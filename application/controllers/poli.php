<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load model Poli_model
        $this->load->model('Poli_model');
    }

    // Fungsi untuk menampilkan halaman kelola poli
    public function index()
    {
        // Mengambil semua data poli dari model
        $data['poliklinik'] = $this->Poli_model->get_all_poli();

        // Menampilkan halaman kelola_poli.php dengan data poli
        $this->load->view('kelola_poli', $data);
    }

    // Fungsi untuk mengambil data poli berdasarkan ID
    public function get($id)
    {
        $data = $this->Poli_model->get_poli_by_id($id); // Ambil data poli berdasarkan ID
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data poli tidak ditemukan']);
        }
    }

    // Fungsi untuk menambah poli
    public function tambah()
    {
        $this->form_validation->set_rules('nama_poli', 'Nama Poli', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = array(
                'nama_poli' => $this->input->post('nama_poli'),
                'deskripsi' => $this->input->post('deskripsi')
            );

            $this->Poli_model->insert_poli($data);
            echo json_encode(['status' => 'success']);
        }
    }

    // Fungsi untuk mengedit poli
    public function edit($id)
    {
        $this->form_validation->set_rules('nama_poli', 'Nama Poli', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = array(
                'nama_poli' => $this->input->post('nama_poli'),
                'deskripsi' => $this->input->post('deskripsi')
            );

            $this->Poli_model->update_poli($id, $data);
            echo json_encode(['status' => 'success']);
        }
    }

    // Fungsi untuk menghapus poli
    public function hapus($id)
    {
        $this->Poli_model->delete_poli($id);
        echo json_encode(['status' => 'success']);
    }
}
