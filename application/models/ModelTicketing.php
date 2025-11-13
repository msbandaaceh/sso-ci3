<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelTicketing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ambil semua data ticketing
     */
    public function get_all_tickets()
    {
        try {
            $this->db->order_by('created_on', 'DESC');
            return $this->db->get('ticketing');
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Ambil data ticketing berdasarkan status
     */
    public function get_tickets_by_status($status)
    {
        try {
            $this->db->where('status', $status);
            $this->db->order_by('created_on', 'DESC');
            return $this->db->get('ticketing');
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Ambil data ticketing berdasarkan ID
     */
    public function get_ticket_by_id($id)
    {
        try {
            $this->db->where('id', $id);
            return $this->db->get('ticketing');
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Simpan data ticketing baru
     */
    public function simpan_ticket($data)
    {
        try {
            $this->db->insert('ticketing', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Update data ticketing
     */
    public function update_ticket($id, $data)
    {
        try {
            $this->db->where('id', $id);
            $this->db->update('ticketing', $data);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Hitung jumlah ticket berdasarkan status
     */
    public function count_tickets_by_status($status)
    {
        try {
            $this->db->where('status', $status);
            $this->db->from('ticketing');
            return $this->db->count_all_results();
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Simpan log ticketing
     */
    public function simpan_log($data)
    {
        try {
            $this->db->insert('ticketing_log', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Ambil log berdasarkan ticket_id
     */
    public function get_log_by_ticket_id($ticket_id)
    {
        try {
            $this->db->where('ticket_id', $ticket_id);
            $this->db->order_by('dilakukan_pada', 'ASC');
            return $this->db->get('ticketing_log');
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Ambil data ticketing dengan filter tanggal dan status
     */
    public function get_tickets_filtered($tanggal_awal = null, $tanggal_akhir = null, $status = [])
    {
        try {
            // Filter tanggal
            if ($tanggal_awal) {
                $this->db->where('DATE(created_on) >=', $tanggal_awal);
            }
            if ($tanggal_akhir) {
                $this->db->where('DATE(created_on) <=', $tanggal_akhir);
            }
            
            // Filter status (multiselect)
            if (!empty($status) && is_array($status)) {
                $this->db->where_in('status', $status);
            }
            
            $this->db->order_by('created_on', 'DESC');
            return $this->db->get('ticketing');
        } catch (Exception $e) {
            return 0;
        }
    }
}

