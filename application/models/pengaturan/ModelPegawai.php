<?php

class ModelPegawai extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('ModelUtama', 'model');
    }

    private function add_audittrail($action, $title, $table, $descrip)
    {
        $username = $this->session->userdata('username');
        if ($username == '') {
            $username = 'admin';
        }
        try {
            $data = array(
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $this->input->ip_address(),
                'username' => $username,
                'tablename' => $table,
                'action' => $action,
                'title' => $title,
                'description' => $descrip
            );
            $this->db->insert('sys_audittrail', $data);
        } catch (Exception $e) {

        }
    }

    public function all_pegawai_data()
    {
        $this->db->order_by('jab_id', 'ASC');
        $this->db->order_by('status_pegawai', 'DESC');
        return $this->db->select('*')->from('v_pegawai')->where('id > 0')->get()->result();
    }

    public function pilih_pegawai()
    {
        try {
            $this->db->where('id > 0');
            $this->db->where('status_pegawai', '1');
            $this->db->order_by('jab_id', 'ASC');
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pilih_semua_pegawai()
    {
        try {
            $this->db->where('id > 0');
            $this->db->order_by('jab_id', 'ASC');
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pilih_atasan()
    {
        try {
            $this->db->order_by('id', 'ASC');
            $this->db->where_in('id', array(1, 4, 5, 6, 7, 8, 9, 10, 11, 12));
            return $this->db->get('ref_jabatan');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pilih_pegawai_tamu()
    {
        try {
            $this->db->where('status_pegawai', '1');
            $this->db->where('jab_id <> 0');
            $this->db->where('id_grup <> 5');
            $this->db->order_by('jab_id', 'ASC');
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function atasan_aktif()
    {
        $this->db->order_by('id', 'ASC');
        $this->db->where_in('id', array(1, 4, 5, 6, 7, 8, 9, 10, 11, 12));
        return $this->db->select('*')->from('ref_jabatan')->get()->result();
    }

    public function pegawai_data($id)
    {
        $this->db->where('id', $id);
        return $this->db->select('*')->from('v_pegawai')->get()->result();
    }

    public function cek_jabatan_pegawai($jabatan, $id)
    {
        try {
            $this->db->where("id != '" . $id . "'");
            $this->db->where('status_pegawai', '1');
            $this->db->where('jab_id', $jabatan);
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function get_pegawai_by($seleksi, $nilai)
    {
        try {
            $this->db->where($seleksi, $nilai);
            return $this->db->get('pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function cek_jabatan_baru_pegawai($jabatan)
    {
        try {
            $this->db->where('status_pegawai', '1');
            $this->db->where('jab_id', $jabatan);
            return $this->db->get('v_pegawai');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function jenis_pegawai()
    {
        try {
            return $this->db->get('ref_group_jabatan');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function tambah_pegawai($data)
    {
        $table = 'pegawai';
        try {
            $this->db->insert($table, $data);
            $title = "Tambah Pegawai [Pegawai=<b>" . $data['nama_gelar'] . "</b>]<br />Tambah tabel <b>pegawai</b>]";
            $descrip = null;
            $this->add_audittrail("TAMBAH", $title, $table, $descrip);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function get_seleksi_pegawai()
    {
        $jekel = [
            '' => 'Pilih Jenis Kelamin',
            '1' => 'Pria',
            '2' => 'Wanita'
        ];

        $jabatan = [
            '' => 'Pilih Jabatan'
        ];
        $query_jabatan = $this->model->get_data('ref_jabatan')->result_array();

        foreach ($query_jabatan as $j) {
            $jabatan[$j['id']] = $j['nama_jabatan'];
        }

        $pangkat = [
            '' => 'Pilih Pangkat Golongan'
        ];
        $query_pangkat = $this->model->get_data('ref_pangkat')->result_array();

        foreach ($query_pangkat as $p) {
            $pangkat[$p['id']] = $p['golongan'] . ' | ' . $p['pangkat'];
        }

        $grup = [
            '' => 'Pilih Jenis Pegawai',
            '1' => 'Hakim',
            '2' => 'PNS',
            '3' => 'Honorer/PPNPN',
            '4' => 'Calon Hakim',
            '5' => 'Operator',
            '6' => 'PPPK'
        ];

        $status = [
            '' => 'Pilih Status Pegawai',
            '0' => 'Tidak Aktif',
            '1' => 'Aktif'
        ];

        if ($this->input->post('id')) {
            $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
            $userid = '';
            $queryProfil = $this->model->get_seleksi('v_pegawai', 'id', $id)->row();
            $query = $this->model->get_seleksi('v_users', 'pegawai_id', $id);
            if ($query->num_rows() > 0)
                $userid = $query->row()->userid;
            $data = [
                'id' => base64_encode($this->encryption->encrypt($queryProfil->id)),
                'nip' => $queryProfil->nip,
                'nama' => $queryProfil->nama,
                'alamat' => $queryProfil->alamat,
                'nama_gelar' => $queryProfil->nama_gelar,
                'tmt' => $queryProfil->tmt,
                'nohp' => $queryProfil->nohp,
                'qrcode' => $queryProfil->qrcode_pegawai,
                'foto' => $queryProfil->foto ? base_url() . $queryProfil->foto : base_url() . 'assets/img/1.png',
                'jenis_kelamin' => form_dropdown('jk', $jekel, $queryProfil->jk, 'id="jk" class="select2 form-select"'),
                'jabatan' => form_dropdown('jabatan', $jabatan, $queryProfil->jab_id, 'id="jabatan" class="form-select select2"'),
                'pangkat' => form_dropdown('pangkat', $pangkat, $queryProfil->gol_id, 'id="pangkat" class="form-select select2"'),
                'jenis' => form_dropdown('jenis', $grup, $queryProfil->id_grup, 'id="jenis" class="form-select select2"'),
                'status' => form_dropdown('stat', $status, $queryProfil->status_pegawai, 'id="status" class="form-select select2"'),
                'userid' => $userid
            ];
        } else {
            $data = [
                'id' => '',
                'nip' => '',
                'nama' => '',
                'alamat' => '',
                'nama_gelar' => '',
                'tmt' => '',
                'nohp' => '',
                'qrcode' => '',
                'foto' => base_url() . 'assets/img/1.png',
                'jenis_kelamin' => form_dropdown('jk', $jekel, '', 'id="jk" class="select2 form-select"'),
                'jabatan' => form_dropdown('jabatan', $jabatan, '', 'id="jabatan" class="form-select select2"'),
                'pangkat' => form_dropdown('pangkat', $pangkat, '', 'id="pangkat" class="form-select select2"'),
                'jenis' => form_dropdown('jenis', $grup, '', 'id="jenis" class="form-select select2"'),
                'status' => form_dropdown('stat', $status, '', 'id="status" class="form-select select2"'),
                'userid' => ''
            ];
        }

        $data['role'] = $this->session->userdata('role');
        $data['plh'] = $this->session->userdata('status_plh');
        $data['plt'] = $this->session->userdata('status_plt');
        $data['page'] = 'profil';

        return $data;
    }
}