<?php
$title = 'Activité - ' . ($project['title'] ?? '');

function p_h($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

ob_start();
?>
<section class="detail-modern-page">
    <header class="detail-modern-hero">
        <div class="container">
            <div class="detail-modern-kicker">ACTIVITÉ</div>
            <h1><?php echo p_h($project['title'] ?? ''); ?></h1>
        </div>
    </header>

    <section class="detail-modern-cover" style="background-image: linear-gradient(135deg, rgba(4, 33, 75, 0.45), rgba(2, 126, 189, 0.35)), url('<?php echo p_h($project['image_url'] ?? '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png'); ?>');">
        <div class="container">
            <div class="detail-modern-floating-icon">
                <i class="bi bi-kanban"></i>
            </div>
            <h2><?php echo p_h($project['title'] ?? ''); ?></h2>
        </div>
    </section>

    <section class="detail-modern-content">
        <div class="container">
            <p><?php echo nl2br(p_h($project['description'] ?? '')); ?></p>
            <div class="detail-modern-meta">
                <span><strong>Catégorie:</strong> <?php echo p_h($project['category'] ?? '-'); ?></span>
                <span><strong>Statut:</strong> <?php echo p_h($project['status'] ?? '-'); ?></span>
            </div>
            <div class="detail-modern-update">Mise à jour: <?php echo p_h($project['update_date'] ?? '-'); ?></div>
        </div>
    </section>

    <section class="funding-section" aria-label="Bailleurs de fonds">
        <div class="container">
            <div class="funding-row">
                <span class="funding-label">les bailleurs <br>de fonds</span>
                <div class="funding-logos">
                    <div class="funding-logo-block">
                        <img src="/public/images/logo.webp" alt="Ministère des Finances">
                    </div>
                    <div class="funding-logo-block">
                        <img src="/public/images/eu_flag.jpg" alt="Union européenne">
                        <span class="eu-note">Financé par<br>l'Union européenne</span>
                    </div>
                    <div class="funding-partner">
                        <img src="/public/images/republique_francaise_rvb.png" alt="République française">
                        <img src="/public/images/afd_logo.webp" alt="AFD">
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    .detail-modern-meta { display: flex; gap: 28px; flex-wrap: wrap; font-weight: 600; margin-top: 18px; }
    .detail-modern-update { margin-top: 24px; font-weight: 800; font-size: 1.9rem; color: #111; }
    .funding-section { margin: 0; border-radius: 0; background: #fff; padding: 54px 0; position: relative; overflow: hidden; z-index: 1; }
    .funding-row {
        display: grid;
        grid-template-columns: minmax(0, 240px) minmax(0, 1fr);
        align-items: center;
        column-gap: clamp(20px, 4vw, 40px);
    }
    .funding-label { font-size: 1.35rem; font-weight: 800; color: #333; line-height: 1.12; white-space: nowrap; text-transform: capitalize; }
    .funding-logos {
        display: flex;
        gap: 48px;
        align-items: center;
        flex-wrap: wrap;
        flex: 1;
        padding-left: clamp(20px, 4vw, 40px);
        border-left: 1px solid rgba(0,0,0,0.28);
    }
    .funding-logo-block {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        min-height: 80px;
    }
    .funding-logo-block img {
        height: 58px;
        object-fit: contain;
        display: block;
        max-width: 120px;
    }
    .funding-logo-block .eu-note {
        display: block;
        margin-top: 8px;
        font-size: 0.78rem;
        color: #285ab2;
        font-weight: 700;
        line-height: 1.05;
    }
    .funding-partner {
        display: flex;
        align-items: center;
        gap: 40px;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .funding-partner img {
        height: 58px;
        object-fit: contain;
        max-width: 140px;
        display: block;
    }
    @media (max-width: 767px) {
        .detail-modern-content { padding: 28px 0 42px; }
        .detail-modern-update { font-size: 1.35rem; }
        .detail-modern-floating-icon { width: 96px; height: 96px; }
        .detail-modern-floating-icon i { font-size: 2.8rem; }
    }
    @media (max-width: 991.98px) {
        .funding-row { grid-template-columns: 1fr; row-gap: 20px; }
        .funding-logos { padding-left: 0; border-left: 0; }
    }
</style>
HTML;
require_once __DIR__ . '/layout.php';
?>