<?php
$pageTitle = $title ?? 'Ministère des Finances';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$currentPath = rtrim($requestPath, '/');
if ($currentPath === '') {
    $currentPath = '/';
}

$isHome = $currentPath === '/' || $currentPath === '/index.php';
$isAbout = str_starts_with($currentPath, '/about');
$isProjects = str_starts_with($currentPath, '/activite') || str_starts_with($currentPath, '/projects');
$isRealisations = str_starts_with($currentPath, '/realisations');
$isRealisationsDGDA = str_starts_with($currentPath, '/realisations-dgda');
$isRealisationsDGRAD = str_starts_with($currentPath, '/realisations-dgrad');
$isDocuments = str_starts_with($currentPath, '/documents');
$isContact = str_starts_with($currentPath, '/contact');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/images/Logo blanc_Min Finance-8.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <?php echo $extraHead ?? ''; ?>
    <link rel="stylesheet" href="/public/css/site-layout.css?v=2">
    <link rel="stylesheet" href="/public/css/mobile-responsive.css?v=1">
    <style>
        :root {
            --brand-blue: #0a85df;
            --brand-blue-deep: #004f9f;
            --text-ink: #152238;
            --text-muted: #647189;
            --surface: #ffffff;
            --btn-radius: 12px;
        }

        html {
            scroll-behavior: smooth;
            height: 100%;
            width: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-ink);
            background: #f6f8fb;
            overflow-x: hidden;
            padding-top: 130px;
            position: relative;
            z-index: 0;
        }

        main {
            flex: 1 0 auto;
            width: 100%;
            max-width: 100%;
        }

        .container > .row,
        .container-fluid > .row {
            margin-left: 0;
            margin-right: 0;
        }

        section,
        .section-shell,
        .hero-section,
        .governance-band,
        .timeline-section,
        .articles-section,
        .stats-section,
        .funding-section,
        .home-metrics-panel,
        .about-page .about-intro,
        .about-page .about-section,
        .contact-panel {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        .hero-title-wrapper,
        .timeline-section .section-header,
        .articles-section h2,
        .articles-footer,
        .stats-section .home-stats-title,
        .stats-section .home-stat,
        .home-metrics-panel .home-stat,
        .about-page .about-intro,
        .about-page .about-section,
        .contact-title,
        .contact-info,
        .contact-card,
        .contact-info-card,
        .contact-form-wrap {
            text-align: center;
        }

        .governance-grid,
        .about-page .about-authority,
        .contact-grid {
            align-items: center;
        }

        /* === FIX NAVBAR : Z-INDEX ÉLEVÉ + POSITION FORCÉE === */
        .navbar {
            padding: 22px 0;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 16px rgba(24, 45, 72, 0.04);
            backdrop-filter: blur(8px);
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 9999 !important;
            width: 100% !important;
            margin: 0 !important;
            border-radius: 0 !important;
        }

        .navbar-brand img {
            height: 66px;
        }

        .nav-link {
            font-weight: 700;
            color: #182230 !important;
            font-size: 0.78rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: -.01em;
            transition: color 0.2s ease, opacity 0.2s ease;
        }

        .nav-link:hover {
            color: var(--brand-blue) !important;
        }

        .nav-link.active[href="/"] {
            color: var(--brand-blue) !important;
        }

        .nav-link.active:not([href="/"]) {
            color: var(--brand-blue) !important;
        }

        .navbar .dropdown-toggle::after { display: none; }

        .navbar .dropdown.show .dropdown-toggle::after,
        .navbar .dropdown:hover .dropdown-toggle::after,
        .navbar .dropdown:focus-within .dropdown-toggle::after {
            transform: rotate(180deg);
        }

        .navbar .dropdown-menu {
            border: 0;
            border-radius: 18px;
            padding: 10px;
            margin-top: 12px;
            box-shadow: 0 20px 50px rgba(13, 29, 54, 0.12);
            min-width: 240px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px) scale(0.98);
            transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
            display: block;
            pointer-events: none;
        }

        .navbar .dropdown:hover > .dropdown-menu,
        .navbar .dropdown.show > .dropdown-menu,
        .navbar .dropdown:focus-within > .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .navbar .dropdown-item {
            border-radius: 12px;
            padding: 0.7rem 0.9rem;
            font-size: 0.92rem;
            font-weight: 600;
            color: #24324a;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .navbar .dropdown-item:hover,
        .navbar .dropdown-item:focus {
            background: linear-gradient(135deg, rgba(10, 133, 223, 0.1), rgba(20, 99, 255, 0.12));
            color: var(--brand-blue);
            transform: translateX(4px);
        }

        .navbar .dropdown-divider {
            margin: 0.35rem 0;
            opacity: 0.12;
        }

        .navbar-nav {
            column-gap: clamp(22px, 2.8vw, 48px);
        }

        @media (min-width: 992px) {
            .navbar-nav {
                margin-left: 0;
            }

            .navbar > .site-shell,
            .navbar > .navbar-shell {
                padding-top: 4px;
                padding-bottom: 4px;
            }
        }

        .btn-contact {
            background: var(--brand-blue);
            color: white !important;
            border-radius: var(--btn-radius);
            padding: 12px 20px;
            font-weight: 800;
            font-size: 0.76rem;
            text-transform: uppercase;
            box-shadow: 0 8px 18px rgba(10, 133, 223, 0.22);
        }

        .hero-btn-custom,
        .btn-articles,
        .contact-submit,
        .activities-page .filter-box .btn-primary {
            border-radius: var(--btn-radius);
        }

        .btn-contact:hover {
            background: var(--brand-blue-deep);
            color: white !important;
        }

        .main-footer {
            background: linear-gradient(105deg, #078ed8 0%, #006eb6 48%, #00558e 100%);
            color: white;
            padding: 92px 0 0;
            margin-top: auto;
            flex-shrink: 0;
            position: relative;
            overflow: visible;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }

        .footer-upper {
            padding-bottom: 28px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1fr;
            grid-template-rows: auto auto;
            column-gap: clamp(32px, 5vw, 78px);
            row-gap: 18px;
            align-items: start;
        }

        .footer-col {
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-self: start;
        }

        .footer-brand-col {
            grid-column: 1;
            grid-row: 1 / -1;
            align-self: stretch;
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .footer-grid > .footer-column {
            grid-row: 1;
            align-self: start;
        }

        .footer-brand-box {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .footer-brand-box img {
            height: 64px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .footer-brand-text {
            font-weight: 800;
            line-height: 1.05;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
        }

        .footer-address {
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.35;
            margin-bottom: 0;
            font-size: 0.82rem;
        }

        .footer-contact-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: clamp(24px, 4vw, 48px);
            flex-wrap: wrap;
            padding: 0;
            margin-top: auto;
            padding-top: 74px;
            overflow: visible;
        }

        .social-circles {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: nowrap;
            overflow: visible;
            flex-shrink: 0;
        }

        .main-footer .social-circle {
            width: 42px;
            height: 42px;
            min-width: 42px;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #0076bc;
            text-decoration: none;
            opacity: 1;
            border-radius: 50%;
            border: 0;
            background: #fff;
            font-size: 1.15rem;
            overflow: visible !important;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.14);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .main-footer .social-circle i {
            display: block;
            line-height: 1;
        }

        .main-footer .social-circle:hover {
            opacity: 1;
            color: #00558e;
            transform: scale(1.08);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
        }

        .call-center-text {
            font-size: 1.18rem;
            font-weight: 500;
            margin-left: 0;
            white-space: nowrap;
        }

        .footer-column h5 {
            font-size: 1.05rem;
            font-weight: 800;
            text-transform: uppercase;
            margin: 6px 0 26px;
            letter-spacing: 0.02em;
        }

        .footer-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.88);
            text-decoration: none;
            gap: 11px;
            margin-bottom: 18px;
            font-size: 0.95rem;
        }

        .footer-link i {
            margin-right: 0;
            font-size: 1.15rem;
        }

        .footer-link:hover {
            color: #fff;
        }

        .footer-ribbon {
            display: block;
            width: 100%;
            height: 6px;
            margin-top: 60px;
            flex-shrink: 0;
            background: linear-gradient(90deg, #00a5e7 0 32%, #ffd100 32% 64%, #ce1126 64% 100%);
        }

        /* === Z-INDEX POUR LES SECTIONS (pour éviter les conflits avec navbar) === */
        .hero-section,
        .section-shell,
        .timeline-section-new,
        .articles-section,
        .stats-section,
        .funding-section,
        .home-metrics-panel,
        .fixed-image-section {
            position: relative;
            z-index: 1;
        }

        /* === CORRECTIONS MENU MOBILE - COMPACT === */
        @media (max-width: 991.98px) {
            .navbar {
                margin: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                border-radius: 0 !important;
                padding: 0.5rem 0;
            }

            body {
                padding-top: 68px;
            }

            .navbar-brand img {
                height: 42px;
            }

            .navbar-toggler {
                border: none;
                padding: 0.4rem;
                margin-right: 0;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            .navbar-toggler-icon {
                width: 1.4em;
                height: 1.4em;
            }

            .navbar-collapse {
                background: white;
                border-radius: 0 0 12px 12px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
                margin-top: 0.25rem;
                padding: 0;
                max-height: calc(100vh - 68px);
                overflow-y: auto;
            }

            .navbar-nav {
                gap: 0;
                padding: 0.5rem 0;
            }

            .nav-item {
                margin: 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            }

            .nav-item:last-child {
                border-bottom: none;
            }

            .nav-link {
                padding: 0.65rem 1rem !important;
                margin: 0 !important;
                font-size: 0.88rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-radius: 0;
                min-height: 44px;
            }

            .nav-link.dropdown-toggle::after {
                margin-left: auto;
                font-size: 0.75rem;
            }

            /* Dropdown fermé - caché */
            .dropdown-menu {
                display: none !important;
                background: rgba(10, 133, 223, 0.03);
                padding: 0;
                margin: 0;
                border: none;
                border-radius: 0;
                box-shadow: none;
            }

            /* Dropdown ouvert - affiché */
            .dropdown.show > .dropdown-menu {
                display: block !important;
            }

            .dropdown-item {
                padding: 0.6rem 2rem;
                font-size: 0.85rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.03);
                border-radius: 0;
                min-height: 40px;
                display: flex;
                align-items: center;
            }

            .dropdown-item:last-child {
                border-bottom: none;
            }

            .dropdown-item:hover {
                background: rgba(10, 133, 223, 0.08);
                padding-left: 2.15rem;
            }

            .btn-contact {
                margin: 0.75rem 1rem;
                text-align: center;
                display: block;
                padding: 0.75rem;
                font-size: 0.8rem;
            }

            .footer-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
                column-gap: 24px;
                row-gap: 0;
            }

            .footer-brand-col {
                order: 10;
                grid-column: 1 / -1;
                grid-row: auto;
                margin-top: 28px;
                padding-top: 28px;
                border-top: 1px solid rgba(255, 255, 255, 0.18);
            }

            .footer-grid > .footer-column {
                order: 1;
                grid-row: auto;
            }

            .footer-column {
                margin-top: 8px;
            }

            .footer-brand-col .footer-address {
                order: 1;
                text-align: center;
                margin-bottom: 0;
            }

            .footer-brand-col .footer-brand-box {
                order: 2;
                justify-content: center;
                margin-top: 20px;
                margin-bottom: 18px;
            }

            .footer-brand-col .footer-contact-row {
                order: 3;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin-top: 0;
                padding-top: 0;
                gap: 18px;
            }

            .footer-brand-col .call-center-text {
                text-align: center;
            }

            .main-footer {
                padding-top: 60px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding-top: 64px;
            }

            .navbar {
                padding: 0.4rem 0;
            }

            .navbar-brand img {
                height: 38px;
            }

            .navbar-collapse {
                padding: 0;
            }

            .navbar-nav {
                padding: 0.4rem 0;
            }

            .nav-link {
                padding: 0.6rem 0.9rem !important;
                font-size: 0.85rem;
                min-height: 42px;
            }

            .dropdown-item {
                padding: 0.55rem 1.8rem;
                font-size: 0.82rem;
                min-height: 38px;
            }

            .dropdown-item:hover {
                padding-left: 1.95rem;
            }

            .btn-contact {
                margin: 0.6rem 0.9rem;
                padding: 0.7rem;
                font-size: 0.78rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                row-gap: 4px;
            }

            .footer-brand-col {
                margin-top: 32px;
                padding-top: 32px;
            }

            .footer-brand-col .footer-brand-box img {
                height: 56px;
            }

            .footer-brand-col .footer-contact-row {
                gap: 20px;
            }

            .footer-column h5 {
                margin-bottom: 18px;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-brand img {
                height: 34px;
            }

            .nav-link {
                padding: 0.55rem 0.85rem !important;
                font-size: 0.82rem;
                min-height: 40px;
            }

            .dropdown-item {
                padding: 0.5rem 1.6rem;
                font-size: 0.8rem;
                min-height: 36px;
            }

            .dropdown-item:hover {
                padding-left: 1.75rem;
            }

            .btn-contact {
                margin: 0.5rem 0.75rem;
                padding: 0.65rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body<?php echo $isContact ? ' class="page-no-animations"' : ''; ?>>
    <!-- Overlay de transition de page -->
    <div class="page-transition"<?php echo $isContact ? ' style="display:none!important"' : ''; ?>>
        <div class="transition-spinner"></div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="site-shell navbar-shell">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="/public/images/logo.webp" alt="RDC Logo" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link<?php echo $isHome ? ' active' : ''; ?>" href="/">Accueil</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo $isAbout ? ' active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">À propos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/about#presentation-projet">Présentation du Projet</a></li>
                            <li><a class="dropdown-item" href="/about#fondements">Fondements</a></li>
                            <li><a class="dropdown-item" href="/about#missions-objectifs">Missions et Objectifs</a></li>
                            <li><a class="dropdown-item" href="/about#financement">Financements</a></li>
                            <li><a class="dropdown-item" href="/about#equipe-projet">Équipe Projet</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo $isProjects ? ' active' : ''; ?>" href="/activites" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nos activités</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/activites">Toutes les activités</a></li>
                            <li><a class="dropdown-item" href="/activites/filter?status=En+cours">En cours</a></li>
                            <li><a class="dropdown-item" href="/activites/filter?status=Terminé">Terminées</a></li>
                            <li><a class="dropdown-item" href="/activites/filter?status=Planifié">Planifiées</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo ($isRealisations || $isRealisationsDGDA || $isRealisationsDGRAD) ? ' active' : ''; ?>" href="/realisations" role="button" data-bs-toggle="dropdown" aria-expanded="false">Réalisations</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/realisations#dgi">Réalisations à la DGI</a></li>
                            <li><a class="dropdown-item" href="/realisations-dgda">Réalisations à la DGDA</a></li>
                            <li><a class="dropdown-item" href="/realisations-dgrad">Réalisations à la DGRAD</a></li>
                            <li><a class="dropdown-item" href="/realisations#autres">Autres réalisations</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link<?php echo $isDocuments ? ' active' : ''; ?>" href="/documents">Documents</a></li>
                </ul>
                <a href="/contact" class="btn btn-contact d-lg-none<?php echo $isContact ? ' active' : ''; ?>">Nous contacter</a>
            </div>
            <a href="/contact" class="btn btn-contact navbar-contact-desktop d-none d-lg-inline-flex<?php echo $isContact ? ' active' : ''; ?>">Nous contacter</a>
        </div>
    </nav>

    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="main-footer">
        <div class="site-shell footer-upper">
            <div class="footer-grid">
                <div class="footer-col footer-brand-col">
                    <div class="footer-brand-box">
                        <img src="/public/images/logo_Arm blanc.png" alt="Armoiries de la RDC">
                        <img src="/public/images/Logo blanc_Min Finance-8.png" alt="Ministère des Finances">
                    </div>
                    <p class="footer-address">
                        Concession Cotex, Local 6AB Avenue<br>
                        Colonel Mondjiba N°63 Kinshasa /<br>
                        RD Congo
                    </p>
                    <div class="footer-contact-row">
                        <div class="social-circles" aria-label="Réseaux sociaux">
                            <a href="#" class="social-circle" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-circle" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-circle" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-circle" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                        </div>
                        <div class="call-center-text">Call Center 1233</div>
                    </div>
                </div>

                <div class="footer-col footer-column">
                    <h5>Accès Rapide</h5>
                    <a href="/" class="footer-link"><i class="bi bi-chevron-right"></i>Accueil</a>
                    <a href="/about" class="footer-link"><i class="bi bi-chevron-right"></i>À propos</a>
                    <a href="/activites" class="footer-link"><i class="bi bi-chevron-right"></i>Activités</a>
                    <a href="/realisations" class="footer-link"><i class="bi bi-chevron-right"></i>Réalisations</a>
                </div>

                <div class="footer-col footer-column">
                    <h5>Réalisations</h5>
                    <a href="/realisations" class="footer-link"><i class="bi bi-chevron-right"></i>Réalisations à la DGI</a>
                    <a href="/realisations-dgda" class="footer-link"><i class="bi bi-chevron-right"></i>Réalisations à la DGDA</a>
                    <a href="/realisations-dgrad" class="footer-link"><i class="bi bi-chevron-right"></i>Réalisations à la DGRAD</a>
                    <a href="/realisations" class="footer-link"><i class="bi bi-chevron-right"></i>Autres réalisations</a>
                </div>

                <div class="footer-col footer-column">
                    <h5>Documents</h5>
                    <a href="/documents" class="footer-link"><i class="bi bi-chevron-right"></i>Tous les documents</a>
                    <a href="/documents#rapports-d-activites" class="footer-link"><i class="bi bi-chevron-right"></i>Rapports d'Activités</a>
                    <a href="/documents#textes-reglementaires" class="footer-link"><i class="bi bi-chevron-right"></i>Textes Réglementaires</a>
                    <a href="/documents#autres-ressources" class="footer-link"><i class="bi bi-chevron-right"></i>Autres ressources</a>
                </div>
            </div>
        </div>

        <div class="footer-ribbon"></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!$isContact): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/split-type"></script>
    <script src="/public/js/script.js?v=4"></script>
    <?php endif; ?>
    <script>
        // Script pour gérer l'ouverture/fermeture des dropdowns en mobile
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.navbar .dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        const dropdown = this.parentElement;
                        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                        
                        // Fermer les autres dropdowns ouverts
                        document.querySelectorAll('.navbar .dropdown.show').forEach(otherDropdown => {
                            if (otherDropdown !== dropdown) {
                                otherDropdown.classList.remove('show');
                                const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                                if (otherMenu) otherMenu.style.display = 'none';
                            }
                        });
                        
                        // Toggle le dropdown actuel
                        if (dropdown.classList.contains('show')) {
                            dropdown.classList.remove('show');
                            if (dropdownMenu) dropdownMenu.style.display = 'none';
                        } else {
                            dropdown.classList.add('show');
                            if (dropdownMenu) dropdownMenu.style.display = 'block';
                        }
                    }
                });
            });
            
            // Fermer le menu mobile lors du clic sur un lien
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navLinks = navbarCollapse.querySelectorAll('.nav-link:not(.dropdown-toggle), .dropdown-item, .btn-contact');
            const mobileMenu = document.querySelector('.navbar-toggler');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        navbarCollapse.classList.remove('show');
                        mobileMenu.setAttribute('aria-expanded', 'false');
                        
                        // Fermer tous les dropdowns
                        document.querySelectorAll('.navbar .dropdown.show').forEach(dropdown => {
                            dropdown.classList.remove('show');
                            const menu = dropdown.querySelector('.dropdown-menu');
                            if (menu) menu.style.display = 'none';
                        });
                    }
                });
            });

            function scrollToPageHash(delay = 150) {
                if (!window.location.hash) return;
                const hash = window.location.hash;
                const target = document.querySelector(hash);
                if (!target) return;
                window.setTimeout(() => {
                    const nav = document.querySelector('.navbar');
                    const offset = (nav ? nav.offsetHeight : 100) + 16;
                    const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
                }, delay);
            }

            const isAboutPage = window.location.pathname.replace(/\/+$/, '') === '/about';
            const hashDelay = isAboutPage && window.location.hash ? 700 : 300;
            scrollToPageHash(hashDelay);
            window.addEventListener('hashchange', () => scrollToPageHash(80));

            // Liens À propos avec ancre : forcer le scroll même si déjà sur /about
            document.querySelectorAll('a.dropdown-item[href*="/about#"], a.dropdown-item[href^="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href') || '';
                    const hashIndex = href.indexOf('#');
                    if (hashIndex === -1) return;
                    const hash = href.slice(hashIndex);
                    const path = href.slice(0, hashIndex) || window.location.pathname;
                    const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
                    const targetPath = path.replace(/\/+$/, '') || '/';

                    if (targetPath === '/about' && currentPath === '/about') {
                        e.preventDefault();
                        history.pushState(null, '', hash);
                        scrollToPageHash(80);
                    }
                });
            });
        });
    </script>
</body>
</html>
