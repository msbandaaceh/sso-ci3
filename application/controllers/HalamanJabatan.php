<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $jabatan
 * @property CI_URI $uri
 * @property CI_Encryption $encryption
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */
class HalamanJabatan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('ModelJabatan', 'jabatan');
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
        $data['jabatan'] = $this->jabatan->all_jabatan_data();
        $data['page'] = 'daftar';
        $data['role'] = $this->session->userdata('role');

        $this->load->view('header', $data);
        $this->load->view('halamanjabatan/lis_jabatan');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('struktural', 'Status Jabatan Struktural', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'max_length' => '%s Tidak Boleh Melebihi 100 Karakter']);

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', validation_errors());
            redirect('daftar_jabatan');
        }

        $id = $this->input->post('id');
        $nama_jabatan = strtoupper($this->input->post('nama_jabatan'));
        $struktural = $this->input->post('struktural');
        $role = $this->input->post('peran');

        if ($id) {
            $data = array(
                'nama_jabatan' => $nama_jabatan,
                'struktural' => $struktural,
                'role' => $role,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );
            $querySimpan = $this->jabatan->update_jabatan($data, $id);
        } else {
            $data = array(
                'nama_jabatan' => $nama_jabatan,
                'struktural' => $struktural,
                'role' => $role,
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
        $struktural = array('' => "Pilih", '1' => 'Ya', '0' => 'Tidak');
        $role = [
            '' => 'Pilih Peran Jabatan',
            'admin_satker' => 'Administrator Satuan Kerja',
            'validator_uk_satker' => 'Validator Bagian Umum dan Keuangan',
            'validator_kepeg_satker' => 'Validator Bagian Kepegawaian',
            'validator_ptip_satker' => 'Validator Bagian PTIP',
        ];


        if ($id == '-1') {
            $judul = "TAMBAH DATA JABATAN";
            $id = '';
            $jenis = form_dropdown('struktural', $struktural, '', 'class="form-select" id="struktural"');
            $role_ = form_dropdown('peran', $role, '', 'class="form-select" id="peran"');
        } else {
            $judul = "EDIT DATA JABATAN";
            $query = $this->model->get_seleksi('ref_jabatan', 'id', $id);

            $nama_jabatan = $query->row()->nama_jabatan;
            $struktural_ = $query->row()->struktural;
            $peran = $query->row()->role;
            $jenis = form_dropdown('struktural', $struktural, $struktural_, 'class="form-select" id="struktural"');
            $role_ = form_dropdown('peran', $role, $peran, 'class="form-select" id="peran"');
        }


        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => $id,
                'peran' => $role_,
                'struktural' => $jenis,
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