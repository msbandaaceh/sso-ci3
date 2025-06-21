<?php

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $regis
 * @property CI_Model $user
 * @property CI_Model $pegawai
 * @property CI_Model $jabatan
 * @property CI_Model $pangkat
 * @property CI_Model $pegawai
 * @property CI_Model $notif
 * @property CI_Upload $upload
 * @property CI_Encryption $encryption
 * @property CI_URI $uri
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */

class HalamanRegistrasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        #$this->load->model('ModelRegistrasi', 'reg');
        $this->load->model('ModelJabatan', 'jabatan');
        $this->load->model('pengaturan/ModelPegawai', 'pegawai');
        $this->load->model('pengaturan/ModelUser', 'user');
        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelRegistrasi', 'regis');
        $this->load->model('ModelPangkat', 'pangkat');
        $queryLogoSatker = $this->model->get_konfigurasi('22');
        $this->session->set_userdata('logo_satker', 'assets/dokumen/' . $queryLogoSatker->row()->value);
    }

    public function index()
    {
        $this->load->view('halamanregistrasi/regis');
    }

    public function cek_user()
    {
        if ($this->input->post('username')) {
            $username = $this->input->post('username');
            # Panggil fungsi dari model untuk memeriksa apakah username sudah dipakai
            $username_dipakai = $this->regis->cek_username($username);
            echo $username_dipakai ? 'false' : 'true';
        }
    }

    public function cek_nohp()
    {
        if ($this->input->post('nohp')) {
            $nohp = $this->input->post('nohp');
            # Panggil fungsi dari model untuk memeriksa apakah nomor handphone sudah dipakai
            $nohp_dipakai = $this->regis->cek_nohp($nohp);
            echo $nohp_dipakai ? 'false' : 'true';
        }
    }

    public function cek_jabatan()
    {
        $queryStruktural = $this->jabatan->get_jabatan_struktural();
        foreach ($queryStruktural as $item) {
            $str[] = $item->id;
        }

        if (in_array($this->input->post('jabatan'), $str)) {
            $jabatan = $this->input->post('jabatan');
            # Panggil fungsi dari model untuk memeriksa apakah jabatan ada yang mengisi
            $jabatan_terisi = $this->regis->cek_jabatan($jabatan);
            echo $jabatan_terisi ? 'false' : 'true';
        } else {
            echo 'true';
        }
    }

    public function validasi()
    {
        $this->form_validation->set_rules('nip', 'NIP Pengguna', 'trim|required|min_length[18]|max_length[18]');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'max_length' => '%s Tidak Boleh Melebihi 18 Karakter', 'min_length' => '%s Tidak Boleh Kurang Dari 18 Karakter']);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', validation_errors());
            $this->load->view('halamanregistrasi/regis');
            return;
        }

        $nip = $this->input->post('nip');

        $queryPegawai = $this->regis->cek_pegawai($nip);
        $cekPegawai = $queryPegawai->num_rows();

        if ($cekPegawai == 1) {
            $UserPegawai = $this->regis->cek_pegawai_user($nip);
            $cekUser = $UserPegawai->num_rows();
            if ($cekUser == 1) {
                $data['status'] = '2';
                $data['message'] = 'Pegawai sudah terdaftar dan memiliki akun. Silakan login.';
            } else {
                $data['status'] = '1';
                $data['id'] = $queryPegawai->row()->id;
                $data['nama'] = $queryPegawai->row()->nama_gelar;
                $data['message'] = 'Pegawai sudah terdaftar atas nama ' . $queryPegawai->row()->nama_gelar . ' namun belum memiliki akun. Silakan buat akun.';
                $data['nip'] = $nip;
            }
        } else {
            $data['nip'] = $nip;
            $data['status'] = '0';
            $data['message'] = 'Pegawai belum terdaftar. Silakan registrasi pegawai.';
        }

        $this->load->view('halamanregistrasi/regis_hasil', $data);
    }

    public function show_pegawai()
    {

        $queryJabatan = $this->jabatan->pilih_jabatan();
        $jabatan = array();
        $jabatan['0'] = "Pilih Jabatan";
        foreach ($queryJabatan->result() as $row) {
            if ($row->id > 0) {
                $jabatan[$row->id] = $row->nama_jabatan;
            }
        }

        $queryAtasan = $this->pegawai->pilih_atasan();
        $atasan = array();
        $atasan[''] = "Pilih Atasan Langsung";
        foreach ($queryAtasan->result() as $row) {
            $atasan[$row->id] = $row->nama_jabatan;
        }

        $queryPangkat = $this->pangkat->pilih_pangkat();
        $pangkat = array();
        $pangkat['0'] = "Pilih Pangkat Golongan";
        foreach ($queryPangkat->result() as $row) {
            $pangkat[$row->id] = $row->golongan . " | " . $row->pangkat;
        }

        $jenis = array('0' => "Pilih Jenis Pegawai", '1' => 'Hakim', '4' => 'Calon Hakim', '2' => 'PNS', '6' => 'PPPK', '3' => 'PPNPN');

        $atasan = form_dropdown('atasan', $atasan, '', 'class="form-select" id="atasan"');
        $jabatan = form_dropdown('jabatan', $jabatan, '', 'class="form-select" id="jabatan"');
        $jenis = form_dropdown('jenis', $jenis, '', 'class="form-select" id="jenis"');
        $pangkat = form_dropdown('pangkat', $pangkat, '', 'class="form-select" id="pangkat"');

        echo json_encode(
            array(
                'st' => 1,
                'jenis' => $jenis,
                'jabatan' => $jabatan,
                'atasan' => $atasan,
                'pangkat' => $pangkat
            )
        );
        return;
    }

    public function show_user()
    {
        $queryAtasan = $this->pegawai->pilih_atasan();
        $atasan = array();
        $atasan[''] = "Pilih Atasan Langsung";
        foreach ($queryAtasan->result() as $row) {
            $atasan[$row->id] = $row->nama_jabatan;
        }

        $atasan = form_dropdown('atasan', $atasan, '', 'class="form-select"  id="atasan"');

        echo json_encode(
            array(
                'st' => 1,
                'atasan' => $atasan
            )
        );
        return;
    }

    public function show_ppnpn()
    {

        $queryJabatan = $this->jabatan->pilih_jabatan();
        $jabatan = array();
        $jabatan['0'] = "Pilih Jabatan";
        foreach ($queryJabatan->result() as $row) {
            $jabatan[$row->id] = $row->nama_jabatan;
        }

        $queryAtasan = $this->pegawai->pilih_atasan();
        $atasan = array();
        $atasan[''] = "Pilih Atasan Langsung";
        foreach ($queryAtasan->result() as $row) {
            $atasan[$row->id] = $row->nama_jabatan;
        }

        $queryJenis = $this->pegawai->jenis_pegawai();
        $jenis = array();
        $jenis[''] = "Pilih Jenis Pegawai";
        foreach ($queryJenis->result() as $row) {
            $jenis[$row->id] = $row->group_jabatan;
        }

        $atasan = form_dropdown('atasan', $atasan, '', 'class="form-select"  id="atasan"');
        $jabatan = form_dropdown('jabatan', $jabatan, '', 'class="form-select" id="jabatan"');
        $jenis = form_dropdown('jenis', $jenis, '', 'class="form-select" id="jenis"');


        echo json_encode(
            array(
                'st' => 1,
                'jenis' => $jenis,
                'jabatan' => $jabatan,
                'atasan' => $atasan
            )
        );
        return;
    }

    public function simpan_ppnpn()
    {
        $this->form_validation->set_rules('nama_gelar', 'Nama (Dengan Gelar)', 'trim|required|max_length[60]');
        $this->form_validation->set_rules('nama', 'Nama (Tanpa Gelar)', 'trim|required|max_length[60]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('nohp', 'Nomor Handphone', 'trim|required|max_length[14]');
        $this->form_validation->set_rules('jenis', 'Jenis Pegawai', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        $this->form_validation->set_message([
            'required' => '%s Tidak Boleh Kosong',
            'valid_email' => '%s Tidak Sesuai Format',
            'min_length' => '%s Tidak Boleh Kurang Dari %s Karakter',
            'max_length' => '%s Tidak Boleh Lebih Dari %s Karakter'
        ]);

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', form_error('nama_gelar') . form_error('nama') . form_error('jabatan') . form_error('nohp') . form_error('jenis') . form_error('username') . form_error('password') . form_error('email') . 'Gagal Simpan, Periksa Kembali Form Input');
            redirect('reg', validation_errors());
            return;
        }

        $nama_gelar = strtoupper($this->input->post('nama_gelar'));
        $nama = strtoupper($this->input->post('nama'));
        $jabatan = $this->input->post('jabatan');
        $nohp = $this->input->post('nohp');
        $jenis = $this->input->post('jenis');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $atasan = $this->input->post('atasan');

        $dataPegawai = array(
            'nama_gelar' => $nama_gelar,
            'nama' => $nama,
            'jabatan_id' => $jabatan,
            'nohp' => $nohp,
            'jenis_pegawai' => $jenis,
            'diinput_oleh' => $nama_gelar,
            'diinput_tanggal' => date('Y-m-d H:i:s')
        );

        $querySimpan = $this->pegawai->tambah_pegawai($dataPegawai);
        if ($querySimpan == 1) {

            $code_activation = md5(uniqid());
            $password = $this->hash_helper->arr2md5(array($code_activation, $password));
            $activation = $this->hash_helper->arr2md5(array($nama_gelar, $username, $email));

            $queryPegawai = $this->pegawai->get_pegawai_by('nohp', $nohp);
            $id_pegawai = $queryPegawai->row()->id;

            $dataPengguna = array(
                'pegawai_id' => $id_pegawai,
                'fullname' => $nama_gelar,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'atasan_id' => $atasan,
                'code_activation' => $code_activation,
                'activation' => $activation,
                'created_by' => $nama_gelar,
                'created_on' => date('Y-m-d H:i:s')
            );

            $querySimpanUser = $this->user->tambah_pengguna($dataPengguna);

            if ($querySimpanUser == 1) {
                $this->session->set_flashdata('info', '1');
                $this->session->set_flashdata('pesan', 'Registrasi Pegawai dan Akun Berhasil di Buat, Silakan Login');
                redirect('login');
            } else {
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Gagal Buat Akun, ' . $querySimpan);
                redirect('reg');
            }
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Registrasi Pegawai Gagal, ' . $querySimpan);
            redirect('reg');
        }
    }

    public function simpan_pegawai()
    {
        $this->form_validation->set_rules('nama_gelar', 'Nama (Dengan Gelar)', 'trim|required|max_length[60]');
        $this->form_validation->set_rules('nama', 'Nama (Tanpa Gelar)', 'trim|required|max_length[60]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('nohp', 'Nomor Handphone', 'trim|required|max_length[14]');
        $this->form_validation->set_rules('jenis', 'Jenis Pegawai', 'trim|required');
        $this->form_validation->set_rules('pangkat', 'Pangkat Golongan', 'trim|required');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('surel', 'Email', 'trim|required|valid_email');

        $this->form_validation->set_message([
            'required' => '%s Tidak Boleh Kosong',
            'valid_email' => '%s Tidak Sesuai Format',
            'min_length' => '%s Tidak Boleh Kurang Dari %s Karakter',
            'max_length' => '%s Tidak Boleh Lebih Dari %s Karakter'
        ]);

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', validation_errors() . 'Gagal Simpan, Periksa Kembali Form Input');
            redirect('reg');
            return;
        }

        $nip = $this->input->post('nip');
        $nama_gelar = strtoupper($this->input->post('nama_gelar'));
        $nama = strtoupper($this->input->post('nama'));
        $jabatan = $this->input->post('jabatan');
        $nohp = $this->input->post('nohp');
        $jenis = $this->input->post('jenis');
        $password = $this->input->post('pass');
        $email = $this->input->post('surel');
        $atasan = $this->input->post('atasan');
        $pangkat = $this->input->post('pangkat');

        $dataPegawai = array(
            'nip' => $nip,
            'nama_gelar' => $nama_gelar,
            'nama' => $nama,
            'jabatan_id' => $jabatan,
            'golongan_id' => $pangkat,
            'nohp' => $nohp,
            'jenis_pegawai' => $jenis,
            'diinput_oleh' => $nama_gelar,
            'diinput_tanggal' => date('Y-m-d H:i:s')
        );
        $querySimpan = $this->pegawai->tambah_pegawai($dataPegawai);
        if ($querySimpan == 1) {

            $code_activation = md5(uniqid());
            $password = $this->hash_helper->arr2md5(array($code_activation, $password));
            $activation = $this->hash_helper->arr2md5(array($nama_gelar, $nip, $email));

            $queryPegawai = $this->pegawai->get_pegawai_by('nip', $nip);
            $id_pegawai = $queryPegawai->row()->id;

            $dataPengguna = array(
                'pegawai_id' => $id_pegawai,
                'fullname' => $nama_gelar,
                'username' => $nip,
                'password' => $password,
                'email' => $email,
                'atasan_id' => $atasan,
                'code_activation' => $code_activation,
                'activation' => $activation,
                'created_by' => $nama_gelar,
                'created_on' => date('Y-m-d H:i:s')
            );
            $querySimpanUser = $this->user->tambah_pengguna($dataPengguna);

            if ($querySimpanUser == 1) {
                $this->session->set_flashdata('info', '1');
                $this->session->set_flashdata('pesan', 'Registrasi Pegawai dan Akun Berhasil di Buat, Silakan Login');
                redirect('login');
            } else {
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Gagal Buat Akun, ' . $querySimpan);
                redirect('reg');
            }
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Registrasi Pegawai Gagal, ' . $querySimpan);
            redirect('reg');
        }
    }

    public function simpan_user()
    {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        $this->form_validation->set_message([
            'required' => '%s Tidak Boleh Kosong',
            'valid_email' => '%s Tidak Sesuai Format',
            'min_length' => '%s Tidak Boleh Kurang Dari %s Karakter'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', validation_errors() . 'Gagal Simpan, Periksa Kembali Form Input');
            redirect('reg');
            return;
        }

        $nip = $this->input->post('username');
        $fullname = $this->input->post('fullname');
        $id = $this->input->post('id');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $atasan = $this->input->post('atasan');

        $code_activation = md5(uniqid());
        $password = $this->hash_helper->arr2md5(array($code_activation, $password));
        $activation = $this->hash_helper->arr2md5(array($fullname, $nip, $email));

        $dataPengguna = array(
            'pegawai_id' => $id,
            'fullname' => $fullname,
            'username' => $nip,
            'password' => $password,
            'email' => $email,
            'atasan_id' => $atasan,
            'code_activation' => $code_activation,
            'activation' => $activation,
            'created_by' => $fullname,
            'created_on' => date('Y-m-d H:i:s')
        );
        $querySimpanUser = $this->user->tambah_pengguna($dataPengguna);

        if ($querySimpanUser == 1) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Registrasi Pegawai dan Akun Berhasil di Buat, Silakan Login');
            redirect('login');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Buat Akun, ' . $querySimpanUser);
            redirect('reg');
        }
    }
}