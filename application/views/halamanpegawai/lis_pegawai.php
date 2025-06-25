<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold py-3 mb-4">Daftar Data Pegawai</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active"><i class="bx bx-user me-1"></i>
                            Daftar Data Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_user'); ?>" data-loader><i
                                class="bx bx-user-check me-1"></i>
                            Daftar Data User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_jabatan'); ?>" data-loader><i
                                class="bx bx-briefcase me-1"></i>
                            Daftar Data Jabatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_pangkat'); ?>" data-loader><i
                                class="bx bx-chart me-1"></i>
                            Daftar Data Pangkat</a>
                    </li>
                </ul>
                <!-- Bootstrap Table with Header - Footer -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-right">
                            <button type="button" class="btn btn-primary"
                                onclick="BukaModal('<?php echo base64_encode($this->encryption->encrypt(-1)); ?>')"
                                data-bs-toggle="modal" data-bs-target="#tambahModal"><i
                                    class="bx bx-plus me-1"></i>Tambah
                                Data</button>
                        </div>
                        <table id="tabel_pegawai" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>GOLONGAN/PANGKAT</th>
                                    <th>JABATAN</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pegawai as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $item->nip; ?>
                                        </td>
                                        <td>
                                            <?= $item->nama; ?>
                                        </td>
                                        <td>
                                            <?= $item->golongan; ?> |
                                            <?= $item->pangkat; ?>
                                        </td>
                                        <td>
                                            <?= $item->nama_jabatan; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->status_pegawai == "1") {
                                                ?> <span class="badge bg-label-success me-1">Aktif</span>
                                                <?php
                                            } else {
                                                ?> <span class="badge bg-label-warning me-1">Non Aktif</span>
                                                <?php
                                            }
                                            ?>
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
                                                        onclick="BukaModal('<?= base64_encode($this->encryption->encrypt($item->id)) ?>')"
                                                        data-bs-toggle="modal"><i class="bx bx-edit-alt me-1"></i>
                                                        EDIT</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal" data-id="<?= $idEncrypt; ?>"
                                                        data-loader><i class="bx bx-trash me-1"></i>
                                                        HAPUS</a>
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
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>GOLONGAN/PANGKAT</th>
                                    <th>JABATAN</th>
                                    <th>STATUS</th>
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

<!-- Modal Tambah/Edit Pegawai -->
<div class="modal fade" id="tambahModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formPegawai" action="<?= site_url('simpan_pegawai') ?>" class="modal-content"
            onsubmit="return showLoaderSweetalert2(this)" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
                <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <input hidden type="text" name="id" id="id" class="form-control" />
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP"
                                autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="jabatan" class="form-label">JABATAN</label><code> *</code>
                            <div id="jabatan_"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nama_gelar" class="form-label">NAMA (DENGAN GELAR)</label><code> *</code>
                            <input type="text" id="nama_gelar" class="form-control" placeholder="Nama Dengan Gelar"
                                name="nama_gelar" value="<?php echo set_value('nama_gelar'); ?>" autocomplete="off" />
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="alamat" class="form-label">ALAMAT</label>
                            <input type="text" id="alamat" class="form-control" placeholder="Alamat" name="alamat"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nama" class="form-label">NAMA (TANPA GELAR)</label><code> *</code>
                            <input type="text" id="nama" class="form-control" placeholder="Nama Tanpa Gelar" name="nama"
                                autocomplete="off" />
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="ket" class="form-label">KETERANGAN</label>
                            <input type="text" id="ket" class="form-control" name="ket" placeholder="Keterangan"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="pangkat" class="form-label">PANGKAT | GOLONGAN</label><code> *</code>
                            <div id="pangkat_"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="nohp" class="form-label">NOMOR HANDPHONE</label><code> *</code>
                            <input type="text" id="nohp" class="form-control" name="nohp" placeholder="Nomor Handphone"
                                autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="aktif" class="form-label">STATUS PEGAWAI</label><code> *</code>
                            <div id="aktif_"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="jenis" class="form-label">JENIS PEGAWAI</label><code> *</code>
                            <div id="jenis_"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="tmt" class="form-label">TMT PEGAWAI</label>
                            <input type="date" placeholder="Terhitung Mulai Tanggal Pegawai" class="form-control"
                                id="tmt" name="tmt">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="jenis" class="form-label">JENIS KELAMIN</label>
                            <div id="jk_"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="foto" class="form-label">FOTO</label>
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img alt="user-avatar" class="d-block rounded" height="180" width="120"
                                    id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Pilih Foto</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                    </label>

                                    <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                </div>
                            </div>
                            <input hidden type="file" id="foto" name="foto" class="account-file-input"
                                accept="image/png" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-0">
                        <div class="form-group">
                            <label for="ttd" class="form-label">TANDA TANGAN</label>
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img alt="user-avatar" class="d-block rounded" height="180" width="120"
                                    id="uploadedSignature" />
                                <div class="button-wrapper">
                                    <label for="ttd" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Pilih Tanda Tangan</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                    </label>

                                    <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                </div>
                            </div>
                            <input hidden type="file" id="ttd" name="ttd" class="account-file-input"
                                accept="image/png" />
                        </div>
                    </div>
                </div>
                <label class="form-label"><code><i>* Wajib Diisi</i></code></label>
            </div>

            <div class="modal-footer">
                <button type="submit" id="simpanPegawai" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Pegawai -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formPegawai" class="modal-content" onsubmit="return showLoaderSweetalert2(this)">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA PEGAWAI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="hapusPegawai" class="btn btn-danger" role="button"><span class="badge bg-danger">Hapus</span></a>
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
    // Fungsi untuk menampilkan preview gambar
    function previewImage(input, imgElementId) {
        const file = input.files[0];
        const preview = document.getElementById(imgElementId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result; // Set src ke hasil pembacaan
            }
            reader.readAsDataURL(file); // Baca file sebagai URL data
        }
    }

    // Event listener untuk foto pegawai
    document.getElementById('foto').addEventListener('change', function () {
        previewImage(this, 'uploadedAvatar'); // Menampilkan preview pada gambar pegawai
    });

    document.getElementById('ttd').addEventListener('change', function () {
        previewImage(this, 'uploadedSignature'); // Menampilkan preview pada gambar pegawai
    });
