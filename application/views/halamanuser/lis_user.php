<style>
    /* Samakan kontainer select2 (yang menggantikan <select>) dengan .form-select */
    .select2-container--default .select2-selection--single {
        display: block;
        width: 100%;
        height: calc(1.5em + .875rem + 2px);
        /* = 1.5em line-height + .4375rem pad-top + .4375rem pad-bottom + 2px border ≈ 40px (sama dengan .form-select) */
        padding: .4375rem 1.875rem .4375rem .875rem;
        font-size: .9375rem;
        font-weight: 400;
        line-height: 1.5;
        color: #697a8d;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23697a8d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .875rem center;
        background-size: 16px 12px;
        border: 1px solid #d9dee3;
        border-radius: .375rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    /* Samakan teks pilihan yang tampil (rendered text) */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: 0;
        padding-right: 0;
        line-height: 1.5;
        color: #697a8d;
        font-size: .9375rem;
        font-weight: 400;
    }

    /* Posisi panah default select2 (yang di kanan selection) disembunyikan,
       karena kita sudah pakai panah SVG dari .form-select di background */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none;
    }

    /* Samakan warna saat focus (sama dengan .form-select:focus) */
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
        border-color: #696cff;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(105, 108, 255, .1);
    }

    /* Placeholder (sama seperti .form-select) */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #697a8d;
    }

    /* Samakan tinggi dropdown (option list) */
    .select2-container--default .select2-results__option {
        padding: .4375rem .875rem;
        font-size: .9375rem;
        color: #697a8d;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #e7e7ff;
        color: #697a8d;
    }

    /* Samakan searchbox di dalam dropdown (jika dropdownParent besar, min-height biar konsisten) */
    .select2-container--default .select2-dropdown {
        border-color: #d9dee3;
        border-radius: .375rem;
        box-shadow: 0 .25rem 1rem rgba(0, 0, 0, .08);
    }

    /* Samakan tampilan clear (x) yang muncul karena allowClear */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        margin-right: 1.25rem;
        color: #697a8d;
        font-size: 1rem;
    }

    /* State invalid (untuk form validation jQuery validate) */
    .is-invalid+.select2-container--default .select2-selection--single {
        border-color: #ff5b5c;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23ff5b5c' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
    }

    .is-invalid+.select2-container--default .select2-selection--single:focus,
    .is-invalid+.select2-container--default.select2-container--open .select2-selection--single {
        border-color: #ff5b5c;
        box-shadow: 0 0 0 .25rem rgba(255, 91, 92, .1);
    }
