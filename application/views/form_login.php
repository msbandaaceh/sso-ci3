<!DOCTYPE html>
<html lang="id" class="light-style">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="theme-color" content="#e0e5ec" />
    <meta name="description" content="Halaman Login SSO MS Banda Aceh" />

    <title>Login SSO <?= $nama_satker ?></title>
    <link rel="icon" type="image/x-icon" href="<?= site_url($logo_satker) ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --neu-bg:        #e0e5ec;
            --neu-bg-alt:    #e6ebf1;
            --neu-text:      #2c3e50;
            --neu-text-dim:  #6b7f94;
            --neu-text-muted:#9ba7b5;
            --neu-accent:    #3b82f6;
            --neu-accent-2:  #8b5cf6;
            --neu-success:   #10b981;
            --neu-warning:   #f59e0b;
            --neu-danger:    #ef4444;
            --neu-radius:    20px;
            --neu-radius-sm: 14px;
            --neu-radius-full:999px;
            --neu-shadow-raised:
                8px 8px 16px rgba(163,177,198,0.6),
               -8px -8px 16px rgba(255,255,255,0.7);
            --neu-shadow-raised-lg:
                12px 12px 24px rgba(163,177,198,0.6),
               -12px -12px 24px rgba(255,255,255,0.7);
            --neu-shadow-inset:
                inset 6px 6px 12px rgba(163,177,198,0.5),
                inset -6px -6px 12px rgba(255,255,255,0.7);
            --neu-shadow-inset-sm:
                inset 3px 3px 6px rgba(163,177,198,0.4),
                inset -3px -3px 6px rgba(255,255,255,0.6);
            --neu-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--neu-text);
            line-height: 1.6;
            min-height: 100vh;
            background: var(--neu-bg);
            background-image:
                radial-gradient(ellipse at 20% 20%, rgba(139,92,246,0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(59,130,246,0.05) 0%, transparent 50%);
            overflow-x: hidden;
            position: relative;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: var(--neu-text);
        }

        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* Animated background shapes */
        .neu-bg-shapes {
            position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
        }
        .neu-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
        }
        .neu-shape-1 {
            width: 400px; height: 400px;
            background: var(--neu-accent);
            top: -100px; left: -80px;
            animation: neu-drift 22s ease-in-out infinite;
        }
        .neu-shape-2 {
            width: 300px; height: 300px;
            background: var(--neu-accent-2);
            top: 50%; right: -60px;
            animation: neu-drift 18s ease-in-out infinite reverse;
        }
        .neu-shape-3 {
            width: 220px; height: 220px;
            background: var(--neu-success);
            bottom: -60px; left: 25%;
            animation: neu-drift 25s ease-in-out infinite;
            animation-delay: -8s;
        }
        @keyframes neu-drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%      { transform: translate(40px, -30px) scale(1.05); }
            66%      { transform: translate(-20px, 50px) scale(0.95); }
        }

        /* Alert styles */
        .neu-alert {
            padding: 14px 20px;
            border-radius: var(--neu-radius-sm);
            font-size: 0.88rem;
            margin-bottom: 20px;
            box-shadow: var(--neu-shadow-inset-sm);
        }
        .neu-alert-danger {
            background: var(--neu-bg);
            color: var(--neu-danger);
            border-left: 4px solid var(--neu-danger);
        }
        .neu-alert-success {
            background: var(--neu-bg);
            color: var(--neu-success);
            border-left: 4px solid var(--neu-success);
        }

        /* Login card */
        .neu-login-wrap {
            position: relative; z-index: 1;
            width: 100%; max-width: 440px;
        }

        .neu-login-card {
            background: var(--neu-bg);
            border-radius: var(--neu-radius);
            box-shadow: var(--neu-shadow-raised-lg);
            padding: 40px 32px;
            transition: var(--neu-transition);
        }

        /* Logo */
        .neu-login-logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .neu-login-logo img {
            width: 80px; height: 80px; margin: 0 auto 16px;
            border-radius: 22px;
            object-fit: contain;
            background: var(--neu-bg);
            padding: 12px;
            box-shadow: var(--neu-shadow-raised);
            animation: neu-float 5s ease-in-out infinite;
        }
        @keyframes neu-float {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }
        .neu-login-app-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.3rem; font-weight: 800;
            text-align: center; margin-bottom: 6px;
        }
        .neu-login-app-title {
            font-size: 0.82rem; color: var(--neu-text-muted);
            text-align: center; text-transform: uppercase;
            letter-spacing: 0.1em; font-weight: 600;
        }

        /* Divider */
        .neu-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0;
            color: var(--neu-text-muted);
            font-size: 0.78rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.1em;
        }
        .neu-divider::before, .neu-divider::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(163,177,198,0.5), transparent);
        }

        /* Form inputs */
        .neu-field { margin-bottom: 20px; }
        .neu-label {
            display: block; font-size: 0.78rem; font-weight: 600;
            color: var(--neu-text-dim); margin-bottom: 6px;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        .neu-input {
            width: 100%; padding: 13px 18px;
            background: var(--neu-bg);
            border: none;
            border-radius: var(--neu-radius-sm);
            box-shadow: var(--neu-shadow-inset-sm);
            color: var(--neu-text);
            font-size: 0.92rem;
            font-family: inherit;
            transition: var(--neu-transition);
            outline: none;
        }
        .neu-input:focus {
            box-shadow:
                inset 4px 4px 8px rgba(163,177,198,0.45),
                inset -4px -4px 8px rgba(255,255,255,0.65),
                0 0 0 3px rgba(59,130,246,0.15);
        }
        .neu-input::placeholder { color: var(--neu-text-muted); }
        .neu-error {
            font-size: 0.78rem; color: var(--neu-danger);
            margin-top: 4px; min-height: 18px;
        }

        /* Password toggle */
        .neu-pw-group {
            position: relative;
        }
        .neu-pw-group .neu-input { padding-right: 50px; }
        .neu-pw-toggle {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--neu-text-muted); font-size: 1.3rem;
            padding: 4px; transition: var(--neu-transition);
        }
        .neu-pw-toggle:hover { color: var(--neu-accent); }

        /* Button */
        .neu-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px 26px;
            border-radius: var(--neu-radius-full);
            font-weight: 600; font-size: 0.92rem;
            border: none; cursor: pointer;
            transition: var(--neu-transition);
            font-family: inherit; white-space: nowrap;
        }
        .neu-btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--neu-accent), var(--neu-accent-2));
            color: white;
            box-shadow:
                6px 6px 12px rgba(163,177,198,0.5),
               -4px -4px 10px rgba(255,255,255,0.6),
                inset 0 0 0 1px rgba(255,255,255,0.2);
        }
        .neu-btn-primary:hover {
            box-shadow:
                8px 8px 20px rgba(163,177,198,0.6),
               -6px -6px 16px rgba(255,255,255,0.7),
                inset 0 0 0 1px rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }
        .neu-btn-primary:active {
            box-shadow: var(--neu-shadow-inset-sm);
            transform: translateY(0);
        }

        /* Forgot password link */
        .neu-forgot {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            font-size: 0.88rem; color: var(--neu-text-dim);
            margin-top: 20px; transition: var(--neu-transition);
        }
        .neu-forgot:hover { color: var(--neu-accent); }

        /* CAPTCHA section */
        .neu-captcha-area {
            display: flex; justify-content: center;
            margin: 8px 0 20px;
        }

        /* Footer */
        .neu-login-footer {
            text-align: center; margin-top: 24px;
            font-size: 0.82rem; color: var(--neu-text-muted);
        }

        /* Reveal animation */
        .neu-reveal {
            opacity: 0; transform: translateY(24px);
            transition: opacity 0.7s ease-out, transform 0.7s ease-out;
        }
        .neu-reveal.visible { opacity: 1; transform: translateY(0); }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
            .neu-shape { animation: none; }
        }
    </style>
