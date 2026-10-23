<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller untuk Reset Password
 * Fitur keamanan:
 * - Token dienkripsi menggunakan CI Encryption
 * - Token hanya berlaku sekali pakai
 * - Token memiliki expiry time (1 jam)
 * - Rate limiting (max 3 request per jam per NIP/IP)
 * - Validasi password kuat (min 8 karakter, huruf besar, huruf kecil, angka, simbol)
 * 
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Encryption $encryption
 * @property CI_Session $session
 * @property ModelResetPassword $reset_model
 * @property ModelNotifikasi $notif
 * @property Hash_helper $hash_helper
 */
class ResetPassword extends CI_Controller
{
    // Rate limiting: maksimal 3 request per jam per NIP/IP
    const MAX_REQUESTS_PER_HOUR = 3;
    
    // Token expiry: 1 jam
    const TOKEN_EXPIRY_HOURS = 1;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelResetPassword', 'reset_model');
        $this->load->model('ModelNotifikasi', 'notif');
        $this->load->library('encryption');
    }

    /**
     * Halaman form request reset password (input NIP)
     */
    public function index()
    {
        $this->load->model('ModelLogin', 'login_model');
        $data['nama_satker'] = $this->login_model->get_konfigurasi('4')->row()->value ?? 'SSO';
        $data['logo_satker'] = 'assets/dokumen/' . ($this->login_model->get_konfigurasi('22')->row()->value ?? 'logo.webp');
        $data['nama_app'] = $this->login_model->get_konfigurasi('1')->row()->value ?? 'SSO';
        $data['title_app'] = $this->login_model->get_konfigurasi('2')->row()->value ?? 'SSO';
        
        $this->load->view('reset_password/form_request_reset', $data);
    }

    /**
     * Proses request reset password
     * - Validasi NIP
     * - Cek rate limiting
     * - Generate token terenkripsi
     * - Kirim link reset via WhatsApp
     */
    public function request_reset()
    {
        // Validasi input
        $this->form_validation->set_rules('nip', 'NIP', 'trim|required|min_length[8]|max_length[18]|regex_match[/^[0-9]+$/]', [
            'required' => 'NIP tidak boleh kosong',
            'min_length' => 'NIP minimal 8 karakter',
            'max_length' => 'NIP maksimal 18 karakter',
            'regex_match' => 'NIP hanya boleh berisi angka'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('reset_password');
            return;
        }

        $nip = $this->input->post('nip');
        $ip_address = $this->input->ip_address();

        // Cleanup token expired
        $this->reset_model->cleanup_expired_tokens();

        // Cek rate limiting
        $recent_requests = $this->reset_model->count_recent_requests($nip, $ip_address);
        if ($recent_requests >= self::MAX_REQUESTS_PER_HOUR) {
            $this->session->set_flashdata('error', 'Terlalu banyak permintaan reset password. Silakan coba lagi setelah 1 jam.');
            redirect('reset_password');
            return;
        }

        // Cari user berdasarkan NIP
        $user = $this->reset_model->get_user_by_nip($nip);
        
        if (!$user || $user->num_rows() == 0) {
            // Untuk keamanan, jangan beri tahu bahwa NIP tidak ditemukan
            // Beri pesan generic untuk mencegah enumeration attack
            $this->session->set_flashdata('success', 'Berhasil melakukan request reset password, link reset password telah dikirim ke nomor WhatsApp yang terdaftar.');
            redirect('reset_password');
            return;
        }

        $user_data = $user->row();

        // Cek apakah user memiliki nomor HP
        if (empty($user_data->nohp)) {
            $this->session->set_flashdata('error', 'Nomor WhatsApp tidak terdaftar. Silakan hubungi administrator.');
            redirect('reset_password');
            return;
        }

        // Generate token (random string)
        $token = bin2hex(random_bytes(32)); // 64 karakter hex
        
        // Data untuk disimpan di database
        $token_data = [
            'userid' => $user_data->userid,
            'nip' => $nip,
            'token' => $token, // Simpan token plain untuk pencarian (akan dienkripsi di URL)
            'ip_address' => $ip_address,
            'used' => 0,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+' . self::TOKEN_EXPIRY_HOURS . ' hours')),
            'created_on' => date('Y-m-d H:i:s')
        ];

        // Simpan token
        $token_id = $this->reset_model->save_reset_token($token_data);
        
        if (!$token_id) {
            $this->session->set_flashdata('error', 'Gagal membuat token reset. Silakan coba lagi.');
            redirect('reset_password');
            return;
        }

        // Enkripsi token untuk URL (menggunakan CI Encryption)
        $encrypted_token = $this->encryption->encrypt($token);
        $encrypted_token = base64_encode($encrypted_token); // URL-safe encoding

        // Buat link reset password
        $reset_link = site_url('reset_password/process?token=' . urlencode($encrypted_token));

        // Buat pesan WhatsApp
        $pesanWA = "Halo " . $user_data->nama_gelar . ",\n\n";
        $pesanWA .= "Anda telah meminta reset password untuk akun LITERASI.\n\n";
        $pesanWA .= "Klik link berikut untuk reset password Anda:\n";
        $pesanWA .= $reset_link . "\n\n";
        $pesanWA .= "Link ini hanya berlaku 1 jam dan hanya dapat digunakan sekali.\n\n";
        $pesanWA .= "Jika Anda tidak meminta reset password, abaikan pesan ini.";

        // Kirim notifikasi WhatsApp
        $dataNotif = [
            'id_pemohon' => '999',
            'jenis_pesan' => 'reset_password',
            'pesan' => $pesanWA,
            'id_tujuan' => $user_data->pegawai_id,
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => 'system'
        ];

        $this->notif->tambahNotif($dataNotif, 'sys_notif');

        // Beri feedback ke user (generic message untuk keamanan)
        $this->session->set_flashdata('success', 'Berhasil melakukan request reset password, link reset password telah dikirim ke nomor WhatsApp yang terdaftar.');
        redirect('reset_password');
    }

    /**
     * Halaman form reset password (setelah klik link dari WhatsApp)
     * 
     * @param string token Token terenkripsi dari URL
     */
    public function process()
    {
        $encrypted_token = $this->input->get('token');

        if (empty($encrypted_token)) {
            $this->session->set_flashdata('error', 'Token tidak valid atau sudah kadaluarsa.');
            redirect('reset_password');
            return;
        }

        // Decode dan decrypt token
        try {
            $decoded_token = base64_decode($encrypted_token);
            $token = $this->encryption->decrypt($decoded_token);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Token tidak valid atau sudah kadaluarsa.');
            redirect('reset_password');
            return;
        }

        // Cari token yang valid
        $token_data = $this->reset_model->get_valid_token($token);

        if (!$token_data || $token_data->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Token tidak valid, sudah digunakan, atau sudah kadaluarsa.');
            redirect('reset_password');
            return;
        }

        $token_row = $token_data->row();

        // Ambil data user
        $user = $this->reset_model->get_user_by_nip($token_row->nip);
        if (!$user || $user->num_rows() == 0) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('reset_password');
            return;
        }

        $this->load->model('ModelLogin', 'login_model');
        $data['token_id'] = $token_row->id;
        $data['encrypted_token'] = $encrypted_token;
        $data['nama_satker'] = $this->login_model->get_konfigurasi('4')->row()->value ?? 'SSO';
        $data['logo_satker'] = 'assets/dokumen/' . ($this->login_model->get_konfigurasi('22')->row()->value ?? 'logo.webp');
        $data['nama_app'] = $this->login_model->get_konfigurasi('1')->row()->value ?? 'SSO';
        $data['title_app'] = $this->login_model->get_konfigurasi('2')->row()->value ?? 'SSO';

        $this->load->view('reset_password/form_reset_password', $data);
    }

    /**
     * Proses reset password
     * - Validasi token
     * - Validasi password kuat
     * - Update password
     * - Tandai token sebagai used
     */
    public function do_reset()
    {
        $encrypted_token = $this->input->post('token');
        $new_password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');

        // Validasi input
        if (empty($encrypted_token)) {
            $this->session->set_flashdata('error', 'Token tidak valid.');
            redirect('reset_password');
            return;
        }

        // Decode dan decrypt token
        try {
            $decoded_token = base64_decode($encrypted_token);
            $token = $this->encryption->decrypt($decoded_token);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Token tidak valid atau sudah kadaluarsa.');
            redirect('reset_password');
            return;
        }

        // Cari token yang valid
        $token_data = $this->reset_model->get_valid_token($token);

        if (!$token_data || $token_data->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Token tidak valid, sudah digunakan, atau sudah kadaluarsa.');
            redirect('reset_password');
            return;
        }

        $token_row = $token_data->row();

        // Validasi password
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|callback_validate_strong_password');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'trim|required|matches[password]', [
            'matches' => 'Konfirmasi password tidak cocok'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->model('ModelLogin', 'login_model');
            $data['token_id'] = $token_row->id;
            $data['encrypted_token'] = $encrypted_token;
            $data['nama_satker'] = $this->login_model->get_konfigurasi('4')->row()->value ?? 'SSO';
            $data['logo_satker'] = 'assets/dokumen/' . ($this->login_model->get_konfigurasi('22')->row()->value ?? 'logo.webp');
            $data['nama_app'] = $this->login_model->get_konfigurasi('1')->row()->value ?? 'SSO';
            $data['title_app'] = $this->login_model->get_konfigurasi('2')->row()->value ?? 'SSO';
            $data['validation_errors'] = validation_errors();
            
            $this->load->view('reset_password/form_reset_password', $data);
            return;
        }

        // Hash password baru menggunakan Hash_helper
        $new_password_hash = $this->hash_helper->hash_password($new_password);

        // Update password user
        $update_result = $this->reset_model->update_user_password($token_row->userid, $new_password_hash);

        if (!$update_result) {
            $this->session->set_flashdata('error', 'Gagal mengupdate password. Silakan coba lagi.');
            redirect('reset_password');
            return;
        }

        // Tandai token sebagai used
        $this->reset_model->mark_token_as_used($token_row->id);

        // Invalidate semua token lain untuk user ini (keamanan tambahan)
        $this->reset_model->invalidate_user_tokens($token_row->userid);

        // Success
        $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        redirect('login');
    }

    /**
     * Custom validation untuk password kuat
     * Password harus:
     * - Minimal 8 karakter
     * - Mengandung huruf besar
     * - Mengandung huruf kecil
     * - Mengandung angka
     * - Mengandung simbol
     */
    public function validate_strong_password($password)
    {
        if (strlen($password) < 8) {
            $this->form_validation->set_message(['validate_strong_password' => 'Password minimal 8 karakter.']);
            return FALSE;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $this->form_validation->set_message(['validate_strong_password' => 'Password harus mengandung minimal 1 huruf besar.']);
            return FALSE;
        }

        if (!preg_match('/[a-z]/', $password)) {
            $this->form_validation->set_message(['validate_strong_password' => 'Password harus mengandung minimal 1 huruf kecil.']);
            return FALSE;
        }

        if (!preg_match('/[0-9]/', $password)) {
            $this->form_validation->set_message(['validate_strong_password' => 'Password harus mengandung minimal 1 angka.']);
            return FALSE;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $this->form_validation->set_message(['validate_strong_password' => 'Password harus mengandung minimal 1 simbol.']);
            return FALSE;
        }

        return TRUE;
    }
}

