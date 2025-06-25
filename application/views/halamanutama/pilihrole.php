<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0" />

    <title>SSO | Single Sign On MS Banda Aceh</title>

    <meta name="description" content="Halaman Pilih Role oleh Plh/Plt" />

    <link rel="icon" href="<?= $this->session->userdata('logo_satker') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= site_url('assets/fonts/boxicons.css') ?>" />
    <link rel="stylesheet" href="<?= site_url('assets/libs/sweetalert2/css/sweetalert2.min.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= site_url('assets/css/core.css') ?>" class="template-customizer-core-css" />

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= site_url('assets/js/helpers.js') ?>"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Nama Pengguna -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                Dashboard SSO (Single Sign On)
                            </div>
                        </div>
                        <!-- Nama Pengguna -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('keluar'); ?>">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Keluar</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row mt-sm-4 mt-3">
                            <div class="col-12">
                                <div class="card bg-primary text-center text-white mb-3">
                                    <div class="card-body">
                                        <h4 class="card-title text-white">Assalamu'alaikum, Saleum Teuka</h4>
                                        <h4 class="card-title text-white">
                                            Anda Telah Ditunjuk Menjadi Plh/Plt <?= $jabatan ?>
                                        </h4>
                                        <h4 class="card-title text-white">
                                            Silakan Pilih Role
                                        </h4>
                                        <div class="row mt-sm-4 mt-3">
                                            <div class="col-12">
                                                <form method="POST" action="<?= site_url('role_plh') ?>"
                                                    onsubmit="return showLoaderSweetalert2(this)">
                                                    <input type="hidden" name="userid"
                                                        value="<?= base64_encode($this->encryption->encrypt($this->session->userdata('id_plh'))) ?>">
                                                    <button class="btn btn-warning d-grid w-100" type="submit">Masuk
                                                        sebagai Plh/Plt <?= $jabatan ?></button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row mt-sm-4 mt-3">
                                            <div class="col-12">
                                                <form method="POST" action="<?= site_url('role_user') ?>"
                                                    onsubmit="return showLoaderSweetalert2(this)">
                                                    <input type="hidden" name="userid"
                                                        value="<?= base64_encode($this->encryption->encrypt($this->session->userdata('userid'))) ?>">
                                                    <button class="btn btn-warning d-grid w-100" type="submit">Masuk
                                                        sebagai <?= $fullname ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Content wrapper -->
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

    <script src="<?= site_url('assets/js/menu.js'); ?>"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="<?= site_url('assets/js/main.js') ?>"></script>
    <!-- Page JS -->

    <script src="<?= site_url('assets/libs/sweetalert2/js/sweetalert2.min.js') ?>"></script>
    <script src="<?= site_url('assets/js/sso.js') ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>