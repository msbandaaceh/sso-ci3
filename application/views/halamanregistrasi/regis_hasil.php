<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0" />

    <title>REGISTRASI</title>

    <meta name="description" content="HALAMAN REGISTRASI" />

    <link rel="icon" href="<?= $this->session->userdata('logo_satker') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= site_url('assets/fonts/boxicons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= site_url('assets/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= site_url('assets/css/theme-default.css') ?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= site_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= site_url('assets/css/page-auth.css') ?>" />
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Helpers -->
    <script src="<?= site_url('assets/js/helpers.js') ?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= site_url('assets/js/config.js') ?>"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="row">
                <!-- Register -->
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-head p-4">
                                <div class="app-brand justify-content-center mb-4">
                                    <img src="<?= $this->session->userdata('logo_satker') ?>" alt="Card image"
                                        height="100" />
                                </div>
                            </div>
                            <div class="app-brand justify-content-center">
                                REGISTRASI PEGAWAI
                            </div>
                            <div class="card-body p-4">

                                <div class="mb-3">
                                    <p class="text-center"><?= $message; ?></p>
                                </div>

                                <div>
                                    <?php if (isset($status)):
                                        if ($status == '1'): ?>
                                            <button class="btn btn-primary d-grid w-100" type="button" data-bs-toggle="modal"
                                                data-bs-target="#daftarUser" onclick="BukaModalUser()">Buat
                                                Akun
                                            </button>
                                        <?php elseif ($status == '2'): ?>
                                            <button class="btn btn-primary d-grid w-100" type="button"
                                                onclick="document.location='<?= site_url('login') ?>'">Login
                                            </button>
                                        <?php elseif ($status == '0'): ?>
                                            <button class="btn btn-primary d-grid w-100" type="button" data-bs-toggle="modal"
                                                data-bs-target="#daftarPegawai" onclick="BukaModal()">Registrasi Pegawai
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>

        <!-- Modal Tambah Pegawai dan User -->
        <div class="modal fade" id="daftarPegawai" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <form method="POST" id="formPegawai" action="<?= site_url('simpan_peg') ?>" class="modal-content"
                    onsubmit="return showLoaderSweetalert2(this)">
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="divider">
                                <div class="divider-text">Pendaftaran Pegawai</div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nip" class="form-label">NIP</label><code> *</code>
                                    <input type="text" id="nip" class="form-control" placeholder="NIP" name="nip"
                                        value="<?= $nip ?>" readonly />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">JABATAN</label><code> *</code>
                                    <div id="jabatan_"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nama_gelar" class="form-label">NAMA (DENGAN
                                        GELAR)</label><code> *</code>
                                    <input type="text" id="nama_gelar" class="form-control"
                                        placeholder="Nama (Dengan Gelar)" name="nama_gelar" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nama" class="form-label">NAMA (TANPA GELAR)</label><code> *</code>
                                    <input type="text" id="nama" class="form-control" placeholder="Nama (Tanpa Gelar)"
                                        name="nama" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nohp" class="form-label">NOMOR HANDPHONE</label><code> *</code>
                                    <input type="text" id="nohp" class="form-control" placeholder="Nomor Handphone"
                                        name="nohp" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">JENIS PEGAWAI</label><code> *</code>
                                    <div id="jenis_"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">PANGKAT GOLONGAN</label><code> *</code>
                                    <div id="pangkat_"></div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Pendaftaran Akun</div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="user" class="form-label">USER NAME</label><code> *</code>
                                    <input type="text" id="user" class="form-control" placeholder="Username" name="user"
                                        value="<?= $nip ?>" readonly />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label">ATASAN LANGSUNG</label>
                                <div id="atasan_"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pass" class="form-label">PASSWORD (Minimal 8
                                        karakter)</label><code> *</code>
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="pass" class="form-control" name="pass"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" autocomplete="off" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="passKonfirm" class="form-label">KONFIRMASI
                                        PASSWORD</label><code> *</code>
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="passKon" class="form-control" name="passKon"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" autocomplete="off" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">E-MAIL</label><code> *</code>
                                    <input type="email" id="surel" class="form-control" placeholder="Alamat E-Mail"
                                        name="surel" autocomplete="off" />
                                </div>
                            </div>
                        </div>

                        <label class="form-label"><code><i>* Wajib Diisi</i></code></label>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="simpanPegawai" class="btn btn-primary">Simpan</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="daftarUser" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <form method="POST" id="formUser" action="<?= site_url('save_user') ?>" class="modal-content"
                    onsubmit="return showLoaderSweetalert2(this)">
                    <div class="modal-body">
                        <input hidden readonly type="text" name="id" id="id" class="form-control" value="<?= $id ?>" />
                        <input hidden readonly type="text" name="fullname" id="fulllname" class="form-control"
                            value="<?= $nama ?>" />
                        <div class="row g-2">
                            <div class="divider">
                                <div class="divider-text">Pendaftaran Akun</div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="username" class="form-label">USER NAME</label><code> *</code>
                                    <input type="text" id="username" class="form-control" placeholder="Username"
                                        name="username" value="<?= $nip ?>" readonly />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label">ATASAN LANGSUNG</label>
                                <div id="atasanuser_"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">PASSWORD (Minimal 8
                                        Karakter)</label><code> *</code>
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" autocomplete="off" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="passKonfirm" class="form-label">KONFIRMASI
                                        PASSWORD</label><code> *</code>
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="passKonfirm" class="form-control"
                                                name="passKonfirm" autocomplete="off"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">E-MAIL</label><code> *</code>
                                    <input type="email" id="email" class="form-control" placeholder="Alamat E-Mail"
                                        name="email" autocomplete="off" />
                                </div>
                            </div>
                        </div>

                        <label class="form-label"><code><i>* Wajib Diisi</i></code></label>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="simpanUser" class="btn btn-primary">Simpan</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

    <script src="<?= site_url('assets/js/menu.js'); ?>"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <!-- jquery-validation -->
    <!-- jquery-validation -->
    <script src="<?= site_url('assets/libs/jquery-validation/jquery.validate.min.js') ?>"></script>
    <script src="<?= site_url('assets/libs/jquery-validation/additional-methods.min.js') ?>"></script>

    <!-- Main JS -->
    <script src="<?= site_url('assets/js/main.js'); ?>"></script>

    <!-- Page JS -->
    <script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
        $(function () {
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
                                    username: function () {
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
                                    username: function () {
                                        return $('#nohp').val();
                                    }
                                }
                            }
                        },
                        pass: {
                            required: true,
                            minlength: 8
                        },
                        surel: {
                            required: true,
                            email: true
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
                        pass: {
                            required: "Password tidak boleh kosong",
                            minlength: "Password tidak boleh kurang dari 8 karakter"
                        },
                        surel: {
                            required: "Email tidak boleh kosong",
                            email: "Email tidak valid"
                        },
                        passKon: {
                            required: "Konfirmasi Password tidak boleh kosong",
                            equalTo: "Password Tidak Sesuai"
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

                $('#formUser').validate({
                    rules: {
                        passKonfirm: {
                            equalTo: "#password",
                            required: true
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                        email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        password: {
                            required: "Password tidak boleh kosong",
                            minlength: "Password tidak boleh kurang dari 8 karakter"
                        },
                        email: {
                            required: "Email tidak boleh kosong",
                            email: "Email tidak valid"
                        },
                        passKonfirm: {
                            required: "Konfirmasi Password tidak boleh kosong",
                            equalTo: "Password Tidak Sesuai"
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
        });

    </script>

    <script type="text/javascript">
        function BukaModal(id) {
            $.post('<?= site_url() ?>show_peg', function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {

                    $("#jabatan_").html('');
                    $("#jenis_").html('');
                    $("#atasan_").html("");
                    $("#pangkat_").html("");

                    $("#jabatan_").append(json.jabatan);
                    $("#jenis_").append(json.jenis);
                    $("#atasan_").append(json.atasan);
                    $("#pangkat_").append(json.pangkat);
                } else if (json.st == 0) {
                    pesan('PERINGATAN', json.msg, '');
                    $('#table_pegawai').DataTable().ajax.reload();
                }
            });
        }

        function BukaModalUser() {
            $.post('<?= site_url() ?>show_peg_user', function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    $("#atasanuser_").html("");

                    $("#atasanuser_").append(json.atasan);
                } else if (json.st == 0) {
                    pesan('PERINGATAN', json.msg, '');
                    $('#table_pegawai').DataTable().ajax.reload();
                }
            });
        }
    </script>
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
</body>

</html>