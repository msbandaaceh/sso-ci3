<?php defined('BASEPATH') or exit('No direct script access allowed');

class ModelLogin extends CI_Model
{
    public function get_seleksi_user($tabel, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where('block = 0');
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi($tabel, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_konfigurasi($id)
    {
        try {
            $this->db->where('id', $id);
            return $this->db->get('sys_config');
        } catch (Exception $e) {
            return 0;
        }
    }

    public function log_online($data_login)
    {
        try {
            $this->db->insert('sys_user_online', $data_login);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function last_online($userid, $date) {
        $tabel = 'sys_users';
        try {
            $this->db->where('userid', $userid);
            $this->db->update($tabel, $date);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    function tambahTamu($data, $table) {
        return $this->db->insert($table, $data);
    }
}