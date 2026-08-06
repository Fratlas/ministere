<?php
require_once __DIR__ . '/config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = array_values(array_unique(array_filter(array_map(static fn($p) => $p['category'] ?? '', $projects))));
$statuses = array_values(array_unique(array_filter(array_map(static fn($p) => $p['status'] ?? '', $projects))));

function h($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function project_status_class($status) {
    $value = strtolower(str_replace([' ', 'é', 'è', 'à', 'â', 'ç'], ['', 'e', 'e', 'a', 'a', 'c'], (string) $status));
    return match ($value) {
        'encours' => 'status-encours',
        'termine' => 'status-termine',
        'planifie' => 'status-planifie',
        default => 'status-encours',
    };
}

function project_excerpt($text, $length = 115) {
    $text = trim((string) $text);
    if ($text === '') {
        return '';
    }

    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $length, '...', 'UTF-8');
    }

    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length - 3) . '...';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ministère des Finances - Projets</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="public/images/Logo blanc_Min Finance-8.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --blue: #0b7ee3;
            --blue-dark: #09539f;
            --ink: #1b2432;
            --muted: #6a7380;
            --surface: rgba(255, 255, 255, 0.96);
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f9fc;
            color: #1a2b4c;
        }

        .site-shell { position: relative; z-index: 1; }

        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(13, 28, 54, 0.06);
            margin: 12px 16px 0;
        }

        .navbar-brand img { height: 50px; }
        .nav-link {
            font-weight: 700;
            color: #283243 !important;
            font-size: 0.84rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin: 0 8px;
        }
        .nav-link.active { color: var(--blue) !important; }
        .btn-contact {
            background: linear-gradient(135deg, var(--blue), #1b63ff);
            color: #fff !important;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 800;
            font-size: 0.84rem;
            text-transform: uppercase;
            box-shadow: 0 12px 28px rgba(11, 126, 227, 0.24);
        }

        .nav-item.dropdown {
            position: relative;
        }

        .dropdown-toggle::after {
            margin-left: 0.45rem;
            vertical-align: 0.16em;
        }

        .dropdown-menu {
            display: block;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(10px);
            margin-top: 0.5rem;
            min-width: 230px;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(13, 28, 54, 0.14);
            z-index: 1045;
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
        }

        .nav-item.dropdown:hover > .dropdown-menu,
        .nav-item.dropdown:focus-within > .dropdown-menu,
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 0.75rem 1.1rem;
            font-weight: 600;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            color: var(--blue);
            background: rgba(11, 126, 227, 0.08);
        }

        @media (max-width: 991.98px) {
            .dropdown-menu {
                position: static;
                margin-top: 0;
                margin-bottom: 0.75rem;
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                transform: none;
                box-shadow: none;
                display: none;
            }

            .dropdown-menu.show {
                display: block;
            }
        }

        .hero-section {
            background: linear-gradient(90deg, #1182d8 0%, #0a64b5 100%);
            color: white;
            padding: 92px 0 110px;
            text-align: center;
            margin: 0 16px;
            border-radius: 0 0 0 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section h1 {
            font-weight: 900;
            font-size: clamp(2.4rem, 5vw, 4.2rem);
            margin-bottom: 16px;
            letter-spacing: 0.03em;
        }
        .hero-section p {
            font-size: 1.1rem;
            max-width: 720px;
            margin: 0 auto;
            opacity: 0.94;
            line-height: 1.6;
        }

        .hero-divider {
            width: 140px;
            height: 4px;
            margin: 22px auto 0;
            background: linear-gradient(to right, #3ea2f5 0 33%, #ffd400 33% 66%, #e31b23 66% 100%);
            border-radius: 999px;
        }

        .projects-wrap {
            position: relative;
            padding: 48px 0 70px;
            margin: 0 16px;
            background: transparent;
        }

        .filter-panel {
            background: var(--surface);
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 14px 35px rgba(12, 25, 45, 0.06);
            border: 1px solid rgba(16, 30, 50, 0.05);
            margin-top: -52px;
            margin-bottom: 42px;
        }

        .filter-label {
            font-size: 0.72rem;
            font-weight: 800;
            color: #7a8088;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 8px !important;
            min-height: 46px;
            border: 1px solid #e4e8ee;
            box-shadow: none !important;
        }

        .filter-search .input-group-text {
            border-radius: 8px 0 0 8px !important;
            background: #f8fafc;
            border: 1px solid #e4e8ee;
            border-right: 0;
        }

        .filter-search .form-control {
            border-left: 0;
            background: #f8fafc;
        }

        .btn-filter {
            height: 46px;
            border-radius: 8px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--blue), #1369ff);
            border: 0;
            box-shadow: 0 12px 24px rgba(11, 126, 227, 0.18);
        }

        .project-grid {
            margin-top: 8px;
        }

        .project-card {
            position: relative;
            height: 100%;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(17, 29, 48, 0.08);
            transition: transform 0.35s ease, box-shadow 0.35s ease;
            border: 1px solid rgba(14, 26, 43, 0.06);
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 22px 44px rgba(17, 29, 48, 0.14);
        }

        .project-image-wrap {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 10;
            background: #eef2f7;
        }

        .project-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.65s ease, filter 0.65s ease;
        }

        .project-card:hover .project-image-wrap img {
            transform: scale(1.05);
            filter: saturate(1.05);
        }

        .project-status {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            color: #fff;
            z-index: 2;
        }

        .status-encours { background: #0d86d9; }
        .status-termine { background: #159a43; }
        .status-planifie { background: #f2c312; color: #111; }

        .project-body {
            padding: 18px 18px 14px;
        }

        .project-category {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .project-title {
            font-size: 1.05rem;
            font-weight: 900;
            line-height: 1.25;
            margin-bottom: 10px;
            color: #131b29;
        }

        .project-desc {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.65;
            margin-bottom: 18px;
            min-height: 72px;
        }

        .project-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            padding-top: 14px;
            border-top: 1px solid #edf1f5;
        }

        .project-meta {
            font-size: 0.72rem;
            color: #8a919d;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .btn-details {
            color: #1b8fe8;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .pagination-wrap {
            margin-top: 44px;
            display: flex;
            justify-content: center;
        }

        .pagination .page-link {
            border: 0;
            border-radius: 50% !important;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            color: #405063;
            box-shadow: 0 8px 18px rgba(20, 32, 50, 0.08);
        }

        .pagination .page-item.active .page-link {
            background: #0f7fd8;
            color: #fff;
        }

        .main-footer {
            background: linear-gradient(135deg, #1785d3 0%, #0c6bbd 100%);
            color: white;
            padding: 72px 0 36px;
            margin: 0 16px 16px;
            border-radius: 0;
            position: relative;
            overflow: hidden;
        }

        .main-footer::before,
        .main-footer::after {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            opacity: 0.06;
            pointer-events: none;
            top: 40px;
            pointer-events: none;
        }

        .main-footer::before { left: -120px; }
        .main-footer::after { right: -120px; transform: scaleX(-1); }

        .footer-logo-box {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
        }

        .footer-logo-box img { height: 40px; }
        .footer-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
        }
        .footer-link:hover { color: #fff; }

        .social-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 28px;
            padding-top: 18px;
        }

        .social-icons {
            display: flex;
            gap: 14px;
            font-size: 1.15rem;
        }

        .social-icons a {
            color: white;
            opacity: 0.9;
        }

        .call-center {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .reveal-item {
            opacity: 0;
            transform: translateY(24px) scale(0.985);
            transition: opacity 0.75s ease, transform 0.75s ease;
        }

        .reveal-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        @media (max-width: 991px) {
            .projects-wrap { padding-top: 34px; }
            .filter-panel { margin-top: -34px; }
        }

        @media (max-width: 767px) {
            .hero-section {
                padding: 68px 0 82px;
            }

            .hero-section h1 {
                font-size: 2.1rem;
            }

            .filter-panel {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="site-shell">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.html">
                    <img src="public/images/logo.webp" alt="Logo" class="me-2">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">A Propos</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="projectsDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">ACTIVITÉS</a>
                            <ul class="dropdown-menu" aria-labelledby="projectsDropdown">
                                <li><a class="dropdown-item" href="/projects">Toutes les activités</a></li>
                                <li><a class="dropdown-item" href="/projects/filter?status=encours">En cours</a></li>
                                <li><a class="dropdown-item" href="/projects/filter?status=termine">Terminées</a></li>
                                <li><a class="dropdown-item" href="/projects/filter?status=planifie">Planifiées</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="realisations.html">Realisations</a></li>
                        <li class="nav-item"><a class="nav-link" href="documents.html">Documents</a></li>
                    </ul>
                    <a href="/contact" class="btn btn-contact">Nous Contacter</a>
                </div>
            </div>
        </nav>

        <header class="hero-section reveal-item">
            <div class="container">
                <h1>PROJETS</h1>
                <p>Découvrez les étapes clés de la transformation financière de la République Démocratique du Congo.</p>
                <div class="hero-divider"></div>
            </div>
        </header>

        <main class="projects-wrap">
            <div class="container">
                <section class="filter-panel reveal-item">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-7">
                            <div class="filter-label">Rechercher un projet</div>
                            <div class="input-group filter-search">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchInput" class="form-control" placeholder="Entrez des mots clés...">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="filter-label">Secteur</div>
                            <select id="categoryFilter" class="form-select">
                                <option value="">Tous les secteurs</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo h($category); ?>"><?php echo h($category); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <div class="filter-label">Statut</div>
                            <select id="statusFilter" class="form-select">
                                <option value="">Tous les statuts</option>
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?php echo h($status); ?>"><?php echo h($status); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-1 d-grid">
                            <button id="resetFilters" class="btn btn-filter text-white" type="button"><i class="bi bi-arrow-counterclockwise"></i></button>
                        </div>
                    </div>
                </section>

                <section class="project-grid">
                    <div class="row g-4" id="projectsContainer">
                        <?php foreach ($projects as $project): ?>
                            <?php
                                $image = $project['image_url'] ?: 'public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg';
                                $statusClass = project_status_class($project['status']);
                                $projectUrl = 'detail.php?type=realisation&id=' . urlencode((string) $project['id']);
                            ?>
                            <div class="col-lg-4 col-md-6 project-item reveal-item"
                                 data-category="<?php echo h($project['category']); ?>"
                                 data-status="<?php echo h($project['status']); ?>"
                                 data-title="<?php echo h(mb_strtolower($project['title'], 'UTF-8')); ?>">
                                <article class="project-card">
                                    <div class="project-image-wrap">
                                        <span class="project-status <?php echo h($statusClass); ?>"><?php echo h($project['status']); ?></span>
                                        <img src="<?php echo h($image); ?>" alt="<?php echo h($project['title']); ?>">
                                    </div>
                                    <div class="project-body">
                                        <div class="project-category text-primary"><?php echo h($project['category']); ?></div>
                                        <h3 class="project-title"><?php echo h($project['title']); ?></h3>
                                        <p class="project-desc"><?php echo h(project_excerpt($project['description'])); ?></p>
                                        <div class="project-footer">
                                            <span class="project-meta"><?php echo h($project['update_date']); ?></span>
                                            <a class="btn-details" href="<?php echo h($projectUrl); ?>">Voir détails <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pagination-wrap">
                        <nav aria-label="Pagination projets">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </section>
            </div>
        </main>

        <footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="footer-logo-box d-flex gap-3 align-items-center">
                    <img src="public/images/Logo blanc_Min Finance-8.png" alt="Ministère des Finances" style="height: 60px; width: auto;">
                    <img src="public/images/logo_Arm blanc.png" alt="Logo" style="height: 60px; width: auto;">
                </div>
                <p class="footer-address">
                    Concession Cotex, Local 6AB Avenue<br>
                    Colonel Mondjiba N°63 Kinshasa /<br>
                    RD Congo
                </p>
                <div class="footer-contact-row">
                    <div class="social-circles">
                        <a href="#" class="social-circle"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-circle"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-circle"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-circle"><i class="bi bi-tiktok"></i></a>
                    </div>
                    <div class="call-center-text">
                        Call Center 1233
                    </div>
                </div>
            </div>
            <div class="col-md-2 offset-md-1 footer-column">
                <h5>ACCÈS RAPIDE</h5>
                <a href="index.html" class="footer-link"><i class="bi bi-chevron-right"></i> Accueil</a>
                <a href="about.html" class="footer-link"><i class="bi bi-chevron-right"></i> À propos</a>
                <a href="projets.php" class="footer-link"><i class="bi bi-chevron-right"></i> Projets</a>
                <a href="realisations.html" class="footer-link"><i class="bi bi-chevron-right"></i> Réalisations</a>
            </div>
            <div class="col-md-2 footer-column">
                <h5>RÉALISATIONS</h5>
                <a href="detail.php?type=realisation" class="footer-link"><i class="bi bi-chevron-right"></i> Réalisations à la DGI</a>
                <a href="detail.php?type=realisation" class="footer-link"><i class="bi bi-chevron-right"></i> Réalisations à la DGRAD</a>
                <a href="detail.php?type=realisation" class="footer-link"><i class="bi bi-chevron-right"></i> Autres réalisations</a>
            </div>
            <div class="col-md-2 footer-column">
                <h5>PROJETS</h5>
                <a href="projets.php" class="footer-link"><i class="bi bi-chevron-right"></i> Appels d'offres</a>
                <a href="realisations.html" class="footer-link"><i class="bi bi-chevron-right"></i> Nos réalisations</a>
                <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i> Financement</a>
            </div>
        </div>
    </div>
    <div class="footer-ribbon"></div>
</footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetFilters = document.getElementById('resetFilters');

        function setupReveal() {
            const targets = document.querySelectorAll('.reveal-item');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            targets.forEach((el) => observer.observe(el));
        }

        function filterProjects() {
            const search = searchInput.value.toLowerCase().trim();
            const category = categoryFilter.value;
            const status = statusFilter.value;

            document.querySelectorAll('.project-item').forEach((item) => {
                const title = item.dataset.title || '';
                const itemCategory = item.dataset.category || '';
                const itemStatus = item.dataset.status || '';

                const matchSearch = !search || title.includes(search);
                const matchCategory = !category || itemCategory === category;
                const matchStatus = !status || itemStatus === status;

                item.style.display = (matchSearch && matchCategory && matchStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterProjects);
        categoryFilter.addEventListener('change', filterProjects);
        statusFilter.addEventListener('change', filterProjects);
        resetFilters.addEventListener('click', () => {
            searchInput.value = '';
            categoryFilter.value = '';
            statusFilter.value = '';
            filterProjects();
        });

        document.addEventListener('DOMContentLoaded', setupReveal);
    </script>
</body>
</html>
