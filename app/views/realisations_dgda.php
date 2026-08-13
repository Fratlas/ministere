<?php
$title = 'Réalisations DGDA - Ministère des Finances';

$extraHead = <<<'HTML'
<style>
    .realisations-page { background: #efefef; padding-bottom: 64px; }
    .real-hero { background: linear-gradient(90deg, #0d8ddd 0%, #075d9f 100%); color: #fff; text-align: center; padding: 64px 0 68px; }
    .real-hero h1 { font-weight: 900; font-size: clamp(2.2rem, 4vw, 3.3rem); margin-bottom: 10px; }
    .real-hero p { margin: 0 auto; max-width: 640px; opacity: 0.9; font-size: 1.05rem; }
    .real-divider { width: 88px; height: 4px; margin: 16px auto 0; background: linear-gradient(to right, #0a84db 0 33%, #f4d10f 33% 66%, #ce1021 66% 100%); }
    .section-title { text-align: center; font-weight: 900; color: #1b2330; font-size: clamp(1.8rem, 3.2vw, 3rem); margin: 58px 0 42px; }
    .real-grid .realisation-card {
        border: none; border-radius: 0; overflow: hidden; box-shadow: 0 10px 24px rgba(0,0,0,0.14);
        transition: transform 0.25s ease; height: 100%; background: #fff;
        text-decoration: none; display: block;
    }
    .real-grid .realisation-card:hover { transform: translateY(-4px); }
    .real-grid .card-header-title {
        background: linear-gradient(180deg, #0d8ddd 0%, #075d9f 100%);
        color: #fff; text-align: center; font-weight: 800; min-height: 86px;
        display: flex; align-items: center; justify-content: center; padding: 14px 10px; font-size: 0.98rem;
    }
    .real-grid .card-img-container { height: 250px; background: #ececec; position: relative; overflow: hidden; }
    .real-grid .card-img-container img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .real-grid .card-overlay-icon {
        position: absolute; width: 78px; height: 78px; object-fit: contain;
        right: 16px; bottom: 14px; opacity: 0.88; filter: brightness(0) invert(1);
    }
    .real-grid .card-meta {
        padding: 10px 14px 14px; font-size: 0.85rem; color: #2f3a4b;
        font-weight: 700; text-align: center; background: #fff;
    }
    .real-empty {
        text-align: center; color: #5b6472; background: #fff; border-radius: 12px;
        padding: 48px 24px; box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }
</style>
HTML;

function dgda_image_url(array $item, int $index, array $fallbacks): string {
    $raw = trim((string) ($item['image_url'] ?? ''));
    if ($raw !== '') {
        if (preg_match('#^https?://#i', $raw)) {
            return $raw;
        }
        return str_starts_with($raw, '/') ? $raw : '/' . ltrim($raw, '/');
    }
    return $fallbacks[$index % count($fallbacks)];
}

$fallbackImages = [
    '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
    '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
    '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg',
];

ob_start();
?>

<div class="realisations-page">
    <section class="real-hero">
        <div class="site-shell">
            <h1>NOS RÉALISATIONS</h1>
            <p>Découvrez les étapes clés de la transformation financière de la République Démocratique du Congo.</p>
            <div class="real-divider"></div>
        </div>
    </section>

    <main class="site-shell">
        <h2 class="section-title">Appui à la Direction Générale des Douanes et Accises (DGDA)</h2>
        <div class="row g-4 real-grid">
            <?php if (!empty($realisations)): ?>
                <?php foreach ($realisations as $index => $item): ?>
                    <?php
                    $meta = [];
                    if (!empty($item['meta_text'])) {
                        $meta = json_decode($item['meta_text'], true) ?? [];
                    }
                    $imageUrl = dgda_image_url($item, $index, $fallbackImages);
                    $iconUrl = !empty($meta['icon_url']) ? (string) $meta['icon_url'] : '/public/images/logo_Arm blanc.png';
                    $itemId = (int) ($item['id'] ?? 0);
                    $detailUrl = 'detail.php?type=realisation_dgda' . ($itemId > 0 ? '&id=' . $itemId : '');
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8'); ?>" class="realisation-card">
                            <div class="card-header-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="card-img-container">
                                <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                <img src="<?php echo htmlspecialchars($iconUrl, ENT_QUOTES, 'UTF-8'); ?>" class="card-overlay-icon" alt="">
                            </div>
                            <?php if (!empty($item['badge_text'])): ?>
                                <div class="card-meta"><?php echo htmlspecialchars($item['badge_text'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="real-empty">Aucune réalisation DGDA publiée pour le moment. Ajoutez du contenu depuis l'administration.</div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
