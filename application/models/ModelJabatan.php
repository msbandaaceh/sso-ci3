<?php

class ModelJabatan extends CI_Model
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

    public function all_jabatan_data()
    {
        $this->db->where('hapus', '0');
        return $this->db->select('*')->from('ref_jabatan')->get()->result();
    }

    public function get_jabatan_struktural()
    {
        $this->db->where('hapus', '0');
        $this->db->where('struktural', '1');
        return $this->db->select('*')->from('ref_jabatan')->get()->result();
    }

    public function pilih_jabatan()
    {
        try {
            $this->db->order_by('id');
            $this->db->where('id > 0');
            return $this->db->get('ref_jabatan');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function tambah_jabatan($data)
    {
        $table = 'ref_jabatan';
        try {
            $this->db->insert($table, $data);
            $title = "Tambah Jabatan [Jabatan=<b>" . $data['nama_jabatan'] . "</b>]<br />Tambah tabel <b>jabatan</b>]";
            $descrip = null;
            $this->add_audittrail("TAMBAH", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function update_jabatan($data, $id)
    {
        $table = 'ref_jabatan';
        try {
            $this->db->where('id', $id);
            $this->db->update($table, $data);
            $title = "Update Jabatan [Jabatan=<b>" . $data['nama_jabatan'] . "</b>]<br />Update tabel <b>jabatan</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

}