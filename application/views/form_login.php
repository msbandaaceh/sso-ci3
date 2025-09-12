<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0" />

    <title>Login SSO <?= $nama_satker ?></title>

    <meta name="description" content="Halaman Login SSO MS Banda Aceh" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= site_url($logo_satker) ?>" />

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
                            <img src="<?= site_url($logo_satker) ?>" alt="Card image"
                                height="75" />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <h4>
                            <p class="text-center"><?= $nama_app ?></p>
                        </h4>
                        <div class="divider divider-primary">
                            <div class="divider-text">
                                <div class="text-muted"><?= $title_app ?>
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
                        </form>
                    </div>
                </div>
                <!-- /Register -->
                <div class="mt-3">
                    <div class="text-center">Copyright © 2024 All Right Reserved. Powered by Bagian
                        Teknologi Informasi</div>
                </div>
            </div>
        </div>
    </div>
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