</head>

<body>
    <!-- Animated background shapes -->
    <div class="neu-bg-shapes" aria-hidden="true">
        <div class="neu-shape neu-shape-1"></div>
        <div class="neu-shape neu-shape-2"></div>
        <div class="neu-shape neu-shape-3"></div>
    </div>

    <div class="neu-login-wrap">
        <div class="neu-login-card neu-reveal">
            <!-- Logo -->
            <div class="neu-login-logo">
                <img src="<?= site_url($logo_satker) ?>" alt="Logo" />
                <div class="neu-login-app-name"><?= $nama_app ?></div>
                <div class="neu-login-app-title"><?= $title_app ?></div>
            </div>

            <div class="neu-divider">Masuk ke akun</div>

            <!-- Alerts -->
            <?php if ($this->session->userdata('login_error')) { ?>
                <div class="neu-alert neu-alert-danger" role="alert">
                    <?= $this->session->userdata('login_error') ?>
                </div>
            <?php } ?>
            <?php if ($this->session->userdata('validation')) { ?>
                <div class="neu-alert neu-alert-danger" role="alert">
                    <?= $this->session->userdata('validation') ?>
                </div>
            <?php } ?>

            <!-- Form -->
            <form action="validasi" id="loginForm" method="POST"
                onsubmit="return showLoaderSweetalert2(this)">

                <div class="neu-field">
                    <label class="neu-label" for="username">Username</label>
                    <input type="text" class="neu-input" id="username" name="username"
                        placeholder="Masukkan Username" autofocus autocomplete="off"
                        value="<?= set_value('username'); ?>" />
                    <div class="neu-error"><?= $validation_errors ?? ''; ?></div>
                </div>

                <div class="neu-field">
                    <label class="neu-label" for="password">Password</label>
                    <div class="neu-pw-group">
                        <input type="password" id="password" class="neu-input" name="password"
                            placeholder="Masukkan Password"
                            autocomplete="off" />
                        <button type="button" class="neu-pw-toggle" onclick="togglePassword()" aria-label="Tampilkan password">
                            <i class="bx bx-hide" id="pwIcon"></i>
                        </button>
                    </div>
                </div>

                <?php if ($this->session->userdata('login_attempts') >= 3): ?>
                    <div class="neu-divider">Keamanan</div>
                    <div class="neu-field">
                        <label class="neu-label">Verifikasi</label>
                        <div class="neu-captcha-area">
                            <div class="g-recaptcha"
                                data-sitekey="6LfWeOMpAAAAADEva2cBc61p8-sIgPbo34R_76wY"></div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="neu-field">
                    <button class="neu-btn neu-btn-primary" type="submit">
                        <i class="bx bx-log-in"></i> Masuk
                    </button>
                </div>
            </form>

            <a href="<?= site_url('reset_password') ?>" class="neu-forgot">
                <i class="bx bx-lock-open-alt"></i>
                <span>Lupa Password?</span>
            </a>
        </div>

        <div class="neu-login-footer">
            Copyright &copy; 2024 All Right Reserved. Powered by Bagian Teknologi Informasi
        </div>
    </div>

    <!-- Core JS -->
    <script src="<?= site_url('assets/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('assets/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('assets/js/bootstrap.js') ?>"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="<?= site_url('assets/js/main.js') ?>"></script>
    <script src="<?= site_url('assets/js/sso.js') ?>"></script>

    <script>
        // Toggle password visibility
        function togglePassword() {
            var pw = document.getElementById('password');
            var icon = document.getElementById('pwIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                pw.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        }

        // Reveal on scroll/load
        (function () {
            var items = document.querySelectorAll('.neu-reveal');
            if (!('IntersectionObserver' in window)) {
                items.forEach(function (el) { el.classList.add('visible'); });
                return;
            }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            items.forEach(function (el) { io.observe(el); });
        })();

        // Flash messages
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