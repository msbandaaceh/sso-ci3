<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanPangkat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('ModelPangkat', 'pangkat');
        $this->load->model('ModelUtama', 'model');

        $token = $this->input->cookie('sso_token');
        if (!$token) {
            $this->session->sess_destroy();
        }

        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }
    }

    public function index()
    {
        $data['pangkat'] = $this->pangkat->all_pangkat_data();
        $data['page'] = 'daftar';
        $data['role'] = $this->session->userdata('role');

        $this->load->view('header', $data);
        $this->load->view('halamanpangkat/lis_pangkat');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('golongan', 'Golongan', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('pangkat', 'Pangkat', 'trim|required|max_length[30]');

        $this->form_validation->set_message('required', '%s Tidak Boleh Kosong');
        $this->form_validation->set_message('max_length', '%s Tidak Boleh Melebihi %s Karakter');

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', form_error('golongan') . form_error('pangkat') . 'Gagal Simpan Pangkat, Periksa Kembali Form Input Pangkat');
            redirect('daftar_pangkat', validation_errors());
            return;
        }

        $id = $this->input->post('id');
        $golongan = $this->input->post('golongan');
        $pangkat = strtoupper($this->input->post('pangkat'));

        if ($id) {
            $data = array(
                'golongan' => $golongan,
                'pangkat' => $pangkat,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );
            $querySimpan = $this->pangkat->update_pangkat($data, $id);
        } else {
            $data = array(
                'golongan' => $golongan,
                'pangkat' => $pangkat,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );
            $querySimpan = $this->pangkat->tambah_pangkat($data);
        }

        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            if ($id) {
                $this->session->set_flashdata('pesans', 'Golongan Pangkat Berhasil di Perbarui');
            } else {
                $this->session->set_flashdata('pesan', 'Golongan Pangkat Berhasil di Tambahkan');
            }
            redirect('daftar_pangkat');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
            redirect('daftar_pangkat');
        }
    }

    public function show()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $golongan = "";
        $pangkat = "";

        if ($id == '-1') {
            $judul = "TAMBAH DATA GOLONGAN PANGKAT";
            $id = '';
        } else {
            $judul = "EDIT DATA GOLONGAN PANGKAT";
            $query = $this->pangkat->get_seleksi_pangkat($id);

            $golongan = $query->row()->golongan;
            $pangkat = $query->row()->pangkat;
        }


        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => $id,
                'golongan' => $golongan,
                'pangkat' => $pangkat
            )
        );
        return;
    }

    public function hapus($idDecrypt)
    {
        $a = str_replace('___', '/', $this->uri->segment(2));
        $idDecrypt = $this->encryption->decrypt($a);

        $data = array(
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s'),
            'hapus' => '1'
        );

        $hapus = $this->model->pembaharuan_data('ref_pangkat', $data, 'id', $idDecrypt);

        if ($hapus) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Data Golongan Pangkat Berhasil di hapus');
            redirect('daftar_pangkat');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Data Golongan Pangkat Gagal di hapus, ' . $hapus);
            redirect('daftar_pangkat');
        }
    }
}