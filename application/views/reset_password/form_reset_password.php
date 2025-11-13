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

    <style>
        .password-requirement {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .password-requirement.valid {
            color: #28a745;
        }
        .password-requirement.invalid {
            color: #dc3545;
        }
        .password-strength {
            height: 4px;
            margin-top: 0.5rem;
            border-radius: 2px;
            background-color: #e9ecef;
        }
        .password-strength-bar {
            height: 100%;
            border-radius: 2px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
    </style>
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

                        <?php if (isset($validation_errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $validation_errors ?>
                            </div>
                        <?php endif; ?>

                        <p class="text-center text-muted mb-4">
                            Masukkan password baru Anda. Password harus memenuhi kriteria keamanan.
                        </p>

                        <form action="<?= site_url('reset_password/do_reset') ?>" id="resetPasswordForm" method="POST">
                            <input type="hidden" name="token" value="<?= $encrypted_token ?>">

                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="password">Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" autocomplete="new-password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                
                                <!-- Password Requirements -->
                                <div class="password-requirement mt-2">
                                    <div id="req-length" class="invalid">
                                        <i class="bx bx-x"></i> Minimal 8 karakter
                                    </div>
                                    <div id="req-uppercase" class="invalid">
                                        <i class="bx bx-x"></i> Minimal 1 huruf besar (A-Z)
                                    </div>
                                    <div id="req-lowercase" class="invalid">
                                        <i class="bx bx-x"></i> Minimal 1 huruf kecil (a-z)
                                    </div>
                                    <div id="req-number" class="invalid">
                                        <i class="bx bx-x"></i> Minimal 1 angka (0-9)
                                    </div>
                                    <div id="req-symbol" class="invalid">
                                        <i class="bx bx-x"></i> Minimal 1 simbol (!@#$%^&*)
                                    </div>
                                </div>

                                <!-- Password Strength Indicator -->
                                <div class="password-strength">
                                    <div id="strength-bar" class="password-strength-bar" style="width: 0%; background-color: #dc3545;"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="confirm_password" autocomplete="new-password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div id="confirm-match" class="password-requirement mt-2" style="display: none;">
                                    <span id="match-text"></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" id="submit-btn" disabled>
                                    <i class="bx bx-check me-2"></i>Reset Password
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
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submit-btn');
        const requirements = {
            length: document.getElementById('req-length'),
            uppercase: document.getElementById('req-uppercase'),
            lowercase: document.getElementById('req-lowercase'),
            number: document.getElementById('req-number'),
            symbol: document.getElementById('req-symbol')
        };
        const strengthBar = document.getElementById('strength-bar');
        const matchDiv = document.getElementById('confirm-match');
        const matchText = document.getElementById('match-text');

        function validatePassword(password) {
            const checks = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                symbol: /[^A-Za-z0-9]/.test(password)
            };

            // Update requirement indicators
            Object.keys(checks).forEach(key => {
                const req = requirements[key];
                if (checks[key]) {
                    req.classList.remove('invalid');
                    req.classList.add('valid');
                    req.querySelector('i').className = 'bx bx-check';
                } else {
                    req.classList.remove('valid');
                    req.classList.add('invalid');
                    req.querySelector('i').className = 'bx bx-x';
                }
            });

            // Calculate password strength
            const validCount = Object.values(checks).filter(v => v).length;
            const strength = (validCount / 5) * 100;
            
            strengthBar.style.width = strength + '%';
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545'; // Red
            } else if (strength < 80) {
                strengthBar.style.backgroundColor = '#ffc107'; // Yellow
            } else {
                strengthBar.style.backgroundColor = '#28a745'; // Green
            }

            return Object.values(checks).every(v => v);
        }

        function validateConfirmPassword() {
            const password = passwordInput.value;
            const confirm = confirmPasswordInput.value;

            if (confirm.length === 0) {
                matchDiv.style.display = 'none';
                return false;
            }

            matchDiv.style.display = 'block';
            if (password === confirm) {
                matchText.innerHTML = '<i class="bx bx-check text-success"></i> Password cocok';
                matchText.className = 'text-success';
                return true;
            } else {
                matchText.innerHTML = '<i class="bx bx-x text-danger"></i> Password tidak cocok';
                matchText.className = 'text-danger';
                return false;
            }
        }

        function checkFormValidity() {
            const passwordValid = validatePassword(passwordInput.value);
            const confirmValid = validateConfirmPassword();
            submitBtn.disabled = !(passwordValid && confirmValid);
        }

        passwordInput.addEventListener('input', function() {
            validatePassword(this.value);
            if (confirmPasswordInput.value.length > 0) {
                validateConfirmPassword();
            }
            checkFormValidity();
        });

        confirmPasswordInput.addEventListener('input', function() {
            validateConfirmPassword();
            checkFormValidity();
        });

        // Toggle password visibility
        document.querySelectorAll('.form-password-toggle .input-group-text').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bx bx-show';
                } else {
                    input.type = 'password';
                    icon.className = 'bx bx-hide';
                }
            });
        });

        // Initial check
        checkFormValidity();
    </script>
</body>

</html>

