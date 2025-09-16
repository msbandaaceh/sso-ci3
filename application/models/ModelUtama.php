<?php defined('BASEPATH') or exit('No direct script access allowed');

class ModelUtama extends CI_Model
{

    private function add_audittrail($action, $title, $table, $descrip)
    {
        $username = $this->session->userdata('username');
        if ($username == '') {
            $username = 'admin';
        }
        try {
            $data = array(
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $this->input->ip_address(),
                'username' => $username,
                'tablename' => $table,
                'action' => $action,
                'title' => $title,
                'description' => $descrip
            );
            $this->db->insert('sys_audittrail', $data);
        } catch (Exception $e) {

        }
    }

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

    public function get_seleksi2($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        try {
            $this->db->where($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_data($tabel)
    {
        try {
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_data_client()
    {
        try {
            $this->db->where('status', '1');
            return $this->db->get('ref_client_app');
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

    public function simpan_data($tabel, $data)
    {
        try {
            $this->db->insert($tabel, $data);
            $title = "Simpan Data <br />Update tabel <b>" . $tabel . "</b>[]";
            $descrip = null;
            $this->add_audittrail("INSERT", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function pembaharuan_data($tabel, $data, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where($kolom_seleksi, $seleksi);
            $this->db->update($tabel, $data);
            $title = "Pembaharuan Data <br />Update tabel <b>" . $tabel . "</b>[Pada kolom<b>" . $kolom_seleksi . "</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}