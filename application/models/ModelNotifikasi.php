<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelNotifikasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function tambahNotif($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    public function format_nomorhp($nohp)
    {
        $nohps = explode("/", str_replace("'", "", $nohp));
        $nohp = $nohps[0];
        if ((substr($nohp, 0, 3) == '+62') or (substr($nohp, 0, 2) == '62')) {
            $hp = $nohp;
        } else {
            $hp = substr_replace("$nohp", "62", 0, 1);
        }

        return $hp;
    }

    public function notif()
    {
        $notif = [];
        try {
            $kweri_notif = $this->db->query("SELECT 
            n.id AS id,
            n.id_pemohon AS id_pemohon,
            p.`fullname` AS nama_pemohon,
            n.jenis_pesan AS jenis_pesan,
            n.pesan AS pesan,
            n.id_tujuan AS id_tujuan,
            pe.fullname AS nama_tujuan,
            pe.nohp AS hp,
            n.status AS stat
        FROM sys_notif n
        LEFT JOIN v_users p ON n.id_pemohon = p.pegawai_id
        LEFT JOIN v_users pe ON n.id_tujuan = pe.pegawai_id
        WHERE n.status = 0 AND n.jenis_pesan <> 'wag'");

            if ($kweri_notif->num_rows() > 0) {
                foreach ($kweri_notif->result() as $row) {

                    //$cari = array("#jenis_perkara#", "#namap#", "#tgl_daftar#", "#noperk#");
                    //$ganti = array($row->jenis_perkara_nama, str_replace("'", "''", $row->namap), $row->tgl_daftar, $row->nomor_perkara);
                    $pesans = "*[NOTIFIKASI OTOMATIS ".$this->session->userdata('nama_app')." MS BANDA ACEH]*\n\n" . $row->pesan . "\n\nPesan ini dikirim otomatis oleh sistem Mahkamah Syar'iyah Banda Aceh";
                    //$tanggals = date("Y-m-d H:i:s");
                    //$this->db->query("insert into waku.perkara_daftar(perkara_id,nomor_perkara,tanggal_daftar,nama_pihak,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->tgl_daftar','" . str_replace("'", "''", $row->namap) . "','$row->telp1','$pesans','$tanggals')");
                    $pesan = array(
                        "telp" => $this->format_nomorhp($row->hp),
                        "pesan" => $pesans,
                        "tabel" => "sys_notif",
                        "id" => $row->id
                    );
                    $notif[] = $pesan;
                }
                return $notif;
            }


        } catch (Exception $e) {
            $pesan = array("error" => $e);
            $notif[] = $pesan;
        }
    }

    public function notif_wag()
    {
        $notif = [];
        try {
            $kweri_notif = $this->db->query("SELECT * FROM sys_notif WHERE jenis_pesan = 'wag' AND status = 0");

            if ($kweri_notif->num_rows() > 0) {
                foreach ($kweri_notif->result() as $row) {

                    //$cari = array("#jenis_perkara#", "#namap#", "#tgl_daftar#", "#noperk#");
                    //$ganti = array($row->jenis_perkara_nama, str_replace("'", "''", $row->namap), $row->tgl_daftar, $row->nomor_perkara);
                    $pesans = "*[NOTIFIKASI OTOMATIS LITERASI MS BANDA ACEH]*\n\n" . $row->pesan . "\n\nPesan ini dikirim otomatis oleh sistem LITERASI Mahkamah Syar'iyah Banda Aceh";
                    //$tanggals = date("Y-m-d H:i:s");
                    //$this->db->query("insert into waku.perkara_daftar(perkara_id,nomor_perkara,tanggal_daftar,nama_pihak,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->tgl_daftar','" . str_replace("'", "''", $row->namap) . "','$row->telp1','$pesans','$tanggals')");
                    $pesan = array(
                        "pesan" => $pesans,
                        "tabel" => "sys_notif",
                        "id" => $row->id
                    );
                    $notif[] = $pesan;
                }
                return $notif;
            }


        } catch (Exception $e) {
            $pesan = array("error" => $e);
            $notif[] = $pesan;
        }
    }

    public function update_data($id, $status, $tabel)
    {
        $notif = [];
        try {
            $kweri_daftar = $this->db->query("UPDATE $tabel
                    SET status = $status
                    WHERE id=$id");

        } catch (Exception $e) {
            $pesan = array("error" => $e);
            $notif[] = $pesan;
        }

        return $notif;
    }

    public function get_rapat_5_menit_sebelum_mulai()
    {
        // Mendapatkan waktu sekarang
        $this->db->select('*');
        $this->db->from('register_rapat');
        $this->db->where('TIME(NOW()) BETWEEN TIME(mulai) - INTERVAL 5 MINUTE AND TIME(mulai)');
        $this->db->where('tanggal = DATE(NOW())');
        $this->db->where('reminder', 0);

        // Menjalankan query dan mengambil hasilnya
        $query = $this->db->get();
        return $query;
    }
    
    public function cek_reminder_presensi($jenis)
    {
        try {
            $this->db->where('status', '0');
            $this->db->where('tanggal', date('Y-m-d'));
            $this->db->where('jenis', $jenis);
            return $this->db->get('reminder');
        } catch (Exception $e) {
            return $e;
        }
    }
}