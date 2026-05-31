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

        $data['booking'] = $booking;
        $data['title'] = 'Bayar Bukti Pesanan | MOBILKU';

        $this->load->view('layout/header', $data);
        $this->load->view('booking_fee_payment', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Process simulated payment of booking fee
     */
    public function process_booking_fee($booking_id) {
        $method = $this->input->post('method');
        $bank = $this->input->post('bank_name');
        $account = $this->input->post('bank_account');
        $holder = $this->input->post('bank_holder');

        // Simulated file upload or placeholder
        $evidence = 'booking_fee_' . $booking_id . '.png';

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
        $data['title'] = 'Portal Pelanggan | MOBILKU';

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

        $method = $this->input->post('method');
        $bank = $this->input->post('bank_name');
        $account = $this->input->post('bank_account');
        $holder = $this->input->post('bank_holder');

        $this->Booking_model->log_payment(
            $booking_id, 
            $booking['remaining_payment'], 
            'pelunasan', 
            $method, 
            $bank, 
            $account, 
            $holder, 
            $evidence_file
        );

        $this->session->set_flashdata('success', 'Pelunasan berhasil dikirim! Menunggu verifikasi admin untuk serah terima kendaraan.');
        redirect('booking/detail/' . $booking_id);
    }

    /**
     * Configure delivery parameters once Pelunasan and STNK are ready
     */
    public function submit_delivery($booking_id) {
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
}
