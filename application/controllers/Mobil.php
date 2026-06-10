<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mobil_model');
        $this->load->model('Booking_model');
        // Standard session initialization helper check
        if (!$this->session->userdata('role')) {
            // Default to guest simulation or let them pick role
        }
    }

    /**
     * Home / Catalog Landing Page
     */
    public function index() {
        $this->db->select('*');
        $this->db->from('cars');
        $this->db->where_in('status', array('available', 'booked'));
        $this->db->order_by('created_at', 'DESC');
        $data['cars'] = $this->db->get()->result_array();
        $data['brands'] = $this->Mobil_model->get_unique_brands();
        $data['types'] = $this->Mobil_model->get_unique_types();
        $data['title'] = 'DRIVE.X - Premium Second-Hand Car Platform';
        
        $this->load->view('layout/header', $data);
        $this->load->view('home', $data);
        $this->load->view('layout/footer');
    }

    /**
     * AJAX Search / Filter endpoint for Anime.js animation grids
     */
    public function filter() {
        $brand     = $this->input->get('brand');
        $type      = $this->input->get('type');
        $min_price = floatval($this->input->get('min_price'));
        $max_price = floatval($this->input->get('max_price'));
        $search    = $this->input->get('search');

        $cars = $this->Mobil_model->filter_cars($brand, $type, $min_price, $max_price, $search);

        // Output clean JSON for front-end rendering
        header('Content-Type: application/json');
        echo json_encode($cars);
        exit;
    }

    /**
     * Car Details View & Simulated Booking Option
     */
    public function detail($id) {
        $car = $this->Mobil_model->get_car_by_id($id);
        if (!$car) {
            show_404();
        }

        $data['car'] = $car;
        $data['title'] = $car['brand'] . ' ' . $car['model'] . ' | DRIVE.X';
        
        $this->load->view('layout/header', $data);
        $this->load->view('detail', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Instant Multi-Actor Authentication Simulator
     * Built specifically for semester projects to let users/professors bypass login easily
     */
    public function login_sim() {
        $role = $this->input->post('role');
        $user_id = 4; // Bachira or Isagi defaults
        if ($role === 'admin') $user_id = 1;
        if ($role === 'staff') $user_id = 2;
        if ($role === 'kurir') $user_id = 3;

        $this->db->select('*');
        $this->db->from('users');
        if ($role === 'manager') {
            $this->db->where('role', 'manager');
        } else {
            $this->db->where('id', $user_id);
        }
        $user = $this->db->get()->row_array();

        if ($user) {
            $this->session->set_userdata(array(
                'user_id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'role' => $user['role']
            ));
            
            // Redirect based on role
            if ($user['role'] === 'admin' || $user['role'] === 'staff' || $user['role'] === 'manager') {
                redirect('admin');
            } elseif ($user['role'] === 'kurir') {
                redirect('admin/kurir');
            } else {
                redirect('booking/dashboard');
            }
        } else {
            redirect('mobil');
        }
    }

    /**
     * Destroy Session
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('mobil');
    }
}

/**
 * Utility helper to output clean JSON response
 */
if (!function_exists('this_output_json')) {
    function this_output_json($data) {
        $ci =& get_instance();
        $ci->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
