<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $this->session->userdata('title') ?></title>

    <meta name="description" content="DAFTAR JABATAN MS BANDA ACEH" />

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

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= site_url('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet"
        href="<?= site_url('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= site_url('assets/libs/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">

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
                                Halo, <?= $this->session->userdata('fullname') ?>
                            </div>
                        </div>
                        <!-- Nama Pengguna -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?= $this->session->userdata('foto'); ?>" alt
                                            class="w-px-40 h-px-40 rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="<?= $this->session->userdata('foto'); ?>" alt
                                                            class="w-px-40 h-px-40 rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1" style="display: grid; place-items: center;">
                                                    <span class="fw-semibold d-block">
                                                        <?= $this->session->userdata('fullname') ?>
                                                    </span>
                                                    <!--<small class="text-muted">Admin</small>-->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url() ?>">
                                            <i class="bx bx-home me-2"></i>
                                            <span class="align-middle">Dashboard</span>
                                        </a>
                                    </li>
                                    <?php
                                    if ($this->session->userdata('level') == "admin") {
                                        ?>
                                        <li>
                                            <a class="dropdown-item" href="<?= site_url('daftar_pegawai'); ?>">
                                                <i class="bx bx-list-ul me-2"></i>
                                                <span class="align-middle">Manajemen Pengguna</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($this->session->userdata('fullname') == "Super Administrator") {
                                        echo
                                            '<li>
                                        <a class="dropdown-item" href="' . site_url('user') . '">
                                        <i class="bx bx-wrench me-2"></i>
                                        <span class="align-middle">Pengaturan</span>
                                        </a>
                                        </li>';
                                    } else {
                                        echo
                                            '<li>
                                        <a class="dropdown-item" href="' . site_url('profil') . '">
                                        <i class="bx bx-wrench me-2"></i>
                                        <span class="align-middle">Pengaturan</span>
                                        </a>
                                        </li>';
                                    }
                                    ?>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
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