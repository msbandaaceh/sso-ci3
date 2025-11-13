<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelResetPassword extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Cari user berdasarkan NIP
     * 
     * @param string $nip NIP pegawai
     * @return object|null Query result atau null jika tidak ditemukan
     */
    public function get_user_by_nip($nip)
    {
        try {
            $this->db->select('u.userid, u.pegawai_id, u.username, p.nip, p.nama_gelar, p.nohp, u.block');
            $this->db->from('sys_users u');
            $this->db->join('pegawai p', 'u.pegawai_id = p.id', 'inner');
            $this->db->where('p.nip', $nip);
            $this->db->where('u.block', 0); // Hanya user yang tidak diblokir
            $this->db->limit(1);
            return $this->db->get();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Simpan token reset password
     * 
     * @param array $data Data token (userid, nip, token, ip_address, expires_at)
     * @return int|false Insert ID jika berhasil, false jika gagal
     */
    public function save_reset_token($data)
    {
        try {
            $this->db->insert('reset_password_tokens', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cari token reset password yang valid (belum digunakan dan belum expired)
     * 
     * @param string $encrypted_token Token terenkripsi
     * @return object|null Query result atau null jika tidak ditemukan
     */
    public function get_valid_token($encrypted_token)
    {
        try {
            $this->db->where('token', $encrypted_token);
            $this->db->where('used', 0);
            $this->db->where('expires_at >', date('Y-m-d H:i:s'));
            $this->db->limit(1);
            return $this->db->get('reset_password_tokens');
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Tandai token sebagai sudah digunakan
     * 
     * @param int $token_id ID token
     * @return bool True jika berhasil, false jika gagal
     */
    public function mark_token_as_used($token_id)
    {
        try {
            $this->db->where('id', $token_id);
            $this->db->update('reset_password_tokens', ['used' => 1]);
            return $this->db->affected_rows() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Hapus token yang sudah expired (cleanup)
     * 
     * @return int Jumlah token yang dihapus
     */
    public function cleanup_expired_tokens()
    {
        try {
            $this->db->where('expires_at <', date('Y-m-d H:i:s'));
            $this->db->or_where('used', 1);
            $this->db->delete('reset_password_tokens');
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Cek rate limiting - hitung jumlah request reset dalam 1 jam terakhir
     * 
     * @param string $nip NIP user
     * @param string $ip_address IP address
     * @return int Jumlah request dalam 1 jam terakhir
     */
    public function count_recent_requests($nip, $ip_address)
    {
        try {
            $one_hour_ago = date('Y-m-d H:i:s', strtotime('-1 hour'));
            $this->db->where('nip', $nip);
            $this->db->where('ip_address', $ip_address);
            $this->db->where('created_on >=', $one_hour_ago);
            return $this->db->count_all_results('reset_password_tokens');
        } catch (Exception $e) {
            return 999; // Return tinggi untuk mencegah abuse jika error
        }
    }

    /**
     * Update password user
     * 
     * @param int $userid User ID
     * @param string $new_password_hash Password hash baru
     * @return bool True jika berhasil, false jika gagal
     */
    public function update_user_password($userid, $new_password_hash)
    {
        try {
            $this->db->where('userid', $userid);
            $this->db->update('sys_users', ['password' => $new_password_hash]);
            return $this->db->affected_rows() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Hapus semua token reset untuk user tertentu (untuk invalidate token lama)
     * 
     * @param int $userid User ID
     * @return int Jumlah token yang dihapus
     */
    public function invalidate_user_tokens($userid)
    {
        try {
            $this->db->where('userid', $userid);
            $this->db->where('used', 0);
            $this->db->update('reset_password_tokens', ['used' => 1]);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return 0;
        }
    }
}

