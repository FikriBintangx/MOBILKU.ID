<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sourcing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sourcing_model');
        // Ensure user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda harus masuk terlebih dahulu.');
            redirect('auth');
        }
    }

    /**
     * Display Sell Car landing lead form
     */
    public function index() {
        $data['title'] = 'Jual Mobil Anda | MOBILKU Sourcing';
        
        $this->load->view('layout/header', $data);
        $this->load->view('sourcing_form', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Helper to perform file upload
     */
    private function _upload_file($field_name, $required = false) {
        if (!isset($_FILES[$field_name]) || empty($_FILES[$field_name]['name'])) {
            if ($required) {
                return ['error' => 'Berkas ' . $field_name . ' wajib diunggah.'];
            }
            return ['file_name' => null];
        }

        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 10240; // 10MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field_name)) {
            return ['error' => $this->upload->display_errors('', '')];
        } else {
            $data = $this->upload->data();
            return ['file_name' => $data['file_name']];
        }
    }

    /**
     * Submit vehicle offer lead
     */
    public function submit() {
        if ($this->input->post('price_desired')) {
            $_POST['price_desired'] = str_replace('.', '', $this->input->post('price_desired'));
        }
        $role = $this->session->userdata('role');
        if (in_array($role, array('admin', 'staff', 'kurir'))) {
            $this->session->set_flashdata('error', 'Akses Dibatasi: Akun administratif tidak diperbolehkan mengajukan penawaran sourcing mobil.');
            redirect('sourcing');
            return;
        }

        $this->load->library('form_validation');
        $this->load->library('upload');

        $this->form_validation->set_rules('owner_name', 'Nama Pemilik', 'required');
        $this->form_validation->set_rules('owner_phone', 'No Telepon', 'required');
        if ($this->input->post('sourcing_method') === 'jemput') {
            $this->form_validation->set_rules('owner_address', 'Alamat', 'required');
        }
        $this->form_validation->set_rules('car_brand', 'Merk Mobil', 'required');
        $this->form_validation->set_rules('car_model', 'Model Mobil', 'required');
        $this->form_validation->set_rules('car_year', 'Tahun Perakitan', 'required|numeric');
        $this->form_validation->set_rules('car_color', 'Warna Kendaraan', 'required');
        $this->form_validation->set_rules('mileage', 'Kilometer', 'required|numeric');
        $this->form_validation->set_rules('price_desired', 'Harga yang Diinginkan', 'required|numeric');
        $this->form_validation->set_rules('sourcing_method', 'Metode Sourcing', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' '));
            $this->index();
            return;
        }

        // Upload documents
        $stnk = $this->_upload_file('stnk_doc', true);
        if (isset($stnk['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload STNK: ' . $stnk['error']);
            redirect('sourcing');
            return;
        }

        $bpkb = $this->_upload_file('bpkb_doc', false);
        if (isset($bpkb['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload BPKB: ' . $bpkb['error']);
            redirect('sourcing');
            return;
        }

        $p_front = $this->_upload_file('photo_front', true);
        if (isset($p_front['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload Foto Depan: ' . $p_front['error']);
            redirect('sourcing');
            return;
        }

        $p_back = $this->_upload_file('photo_back', true);
        if (isset($p_back['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload Foto Belakang: ' . $p_back['error']);
            redirect('sourcing');
            return;
        }

        $p_interior = $this->_upload_file('photo_interior', true);
        if (isset($p_interior['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload Foto Interior: ' . $p_interior['error']);
            redirect('sourcing');
            return;
        }

        $data = array(
            'user_id' => $this->session->userdata('user_id'),
            'owner_name' => $this->input->post('owner_name'),
            'owner_phone' => $this->input->post('owner_phone'),
            'owner_address' => ($this->input->post('sourcing_method') === 'antar') ? 'Showroom DRIVE.X (Drive-In)' : $this->input->post('owner_address'),
            'car_brand' => $this->input->post('car_brand'),
            'car_model' => $this->input->post('car_model'),
            'car_year' => $this->input->post('car_year'),
            'car_plate' => 'B ' . rand(1000, 9999) . ' TMP',
            'car_color' => $this->input->post('car_color'),
            'mileage' => $this->input->post('mileage'),
            'price_desired' => $this->input->post('price_desired'),
            'description' => $this->input->post('description'),
            'stnk_doc' => $stnk['file_name'],
            'bpkb_doc' => $bpkb['file_name'],
            'photo_front' => $p_front['file_name'],
            'photo_back' => $p_back['file_name'],
            'photo_interior' => $p_interior['file_name'],
            'sourcing_method' => $this->input->post('sourcing_method'),
            'engine_number' => 'ENG-' . rand(10000, 99999),
            'frame_number' => 'FRM-' . rand(10000, 99999)
        );

        $sourcing_id = $this->Sourcing_model->create_sourcing_request($data);

        if ($sourcing_id) {
            $this->session->set_flashdata('success', 'Penawaran mobil Anda berhasil dikirim! Nomor pengajuan Anda adalah: #' . str_pad($sourcing_id, 5, '0', STR_PAD_LEFT) . '. Tim inspeksi kami akan meninjau kelengkapan berkas Anda.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan data.');
        }
        redirect('booking/dashboard'); // Redirect to client dashboard to see tracking
    }

    /**
     * Edit/Resubmit Sourcing Request if revision is required
     */
    public function resubmit($id) {
        if ($this->input->post('price_desired')) {
            $_POST['price_desired'] = str_replace('.', '', $this->input->post('price_desired'));
        }
        $user_id = $this->session->userdata('user_id');
        $sourcing = $this->Sourcing_model->get_sourcing_by_id($id);

        if (!$sourcing || $sourcing['user_id'] != $user_id || $sourcing['status'] !== 'revision_required') {
            $this->session->set_flashdata('error', 'Akses ditolak atau pengajuan tidak membutuhkan revisi.');
            redirect('booking/dashboard');
            return;
        }

        $this->load->library('form_validation');
        $this->load->library('upload');

        $this->form_validation->set_rules('owner_name', 'Nama Pemilik', 'required');
        $this->form_validation->set_rules('owner_phone', 'No Telepon', 'required');
        if ($this->input->post('sourcing_method') === 'jemput') {
            $this->form_validation->set_rules('owner_address', 'Alamat', 'required');
        }
        $this->form_validation->set_rules('car_brand', 'Merk Mobil', 'required');
        $this->form_validation->set_rules('car_model', 'Model Mobil', 'required');
        $this->form_validation->set_rules('car_year', 'Tahun Perakitan', 'required|numeric');
        $this->form_validation->set_rules('car_color', 'Warna Kendaraan', 'required');
        $this->form_validation->set_rules('mileage', 'Kilometer', 'required|numeric');
        $this->form_validation->set_rules('price_desired', 'Harga yang Diinginkan', 'required|numeric');
        $this->form_validation->set_rules('sourcing_method', 'Metode Sourcing', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' '));
            redirect('booking/dashboard');
            return;
        }

        $update_data = array(
            'owner_name' => $this->input->post('owner_name'),
            'owner_phone' => $this->input->post('owner_phone'),
            'owner_address' => ($this->input->post('sourcing_method') === 'antar') ? 'Showroom DRIVE.X (Drive-In)' : $this->input->post('owner_address'),
            'car_brand' => $this->input->post('car_brand'),
            'car_model' => $this->input->post('car_model'),
            'car_year' => $this->input->post('car_year'),
            'car_color' => $this->input->post('car_color'),
            'mileage' => $this->input->post('mileage'),
            'price_desired' => $this->input->post('price_desired'),
            'description' => $this->input->post('description'),
            'sourcing_method' => $this->input->post('sourcing_method'),
            'status' => 'pending', // reset to pending for admin re-review
            'revisions_required' => null // clear revisions required
        );

        // Upload any new documents if provided
        $stnk = $this->_upload_file('stnk_doc', false);
        if (isset($stnk['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload STNK: ' . $stnk['error']);
            redirect('booking/dashboard');
            return;
        } elseif ($stnk['file_name']) {
            $update_data['stnk_doc'] = $stnk['file_name'];
        }

        $bpkb = $this->_upload_file('bpkb_doc', false);
        if (isset($bpkb['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload BPKB: ' . $bpkb['error']);
            redirect('booking/dashboard');
            return;
        } elseif ($bpkb['file_name']) {
            $update_data['bpkb_doc'] = $bpkb['file_name'];
        }

        $p_front = $this->_upload_file('photo_front', false);
        if (isset($p_front['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload Foto Depan: ' . $p_front['error']);
            redirect('booking/dashboard');
            return;
        } elseif ($p_front['file_name']) {
            $update_data['photo_front'] = $p_front['file_name'];
        }

        $p_back = $this->_upload_file('photo_back', false);
        if (isset($p_back['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload Foto Belakang: ' . $p_back['error']);
            redirect('booking/dashboard');
            return;
        } elseif ($p_back['file_name']) {
            $update_data['photo_back'] = $p_back['file_name'];
        }

        $p_interior = $this->_upload_file('photo_interior', false);
        if (isset($p_interior['error'])) {
            $this->session->set_flashdata('error', 'Gagal upload Foto Interior: ' . $p_interior['error']);
            redirect('booking/dashboard');
            return;
        } elseif ($p_interior['file_name']) {
            $update_data['photo_interior'] = $p_interior['file_name'];
        }

        if ($this->Sourcing_model->update_sourcing_request($id, $update_data)) {
            $this->session->set_flashdata('success', 'Pengajuan sourcing #' . str_pad($id, 5, '0', STR_PAD_LEFT) . ' berhasil diperbaiki dan dikirim kembali ke Admin.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pengajuan.');
        }
        redirect('booking/dashboard');
    }

    /**
     * Customer accepts offer price
     */
    public function accept_offer($id) {
        $user_id = $this->session->userdata('user_id');
        $sourcing = $this->Sourcing_model->get_sourcing_by_id($id);

        if (!$sourcing || $sourcing['user_id'] != $user_id || $sourcing['status'] !== 'inspected') {
            $this->session->set_flashdata('error', 'Pengajuan tidak valid atau belum melewati tahap inspeksi.');
            redirect('booking/dashboard');
            return;
        }

        $this->db->where('id', $id);
        $this->db->update('car_sourcing', array('customer_approved' => 1));
        
        $this->session->set_flashdata('success', 'Anda menyetujui penawaran harga sebesar Rp ' . number_format($sourcing['price_offered'], 0, ',', '.') . '. Admin akan segera memproses transaksi pembayaran.');
        redirect('booking/dashboard');
    }

    /**
     * Customer rejects offer price / cancels request
     */
    public function reject_offer($id) {
        $user_id = $this->session->userdata('user_id');
        $sourcing = $this->Sourcing_model->get_sourcing_by_id($id);

        if (!$sourcing || $sourcing['user_id'] != $user_id || !in_array($sourcing['status'], ['pending', 'revision_required', 'inspected'])) {
            $this->session->set_flashdata('error', 'Pengajuan tidak valid untuk dibatalkan.');
            redirect('booking/dashboard');
            return;
        }

        $this->db->where('id', $id);
        $this->db->update('car_sourcing', array('status' => 'cancelled'));
        
        $this->session->set_flashdata('success', 'Pengajuan penjualan mobil Anda berhasil dibatalkan.');
        redirect('booking/dashboard');
    }
}
