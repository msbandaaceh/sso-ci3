<?php

class ModelPlh extends CI_Model
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

    public function plh_data($jab_id)
    {
        if (in_array($jab_id, ['0', '5', '11'])) {
            $this->db->select('pl.id AS id, pl.nama AS nama, pl.pegawai_id AS pegawai_id, p.nama_gelar AS nama_pegawai');
            $this->db->from('ref_plh pl');
            $this->db->join('pegawai p', 'pl.pegawai_id = p.id', 'left');
            return $this->db->get()->result();
        } else {
            $this->db->order_by('id', 'ASC');
            $this->db->where('plh_id_jabatan', $jab_id);
            return $this->db->select('*')->from('ref_plh')->get();
        }
    }

    public function update_plh($data, $id)
    {
        $table = 'ref_plh';
        try {
            $this->db->where('id', $id);
            $this->db->update($table, $data);
            if ($data['pegawai_id'] == NULL) {
                $title = "Hapus Plh [Plh=<b>-</b>]<br />Update tabel <b>plh</b>]";
            } else {
                $title = "Update Plh [Plh=<b>" . $data['pegawai_id'] . "</b>]<br />Update tabel <b>plh</b>]";
            }
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}