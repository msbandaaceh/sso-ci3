<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0" />

    <title><?= $nama_app ?></title>

    <meta name="description" content="SSO MS BANDA ACEH" />

    <link rel="icon" href="<?= $logo_satker ?>">

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

    <!-- Helpers -->
    <script src="<?= site_url('assets/js/helpers.js') ?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= site_url('assets/js/config.js') ?>"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav flex-row align-items-center ms-auto">
                            <a class="btn btn-danger" href="login">
                                Login
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="row mt-sm-4 mt-3">
                            <div class="col-12">
                                <div class="card bg-warning text-center text-white mb-3">
                                    <div class="card-header">
                                        <div class="card-image mb-3">
                                            <img src="<?= $logo_satker ?>"
                                                class="w-px-90 h-px-150" />
                                        </div>
                                        <h2 class="card-title text-white">SELAMAT DATANG DI LITERASI</h2>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title text-white">APLIKASI INTERNAL TERINTEGRASI</h4>
                                        <h3 class="card-title text-white">MAHKAMAH SYAR'IYAH BANDA ACEH
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                                <div class="card h-100">
                                    <a href="http://hadir-in.ms-bandaaceh.local"><img class="card-img-top"
                                            src="<?= site_url('assets/img/hadir-in.webp') ?>" alt="Card image cap"></a>
                                    <div class="card-body text-center">
                                        <div class="btn btn-primary">
                                            <p class="card-text"><?= $hasil[0] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                                <div class="card h-100">
                                    <a href="http://paylink.ms-bandaaceh.local"><img class="card-img-top"
                                            src="<?= site_url('assets/img/paylink.webp') ?>" alt="Card image cap"></a>
                                    <div class="card-body text-center">
                                        <div class="btn btn-primary">
                                            <p class="card-text"><?= $hasil[1] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                                <div class="card h-100">
                                    <a href="http://sias.ms-bandaaceh.local"><img class="card-img-top"
                                            src="<?= site_url('assets/img/sias.webp') ?>" alt="Card image cap"></a>
                                    <div class="card-body text-center">
                                        <div class="btn btn-primary">
                                            <p class="card-text"><?= $hasil[2] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                                <div class="card h-100">
                                    <a href="http://seudati.ms-bandaaceh.local"><img class="card-img-top"
                                            src="<?= site_url('assets/img/seudati.webp') ?>" alt="Card image cap"></a>
                                    <div class="card-body text-center">
                                        <div class="btn btn-primary">
                                            <p class="card-text"><?= $hasil[3] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                                <div class="card h-100">
                                    <a href="http://agam.ms-bandaaceh.local"><img class="card-img-top"
                                            src="<?= site_url('assets/img/agam.webp') ?>" alt="Card image cap"></a>
                                    <div class="card-body text-center">
                                        <div class="btn btn-primary">
                                            <p class="card-text"><?= $hasil[4] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mb-3">
                                <div class="card h-100">
                                    <a href="http://e-guest.ms-bandaaceh.local"><img class="card-img-top"
                                            src="<?= site_url('assets/img/e-guest.webp') ?>" alt="Card image cap"></a>
                                    <div class="card-body text-center">
                                        <div class="btn btn-primary">
                                            <p class="card-text"><?= $hasil[5] ?></p>
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
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

    <script src="<?= site_url('assets/js/menu.js'); ?>"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="<?= site_url('assets/js/main.js') ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>