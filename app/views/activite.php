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
    <div class="container">
        <div class="filter-box">
            <div class="row g-3 align-items-center">
                <div class="col-lg-7">
                    <div class="filter-label">Rechercher une activité</div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Résultats filtrés par le contrôleur">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="filter-label">Secteur</div>
                    <select class="form-select bg-light border-0">
                        <option>Tous les secteurs</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <div class="filter-label">Statut</div>
                    <select class="form-select bg-light border-0">
                        <option>Tous les statuts</option>
                    </select>
                </div>
                <div class="col-lg-1 d-grid">
                    <button type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>

        <div class="row g-4">
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

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
