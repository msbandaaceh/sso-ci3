<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPangkat extends CI_Model
{
    private function add_audittrail($action, $title, $table, $descrip)
    {
        try {
            $data = array(
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $this->input->ip_address(),
                'username' => $this->session->userdata('username'),
                'tablename' => $table,
                'action' => $action,
                'title' => $title,
                'description' => $descrip
            );
            $this->db->insert('sys_audittrail', $data);
        } catch (Exception $e) {

        }
    }

    public function all_pangkat_data()
    {
        $this->db->where('hapus', '0');
        return $this->db->select('*')->from('ref_pangkat')->get()->result();
    }

    public function pilih_pangkat()
    {
        try {
            return $this->db->get('ref_pangkat');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function tambah_pangkat($data)
    {
        $table = 'ref_pangkat';
        try {
            $this->db->insert($table, $data);
            $title = "Tambah Pangkat Golongan [Pangkat=<b>" . $data['pangkat'] . "</b>, Golongan=<b>" . $data['golongan'] . "]<br />Tambah tabel <b>pangkat</b>]";
            $descrip = null;
            $this->add_audittrail("TAMBAH", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function update_pangkat($data, $id)
    {
        $table = 'ref_pangkat';
        try {
            $this->db->where('id', $id);
            $this->db->update($table, $data);
            $title = "Update Pangkat [Pangkat=<b>" . $data['pangkat'] . "</b>, Golongan=<b>" . $data['golongan'] . "</b>]<br />Update tabel <b>jabatan</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function get_seleksi_pangkat($id)
	{
		try {
			$this->db->where('id', $id);
			return $this->db->get('ref_pangkat');
		} catch (Exception $e) {
			return $e;
		}
	}
}