</script>

<script>
    $(function () {
        $("#tabel_pegawai").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabel_pegawai_wrapper .col-md-6:eq(0)');

        $("#btn-close").click(function () {
            var form = $('#formPegawai');

            // Reset field validation (hapus .is-invalid & error <span>)
            form.validate().resetForm();
        });
    });

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusPegawai').attr('href', '<?= base_url() ?>hapus_pegawai/' + id);
    })

    $(document).ready(function () {
        $.validator.addMethod("valueNotEquals", function (value, element, arg) {
            return arg !== value;
        }, "Value must not equal arg.");

        $('#formPegawai').validate({
            rules: {
                passKon: {
                    equalTo: "#pass",
                    required: true
                },
                nama_gelar: {
                    required: true,
                    maxlength: 60
                },
                nama: {
                    required: true,
                    maxlength: 40
                },
                jabatan: {
                    valueNotEquals: "0",
                    remote: {
                        url: '<?= site_url() ?>cek_jabatan',
                        type: 'post',
                        data: {
                            jabatan: function () {
                                return $('#jabatan').val();
                            }
                        }
                    }
                },
                jenis: {
                    valueNotEquals: "0"
                },
                pangkat: {
                    valueNotEquals: "0"
                },
                nohp: {
                    required: true,
                    maxlength: 14,
                    remote: {
                        url: '<?= site_url() ?>cek_nohp',
                        type: 'post',
                        data: {
                            nohp: function () {
                                return $('#nohp').val();
                            }
                        }
                    }
                },
                stat: {
                    valueNotEquals: "2"
                }
            },
            messages: {
                nama_gelar: {
                    required: "Nama (Dengan Gelar) tidak boleh kosong",
                    maxlength: "Nama Gelar tidak boleh melebihi 60 karakter"
                },
                nama: {
                    required: "Nama tidak boleh kosong",
                    maxlength: "Nama Tanpa Gelar tidak boleh melebihi 40 karakter"
                },
                jabatan: {
                    valueNotEquals: "Jabatan harus dipilih",
                    remote: "Ada pegawai aktif yang menduduki jabatan yang anda pilih, silakan hubungi bagian kepegawaian"
                },
                jenis: {
                    valueNotEquals: "Jenis Pegawai harus dipilih"
                },
                pangkat: {
                    valueNotEquals: "Pangkat Golongan harus dipilih"
                },
                nohp: {
                    required: "Nomor Handphone tidak boleh kosong",
                    maxlength: "Nomor Handphone tidak boleh melebihi 14 karakter",
                    remote: "Nomor Handphone sudah dipakai"
                },
                stat: {
                    valueNotEquals: "Status keaktifan harus dipilih"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

</script>

<script type="text/javascript">
    function BukaModal(id) {
        $.post('show_pegawai', {
            id: id
        }, function (response) {
            var json = jQuery.parseJSON(response);
            if (json.st == 1) {
                $("#judul").html("");
                $("#nip").val('');
                $("#nama_gelar").val('');
                $("#nama").val('');
                $("#alamat").val('');
                $("#id").val('');
                $("#ket").val('');
                $("#aktif_").html("");
                $("#jenis_").html("");
                $("#jabatan_").html("");
                $("#nohp").val('');
                $("#pangkat_").html("");
                $("#tmt").val('');
                $("#jk_").html('');
                $("#judul").append(json.judul);
                $("#nip").val(json.nip);
                $("#nama_gelar").val(json.nama_gelar);
                $("#nama").val(json.nama);
                $("#alamat").val(json.alamat);
                $("#ket").val(json.ket);
                $("#id").val(json.id);
                $("#nohp").val(json.nohp);
                $("#tmt").val(json.tmt);
                $("#aktif_").append(json.aktif);
                $("#jenis_").append(json.jenis);
                $("#jabatan_").append(json.jabatan);
                $("#pangkat_").append(json.pangkat);
                $("#jk_").append(json.jk);

                const preview = document.getElementById('uploadedAvatar');
                if (json.foto) {
                    preview.src = '<?= site_url() ?>' + json.foto;
                } else {
                    preview.src = '<?= site_url('assets/img/1.png') ?>';
                }

                const preview_ttd = document.getElementById('uploadedSignature');
                if (json.ttd) {
                    preview_ttd.src = '<?= site_url() ?>' + json.ttd;
                } else {
                    preview_ttd.src = '<?= site_url('assets/img/1.png') ?>';
                }
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

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>