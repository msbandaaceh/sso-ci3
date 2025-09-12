<?php

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $pegawai
 * @property CI_Model $jabatan
 * @property CI_Model $pangkat
 * @property CI_Model $pegawai
 * @property CI_Model $notif
 * @property CI_Upload $upload
 * @property CI_Encryption $encryption
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */

class HalamanPegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('pengaturan/ModelPlh', 'plh');
        $this->load->model('pengaturan/ModelPegawai', 'pegawai');
        $this->load->model('pengaturan/ModelUser', 'user');
        $this->load->model('ModelJabatan', 'jabatan');
        $this->load->model('ModelPangkat', 'pangkat');
        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelNotifikasi', 'notif');
        $this->load->library('image_lib');
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
        $data['pegawai'] = $this->pegawai->all_pegawai_data();
        $data['page'] = 'daftar';
        $data['role'] = $this->session->userdata('role');
        $data['userid'] = $this->session->userdata('userid');

        $this->load->view('header', $data);
        $this->load->view('halamanpegawai/lis_pegawai');
    }

    public function show()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $queryJabatan = $this->jabatan->pilih_jabatan();
        $jabatan = array();
        $jabatan['0'] = "Pilih Jabatan";
        foreach ($queryJabatan->result() as $row) {
            $jabatan[$row->id] = $row->nama_jabatan;
        }

        $queryGolongan = $this->pangkat->pilih_pangkat();
        $golongan = array();
        $golongan['0'] = "Pilih Pangkat Golongan";
        foreach ($queryGolongan->result() as $row) {
            $golongan[$row->id] = $row->golongan . " | " . $row->pangkat;
        }

        $queryJenis = $this->pegawai->jenis_pegawai();
        $jenis = array();
        $jenis['0'] = "Pilih Jenis Pegawai";
        foreach ($queryJenis->result() as $row) {
            $jenis[$row->id] = $row->group_jabatan;
        }

        $blok = array('2' => "Pilih Status Pegawai", '1' => 'Aktif', '0' => 'Tidak Aktif');
        $jk = array('0' => "Pilih Jenis Kelamin Pegawai", '1' => 'Pria', '2' => 'Wanita');

        $nip = "";
        $nama_gelar = "";
        $nama = "";
        $alamat = "";
        $jab_id = "";
        $nohp = "";
        $ket = "";
        $gol_id = "";
        $foto = "";
        $tmt = "";
        $ttd = "";

        if ($id == '-1') {
            $id = '';
            $judul = "TAMBAH DATA PEGAWAI";
            $queryGolongan = $this->pangkat->pilih_pangkat();
            $golongan = array();
            $golongan['0'] = "Pilih Pangkat Golongan";
            foreach ($queryGolongan->result() as $row) {
                $golongan[$row->id] = $row->golongan . " | " . $row->pangkat;
            }
            $golongan = form_dropdown('pangkat', $golongan, '', 'class="form-select" id="pangkat"');
            $jabatan = form_dropdown('jabatan', $jabatan, '', 'class="form-select" id="jabatan"');
            $aktif = form_dropdown('stat', $blok, '', 'class="form-select" id="aktif"');
            $jenis = form_dropdown('jenis', $jenis, '', 'class="form-select" id="jenis"');
            $jk_peg = form_dropdown('jk', $jk, '', 'class="form-select" id="jk"');
        } else {
            $judul = "EDIT DATA PEGAWAI";
            $queryPegawai = $this->model->get_seleksi('v_pegawai', 'id', $id);
            $nip = $queryPegawai->row()->nip;
            $nama_gelar = $queryPegawai->row()->nama_gelar;
            $nama = $queryPegawai->row()->nama;
            $alamat = $queryPegawai->row()->alamat;
            $nohp = $queryPegawai->row()->nohp;
            $ket = $queryPegawai->row()->ket;
            $jab_id = $queryPegawai->row()->jab_id;
            $gol_id = $queryPegawai->row()->gol_id;
            $stat = $queryPegawai->row()->status_pegawai;
            $grup = $queryPegawai->row()->id_grup;
            $foto = $queryPegawai->row()->foto;
            $ttd = $queryPegawai->row()->ttd;
            $tmt = $queryPegawai->row()->tmt;
            $jenkel = $queryPegawai->row()->jk;
            $jabatan = form_dropdown('jabatan', $jabatan, $jab_id, 'class="form-select" id="jabatan"');
            $golongan = form_dropdown('pangkat', $golongan, $gol_id, 'class="form-select" id="pangkat"');
            $aktif = form_dropdown('stat', $blok, $stat, 'class="form-select" id="aktif"');
            $jenis = form_dropdown('jenis', $jenis, $grup, 'class="form-select" id="jenis"');
            $jk_peg = form_dropdown('jk', $jk, $jenkel, 'class="form-select" id="jk"');
        }

        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => $id,
                'nip' => $nip,
                'nama_gelar' => $nama_gelar,
                'nama' => $nama,
                'alamat' => $alamat,
                'nohp' => $nohp,
                'ket' => $ket,
                'foto' => $foto,
                'ttd' => $ttd,
                'tmt' => $tmt,
                'jk' => $jk_peg,
                'aktif' => $aktif,
                'jenis' => $jenis,
                'jabatan' => $jabatan,
                'pangkat' => $golongan
            )
        );
        return;
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'trim|max_length[18]');
        $this->form_validation->set_rules('nama_gelar', 'Nama Dengan Gelar', 'trim|required|max_length[75]');
        $this->form_validation->set_rules('nama', 'Nama Tanpa Gelar', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|max_length[50]');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|max_length[50]');
        $this->form_validation->set_rules('nohp', 'Nomor HP', 'trim|required|max_length[15]');
        $this->form_validation->set_rules('stat', 'Status Pegawai', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis Pegawai', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'max_length' => '%s Tidak Boleh Melebihi %s Karakter']);

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', form_error('nip') . form_error('nama_gelar') . form_error('nama') . form_error('pangkat') . form_error('jabatan') . form_error('alamat') . form_error('ket') . form_error('nohp') . form_error('stat') . 'Gagal Simpan Pegawai, Periksa Kembali Form Input Pegawai');
            redirect('daftar_pegawai', validation_errors());
            return;
        }

        $id = $this->input->post('id');
        $nip = $this->input->post('nip');
        $nama_gelar = strtoupper($this->input->post('nama_gelar'));
        $nama = strtoupper($this->input->post('nama'));
        $pangkat = $this->input->post('pangkat');
        $jabatan = $this->input->post('jabatan');
        $alamat = strtoupper($this->input->post('alamat'));
        $ket = $this->input->post('ket');
        $nohp = $this->input->post('nohp');
        $stat = $this->input->post('stat');
        $jenis = $this->input->post('jenis');
        $tmt = $this->input->post('tmt');
        $jk = $this->input->post('jk');

        if ($tmt == "") {
            $tmt = NULL;
        }

        if (!$id) {
            $cekPegawaiExist = $this->model->get_seleksi('v_pegawai', 'nip', $nip);
            if ($cekPegawaiExist->num_rows() > 0) {
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan', 'Pegawai sudah terdaftar, cek kembali daftar pegawai');
                redirect('daftar_pegawai', validation_errors());
                return;
            }
        }

        // Konfigurasi untuk upload foto
        $config_foto['upload_path'] = 'assets/dokumen/foto/';
        $config_foto['allowed_types'] = 'png';
        $config_foto['max_size'] = 1024 * 5;
        $config_foto['encrypt_name'] = FALSE;

        // Konfigurasi untuk upload tanda tangan
        $config_ttd['upload_path'] = 'assets/dokumen/ttd/';
        $config_ttd['allowed_types'] = 'png';
        $config_ttd['max_size'] = 1024 * 5;
        $config_ttd['encrypt_name'] = FALSE;

        $this->load->library('upload');

        // Inisialisasi variabel file path
        $file_path_foto = '';
        $file_path_ttd = '';

        // Upload foto jika ada
        if (!empty($_FILES['foto']['name'])) {
            $this->upload->initialize($config_foto);
            if (!$this->upload->do_upload('foto')) {
                $error = $this->upload->display_errors();
                $file_path_foto = $error;
            } else {
                $data = $this->upload->data();
                $file_path_foto = 'assets/dokumen/foto/' . $data['file_name'];

                // Konversi ke WebP
                $webp_path = 'assets/dokumen/foto/' . pathinfo($data['file_name'], PATHINFO_FILENAME) . '.webp';
                $source_image = imagecreatefrompng($file_path_foto);
                imagewebp($source_image, $webp_path);
                imagedestroy($source_image);
                unlink($file_path_foto);
                $file_path_foto = $webp_path;

                // Resize foto
                $resize_config['image_library'] = 'gd2';
                $resize_config['source_image'] = $file_path_foto;
                $resize_config['maintain_ratio'] = TRUE;
                $resize_config['width'] = 100;
                $resize_config['height'] = 100;

                $this->load->library('image_lib', $resize_config);
                $this->image_lib->resize();
            }
        }

        // Upload tanda tangan jika ada
        if (!empty($_FILES['ttd']['name'])) {
            $this->upload->initialize($config_ttd);
            if (!$this->upload->do_upload('ttd')) {
                $error = $this->upload->display_errors();
                $file_path_ttd = $error;
            } else {
                $data = $this->upload->data();
                $file_path_ttd = 'assets/dokumen/ttd/' . $data['file_name'];
            }
        }

        if (!empty($file_path_foto) && !empty($file_path_ttd)) {
            $dataPegawai = array(
                'nip' => $nip,
                'nama_gelar' => $nama_gelar,
                'nama' => $nama,
                'golongan_id' => $pangkat,
                'jabatan_id' => $jabatan,
                'alamat' => $alamat,
                'keterangan' => $ket,
                'nohp' => $nohp,
                'foto' => $file_path_foto,
                'ttd' => $file_path_ttd,
                'tmt' => $tmt,
                'jk' => $jk,
                'status_pegawai' => $stat,
                'jenis_pegawai' => $jenis
            );
        } else {
            // Update data jika foto diupload
            if (!empty($file_path_foto)) {
                $dataPegawai = array(
                    'nip' => $nip,
                    'nama_gelar' => $nama_gelar,
                    'nama' => $nama,
                    'golongan_id' => $pangkat,
                    'jabatan_id' => $jabatan,
                    'alamat' => $alamat,
                    'keterangan' => $ket,
                    'nohp' => $nohp,
                    'tmt' => $tmt,
                    'jk' => $jk,
                    'status_pegawai' => $stat,
                    'foto' => $file_path_foto,
                    'jenis_pegawai' => $jenis
                );
            }

            // Update data jika tanda tangan diupload
            if (!empty($file_path_ttd)) {
                $dataPegawai = array(
                    'nip' => $nip,
                    'nama_gelar' => $nama_gelar,
                    'nama' => $nama,
                    'golongan_id' => $pangkat,
                    'jabatan_id' => $jabatan,
                    'alamat' => $alamat,
                    'keterangan' => $ket,
                    'nohp' => $nohp,
                    'tmt' => $tmt,
                    'jk' => $jk,
                    'status_pegawai' => $stat,
                    'ttd' => $file_path_ttd,
                    'jenis_pegawai' => $jenis
                );

                $this->session->set_userdata('ttd', $file_path_ttd);
            }

            if (empty($file_path_foto) && empty($file_path_ttd)) {
                $dataPegawai = array(
                    'nip' => $nip,
                    'nama_gelar' => $nama_gelar,
                    'nama' => $nama,
                    'golongan_id' => $pangkat,
                    'jabatan_id' => $jabatan,
                    'alamat' => $alamat,
                    'keterangan' => $ket,
                    'nohp' => $nohp,
                    'tmt' => $tmt,
                    'jk' => $jk,
                    'status_pegawai' => $stat,
                    'jenis_pegawai' => $jenis
                );
            }
        }

        if ($id) {
            $queryStruktural = $this->jabatan->get_jabatan_struktural();
            foreach ($queryStruktural as $item) {
                $str[] = $item->id;
            }
            if (in_array($jabatan, $str)) {
                $cekJabatan = $this->pegawai->cek_jabatan_pegawai($jabatan, $id)->num_rows();
            } else {
                $cekJabatan = 0;
            }

            #die(var_dump($cekJabatan));
            if ($cekJabatan > 0) {
                $querySimpan = "Ada Pegawai Aktif Menjabat Jabatan Yang Anda Pilih, Silakan Cek Kembali";
            } else {
                $dataPegawai += array(
                    'diperbaharui_oleh' => $this->session->userdata('fullname'),
                    'diperbaharui_tanggal' => date('Y-m-d H:i:s')
                );
                $queryPegawai = $this->model->get_seleksi('pegawai', 'id', $id);
                $cur_stat = $queryPegawai->row()->status_pegawai;
                //die(var_dump($cur_stat . ' & ' . $stat));
                if ($cur_stat != $stat) {
                    if ($stat == '0') {
                        $dataNotif = array(
                            'jenis_pesan' => 'user',
                            'id_pemohon' => $this->session->userdata("userid"),
                            'pesan' => 'Anda telah diberhentikan sebagai pengguna LITERASI MS BANDA ACEH karena Mutasi/Pensiun. Terima Kasih atas Pengabdian, sampai jumpa di lain hari.',
                            'id_tujuan' => $id,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    } else {
                        $dataNotif = array(
                            'jenis_pesan' => 'user',
                            'id_pemohon' => $this->session->userdata("userid"),
                            'pesan' => 'Anda telah diaktifkan kembali sebagai pengguna LITERASI MS BANDA ACEH. Selamat datang kembali, mari berjuang bersama.',
                            'id_tujuan' => $id,
                            'created_by' => $this->session->userdata('fullname'),
                            'created_on' => date('Y-m-d H:i:s')
                        );
                    }

                    $this->notif->tambahNotif($dataNotif, 'sys_notif');
                }

                $querySimpan = $this->model->pembaharuan_data('pegawai', $dataPegawai, 'id', $id);
            }
        } else {
            $queryStruktural = $this->jabatan->get_jabatan_struktural();
            foreach ($queryStruktural as $item) {
                $str[] = $item->id;
            }
            if (in_array($jabatan, $str)) {
                $cekJabatan = $this->pegawai->cek_jabatan_baru_pegawai($jabatan)->num_rows();
            } else {
                $cekJabatan = 0;
            }

            //die(var_dump($cekJabatan->num_rows()));
            if ($cekJabatan > 0) {
                $querySimpan = "Ada Pegawai Aktif Menjabat Jabatan Yang Anda Pilih, Silakan Cek Kembali";
            } else {
                $dataPegawai += array(
                    'diinput_oleh' => $this->session->userdata('fullname'),
                    'diinput_tanggal' => date('Y-m-d H:i:s')
                );

                $querySimpan = $this->pegawai->tambah_pegawai($dataPegawai);
            }
        }

        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            if ($id) {
                $this->session->set_flashdata('pesan', 'Pegawai Berhasil di Perbarui');
            } else {
                $this->session->set_flashdata('pesan', 'Pegawai Berhasil di Tambahkan');
            }
            redirect('daftar_pegawai');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
            redirect('daftar_pegawai');
        }
    }
}