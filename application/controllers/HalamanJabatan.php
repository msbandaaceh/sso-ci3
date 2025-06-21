<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanJabatan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('ModelJabatan', 'jabatan');
        $this->load->model('ModelUtama', 'model');

        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }

    }
    public function index()
    {
        $data['jabatan'] = $this->jabatan->all_jabatan_data();

        $this->load->view('halamanjabatan/header');
        $this->load->view('halamanjabatan/lis_jabatan', $data);
        $this->load->view('halamanjabatan/footer');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'trim|required|max_length[100]');

        $this->form_validation->set_message('required', '%s Tidak Boleh Kosong');
        $this->form_validation->set_message('max_length', '%s Tidak Boleh Melebihi 100 Karakter');

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan_gagal', 'Gagal Simpan Jabatan, ' . form_error('nama_jabatan'));
            redirect('daftar_jabatan', validation_errors());
            return;
        }

        $id = $this->input->post('id');
        $nama_jabatan = strtoupper($this->input->post('nama_jabatan'));

        if ($id) {
            $data = array(
                'nama_jabatan' => $nama_jabatan,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );
            $querySimpan = $this->jabatan->update_jabatan($data, $id);
        } else {
            $data = array(
                'nama_jabatan' => $nama_jabatan,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $querySimpan = $this->jabatan->tambah_jabatan($data);
        }

        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            if ($id) {
                $this->session->set_flashdata('pesan', 'Jabatan Berhasil di Perbarui');
            } else {
                $this->session->set_flashdata('pesan', 'Jabatan Berhasil di Tambahkan');
            }
            redirect('daftar_jabatan');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
            redirect('daftar_jabatan');
        }
    }

    public function show()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $nama_jabatan = "";

        if ($id == '-1') {
            $judul = "TAMBAH DATA JABATAN";
            $id = '';
        } else {
            $judul = "EDIT DATA JABATAN";
            $query = $this->model->get_seleksi('ref_jabatan', 'id', $id);

            $nama_jabatan = $query->row()->nama_jabatan;
        }


        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => $id,
                'nama_jabatan' => $nama_jabatan
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

        $hapus = $this->model->pembaharuan_data('ref_jabatan', $data, 'id', $idDecrypt);
        if ($hapus) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Data Jabatan Berhasil di hapus');
            redirect('daftar_jabatan');
        } else {
            $this->session->set_flashdata('info', '0');
            $this->session->set_flashdata('pesan', 'Data Jabatan Gagal di hapus, ' . $hapus);
            redirect('daftar_jabatan');
        }
    }
}