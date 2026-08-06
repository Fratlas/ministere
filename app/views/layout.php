<?php
$pageTitle = $title ?? 'Ministère des Finances';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$currentPath = rtrim($requestPath, '/');
if ($currentPath === '') {
    $currentPath = '/';
}

$isHome = $currentPath === '/' || $currentPath === '/index.php';
$isAbout = str_starts_with($currentPath, '/about');
$isProjects = str_starts_with($currentPath, '/activite');
$isRealisations = str_starts_with($currentPath, '/realisations');
$isRealisationsDGDA = str_starts_with($currentPath, '/realisations-dgda');
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
    <style>
        :root {
            --brand-blue: #0a85df;
            --brand-blue-deep: #004f9f;
            --text-ink: #152238;
            --text-muted: #647189;
            --surface: #ffffff;
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
            padding-top: 92px;
            position: relative;
            z-index: 0;
        }

        main {
            flex: 1 0 auto;
            width: 100%;
            max-width: 100%;
        }

        .container,
        .container-fluid {
            width: 100%;
            max-width: 100%;
            padding-left: clamp(18px, 3vw, 36px);
            padding-right: clamp(18px, 3vw, 36px);
        }

        .container > .row,
        .container-fluid > .row {
            margin-left: 0;
            margin-right: 0;
        }

        section,
        .section-shell,
        .hero-section,
        .governance-section,
        .timeline-section,
        .articles-section,
        .stats-section,
        .funding-section,
        .about-page .about-intro,
        .about-page .about-section,
        .contact-panel {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        .hero-title-wrapper,
        .hero-content-wrapper,
        .governance-text,
        .timeline-section .section-header,
        .articles-section h2,
        .articles-footer,
        .stats-section .home-stats-title,
        .stats-section .home-stat,
        .about-page .about-intro,
        .about-page .about-section,
        .contact-title,
        .contact-info,
        .contact-card,
        .contact-info-card,
        .contact-form-wrap {
            text-align: center;
        }

        .hero-content-wrapper {
            justify-content: center;
            align-items: center;
        }

        .governance-grid,
        .about-page .about-authority,
        .contact-grid {
            align-items: center;
        }

        /* === FIX NAVBAR : Z-INDEX ÉLEVÉ + POSITION FORCÉE === */
        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 2px 24px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
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
            height: 58px;
        }

        .nav-link {
            font-weight: 600;
            color: #526174 !important;
            font-size: 0.9rem;
            margin: 0 10px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            transition: color 0.2s ease, opacity 0.2s ease;
        }

        .nav-link:hover {
            color: #2f6eb1 !important;
        }

        .nav-link.active[href="/"] {
            color: var(--brand-blue) !important;
        }

        .nav-link.active:not([href="/"]) {
            color: #4f78ab !important;
        }

        .navbar .dropdown-toggle::after {
            margin-left: 0.45rem;
            vertical-align: 0.15em;
            transition: transform 0.25s ease;
        }

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

        .btn-contact {
            background: linear-gradient(135deg, #4d7cb7 0%, #2c5d92 100%);
            color: white !important;
            border-radius: 999px;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            box-shadow: 0 8px 18px rgba(44, 93, 146, 0.16);
        }

        .main-footer {
            background: linear-gradient(90deg, #0d8de4 0%, #004d98 100%);
            color: white;
            padding: 36px 0 0;
            margin-top: auto;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }

        .footer-upper {
            padding-bottom: 28px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr 1fr;
            column-gap: clamp(22px, 3vw, 44px);
            row-gap: 18px;
            align-items: end;
        }

        .footer-col {
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .footer-brand-box {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 12px;
        }

        .footer-brand-box img {
            height:150px;
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
            line-height: 1.5;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .footer-contact-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            padding: 16px 0 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.22);
        }

        .social-circles {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .social-circle {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            opacity: 0.92;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: rgba(255, 255, 255, 0.12);
        }

        .social-circle:hover {
            opacity: 1;
        }

        .call-center-text {
            font-size: 1rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .footer-column h5 {
            font-size: 1.05rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 18px;
            letter-spacing: 0.02em;
        }

        .footer-link {
            display: block;
            color: rgba(255, 255, 255, 0.88);
            text-decoration: none;
            margin-bottom: 14px;
            font-size: 0.95rem;
        }

        .footer-link i {
            margin-right: 8px;
        }

        .footer-link:hover {
            color: #fff;
        }

        .footer-ribbon {
            display: block;
            width: 100%;
            height: 6px;
            margin-top: 0;
            flex-shrink: 0;
            background: linear-gradient(90deg, #0da0f0 0 38%, #ffd400 38% 68%, #e31b23 68% 100%);
        }

        /* === Z-INDEX POUR LES SECTIONS (pour éviter les conflits avec navbar) === */
        .hero-section,
        .section-shell,
        .timeline-section-new,
        .articles-section,
        .stats-section,
        .funding-section,
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
                grid-template-columns: 1fr 1fr;
                column-gap: 24px;
            }

            .footer-column {
                margin-top: 8px;
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
                row-gap: 8px;
            }

            .footer-contact-row {
                justify-content: flex-start;
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
<body>
    <!-- Overlay de transition de page -->
    <div class="page-transition">
        <div class="transition-spinner"></div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="/public/images/logo.webp" alt="RDC Logo" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Basculer la navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link<?php echo $isHome ? ' active' : ''; ?>" href="/">Accueil</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo $isAbout ? ' active' : ''; ?>" href="/about" role="button" data-bs-toggle="dropdown" aria-expanded="false">À propos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/about#presentation-projet">Présentation de l'activité</a></li>
                            <li><a class="dropdown-item" href="/about#mission-objectifs">Missions et Objectifs</a></li>
                            <li><a class="dropdown-item" href="/about#financement">Financements</a></li>
                            <li><a class="dropdown-item" href="/about#equipe-projet">Équipe de l'activité</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo $isProjects ? ' active' : ''; ?>" href="/activite" role="button" data-bs-toggle="dropdown" aria-expanded="false">Activités</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/activite">Toutes les activités</a></li>
                            <li><a class="dropdown-item" href="/activite?status=en_cours">En cours</a></li>
                            <li><a class="dropdown-item" href="/activite?status=termine">Terminées</a></li>
                            <li><a class="dropdown-item" href="/activite?status=planifie">Planifiées</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo ($isRealisations || $isRealisationsDGDA) ? ' active' : ''; ?>" href="/realisations" role="button" data-bs-toggle="dropdown" aria-expanded="false">Réalisations</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/realisations#dgi">Réalisations à la DGI</a></li>
                            <li><a class="dropdown-item" href="/realisations-dgda">Réalisations à la DGDA</a></li>
                            <li><a class="dropdown-item" href="/realisations-dgrad">Réalisations à la DGRAD</a></li>
                            <li><a class="dropdown-item" href="/realisations#autres">Autres réalisations</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php echo $isDocuments ? ' active' : ''; ?>" href="/documents" role="button" data-bs-toggle="dropdown" aria-expanded="false">Documents</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/documents#rapports-activites">Rapports d’Activités</a></li>
                            <li><a class="dropdown-item" href="/documents#textes-reglementaires">Textes Réglementaires</a></li>
                            <li><a class="dropdown-item" href="/documents#autres-ressources">Autres ressources</a></li>
                        </ul>
                    </li>
                </ul>
                <a href="/contact" class="btn btn-contact<?php echo $isContact ? ' active' : ''; ?>">Nous contacter</a>
            </div>
        </div>
    </nav>

    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="main-footer">
        <div class="container footer-upper">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-brand-box">
                        <img src="/public/images/Logo blanc_Min Finance-8.png" alt="Ministère des Finances">
                        
                    </div>
                    <p class="footer-address">
                        Concession Cotex, Local 6AB Avenue<br>
                        Colonel Mondjiba N°63 Kinshasa /<br>
                        RD Congo
                    </p>
                   
                </div>

                <div class="footer-col footer-column">
                    <h5>Accès Rapide</h5>
                    <a href="/" class="footer-link"><i class="bi bi-chevron-right"></i>Accueil</a>
                    <a href="/about" class="footer-link"><i class="bi bi-chevron-right"></i>À propos</a>
                    <a href="/activite" class="footer-link"><i class="bi bi-chevron-right"></i>Activités</a>
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
                    <h5>Activités</h5>
                    <a href="/activite" class="footer-link"><i class="bi bi-chevron-right"></i>Appels d'offres</a>
                    <a href="/activite" class="footer-link"><i class="bi bi-chevron-right"></i>Nos réalisations</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>Financement</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="footer-contact-row">
                <div class="social-circles">
                    <a href="#" class="social-circle"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-circle"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-circle"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-circle"><i class="bi bi-tiktok"></i></a>
                </div>
                <div class="call-center-text">Call Center 1233</div>
            </div>
        </div>
        <div class="footer-ribbon"></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/split-type"></script>
    <script src="/public/js/script.js"></script>
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
            const navLinks = navbarCollapse.querySelectorAll('.nav-link:not(.dropdown-toggle)');
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
        });
    </script>
</body>
</html>
