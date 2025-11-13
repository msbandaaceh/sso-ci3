<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Model $model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property ModelTicketing $ticketing
 * @property ModelNotifikasi $notif
 * @property ModelUtama $model
 */

class HalamanTicketing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelTicketing', 'ticketing');
        $this->load->model('ModelNotifikasi', 'notif');
        $this->load->model('ModelLogin', 'login');

        // Form publik tidak perlu login (ticketing_form dan simpan_ticket)
        // Halaman management memerlukan login (akan dicek di masing-masing method)
        // Tidak perlu menghancurkan session untuk method publik
    }

    /**
     * Halaman form publik (tanpa login)
     */
    public function form()
    {
        $this->load->model('ModelLogin', 'login');

        $data['page'] = 'ticketing_form';

        // Load konfigurasi untuk header
        $data['nama_satker'] = $this->login->get_konfigurasi('4')->row()->value;
        $data['logo_satker'] = 'assets/dokumen/' . $this->login->get_konfigurasi('22')->row()->value;
        $data['nama_app'] = $this->login->get_konfigurasi('1')->row()->value;
        $data['title_app'] = $this->login->get_konfigurasi('2')->row()->value;

        // Gunakan header dan footer khusus untuk form ticketing (tidak memerlukan login)
        $this->load->view('ticketing/header_ticketing', $data);
        $this->load->view('ticketing/form_ticketing', $data);
        $this->load->view('ticketing/footer_ticketing', $data);
    }

    /**
     * Proses simpan ticketing dari form publik
     */
    public function simpan_ticket()
    {
        $this->form_validation->set_rules('nama_pelapor', 'Nama Pelapor', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('jenis_laporan', 'Jenis Laporan', 'trim|required');

        $this->form_validation->set_message([
            'required' => '%s tidak boleh kosong',
            'min_length' => '%s minimal %s karakter'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', validation_errors());
            redirect('ticketing_form');
            return;
        }

        $nama_pelapor = $this->input->post('nama_pelapor');
        $deskripsi = $this->input->post('deskripsi');
        $jenis_laporan = $this->input->post('jenis_laporan');

        $data = [
            'nama_pelapor' => $nama_pelapor,
            'deskripsi' => $deskripsi,
            'jenis_laporan' => $jenis_laporan,
            'status' => 'baru',
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => 'public'
        ];

        $ticket_id = $this->ticketing->simpan_ticket($data);

        if ($ticket_id > 0) {
            // Simpan log untuk ticket baru
            $log_data = [
                'ticket_id' => $ticket_id,
                'action' => 'created',
                'status_lama' => null,
                'status_baru' => 'baru',
                'keterangan' => 'Laporan ticketing baru dibuat oleh: ' . $nama_pelapor,
                'dilakukan_oleh' => $nama_pelapor . ' (public)',
                'dilakukan_pada' => date('Y-m-d H:i:s')
            ];
            $this->ticketing->simpan_log($log_data);

            // Kirim notifikasi WhatsApp ke admin satker
            $this->kirim_notifikasi_wa($ticket_id, $nama_pelapor, $deskripsi, $jenis_laporan);

            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Laporan ticketing berhasil dikirim. Terima kasih atas laporan Anda!');
            redirect('ticketing_form');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal mengirim laporan. Silakan coba lagi.');
            redirect('ticketing_form');
        }
    }

    /**
     * Halaman daftar ticketing untuk admin
     */
    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }

        $role = $this->session->userdata('role');
        if (!in_array($role, ['super', 'admin_satker', 'validator_ptip_satker'])) {
            redirect('keluar');
        }

        $data['tickets'] = $this->ticketing->get_all_tickets()->result();
        $data['role'] = $role;
        $data['page'] = 'ticketing';

        // Hitung statistik
        $data['statistik'] = [
            'baru' => $this->ticketing->count_tickets_by_status('baru'),
            'diproses' => $this->ticketing->count_tickets_by_status('diproses'),
            'selesai' => $this->ticketing->count_tickets_by_status('selesai'),
            'ditolak' => $this->ticketing->count_tickets_by_status('ditolak')
        ];

        $this->load->view('header', $data);
        $this->load->view('ticketing/daftar_ticketing', $data);
    }

    /**
     * Tampilkan detail ticket
     */
    public function detail()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }

        $role = $this->session->userdata('role');
        if (!in_array($role, ['super', 'admin_satker', 'validator_ptip_satker'])) {
            redirect('keluar');
        }

        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $ticket = $this->ticketing->get_ticket_by_id($id);

        if ($ticket->num_rows() == 0) {
            echo json_encode(['st' => 0, 'msg' => 'Data tidak ditemukan']);
            return;
        }

        // Ambil log untuk ticket ini
        $logs = $this->ticketing->get_log_by_ticket_id($id);
        $log_array = [];
        if ($logs && $logs->num_rows() > 0) {
            foreach ($logs->result() as $log) {
                $log_array[] = [
                    'action' => $log->action,
                    'status_lama' => $log->status_lama,
                    'status_baru' => $log->status_baru,
                    'keterangan' => $log->keterangan,
                    'dilakukan_oleh' => $log->dilakukan_oleh,
                    'dilakukan_pada' => $log->dilakukan_pada
                ];
            }
        }

        $data = $ticket->row();
        echo json_encode([
            'st' => 1,
            'data' => [
                'id' => $data->id,
                'nama_pelapor' => $data->nama_pelapor,
                'deskripsi' => $data->deskripsi,
                'jenis_laporan' => $data->jenis_laporan,
                'status' => $data->status,
                'tindak_lanjut' => $data->tindak_lanjut,
                'evidence' => isset($data->evidence) ? $data->evidence : null,
                'ditindak_lanjut_oleh' => $data->ditindak_lanjut_oleh,
                'ditindak_lanjut_pada' => $data->ditindak_lanjut_pada,
                'created_on' => $data->created_on,
                'logs' => $log_array
            ]
        ]);
    }

    /**
     * Update status dan tindak lanjut
     */
    public function update_tindak_lanjut()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('keluar');
        }

        $role = $this->session->userdata('role');
        // Hanya admin_satker dan validator_ptip_satker yang bisa menindaklanjuti
        if (!in_array($role, ['admin_satker', 'validator_ptip_satker'])) {
            redirect('keluar');
        }

        $this->form_validation->set_rules('id', 'ID Ticket', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('tindak_lanjut', 'Tindak Lanjut', 'trim|required');

        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $status = $this->input->post('status');
        $tindak_lanjut = $this->input->post('tindak_lanjut');

        // Ambil data ticket lama untuk log
        $ticket_lama = $this->ticketing->get_ticket_by_id($id);
        $status_lama = $ticket_lama->num_rows() > 0 ? $ticket_lama->row()->status : null;

        // Jika status selesai, wajib upload evidence
        if ($status == 'selesai') {
            if (empty($_FILES['evidence']['name'])) {
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan', 'Evidence (foto/PDF) wajib diupload untuk status selesai');
                redirect('ticketing');
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan', validation_errors());
            redirect('ticketing');
            return;
        }

        $data = [
            'status' => $status,
            'tindak_lanjut' => $tindak_lanjut,
            'ditindak_lanjut_oleh' => $this->session->userdata('fullname'),
            'ditindak_lanjut_pada' => date('Y-m-d H:i:s')
        ];

        // Handle upload evidence jika status selesai dan ada file
        if ($status == 'selesai' && !empty($_FILES['evidence']['name'])) {
            $upload_path = 'assets/dokumen/tiket/';

            // Buat folder jika belum ada
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            // Konfigurasi upload
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('evidence')) {
                $upload_data = $this->upload->data();
                $data['evidence'] = $upload_path . $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('info', '3');
                $this->session->set_flashdata('pesan', 'Gagal upload evidence: ' . $error);
                redirect('ticketing');
                return;
            }
        }

        $result = $this->model->pembaharuan_data('ticketing', $data, 'id', $id);

        if ($result == 1) {
            // Simpan log untuk update tindak lanjut
            $action = ($status_lama != $status) ? 'status_changed' : 'updated';
            $keterangan = 'Tindak lanjut: ' . substr($tindak_lanjut, 0, 200) . (strlen($tindak_lanjut) > 200 ? '...' : '');
            if ($status == 'selesai' && isset($data['evidence'])) {
                $keterangan .= ' | Evidence diupload';
            }

            $log_data = [
                'ticket_id' => $id,
                'action' => $action,
                'status_lama' => $status_lama,
                'status_baru' => $status,
                'keterangan' => $keterangan,
                'dilakukan_oleh' => $this->session->userdata('fullname'),
                'dilakukan_pada' => date('Y-m-d H:i:s')
            ];

            $this->model->simpan_data('ticketing_log', $log_data);

            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan', 'Tindak lanjut berhasil disimpan');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan', 'Gagal menyimpan tindak lanjut');
        }

        redirect('ticketing');
    }

    /**
     * Kirim notifikasi WhatsApp ke admin satker dan validator_ptip_satker
     */
    private function kirim_notifikasi_wa($ticket_id, $nama_pelapor, $deskripsi, $jenis_laporan)
    {
        // Ambil semua admin satker
        $admin_satker = $this->model->get_seleksi2('v_users', 'role', 'admin_satker', 'status_pegawai', '1');

        // Ambil semua validator_ptip_satker
        $validator_ptip_satker = $this->model->get_seleksi2('v_users', 'role', 'validator_ptip_satker', 'status_pegawai', '1');

        $jenis_label = [
            'error' => 'Error',
            'bug' => 'Bug',
            'permintaan_fitur' => 'Permintaan Fitur',
            'laporan_lainnya' => 'Laporan Lainnya'
        ];

        $jenis = isset($jenis_label[$jenis_laporan]) ? $jenis_label[$jenis_laporan] : 'Laporan Lainnya';

        // Buat pesan WhatsApp
        $pesanWA = "Laporan ticketing baru telah masuk:\n\n";
        $pesanWA .= "ID Ticket: #" . $ticket_id . "\n";
        $pesanWA .= "Nama Pelapor: " . $nama_pelapor . "\n";
        $pesanWA .= "Jenis: " . $jenis . "\n";
        $pesanWA .= "Deskripsi: " . substr($deskripsi, 0, 200) . (strlen($deskripsi) > 200 ? '...' : '') . "\n\n";
        $pesanWA .= "Silakan login ke sistem untuk menindaklanjuti.\n\n";

        // Kirim ke semua admin satker
        if ($admin_satker->num_rows() > 0) {
            foreach ($admin_satker->result() as $admin) {
                if (!empty($admin->nohp)) {
                    $dataNotif = [
                        'id_pemohon' => '999',
                        'jenis_pesan' => 'ticketing',
                        'pesan' => $pesanWA,
                        'id_tujuan' => $admin->pegawai_id,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => 'system'
                    ];
                    $this->notif->tambahNotif($dataNotif, 'sys_notif');
                }
            }
        }

        // Kirim ke semua validator_ptip_satker
        if ($validator_ptip_satker->num_rows() > 0) {
            foreach ($validator_ptip_satker->result() as $validator) {
                if (!empty($validator->nohp)) {
                    $dataNotif = [
                        'id_pemohon' => '999',
                        'jenis_pesan' => 'ticketing',
                        'pesan' => $pesanWA,
                        'id_tujuan' => $validator->pegawai_id,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => 'system'
                    ];
                    $this->notif->tambahNotif($dataNotif, 'sys_notif');
                }
            }
        }
    }
}

