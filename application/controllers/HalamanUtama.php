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

        $query = $this->model->get_data_client();

        $data['hasil'] = $query->result();
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

    public function kalender_pegawai()
    {
        $data['page'] = 'kalender_pegawai';
        $data['role'] = $this->session->userdata('role');
        $this->load->view('header', $data);
        $this->load->view('halamankalender/kalender_pegawai');
    }

    public function get_cuti_kalender()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $data_cuti = $this->model->get_cuti_kalender($start, $end);
        $data_izin_keluar = $this->model->get_izin_keluar_kalender($start, $end);
        $params = [
            'api_key' => $this->config->item('api_key'),
            'tgl_awal' => $start,
            'tgl_akhir' => $end
        ];
        $data_libur = $this->apihelper->get($this->config->item('api_izincuti') . '/get_hari_libur_kalender', $params)['response']['data'] ?? [];

        $liburDates = [];
        foreach ($data_libur as $libur) {
            $liburDates[$libur['tgl']] = true;
        }

        $events = [];

        // Event Hari Libur (background merah)
        foreach ($data_libur as $libur) {
            $events[] = [
                'id' => 'libur_' . $libur['tgl'],
                'start' => $libur['tgl'],
                'end' => date('Y-m-d', strtotime($libur['tgl'] . ' +1 day')),
                'display' => 'background',
                'color' => '#ffcccc',
                'extendedProps' => [
                    'tipe' => 'hari_libur',
                    'keterangan' => $libur['ket'] ?? 'Hari Libur'
                ]
            ];
        }

        // Event Cuti
        foreach ($data_cuti as $cuti) {
            $jenis_cuti = '';
            $color = '';
            switch ($cuti['jenis_cuti']) {
                case '1':
                    $jenis_cuti = 'Cuti Tahunan';
                    $color = '#28a745';
                    break;
                case '2':
                    $jenis_cuti = 'Cuti Sakit';
                    $color = '#dc3545';
                    break;
                case '3':
                    $jenis_cuti = 'Cuti Melahirkan';
                    $color = '#ffc107';
                    break;
                case '4':
                    $jenis_cuti = 'Cuti Besar';
                    $color = '#17a2b8';
                    break;
                case '5':
                    $jenis_cuti = 'Cuti Alasan Penting';
                    $color = '#6f42c1';
                    break;
                case '6':
                    $jenis_cuti = 'Cuti di Luar Tanggungan Negara';
                    $color = '#6c757d';
                    break;
                default:
                    $jenis_cuti = 'Cuti Lainnya';
                    $color = '#343a40';
                    break;
            }

            // Untuk Cuti Tahunan (1) dan Cuti Sakit (2), pecah per hari dan skip hari libur
            if (($cuti['jenis_cuti'] == '1' || $cuti['jenis_cuti'] == '2') && !empty($liburDates)) {
                $current = strtotime($cuti['tgl_awal']);
                $lastDay = strtotime($cuti['tgl_akhir']);
                $inSegment = false;
                $segmentStart = null;

                while ($current <= $lastDay) {
                    $dateStr = date('Y-m-d', $current);
                    $isLibur = isset($liburDates[$dateStr]);

                    if (!$isLibur) {
                        if (!$inSegment) {
                            $inSegment = true;
                            $segmentStart = $dateStr;
                        }
                    } else {
                        if ($inSegment) {
                            $events[] = [
                                'id' => 'cuti_' . $cuti['id'] . '_' . md5($segmentStart . '-' . $dateStr),
                                'start' => $segmentStart,
                                'end' => date('Y-m-d', strtotime($dateStr . ' +1 day')),
                                'display' => 'block',
                                'title' => $cuti['nama_pegawai'] . ' - ' . $jenis_cuti,
                                'color' => $color,
                                'extendedProps' => [
                                    'tipe' => 'cuti',
                                    'nama' => $cuti['nama_pegawai'],
                                    'jenis' => $jenis_cuti,
                                    'nomor_cuti' => $cuti['nomor_cuti'],
                                    'alasan' => $cuti['alasan']
                                ]
                            ];
                            $inSegment = false;
                            $segmentStart = null;
                        }
                    }
                    $current = strtotime('+1 day', $current);
                }

                // Tutup segment terakhir jika masih berjalan
                if ($inSegment && $segmentStart !== null) {
                    $events[] = [
                        'id' => 'cuti_' . $cuti['id'] . '_' . md5($segmentStart . '-end'),
                        'start' => $segmentStart,
                        'end' => date('Y-m-d', strtotime($cuti['tgl_akhir'] . ' +1 day')),
                        'display' => 'block',
                        'title' => $cuti['nama_pegawai'] . ' - ' . $jenis_cuti,
                        'color' => $color,
                        'extendedProps' => [
                            'tipe' => 'cuti',
                            'nama' => $cuti['nama_pegawai'],
                            'jenis' => $jenis_cuti,
                            'nomor_cuti' => $cuti['nomor_cuti'],
                            'alasan' => $cuti['alasan']
                        ]
                    ];
                }
            } else {
                $events[] = [
                    'id' => 'cuti_' . $cuti['id'],
                    'title' => $cuti['nama_pegawai'] . ' - ' . $jenis_cuti,
                    'start' => $cuti['tgl_awal'],
                    'end' => date('Y-m-d', strtotime($cuti['tgl_akhir'] . ' +1 day')),
                    'color' => $color,
                    'extendedProps' => [
                        'tipe' => 'cuti',
                        'nama' => $cuti['nama_pegawai'],
                        'jenis' => $jenis_cuti,
                        'nomor_cuti' => $cuti['nomor_cuti'],
                        'alasan' => $cuti['alasan']
                    ]
                ];
            }
        }

        // Event Izin Keluar
        foreach ($data_izin_keluar as $izin) {
            $start_datetime = $izin['tgl_izin'] . 'T' . $izin['jam_mulai'];
            $end_datetime = $izin['tgl_izin'] . 'T' . $izin['jam_akhir'];

            // Jika jam_akhir lebih kecil dari jam_mulai, berarti sampai hari berikutnya
            if (strtotime($izin['jam_akhir']) < strtotime($izin['jam_mulai'])) {
                $end_date = date('Y-m-d', strtotime($izin['tgl_izin'] . ' +1 day'));
                $end_datetime = $end_date . 'T' . $izin['jam_akhir'];
            }

            $events[] = [
                'id' => 'izin_' . $izin['id'],
                'title' => $izin['nama_pegawai'] . ' - Izin Keluar',
                'start' => $start_datetime,
                'end' => $end_datetime,
                'color' => '#fd7e14', // orange
                'display' => 'block',
                'extendedProps' => [
                    'tipe' => 'izin_keluar',
                    'nama' => $izin['nama_pegawai'],
                    'jenis' => 'Izin Keluar',
                    'alasan' => $izin['alasan'],
                    'jam_mulai' => $izin['jam_mulai'],
                    'jam_akhir' => $izin['jam_akhir']
                ]
            ];
        }

        echo json_encode($events);
    }
}