<?php

class ModelApi extends CI_Model
{
    public function log_trail($action, $title, $table, $descrip, $username, $ip = null)
    {
        try {
            $data = [
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $ip ?? $this->input->ip_address(),
                'username' => $username,
                'tablename' => $table,
                'action' => $action,
                'title' => $title,
                'description' => $descrip
            ];

            return $this->db->insert('sys_audittrail', $data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_seleksi($tabel, $kolom_seleksi, $seleksi)
    {
        $this->db->where($kolom_seleksi, $seleksi);
        return $this->db->get($tabel);
    }

    public function get_seleksi2($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        $this->db->where($kolom_seleksi2, $seleksi2);
        $this->db->where($kolom_seleksi, $seleksi);
        return $this->db->get($tabel);
    }

    public function get_data_tabel($tabel)
    {
        return $this->db->get($tabel);
    }

    public function pembaharuan_data($tabel, $data, $kunci, $id)
    {
        $this->db->where($kunci, $id);
        return $this->db->update($tabel, $data);
    }

    public function simpan_data($tabel, $data)
    {
        return $this->db->insert($tabel, $data);
    }
}