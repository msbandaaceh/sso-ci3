<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0" />

    <title>Login SSO <?= $this->session->userdata('nama_satker') ?></title>

    <meta name="description" content="Halaman Login SSO MS Banda Aceh" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= site_url($this->session->userdata('logo_satker')) ?>" />

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
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= site_url('assets/css/page-auth.css') ?>" />
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
            <div class="authentication-inner">
                <!-- Register -->
                <div class="row">
                    <div>
                        <div class="app-brand justify-content-center mb-4">
                            <img src="<?= site_url($this->session->userdata('logo_satker')) ?>" alt="Card image"
                                height="75" />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <h4>
                            <p class="text-center"><?= $this->session->userdata('nama_app') ?></p>
                        </h4>
                        <div class="divider divider-primary">
                            <div class="divider-text">
                                <div class="text-muted"><?= $this->session->userdata('title_app') ?>
                                </div>
                            </div>
                        </div>
                        <!-- /Logo -->

                        <?php if ($this->session->userdata('login_error')) { ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $this->session->userdata('login_error') ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->userdata('validation')) { ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $this->session->userdata('validation') ?>
                            </div>
                        <?php } ?>

                        <form action="validasi" id="loginForm" method="POST"
                            onsubmit="return showLoaderSweetalert2(this)">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <code><?php echo form_error('username'); ?></code>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Masukkan Username" autofocus autocomplete="off"
                                    value="<?= set_value('username'); ?>" />
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password</label>
                                    </div>
                                    <code><?php echo form_error('password'); ?></code>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" autocomplete="off" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>

                            <?php if ($this->session->userdata('login_attempts') >= 3): ?>
                                <div class="divider">
                                    <div class="divider-text">
                                        CAPTCHA
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="g-recaptcha" style="display: grid; place-items: center;"
                                        data-sitekey="6LfWeOMpAAAAADEva2cBc61p8-sIgPbo34R_76wY"></div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign
                                    in</button>
                            </div>

                            <p class="text-center">

                                <span>Apakah anda tamu ?</span>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tamuModal" onclick="BukaModal()">
                                    <span>Isi Buku Tamu</span>
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
                <div class="mt-3">
                    <div class="text-center">Copyright © 2024 - <?= date('Y') ?> All Right Reserved. Powered by Bagian
                        Teknologi Informasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tamuModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form method="POST" id="formTamu" action="simpan_tamu" class="modal-content"
                onsubmit="return showLoaderSweetalert2(this)">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul">ISI BUKU TAMU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body">

                    <input hidden type="text" name="id" id="id" class="form-control" />
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="nama_tamu" class="form-label">NAMA</label><code> *</code>
                            <input type="text" name="nama_tamu" id="nama_tamu" class="form-control"
                                placeholder="Masukkan Nama Anda" autocomplete="off" />
                        </div>
                        <div class="col mb-0">
                            <label for="tujuan" class="form-label">TUJUAN BERKUNJUNG</label><code> *</code>
                            <select id="tujuan" name="tujuan" class="form-select">
                                <option value="KONSULTASI" selected="selected">KONSULTASI</option>
                                <option value="KOORDINASI">KOORDINASI</option>
                                <option value="PENGAWASAN">PENGAWASAN</option>
                                <option value="PEMERIKSAAN">PEMERIKSAAN</option>
                                <option value="SOSIALISASI">SOSIALISASI</option>
                                <option value="KONFIRMASI">KONFIRMASI</option>
                                <option value="KELUARGA">KELUARGA</option>
                                <option value="LAIN-LAIN">LAIN-LAIN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="alamat" class="form-label">ALAMAT / NAMA INSTITUSI</label><code> *</code>
                            <input type="text" id="alamat" class="form-control" placeholder="Alamat" name="alamat"
                                autocomplete="off" />
                        </div>

                        <div class="col mb-3">
                            <label for="pegawai" class="form-label">YANG INGIN DITEMUI</label><code> *</code>
                            <div id="pegawai_"></div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col mb-0">
                            <label for="job" class="form-label">PEKERJAAN</label><code> *</code>
                            <select id="job" name="job" class="form-select">
                                <option value="PNS" selected="selected">PNS</option>
                                <option value="TNI/POLRI">TNI/POLRI</option>
                                <option value="ADVOKAT">ADVOKAT</option>
                                <option value="WIRASWASTA">WIRASWASTA</option>
                                <option value="PEGAWAI SWASTA">PEGAWAI SWASTA</option>
                                <option value="PEGAWAI PEMERINTAHAN NON PNS">PEGAWAI PEMERINTAHAN NON PNS</option>
                                <option value="PETANI/NELAYAN">PETANI/NELAYAN</option>
                                <option value="PEDAGANG">PEDAGANG</option>
                                <option value="IBU RUMAH TANGGA">IBU RUMAH TANGGA</option>
                                <option value="MAHASISWA">MAHASISWA</option>
                                <option value="LAIN-LAIN">LAIN-LAIN</option>
                            </select>

                        </div>
                        <div class="col mb-0">
                            <label for="ket" class="form-label">KETERANGAN</label>
                            <input type="text" id="ket" class="form-control" name="ket" autocomplete="off"
                                placeholder="Keterangan" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <div class="form-group" style="display: grid; place-items: center;">
                                <span class="form-label">Foto</span>
                                <div>
                                    <div id="foto"></div>
                                    <input class="form-control" id="fotobase" name="foto" hidden></label>
                                </div>
                                <div class="form-group">
                                    <div class="btn btn-info" data-bs-toggle='modal' data-bs-target='#modal_kamera'
                                        onclick="aturIzin()">Ambil
                                        Foto</div>
                                    <input type="hidden" name="image" class="image-tag">
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="form-label"><code><i>* Wajib Diisi</i></code></span>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="simpanTamu" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============ MODAL KAMERA =============== -->
    <div class="modal fade" id="modal_kamera" tabindex="-1" role="dialog" aria-labelledby="largeModal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#tamuModal" aria-label="Close" onclick="offKamera()"></button>
                </div>

                <div class="modal-header">
                    <p class="text-center">
                    <h3 class="modal-title" id="myModalLabel">Silakan Foto Diri Anda</h3>
                    </p>
                </div>

                <div class="modal-body">
                    <div>
                        <center>
                            <video autoplay="false" id="video-webcam">
                                Browsermu tidak mendukung bro, upgrade donk!
                            </video>
                        </center>
                    </div>

                    <div id="my_camera"></div>
                    <br />
                    <p class="text-center">
                        <button class="btn btn-info" value="Take Snapshot" data-bs-toggle="modal"
                            data-bs-target="#tamuModal" onclick="takeSnapshot()">Ambil
                            Foto</button>
                        <input type="hidden" name="image" class="image-tag">
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--END MODAL KAMERA-->
    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

    <script src="<?= site_url('assets/js/menu.js') ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= site_url('assets/js/main.js') ?>"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        function BukaModal() {
            <?php $this->session->set_userdata('user', 'tamu'); ?>
            $.post('show_form', function (response) {
                var json = jQuery.parseJSON(response);
                if (json.st == 1) {
                    $("#pegawai_").html("");
                    $("#pegawai_").append(json.pegawai);

                } else if (json.st == 0) {
                    pesan('PERINGATAN', json.msg, '');
                    $('#table_pegawai').DataTable().ajax.reload();
                }
            });
        }
    </script>

    <script src="<?= site_url('assets/js/tamu.js') ?>"></script>
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