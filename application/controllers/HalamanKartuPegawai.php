<?php

class HalamanKartuPegawai extends CI_Controller {
    public function kartu_pegawai($id) {
        $this->load->model('ModelUtama', 'model');

        $query = $this->model->get_seleksi('v_users', 'userid', $id);
        
        $data['foto'] = $query->row()->foto;
        $data['nip'] = $query->row()->nip;
        $data['nama'] = $query->row()->fullname;
        $data['jabatan'] = $query->row()->jabatan;
        //die(var_dump($data));
        $this->load->view('halamanutama/kartu_pegawai', $data);
    }
}