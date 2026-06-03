<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database explicitly if needed, but it is typically autoloaded
    }

    /**
     * Handle User Login
     */
    public function login() {
        if ($this->session->userdata('user_id')) {
            $this->redirect_by_role($this->session->userdata('role'));
        }

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('username', $username);
            $this->db->where('password', $password); // Plain text check as per database standard
            $user = $this->db->get()->row_array();

            if ($user) {
                $this->session->set_userdata(array(
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'fullname' => $user['fullname'],
                    'role' => $user['role']
                ));
                $this->session->set_flashdata('success', 'Welcome back, ' . $user['fullname'] . '!');
                $this->redirect_by_role($user['role']);
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah.');
                redirect('auth/login');
            }
        } else {
            $data['title'] = 'Sign In | DRIVE.X';
            $this->load->view('layout/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('layout/footer');
        }
    }

    /**
     * Handle User Registration
     */
    public function register() {
        if ($this->session->userdata('user_id')) {
            $this->redirect_by_role($this->session->userdata('role'));
        }

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $fullname = $this->input->post('fullname');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');

            // Check if username already exists
            $this->db->where('username', $username);
            $check_user = $this->db->get('users')->row_array();

            // Check if email already exists
            $this->db->where('email', $email);
            $check_email = $this->db->get('users')->row_array();

            if ($check_user) {
                $this->session->set_flashdata('error', 'Username sudah terdaftar.');
                redirect('auth/register');
            } elseif ($check_email) {
                $this->session->set_flashdata('error', 'Email sudah terdaftar.');
                redirect('auth/register');
            } else {
                $data_user = array(
                    'username' => $username,
                    'password' => $password, // Plain text standard for compatibility
                    'fullname' => $fullname,
                    'email'    => $email,
                    'phone'    => $phone,
                    'role'     => 'client'
                );

                $this->db->insert('users', $data_user);
                $new_id = $this->db->insert_id();

                if ($new_id) {
                    $this->session->set_userdata(array(
                        'user_id' => $new_id,
                        'username' => $username,
                        'fullname' => $fullname,
                        'role'     => 'client'
                    ));
                    $this->session->set_flashdata('success', 'Akun berhasil dibuat! Selamat datang di DRIVE.X.');
                    redirect('booking/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mendaftarkan akun baru.');
                    redirect('auth/register');
                }
            }
        } else {
            $data['title'] = 'Register | DRIVE.X';
            $this->load->view('layout/header', $data);
            $this->load->view('auth/register', $data);
            $this->load->view('layout/footer');
        }
    }

    /**
     * Handle User Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('mobil');
    }

    /**
     * Redirect User Based On Role
     */
    private function redirect_by_role($role) {
        // If there is a pending transaction redirection URL, prioritize it
        if ($this->session->userdata('redirect_url')) {
            $redirect_url = $this->session->userdata('redirect_url');
            $this->session->unset_userdata('redirect_url');
            redirect($redirect_url);
        }

        if ($role === 'manager' || $role === 'admin') {
            redirect('admin');
        } else {
            redirect('booking/dashboard');
        }
    }
}
