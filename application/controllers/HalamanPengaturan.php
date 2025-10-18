<?php

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $plh
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

class HalamanPengaturan extends CI_Controller
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
        $token = $this->input->cookie('sso_token');
        if (!$token) {
            $this->session->sess_destroy();
        }
        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }
    }

    #                                #   
    #   PENGATURAN PLH/PLT PEGAWAI   #
    #                                #

    public function get_plh_data()
    {
        $data['plh_data'] = $this->plh->plh_data();
        $data["page"] = 'plh';
        $data['userid'] = $this->session->userdata('userid');
        $data['role'] = $this->session->userdata('role');
        $data['plh'] = $this->session->userdata('status_plh');
        $data['plt'] = $this->session->userdata('status_plt');


        $this->load->view('header', $data);
        $this->load->view('halamanpengaturan/plh');
        $this->load->view('footer');
    }

    public function edit_plh()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $queryPegawai = $this->model->get_seleksi('v_pegawai', 'status_pegawai', '1');
        $pegawai = array();
        $pegawai[''] = "Pilih Pegawai";
        foreach ($queryPegawai->result() as $row) {
            $pegawai[$row->id] = $row->nama_gelar;
        }

        $judul = "EDIT DATA PLH";
        $query = $this->model->get_seleksi('ref_plh', 'id', $id);
        $id_pegawai = $query->row()->pegawai_id;

        $pegawai = form_dropdown('pegawai', $pegawai, $id_pegawai, 'class="select2"  id="pegawai"');

        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => base64_encode($this->encryption->encrypt($id)),
                'pegawai' => $pegawai
            )
        );
        return;
    }

    public function simpan_plh()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $pegawai = $this->input->post('pegawai');
        //die(var_dump($id .' + '. $pegawai));

        $cekPlh = $this->model->get_seleksi('v_plh', 'pegawai_id', $pegawai);
        if ($cekPlh->num_rows() > 0) {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan Plh, Pegawai yang ditunjuk sudah menjadi Plh untuk Jabatan lain');
            redirect('plh');
        } else {
            $dataPlh = array(
                'pegawai_id' => $pegawai,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );
            $querySimpan = $this->plh->update_plh($dataPlh, $id);

            if ($querySimpan == 1) {
                $dataPPlh = $this->model->get_seleksi('v_plh', 'id', $id);

                $dataNotif = array(
                    'jenis_pesan' => 'plh',
                    'id_pemohon' => $this->session->userdata("id_pegawai"),
                    'pesan' => 'Anda telah ditunjuk menjadi Plh ' . $dataPPlh->row()->nama_jabatan . '. Silakan login Plh menggunakan akun pribadi.',
                    'id_tujuan' => $pegawai,
                    'created_by' => $this->session->userdata('fullname'),
                    'created_on' => date('Y-m-d H:i:s')
                );

                $this->notif->tambahNotif($dataNotif, 'sys_notif');

                $this->session->set_flashdata('info', '1');
                $this->session->set_flashdata('pesan', 'Plh Berhasil di Pilih');
                redirect('plh');
            } else {
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
                redirect('plh');
            }
        }
    }

    public function hapus_plh($id)
    {
        $a = str_replace('___', '/', $this->uri->segment(2));
        $id = $this->encryption->decrypt($a);
        //die(var_dump($id_atasan));

        $dataPlh = array(
            'pegawai_id' => null,
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        );
        $querySimpan = $this->plh->update_plh($dataPlh, $id);

        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Plh Berhasil di Hapus');
            redirect('plh');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Hapus, ' . $querySimpan);
            redirect('plh');
        }
    }

    public function hapus_plh_js()
    {
        $id = $this->session->userdata('userid');
        $jab_id = $this->model->get_seleksi('v_users', 'userid', $id)->row()->jab_id;
        $dataPlh = array(
            'pegawai_id' => null,
            'modified_by' => $this->session->userdata('fullname'),
            'modified_on' => date('Y-m-d H:i:s')
        );
        $querySimpan = $this->model->pembaharuan_data('ref_plh', $dataPlh, 'plh_id_jabatan', $jab_id);

        if ($querySimpan == 1) {
            echo json_encode(
                array(
                    'st' => 1
                )
            );
        } else {
            echo json_encode(
                array(
                    'st' => 0
                )
            );
        }

        return;
    }

    #                                #   
    #   PENGATURAN PLH/PLT PEGAWAI   #
    #                                #

    #                             #
    #   PENGATURAN USER PEGAWAI   #
    #                             #

    public function get_user_data()
    {
        $plt = $this->session->userdata('status_plt');
        $role = $this->session->userdata('role');
        if ($plt != '1') {
            $id = $this->session->userdata('userid');

            $queryUser = $this->user->get_user_data($id);
            $data['atasan'] = $this->pegawai->atasan_aktif();
            $data['page'] = 'user';
            $data['role'] = $role;
            $data['plh'] = $this->session->userdata('status_plh');
            $data['plt'] = $plt;

            $data['userid'] = $queryUser[0]->userid;
            $data['atasan_id'] = $queryUser[0]->atasan_id;
            $data['email'] = $queryUser[0]->email;

        } else {
            if ($role != 'admin_satker' || $role != 'validator_kepeg_satker') {
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan', 'Anda tidak memiliki otoriasi untuk membuka menu ini, hanya untuk Admin Satker dan Kepegawaian Satker');
                redirect('/');
            }
        }

        $this->load->view('header', $data);
        $this->load->view('halamanpengaturan/user');
        $this->load->view('footer');

    }

    public function simpan_data_user()
    {
        $password = $this->input->post('password');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($password != 'xxxx') {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_message(['min_length' => '%s Tidak Boleh Kurang Dari %s Karakter']);
        }

        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'valid_email' => '%s Tidak Sesuai Format'], );

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', form_error('password') . form_error('email') . 'Gagal Simpan User, Periksa Kembali Form Input User');
            redirect('user', validation_errors());
            return;
        }

        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $email = $this->input->post('email');
        $id_atasan = $this->input->post('atasan');

        if ($password == "xxxx") {
            //die(var_dump("masuk disini"));
            $dataPengguna = array(
                'email' => $email,
                'atasan_id' => $id_atasan,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );
        } else {
            //$activation = $this->arr2md5(array($nama, $username, $email));
            $code_activation = md5(uniqid());
            $password = $this->hash_helper->arr2md5(array($code_activation, $password));
            //die(var_dump("masuk nang kene"));
            $dataPengguna = array(
                'password' => $password,
                'email' => $email,
                'atasan_id' => $id_atasan,
                'code_activation' => $code_activation,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );
        }

        $querySimpan = $this->model->pembaharuan_data('sys_users', $dataPengguna, 'userid', $id);
        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Pengguna Berhasil di Perbarui');
            redirect('user');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
            redirect('user');
        }
    }

    #                             #
    #   PENGATURAN USER PEGAWAI   #
    #                             #


    #                               #
    #   PENGATURAN PROFIL PEGAWAI   #
    #                               #

    public function get_profil_data()
    {
        if ($this->session->userdata('status_plt') == '1' || $this->session->userdata('status_plh') == '1') {
            $queryPlh = $this->model->get_seleksi('v_plh', 'plh_id_jabatan', $this->session->userdata('id_jabatan'));
            if ($queryPlh->row()->pegawai_id != null) {
                $query = $this->model->get_seleksi2('v_pegawai', 'jab_id', $this->session->userdata('id_jabatan'), 'status_pegawai', '1');
                $id = $query->row()->id;
            } else {
                $query = $this->model->get_seleksi('v_users', 'userid', $this->session->userdata('userid'));
                $id = $query->row()->pegawai_id;
            }
        } else {
            $query = $this->model->get_seleksi('v_users', 'userid', $this->session->userdata('userid'));
            $id = $query->row()->pegawai_id;
        }

        if ($this->session->userdata('role') == 'super') {
            redirect('user');
        } elseif ($this->session->userdata('status_plt') == '1' || $this->session->userdata('status_plh') == '1') {
            if (in_array($this->session->userdata('role'), ['super', 'admin_satker', 'validator_kepeg_satker'])) {
                redirect('plh');
            } else {
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Anda tidak memiliki hak akses');
                redirect('');
            }
        } else {
            $queryProfil = $this->pegawai->pegawai_data($id);

            $data['id'] = $queryProfil[0]->id;
            $data['nip'] = $queryProfil[0]->nip;
            $data['nama'] = $queryProfil[0]->nama;
            $data['alamat'] = $queryProfil[0]->alamat;
            $data['nama_gelar'] = $queryProfil[0]->nama_gelar;
            $data['gol_id'] = $queryProfil[0]->gol_id;
            $data['jk'] = $queryProfil[0]->jk;
            $data['jab_id'] = $queryProfil[0]->jab_id;
            $data['id_grup'] = $queryProfil[0]->id_grup;
            $data['tmt'] = $queryProfil[0]->tmt;
            $data['nohp'] = $queryProfil[0]->nohp;
            $this->session->set_userdata('ttd', site_url($queryProfil[0]->ttd));

            $data['jabatan'] = $this->jabatan->all_jabatan_data();
            $data['pangkat'] = $this->pangkat->all_pangkat_data();
            $data['role'] = $this->session->userdata('role');
            $data['userid'] = $this->session->userdata('userid');
            $data['plh'] = $this->session->userdata('status_plh');
            $data['plt'] = $this->session->userdata('status_plt');
            $data['page'] = 'profil';

            $this->load->view('header', $data);
            $this->load->view('halamanpengaturan/profil');
            $this->load->view('footer');
        }
    }

    public function simpan_data_profil()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $this->form_validation->set_rules('nip', 'NIP', 'trim|max_length[18]');
        $this->form_validation->set_rules('nama_gelar', 'Nama Dengan Gelar', 'trim|required|max_length[75]');
        $this->form_validation->set_rules('nama', 'Nama Tanpa Gelar', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|max_length[50]');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|max_length[50]');
        $this->form_validation->set_rules('nohp', 'Nomor HP', 'trim|required|max_length[15]');
        $this->form_validation->set_rules('jenis', 'Jenis Pegawai', 'trim|required');

        $this->form_validation->set_message(['required' => '%s Tidak Boleh Kosong', 'max_length' => '%s Tidak Boleh Melebihi %s Karakter']);

        if ($this->form_validation->run() == FALSE) {
            //echo json_encode(array('st' => 0, 'msg' => 'Tidak Berhasil:<br/>'.validation_errors()));
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', form_error('nip') . form_error('nama_gelar') . form_error('nama') . form_error('pangkat') . form_error('jabatan') . form_error('alamat') . form_error('ket') . form_error('nohp') . form_error('stat') . 'Gagal Simpan Pegawai, Periksa Kembali Form Input Pegawai');
            redirect('profil', validation_errors());
            return;
        }

        $nip = $this->input->post('nip');
        $nama_gelar = strtoupper($this->input->post('nama_gelar'));
        $nama = strtoupper($this->input->post('nama'));
        $pangkat = $this->input->post('pangkat');
        $jabatan = $this->input->post('jabatan');
        $alamat = strtoupper($this->input->post('alamat'));
        $ket = $this->input->post('ket');
        $nohp = $this->input->post('nohp');
        $jenis = $this->input->post('jenis');
        $tmt = $this->input->post('tmt');
        $jk = $this->input->post('jk');

        if ($tmt == "") {
            $tmt = NULL;
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

                $this->session->set_userdata('foto', $file_path_foto);
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

                $this->session->set_userdata('ttd', $file_path_ttd);
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
                'jenis_pegawai' => $jenis,
                'diperbaharui_oleh' => $this->session->userdata('fullname'),
                'diperbaharui_tanggal' => date('Y-m-d H:i:s')
            );

            $this->session->set_userdata('foto', $file_path_foto);
            $this->session->set_userdata('ttd', $file_path_ttd);
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
                    'foto' => $file_path_foto,
                    'jenis_pegawai' => $jenis,
                    'diperbaharui_oleh' => $this->session->userdata('fullname'),
                    'diperbaharui_tanggal' => date('Y-m-d H:i:s')
                );

                $this->session->set_userdata('foto', $file_path_foto);
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
                    'ttd' => $file_path_ttd,
                    'jenis_pegawai' => $jenis,
                    'diperbaharui_oleh' => $this->session->userdata('fullname'),
                    'diperbaharui_tanggal' => date('Y-m-d H:i:s')
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
                    'jenis_pegawai' => $jenis,
                    'diperbaharui_oleh' => $this->session->userdata('fullname'),
                    'diperbaharui_tanggal' => date('Y-m-d H:i:s')
                );
            }
        }

        if (in_array($jabatan, ["1", "2", "4", "5", "6", "7", "8", "9", "10", "11", "12"])) {
            $cekJabatan = $this->pegawai->cek_jabatan_pegawai($jabatan, $id);
        } else {
            $cekJabatan = 0;
        }

        if ($cekJabatan->num_rows > 0) {
            $querySimpan = "Ada Pegawai Aktif Menjabat Jabatan Yang Anda Pilih, Silakan Cek Kembali";
        } else {
            $querySimpan = $this->model->pembaharuan_data('pegawai', $dataPegawai, 'id', $id);
        }

        if ($querySimpan == 1) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Pegawai Berhasil di Perbarui');

            $this->session->set_userdata('fullname', $nama_gelar);
            $this->session->set_userdata('jab_id', $jabatan);
            $this->session->set_userdata('jk', $jk);
            $this->session->set_userdata('id_grup', $jenis);
            $hari = $this->tanggalhelper->getSelisihHari($tmt, date('Y-m-d'));
            $masa_kerja_tahun = $this->tanggalhelper->konversiMasaKerjaTahun($hari);
            $this->session->set_userdata('masa_kerja', $masa_kerja_tahun);

            redirect('profil');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $querySimpan);
            redirect('profil');
        }
    }

    #                               #
    #   PENGATURAN PROFIL PEGAWAI   #
    #                               #

    #                         #
    #   PENGATURAN APLIKASI   #
    #                         #

    public function get_app_data()
    {
        $data['userid'] = $this->session->userdata('userid');
        $data['role'] = $this->session->userdata('role');
        $data['plh'] = $this->session->userdata('status_plh');
        $data['plt'] = $this->session->userdata('status_plt');


        $data['nama_app'] = $this->model->get_konfigurasi('1');
        $data['title_app'] = $this->model->get_konfigurasi('2');
        $data['kode_satker'] = $this->model->get_konfigurasi('3');
        $data['nama_satker'] = $this->model->get_konfigurasi('4');
        $data['alamat_satker'] = $this->model->get_konfigurasi('5');
        $data['logo_satker'] = $this->model->get_konfigurasi('22');
        $data['foto_satker'] = $this->model->get_konfigurasi('14');
        $data['kop_satker'] = $this->model->get_konfigurasi('15');
        $data['mulai_apel_senin'] = $this->model->get_konfigurasi('30');
        $data['selesai_apel_senin'] = $this->model->get_konfigurasi('31');
        $data['mulai_apel_jumat'] = $this->model->get_konfigurasi('32');
        $data['selesai_apel_jumat'] = $this->model->get_konfigurasi('33');
        $data['ip_kantor'] = $this->model->get_konfigurasi('34');
        $data['istirahat_mulai'] = $this->model->get_konfigurasi('35');
        $data['istirahat_selesai'] = $this->model->get_konfigurasi('36');
        $data['istirahat_mulai_jumat'] = $this->model->get_konfigurasi('37');
        $data['istirahat_selesai_jumat'] = $this->model->get_konfigurasi('38');
        $data['presensi_lokasi'] = $this->model->get_konfigurasi('39');
        $data['page'] = 'app';

        $this->load->view('header', $data);
        $this->load->view('halamanpengaturan/app');
        $this->load->view('footer');
    }

    public function simpan_config()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        if (in_array($id, ['14', '15', '22'])) {
            $value_awal = $this->model->get_konfigurasi($id);

            //die(var_dump($value_awal->row()->value));
            # Konfigurasi untuk upload tanda tangan
            $config['upload_path'] = 'assets/dokumen/';
            $config['allowed_types'] = 'png';
            $config['max_size'] = 1024 * 5;
            $config['encrypt_name'] = FALSE;

            $this->load->library('upload');

            $file_path = '';
            if (!empty($_FILES['app']['name'])) {
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('app')) {
                    $error = $this->upload->display_errors();
                    $file_path = $error;
                } else {
                    # Ada file baru, sebelum upload, hapus dulu file yang lama
                    if ($value_awal->row()->value != NULL) {
                        unlink('assets/dokumen/' . $value_awal->row()->value);
                    }

                    $data = $this->upload->data();
                    $file_path = 'assets/dokumen/' . $data['file_name'];

                    // Konversi ke WebP
                    $webp_path = 'assets/dokumen/' . pathinfo($data['file_name'], PATHINFO_FILENAME) . '.webp';
                    $source_image = imagecreatefrompng($file_path);
                    imagewebp($source_image, $webp_path);
                    imagedestroy($source_image);
                    unlink($file_path);
                    $file_path = $webp_path;
                }
            }

            $value = pathinfo($data['file_name'], PATHINFO_FILENAME) . '.webp';
            if ($id == '15') {
                $this->session->set_userdata('kop_satker', $value);
            }
        } else {
            $value = $this->input->post('app');
        }

        $dataConfig = array(
            'value' => $value
        );

        //die(var_dump($value));
        $queryUpdate = $this->model->pembaharuan_data('sys_config', $dataConfig, 'id', $id);
        if ($queryUpdate == 1) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Konfigurasi Berhasil di Perbarui');
            redirect('app');
        } else {
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $queryUpdate);
            redirect('app');
        }
    }

    public function get_status_presensi()
    {
        $status = $this->model->get_konfigurasi('39')->row()->value;
        $data['status'] = $status;

        echo json_encode($data);
    }

    public function simpan_lokasi()
    {
        $input = json_decode($this->input->raw_input_stream, true);
        $nama = $input['nama'];
        $jenis = $input['tipe'];
        $polygon = json_encode($input['polygon']);

        $query = $this->model->get_seleksi('lokasi_kantor', 'id', $jenis);
        if ($query->num_rows() > 0) {
            $data = [
                'nama' => $nama,
                'polygon_json' => $polygon
            ];

            $this->model->pembaharuan_data('lokasi_kantor', $data, 'id', $jenis);
        }

        echo json_encode(['status' => true, 'message' => 'Polygon berhasil disimpan']);
    }

    public function get_lokasi()
    {
        $jenis = $this->input->get('tipe');
        $this->db->where('id', $jenis);
        $lokasi = $this->db->get('lokasi_kantor')->row();
        if ($lokasi) {
            $lokasi->koordinat = json_decode($lokasi->polygon_json); // decode dulu biar rapi
        }
        echo json_encode($lokasi);
    }

    public function update_lokasi()
    {
        $input = json_decode($this->input->raw_input_stream, true);
        $polygon = json_encode($input['polygon']);

        $this->db->update('lokasi_kantor', [
            'polygon_json' => $polygon
        ]);

        echo json_encode(['status' => true, 'message' => 'Polygon berhasil diupdate']);
    }

    #                         #
    #   PENGATURAN APLIKASI   #
    #                         #

    #                            #
    #   PENGATURAN PETUGAS MPP   #
    #                            #

    public function get_mpp_data()
    {
        $get_data = $this->model->get_data('ref_mpp')->result();
        $mpp_data = [];
        foreach ($get_data as $row) {
            $nama = $this->model->get_seleksi('v_pegawai', 'id', $row->pegawai_id)->row()->nama_gelar;
            $mpp_data[] = [
                'id' => $row->id,
                'nama' => $nama,
                'status' => $row->status
            ];
        }

        $data['mpp_data'] = $mpp_data;
        $data["page"] = 'mpp';
        $data['userid'] = $this->session->userdata('userid');
        $data['role'] = $this->session->userdata('role');
        $data['plh'] = $this->session->userdata('status_plh');
        $data['plt'] = $this->session->userdata('status_plt');

        $this->load->view('header', $data);
        $this->load->view('halamanpengaturan/mpp');
        $this->load->view('footer');
    }

    public function edit_mpp()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        $queryPegawai = $this->model->get_data('v_pegawai');
        $pegawai = array();
        $pegawai[''] = "Pilih Pegawai";
        foreach ($queryPegawai->result() as $row) {
            $pegawai[$row->id] = $row->nama_gelar;
        }

        $status_aktif = ['' => 'Pilih Status Petugas', '0' => 'Non Aktif', '1' => 'Aktif'];
        if ($id == '-1') {
            $judul = "TAMBAH PETUGAS MPP";
            $pegawai_ = form_dropdown('pegawai', $pegawai, '', 'class="form-control select2"  id="pegawai"');
            $stat = form_dropdown('status', $status_aktif, '', 'class="form-select" id="status"');
        } else {
            $judul = "EDIT PETUGAS MPP";
            $query = $this->model->get_seleksi('ref_mpp', 'id', $id);
            $id_pegawai = $query->row()->pegawai_id;
            $status = $query->row()->status;

            $pegawai_ = form_dropdown('pegawai', $pegawai, $id_pegawai, 'class="form-control select2"  id="pegawai"');
            $stat = form_dropdown('status', $status_aktif, $status, 'class="form-select" id="status"');
        }

        echo json_encode(
            array(
                'st' => 1,
                'judul' => $judul,
                'id' => base64_encode($this->encryption->encrypt($id)),
                'pegawai' => $pegawai_,
                'status' => $stat
            )
        );
        return;
    }

    public function simpan_mpp()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $pegawai = $this->input->post('pegawai');
        $status = $this->input->post('status');
        //die(var_dump($id .' + '. $pegawai));

        if ($id == '-1') {
            $cekPetugas = $this->model->get_seleksi('ref_mpp', 'pegawai_id', $pegawai);
            if ($cekPetugas->num_rows() > 0) {
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Gagal Simpan Petugas, Pegawai yang ditunjuk sudah menjadi Petugas MPP');
                redirect('mpp');
            } else {
                $data = [
                    'pegawai_id' => $pegawai,
                    'status' => $status,
                    'created_by' => $this->session->userdata('fullname'),
                    'created_on' => date('Y-m-d H:i:s')
                ];

                $query = $this->model->simpan_data('ref_mpp', $data);
            }
        } else {
            $cekPetugas = $this->model->get_seleksi('ref_mpp', 'id', $id);
            if ($cekPetugas->num_rows() > 0) {
                $data = [
                    'pegawai_id' => $pegawai,
                    'status' => $status,
                    'modified_by' => $this->session->userdata('fullname'),
                    'modified_on' => date('Y-m-d H:i:s')
                ];
            } else {
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Gagal Perbarui Petugas, Petugas tidak ditemukan');
                redirect('mpp');
            }

            $query = $this->model->pembaharuan_data('ref_mpp', $data, 'id', $id);
        }


        if ($query == 1) {

            $dataNotif = array(
                'jenis_pesan' => 'plh',
                'id_pemohon' => $this->session->userdata("pegawai_id"),
                'pesan' => 'Anda telah ditunjuk menjadi Petugas Mall Pelayanan Publik (MPP), Silakan Koordinasi dengan bagian Kepegawaian untuk menindaklanjuti.',
                'id_tujuan' => $pegawai,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->notif->tambahNotif($dataNotif, 'sys_notif');

            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Petugas MPP Berhasil di Pilih');
            redirect('mpp');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal Simpan, ' . $query);
            redirect('mpp');
        }

    }

    #                            #
    #   PENGATURAN PETUGAS MPP   #
    #                            #
}