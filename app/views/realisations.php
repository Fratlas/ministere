<?php
$title = 'Réalisations - Ministère des Finances';
$extraHead = <<<'HTML'
<style>
    :root { --dgi-red: #e30613; --dgi-dark: #be0710; --shell: #efefef; }
    .realisations-page { background: var(--shell); padding-bottom: 64px; }
    .real-hero { background: linear-gradient(90deg, #0d8ddd 0%, #075d9f 100%); color: #fff; text-align: center; padding: 64px 0 68px; }
    .real-hero h1 { font-weight: 900; font-size: clamp(2.2rem, 4vw, 3.3rem); margin-bottom: 10px; }
    .real-hero p { margin: 0 auto; max-width: 640px; opacity: 0.9; font-size: 1.05rem; }
    .real-divider { width: 88px; height: 4px; margin: 16px auto 0; background: linear-gradient(to right, #0a84db 0 33%, #f4d10f 33% 66%, #ce1021 66% 100%); }
    .section-title { text-align: center; font-weight: 900; color: #1b2330; font-size: clamp(1.8rem, 3.2vw, 3rem); margin: 58px 0 42px; }
    .dgi-grid .realisation-card {
        border: none; border-radius: 0; overflow: hidden; box-shadow: 0 10px 24px rgba(0,0,0,0.14);
        transition: transform 0.25s ease; height: 100%; background: #fff;
        text-decoration: none; display: block;
    }
    .dgi-grid .realisation-card:hover { transform: translateY(-4px); }
    .dgi-grid .realisation-card:focus-visible { outline: 3px solid #0a84db; outline-offset: 2px; }
    .dgi-grid .card-header-title {
        background: linear-gradient(180deg, var(--dgi-red) 0%, var(--dgi-dark) 100%);
        color: #fff; text-align: center; font-weight: 800; min-height: 86px;
        display: flex; align-items: center; justify-content: center; padding: 14px 10px; font-size: 0.98rem;
    }
    .dgi-grid .card-img-container { height: 250px; background: #ececec; position: relative; overflow: hidden; }
    .dgi-grid .card-img-container img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .dgi-grid .card-overlay-icon {
        position: absolute; width: 78px; height: 78px; object-fit: contain;
        right: 16px; bottom: 14px; opacity: 0.88; filter: brightness(0) invert(1);
    }
    .dgi-grid .card-meta {
        padding: 10px 14px 14px;
        font-size: 0.85rem;
        color: #2f3a4b;
        font-weight: 700;
        text-align: center;
        background: #fff;
    }
</style>
HTML;

ob_start();
?>

<div class="realisations-page">
    <section class="real-hero">
        <div class="container">
            <h1>NOS RÉALISATIONS</h1>
            <p>Découvrez les étapes clés de la transformation financière de la République Démocratique du Congo.</p>
            <div class="real-divider"></div>
        </div>
    </section>

    <main class="container">
        <h2 class="section-title">Réalisations à la Direction Générale des Impôts (DGI)</h2>
        <div class="row g-4 dgi-grid">
            <?php if (!empty($realisations)): ?>
                <?php foreach ($realisations as $item): ?>
                    <?php
                    $meta = [];
                    if (!empty($item['meta_text'])) {
                        $meta = json_decode($item['meta_text'], true) ?? [];
                    }
                    $imageUrl = trim((string) ($item['image_url'] ?? ''));
                    if ($imageUrl === '') {
                        $imageUrl = '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png';
                    }
                    $iconUrl = !empty($meta['icon_url']) ? (string) $meta['icon_url'] : '/public/images/logo_Arm blanc.png';
                    $itemId = (int) ($item['id'] ?? 0);
                    $detailUrl = 'detail.php?type=realisation' . ($itemId > 0 ? '&id=' . $itemId : '');
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo htmlspecialchars($detailUrl); ?>" class="realisation-card">
                            <div class="card-header-title"><?php echo htmlspecialchars($item['title']); ?></div>
                            <div class="card-img-container">
                                <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                <img src="<?php echo htmlspecialchars($iconUrl); ?>" class="card-overlay-icon" alt="Icone">
                            </div>
                            <?php if (!empty($item['badge_text'])): ?>
                                <div class="card-meta"><?php echo htmlspecialchars($item['badge_text']); ?></div>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';