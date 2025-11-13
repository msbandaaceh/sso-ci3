<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold py-3 mb-4">Daftar Laporan Ticketing</h4>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-error-circle text-danger" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Baru</span>
                        <h3 class="card-title mb-2"><?= $statistik['baru'] ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-time-five text-warning" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Diproses</span>
                        <h3 class="card-title mb-2"><?= $statistik['diproses'] ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-check-circle text-success" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Selesai</span>
                        <h3 class="card-title mb-2"><?= $statistik['selesai'] ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-x-circle text-danger" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Ditolak</span>
                        <h3 class="card-title mb-2"><?= $statistik['ditolak'] ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Export -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bx bx-filter me-2"></i>Filter & Export</h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetFilter()">
                            <i class="bx bx-refresh me-1"></i>Reset
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" method="GET" action="<?= site_url('ticketing') ?>">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" 
                                        value="<?= $this->input->get('tanggal_awal') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                                        value="<?= $this->input->get('tanggal_akhir') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="status_filter" class="form-label">Status (Pilih Banyak)</label>
                                    <select class="form-select" id="status_filter" name="status[]" multiple size="4">
                                        <option value="baru" <?= in_array('baru', $this->input->get('status') ?: []) ? 'selected' : '' ?>>Baru</option>
                                        <option value="diproses" <?= in_array('diproses', $this->input->get('status') ?: []) ? 'selected' : '' ?>>Diproses</option>
                                        <option value="selesai" <?= in_array('selesai', $this->input->get('status') ?: []) ? 'selected' : '' ?>>Selesai</option>
                                        <option value="ditolak" <?= in_array('ditolak', $this->input->get('status') ?: []) ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                    <small class="text-muted">Tekan Ctrl/Cmd untuk pilih banyak</small>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bx bx-search me-1"></i>Filter
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success" onclick="exportPDF()">
                                        <i class="bx bx-file me-1"></i>Export ke PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">
                    <div class="card-body">
                        <table id="tabel_ticketing" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Pelapor</th>
                                    <th>Jenis Laporan</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($tickets as $ticket) {
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
                                    $jenis = isset($jenis_label[$ticket->jenis_laporan]) ? $jenis_label[$ticket->jenis_laporan] : $ticket->jenis_laporan;

                                    $status_badge = [
                                        'baru' => 'bg-label-danger',
                                        'diproses' => 'bg-label-warning',
                                        'selesai' => 'bg-label-success',
                                        'ditolak' => 'bg-label-secondary'
                                    ];
                                    $badge_class = isset($status_badge[$ticket->status]) ? $status_badge[$ticket->status] : 'bg-label-secondary';
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>#<?= $ticket->id ?></td>
                                        <td><?= $ticket->nama_pelapor ?></td>
                                        <td><span class="badge bg-label-info"><?= $jenis ?></span></td>
                                        <td><?= substr($ticket->deskripsi, 0, 100) . (strlen($ticket->deskripsi) > 100 ? '...' : '') ?></td>
                                        <td><span class="badge <?= $badge_class ?>"><?= ucfirst($ticket->status) ?></span></td>
                                        <td><?= date('d/m/Y H:i', strtotime($ticket->created_on)) ?></td>
                                        <td>
                                            <?php $idEncrypt = str_replace('/', '___', $this->encryption->encrypt($ticket->id)); ?>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-target="#detailModal" data-bs-toggle="modal"
                                                        onclick="BukaDetail('<?= base64_encode($this->encryption->encrypt($ticket->id)) ?>')">
                                                        <i class="bx bx-show me-1"></i> Detail
                                                    </button>
                                                    <button class="dropdown-item" data-bs-target="#tindakLanjutModal" data-bs-toggle="modal"
                                                        onclick="BukaTindakLanjut('<?= base64_encode($this->encryption->encrypt($ticket->id)) ?>', '<?= $ticket->status ?>')">
                                                        <i class="bx bx-edit me-1"></i> Tindak Lanjut
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Pelapor</th>
                                    <th>Jenis Laporan</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan Ticketing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tindak Lanjut -->
<div class="modal fade" id="tindakLanjutModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formTindakLanjut" action="<?= site_url('update_tindak_lanjut') ?>" class="modal-content" enctype="multipart/form-data" onsubmit="return showLoaderSweetalert2(this)">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title">Tindak Lanjut Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="ticket_id" />
                <div class="mb-3">
                    <label for="status" class="form-label">Status <code>*</code></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="baru">Baru</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tindak_lanjut" class="form-label">Tindak Lanjut <code>*</code></label>
                    <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="5" required placeholder="Jelaskan tindak lanjut yang telah dilakukan..."></textarea>
                </div>
                <div class="mb-3" id="evidence_upload" style="display: none;">
                    <label for="evidence" class="form-label">Evidence (Foto/PDF) <code id="evidence_required">*</code></label>
                    <input type="file" class="form-control" id="evidence" name="evidence" accept="image/*,.pdf">
                    <small class="text-muted">Format yang diizinkan: JPG, PNG, GIF, PDF. Maksimal 5MB</small>
                    <div id="evidence_preview" class="mt-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
<script src="<?= site_url('assets/js/main.js') ?>"></script>
<script src="<?= site_url('assets/js/sso.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('#tabel_ticketing').DataTable({
            responsive: true,
            order: [[6, 'desc']],
            pageLength: 25
        });
    });

    function BukaDetail(id) {
        $.ajax({
            url: '<?= site_url('ticketing_detail') ?>',
            type: 'POST',
            data: {
                id: id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.st == 1) {
                    var data = response.data;
                    var jenis_label = {
                        'error': 'Error / Kesalahan Sistem',
                        'bug': 'Bug / Kutu Program',
                        'permintaan_fitur': 'Permintaan Fitur Baru',
                        'masalah_jaringan': 'Masalah Jaringan',
                        'masalah_hardware': 'Masalah Hardware / Perangkat',
                        'masalah_software': 'Masalah Software / Aplikasi',
                        'masalah_email': 'Masalah Email',
                        'masalah_printer': 'Masalah Printer',
                        'masalah_internet': 'Masalah Internet / Koneksi',
                        'masalah_akun': 'Masalah Akun / Login',
                        'permintaan_akses': 'Permintaan Akses / Hak Akses',
                        'lainnya': 'Lainnya',
                        'laporan_lainnya': 'Lainnya' // Untuk kompatibilitas data lama
                    };
                    var status_badge = {
                        'baru': 'bg-label-danger',
                        'diproses': 'bg-label-warning',
                        'selesai': 'bg-label-success',
                        'ditolak': 'bg-label-secondary'
                    };
                    var jenis = jenis_label[data.jenis_laporan] || data.jenis_laporan;
                    var badge_class = status_badge[data.status] || 'bg-label-secondary';

                    var html = '<div class="row">';
                    html += '<div class="col-md-6 mb-3"><strong>ID Ticket:</strong><br>#' + data.id + '</div>';
                    html += '<div class="col-md-6 mb-3"><strong>Tanggal:</strong><br>' + data.created_on + '</div>';
                    html += '<div class="col-md-6 mb-3"><strong>Nama Pelapor:</strong><br>' + data.nama_pelapor + '</div>';
                    html += '<div class="col-md-6 mb-3"><strong>Jenis Laporan:</strong><br><span class="badge bg-label-info">' + jenis + '</span></div>';
                    html += '<div class="col-md-6 mb-3"><strong>Status:</strong><br><span class="badge ' + badge_class + '">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span></div>';
                    if (data.ditindak_lanjut_oleh) {
                        html += '<div class="col-md-6 mb-3"><strong>Ditindaklanjuti Oleh:</strong><br>' + data.ditindak_lanjut_oleh + '</div>';
                        html += '<div class="col-md-6 mb-3"><strong>Ditindaklanjuti Pada:</strong><br>' + (data.ditindak_lanjut_pada || '-') + '</div>';
                    }
                    html += '<div class="col-12 mb-3"><strong>Deskripsi:</strong><br><div class="p-3 bg-light rounded">' + data.deskripsi.replace(/\n/g, '<br>') + '</div></div>';
                    if (data.tindak_lanjut) {
                        html += '<div class="col-12 mb-3"><strong>Tindak Lanjut:</strong><br><div class="p-3 bg-light rounded">' + data.tindak_lanjut.replace(/\n/g, '<br>') + '</div></div>';
                    }
                    if (data.evidence) {
                        html += '<div class="col-12 mb-3"><strong>Evidence:</strong><br>';
                        var fileExt = data.evidence.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                            html += '<a href="<?= site_url() ?>' + data.evidence + '" target="_blank"><img src="<?= site_url() ?>' + data.evidence + '" class="img-thumbnail" style="max-width: 400px; max-height: 400px;" alt="Evidence"></a>';
                        } else if (fileExt === 'pdf') {
                            html += '<a href="<?= site_url() ?>' + data.evidence + '" target="_blank" class="btn btn-primary"><i class="bx bx-file"></i> Lihat PDF</a>';
                        } else {
                            html += '<a href="<?= site_url() ?>' + data.evidence + '" target="_blank" class="btn btn-primary"><i class="bx bx-download"></i> Download File</a>';
                        }
                        html += '</div>';
                    }
                    html += '</div>';

                    // Tampilkan log aktivitas (Timeline)
                    if (data.logs && data.logs.length > 0) {
                        html += '<div class="row mt-4">';
                        html += '<div class="col-12">';
                        html += '<hr class="my-4">';
                        html += '<h5 class="mb-4"><i class="bx bx-history me-2"></i>Timeline Proses Ticketing</h5>';
                        html += '<div class="timeline-wrapper" style="position: relative; padding-left: 40px; padding-bottom: 20px;">';
                        
                        // Garis vertikal utama timeline
                        html += '<div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: linear-gradient(to bottom, #696cff, #e0e0e0);"></div>';
                        
                        for (var i = 0; i < data.logs.length; i++) {
                            var log = data.logs[i];
                            var isLast = (i === data.logs.length - 1);
                            
                            var action_label = {
                                'created': 'Ticket Dibuat',
                                'updated': 'Ticket Diperbarui',
                                'status_changed': 'Status Diubah'
                            };
                            var action_icon = {
                                'created': 'bx-plus-circle',
                                'updated': 'bx-edit',
                                'status_changed': 'bx-refresh'
                            };
                            var action_bg = {
                                'created': 'bg-primary',
                                'updated': 'bg-info',
                                'status_changed': 'bg-warning'
                            };
                            
                            var label = action_label[log.action] || log.action;
                            var icon = action_icon[log.action] || 'bx-circle';
                            var bgColor = action_bg[log.action] || 'bg-secondary';
                            
                            html += '<div class="timeline-item mb-4" style="position: relative;">';
                            
                            // Bullet point timeline
                            html += '<div style="position: absolute; left: -29px; top: 8px; width: 24px; height: 24px; border-radius: 50%; background: #fff; border: 3px solid #696cff; z-index: 2; display: flex; align-items: center; justify-content: center;">';
                            html += '<div style="width: 10px; height: 10px; border-radius: 50%; background: #696cff;"></div>';
                            html += '</div>';
                            
                            // Content
                            html += '<div class="card border shadow-sm">';
                            html += '<div class="card-body">';
                            html += '<div class="d-flex align-items-start">';
                            
                            // Icon
                            html += '<div class="flex-shrink-0 me-3">';
                            html += '<div class="avatar ' + bgColor + ' rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">';
                            html += '<i class="bx ' + icon + ' text-white"></i>';
                            html += '</div>';
                            html += '</div>';
                            
                            // Content detail
                            html += '<div class="flex-grow-1">';
                            html += '<h6 class="mb-2">' + label;
                            if (log.status_lama && log.status_baru && log.status_lama !== log.status_baru) {
                                var status_badge_old = {
                                    'baru': 'bg-label-danger',
                                    'diproses': 'bg-label-warning',
                                    'selesai': 'bg-label-success',
                                    'ditolak': 'bg-label-secondary'
                                };
                                var status_badge_new = {
                                    'baru': 'bg-label-danger',
                                    'diproses': 'bg-label-warning',
                                    'selesai': 'bg-label-success',
                                    'ditolak': 'bg-label-secondary'
                                };
                                html += ' <span class="badge ' + (status_badge_old[log.status_lama] || 'bg-label-secondary') + '">' + log.status_lama.charAt(0).toUpperCase() + log.status_lama.slice(1) + '</span>';
                                html += ' <i class="bx bx-right-arrow-alt mx-1"></i>';
                                html += ' <span class="badge ' + (status_badge_new[log.status_baru] || 'bg-label-primary') + '">' + log.status_baru.charAt(0).toUpperCase() + log.status_baru.slice(1) + '</span>';
                            }
                            html += '</h6>';
                            html += '<p class="mb-2 text-muted">' + log.keterangan + '</p>';
                            html += '<div class="d-flex align-items-center text-muted small">';
                            html += '<span class="me-3"><i class="bx bx-user me-1"></i>' + log.dilakukan_oleh + '</span>';
                            html += '<span><i class="bx bx-time me-1"></i>' + log.dilakukan_pada + '</span>';
                            html += '</div>';
                            html += '</div>';
                            
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }
                        
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    } else {
                        html += '<div class="row mt-4">';
                        html += '<div class="col-12">';
                        html += '<hr class="my-4">';
                        html += '<div class="alert alert-info"><i class="bx bx-info-circle me-2"></i>Belum ada riwayat aktivitas</div>';
                        html += '</div>';
                        html += '</div>';
                    }

                    $('#detailContent').html(html);
                } else {
                    $('#detailContent').html('<div class="alert alert-danger">' + response.msg + '</div>');
                }
            },
            error: function() {
                $('#detailContent').html('<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>');
            }
        });
    }

    function BukaTindakLanjut(id, status) {
        $('#ticket_id').val(id);
        $('#status').val(status);
        $('#tindak_lanjut').val('');
        $('#evidence').val('');
        $('#evidence_preview').html('');
        
        // Tampilkan/sembunyikan field evidence berdasarkan status
        if (status === 'selesai') {
            $('#evidence_upload').show();
            $('#evidence_required').show();
            $('#evidence').prop('required', true);
        } else {
            $('#evidence_upload').hide();
            $('#evidence_required').hide();
            $('#evidence').prop('required', false);
        }
    }

    // Toggle evidence upload saat status berubah
    $(document).on('change', '#status', function() {
        var status = $(this).val();
        if (status === 'selesai') {
            $('#evidence_upload').show();
            $('#evidence_required').show();
            $('#evidence').prop('required', true);
        } else {
            $('#evidence_upload').hide();
            $('#evidence_required').hide();
            $('#evidence').prop('required', false);
            $('#evidence').val('');
            $('#evidence_preview').html('');
        }
    });

    // Preview file yang dipilih
    $(document).on('change', '#evidence', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = '';
                if (file.type.startsWith('image/')) {
                    preview = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 300px; max-height: 300px;" alt="Preview">';
                } else if (file.type === 'application/pdf') {
                    preview = '<div class="alert alert-info"><i class="bx bx-file"></i> File PDF: ' + file.name + '</div>';
                }
                $('#evidence_preview').html(preview);
            };
            reader.readAsDataURL(file);
        }
    });

    $(function() {
        $('#formTindakLanjut').validate({
            rules: {
                status: {
                    required: true
                },
                tindak_lanjut: {
                    required: true,
                    minlength: 10
                },
                evidence: {
                    required: function() {
                        return $('#status').val() === 'selesai';
                    }
                }
            },
            messages: {
                status: {
                    required: "Status harus dipilih"
                },
                tindak_lanjut: {
                    required: "Tindak lanjut tidak boleh kosong",
                    minlength: "Tindak lanjut minimal 10 karakter"
                },
                evidence: {
                    required: "Evidence wajib diupload untuk status selesai"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    // Fungsi export PDF
    function exportPDF() {
        var tanggalAwal = $('#tanggal_awal').val();
        var tanggalAkhir = $('#tanggal_akhir').val();
        var status = $('#status_filter').val();
        
        var params = [];
        if (tanggalAwal) {
            params.push('tanggal_awal=' + encodeURIComponent(tanggalAwal));
        }
        if (tanggalAkhir) {
            params.push('tanggal_akhir=' + encodeURIComponent(tanggalAkhir));
        }
        if (status && status.length > 0) {
            status.forEach(function(s) {
                params.push('status[]=' + encodeURIComponent(s));
            });
        }
        
        var url = '<?= site_url('ticketing_export_pdf') ?>';
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        // Buka di window baru untuk print
        window.open(url, '_blank');
    }

    // Fungsi reset filter
    function resetFilter() {
        $('#tanggal_awal').val('');
        $('#tanggal_akhir').val('');
        $('#status_filter').val(null).trigger('change');
        window.location.href = '<?= site_url('ticketing') ?>';
    }

    var info = "<?= $this->session->flashdata('info') ?? ''; ?>";
    var pesan = "<?= $this->session->flashdata('pesan') ?? ''; ?>";
    if (info === '1') {
        sukses(pesan);
    } else if (info === '2') {
        warning(pesan);
    } else if (info === '3') {
        gagal(pesan);
    }
</script>

