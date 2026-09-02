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

    public function get_cuti_kalender($tgl_awal, $tgl_akhir)
    {
        try {
            // Ambil data cuti dari API seudati
            $params = [
                'api_key' => $this->config->item('api_key'),
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            ];
            $result = $this->apihelper->get($this->config->item('api_izincuti') . '/get_cuti_kalender', $params);

            $data_cuti = [];
            if ($result['status_code'] === 200 && isset($result['response']['status']) && $result['response']['status'] === 'success') {
                $data_cuti = $result['response']['data'];
            }

            // Ambil data pegawai dari v_pegawai lokal
            $this->db->select('id, nama_gelar');
            $this->db->from('v_pegawai');
            $pegawai_result = $this->db->get()->result_array();

            // Build pegawai map
            $pegawai_map = [];
            foreach ($pegawai_result as $pegawai) {
                $pegawai_map[$pegawai['id']] = $pegawai['nama_gelar'];
            }

            // Gabungkan data cuti dengan nama pegawai
            foreach ($data_cuti as &$cuti) {
                $cuti['nama_pegawai'] = $pegawai_map[$cuti['pegawai_id']] ?? '';
            }

            return $data_cuti;
        } catch (Exception $e) {
            return [];
        }
    }

    public function get_izin_keluar_kalender($tgl_awal, $tgl_akhir)
    {
        try {
            // Ambil data izin keluar dari API seudati
            $params = [
                'api_key' => $this->config->item('api_key'),
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            ];
            $result = $this->apihelper->get($this->config->item('api_izincuti') . '/get_izin_keluar_kalender', $params);

            $data_izin = [];
            if ($result['status_code'] === 200 && isset($result['response']['status']) && $result['response']['status'] === 'success') {
                $data_izin = $result['response']['data'];
            }

            // Ambil data user dari v_users lokal
            $this->db->select('userid, fullname');
            $this->db->from('v_users');
            $user_result = $this->db->get()->result_array();

            // Build user map
            $user_map = [];
            foreach ($user_result as $user) {
                $user_map[$user['userid']] = $user['fullname'];
            }

            // Gabungkan data izin dengan nama user
            foreach ($data_izin as &$izin) {
                $izin['nama_pegawai'] = $user_map[$izin['id_user']] ?? '';
            }

            return $data_izin;
        } catch (Exception $e) {
            return [];
        }
    }
}