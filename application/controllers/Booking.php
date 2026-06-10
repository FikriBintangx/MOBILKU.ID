<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Mobil_model');
        
        // Enforce user session authentication for transactions
        if (!$this->session->userdata('user_id')) {
            $this->session->set_userdata('redirect_url', current_url());
            $this->session->set_flashdata('error', 'Silakan masuk atau daftar akun terlebih dahulu untuk melakukan pemesanan.');
            redirect('auth/login');
        }

        // Restrict administrative roles from client transactions
        $role = $this->session->userdata('role');
        $current_method = $this->router->fetch_method();
        if (in_array($role, array('admin', 'staff', 'kurir'))) {
            if (in_array($current_method, array('checkout', 'dashboard', 'detail', 'submit_dp_ktp', 'submit_final_payment', 'submit_delivery'))) {
                $this->session->set_flashdata('error', 'Akses Dibatasi: Peran administratif (Admin/Staff/Kurir) tidak diperbolehkan melakukan transaksi pembelian.');
                if ($role === 'kurir') {
                    redirect('admin/kurir');
                } else {
                    redirect('admin');
                }
            }
        }
    }

    public function checkout($car_id) {
        $user_id = $this->session->userdata('user_id');

        // Check if the user already has an active booking for this specific car
        $this->db->select('*');
        $this->db->from('bookings');
        $this->db->where(array(
            'user_id' => $user_id,
            'car_id' => $car_id
        ));
        $this->db->where_in('status', array('ordered', 'active'));
        $existing = $this->db->get()->row_array();

        if ($existing) {
            $this->session->set_flashdata('error', 'Anda sudah memiliki pesanan aktif untuk unit mobil ini! Silakan lanjutkan proses pembayaran Anda.');
            redirect('booking/detail/' . $existing['id']);
        }

        $booking_id = $this->Booking_model->create_booking($user_id, $car_id);

        if ($booking_id) {
            redirect('booking/pay_booking_fee_sim/' . $booking_id);
        } else {
            $this->session->set_flashdata('error', 'Mobil tidak tersedia atau sedang dipesan orang lain.');
            redirect('mobil');
        }
    }

    /**
     * Simulated Booking Fee screen (Rp 500,000)
     */
    public function pay_booking_fee_sim($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        if (!$booking) show_404();
        if ($booking['status'] === 'cancelled') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Transaksi ini telah dibatalkan/dikunci.');
            redirect('booking/detail/' . $booking_id);
            return;
        }

        $data['booking'] = $booking;
        $data['title'] = 'Bayar Bukti Pesanan | DRIVE.X';

        $this->load->view('layout/header', $data);
        $this->load->view('booking_fee_payment', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Process simulated payment of booking fee
     */
    public function process_booking_fee($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        if (!$booking || $booking['status'] === 'cancelled') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Transaksi ini telah dibatalkan/dikunci.');
            redirect('booking/dashboard');
            return;
        }

        $method = $this->input->post('method');
        
        if ($method === 'cash') {
            $bank = 'CASH / COD';
            $account = '-';
            $holder = 'Bayar di Tempat';
            $evidence = 'cash_payment_placeholder.png';
        } else {
            $bank = $this->input->post('bank_name');
            $account = $this->input->post('bank_account');
            $holder = $this->input->post('bank_holder');
            $evidence = 'booking_fee_' . $booking_id . '.png';
        }

        // Log payment ticket
        $payment_id = $this->Booking_model->log_payment(
            $booking_id, 
            500000.00, 
            'booking_fee', 
            $method, 
            $bank, 
            $account, 
            $holder, 
            $evidence
        );

        // Remove auto-verify to let Admin verify the payment manually from the panel!
        // $this->Booking_model->verify_payment($payment_id);

        $this->session->set_flashdata('success', 'Bukti Pesanan berhasil diunggah! Silakan tunggu beberapa saat sementara Admin memverifikasi pembayaran Anda.');
        redirect('booking/dashboard');
    }

    /**
     * Client Transaction Timeline Dashboard
     */
    public function dashboard() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Sourcing_model');
        $data['bookings'] = $this->Booking_model->get_user_bookings($user_id);
        $data['sourcing'] = $this->Sourcing_model->get_sourcing_by_user($user_id);
        $data['title'] = 'Portal Pelanggan | DRIVE.X';

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/client', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Detailed Order Timeline Tracker
     */
    public function detail($id) {
        $booking = $this->Booking_model->get_booking_by_id($id);
        if (!$booking || $booking['user_id'] != $this->session->userdata('user_id')) {
            show_404();
        }

        // Auto-run scheduler update to check if this transaction has expired
        $this->Booking_model->auto_cancel_overdue_bookings();

        // Refresh data post potential cancellation check
        $data['booking'] = $this->Booking_model->get_booking_by_id($id);
        $data['payments'] = $this->db->get_where('payments', array('booking_id' => $id))->result_array();
        $data['documents'] = $this->db->get_where('documents', array('booking_id' => $id))->result_array();
        
        // Fetch courier delivery proof details
        $this->load->model('Delivery_model');
        $this->db->select('id_pengiriman');
        $this->db->from('pengiriman');
        $this->db->where('id_transaksi', $id);
        $p_row = $this->db->get()->row_array();
        
        $data['delivery'] = null;
        if ($p_row) {
            $data['delivery'] = $this->Delivery_model->get_delivery_by_id($p_row['id_pengiriman']);
        }
        
        $data['title'] = 'Lacak Pesanan #' . $booking['booking_code'];

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/client_detail', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Upload DP (30%) & Scan copy of KTP
     */
    public function submit_dp_ktp($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        if (!$booking) show_404();
        if ($booking['status'] === 'cancelled') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Transaksi ini telah dibatalkan/dikunci.');
            redirect('booking/detail/' . $booking_id);
            return;
        }

        // Configure upload settings
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']      = 2048; // 2MB max
        
        // Ensure upload directory exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        $ktp_file = 'ktp_placeholder.png';
        $evidence_file = 'dp_receipt_placeholder.png';

        // Process KTP file upload
        if ($this->upload->do_upload('ktp_file')) {
            $ktp_data = $this->upload->data();
            $ktp_file = $ktp_data['file_name'];
        }

        // Process DP receipt file upload
        if ($this->upload->do_upload('evidence_file')) {
            $ev_data = $this->upload->data();
            $evidence_file = $ev_data['file_name'];
        }

        $method = $this->input->post('method');
        $bank = $this->input->post('bank_name');
        $account = $this->input->post('bank_account');
        $holder = $this->input->post('bank_holder');

        // Log payment ticket & upload KTP path
        $this->Booking_model->upload_dp_ktp($booking_id, $ktp_file, $evidence_file, $method, $bank, $account, $holder);

        $this->session->set_flashdata('success', 'Uang Muka & Fotocopy KTP berhasil dikirim! Silakan tunggu verifikasi admin untuk pengurusan STNK & BPKB.');
        redirect('booking/detail/' . $booking_id);
    }

    /**
     * Upload Final Payment (Remaining 70%)
     */
    public function submit_final_payment($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        if (!$booking) show_404();
        if ($booking['status'] === 'cancelled') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Transaksi ini telah dibatalkan/dikunci.');
            redirect('booking/detail/' . $booking_id);
            return;
        }

        // 1. Simpan tipe serah terima (Ambil / Kirim)
        $delivery_type = $this->input->post('delivery_type');
        $delivery_address = $this->input->post('delivery_address');
        $this->Booking_model->set_fulfillment($booking_id, $delivery_type, $delivery_address);

        // Jika kirim ke alamat, otomatis buat tiket pengiriman kurir
        if ($delivery_type === 'delivery') {
            $this->load->model('Delivery_model');
            $this->Delivery_model->create_delivery($booking_id, $delivery_address);
        }

        // 2. Proses metode pembayaran pelunasan (Transfer / Bayar di Tempat)
        $method = $this->input->post('method');

        if ($method === 'cash') {
            $evidence_file = 'cash_payment_placeholder.png';
            $bank = 'CASH / COD';
            $account = 'TEMPAT';
            $holder = ($delivery_type === 'delivery') ? 'Bayar di Rumah (COD)' : 'Bayar Cash di Showroom';

            $this->Booking_model->log_payment(
                $booking_id, 
                $booking['remaining_payment'], 
                'pelunasan', 
                'cash', 
                $bank, 
                $account, 
                $holder, 
                $evidence_file
            );

            $this->session->set_flashdata('success', 'Konfirmasi serah terima & opsi Bayar di Tempat berhasil disimpan! Silakan tunggu mobil dipersiapkan.');
        } else {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
            $config['max_size']      = 2048;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);
            $evidence_file = 'pelunasan_receipt_placeholder.png';

            if ($this->upload->do_upload('evidence_file')) {
                $ev_data = $this->upload->data();
                $evidence_file = $ev_data['file_name'];
            }

            $bank = $this->input->post('bank_name');
            $account = $this->input->post('bank_account');
            $holder = $this->input->post('bank_holder');

            $this->Booking_model->log_payment(
                $booking_id, 
                $booking['remaining_payment'], 
                'pelunasan', 
                'transfer', 
                $bank, 
                $account, 
                $holder, 
                $evidence_file
            );

            $this->session->set_flashdata('success', 'Konfirmasi serah terima & bukti transfer pelunasan berhasil dikirim! Menunggu verifikasi admin.');
        }

        redirect('booking/detail/' . $booking_id);
    }

    /**
     * Configure delivery parameters once Pelunasan and STNK are ready
     */
    public function submit_delivery($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        if (!$booking || $booking['status'] === 'cancelled') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Transaksi ini telah dibatalkan/dikunci.');
            redirect('booking/detail/' . $booking_id);
            return;
        }

        $type = $this->input->post('delivery_type');
        $address = $this->input->post('delivery_address');

        $success = $this->Booking_model->set_fulfillment($booking_id, $type, $address);

        if ($success) {
            if ($type === 'delivery') {
                $this->load->model('Delivery_model');
                $this->Delivery_model->create_delivery($booking_id, $address);
            }
            $this->session->set_flashdata('success', 'Metode serah terima berhasil dipilih. ' . ($type === 'delivery' ? 'Kurir kami akan segera mengirim mobil dengan Surat Jalan.' : 'Silakan datang ke showroom untuk mengambil unit mobil Anda.'));
        } else {
            $this->session->set_flashdata('error', 'Gagal mengatur serah terima. Pastikan STNK selesai dan mobil sudah dilunasi.');
        }

        redirect('booking/detail/' . $booking_id);
    }

    /**
     * Request booking cancellation
     */
    public function cancel($booking_id) {
        $result = $this->Booking_model->cancel_booking($booking_id);
        if ($result) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', 'Gagal membatalkan pesanan.');
        }
        redirect('booking/detail/' . $booking_id);
    }

    /**
     * Delete multiple bookings (user-initiated, only cancelled/completed allowed)
     */
    public function delete_bookings() {
        if ($this->input->method() !== 'post') {
            redirect('booking/dashboard');
        }

        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('auth/login');
        }

        $booking_ids = $this->input->post('booking_ids');

        if (empty($booking_ids) || !is_array($booking_ids)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu transaksi untuk dihapus.');
            redirect('booking/dashboard');
        }

        $deleted = $this->Booking_model->delete_bookings($booking_ids, $user_id);

        if ($deleted > 0) {
            $this->session->set_flashdata('success', $deleted . ' transaksi berhasil dihapus dari riwayat Anda.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada transaksi yang bisa dihapus. Hanya transaksi berstatus CANCELLED atau COMPLETED yang dapat dihapus.');
        }

        redirect('booking/dashboard');
    }

    /**
     * Print-ready Invoice / Nota Resmi for completed bookings (client view)
     */
    public function invoice($booking_id) {
        $user_id = $this->session->userdata('user_id');

        // Get full booking with car + user details
        $this->db->select('b.*, u.fullname, u.email, u.phone, c.brand, c.model, c.type, c.year, c.color, c.plate_number, c.engine_number, c.frame_number, c.price as car_price, c.image_url');
        $this->db->from('bookings b');
        $this->db->join('users u', 'b.user_id = u.id');
        $this->db->join('cars c', 'b.car_id = c.id');
        $this->db->where('b.id', $booking_id);
        $this->db->where('b.user_id', $user_id); // Security: only owner
        $booking = $this->db->get()->row_array();

        if (!$booking) {
            show_error('Invoice tidak ditemukan atau Anda tidak memiliki akses.');
            return;
        }

        if ($booking['status'] !== 'completed') {
            $this->session->set_flashdata('error', 'Invoice hanya tersedia untuk transaksi yang telah selesai.');
            redirect('booking/detail/' . $booking_id);
        }

        // Get all verified payments for this booking
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where('booking_id', $booking_id);
        $this->db->where('status', 'verified');
        $this->db->order_by('created_at', 'ASC');
        $payments = $this->db->get()->result_array();

        $data['booking']  = $booking;
        $data['payments'] = $payments;
        $data['title']    = 'Invoice Resmi — ' . $booking['booking_code'];

        $this->load->view('printable/invoice', $data);
    }

    /**
     * Halaman Real-Time Tracking Pengiriman untuk Customer
     */
    public function tracking($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        if (!$booking || ($booking['user_id'] != $user_id && !in_array($user_role, ['admin', 'manager']))) {
            show_404();
        }

        $this->load->model('Delivery_model');
        
        // Find the delivery ticket
        $this->db->select('id_pengiriman');
        $this->db->from('pengiriman');
        $this->db->where('id_transaksi', $booking_id);
        $p_row = $this->db->get()->row_array();
        
        if (!$p_row) {
            $this->session->set_flashdata('error', 'Fitur tracking hanya tersedia jika Anda memilih opsi Dikirim ke Alamat.');
            redirect('booking/detail/' . $booking_id);
            return;
        }

        $delivery = $this->Delivery_model->get_delivery_by_id($p_row['id_pengiriman']);
        if (!$delivery) {
            show_error('Data pengiriman tidak valid.');
            return;
        }

        $data['booking'] = $booking;
        $data['delivery'] = $delivery;
        $data['status_history'] = $this->Delivery_model->get_status_history($p_row['id_pengiriman']);
        $data['title'] = 'Lacak Pengiriman Real-Time #' . $booking['booking_code'];

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/tracking_customer', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Customer confirms delivery has arrived and rates the service
     */
    public function confirm_delivery_arrival($booking_id) {
        $booking = $this->Booking_model->get_booking_by_id($booking_id);
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if (!$booking || ($booking['user_id'] != $user_id && !in_array($user_role, ['admin', 'manager']))) {
            show_404();
        }

        $this->load->model('Delivery_model');
        
        // Find the delivery ticket
        $this->db->select('id_pengiriman');
        $this->db->from('pengiriman');
        $this->db->where('id_transaksi', $booking_id);
        $p_row = $this->db->get()->row_array();
        
        if ($p_row) {
            $id_pengiriman = $p_row['id_pengiriman'];
            
            // 1. Update delivery status to "Selesai"
            $this->Delivery_model->update_delivery_status($id_pengiriman, 'Selesai', 'Penerima menyatakan kendaraan telah sampai di lokasi.');

            // 2. Insert ratings
            $rating_showroom = (int) $this->input->post('rating_showroom');
            $rating_kurir = (int) $this->input->post('rating_kurir');
            $review_text = $this->input->post('review_text');

            $rating_data = array(
                'booking_id' => $booking_id,
                'id_pengiriman' => $id_pengiriman,
                'rating_showroom' => $rating_showroom > 0 ? $rating_showroom : 5,
                'rating_kurir' => $rating_kurir > 0 ? $rating_kurir : 5,
                'review_text' => htmlspecialchars($review_text)
            );
            $this->db->insert('ratings', $rating_data);

            $this->session->set_flashdata('success', 'Konfirmasi serah terima berhasil! Terima kasih telah memberikan penilaian terhadap layanan kami.');
        }

        redirect('booking/tracking/' . $booking_id);
    }

    /**
     * API: Ambil koordinat tracking pengiriman spesifik (GET) untuk Customer
     * Menghindari overwrite session dari controller Admin
     */
    public function get_tracking_data_api($id_pengiriman) {
        $this->load->model('Delivery_model');
        $delivery = $this->Delivery_model->get_delivery_by_id($id_pengiriman);
        if (!$delivery) {
            echo json_encode(array('status' => 'error', 'message' => 'Delivery not found.'));
            return;
        }

        // Authorization check: Make sure client owns the booking or is administrative role
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        $booking = $this->Booking_model->get_booking_by_id($delivery['id_transaksi']);
        
        if (!$booking || ($booking['user_id'] != $user_id && !in_array($user_role, array('admin', 'staff', 'kurir', 'manager')))) {
            echo json_encode(array('status' => 'error', 'message' => 'Unauthorized access.'));
            return;
        }

        $latest_tracking = $this->Delivery_model->get_latest_tracking($id_pengiriman);
        $history = $this->Delivery_model->get_tracking_history($id_pengiriman);
        $status_history = $this->Delivery_model->get_status_history($id_pengiriman);

        echo json_encode(array(
            'status' => 'success',
            'delivery' => $delivery,
            'latest' => $latest_tracking,
            'history' => $history,
            'status_history' => $status_history
        ));
    }
}

