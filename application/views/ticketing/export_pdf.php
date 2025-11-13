<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ticketing - <?= $nama_app ?></title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header img {
            max-height: 60px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16pt;
        }
        .header p {
            margin: 2px 0;
            font-size: 9pt;
        }
        .filter-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 4px solid #696cff;
        }
        .filter-info p {
            margin: 3px 0;
            font-size: 9pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9pt;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #696cff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-baru { background-color: #ff6b6b; color: white; }
        .badge-diproses { background-color: #ffa500; color: white; }
        .badge-selesai { background-color: #51cf66; color: white; }
        .badge-ditolak { background-color: #868e96; color: white; }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8pt;
            color: #666;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <?php if (!empty($logo_satker) && file_exists(FCPATH . $logo_satker)): ?>
            <img src="<?= base_url($logo_satker) ?>" alt="Logo">
        <?php endif; ?>
        <h2><?= $nama_app ?></h2>
        <p><?= $nama_satker ?></p>
        <p><strong>LAPORAN TICKETING</strong></p>
    </div>

    <div class="filter-info">
        <p><strong>Periode:</strong> 
            <?php if ($tanggal_awal && $tanggal_akhir): ?>
                <?= date('d/m/Y', strtotime($tanggal_awal)) ?> - <?= date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?php elseif ($tanggal_awal): ?>
                Dari: <?= date('d/m/Y', strtotime($tanggal_awal)) ?>
            <?php elseif ($tanggal_akhir): ?>
                Sampai: <?= date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?php else: ?>
                Semua Periode
            <?php endif; ?>
        </p>
        <p><strong>Status:</strong> 
            <?php 
            if (!empty($status_filter)) {
                $status_labels = [
                    'baru' => 'Baru',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak'
                ];
                $status_display = [];
                foreach ($status_filter as $s) {
                    $status_display[] = isset($status_labels[$s]) ? $status_labels[$s] : $s;
                }
                echo implode(', ', $status_display);
            } else {
                echo 'Semua Status';
            }
            ?>
        </p>
        <p><strong>Total Data:</strong> <?= count($tickets) ?> laporan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 8%;">ID</th>
                <th style="width: 15%;">Nama Pelapor</th>
                <th style="width: 12%;">Jenis</th>
                <th style="width: 25%;">Deskripsi</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 10%;">Ditindaklanjuti</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $jenis_label = [
                'error' => 'Error / Kesalahan Sistem',
                'bug' => 'Bug / Kutu Program',
                'permintaan_fitur' => 'Permintaan Fitur Baru',
                'masalah_jaringan' => 'Masalah Jaringan',
                'masalah_hardware' => 'Masalah Hardware / Perangkat',
                'masalah_software' => 'Masalah Software / Aplikasi',
                'masalah_email' => 'Masalah Email',
                'masalah_printer' => 'Masalah Printer',
                'masalah_internet' => 'Masalah Internet / Koneksi',
                'masalah_akun' => 'Masalah Akun / Login',
                'permintaan_akses' => 'Permintaan Akses / Hak Akses',
                'lainnya' => 'Lainnya',
                'laporan_lainnya' => 'Lainnya' // Untuk kompatibilitas data lama
            ];
            foreach ($tickets as $ticket): 
                $jenis = isset($jenis_label[$ticket->jenis_laporan]) ? $jenis_label[$ticket->jenis_laporan] : $ticket->jenis_laporan;
            ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <td class="text-center">#<?= $ticket->id ?></td>
                <td><?= $ticket->nama_pelapor ?></td>
                <td><?= $jenis ?></td>
                <td><?= substr($ticket->deskripsi, 0, 100) . (strlen($ticket->deskripsi) > 100 ? '...' : '') ?></td>
                <td class="text-center">
                    <span class="badge badge-<?= $ticket->status ?>">
                        <?= ucfirst($ticket->status) ?>
                    </span>
                </td>
                <td class="text-center"><?= date('d/m/Y H:i', strtotime($ticket->created_on)) ?></td>
                <td class="text-center">
                    <?php if ($ticket->ditindak_lanjut_oleh): ?>
                        <?= $ticket->ditindak_lanjut_oleh ?><br>
                        <small><?= date('d/m/Y', strtotime($ticket->ditindak_lanjut_pada)) ?></small>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
            $no++;
            endforeach; 
            ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
        <p>Oleh: <?= $this->session->userdata('fullname') ?></p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

