<?php
// File: application/controllers/HalamanLogin.php (SSO Server)
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $pegawai
 * @property CI_Model $utama
 * @property CI_Model $notif
 * @property CI_Encryption $encryption
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */

class HalamanLogin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->jwt_key = $this->config->item('jwt_key');
        $this->load->model('ModelLogin', 'model');
        $this->load->model('ModelNotifikasi', 'notif');
        $this->load->model('ModelUtama', 'utama');
        $this->load->model('pengaturan/ModelPegawai', 'pegawai');
        #$this->load->model('pengaturan/ModelUser', 'user');
        $queryNamaSatker = $this->model->get_konfigurasi('4');
        $queryLogoSatker = $this->model->get_konfigurasi('22');
        $queryNamaApp = $this->model->get_konfigurasi('1');
        $queryTitleApp = $this->model->get_konfigurasi('2');
        $this->session->set_userdata('nama_satker', $queryNamaSatker->row()->value);
        $this->session->set_userdata('logo_satker', 'assets/dokumen/' . $queryLogoSatker->row()->value);
        $this->session->set_userdata('nama_app', $queryNamaApp->row()->value);
        $this->session->set_userdata('title_app', $queryTitleApp->row()->value);
    }

    public function index()
    {
        $this->load->view('form_login');
    }

    public function proses_login()
    {
        $this->form_validation->set_rules('username', 'Username Pengguna', 'trim|required|max_length[18]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'max_length' => '%s Tidak Boleh Melebihi 18 Karakter']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('form_login', validation_errors());
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Ambil jumlah percobaan login dari sesi
        $login_attempts = $this->session->userdata('login_attempts') ? $this->session->userdata('login_attempts') : 0;

        if ($login_attempts >= 3) {
            $captcha_response = trim($this->input->post('g-recaptcha-response'));
            if ($captcha_response == '') {
                $this->session->set_flashdata('message', '1');
                redirect('login');
                return;
            }

            $keySecret = $this->config->item('captcha');
            $check = array('secret' => $keySecret, 'response' => $captcha_response);
            $startProcess = curl_init();

            curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($startProcess, CURLOPT_POST, true);
            curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));
            curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

            $receiveData = curl_exec($startProcess);

            if ($receiveData === false) {
                // Handle cURL error
                $this->session->set_flashdata('login_error', 'Gagal Login, Captcha belum di pilih');
                redirect('login');
                return;
            }

            $finalResponse = json_decode($receiveData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle JSON decode error
                $this->session->set_flashdata('login_error', 'Gagal Login, Captcha belum di pilih');
                redirect('login');
                return;
            }

            if (!$finalResponse['success']) {
                $this->session->set_flashdata('login_error', 'Gagal Login, Captcha belum di pilih');
                redirect('login');
                return;
            }
        }

        $queryUser = $this->model->get_seleksi_user('v_users', 'username', $username);

        if ($queryUser->num_rows() == 1) {
            $code = $queryUser->row()->code_activation;
            $pass = $queryUser->row()->password;

            $passHash = $this->hash_helper->arr2md5(array($code, $password));

            if ($pass == $passHash) {
                $this->session->sess_regenerate();

                $queryNamaSatker = $this->model->get_konfigurasi('4');
                $queryLogoSatker = $this->model->get_konfigurasi('22');
                $queryNamaApp = $this->model->get_konfigurasi('1');
                $queryKopSatker = $this->model->get_konfigurasi('15');

                $this->session->set_userdata([
                    'logged_in' => TRUE,
                    'logo_satker' => site_url('assets/dokumen/' . $queryLogoSatker->row()->value),
                    'kop_satker' => site_url('assets/dokumen/' . $queryKopSatker->row()->value),
                    'nama_app' => $queryNamaApp->row()->value,
                    'title' => $queryNamaApp->row()->value . ' ' . $queryNamaSatker->row()->value,
                ]);

                # Cek apakah user merupakan plh/plt
                $cekPlh = $this->model->get_seleksi('v_plh', 'pegawai_id', $queryUser->row()->pegawai_id);

                if ($cekPlh->num_rows() > 0) {
                    $this->session->set_userdata([
                        'userid' => $queryUser->row()->userid,
                        'fullname' => $queryUser->row()->fullname,
                        'id_plh' => $cekPlh->row()->plh_id_jabatan,
                        'plh_jabatan' => $cekPlh->row()->nama_jabatan
                    ]);

                    redirect('pilih_role');
                } else {
                    # Periksa apakah ada pegawai lain yang ditunjuk sebagai plh/plt dari jabatan anda
                    #die(var_dump($queryUser->row()->jab_id));
                    $cekPegawaiPlh = $this->model->get_seleksi('ref_plh', 'plh_id_jabatan', $queryUser->row()->jab_id);
                    if ($cekPegawaiPlh->row()->pegawai_id) {
                        $this->session->set_flashdata('pegawai_plh', '1');
                    }

                    $payload = [
                        'iss' => base_url(),
                        'userid' => $queryUser->row()->userid,
                        'status_plh' => '0',
                        'status_plt' => '0',
                        'iat' => time(),
                        'exp' => time() + 3600
                    ];

                    $cookie_domain = $this->config->item('cookie_domain');

                    $jwt = JWT::encode($payload, $this->jwt_key, 'HS256');
                    $redirect = isset($_COOKIE['redirect_to']) ? $_COOKIE['redirect_to'] : null;
                    setcookie('redirect_to', '', time() - 3600, "/", $cookie_domain);

                    setcookie(
                        'sso_token',
                        $jwt,
                        [
                            'expires' => time() + 3600,
                            'path' => '/',
                            'domain' => $cookie_domain, // pastikan subdomain
                            'secure' => false, // hanya jika HTTPS
                            'httponly' => true,
                            'samesite' => 'Lax', // atau 'Strict'
                        ]
                    );

                    $data_login = array(
                        'userid' => $queryUser->row()->userid,
                        'host_address' => $this->input->ip_address(),
                        'user_agent' => $this->input->user_agent()
                    );

                    $this->model->log_online($data_login);
                    $this->model->last_online($queryUser->row()->userid, array('last_login' => date('Y-m-d H:i:s')));

                    $this->session->set_userdata([
                        'userid' => $queryUser->row()->userid,
                        'fullname' => $queryUser->row()->fullname,
                        'username' => $queryUser->row()->username,
                        'jab_id' => $queryUser->row()->jab_id,
                        'jabatan' => $queryUser->row()->jabatan,
                        'foto' => site_url($queryUser->row()->foto),
                        'role' => $queryUser->row()->role
                    ]);

                    if ($queryUser->row()->userid == '1') {
                        $this->session->set_userdata('super', TRUE);
                    }

                    // Jika tidak ada redirect, arahkan ke dashboard sso
                    if ($redirect) {
                        $redirect_url = urldecode($redirect);
                        redirect($redirect_url);
                    } else {
                        redirect('/');
                    }
                }
            } else {
                $login_attempts++;
                if ($login_attempts >= 3) {
                    $this->session->set_flashdata('login_error', 'Gagal Login 3 kali, Silakan klik captcha sebelum login');
                } else {
                    $this->session->set_flashdata('login_error', 'Username atau Password Salah.');
                }
                $this->session->set_userdata('login_attempts', $login_attempts);
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('login_error', 'Username tidak ditemukan.');
            redirect('login');
        }
    }

    public function show_form()
    {
        $queryPegawai = $this->pegawai->pilih_pegawai_tamu();
        $pegawai = array();
        foreach ($queryPegawai->result() as $row) {
            $pegawai[$row->id] = $row->nama_gelar . ' || ' . $row->nama_jabatan;
        }

        $pegawai = form_dropdown('pegawai', $pegawai, '', 'class="form-select" required id="pegawai"');

        echo json_encode(
            array(
                'st' => 1,
                'pegawai' => $pegawai
            )
        );
        return;
    }

    public function pilih_role()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }

        $data['jabatan'] = $this->session->userdata('plh_jabatan');
        $data['fullname'] = $this->session->userdata('fullname');

        $this->load->view('halamanutama/pilihrole', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        delete_cookie('sso_token', '.ms-bandaaceh.local');
        $redirect = $this->input->get('redirect_to');
        redirect($redirect ?: base_url('login'));
    }

    public function role_plh()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('userid')));
        $queryUser = $this->model->get_seleksi('v_plh', 'plh_id_jabatan', $id);

        $queryPegawai = $this->model->get_seleksi('v_users', 'pegawai_id', $queryUser->row()->pegawai_id);
        $foto = $queryPegawai->row()->foto;

        $queryPlh = $this->utama->get_seleksi2('v_users', 'jab_id', $id, 'status_pegawai', '1');
        if ($queryPlh->num_rows() > 0) {
            // Plh = Pejabat ada tapi berhalangan hadir
            $userid = $queryPlh->row()->userid;
            $jabatan = "Plh " . $queryPlh->row()->jabatan;
            $role = $queryPlh->row()->role;
            $fullname = $queryUser->row()->nama_pegawai;
            $username = $queryPlh->row()->username;
            $plh = '1';
            $plt = '0';
            $this->session->set_userdata('status_plh', '1');
        } else {
            //Plt = Jabatan kosong (tidak ada pegawai yang menjabat)
            $cekJabatan = $this->model->get_seleksi('ref_jabatan', 'id', $id);
            $jabatan = "Plt " . $cekJabatan->row()->nama_jabatan;
            $role = $cekJabatan->row()->role;
            $userid = '-99';
            $fullname = $queryUser->row()->nama_pegawai;
            $username = $this->model->get_seleksi('v_users', 'userid', $id)->row()->username;
            $plh = '0';
            $plt = '1';
            $this->session->set_userdata('status_plt', '1');
        }

        $payload = [
            'iss' => base_url(),
            'userid' => $userid,
            'status_plh' => $plh,
            'status_plt' => $plt,
            'iat' => time(),
            'exp' => time() + 3600
        ];

        $cookie_domain = $this->config->item('cookie_domain');

        $jwt = JWT::encode($payload, $this->jwt_key, 'HS256');
        $redirect = isset($_COOKIE['redirect_to']) ? $_COOKIE['redirect_to'] : null;
        setcookie('redirect_to', '', time() - 3600, "/", $cookie_domain);

        setcookie(
            'sso_token',
            $jwt,
            [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => $cookie_domain, // pastikan subdomain
                'secure' => false, // hanya jika HTTPS
                'httponly' => true,
                'samesite' => 'Lax', // atau 'Strict'
            ]
        );

        $data_login = array(
            'userid' => $userid,
            'host_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        );
        $this->model->log_online($data_login);
        $this->model->last_online($userid, array('last_login' => date('Y-m-d H:i:s')));

        $this->session->set_userdata([
            'userid' => $userid,
            'fullname' => $fullname,
            'username' => $username,
            'jab_id' => $id,
            'jabatan' => $jabatan,
            'foto' => site_url($foto),
            'role' => $role
        ]);

        // Jika tidak ada redirect, arahkan ke dashboard sso
        if ($redirect) {
            $redirect_url = urldecode($redirect);
            redirect($redirect_url);
        } else {
            redirect('/');
        }
    }

    public function role_user()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('userid')));

        $queryUser = $this->model->get_seleksi_user('v_users', 'userid', $id);

        $payload = [
            'iss' => base_url(),
            'userid' => $queryUser->row()->userid,
            'status_plh' => '0',
            'status_plt' => '0',
            'iat' => time(),
            'exp' => time() + 3600
        ];

        $cookie_domain = $this->config->item('cookie_domain');

        $jwt = JWT::encode($payload, $this->jwt_key, 'HS256');
        $redirect = isset($_COOKIE['redirect_to']) ? $_COOKIE['redirect_to'] : null;
        setcookie('redirect_to', '', time() - 3600, "/", $cookie_domain);

        setcookie(
            'sso_token',
            $jwt,
            [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => $cookie_domain, // pastikan subdomain
                'secure' => false, // hanya jika HTTPS
                'httponly' => true,
                'samesite' => 'Lax', // atau 'Strict'
            ]
        );

        $data_login = array(
            'userid' => $queryUser->row()->userid,
            'host_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        );
        $this->model->log_online($data_login);
        $this->model->last_online($queryUser->row()->userid, array('last_login' => date('Y-m-d H:i:s')));

        $this->session->set_userdata([
            'userid' => $queryUser->row()->userid,
            'fullname' => $queryUser->row()->fullname,
            'jab_id' => $queryUser->row()->jab_id,
            'jabatan' => $queryUser->row()->jabatan,
            'foto' => site_url($queryUser->row()->foto),
            'role' => $queryUser->row()->role
        ]);

        // Jika tidak ada redirect, arahkan ke dashboard sso
        if ($redirect) {
            $redirect_url = urldecode($redirect);
            redirect($redirect_url);
        } else {
            redirect('/');
        }
    }

    public function simpan_tamu()
    {
        $this->form_validation->set_rules('nama_tamu', 'Nama Tamu', 'trim|required|max_length[40]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|max_length[40]');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|max_length[40]');
        $this->form_validation->set_rules('foto', 'Foto Diri', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'max_length' => '%s Tidak Boleh Melebihi 40 Karakter']);

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', validation_errors());
            $this->load->view('form_login');
            return;
        }

        $nama = strtoupper($this->input->post('nama_tamu'));
        $alamat = strtoupper($this->input->post('alamat'));
        $pekerjaan = $this->input->post('job');
        $tujuan = $this->input->post('tujuan');
        $pegawai = $this->input->post('pegawai');
        $foto = $this->input->post('foto');
        $ket = strtoupper($this->input->post('ket'));

        $queryPegawai = $this->model->get_seleksi('pegawai', 'id', $pegawai);
        $nama_gelar = $queryPegawai->row()->nama_gelar;

        $dataNotif = array(
            'jenis_pesan' => 'tamu',
            'pesan' => 'Assalamualaikum Wr. Wb., Yth. ' . $nama_gelar . ' Anda kedatangan tamu, atas nama ' . $nama . ' dari ' . $alamat . ' dengan tujuan berkunjung ' . $tujuan . '->' . $ket,
            'id_tujuan' => $pegawai,
            'created_by' => 'tamu',
            'created_on' => date('Y-m-d H:i:s')
        );

        $data = array(
            'pegawai_id' => $pegawai,
            'nama' => $nama,
            'pekerjaan' => $pekerjaan,
            'satker_alamat' => $alamat,
            'tgl_kunjungan' => date('Y-m-d H:i:s'),
            'tujuan_keperluan' => $tujuan,
            'foto_tamu' => $foto,
            'keterangan' => $ket,
            'created_on' => date('Y-m-d H:i:s')
        );

        $result = $this->model->tambahTamu($data, 'buku_tamu');
        $notif = $this->notif->tambahNotif($dataNotif, 'sys_notif');
        if ($result && $notif) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Data Tamu Berhasil dimasukkan, Selamat Datang ' . $nama);
            redirect('login');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Input Data Tamu, Periksa Kembali Data Anda');
            redirect('login');
        }
    }
}