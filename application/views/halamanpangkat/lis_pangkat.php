<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10">
                <h4 class="fw-bold py-3 mb-4">Daftar Data Pangkat</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_pegawai'); ?>" data-loader><i class="bx bx-user me-1"></i>
                            Daftar Data Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_user'); ?>" data-loader><i class="bx bx-user-check me-1"></i>
                            Daftar Data User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_jabatan'); ?>" data-loader><i
                                class="bx bx-briefcase me-1"></i>
                            Daftar Data Jabatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"><i class="bx bx-chart me-1"></i>
                            Daftar Data Pangkat</a>
                    </li>
                </ul>
                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-right">
                            <button type="button" class="btn btn-primary"
                                onclick="ModalPangkat('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"
                                data-bs-toggle="modal" data-bs-target="#tambahModal"><i
                                    class="bx bx-plus me-1"></i>Tambah
                                Data</button>
                        </div>
                        <table id="tabel_pangkat" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>GOLONGAN</th>
                                    <th>PANGKAT</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pangkat as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $item->golongan; ?>
                                        </td>
                                        <td>
                                            <?= $item->pangkat; ?>
                                        </td>
                                        <td>
                                            <?php $idEncrypt = str_replace('/', '___', $this->encryption->encrypt($item->id)); ?>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-target="#tambahModal"
                                                        onclick="ModalPangkat('<?= base64_encode($this->encryption->encrypt($item->id)) ?>')"
                                                        data-bs-toggle="modal"><i class="bx bx-edit-alt me-1"></i>
                                                        Edit</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal" data-id="<?= $idEncrypt; ?>" data-loader><i
                                                            class="bx bx-trash me-1"></i>
                                                        Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>GOLONGAN</th>
                                    <th>PANGKAT</th>
                                    <th>AKSI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- Bootstrap Table with Header - Footer -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Golongan Pangkat -->
<div class="modal fade" id="tambahModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formPegawai" action="<?= site_url('simpan_pangkat') ?>" class="modal-content"
            onsubmit="return showLoaderSweetalert2(this)">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <input hidden type="text" name="id" id="id" class="form-control" />
                <div class="row g-2">
                    <div class="col mb-3">
                        <label for="golongan" class="form-label">Golongan</label><code> *</code>
                        <input type="text" name="golongan" id="golongan" class="form-control"
                            placeholder="Masukkan Nama Golongan" autocomplete="off" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-3">
                        <label for="pangkat" class="form-label">Pangkat</label><code> *</code>
                        <input type="text" name="pangkat" id="pangkat" class="form-control"
                            placeholder="Masukkan Pangkat" autocomplete="off" />
                    </div>
                </div>
                <span class="form-label"><code><i>* Wajib Diisi</i></code></span>
            </div>

            <div class="modal-footer">
                <button type="submit" id="simpanPegawai" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Hapus Pangkat -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formPegawai" class="modal-content" onsubmit="return showLoaderSweetalert2(this)">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA PANGKAT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="hapusPangkat" class="btn btn-danger" role="button"><span class="badge bg-danger">Hapus</span></a>
            </div>
        </form>
    </div>
</div>

<script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
<script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
<script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= site_url('assets/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>

<!-- jquery-validation -->
<script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?= site_url('assets/libs/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?= site_url('assets/libs/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>

<script>
    $(function () {
        $("#tabel_pangkat").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabel_pangkat_wrapper .col-md-6:eq(0)');
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusPangkat').attr('href', 'hapus_pangkat/' + id);
    })
</script>

<script type="text/javascript">

    function ModalPangkat(id) {
        $.post('show_pangkat', {
            id: id
        }, function (response) {
            var json = jQuery.parseJSON(response);
            if (json.st == 1) {
                $("#judul").html("");
                $("#id").val('');
                $("#pangkat").val('');
                $("#golongan").val('');
                $("#judul").append(json.judul);
                $("#id").val(json.id);
                $("#pangkat").val(json.pangkat);
                $("#golongan").val(json.golongan);
            } else if (json.st == 0) {
                pesan('PERINGATAN', json.msg, '');
                $('#table_pegawai').DataTable().ajax.reload();
            }
        });
    }
</script>

<!-- Page JS -->
<script src="<?= site_url('assets/js/sso.js') ?>"></script>

<script>
    var info = "<?= $this->session->flashdata('info') ?? ''; ?>";
    var pesan = "<?= $this->session->flashdata('pesan') ?>"
    if (info === '1') {
        sukses(pesan);
    } else if (info === '2') {
        warning(pesan);
    } else if (info === '3') {
        gagal(pesan);
    }
</script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>