<?php

class HalamanUser extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('pengaturan/ModelPegawai', 'pegawai');
        $this->load->model('pengaturan/ModelUser', 'user');
        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelNotifikasi', 'notif');

        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }
    }

    public function index()
    {
        $data['user'] = $this->user->all_user_data();

        $this->load->view('halamanuser/header');
        $this->load->view('halamanuser/lis_user', $data);
        $this->load->view('halamanuser/footer');
    }

    public function get_pegawai_nip()
    {
        $id = $this->input->post('id');

        $queryPegawai = $this->model->get_seleksi('pegawai', 'id', $id);
        $nip = $queryPegawai->row()->nip;

        echo json_encode(
            array(
                'st' => 1,
                'nip' => $nip
            )
        );
        return;
    }

    public function show()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $queryPegawai = $this->pegawai->pilih_pegawai();
        $pegawai = array();
        $pegawai['0'] = "Pilih Pegawai";
        foreach ($queryPegawai->result() as $row) {
            $pegawai[$row->id] = $row->nama_gelar;
        }

        $queryAtasan = $this->pegawai->pilih_atasan();
        $atasan = array();
        $atasan[''] = "Pilih Atasan Langsung";
        foreach ($queryAtasan->result() as $row) {
            $atasan[$row->id] = $row->nama_jabatan;
        }

        $blok = array('2' => "Pilih", '1' => 'Ya', '0' => 'Tidak');

        $username = "";
        $email = "";
        $password = "";

        if ($id == '-1') {
            $id = '';
            $judul = "TAMBAH DATA PENGGUNA";
            $pegawai = form_dropdown('pegawai', $pegawai, '', 'class="form-select"  id="pegawai" onChange = "TampilUsername()"');
            $aktif = form_dropdown('blok', $blok, '', 'class="form-select"  id="blok"');
            $atasan = form_dropdown('atasan', $atasan, '', 'class="form-select"  id="atasan"');
        } else {
            $judul = "EDIT DATA PENGGUNA";
            $query = $this->model->get_seleksi('v_users', 'userid', $id);
            $id_pegawai = $query->row()->pegawai_id;
            $username = $query->row()->username;
            $email = $query->row()->email;
            $stat = $query->row()->block;
            $id_atasan = $query->row()->atasan_id;
            $password = "xxxx";

            $pegawai = form_dropdown('pegawai', $pegawai, $id_pegawai, 'class="form-select"  id="pegawai"');
            $atasan = form_dropdown('atasan', $atasan, $id_atasan, 'class="form-select"  id="atasan"');
            $aktif = form_dropdown('blok', $blok, $stat, 'class="form-select"  id="blok"');
        }

        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'id' => $id,
                'blok' => $aktif,
                'pegawai' => $pegawai,
                'atasan' => $atasan
            )
        );
        return;
    }

    public function simpan()
    {
        $password = $this->input->post('password');

        $this->form_validation->set_rules('pegawai', 'Pegawai', 'trim|required');
        if ($password != 'xxxx') {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_message('min_length', '%s Tidak Boleh Kurang Dari %s Karakter');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('blok', 'Status Blok User', 'trim|required');

        $this->form_validation->set_message('required', '%s Tidak Boleh Kosong');
        $this->form_validation->set_message('valid_email', '%s Tidak Sesuai Format');

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', form_error('pegawai') . form_error('password') . form_error('email') . form_error('stat') . 'Gagal Simpan User, Periksa Kembali Form Input User');
            redirect('daftar_user', validation_errors());
            return;
        }

        $id = $this->input->post('id');
        $id_pegawai = $this->input->post('pegawai');
        $username = $this->input->post('username');

        $email = $this->input->post('email');
        $stat = $this->input->post('blok');
        $id_atasan = $this->input->post('atasan');

        $queryPegawai = $this->model->get_seleksi('v_pegawai', 'id', $id_pegawai);
        $nama = $queryPegawai->row()->nama_gelar;

        if ($id) {
            if ($password == 'xxxx') {
                $dataPengguna = array(
                    'userid' => $id,
                    'pegawai_id' => $id_pegawai,
                    'fullname' => $nama,
                    'username' => $username,
                    'email' => $email,
                    'atasan_id' => $id_atasan,
                    'block' => $stat,
                    'modified_by' => $this->session->userdata('fullname'),
                    'modified_on' => date('Y-m-d H:i:s')
                );
            } else {
                $code_activation = md5(uniqid());
                $password = $this->hash_helper->arr2md5(array($code_activation, $password));
                $activation = $this->hash_helper->arr2md5(array($nama, $username, $email));
                $dataPengguna = array(
                    'userid' => $id,
                    'pegawai_id' => $id_pegawai,
                    'fullname' => $nama,
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'atasan_id' => $id_atasan,
                    'code_activation' => $code_activation,
                    'activation' => $activation,
                    'block' => $stat,
                    'modified_by' => $this->session->userdata('fullname'),
                    'modified_on' => date('Y-m-d H:i:s')
                );
            }

            $querySimpan = $this->user->update_pengguna($dataPengguna, $id);
        } else {
            $queryPengguna = $this->model->get_seleksi('v_users', 'pegawai_id', $id_pegawai);
            if ($queryPengguna->num_rows() > 0) {
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan', 'Gagal Simpan, Pegawai Sudah Terdaftar sebagai Pengguna ' . $id_pegawai);
                redirect('daftar_user');
            } else {
                $code_activation = md5(uniqid());
                $password = $this->hash_helper->arr2md5(array($code_activation, $password));
                $activation = $this->hash_helper->arr2md5(array($nama, $username, $email));
                $dataPengguna = array(
                    'userid' => $id,
                    'pegawai_id' => $id_pegawai,
                    'fullname' => $nama,
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'atasan_id' => $id_atasan,
                    'code_activation' => $code_activation,
                    'activation' => $activation,
                    'block' => $stat,
                    'created_by' => $this->session->userdata('username'),
                    'created_on' => date('Y-m-d H:i:s')
                );
                $querySimpan = $this->user->tambah_pengguna($dataPengguna);
            }
        }

        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            if ($id) {
                $this->session->set_flashdata('pesan', 'Pengguna Berhasil di Perbarui');
            } else {
                $this->session->set_flashdata('pesan', 'Pengguna Berhasil di Buat');
            }
            redirect('daftar_user');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
            redirect('daftar_user');
        }
    }

    public function reset_perangkat()
    {
        $a = str_replace('___', '/', $this->uri->segment(2));
        $idDecrypt = $this->encryption->decrypt($a);

        $dataPengguna = array(
            'ip_add' => '',
            'token_pres' => '',
            'modified_by' => $this->session->userdata('username'),
            'modified_on' => date('Y-m-d H:i:s')
        );

        $resetPengguna = $this->user->reset_perangkat($dataPengguna, $idDecrypt);
        if ($resetPengguna) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Data Perangkat Pengguna Berhasil di Reset, Silakan melakukan perekaman kembali');
            redirect('daftar_user');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Data Pengguna Gagal di reset');
            redirect('daftar_user');
        }
    }
}