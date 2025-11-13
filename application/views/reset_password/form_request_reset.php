<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0" />

    <title>Reset Password - <?= $nama_app ?></title>

    <meta name="description" content="Halaman Reset Password SSO" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= site_url($logo_satker) ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
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
    <link rel="stylesheet" href="<?= site_url('assets/css/page-auth.css') ?>" />
    
    <!-- Helpers -->
    <script src="<?= site_url('assets/js/helpers.js') ?>"></script>
    <script src="<?= site_url('assets/js/config.js') ?>"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="row">
                    <div>
                        <div class="app-brand justify-content-center mb-4">
                            <img src="<?= site_url($logo_satker) ?>" alt="Logo" height="75" />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4>
                            <p class="text-center">Reset Password</p>
                        </h4>
                        <div class="divider divider-primary">
                            <div class="divider-text">
                                <div class="text-muted"><?= $title_app ?></div>
                            </div>
                        </div>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success text-center" role="alert">
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <p class="text-center text-muted mb-4">
                            Masukkan NIP Anda. Link reset password akan dikirim ke nomor WhatsApp yang terdaftar.
                        </p>

                        <form action="<?= site_url('reset_password/request_reset') ?>" id="resetForm" method="POST">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <code><?php echo form_error('nip'); ?></code>
                                <input type="text" class="form-control" id="nip" name="nip"
                                    placeholder="Masukkan NIP" autofocus autocomplete="off"
                                    value="<?= set_value('nip'); ?>" maxlength="18" pattern="[0-9]+" required />
                                <small class="text-muted">NIP hanya boleh berisi angka</small>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    <i class="bx bx-send me-2"></i>Kirim Link Reset Password
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="<?= site_url('login') ?>" class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-arrow-back me-2"></i>
                                    <span>Kembali ke Halaman Login</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-center">Copyright © 2024 All Right Reserved. Powered by Bagian
                        Teknologi Informasi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('assets/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= site_url('assets/js/menu.js') ?>"></script>
    <script src="<?= site_url('assets/js/main.js') ?>"></script>
    <script src="<?= site_url('assets/js/sso.js') ?>"></script>

    <script>
        // Validasi NIP hanya angka
        document.getElementById('nip').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // SweetAlert untuk feedback
        var error = "<?= $this->session->flashdata('error') ?? ''; ?>";
        var success = "<?= $this->session->flashdata('success') ?? ''; ?>";
        
        if (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                confirmButtonColor: '#696cff'
            });
        }
        
        if (success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: success,
                confirmButtonColor: '#696cff'
            });
        }
    </script>
</body>

</html>

