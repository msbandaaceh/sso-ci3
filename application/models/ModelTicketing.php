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
     * OPTIMASI: Menggunakan range query tanpa fungsi DATE() untuk memungkinkan penggunaan index
     */
    public function get_tickets_filtered($tanggal_awal = null, $tanggal_akhir = null, $status = [])
    {
        try {
            // Filter tanggal - menggunakan range query tanpa fungsi DATE()
            // Ini memungkinkan MySQL menggunakan index pada kolom created_on
            if ($tanggal_awal) {
                // Tambahkan waktu 00:00:00 untuk awal hari
                $tanggal_awal_datetime = $tanggal_awal . ' 00:00:00';
                $this->db->where('created_on >=', $tanggal_awal_datetime);
            }
            if ($tanggal_akhir) {
                // Tambahkan waktu 23:59:59 untuk akhir hari
                $tanggal_akhir_datetime = $tanggal_akhir . ' 23:59:59';
                $this->db->where('created_on <=', $tanggal_akhir_datetime);
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

