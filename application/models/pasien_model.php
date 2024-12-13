<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_pasien() {
        $query = $this->db->get('pasien');
        return $query->result();  // Mengembalikan hasil query
    }

    // Fungsi untuk menambahkan pasien
    public function insert_pasien($data) {
        $this->db->insert('pasien', $data);
        return $this->db->insert_id(); // Mengembalikan ID pasien yang baru saja dimasukkan
    }

    // Fungsi untuk mendapatkan pasien berdasarkan ID
    public function get_pasien_by_id($id) {
        return $this->db->get_where('pasien', ['id' => $id])->row();
    }

    // Fungsi untuk memperbarui data pasien
    public function update_pasien($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pasien', $data);
    }

    // Fungsi untuk menghapus pasien
    public function delete_pasien($id) {
        return $this->db->delete('pasien', ['id' => $id]);
    }

    // Fungsi untuk menghasilkan no_rm (nomor rekam medis)
    public function generate_no_rm() {
        $this->db->select('no_rm');
        $this->db->from('pasien');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
    
        // Cek jika ada pasien yang sudah terdaftar
        if ($query->num_rows() > 0) {
            $last_no_rm = $query->row()->no_rm;
            $last_year = substr($last_no_rm, 0, 4);
            $last_month = substr($last_no_rm, 4, 2);
            $last_number = substr($last_no_rm, 7, 3);
        } else {
            // Jika belum ada pasien, mulai dari tahun dan bulan sekarang
            $last_year = date('Y');
            $last_month = date('m');
            $last_number = '000';
        }
    
        // Jika tahun dan bulan sama, lanjutkan dengan nomor urut berikutnya
        if ($last_year == date('Y') && $last_month == date('m')) {
            $last_number = str_pad((int)$last_number + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika berbeda tahun/bulan, reset nomor urut
            $last_number = '001';
        }
    
        // Generate no_rm dengan format: YYYYMM-XXX
        return $last_year . $last_month . '-' . $last_number;
    }

    public function authenticate($nama, $password) {
        // Mencari pasien berdasarkan nama
        $this->db->where('nama', $nama);
        $query = $this->db->get('pasien');

        // Jika pasien ditemukan
        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Verifikasi password
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return null; // Jika autentikasi gagal
    }
}
?>
