<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wa extends CI_Controller
{
    private $api_izincuti = 'seudati.ms-bandaaceh.local/api';
    private $api_rapat = 'agam.ms-bandaaceh.local/api';
    private $api_gaji = 'paylink.ms-bandaaceh.local/api';

    public function notifikasi()
    {
        $this->load->model('pengaturan/ModelNotifikasi', 'notif');
        $apine = $this->input->get('kuncine');
        if ($apine <> $this->config->item('api_key')) {
            echo json_encode(array("hasill" => "ANDA TIDAK BERHAK AKSES !!!!"));
        } else {
            $pesan = $this->notif->notif();
            if ($pesan <> 0) {
                echo json_encode(array("hasil" => $pesan));
            } else {
                echo json_encode(array("hasil" => 0));
            }
        }
    }

    public function notifikasi_wag()
    {
        $this->load->model('ModelNotifikasi', 'notif');

        $this->cek_reminder_presensi();
        $this->cek_jadwal_rapat();
        $this->reminder_presensi();

        $apine = $this->input->get('kuncine');
        if ($apine <> $this->config->item('api_key')) {
            echo json_encode(array("hasill" => "ANDA TIDAK BERHAK AKSES !!!!"));
        } else {
            $pesan = $this->notif->notif_wag();
            if ($pesan <> 0) {
                echo json_encode(array("hasil" => $pesan));
            } else {
                echo json_encode(array("hasil" => 0));
            }
        }
    }

    public function cek_reminder_presensi()
    {
        $this->load->model('ModelUtama', 'model');
        if (strtotime(date('H:i:s')) >= strtotime('07:10:00') && strtotime(date('H:i:s')) <= strtotime('07:35:00')) {
            # CEK APAKAH HARI INI ADA REMINDER PRESENSI
            $cekReminder = $this->model->get_seleksi('reminder', 'tanggal', date('Y-m-d'));
            if ($cekReminder->num_rows() == 0) {
                $dataMasuk = array(
                    'jenis' => '1',
                    'tanggal' => date('Y-m-d')
                );
                $dataPulang = array(
                    'jenis' => '2',
                    'tanggal' => date('Y-m-d')
                );
                $dataMulaiIstirahat = array(
                    'jenis' => '4',
                    'tanggal' => date('Y-m-d')
                );
                $dataSelesaiIstirahat = array(
                    'jenis' => '5',
                    'tanggal' => date('Y-m-d')
                );

                $this->model->simpan_data('reminder', $dataMasuk);
                $this->model->simpan_data('reminder', $dataPulang);
                $this->model->simpan_data('reminder', $dataMulaiIstirahat);
                $this->model->simpan_data('reminder', $dataSelesaiIstirahat);
            }
        }
    }

    public function cek_jadwal_rapat()
    {
        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelNotifikasi', 'notif');

        $params = [
            'api_key' => $this->config->item('api_key')
        ];

        $result = $this->apihelper->get($this->api_rapat . '/reminder_rapat', $params);

        if ($result['status_code'] == '200' && $result['response']['status'] === 'success') {
            $data_rapat = $result['response']['data'][0];
            $id = $data_rapat['id'];
            $agenda = $data_rapat['agenda'];
            $tempat = $data_rapat['tempat'];
            $peserta = $data_rapat['peserta'];
            $pengundang = $data_rapat['penandatangan'];
            $tujuan = $this->model->get_seleksi('v_users', 'userid', $pengundang);
            $fullname = $tujuan->row()->fullname;
            $jab = $tujuan->row()->jabatan;

            $pesanWA = "*[REMINDER]*\n\n";
            $pesanWA .= "Yth. Bapak/Ibu Aparatur MS Banda Aceh, sesaat lagi agenda *" . $agenda . "* oleh *" . $jab . " (" . $fullname . ")* akan segera dimulai.\n";
            $pesanWA .= "Kepada peserta (*" . $peserta . "*) diharapkan segera memasuki *" . $tempat . "* agar agenda dapat dimulai tepat waktu.\n";
            $pesanWA .= "Terima kasih atas perhatian.";

            $dataNotif = array(
                'id_pemohon' => '999',
                'jenis_pesan' => 'wag',
                'pesan' => $pesanWA,
                'id_tujuan' => '999',
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => 'system'
            );

            $simpanNotif = $this->model->simpan_data('sys_notif', $dataNotif);
            if ($simpanNotif == 1) {
                $payload = [
                    'api_key' => $this->config->item('api_key'),
                    'tabel' => 'register_rapat',
                    'kunci' => 'id',
                    'id' => $id,
                    'data' => array('reminder' => 1)
                ];

                $this->apihelper->post($this->api_rapat . '/pembaharuan_data', $payload);
            }
        }
    }

    private function waktu_dalam_rentang($start, $end)
    {
        $now = strtotime(date("H:i"));
        return ($now >= strtotime($start) && $now <= strtotime($end));
    }

    private function kirim_reminder($jenis, $pesan)
    {
        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelNotifikasi', 'notif');
        $queryReminder = $this->notif->cek_reminder_presensi($jenis);
        if ($queryReminder->num_rows() > 0) {
            $this->model->pembaharuan_data('reminder', ['status' => 1], 'id', $queryReminder->row()->id);

            $dataNotif = [
                'id_pemohon' => '999',
                'jenis_pesan' => 'wag',
                'pesan' => $pesan,
                'id_tujuan' => '999',
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => 'system'
            ];

            $this->model->simpan_data('sys_notif', $dataNotif);
        }
    }

    public function reminder_presensi()
    {
        $this->load->model('pengaturan/ModelUser', 'model');
        $this->load->model('ModelNotifikasi', 'notif');
        $this->load->model('ModelLogin', 'login');

        $mulaiIstirahat = $this->login->get_konfigurasi('35')->row()->value;
        $selesaiIstirahat = $this->login->get_konfigurasi('36')->row()->value;
        $mulaiIstirahatJumat = $this->login->get_konfigurasi('37')->row()->value;
        $selesaiIstirahatJumat = $this->login->get_konfigurasi('38')->row()->value;

        $day = $this->tanggalhelper->getDayName(date('Y-m-d'));
        $hari = $this->tanggalhelper->dayName($day);

        // Reminder Umum
        $pesanWA = "*[REMINDER]*\n\nAssalamu'alaikum Wr.Wb.\nYth. Bapak/Ibu Aparatur MS Banda Aceh, sudahkah kita melakukan presensi kehadiran melalui aplikasi SIKEP?\nPastikan kembali bahwa presensi Bapak/Ibu telah tersimpan. Terima Kasih.";

        // Reminder Istirahat
        $pesanMulaiIstirahat = "*[REMINDER]*\n\nAssalamu'alaikum Wr.Wb.\nYth. Bapak/Ibu Aparatur MS Banda Aceh, waktu sudah menunjukkan pukul %s WIB\nBapak/Ibu dipersilahkan ISHOMA terlebih dahulu dan melakukan presensi mulai istirahat melalui LITERASI MS Banda Aceh. Terima Kasih.";
        $pesanSelesaiIstirahat = "*[REMINDER]*\n\nAssalamu'alaikum Wr.Wb.\nYth. Bapak/Ibu Aparatur MS Banda Aceh, sesaat lagi waktu ISHOMA akan berakhir\nBapak/Ibu dipersilahkan melakukan presensi istirahat kembali melalui LITERASI MS Banda Aceh dan melanjutkan aktivitas pekerjaan seperti biasa. Terima Kasih.";

        $params = [
            'api_key' => $this->config->item('api_key'),
        ];

        $result = $this->apihelper->get($this->api_izincuti . '/cek_hari_libur', $params);
        if ($result['status_code'] == 200 && $result['response']['status'] == 'kosong') {
            if (in_array($hari, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])) {
                // Pagi
                if ($this->waktu_dalam_rentang("07:50", "08:00")) {
                    $this->kirim_reminder('1', $pesanWA);
                }

                // Sore (Jumat atau bukan)
                if ($hari == 'Jumat') {
                    if ($this->waktu_dalam_rentang("17:00", "17:10")) {
                        $this->kirim_reminder('2', $pesanWA);
                    }
                    if ($this->waktu_dalam_rentang($mulaiIstirahatJumat, date("H:i", strtotime($mulaiIstirahatJumat) + 300))) {
                        $this->kirim_reminder('4', sprintf($pesanMulaiIstirahat, $mulaiIstirahatJumat));
                    }
                    if ($this->waktu_dalam_rentang(date("H:i", strtotime($selesaiIstirahatJumat) - 300), $selesaiIstirahatJumat)) {
                        $this->kirim_reminder('5', $pesanSelesaiIstirahat);
                    }
                } else {
                    if ($this->waktu_dalam_rentang("16:30", "16:40")) {
                        $this->kirim_reminder('2', $pesanWA);
                    }
                    if ($this->waktu_dalam_rentang($mulaiIstirahat, date("H:i", strtotime($mulaiIstirahat) + 300))) {
                        $this->kirim_reminder('4', sprintf($pesanMulaiIstirahat, $mulaiIstirahat));
                    }
                    if ($this->waktu_dalam_rentang(date("H:i", strtotime($selesaiIstirahat) - 300), $selesaiIstirahat)) {
                        $this->kirim_reminder('5', $pesanSelesaiIstirahat);
                    }
                }
            }
        }
    }

    public function update_data()
    {
        $this->load->model('ModelNotifikasi', 'notif');
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $tabel = $this->input->post('tabel');
        $apine = $this->input->post('kuncine');
        if ($apine <> $this->config->item('api_key')) {
            echo json_encode(array("hasill" => "ANDA TIDAK BERHAK AKSES !!!!"));
        } else {
            $pesan = $this->notif->update_data($id, $status, $tabel);
            echo json_encode(array("hasil" => $pesan));
        }
    }
}
