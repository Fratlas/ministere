<?php
$title = 'Ministère des Finances - Activités';

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

$extraHead = <<<'HTML'
<style>
.activities-page { background: #efefef; padding-bottom: 64px; }
.activities-page .real-hero {
    background: linear-gradient(90deg, #0d8ddd 0%, #075d9f 100%);
    color: #fff;
    text-align: center;
    padding: 64px 0 68px;
}
.activities-page .real-hero h1 {
    font-weight: 900;
    font-size: clamp(2.2rem, 4vw, 3.3rem);
    margin-bottom: 10px;
    letter-spacing: 0;
    text-transform: none;
}
.activities-page .real-hero p {
    margin: 0 auto;
    max-width: 640px;
    opacity: 0.9;
    font-size: 1.05rem;
}
.activities-page .real-divider {
    width: 88px;
    height: 4px;
    margin: 16px auto 0;
    background: linear-gradient(to right, #0a84db 0 33%, #f4d10f 33% 66%, #ce1021 66% 100%);
}
.activities-page .content-wrapper {
    position: relative;
    z-index: 2;
    margin-top: 0;
    padding-top: 48px;
    padding-bottom: 80px;
}
.activities-page .filter-box {
    background: #fff;
    border-radius: 8px;
    padding: 28px 30px;
    box-shadow: 0 14px 35px rgba(12, 25, 45, 0.08);
    margin-top: 0 !important;
    margin-bottom: 56px;
    position: relative;
    z-index: 3;
}
.activities-page .activities-grid {
    margin-top: 8px;
}
.activities-page .filter-label {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #7a8088;
    margin-bottom: 8px;
}
.activities-page .filter-box .form-control,
.activities-page .filter-box .form-select {
    min-height: 44px;
    border-radius: 6px;
    border: 1px solid #e4e8ee;
    box-shadow: none !important;
}
.activities-page .filter-box .input-group-text {
    background: #f8f9fb;
    border: 1px solid #e4e8ee;
    color: #9aa3af;
}
.activities-page .filter-box .btn-primary {
    min-height: 44px;
    border-radius: 6px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
</style>
HTML;

ob_start();
?>

<div class="activities-page">
<section class="real-hero">
    <div class="container">
        <h1>ACTIVITÉS</h1>
        <p>Découvrez les étapes clés de la transformation financière de la République Démocratique du Congo.</p>
        <div class="real-divider"></div>
    </div>
</section>

<div class="content-wrapper">
    <div class="container">
        <div class="filter-box">
            <form method="GET" action="/projects/filter">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-7">
                        <div class="filter-label">Rechercher une activité</div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Entrez des mots clés..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="filter-label">Secteur</div>
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Tous les secteurs</option>
                            <?php
                            $categories = ['Numérisation', 'Fiscalité', 'Infrastructure', 'Ressources Humaines', 'Législation', 'Transparence'];
                            foreach ($categories as $category):
                            ?>
                                <option value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>" <?php echo (($_GET['category'] ?? '') === $category) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <div class="filter-label">Statut</div>
                        <select name="status" class="form-select bg-light border-0">
                            <option value="">Tous les statuts</option>
                            <?php
                            $statuses = ['En cours', 'Terminé', 'Planifié'];
                            foreach ($statuses as $status):
                            ?>
                                <option value="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>" <?php echo (($_GET['status'] ?? '') === $status) ? 'selected' : ''; ?>>
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

        <div class="row g-4 activities-grid">
            <?php foreach ($projects as $project): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card card-project">
                    <div class="card-img-wrapper">
                        <span class="badge-status <?php echo 'status-' . strtolower(str_replace([' ', 'é', 'è'], ['', 'e', 'e'], $project['status'])); ?>">
                            <?php echo htmlspecialchars($project['status'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                        <img src="<?php echo htmlspecialchars($project['image_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="card-body">
                        <span class="project-category"><?php echo htmlspecialchars($project['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <h5 class="project-title"><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="project-desc"><?php echo htmlspecialchars(project_excerpt_view($project['description']), ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="card-footer-custom">
                            <span><?php echo htmlspecialchars($project['update_date'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <a href="/projects/<?php echo (int) $project['id']; ?>" class="btn-details-link">Voir détails →</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <nav class="mt-5">
            <ul class="pagination justify-content-center border-0">
                <li class="page-item mx-1"><a class="page-link rounded-circle" href="#"><i class="bi bi-chevron-left"></i></a></li>
                <li class="page-item mx-1 active"><a class="page-link rounded-circle" href="#">1</a></li>
                <li class="page-item mx-1"><a class="page-link rounded-circle" href="#">2</a></li>
                <li class="page-item mx-1"><a class="page-link rounded-circle" href="#">3</a></li>
                <li class="page-item mx-1"><a class="page-link rounded-circle" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
