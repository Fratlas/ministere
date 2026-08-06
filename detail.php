<?php
require_once __DIR__ . '/app/models/ContentItem.php';

$type = strtolower((string) ($_GET['type'] ?? 'realisation'));
$itemId = (int) ($_GET['id'] ?? 0);

$allowedTypes = ['realisation', 'article', 'document', 'realisation_dgda', 'realisation_dgrad'];
if (!in_array($type, $allowedTypes, true)) {
    $type = 'realisation';
}

$model = new ContentItem();
$item = null;
$allItems = $model->getAllByType($type);

if ($itemId > 0) {
    $candidate = $model->getById($itemId);
    if ($candidate && ($candidate['content_type'] ?? '') === $type) {
        $item = $candidate;
    }
}

if (!$item && !empty($allItems)) {
    $item = $allItems[0];
}

$pageLabel = match ($type) {
    'article' => 'ARTICLE',
    'document' => 'DOCUMENT',
    'realisation_dgda' => 'REALISATION DGDA',
    'realisation_dgrad' => 'REALISATION DGRAD',
    default => 'REALISATION DGI',
};

$title = $item ? ($item['title'] . ' - Detail') : 'Detail';
if (!$item) http_response_code(404);

function d_h($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function d_image($item) {
    $img = trim((string) ($item['image_url'] ?? ''));
    if ($img !== '') {
        return $img;
    }
    return '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png';
}

function d_link($item, $type) {
    $itemId = (int) ($item['id'] ?? 0);
    return 'detail.php?type=' . rawurlencode((string) $type) . ($itemId > 0 ? '&id=' . $itemId : '');
}

ob_start();
?>
<section class="detail-modern-page">
    <?php if (!$item): ?>
        <div class="container py-5">
            <div class="alert alert-warning">Contenu introuvable.</div>
        </div>
    <?php else: ?>
        <header class="detail-modern-hero">
            <div class="container">
                <div class="detail-modern-kicker"><?php echo d_h($pageLabel); ?></div>
                <h1><?php echo d_h($item['title']); ?></h1>
            </div>
        </header>

        <section class="detail-modern-cover" style="background-image: linear-gradient(135deg, rgba(4, 33, 75, 0.45), rgba(2, 126, 189, 0.35)), url('<?php echo d_h(d_image($item)); ?>');">
            <div class="container">
                <div class="detail-modern-floating-icon">
                    <i class="bi bi-kanban"></i>
                </div>
                <h2><?php echo d_h($item['title']); ?></h2>
            </div>
        </section>

        <section class="detail-modern-content">
            <div class="container">
                <p><?php echo nl2br(d_h($item['description'])); ?></p>
                <?php if (!empty($item['badge_text'])): ?>
                    <div class="detail-modern-update">Mise à jour: <?php echo d_h($item['badge_text']); ?></div>
                <?php endif; ?>
            </div>
        </section>

        <?php if (!empty($allItems)): ?>
            <section class="detail-modern-list">
                <div class="container">
                    <h3>Toutes les réalisations</h3>
                    <div class="row g-4">
                        <?php foreach ($allItems as $entry): ?>
                            <div class="col-md-6 col-lg-4">
                                <article class="detail-modern-card">
                                    <img src="<?php echo d_h(d_image($entry)); ?>" alt="<?php echo d_h($entry['title'] ?? ''); ?>">
                                    <div class="p-3">
                                        <h4><?php echo d_h($entry['title'] ?? ''); ?></h4>
                                        <p><?php echo d_h($entry['description'] ?? ''); ?></p>
                                        <a href="<?php echo d_h(d_link($entry, $type)); ?>">En savoir plus</a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
$extraHead = <<<'HTML'
<style>
    .detail-modern-page { background: #efefef; }
    .detail-modern-hero {
        background: linear-gradient(90deg, #0d8ddd 0%, #075d9f 100%);
        color: #fff; text-align: center; padding: 66px 0 70px;
    }
    .detail-modern-kicker {
        font-size: 0.75rem; letter-spacing: 0.12em; font-weight: 800;
        opacity: 0.88; margin-bottom: 10px;
    }
    .detail-modern-hero h1 { margin: 0; font-size: clamp(2rem, 5vw, 3.3rem); font-weight: 900; }
    .detail-modern-cover {
        min-height: 380px; background-position: center; background-size: cover;
        display: flex; align-items: center; color: #fff; position: relative;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.22);
    }
    .detail-modern-cover .container { position: relative; }
    .detail-modern-cover h2 {
        margin: 0; max-width: 560px; font-size: clamp(2rem, 4.7vw, 3.9rem);
        font-weight: 900; line-height: 1.03; text-shadow: 0 8px 24px rgba(0,0,0,0.34);
    }
    .detail-modern-floating-icon {
        width: 136px; height: 136px; border-radius: 16px; background: #f3f3f3;
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 18px; box-shadow: 0 12px 28px rgba(0,0,0,0.2);
    }
    .detail-modern-floating-icon i { color: #191919; font-size: 4rem; }
    .detail-modern-content { padding: 40px 0 56px; background: #efefef; }
    .detail-modern-content .container { max-width: 980px; }
    .detail-modern-content p { color: #111; font-size: 1rem; line-height: 1.75; }
    .detail-modern-update { margin-top: 24px; font-weight: 800; font-size: 1.9rem; color: #111; }
    .detail-modern-list { background: #efefef; padding: 8px 0 56px; }
    .detail-modern-list h3 { font-size: 1.75rem; font-weight: 900; margin: 0 0 18px; color: #1c2c43; }
    .detail-modern-card { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 10px 24px rgba(0,0,0,0.08); height: 100%; }
    .detail-modern-card img { width: 100%; height: 185px; object-fit: cover; display: block; }
    .detail-modern-card h4 { font-size: 1rem; font-weight: 800; margin-bottom: 8px; }
    .detail-modern-card p { font-size: 0.9rem; line-height: 1.5; color: #4c5a70; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .detail-modern-card a { color: #0b6dd4; font-weight: 700; text-decoration: none; }
    @media (max-width: 767px) {
        .detail-modern-content { padding: 28px 0 42px; }
        .detail-modern-update { font-size: 1.35rem; }
        .detail-modern-floating-icon { width: 96px; height: 96px; }
        .detail-modern-floating-icon i { font-size: 2.8rem; }
    }
</style>
HTML;
require_once __DIR__ . '/app/views/layout.php';