</style>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold py-3 mb-4">Daftar Data User</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_pegawai'); ?>" data-loader><i
                                class="bx bx-user me-1"></i>
                            Data Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"><i class="bx bx-user-check me-1" data-loader></i>
                            Data User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_jabatan'); ?>" data-loader><i
                                class="bx bx-briefcase me-1"></i>
                            Data Referensi Jabatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('daftar_pangkat'); ?>" data-loader><i
                                class="bx bx-chart me-1"></i>
                            Data Referensi Pangkat</a>
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
                        <table id="tabel_user" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>BLOKIR</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($user as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $item->fullname; ?>
                                        </td>
                                        <td>
                                            <?= $item->username; ?>
                                        </td>
                                        <td>
                                            <?= $item->email; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->block == "0") {
                                                ?> <span class="badge bg-label-success me-1">Tidak</span>
                                                <?php
                                            } else {
                                                ?> <span class="badge bg-label-warning me-1">Ya</span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php $idEncrypt = str_replace('/', '___', $this->encryption->encrypt($item->userid)); ?>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-target="#tambahModal"
                                                        data-bs-toggle="modal"
                                                        onclick="BukaModal('<?= base64_encode($this->encryption->encrypt($item->userid)) ?>')"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</button>
                                                    <a class="dropdown-item" id="hapus" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal" data-id="<?= $idEncrypt; ?>"><i
                                                            class="bx bx-trash me-1"></i> Hapus</a>
                                                    <a class="dropdown-item" id="reset" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#resetModal" data-id="<?= $idEncrypt; ?>"><i
                                                            class="bx bx-trash me-1"></i> Reset Perangkat
                                                        Presensi</a>
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
                                    <th>NAMA</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>BLOKIR</th>
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

<!-- Modal Tambah/Edit User -->
<div class="modal fade" id="tambahModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="formUser" action="<?= site_url('simpan_user') ?>" class="modal-content"
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
                        <div class="form-group">
                            <label for="pegawai" class="form-label">PEGAWAI</label><code> *</code>
                            <div id="pegawai_"></div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">USERNAME</label>
                            <input type="text" id="username" autocomplete="off" class="form-control"
                                placeholder="Username" name="username" readonly />
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">PASSWORD</label><code> *</code>
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" autocomplete="off" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="passKonfirm" class="form-label">KONFIRMASI PASSWORD</label><code> *</code>
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="passKonfirm" class="form-control" name="passKonfirm"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" autocomplete="off" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                            <label for="atasan" class="form-label">ATASAN LANGSUNG</label>
                            <div id="atasan_"></div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">E-MAIL</label><code> *</code>
                            <input type="email" id="email" class="form-control" autocomplete="off"
                                placeholder="Alamat E-Mail" name="email" />
                        </div>
                        <div class="form-group">
                            <label for="blok" class="form-label">BLOKIR PENGGUNA</label><code> *</code>
                            <div id="blok_"></div>
                        </div>
                    </div>
                </div>

                <h4 class="form-label"><code><i>* Wajib Diisi</i></code></h4>
            </div>

            <div class="modal-footer">
                <button type="submit" id="simpanPegawai" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Pegawai -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formPengguna" class="modal-content" onsubmit="return showLoaderSweetalert2(this)">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">HAPUS DATA PENGGUNA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="hapusPengguna" class="btn btn-danger" role="button"><span
                        class="badge bg-danger">Hapus</span></a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reset Perangkat User -->
<div class="modal fade" id="resetModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formReset" class="modal-content" onsubmit="return showLoaderSweetalert2(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">RESET DATA PERANGKAT PENGGUNA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="dropdown-divider"></div>
            <div class="modal-body">
                <blockquote class="blockquote mt-3">
                    <p>Apakah anda yakin akan mereset data perangkat user ini?</p>
                </blockquote>
            </div>

            <div class="modal-footer">
                <a id="resetPengguna" class="btn btn-danger" role="button"><span
                        class="badge bg-danger">Reset</span></a>
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
<script src="<?= site_url('assets/libs/select2/js/select2.min.js') ?>"></script>
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
    $(document).ready(function () {
        $.validator.addMethod("valueNotEquals", function (value, element, arg) {
            return arg !== value;
        }, "Value must not equal arg.");
    });

    $(function () {
        $("#tabel_user").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabel_user_wrapper .col-md-6:eq(0)');

        $("#btn-close").click(function () {
            var form = $('#formUser');

            // Reset field validation (hapus .is-invalid & error <span>)
            form.validate().resetForm();
        });

        $('#formUser').validate({
            rules: {
                password: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                passKonfirm: {
                    equalTo: "#password"
                },
                pegawai: {
                    valueNotEquals: "0"
                },
                blok: {
                    valueNotEquals: "2"
                }
            },
            messages: {
                password: {
                    required: "Password Harus Diisi"
                },
                email: {
                    required: "Email harus diisi",
                    email: "Masukkan Email yang valid"
                },
                passKonfirm: {
                    equalTo: "Password Tidak Sesuai"
                },
                pegawai: {
                    valueNotEquals: "Pegawai harus dipilih"
                },
                blok: {
                    valueNotEquals: "Status blokir harus dipilih"
                }
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

    $(document).on("click", "#hapus", function () {
        var id = $(this).data('id');
        $('#hapusPengguna').attr('href', 'hapus_user/' + id);
    })

    $(document).on("click", "#reset", function () {
        var id = $(this).data('id');
        $('#resetPengguna').attr('href', 'reset_perangkat/' + id);
    })

    //Merubah Username Pegawai dengan NIP ketika memilih pegawai
    function TampilUsername() {
        var id_pegawai = $('#pegawai').val();
        $.post('get_nip', {
            id: id_pegawai
        }, function (response) {
            var json = jQuery.parseJSON(response);
            if (json.st == 1) {
                if (json.nip != "") {
                    $("#username").val(json.nip);
                } else {
                    $("#username").removeAttr('readonly');
                }
            } else if (json.st == 0) {
                pesan('PERINGATAN', json.msg, '');
                $('#table_suratkeluar').DataTable().ajax.reload();
            }
        });
    }
</script>

<script type="text/javascript">
    function BukaModal(id) {
        $.post('show_user', {
            id: id
        }, function (response) {
            var json = jQuery.parseJSON(response);
            if (json.st == 1) {
                $("#judul").html("");
                $("#id").val('');
                $("#pegawai_").html('');
                $("#username").val('');
                $('#password').val('');
                $('#passKonfirm').val('');
                $("#email").val('');
                $("#blok_").html("");
                $("#atasan_").html("");

                $("#judul").append(json.judul);
                $("#id").val(json.id);
                $("#pegawai_").append(json.pegawai);
                $("#username").val(json.username);
                $('#password').val(json.password);
                $('#passKonfirm').val(json.password);
                $("#email").val(json.email);
                $("#blok_").append(json.blok);
                $("#atasan_").append(json.atasan);

                // Hancurkan instance select2 lama (jika ada) sebelum inisialisasi ulang,
                // supaya tidak terjadi double-widget / error "select2 already initialized"
                if ($("#pegawai").data('select2')) {
                    $("#pegawai").select2('destroy');
                }
                if ($("#atasan").data('select2')) {
                    $("#atasan").select2('destroy');
                }

                // Inisialisasi select2.
                // dropdownParent PENTING di Bootstrap modal: tanpa ini dropdown
                // terpotong / tertutup backdrop sehingga data "tidak muncul".
                $("#pegawai").select2({
                    width: '100%',
                    placeholder: '-- Pilih Pegawai --',
                    allowClear: true,
                    dropdownParent: $('#tambahModal')
                });
                $("#atasan").select2({
                    width: '100%',
                    placeholder: '-- Pilih Atasan --',
                    allowClear: true,
                    dropdownParent: $('#tambahModal')
                });

                // Trigger change supaya nilai dari server (selected) tertampil di select2
                $("#pegawai").val($("#pegawai").val()).trigger('change');
                $("#atasan").val($("#atasan").val()).trigger('change');
            } else if (json.st == 0) {
                pesan('PERINGATAN', json.msg, '');
                $('#table_pegawai').DataTable().ajax.reload();
            }
        });
    }
</script>
<script src="<?= site_url('assets/js/main.js') ?>"></script>

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