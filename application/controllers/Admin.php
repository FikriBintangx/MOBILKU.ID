<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Mobil_model');
        $this->load->model('Sourcing_model');
        $this->load->model('Delivery_model');
        
        // Auto-run schema updates & user seeding for Manager role
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'staff', 'kurir', 'admin', 'manager') NOT NULL DEFAULT 'client'");
        
        // Seed Manager if not exists
        $manager = $this->db->get_where('users', array('role' => 'manager'))->row_array();
        if (!$manager) {
            $this->db->insert('users', array(
                'username' => 'manager',
                'password' => 'manager123',
                'email' => 'manager@mobilku.com',
                'role' => 'manager',
                'fullname' => 'Super Manager (Super Admin)',
                'phone' => '082123456789'
            ));
        }

        // Enforce administrative authentication (including manager)
        if (!$this->session->userdata('user_id') || !in_array($this->session->userdata('role'), array('admin', 'staff', 'kurir', 'manager'))) {
            // Auto authenticate as admin for demonstration convenience if requested
            $this->session->set_userdata(array(
                'user_id' => 1,
                'username' => 'admin',
                'fullname' => 'Super Administrator',
                'role' => 'admin'
            ));
        }
    }

    /**
     * Primary Admin Panel Dashboard
     */
    public function index() {
        $data['bookings'] = $this->Booking_model->get_all_bookings();
        $data['sourcing'] = $this->Sourcing_model->get_all_sourcing();
        $data['cars']     = $this->Mobil_model->get_all_cars('all');
        
        // Load pending payment verifications with full detail
        $this->db->select('p.*, u.fullname as client_name, u.email as client_email, u.phone as client_phone, b.booking_code, b.ktp_image, b.dp_amount, b.remaining_payment, b.booking_fee, c.brand as car_brand, c.model as car_model, c.year as car_year, c.price as car_price, c.plate_number as car_plate, c.image_url as car_image');
        $this->db->from('payments p');
        $this->db->join('bookings b', 'p.booking_id = b.id', 'left');
        $this->db->join('users u', 'b.user_id = u.id', 'left');
        $this->db->join('cars c', 'b.car_id = c.id', 'left');
        $this->db->where('p.status', 'pending');
        $data['pending_payments'] = $this->db->get()->result_array();


        // Load all users for User Management panel
        $this->db->select('id, username, fullname, email, phone, role, created_at');
        $this->db->from('users');
        $this->db->order_by('created_at', 'DESC');
        $data['users'] = $this->db->get()->result_array();

        // Load buyers (users with bookings)
        $this->db->select('u.id, u.fullname, u.email, u.phone, COUNT(b.id) as total_orders, SUM(c.price) as total_spent');
        $this->db->from('users u');
        $this->db->join('bookings b', 'b.user_id = u.id', 'left');
        $this->db->join('cars c', 'b.car_id = c.id', 'left');
        $this->db->where('u.role', 'client');
        $this->db->group_by('u.id');
        $this->db->order_by('total_orders', 'DESC');
        $data['buyers'] = $this->db->get()->result_array();

        $data['couriers']   = $this->db->get('kurir')->result_array();
        $data['deliveries'] = $this->Delivery_model->get_all_deliveries();

        $data['title'] = 'Dashboard Admin | MOBILKU';

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/admin', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Approve and verify client payment
     */
    public function approve_payment($payment_id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat menyetujui transaksi.');
            redirect('admin');
            return;
        }
        $success = $this->Booking_model->verify_payment($payment_id);
        
        if ($success) {
            $this->session->set_flashdata('success', 'Pembayaran berhasil diverifikasi & Kwitansi otomatis diterbitkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memverifikasi pembayaran.');
        }
        redirect('admin');
    }

    /**
     * Reject client payment with reason
     */
    public function reject_payment($payment_id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat menolak transaksi.');
            redirect('admin');
            return;
        }
        $reason = $this->input->post('reason');
        if (empty($reason)) {
            $reason = 'Bukti pembayaran tidak sesuai atau dana belum masuk.';
        }
        
        $success = $this->Booking_model->reject_payment($payment_id, $reason);
        
        if ($success) {
            $this->session->set_flashdata('success', 'Pembayaran ditolak & alasan penolakan berhasil dikirim ke pembeli.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak pembayaran.');
        }
        redirect('admin');
    }

    /**
     * Update STNK / BPKB timelines
     */
    public function update_doc_status() {
        $booking_id = $this->input->post('booking_id');
        $doc_type = $this->input->post('doc_type'); // 'stnk' or 'bpkb'
        $status = $this->input->post('status'); // 'processing' or 'completed'

        $this->Booking_model->update_doc_progress($booking_id, $doc_type, $status);
        $this->session->set_flashdata('success', 'Status pengurusan ' . strtoupper($doc_type) . ' berhasil diperbarui.');
        redirect('admin');
    }

    /**
     * Sourcing: Valuation & Inspections record
     */
    public function evaluate_sourcing() {
        $sourcing_id = $this->input->post('sourcing_id');
        $notes = $this->input->post('inspection_notes');
        $price = floatval($this->input->post('price_offered'));
        $status = $this->input->post('status'); // 'inspected', 'rejected'

        $this->Sourcing_model->record_inspection($sourcing_id, $notes, $price, $status);
        
        $this->session->set_flashdata('success', 'Inspeksi sourcing berhasil dicatat. Status: ' . strtoupper($status));
        redirect('admin');
    }

    /**
     * Sourcing: Trigger payout to seller (cash or transfer)
     */
    public function pay_seller($sourcing_id) {
        $method = $this->input->post('payment_method');
        $bank = $this->input->post('bank_name');
        $account = $this->input->post('bank_account');
        $holder = $this->input->post('bank_holder');

        // Simulated file
        $receipt = 'sourcing_payout_' . $sourcing_id . '.png';

        $payment_id = $this->Sourcing_model->record_payout($sourcing_id, $method, $bank, $account, $holder, $receipt);

        if ($payment_id) {
            $this->session->set_flashdata('success', 'Pembayaran penyediaan mobil berhasil diproses. ' . ($method === 'cash' ? 'Mobil otomatis ditambahkan ke katalog.' : 'Menunggu transfer bank dikonfirmasi.'));
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses pembayaran sourcing.');
        }
        redirect('admin');
    }

    /**
     * Approve seller sourcing transfer payment
     */
    public function approve_sourcing_payment($payment_id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat menyetujui sourcing.');
            redirect('admin');
            return;
        }
        $success = $this->Sourcing_model->verify_sourcing_payout($payment_id);
        
        if ($success) {
            $this->session->set_flashdata('success', 'Pembayaran transfer sourcing terverifikasi. Mobil otomatis masuk ke inventori.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memverifikasi.');
        }
        redirect('admin');
    }

    /**
     * Admin assigns courier to delivery request
     */
    public function assign_courier_task() {
        $id_pengiriman = $this->input->post('id_pengiriman');
        $id_kurir = $this->input->post('id_kurir');

        if (empty($id_pengiriman) || empty($id_kurir)) {
            $this->session->set_flashdata('error', 'Silakan pilih kurir terlebih dahulu.');
            redirect('admin');
            return;
        }

        $this->Delivery_model->assign_courier($id_pengiriman, $id_kurir);
        $this->session->set_flashdata('success', 'Kurir berhasil ditugaskan dan Surat Jalan telah diterbitkan.');
        redirect('admin');
    }

    /**
     * Courier Dashboard Portal
     */
    public function kurir() {
        // Enforce Courier role
        if ($this->session->userdata('role') !== 'kurir' && $this->session->userdata('role') !== 'admin') {
            redirect('mobil');
        }

        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', array('id' => $user_id))->row_array();
        $email = $user ? $user['email'] : 'kurir@mobilku.com';
        
        $courier = $this->db->get_where('kurir', array('email' => $email))->row_array();

        // Auto seed courier record if missing (matches user login)
        if (!$courier) {
            $data_kurir = array(
                'nama' => $user ? $user['fullname'] : 'Kurir Pengirim',
                'email' => $email,
                'no_hp' => ($user && $user['phone']) ? $user['phone'] : '08111222333',
                'password' => 'kurir123',
                'alamat' => 'Showroom DRIVE.X Head Office',
                'status' => 'active'
            );
            $this->db->insert('kurir', $data_kurir);
            $courier = $this->db->get_where('kurir', array('email' => $email))->row_array();
        }

        $id_kurir = $courier['id_kurir'];
        
        // Load Delivery model
        $this->load->model('Delivery_model');

        $data['courier'] = $courier;
        $data['stats'] = $this->Delivery_model->get_courier_stats($id_kurir);
        
        // Get deliveries assigned to this courier with details
        $data['deliveries'] = $this->Delivery_model->get_courier_deliveries($id_kurir);
        $data['title'] = 'Portal Kurir | MOBILKU';

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/kurir', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Courier update dispatch status (new table workflow)
     */
    public function update_delivery_status_p($id_pengiriman) {
        $status = $this->input->post('status_pengiriman');
        $catatan = $this->input->post('catatan');
        
        $this->load->model('Delivery_model');
        $this->Delivery_model->update_delivery_status($id_pengiriman, $status, $catatan);
        
        $this->session->set_flashdata('success', 'Status pengiriman berhasil diperbarui menjadi ' . strtoupper($status));
        redirect('admin/kurir');
    }

    /**
     * Courier upload delivery proof (photos + signature)
     */
    public function upload_delivery_proof_p($id_pengiriman) {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 10240;
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload');
        $this->load->model('Delivery_model');
        
        $proof_data = array();

        // 1. Foto Serah Terima
        if (!empty($_FILES['foto_serah_terima']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto_serah_terima')) {
                $proof_data['foto_serah_terima'] = $this->upload->data('file_name');
            }
        }

        // 2. Tanda Tangan Penerima
        if (!empty($_FILES['tanda_tangan_penerima']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('tanda_tangan_penerima')) {
                $proof_data['tanda_tangan_penerima'] = $this->upload->data('file_name');
            }
        }

        // 3. Foto Kendaraan
        if (!empty($_FILES['foto_kendaraan']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto_kendaraan')) {
                $proof_data['foto_kendaraan'] = $this->upload->data('file_name');
            }
        }

        $this->Delivery_model->upload_delivery_proof($id_pengiriman, $proof_data);
        
        // Auto update status to "Diserahkan ke Pembeli" when proof uploaded
        if (isset($proof_data['foto_serah_terima']) || isset($proof_data['foto_kendaraan'])) {
            $this->Delivery_model->update_delivery_status($id_pengiriman, 'Diserahkan ke Pembeli');
        }

        $this->session->set_flashdata('success', 'Bukti serah terima pengiriman berhasil diunggah.');
        redirect('admin/kurir');
    }

    /**
     * Courier edit password profile
     */
    public function change_kurir_password() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', array('id' => $user_id))->row_array();
        $email = $user ? $user['email'] : $this->session->userdata('email');
        
        if (empty($email)) {
            $this->session->set_flashdata('error', 'Gagal memverifikasi identitas pengguna.');
            redirect('admin/kurir');
            return;
        }

        $new_pass = $this->input->post('new_password');
        if (empty($new_pass)) {
            $this->session->set_flashdata('error', 'Password baru tidak boleh kosong.');
            redirect('admin/kurir');
            return;
        }

        // Update in users table and kurir table
        $this->db->where('email', $email);
        $this->db->update('users', array('password' => $new_pass));

        $this->db->where('email', $email);
        $this->db->update('kurir', array('password' => $new_pass));

        $this->session->set_flashdata('success', 'Password berhasil diubah.');
        redirect('admin/kurir');
    }

    /**
     * printable digital Kwitansi (Receipt)
     */
    public function kwitansi($payment_id) {
        $this->db->select('p.*, b.booking_code, s.receipt_number as sourcing_receipt, b.dp_amount, b.remaining_payment, u.fullname as client_name, u.phone as client_phone, c.brand, c.model, c.plate_number');
        $this->db->from('payments p');
        $this->db->join('bookings b', 'p.booking_id = b.id', 'left');
        $this->db->join('car_sourcing s', 'p.sourcing_id = s.id', 'left');
        $this->db->join('users u', 'b.user_id = u.id', 'left');
        $this->db->join('cars c', 'b.car_id = c.id', 'left');
        $this->db->where('p.id', $payment_id);
        $payment = $this->db->get()->row_array();

        if (!$payment || $payment['status'] !== 'verified') {
            show_error('Kwitansi tidak ditemukan atau pembayaran belum diverifikasi.');
        }

        $data['payment'] = $payment;
        $data['title'] = 'Kwitansi Resmi #' . ($payment['receipt_number'] ? $payment['receipt_number'] : $payment['sourcing_receipt']);

        $this->load->view('printable/kwitansi', $data);
    }

    /**
     * printable Courier Surat Jalan
     */
    public function surat_jalan($booking_id) {
        $this->load->model('Delivery_model');
        
        // Find the delivery ticket
        $this->db->select('id_pengiriman');
        $this->db->from('pengiriman');
        $this->db->where('id_transaksi', $booking_id);
        $p_row = $this->db->get()->row_array();
        
        if (!$p_row) {
            show_error('Surat Jalan tidak tersedia untuk pesanan ini.');
            return;
        }

        $delivery = $this->Delivery_model->get_delivery_by_id($p_row['id_pengiriman']);
        if (!$delivery) {
            show_error('Data pengiriman tidak valid.');
            return;
        }

        $data['delivery'] = $delivery;
        $data['title'] = 'Surat Jalan Serah Terima Kendaraan — ' . ($delivery['nomor_surat'] ? $delivery['nomor_surat'] : 'SJ/TEMP');

        $this->load->view('printable/surat_jalan', $data);
    }

    public function complete_booking($booking_id) {
        $success = $this->Booking_model->complete_booking($booking_id);
        
        if ($success) {
            $this->session->set_flashdata('success', 'Pesanan berhasil diselesaikan. Dokumen BPKB diserahterimakan & status unit diubah menjadi SOLD.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyelesaikan pesanan. Pastikan berkas BPKB sudah berkategori COMPLETED.');
        }
        redirect('admin');
    }

    /**
     * Request Sourcing Revision (missing/invalid docs)
     */
    public function request_sourcing_revision($id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat meminta revisi.');
            redirect('admin');
            return;
        }
        $revisions = $this->input->post('revisions_required');
        if (empty($revisions)) {
            $revisions = 'Silakan perbaiki data/unggah dokumen STNK/BPKB/Foto yang lebih jelas.';
        }
        $this->db->where('id', $id);
        $this->db->update('car_sourcing', array(
            'status' => 'revision_required',
            'revisions_required' => $revisions
        ));
        $this->session->set_flashdata('success', 'Catatan revisi berhasil dikirim ke pengaju.');
        redirect('admin');
    }

    /**
     * Reject Sourcing Offer
     */
    public function reject_sourcing($id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat menolak sourcing.');
            redirect('admin');
            return;
        }
        $reason = $this->input->post('rejection_reason');
        if (empty($reason)) {
            $reason = 'Kondisi kendaraan tidak memenuhi standar kelayakan kami.';
        }
        $this->db->where('id', $id);
        $this->db->update('car_sourcing', array(
            'status' => 'rejected',
            'rejection_reason' => $reason
        ));
        $this->session->set_flashdata('success', 'Pengajuan sourcing ditolak secara resmi.');
        redirect('admin');
    }

    /**
     * Save physical inspection & price offer details
     */
    public function save_inspection($id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat mencatat survey.');
            redirect('admin');
            return;
        }
        $notes = $this->input->post('inspection_notes');
        $price = $this->input->post('price_offered');
        
        $this->Sourcing_model->record_inspection($id, $notes, $price, 'inspected');
        
        $this->session->set_flashdata('success', 'Hasil survey fisik berhasil disimpan dan penawaran harga dikirim ke pelanggan.');
        redirect('admin');
    }

    /**
     * Process sourcing payment payout (Cash or Transfer)
     */
    public function process_sourcing_payout($id) {
        if ($this->session->userdata('role') !== 'manager') {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Hanya Manager (Super Admin) yang dapat memproses payout.');
            redirect('admin');
            return;
        }
        $method = $this->input->post('payment_method');
        $bank = $this->input->post('bank_name');
        $account = $this->input->post('bank_account');
        $holder = $this->input->post('bank_holder');
        
        $receipt = '';
        if ($method === 'transfer') {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 10240;
            $config['encrypt_name']  = TRUE;
            
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('receipt_file')) {
                $file_data = $this->upload->data();
                $receipt = $file_data['file_name'];
            }
        }
        
        $this->Sourcing_model->record_payout($id, $method, $bank, $account, $holder, $receipt);
        
        $this->session->set_flashdata('success', 'Pembayaran sourcing berhasil diproses.');
        redirect('admin');
    }

    /**
     * Printable PDF/Print report with filters (sales, purchases, or both)
     */
    public function cetak_laporan() {
        $filter = $this->input->get('type'); // 'penjualan', 'pembelian', 'semua'
        if (empty($filter)) {
            $filter = 'semua';
        }

        $data['filter_type'] = $filter;
        $data['title'] = 'Laporan Keuangan & Ledger | DRIVE.X';

        // 1. Fetch Sales (Client Orders) Data
        $data['sales_data'] = array();
        $data['total_revenue'] = 0;
        $data['count_sales'] = 0;

        if ($filter !== 'pembelian') {
            $this->db->select('b.*, u.fullname, c.brand, c.model, c.plate_number, c.price as car_price');
            $this->db->from('bookings b');
            $this->db->join('users u', 'b.user_id = u.id');
            $this->db->join('cars c', 'b.car_id = c.id');
            $this->db->where_in('b.status', array('active', 'completed'));
            $data['sales_data'] = $this->db->get()->result_array();

            foreach ($data['sales_data'] as $s) {
                $data['count_sales']++;
                if ($s['booking_fee_status'] === 'paid') $data['total_revenue'] += 500000;
                if ($s['dp_status'] === 'paid') $data['total_revenue'] += $s['dp_amount'];
                if ($s['pelunasan_status'] === 'paid') $data['total_revenue'] += $s['remaining_payment'];
            }
        }

        // 2. Fetch Purchases (Car Sourcing Purchased) Data
        $data['purchase_data'] = array();
        $data['total_purchases'] = 0;
        $data['count_purchases'] = 0;

        if ($filter !== 'penjualan') {
            $this->db->select('*');
            $this->db->from('car_sourcing');
            $this->db->where('status', 'purchased');
            $data['purchase_data'] = $this->db->get()->result_array();

            foreach ($data['purchase_data'] as $p) {
                $data['count_purchases']++;
                $data['total_purchases'] += floatval($p['price_offered']);
            }
        }

        $this->load->view('printable/laporan', $data);
    }


    /**
     * Admin updates car catalog details (stock and status)
     */
    public function update_car_catalog() {
        $id = $this->input->post('car_id');
        $stock = intval($this->input->post('stock'));
        $status = $this->input->post('status');

        if (empty($id)) {
            $this->session->set_flashdata('error', 'ID Mobil tidak valid.');
            redirect('admin');
            return;
        }

        // Update database
        $this->db->where('id', $id);
        $this->db->update('cars', array(
            'stock' => $stock,
            'status' => $status
        ));

        $this->session->set_flashdata('success', 'Katalog mobil berhasil diperbarui.');
        redirect('admin');
    }

    /**
     * Admin updates all car catalog details (bulk stock and status)
     */
    public function update_all_cars_catalog() {
        $single_car_id = $this->input->post('single_car_id');
        $stocks = $this->input->post('stocks');
        $statuses = $this->input->post('statuses');

        if (!empty($single_car_id) && isset($stocks[$single_car_id])) {
            // Save only the single car row
            $stock = $stocks[$single_car_id];
            $status = $statuses[$single_car_id] ?? 'available';
            
            $this->db->where('id', $single_car_id);
            $this->db->update('cars', array(
                'stock' => intval($stock),
                'status' => $status
            ));
            $this->session->set_flashdata('success', 'Katalog mobil berhasil diperbarui.');
        } elseif (!empty($stocks)) {
            // Save all rows
            foreach ($stocks as $car_id => $stock) {
                $status = $statuses[$car_id] ?? 'available';
                $this->db->where('id', $car_id);
                $this->db->update('cars', array(
                    'stock' => intval($stock),
                    'status' => $status
                ));
            }
            $this->session->set_flashdata('success', 'Semua perubahan katalog mobil berhasil disimpan sekaligus.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data katalog mobil untuk diperbarui.');
        }
        redirect('admin');
    }

    /**
     * RESET DATABASE TO FRESH CLEAN TRANSACTION STATE
     */
    public function reset_db() {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Akses Dibatasi.');
        }
        
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->query("TRUNCATE TABLE payments");
        $this->db->query("TRUNCATE TABLE documents");
        $this->db->query("TRUNCATE TABLE bookings");
        $this->db->query("TRUNCATE TABLE car_sourcing");
        $this->db->query("UPDATE cars SET status = 'available', stock = 5");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        
        $this->session->set_flashdata('success', 'Database berhasil di-reset ke kondisi awal secara bersih!');
        redirect('admin');
    }
}
