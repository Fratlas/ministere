<?php
$title = $pageTitle ?? 'Ministère des Finances - Activités';
$bodyClass = trim(($bodyClass ?? '') . ' projects-page');

function project_excerpt_view($text, $length = 115) {
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

function project_slugify($value) {
    $value = strtolower(trim((string) $value));
    $value = strtr($value, [
        'à' => 'a', 'â' => 'a', 'ä' => 'a',
        'ç' => 'c',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'î' => 'i', 'ï' => 'i',
        'ô' => 'o', 'ö' => 'o',
        'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ÿ' => 'y',
        ' ' => '-', '\'' => '-', '/' => '-', '&' => '-',
    ]);

    return preg_replace('/[^a-z0-9\-]+/i', '', $value);
}

function project_category_tone($category) {
    $map = [
        'numerisation' => 'tone-blue',
        'fiscalite' => 'tone-red',
        'infrastructure' => 'tone-green',
        'ressources-humaines' => 'tone-teal',
        'legislation' => 'tone-amber',
        'transparence' => 'tone-cyan',
    ];

    $slug = project_slugify($category);
    return $map[$slug] ?? 'tone-blue';
}

$searchValue = (string) ($_GET['search'] ?? '');
$categoryValue = (string) ($_GET['category'] ?? '');
$statusValue = (string) ($_GET['status'] ?? '');
$displayProjects = array_values($projects ?? []);

$extraHead = <<<'HTML'
<style>
    body.projects-page {
        background:
            linear-gradient(180deg, #f6f8fc 0%, #f5f7fb 100%);
    }

    body.projects-page::before {
        opacity: 0.03;
    }

    body.projects-page .hero-section {
        position: relative;
        margin: 0 16px 28px;
        padding: 92px 0 104px;
        overflow: hidden;
        border-radius: 0 0 0 0;
        background: linear-gradient(90deg, #0d87d8 0%, #046bb3 52%, #00558f 100%);
        color: #fff;
        box-shadow: 0 22px 44px rgba(8, 94, 161, 0.12);
    }

    body.projects-page .hero-section::before,
    body.projects-page .hero-section::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    body.projects-page .hero-section::before {
        width: 260px;
        height: 260px;
        top: -70px;
        right: -60px;
    }

    body.projects-page .hero-section::after {
        width: 180px;
        height: 180px;
        left: -50px;
        bottom: -40px;
    }

    body.projects-page .hero-section .container {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 980px;
    }

    body.projects-page .hero-section h1 {
        font-size: clamp(2.7rem, 5vw, 4.4rem);
        font-weight: 900;
        letter-spacing: 0.04em;
        line-height: 1;
        margin: 0 0 18px;
        text-transform: uppercase;
        color: #fff;
    }

    body.projects-page .hero-section p {
        max-width: 720px;
        margin: 0 auto 28px;
        font-size: 1.08rem;
        line-height: 1.45;
        color: rgba(255, 255, 255, 0.92);
    }

    body.projects-page .hero-divider {
        width: 170px;
        height: 4px;
        margin: 0 auto;
        border-radius: 999px;
        background: linear-gradient(to right, #0aa2f0 0 36%, #ffd400 36% 66%, #e31b23 66% 100%);
    }

    body.projects-page .content-wrapper {
        position: relative;
        padding: 48px 0 92px;
        background: linear-gradient(180deg, #f5f7fb 0%, #f7f9fd 100%);
    }

    body.projects-page .content-wrapper::before,
    body.projects-page .content-wrapper::after {
        content: "";
        position: absolute;
        width: 360px;
        height: 360px;
        background: url('/public/images/logo.webp') center / contain no-repeat;
        opacity: 0.06;
        pointer-events: none;
    }

    body.projects-page .content-wrapper::before {
        left: -140px;
        top: 160px;
    }

    body.projects-page .content-wrapper::after {
        right: -140px;
        bottom: 160px;
    }

    body.projects-page .projects-shell {
        position: relative;
        z-index: 1;
    }

    body.projects-page .filter-box {
        background: rgba(255, 255, 255, 0.96) !important;
        border: 1px solid rgba(17, 24, 39, 0.06);
        border-radius: 2px;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.05);
        padding: 26px 28px;
        margin: 0 0 42px;
    }

    body.projects-page .filter-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 8px;
    }

    body.projects-page .filter-box .form-control,
    body.projects-page .filter-box .form-select {
        min-height: 42px;
        border-radius: 4px;
        border: 1px solid #e5e7eb;
        box-shadow: none !important;
        color: #1f2937;
    }

    body.projects-page .filter-box .form-control::placeholder {
        color: #a3aab7;
    }

    body.projects-page .filter-box .input-group-text {
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #9aa3af;
    }

    body.projects-page .filter-box .btn-primary {
        min-height: 42px;
        border-radius: 4px;
        background: linear-gradient(135deg, #0d87d8, #0b78c4);
        border: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        box-shadow: 0 8px 18px rgba(13, 135, 216, 0.18);
    }

    body.projects-page .projects-grid {
        position: relative;
        z-index: 1;
        margin-top: 18px;
    }

    body.projects-page .project-card {
        height: 100%;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
        transition: transform 0.28s ease, box-shadow 0.28s ease;
    }

    body.projects-page .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
    }

    body.projects-page .project-media {
        position: relative;
        height: 184px;
        overflow: hidden;
        background: #f3f4f6;
    }

    body.projects-page .project-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.45s ease;
    }

    body.projects-page .project-card:hover .project-media img {
        transform: scale(1.05);
    }

    body.projects-page .project-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 800;
        line-height: 1;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #fff;
    }

    body.projects-page .project-status.is-blue { background: #1490d9; }
    body.projects-page .project-status.is-green { background: #22a059; }
    body.projects-page .project-status.is-amber { background: #e8b22b; color: #1f2937; }
    body.projects-page .project-status.is-red { background: #e55353; }

    body.projects-page .project-body {
        display: flex;
        flex-direction: column;
        min-height: 222px;
        padding: 18px 18px 16px;
    }

    body.projects-page .project-category {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    body.projects-page .project-category.tone-blue { color: #1f7ed0; }
    body.projects-page .project-category.tone-red { color: #e55353; }
    body.projects-page .project-category.tone-green { color: #22a059; }
    body.projects-page .project-category.tone-teal { color: #0f9aa7; }
    body.projects-page .project-category.tone-amber { color: #f59e0b; }
    body.projects-page .project-category.tone-cyan { color: #0ea5e9; }

    body.projects-page .project-title {
        font-size: 1rem;
        line-height: 1.25;
        font-weight: 800;
        color: #111827;
        margin-bottom: 10px;
    }

    body.projects-page .project-desc {
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.52;
        margin-bottom: 16px;
        flex: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    body.projects-page .card-footer-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        border-top: 1px solid #eef2f6;
        padding-top: 14px;
        margin-top: auto;
    }

    body.projects-page .card-footer-custom span {
        font-size: 0.72rem;
        font-weight: 700;
        color: #8b93a1;
        text-transform: uppercase;
    }

    body.projects-page .btn-details-link {
        color: #1d8ad9;
        font-weight: 800;
        font-size: 0.83rem;
        text-decoration: none;
        white-space: nowrap;
    }

    body.projects-page .btn-details-link:hover {
        color: #0b67a9;
    }

    body.projects-page .projects-empty {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #edf0f4;
        padding: 36px 24px;
        text-align: center;
        color: #647189;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
    }

    body.projects-page .projects-pagination {
        margin-top: 54px;
    }

    body.projects-page .pagination {
        gap: 8px;
    }

    body.projects-page .page-link {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        background: #fff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    body.projects-page .page-link:hover {
        color: #0d87d8;
        border-color: #0d87d8;
    }

    body.projects-page .page-item.active .page-link {
        background: #0d87d8;
        border-color: #0d87d8;
        color: #fff;
    }

    body.projects-page .main-footer {
        background: linear-gradient(90deg, #0d8bdc 0%, #005b9f 100%);
        padding: 76px 0 36px;
        position: relative;
    }

    body.projects-page .footer-ribbon {
        margin-top: 38px;
        height: 5px;
        background: linear-gradient(90deg, #0a8ef0 0 38%, #ffd400 38% 68%, #d81f2a 68% 100%);
    }

    @media (max-width: 991.98px) {
        body.projects-page .hero-section {
            padding: 76px 0 82px;
        }

        body.projects-page .hero-section h1 {
            font-size: clamp(2.2rem, 8vw, 3.6rem);
        }

        body.projects-page .filter-box {
            padding: 22px 18px;
        }

        body.projects-page .project-body {
            min-height: 0;
        }
    }

    @media (max-width: 575.98px) {
        body.projects-page .hero-section,
        body.projects-page .content-wrapper {
            margin-left: 12px;
            margin-right: 12px;
        }

        body.projects-page .hero-section {
            padding: 66px 0 72px;
        }

        body.projects-page .hero-section p {
            font-size: 0.98rem;
        }

        body.projects-page .filter-box {
            padding: 18px 14px;
        }

        body.projects-page .project-media {
            height: 170px;
        }
    }
</style>
HTML;

ob_start();
?>

<section class="hero-section">
    <div class="container">
        <h1>ACTIVITÉS</h1>
        <p>Découvrez les étapes clés de la transformation financière de la République Démocratique du Congo.</p>
        <div class="hero-divider"></div>
    </div>
</section>

<div class="content-wrapper">
    <div class="container projects-shell">
        <div class="filter-box">
            <form method="GET" action="/projects/filter">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-7">
                        <div class="filter-label">Rechercher une activité</div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Entrez des mots clés..." value="<?php echo htmlspecialchars($searchValue, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="filter-label">Secteur</div>
                        <select name="category" class="form-select">
                            <option value="">Tous les secteurs</option>
                            <?php
                            $categories = ['Numérisation', 'Fiscalité', 'Infrastructure', 'Ressources Humaines', 'Législation', 'Transparence'];
                            foreach ($categories as $category):
                                $selected = $categoryValue === $category ? 'selected' : '';
                            ?>
                                <option value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <div class="filter-label">Statut</div>
                        <select name="status" class="form-select">
                            <option value="">Tous les statuts</option>
                            <?php
                            $statuses = ['En cours', 'Terminé', 'Planifié'];
                            foreach ($statuses as $status):
                                $selected = $statusValue === $status ? 'selected' : '';
                            ?>
                                <option value="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-1 d-grid">
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (!empty($displayProjects)): ?>
            <div class="row g-4 projects-grid">
                <?php foreach ($displayProjects as $project): ?>
                    <?php
                        $statusClass = project_slugify($project['status'] ?? '');
                        switch ($statusClass) {
                            case 'termine':
                                $statusClass = 'is-green';
                                break;
                            case 'planifie':
                                $statusClass = 'is-amber';
                                break;
                            case 'en-cours':
                            case 'encours':
                                $statusClass = 'is-blue';
                                break;
                            default:
                                $statusClass = 'is-blue';
                                break;
                        }
                        $categoryClass = project_category_tone($project['category'] ?? '');
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="project-card">
                            <div class="project-media">
                                <img src="<?php echo htmlspecialchars($project['image_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                <span class="project-status <?php echo $statusClass; ?>"><?php echo htmlspecialchars($project['status'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div class="project-body">
                                <span class="project-category <?php echo $categoryClass; ?>"><?php echo htmlspecialchars($project['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <h3 class="project-title"><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="project-desc"><?php echo htmlspecialchars(project_excerpt_view($project['description'], 140), ENT_QUOTES, 'UTF-8'); ?></p>
                                <div class="card-footer-custom">
                                    <span><?php echo htmlspecialchars($project['update_date'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <a href="/projects/<?php echo (int) $project['id']; ?>" class="btn-details-link">Voir détails →</a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="projects-empty">Aucune activité trouvée pour ces critères.</div>
        <?php endif; ?>

        <nav class="projects-pagination">
            <ul class="pagination justify-content-center border-0">
                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
