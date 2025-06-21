<?php

class ModelUser extends CI_Model
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

    public function all_user_data()
    {
        $this->db->order_by('jab_id', 'ASC');
        $this->db->where('pegawai_id > 0');
        return $this->db->select('*')->from('v_users')->get()->result();
    }

    public function get_user_data($id)
    {
        $this->db->where('userid', $id);
        return $this->db->select('*')->from('v_users')->get()->result();
    }

    public function tambah_pengguna($data)
    {
        $table = 'sys_users';
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

    public function update_pengguna($data, $id)
    {
        $table = 'sys_users';
        try {
            $this->db->where('userid', $id);
            $this->db->update($table, $data);
            $title = "Update Pengguna [Pengguna=<b>" . $data['nama_gelar'] . "</b>]<br />Update tabel <b>pengguna</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function reset_perangkat($data, $id)
    {
        $table = 'sys_users';
        try {
            $this->db->where('userid', $id);
            $this->db->update($table, $data);
            $title = "Reset Perangkat Pengguna [Pengguna=<b>" . $data['nama_gelar'] . "</b>]<br />Update tabel <b>pengguna</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}