<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="theme-color" content="#e0e5ec" />
    <meta name="description"
        content="SSO Mahkamah Syar'iyah Banda Aceh — Sistem Single Sign-On terintegrasi untuk aplikasi internal." />

    <title><?= htmlspecialchars($nama_app ?? 'SSO MS Banda Aceh', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" href="<?= site_url('assets/img/ms-bna.png') ?>" />

    <!-- Fonts: Plus Jakarta Sans (headings) + Inter (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
            rel="stylesheet">
    </noscript>
    <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet" />

    <style>
        /* ============================================================
           NEUMORPHISM THEME — SSO MS Banda Aceh
           Light background (#e0e5ec) with soft dual-shadow cards
           ============================================================ */

        :root {
            --neu-bg: #e0e5ec;
            --neu-bg-alt: #e6ebf1;
            --neu-text: #1e2f41;
            --neu-text-dim: #4a5e73;
            --neu-text-muted: #5e7388;
            --neu-accent: #1d4ed8;
            --neu-accent-2: #6d28d9;
            --neu-accent-soft: rgba(29, 78, 216, 0.12);
            --neu-success: #047857;
            --neu-warning: #92400e;
            --neu-danger: #b91c1c;
            --neu-radius: 20px;
            --neu-radius-sm: 14px;
            --neu-radius-full: 999px;
            --neu-shadow-raised:
                8px 8px 16px rgba(163, 177, 198, 0.6),
                -8px -8px 16px rgba(255, 255, 255, 0.7);
            --neu-shadow-raised-lg:
                12px 12px 24px rgba(163, 177, 198, 0.6),
                -12px -12px 24px rgba(255, 255, 255, 0.7);
            --neu-shadow-inset:
                inset 6px 6px 12px rgba(163, 177, 198, 0.5),
                inset -6px -6px 12px rgba(255, 255, 255, 0.7);
            --neu-shadow-inset-sm:
                inset 3px 3px 6px rgba(163, 177, 198, 0.4),
                inset -3px -3px 6px rgba(255, 255, 255, 0.6);
            --neu-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--neu-text);
            line-height: 1.6;
            min-height: 100vh;
            background: var(--neu-bg);
            background-image:
                radial-gradient(ellipse at 20% 20%, rgba(139, 92, 246, 0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
            overflow-x: hidden;
            position: relative;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: var(--neu-text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* ============================================================
           ANIMATED BACKGROUND SHAPES
           ============================================================ */
        .neu-bg-shapes {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .neu-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
        }

        .neu-shape-1 {
            width: 400px;
            height: 400px;
            background: var(--neu-accent);
            top: -100px;
            left: -80px;
            animation: neu-drift 22s ease-in-out infinite;
        }

        .neu-shape-2 {
            width: 300px;
            height: 300px;
            background: var(--neu-accent-2);
            top: 50%;
            right: -60px;
            animation: neu-drift 18s ease-in-out infinite reverse;
        }

        .neu-shape-3 {
            width: 220px;
            height: 220px;
            background: var(--neu-success);
            bottom: -60px;
            left: 25%;
            animation: neu-drift 25s ease-in-out infinite;
            animation-delay: -8s;
        }

        .neu-shape-4 {
            width: 180px;
            height: 180px;
            background: var(--neu-warning);
            top: 30%;
            left: 15%;
            animation: neu-drift 20s ease-in-out infinite;
            animation-delay: -4s;
        }

        @keyframes neu-drift {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(40px, -30px) scale(1.05);
            }

            66% {
                transform: translate(-20px, 50px) scale(0.95);
            }
        }

        /* ============================================================
           LAYOUT
           ============================================================ */
        .neu-wrap {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ============================================================
           NEUMORPHIC COMPONENTS
           ============================================================ */

        /* — Buttons — */
        .neu-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: var(--neu-radius-full);
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: var(--neu-transition);
            font-family: inherit;
            white-space: nowrap;
            background: var(--neu-bg);
            color: var(--neu-text);
            box-shadow: var(--neu-shadow-raised);
        }

        .neu-btn:hover {
            box-shadow:
                10px 10px 20px rgba(163, 177, 198, 0.65),
                -10px -10px 20px rgba(255, 255, 255, 0.75);
            transform: translateY(-2px);
        }

        .neu-btn:active {
            box-shadow: var(--neu-shadow-inset-sm);
            transform: translateY(0);
        }

        .neu-btn-primary {
            background: linear-gradient(135deg, var(--neu-accent), var(--neu-accent-2));
            color: white;
            box-shadow:
                6px 6px 12px rgba(163, 177, 198, 0.5),
                -4px -4px 10px rgba(255, 255, 255, 0.6),
                inset 0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .neu-btn-primary:hover {
            box-shadow:
                8px 8px 20px rgba(163, 177, 198, 0.6),
                -6px -6px 16px rgba(255, 255, 255, 0.7),
                inset 0 0 0 1px rgba(255, 255, 255, 0.25);
        }

        /* — Cards — */
        .neu-card {
            background: var(--neu-bg);
            border-radius: var(--neu-radius);
            box-shadow: var(--neu-shadow-raised);
            padding: 28px;
            transition: var(--neu-transition);
            border: none;
        }

        .neu-card:hover {
            box-shadow: var(--neu-shadow-raised-lg);
            transform: translateY(-4px);
        }

        /* — Inset cards (for input areas, stat panels) — */
        .neu-card-inset {
            background: var(--neu-bg);
            border-radius: var(--neu-radius);
            box-shadow: var(--neu-shadow-inset);
            padding: 24px;
            transition: var(--neu-transition);
        }

        /* — Input fields — */
        .neu-input,
        .neu-select {
            width: 100%;
            padding: 12px 18px;
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

        .neu-input:focus,
        .neu-select:focus {
            box-shadow:
                inset 4px 4px 8px rgba(163, 177, 198, 0.45),
                inset -4px -4px 8px rgba(255, 255, 255, 0.65),
                0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .neu-input::placeholder {
            color: var(--neu-text-muted);
        }

        .neu-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--neu-text-dim);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* — Badge / tag — */
        .neu-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: var(--neu-radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--neu-bg);
            box-shadow: var(--neu-shadow-inset-sm);
            color: var(--neu-text-dim);
        }

        .neu-badge-accent {
            box-shadow: var(--neu-shadow-inset-sm);
            color: var(--neu-accent);
        }

        /* — Stat number — */
        .neu-stat-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--neu-accent), var(--neu-accent-2));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .neu-stat-label {
            font-size: 0.75rem;
            color: var(--neu-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 4px;
            font-weight: 600;
        }

        /* ============================================================
           NAVBAR
           ============================================================ */
        .neu-navbar {
            position: sticky;
            top: 16px;
            z-index: 50;
            margin: 16px auto 0;
            max-width: 1160px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: var(--neu-bg);
            border-radius: var(--neu-radius);
            box-shadow: var(--neu-shadow-raised);
        }

        .neu-mobile-menu {
            display: none;
            position: fixed;
            top: 60px;
            left: 16px;
            right: 16px;
            background: var(--neu-bg);
            border-radius: var(--neu-radius);
            box-shadow: var(--neu-shadow-raised-lg);
            padding: 16px;
            flex-direction: column;
            gap: 8px;
            z-index: 49;
        }

        .neu-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--neu-text);
        }

        .neu-brand img {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            object-fit: contain;
            background: var(--neu-bg);
            padding: 6px;
            box-shadow: var(--neu-shadow-inset-sm);
        }

        .neu-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .neu-brand-title {
            font-size: 0.95rem;
            font-weight: 700;
        }

        .neu-brand-sub {
            font-size: 0.68rem;
            color: var(--neu-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .neu-nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .neu-nav-link {
            padding: 9px 18px;
            border-radius: var(--neu-radius-full);
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--neu-text-dim);
            transition: var(--neu-transition);
            background: var(--neu-bg);
            box-shadow: 4px 4px 8px rgba(163, 177, 198, 0.4),
                -4px -4px 8px rgba(255, 255, 255, 0.6);
        }

        .neu-nav-link:hover {
            color: var(--neu-accent);
            box-shadow: var(--neu-shadow-inset-sm);
        }

        .neu-nav-link.active {
            color: var(--neu-accent);
            box-shadow: var(--neu-shadow-inset-sm);
            font-weight: 600;
        }

        .neu-menu-btn {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: var(--neu-radius-sm);
            background: var(--neu-bg);
            box-shadow: var(--neu-shadow-raised);
            border: none;
            cursor: pointer;
            color: var(--neu-text);
            font-size: 1.4rem;
            align-items: center;
            justify-content: center;
            padding: 0;
            flex-shrink: 0;
        }

        .neu-menu-btn>i.bx {
            font-size: 1.6rem;
            line-height: 1;
            display: inline-block;
            color: inherit;
        }

        .neu-mobile-menu.open {
            display: flex;
        }

        .neu-mobile-menu a {
            padding: 12px 16px;
            border-radius: var(--neu-radius-sm);
            color: var(--neu-text-dim);
            font-weight: 500;
            background: var(--neu-bg);
            box-shadow: 3px 3px 6px rgba(163, 177, 198, 0.35),
                -3px -3px 6px rgba(255, 255, 255, 0.5);
            transition: var(--neu-transition);
        }

        .neu-mobile-menu a:hover {
            box-shadow: var(--neu-shadow-inset-sm);
            color: var(--neu-accent);
        }

        /* ============================================================
           HERO
           ============================================================ */
        .neu-hero {
            padding: 80px 0 60px;
            text-align: center;
        }

        .neu-hero-logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 32px;
            background: var(--neu-bg);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            box-shadow: var(--neu-shadow-raised-lg);
            animation: neu-float 5s ease-in-out infinite;
        }

        .neu-hero-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 16px;
        }

        @keyframes neu-float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .neu-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: var(--neu-radius-full);
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--neu-accent);
            background: var(--neu-bg);
            box-shadow: var(--neu-shadow-inset-sm);
            margin-bottom: 24px;
        }

        .neu-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--neu-accent);
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.6);
            animation: neu-pulse-anim 2s ease-out infinite;
        }

        @keyframes neu-pulse-anim {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.6);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .neu-hero-title {
            font-size: clamp(1.8rem, 4.5vw, 3rem);
            font-weight: 800;
            margin-bottom: 18px;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--neu-text) 0%, #4a6274 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .neu-hero-sub {
            font-size: clamp(0.95rem, 1.5vw, 1.1rem);
            color: var(--neu-text-dim);
            max-width: 600px;
            margin: 0 auto 36px;
            line-height: 1.7;
        }

        .neu-hero-cta {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ============================================================
           STATS
           ============================================================ */
        .neu-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin: 48px auto;
            max-width: 760px;
        }

        .neu-stat-card {
            text-align: center;
            background: var(--neu-bg);
            border-radius: var(--neu-radius);
            box-shadow: var(--neu-shadow-raised);
            padding: 24px 16px;
            transition: var(--neu-transition);
        }

        .neu-stat-card:hover {
            box-shadow: var(--neu-shadow-raised-lg);
            transform: translateY(-3px);
        }

        /* ============================================================
           SECTION
           ============================================================ */
        .neu-section {
            padding: 64px 0;
        }

        .neu-section-head {
            text-align: center;
            margin-bottom: 48px;
        }

        .neu-section-eyebrow {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--neu-accent);
            text-transform: uppercase;
            letter-spacing: 0.14em;
            margin-bottom: 10px;
        }

        .neu-section-title {
            font-size: clamp(1.4rem, 3vw, 2.2rem);
            font-weight: 800;
            margin-bottom: 12px;
        }

        .neu-section-sub {
            color: var(--neu-text-dim);
            max-width: 520px;
            margin: 0 auto;
        }

        /* ============================================================
           APP CARDS
           ============================================================ */
        .neu-apps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
        }

        .neu-app-card {
            position: relative;
            padding: 32px 24px 28px;
            border-radius: var(--neu-radius);
            background: var(--neu-bg);
            box-shadow: var(--neu-shadow-raised);
            cursor: pointer;
            transition: var(--neu-transition);
            text-align: center;
        }

        .neu-app-card:hover {
            box-shadow: var(--neu-shadow-raised-lg);
            transform: translateY(-6px);
        }

        .neu-app-card:active {
            box-shadow: var(--neu-shadow-inset);
            transform: translateY(0);
        }

        .neu-app-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--neu-bg);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            box-shadow:
                var(--neu-shadow-inset-sm);
            transition: var(--neu-transition);
        }

        .neu-app-card:hover .neu-app-icon {
            box-shadow:
                6px 6px 12px rgba(163, 177, 198, 0.5),
                -6px -6px 12px rgba(255, 255, 255, 0.65);
            transform: scale(1.06) rotate(-3deg);
        }

        .neu-app-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        .neu-app-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.02rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--neu-text);
        }

        .neu-app-domain {
            font-size: 0.75rem;
            color: var(--neu-text-muted);
            margin-bottom: 18px;
            word-break: break-all;
            font-family: 'SF Mono', Menlo, monospace;
        }

        .neu-app-cta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--neu-accent);
            padding: 8px 18px;
            border-radius: var(--neu-radius-full);
            background: var(--neu-bg);
            box-shadow: var(--neu-shadow-inset-sm);
            transition: var(--neu-transition);
        }

        .neu-app-card:hover .neu-app-cta {
            box-shadow: var(--neu-shadow-raised-sm);
            gap: 10px;
        }

        /* ============================================================
           FEATURES
           ============================================================ */
        .neu-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }

        .neu-feature {
            padding: 28px 24px;
            border-radius: var(--neu-radius);
            background: var(--neu-bg);
            box-shadow: var(--neu-shadow-raised);
            transition: var(--neu-transition);
        }

        .neu-feature:hover {
            box-shadow: var(--neu-shadow-raised-lg);
            transform: translateY(-3px);
        }

        .neu-feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 18px;
            background: var(--neu-bg);
            box-shadow:
                var(--neu-shadow-inset-sm);
            color: var(--neu-accent);
        }

        .neu-feature-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.02rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .neu-feature-desc {
            font-size: 0.88rem;
            color: var(--neu-text-dim);
            line-height: 1.6;
        }

        /* ============================================================
           FOOTER
           ============================================================ */
        .neu-footer {
            margin-top: 60px;
            padding: 32px 24px;
            text-align: center;
            border-top: 1px solid rgba(163, 177, 198, 0.3);
        }

        .neu-footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .neu-footer p {
            font-size: 0.85rem;
            color: var(--neu-text-muted);
        }

        .neu-footer-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--neu-text);
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 768px) {
            .neu-nav-links {
                display: none;
            }

            .neu-menu-btn {
                display: flex;
            }

            .neu-navbar {
                margin-top: 12px;
                padding: 12px 16px;
            }

            .neu-hero {
                padding: 50px 0 30px;
            }

            .neu-hero-logo {
                width: 90px;
                height: 90px;
                border-radius: 22px;
            }

            .neu-section {
                padding: 40px 0;
            }

            .neu-section-title {
                font-size: 1.4rem;
            }

            .neu-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .neu-footer-content {
                flex-direction: column;
                text-align: center;
            }

            .neu-apps-grid {
                grid-template-columns: 1fr;
            }

            .neu-mobile-menu {
                top: 76px;
                left: 12px;
                right: 12px;
            }
        }

        @media (max-width: 420px) {
            .neu-hero-cta {
                flex-direction: column;
                width: 100%;
            }

            .neu-hero-cta .neu-btn {
                width: 100%;
            }

            .neu-stats {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }

            .neu-shape {
                animation: none;
            }

            .neu-hero-logo {
                animation: none;
            }
        }

        /* Reveal on scroll */
        .neu-reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease-out, transform 0.7s ease-out;
        }

        .neu-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .neu-brand-sub {
            color: var(--neu-text-dim) !important;
            font-weight: 700 !important;
        }

        .neu-hero-badge {
            color: var(--neu-accent) !important;
            background: #ffffff !important;
            /* tadinya sama kayak bg jadi gak kontras */
            box-shadow: var(--neu-shadow-raised) !important;
            border: 1px solid rgba(29, 78, 216, 0.15);
        }

        .neu-stat-label {
            color: var(--neu-text-dim) !important;
            font-weight: 700 !important;
        }

        .neu-app-domain {
            color: #4a5e73 !important;
            /* tadinya muted */
        }

        .neu-footer p {
            color: var(--neu-text-dim) !important;
        }

        .neu-hero-sub,
        .neu-section-sub,
        .neu-feature-desc {
            color: var(--neu-text-dim) !important;
        }
    </style>
