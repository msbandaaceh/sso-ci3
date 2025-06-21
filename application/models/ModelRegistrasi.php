<?php

class ModelRegistrasi extends CI_Model
{
    public function cek_username($username)
    {
        $table = 'sys_users';
        $this->db->where('username', $username);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function cek_nohp($nohp)
    {
        $table = 'pegawai';
        $this->db->where('nohp', $nohp);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function cek_jabatan($jabatan)
    {
        $table = 'pegawai';
        $this->db->where('status_pegawai', '1');
        $this->db->where('jabatan_id', $jabatan);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function cek_pegawai($nip)
    {
        try {
            $this->db->where('nip', $nip);
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function cek_pegawai_user($nip)
    {
        try {
            $this->db->where('nip', $nip);
            return $this->db->get('v_users');
        } catch (Exception $e) {
            return $e;
        }
    }
}