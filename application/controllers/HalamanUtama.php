<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Model $model
 * @property CI_Session $session
 * @property CI_Input $input
 */

class HalamanUtama extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('ModelUtama', 'model');
        $token = $this->input->cookie('sso_token');
        if (!$token) {
            $this->session->sess_destroy();
        }

        #die(var_dump($this->session->all_userdata()));
    }

    public function index()
    {
        $data['jwt'] = $this->session->userdata('jwt');

        $query = $this->model->get_data('ref_client_app');
        $hasil = [];
        foreach ($query->result() as $i => $item) {
            $hasil[] = $item->nama_app;
        }
        #die(var_dump($hasil));

        $data['hasil'] = $hasil;
        $data['page'] = 'dashboard';

        if (!$this->session->userdata('logged_in')) {
            $this->load->model('ModelLogin', 'model');
            
            $data['nama_satker'] = $this->model->get_konfigurasi('4')->row()->value;
            $data['logo_satker'] = 'assets/dokumen/' . $this->model->get_konfigurasi('22')->row()->value;
            $data['nama_app'] = $this->model->get_konfigurasi('1')->row()->value;
            $data['title_app'] = $this->model->get_konfigurasi('2')->row()->value;
            $this->load->view('halamanutama/landing_page', $data);
        } else {
            $data['role'] = $this->session->userdata('role');
            $this->load->view('header', $data);
            $this->load->view('halamanutama/dashboard');
        }
    }
}