</head>

<body>
    <!-- Animated background shapes -->
    <div class="neu-bg-shapes" aria-hidden="true">
        <div class="neu-shape neu-shape-1"></div>
        <div class="neu-shape neu-shape-2"></div>
        <div class="neu-shape neu-shape-3"></div>
        <div class="neu-shape neu-shape-4"></div>
    </div>

    <main>
        <!-- Navigation -->
        <nav class="neu-navbar" aria-label="Navigasi utama">
            <a href="#" class="neu-brand" aria-label="Beranda">
                <img src="<?= $logo_satker ?? 'assets/img/ms-bna.png' ?>" alt="Logo MS Banda Aceh" />
                <div class="neu-brand-text">
                    <span
                        class="neu-brand-title"><?= htmlspecialchars($nama_satker ?? 'MS Banda Aceh', ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="neu-brand-sub">Single Sign-On</span>
                </div>
            </a>

            <div class="neu-nav-links" id="neu-nav-links">
                <a href="#apps" class="neu-nav-link active">Aplikasi</a>
                <a href="#features" class="neu-nav-link">Fitur</a>
                <a href="#contact" class="neu-nav-link">Kontak</a>
                <a href="<?= site_url('login') ?>" class="neu-btn neu-btn-primary">Masuk</a>
            </div>

            <button class="neu-menu-btn" id="neu-menu-btn" aria-label="Buka menu">
                <i class="bx bx-menu"></i>
            </button>

            <!-- Mobile menu -->
            <div class="neu-mobile-menu" id="neu-mobile-menu">
                <a href="#apps">Aplikasi</a>
                <a href="#features">Fitur</a>
                <a href="#contact">Kontak</a>
                <a href="<?= site_url('login') ?>" class="neu-btn neu-btn-primary" style="margin-top:8px">Masuk</a>
            </div>
        </nav>

        <!-- Hero -->
        <div class="neu-wrap">
            <section class="neu-hero" id="hero">
                <div class="neu-hero-logo neu-reveal">
                    <img src="<?= $logo_satker ?? 'assets/img/ms-bna.png' ?>" alt="Logo" />
                </div>
                <div class="neu-hero-badge neu-reveal">
                    <span class="neu-pulse"></span>
                    Sistem Terintegrasi
                </div>
                <h1 class="neu-hero-title neu-reveal">
                    <?= htmlspecialchars($nama_satker ?? 'Mahkamah Syar\'iyah Banda Aceh', ENT_QUOTES, 'UTF-8') ?>
                    <br /><span style="font-weight:400;font-size:0.7em;color:var(--neu-text-dim)">
                        Single Sign-On Portal
                    </span>
                </h1>
                <p class="neu-hero-sub neu-reveal">
                    Akses semua aplikasi internal dalam satu tempat.
                    Login sekali, gunakan semua layanan digital Mahkamah Syar'iyah Banda Aceh.
                </p>
                <div class="neu-hero-cta neu-reveal">
                    <a href="<?= site_url('login') ?>" class="neu-btn neu-btn-primary">
                        <i class="bx bx-log-in"></i> Masuk Sekarang
                    </a>
                    <a href="#apps" class="neu-btn">
                        <i class="bx bx-grid-alt"></i> Lihat Aplikasi
                    </a>
                </div>
            </section>

            <!-- Stats -->
            <div class="neu-stats neu-reveal">
                <div class="neu-stat-card">
                    <div class="neu-stat-value"><?= count($hasil ?? []) ?></div>
                    <div class="neu-stat-label">Aplikasi</div>
                </div>
                <div class="neu-stat-card">
                    <div class="neu-stat-value">SSO</div>
                    <div class="neu-stat-label">Terintegrasi</div>
                </div>
                <div class="neu-stat-card">
                    <div class="neu-stat-value">24/7</div>
                    <div class="neu-stat-label">Dukungan</div>
                </div>
            </div>

            <!-- App Cards -->
            <section class="neu-section" id="apps">
                <div class="neu-section-head neu-reveal">
                    <span class="neu-section-eyebrow">Portal Aplikasi</span>
                    <h2 class="neu-section-title">Aplikasi yang Tersedia</h2>
                    <p class="neu-section-sub">Pilih aplikasi untuk memulai akses terintegrasi dengan SSO MS Banda Aceh.
                    </p>
                </div>
                <div class="neu-apps-grid">
                    <?php if (!empty($hasil) && is_array($hasil)): ?>
                        <?php $delay = 0;
                        foreach ($hasil as $client): ?>
                            <?php
                            $appName = htmlspecialchars($client->nama_app, ENT_QUOTES, 'UTF-8');
                            $appUrl = htmlspecialchars($client->domain, ENT_QUOTES, 'UTF-8');
                            $appDesc = htmlspecialchars($client->deskripsi ?? '', ENT_QUOTES, 'UTF-8');
                            $iconFile = !empty($client->foto) ? $client->foto : 'ms-bna.png';
                            ?>
                            <a href="<?= $appUrl ?>" target="_blank" rel="noopener noreferrer" class="neu-app-card neu-reveal"
                                style="text-decoration:none; transition-delay: <?= $delay ?>ms">
                                <div class="neu-app-icon">
                                    <img src="<?= site_url('assets/img/' . $iconFile) ?>" alt="<?= $appName ?>" loading="lazy"
                                        onerror="this.onerror=null;this.src='<?= site_url('assets/img/ms-bna.png') ?>'" />
                                </div>
                                <div class="neu-app-name"><?= $appName ?></div>
                                <div class="neu-app-domain"><?= $appUrl ?></div>
                                <?php if ($appDesc): ?>
                                    <p
                                        style="font-size:0.78rem;color:var(--neu-text-muted);margin:0 0 16px;line-height:1.45;min-height:34px">
                                        <?= $appDesc ?>
                                    </p>
                                <?php else: ?>
                                    <div style="min-height:34px"></div>
                                <?php endif; ?>
                                <span class="neu-app-cta">
                                    Buka Aplikasi <i class="bx bx-right-arrow-alt"></i>
                                </span>
                            </a>
                            <?php $delay += 60; endforeach; ?>
                    <?php else: ?>
                        <div class="neu-card-inset" style="grid-column:1/-1;text-align:center;color:var(--neu-text-muted)">
                            Belum ada aplikasi yang tersedia.
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Features -->
            <section class="neu-section" id="features">
                <div class="neu-section-head neu-reveal">
                    <span class="neu-section-eyebrow">Keunggulan</span>
                    <h2 class="neu-section-title">Mengapa SSO?</h2>
                    <p class="neu-section-sub">
                        Solusi otentikasi terpusat yang aman, cepat, dan mudah digunakan.
                    </p>
                </div>
                <div class="neu-features">
                    <div class="neu-feature neu-reveal">
                        <div class="neu-feature-icon"><i class="bx bx-lock-open-alt"></i></div>
                        <div class="neu-feature-title">Aman & Terpercaya</div>
                        <div class="neu-feature-desc">
                            Enkripsi end-to-end dan validasi multi-layer untuk melindungi setiap akses.
                        </div>
                    </div>
                    <div class="neu-feature neu-reveal">
                        <div class="neu-feature-icon"><i class="bx bx-fast-forward"></i></div>
                        <div class="neu-feature-title">Cepat & Ringan</div>
                        <div class="neu-feature-desc">
                            Waktu akses kurang dari 2 detik. Login sekali, gunakan semua aplikasi.
                        </div>
                    </div>
                    <div class="neu-feature neu-reveal">
                        <div class="neu-feature-icon"><i class="bx bx-shield-quarter"></i></div>
                        <div class="neu-feature-title">Terpusat</div>
                        <div class="neu-feature-desc">
                            Satu akun untuk semua layanan. Manajemen user & role dari satu panel.
                        </div>
                    </div>
                    <div class="neu-feature neu-reveal">
                        <div class="neu-feature-icon"><i class="bx bx-bar-chart-alt-2"></i></div>
                        <div class="neu-feature-title">Dashboard Analitik</div>
                        <div class="neu-feature-desc">
                            Pantau aktivitas login dan audit trail secara real-time.
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA / Contact -->
            <section class="neu-section" id="contact">
                <div class="neu-card-inset neu-reveal" style="text-align:center;max-width:600px;margin:0 auto">
                    <h2 class="neu-section-title" style="margin-bottom:14px">Butuh Bantuan?</h2>
                    <p style="color:var(--neu-text-dim);margin-bottom:24px;line-height:1.7">
                        Hubungi administrator SSO MS Banda Aceh untuk pembuatan akun atau bantuan teknis.
                    </p>
                    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
                        <a href="<?= site_url('login') ?>" class="neu-btn neu-btn-primary">
                            <i class="bx bx-log-in"></i> Masuk
                        </a>
                        <a href="mailto:admin@ms-bna.go.id" class="neu-btn">
                            <i class="bx bx-envelope"></i> Hubungi Admin
                        </a>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="neu-footer">
                <div class="neu-footer-content">
                    <p>&copy; 2024 <?= htmlspecialchars($nama_satker ?? 'MS Banda Aceh', ENT_QUOTES, 'UTF-8') ?>.
                        All rights reserved.</p>
                    <span class="neu-footer-brand">SSO Single Sign-On</span>
                </div>
            </footer>
        </div><!-- /neu-wrap -->

    </main>

    <script>
        // Mobile menu toggle
        (function () {
            var btn = document.getElementById('neu-menu-btn');
            var menu = document.getElementById('neu-mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', function () {
                    menu.classList.toggle('open');
                    var open = menu.classList.contains('open');
                    btn.setAttribute('aria-expanded', open);
                    btn.innerHTML = open
                        ? '<i class="bx bx-x"></i>'
                        : '<i class="bx bx-menu"></i>';
                });
            }
        })();

        // Close mobile menu on link click
        (function () {
            var menu = document.getElementById('neu-mobile-menu');
            if (menu) {
                menu.addEventListener('click', function (e) {
                    if (e.target.tagName === 'A') {
                        menu.classList.remove('open');
                        var btn = document.getElementById('neu-menu-btn');
                        if (btn) {
                            btn.setAttribute('aria-expanded', 'false');
                            btn.innerHTML = '<i class="bx bx-menu"></i>';
                        }
                    }
                });
            }
        })();

        // Active nav link on scroll
        (function () {
            var links = document.querySelectorAll('.neu-nav-links .neu-nav-link');
            var sections = document.querySelectorAll('section[id]');
            window.addEventListener('scroll', function () {
                var scrollY = window.scrollY + 120;
                sections.forEach(function (sec) {
                    var top = sec.offsetTop;
                    var h = sec.offsetHeight;
                    var id = sec.getAttribute('id');
                    if (scrollY >= top && scrollY < top + h) {
                        links.forEach(function (l) {
                            l.classList.toggle('active', l.getAttribute('href') === '#' + id);
                        });
                    }
                });
            });
        })();

        // Reveal on scroll
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
            }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
            items.forEach(function (el) { io.observe(el); });
        })();
    </script>
</body>

</html>