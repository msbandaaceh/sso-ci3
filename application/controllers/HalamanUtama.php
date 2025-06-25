<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Model $model
 * @property CI_Session $session
 */

class HalamanUtama extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('ModelUtama', 'model');
        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }
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
        $data['role'] = $this->session->userdata('role');

        $this->load->view('header', $data);
        $this->load->view('halamanutama/dashboard');
    }
}