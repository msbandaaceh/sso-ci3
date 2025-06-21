<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

        $this->load->view('halamanutama/header');
        $this->load->view('halamanutama/dashboard', $data);
    }

    public function get_user_data()
    {
        $this->load->view('halamanutama/header');
        $this->load->view('halamanutama/user');
        $this->load->view('halamanutama/footer');
    }

    public function get_list_user()
    {

        $data['user'] = $this->model->all_user_data();

        $this->load->view('halamanutama/header');
        $this->load->view('lis_user', $data);
        $this->load->view('halamanutama/footer');
    }
}