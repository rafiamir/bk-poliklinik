<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Pastikan database sudah diload
    }

    // Fungsi untuk mengambil semua data poli
    public function get_all_poli()
    {
        $query = $this->db->get('poli'); 
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    // Fungsi untuk menambahkan poli
    public function insert_poli($data)
    {
        $this->db->insert('poli', $data);
    }

    // Fungsi untuk mengupdate data poli
    public function update_poli($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('poli', $data);
    }

    // Fungsi untuk menghapus data poli
    public function delete_poli($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('poli');
    }

    // Fungsi untuk mengambil data poli berdasarkan ID
    public function get_poli_by_id($id)
    {
        $this->db->where('id', $id); // Menambahkan kondisi untuk ID
        $query = $this->db->get('poli'); // Ambil data dari tabel poli berdasarkan ID
        return $query->row_array(); // Mengembalikan satu data poli dalam bentuk array
    }
}
