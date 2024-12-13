<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('Pasien_model');  // Load model Pasien_model
        $this->load->model('Dokter_model');  // Load model Dokter_model
    }

    public function index() {
        // Menampilkan halaman login
        $this->load->view('login');
    }

    public function authenticate() {
        // Mengambil data dari form login
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        // Cek login admin (hardcoded username dan password)
        if ($username == 'admin' && $password == 'admin') {
            // Jika login admin berhasil, set session untuk admin
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('role', 'admin');
            $this->session->set_userdata('username', $username);
            redirect('dashboard');
        } else {
            // Cek autentikasi di tabel pasien
            $user_pasien = $this->Pasien_model->authenticate($username, $password);

            // Cek autentikasi di tabel dokter
            $user_dokter = $this->Dokter_model->authenticate($username, $password);

            if ($user_pasien) {
                // Jika login berhasil sebagai pasien
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('role', 'pasien');
                $this->session->set_userdata('nama', $user_pasien->nama);
                redirect('dashboard_pasien');
            } elseif ($user_dokter) {
                // Jika login berhasil sebagai dokter
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('role', 'dokter');
                $this->session->set_userdata('nama', $user_dokter->nama);
                redirect('dashboard_dokter');
            } else {
                // Jika login gagal
                $this->session->set_flashdata('error', 'Username atau Password salah!');
                redirect('login');
            }
        }
    }

    public function logout() {
        // Logout dan hapus semua session
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama');
        redirect('login');
    }
}
?>
