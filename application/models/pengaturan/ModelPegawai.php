<?php

class ModelPegawai extends CI_Model
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

    public function all_pegawai_data()
    {
        $this->db->order_by('jab_id', 'ASC');
        return $this->db->select('*')->from('v_pegawai')->where('id > 0')->get()->result();
    }

    public function pilih_pegawai()
    {
        try {
            $this->db->where('id > 0');
            $this->db->where('status_pegawai', '1');
            $this->db->order_by('jab_id', 'ASC');
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pilih_semua_pegawai()
    {
        try {
            $this->db->where('id > 0');
            $this->db->order_by('jab_id', 'ASC');
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pilih_atasan()
    {
        try {
            $this->db->order_by('id', 'ASC');
            $this->db->where_in('id', array(1, 4, 5, 6, 7, 8, 9, 10, 11, 12));
            return $this->db->get('ref_jabatan');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pilih_pegawai_tamu()
    {
        try {
            $this->db->where('status_pegawai', '1');
            $this->db->where('jab_id <> 0');
            $this->db->where('id_grup <> 5');
            $this->db->order_by('jab_id', 'ASC');
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function atasan_aktif()
    {
        $this->db->order_by('id', 'ASC');
        $this->db->where_in('id', array(1, 4, 5, 6, 7, 8, 9, 10, 11, 12));
        return $this->db->select('*')->from('ref_jabatan')->get()->result();
    }

    public function pegawai_data($id)
    {
        $this->db->where('id', $id);
        return $this->db->select('*')->from('v_pegawai')->get()->result();
    }

    public function cek_jabatan_pegawai($jabatan, $id)
    {
        try {
            $this->db->where("id != '" . $id . "'");
            $this->db->where('status_pegawai', '1');
            $this->db->where('jab_id', $jabatan);
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function get_pegawai_by($seleksi, $nilai)
    {
        try {
            $this->db->where($seleksi, $nilai);
            return $this->db->get('pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function cek_jabatan_baru_pegawai($jabatan)
    {
        try {
            $this->db->where('status_pegawai', '1');
            $this->db->where('jab_id', $jabatan);
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function jenis_pegawai()
    {
        try {
            return $this->db->get('ref_group_jabatan');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function tambah_pegawai($data)
    {
        $table = 'pegawai';
        try {
            $this->db->insert($table, $data);
            $title = "Tambah Pegawai [Pegawai=<b>" . $data['nama_gelar'] . "</b>]<br />Tambah tabel <b>pegawai</b>]";
            $descrip = null;
            $this->add_audittrail("TAMBAH", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}