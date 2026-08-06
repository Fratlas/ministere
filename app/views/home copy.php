<?php
$title = 'Ministère des Finances - Accueil';

$modelPath = __DIR__ . '/../models/ContentItem.php';
$contentModel = null;
if (is_file($modelPath)) {
    require_once $modelPath;
    if (class_exists('ContentItem')) {
        try {
            $contentModel = new ContentItem();
        } catch (Throwable $e) {
            $contentModel = null;
        }
    }
}

function home_h($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function home_excerpt($value, $length = 120) {
    $text = trim((string) ($value ?? ''));
    if ($text === '') return '';
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $length, '...', 'UTF-8');
    }
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length - 3) . '...';
}

function home_image($item, $fallback) {
    return !empty($item['image_url']) ? $item['image_url'] : $fallback;
}

function home_link($item, $type) {
    $rawLink = trim((string) ($item['link_url'] ?? ''));
    if ($rawLink !== '' && $rawLink !== '#') {
        if (stripos($rawLink, 'detail.php') !== false && !empty($item['id'])) {
            $parts = parse_url($rawLink);
            $query = [];
            parse_str($parts['query'] ?? '', $query);
            if (empty($query['id'])) {
                return 'detail.php?type=' . rawurlencode($type) . '&id=' . rawurlencode((string) $item['id']);
            }
        }
        return $rawLink;
    }
    if (!empty($item['id'])) return 'detail.php?type=' . rawurlencode($type) . '&id=' . rawurlencode((string) $item['id']);
    return 'detail.php?type=' . rawurlencode($type);
}

function home_fetch_items($model, $type, array $fallback) {
    if ($model) {
        try {
            $items = $model->getAllByType($type);
            if (!empty($items)) return $items;
        } catch (Throwable $e) {}
    }
    return $fallback;
}

$fallbackContent = [
    'article' => [
        ['id' => 101, 'content_type' => 'article', 'section_key' => 'Actualité', 'badge_text' => '10.02.2025', 'title' => 'Lancement du recensement national des contribuables', 'description' => 'Mobilisation nationale pour renforcer la traçabilité et l\'équité de la collecte des recettes publiques.', 'image_url' => '/public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg', 'link_url' => '#', 'display_order' => 1],
        ['id' => 102, 'content_type' => 'article', 'section_key' => 'Événement', 'badge_text' => '08.02.2025', 'title' => 'Réunion de pilotage sur les réformes', 'description' => 'Les équipes ont fait le point sur les chantiers de digitalisation et de gouvernance financière.', 'image_url' => '/public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', 'link_url' => '#', 'display_order' => 2],
        ['id' => 103, 'content_type' => 'article', 'section_key' => 'Actualité', 'badge_text' => '05.02.2025', 'title' => 'Publication des nouveaux indicateurs de suivi', 'description' => 'Diffusion des indicateurs de performance pour améliorer la lecture des résultats publics.', 'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', 'link_url' => '#', 'display_order' => 3],
        ['id' => 104, 'content_type' => 'article', 'section_key' => 'Communiqué', 'badge_text' => '03.02.2025', 'title' => 'Point de presse sur les services numériques', 'description' => 'Présentation des améliorations apportées aux services digitaux pour les usagers.', 'image_url' => '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', 'link_url' => '#', 'display_order' => 4],
    ],
    'realisation' => [
        ['id' => 201, 'content_type' => 'realisation', 'section_key' => 'DGI', 'badge_text' => '2015 - 2018', 'title' => 'Mise en œuvre et déploiement de la plateforme citoyenne sur l\'étendue de la République.', 'description' => 'Montage stratégique des projets et déploiement des réseaux d\'interconnexion. Cette phase a permis de poser les bases infrastructurelles de la modernisation des régies financières sur l\'ensemble du territoire national.', 'image_url' => '/public/images/0a0ab46ab0741BSN7gxmPWYCAKJgA9aH4yNuERpTvs4uiX.png', 'link_url' => '#', 'display_order' => 1],
        ['id' => 202, 'content_type' => 'realisation', 'section_key' => 'DGDA', 'badge_text' => '2018 - 2024', 'title' => 'Déploiement des plateformes intégrées', 'description' => 'Lancement des plateformes ISYS-REGIES, LOGIRAD, ERP et Entrepôt des données financières.', 'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', 'link_url' => '#', 'display_order' => 2],
        ['id' => 203, 'content_type' => 'realisation', 'section_key' => 'Citoyen', 'badge_text' => '2018 - 2024', 'title' => 'Plateforme citoyenne nationale', 'description' => 'Mise en œuvre et déploiement de la plateforme citoyenne sur l\'étendue de la République.', 'image_url' => '/public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', 'link_url' => '#', 'display_order' => 3],
    ],
];

$articles = home_fetch_items($contentModel, 'article', $fallbackContent['article']);
$realisations = home_fetch_items($contentModel, 'realisation', $fallbackContent['realisation']);

$heroItem = $realisations[0] ?? ($articles[0] ?? null);
$featuredItem = $articles[0] ?? ($realisations[0] ?? null);
$articleCards = array_slice($articles, 0, 4);
$timelineCards = array_slice($realisations, 0, 3);

$extraHead = <<<'HTML'
<!-- AOS Library for animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Swiper JS for Carousel -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    :root {
        --rdc-blue: #0091D5;
        --rdc-yellow: #FDE000;
        --rdc-red: #E41B23;
        --text-dark: #333333;
    }

    body { font-family: 'Inter', sans-serif; background-color: #fcfcfc; color: var(--text-dark); overflow-x: hidden; position: relative; }

    /* ========== FILIGRANE & ARRIÈRE-PLAN ========== */
    .watermark-leopard {
        position: fixed; top: 10%; right: -5%; width: 40%; opacity: 0.03;
        z-index: 0; pointer-events: none; color: #000;
    }
    
    
    
    a.youtube-link {
  display: inline-flex;   /* garde tout sur la même ligne */
  align-items: center;    /* aligne verticalement l’icône et le texte */
  color: red;
  font-size: 24px;
  text-decoration: none;
}

a.youtube-link i {
  margin-right: 8px;      /* espace entre l’icône et le texte */
  font-size: 48px;
  color: red;
}


    /* ========== HERO SECTION ========== */
    .hero-section { margin: 0; position: relative; overflow: hidden; border-radius: 0; box-shadow: 0 18px 48px rgba(0,0,0,0.08); padding: 20px 0 20px; }
    .hero-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(220,38,38,0.58) 0%, rgba(37,156,235,0.52) 100%); z-index: 1; pointer-events: none; }
    .hero-glow { position: absolute; inset: 0; background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 70%); z-index: 1; pointer-events: none; }
    .hero-stage { position: relative; z-index: 2; min-height: 300px; display: flex; flex-direction: column; justify-content: center; padding: 24px 0; }
    .hero-title-wrapper { text-align: right; margin-bottom: 18px; margin-top: 18px; width: 100%; }
    .hero-title { font-size: clamp(1.05rem, 2.1vw, 1.9rem); font-weight: 800; line-height: 1.1; margin: 0 0 10px 0; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.25); letter-spacing: -0.01em; }
    .hero-underline-custom { width: 100px; height: 10px; margin-left: auto; border-radius: 0px; background: #ffd400; box-shadow: 0 1px 4px rgba(255,212,0,0.4); }
    .hero-content-wrapper { display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 32px; width: 100%; margin: 0; z-index: 4; }
    .hero-button-side { flex: 0 0 auto; }
    .hero-btn-custom { display: flex; align-items: center; gap: 8px; background: #06b6d4; color: #fff; border-radius: 0; padding: 10px 26px; font-weight: 600; text-decoration: none; font-size: 0.85rem; transition: all 0.3s ease; border: none; cursor: pointer; box-shadow: 0 2px 8px rgba(6,182,212,0.3); letter-spacing: 0.3px; }
    .hero-btn-custom:hover { background: #0891b2; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(6,182,212,0.4); }
    .hero-btn-custom i { transition: transform 0.3s ease; font-size: 0.7rem; }
    .hero-btn-custom:hover i { transform: translateX(3px); }
    .hero-controls-bottom { display: flex; justify-content: flex-end; gap: 10px; margin-top: 0; width: auto; z-index: 3; position: relative; padding-right: 0; }
    .hero-controls-bottom button { width: 44px; height: 44px; border-radius: 50%; border: 2px solid #fff; background: rgba(255,255,255,0.25); backdrop-filter: blur(6px); color: #fff; transition: all 0.3s ease; cursor: pointer; font-size: 1.6rem; line-height: 1; display: flex; align-items: center; justify-content: center; padding: 0; text-shadow: 0 2px 10px rgba(0,0,0,0.45); }
    .hero-controls-bottom button:hover { background: rgba(255,255,255,0.45); transform: scale(1.05); border-color: #ffd400; color: #ffd400; }
    .hero-carousel { position: absolute; inset: 0; z-index: 0; }
    .hero-carousel .swiper-slide { background-size: cover; background-position: center; background-repeat: no-repeat; }
    .hero-carousel .swiper-pagination { bottom: 16px; }
    .hero-carousel .swiper-pagination-bullet { background: rgba(255,255,255,0.5); opacity: 1; width: 6px; height: 6px; }
    .hero-carousel .swiper-pagination-bullet-active { background: #ffd400; width: 20px; border-radius: 3px; }

    /* ========== GOUVERNANCE ========== */
    .section-shell { margin: 0; border-radius: 0; background: #eeeeeeff; box-shadow: 0 18px 48px rgba(0,0,0,0.05); overflow: hidden; transition: transform 0.3s ease; position: relative; z-index: 1; }
    .section-shell:hover { transform: translateY(-5px); }
    .governance-section { padding: 84px 0; background: #eeeeeeff; }
    .governance-grid { display: grid; grid-template-columns: 1.1fr 1.3fr; gap: 40px; align-items: center; }
    .governance-text h2 { font-size: clamp(2rem, 3vw, 3rem); font-weight: 800; color: #333; line-height: 1.08; margin-bottom: 18px; }
    .governance-text p { color: #555; line-height: 1.7; max-width: 420px; margin-bottom: 20px; }
    .governance-links { display: flex; gap: 18px; align-items: center; flex-wrap: wrap; }
    .governance-links a { color: #0a6fd6; font-weight: 700; text-decoration: none; transition: color 0.3s ease; }
    .governance-links a:hover { color: #e31b23; }
    .governance-card { min-height: 280px; border-radius: 18px; background: linear-gradient(135deg, rgba(25,14,103,0.78), rgba(25,14,103,0.92)), url('/public/images/centre financier.jpg') center / cover no-repeat; box-shadow: 0 18px 42px rgba(34,18,111,0.28); color: #fff; display: flex; align-items: center; justify-content: center; text-align: center; padding: 28px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .governance-card:hover { transform: scale(1.02); box-shadow: 0 25px 50px rgba(34,18,111,0.35); }
    .governance-card h3 { font-size: 1.15rem; margin: 0; }

    /* ========== TRANSFORMATION / TIMELINE ========== */
    .timeline-section { padding: 40px 0 60px; position: relative; background: #fcfcfc; overflow: hidden; margin: 0; border-radius: 0; z-index: 1; }
    .timeline-section .section-header { max-width: 640px; margin: 0 auto 20px; text-align: center; padding: 0; }
    .timeline-section .section-header h2 { font-size: clamp(2rem, 3.2vw, 2.5rem); line-height: 1.2; font-weight: 800; color: #444; letter-spacing: -0.01em; margin-bottom: 0; }
    
    .tri-color-bar { height: 5px; width: 100%; max-width: 600px; margin: 20px auto; display: flex; border-radius: 2px; overflow: hidden; }
    .bar-blue { background-color: var(--rdc-blue); flex: 1; }
    .bar-yellow { background-color: var(--rdc-yellow); flex: 1; }
    .bar-red { background-color: var(--rdc-red); flex: 1; }

    .timeline-container { position: relative; max-width: 1100px; margin: 40px auto; }
    /* Icônes calendrier */
    .timeline-icon {
        position: absolute; left: 50%; top: 0; width: 44px; height: 44px;
        background-color: var(--rdc-yellow); border-radius: 50%; transform: translateX(-50%);
        display: flex; align-items: center; justify-content: center; color: #333;
        font-size: 1.2rem; z-index: 3; box-shadow: 0 4px 8px rgba(0,0,0,0.15); border: 3px solid #fcfcfc;
    }

    .timeline-row { display: flex; width: 100%; padding: 10px 0; position: relative; margin-bottom: 40px; align-items: flex-start; }
    
    /* Timeline Line - Vertical connector */
    .timeline-line {
        position: absolute; top: 22px; bottom: -40px; left: 50%; width: 4px;
        background-color: var(--rdc-blue); transform: translateX(-50%); z-index: 1;
        pointer-events: none;
    }
    .timeline-container .timeline-row:last-of-type .timeline-line { display: none !important; }
    .timeline-container .timeline-row:last-of-type { margin-bottom: 0; }
    .timeline-content { width: 50%; position: relative; z-index: 2; }
    .left-side { padding-right: 0; text-align: right; display: flex; justify-content: flex-end; }
    .right-side { padding-left: 0; text-align: left; display: flex; justify-content: flex-start; }


    .icon-blue { background-color: var(--rdc-blue); color: white; }

    /* Cartes */
    .card-custom { border: none; border-radius: 15px; overflow: hidden; width: 92%; box-shadow: 0 10px 30px rgba(0,0,0,0.08); position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-custom:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
    .card-custom img { width: 100%; height: 210px; object-fit: cover; display: block; transition: transform 0.5s ease; }
    .card-custom:hover img { transform: scale(1.08); }
    .card-body-blue { background-color: var(--rdc-blue); color: white; padding: 18px 25px; }
    .card-body-yellow { background-color: var(--rdc-yellow); color: #333; padding: 18px 25px; }
    .phase-desc { font-size: 0.88rem; line-height: 1.4; margin-bottom: 10px; font-weight: 500; }
    .phase-years { font-weight: 800; font-size: 1.4rem; margin: 0; }

    .watermark-seal { text-align: end; opacity: 0.15; margin-bottom: 20px; padding-right: 20px; }
    .watermark-seal img { width: 10px; filter: grayscale(100%); }

    /* ========== ARTICLES ========== */
    .articles-section { margin: 0; border-radius: 0; background: linear-gradient(to right, #a0d0ff, #2674c1); color: #fff; padding: 76px 0 80px; position: relative; overflow: hidden; z-index: 1; }
    .articles-section h2 { text-align: center; font-size: clamp(2rem, 3vw, 3rem); font-weight: 800; margin-bottom: 44px; }
    .title-divider { width: 150px; height: 4px; margin: 18px auto 0; background: linear-gradient(to right, #0a7fe4 0 34%, #f3d100 34% 68%, #e31b23 68% 100%); }
    .article-card { background: #fff; color: #333; border-radius: 10px; overflow: hidden; box-shadow: 0 16px 36px rgba(0,0,0,0.08); height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .article-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0,0,0,0.15); }
    .article-card img { width: 100%; height: 180px; object-fit: cover; display: block; transition: transform 0.5s ease; }
    .article-card:hover img { transform: scale(1.08); }
    .article-card-body { padding: 18px; }
    .article-card-title { font-weight: 700; margin-bottom: 8px; }
    .article-card-desc { font-size: 0.9rem; color: #666; margin-bottom: 10px; }
    .article-link { color: #0a7fe4; font-weight: 700; text-decoration: none; transition: color 0.3s ease; }
    .article-link:hover { color: #e31b23; }
    .articles-footer { text-align: center; margin-top: 34px; }
    .btn-articles { background: #e31b23; color: #fff; border: none; border-radius: 999px; padding: 10px 28px; font-weight: 700; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
    .btn-articles:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(227,27,35,0.3); }

    /* ========== STATS & FUNDING ========== */
    .stats-section { margin: 0; border-radius: 0; background: #e7e7e7; padding: 72px 0; position: relative; overflow: hidden; z-index: 1; }
    .stats-section .home-stats-row { display: grid; grid-template-columns: minmax(0, 240px) 1px minmax(0, 1fr) 1px minmax(0, 1fr) 1px; align-items: center; column-gap: clamp(20px, 4vw, 40px); }
    .stats-section .home-stats-title { font-size: clamp(1.55rem, 2.5vw, 2rem); font-weight: 900; color: #333; line-height: 1.08; margin: 0; text-align: left; }
    .stats-section .home-stats-divider { width: 1px; height: 88px; background: rgba(0,0,0,0.32); justify-self: center; align-self: center; }
    .stats-section .home-stat { text-align: center; padding: 8px 4px; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: transform 0.3s ease; }
    .stats-section .home-stat:hover { transform: translateY(-3px); }
    .stats-section .home-stat-number { font-size: clamp(1.85rem, 3.2vw, 2.35rem); font-weight: 900; color: #333; line-height: 1; margin: 0 0 12px; letter-spacing: -0.02em; }
    .stats-section .home-stat-label { font-size: 0.88rem; font-weight: 400; color: #2f2f2f; line-height: 1.35; margin: 0; max-width: 280px; }

    .funding-section { margin: 0px; border-radius: 0; background: #fff; padding: 72px 0; margin-left: -120px; /* encore plus à gauche */; position: relative;  overflow: hidden; z-index: 1; }
    /* Même logique que "Quelques chiffres" : titre + séparateurs + contenu */
    

    .funding-row { 
        display: grid;
        grid-template-columns: minmax(0, 240px) 1px minmax(0, 1fr) 1px;
        align-items: center;
        column-gap: clamp(20px, 4vw, 100px);
        
    }
    .funding-label { font-size: clamp(1.5rem, 2.7vw, 2.1rem); font-weight: 900; color: #333; line-height: 1.12; white-space: nowrap; text-transform: capitalize; margin-right: 10px; }
    .funding-divider { width: 1px; height: 64px; background: rgba(0,0,0,0.32); justify-self: center; align-self: center; margin-right: 10px; }
    .funding-logos { 
        display: flex; 
        gap: 80px; 
        align-items: center; 
        flex-wrap: wrap; 
        flex: 1;
        justify-content: flex-start;
    }
    .funding-logo-block { 
        text-align: center; 
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        min-height: 80px;
        margin-right: 60px;
    }
    .funding-logo-block:hover { transform: none; }
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
        gap: 30px; 
        flex-wrap: wrap;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .funding-partner img { 
        height: 58px; 
        object-fit: contain; 
        transition: transform 0.3s ease;
        max-width: 140px;
        display: block;
    }
    .funding-partner img:hover { transform: none; }
    .funding-logos img { animation: none !important; transform: none !important; opacity: 1 !important; }

    /* ========== ARRIÈRE-PLANS (teet.png & armoiries.png) ========== */
    .timeline-section::before, .timeline-section::after {
        content: ""; position: absolute; width: 520px; height: 520px;
        background: url('/public/images/teet.png') center / contain no-repeat;
        opacity: 0.08; pointer-events: none; z-index: 0;
    }
    .timeline-section::before { top: auto; bottom: -190px; left: -280px; transform: scale(0.95); }
    .timeline-section::after { top: 126px; right: -230px; transform: scale(1.02); }

    /* Remove armoiries watermark from stats & funding */
    .stats-section::before, .stats-section::after,
    .funding-section::before, .funding-section::after { display: none !important; }

    /* Add armoiries watermark to Transformation (timeline) */
    .timeline-section .container { position: relative; z-index: 1; }
    .timeline-section .container::before {
        content: ""; position: absolute;
        right: -260px; bottom: -220px;
        width: 520px; height: 520px;
        background: url('/public/images/armoiri.png') center / contain no-repeat;
        opacity: 0.07; pointer-events: none; z-index: 0;
        transform: rotate(-8deg);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 991.98px) {
        .hero-stage { padding: 24px 0; min-height: 380px; }
        .hero-title-wrapper { margin-bottom: 24px; }
        .hero-title { font-size: 1.5rem; }
        .hero-content-wrapper { flex-direction: row; gap: 14px; }
        .hero-button-side { width: auto; }
        .hero-controls-bottom button { width: 40px; height: 40px; font-size: 1.4rem; }
        .stats-section .home-stats-row { grid-template-columns: 1fr; row-gap: 22px; }
        .stats-section .home-stats-divider { width: 100%; height: 1px; }
        .governance-grid { grid-template-columns: 1fr; }
        
        /* Timeline Mobile */
        .timeline-line { left: 20px; top: 22px; bottom: -40px; }
        .timeline-container .timeline-row:last-of-type .timeline-line { display: none !important; }
        .timeline-row { flex-direction: column; padding-left: 45px; }
        .timeline-content { width: 100% !important; justify-content: flex-start !important; text-align: left !important; margin-bottom: 60px; }
        .timeline-icon { left: 20px; top: 0; }
        .card-custom { width: 100%; }
        .tri-color-bar { max-width: 90%; }
        
        /* Funding Mobile */
        .funding-row { grid-template-columns: 1fr; row-gap: 16px; }
        .funding-divider { display: none; }
    }
    @media (max-width: 575.98px) {
        .hero-stage { padding: 18px 0; min-height: 260px; }
        .hero-title { font-size: 1.0rem; line-height: 1.4; }
        .hero-underline-custom { width: 120px; }
        .hero-btn-custom { padding: 8px 18px; font-size: 0.82rem; }
        .hero-content-wrapper { gap: 10px; }
        .hero-controls-bottom button { width: 36px; height: 36px; font-size: 1.2rem; }
        .timeline-section .section-header h2 { font-size: 1.8rem; }
        .phase-years { font-size: 1.2rem; }
        .card-custom img { height: 180px; }
    }

    /* Animations */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .pulse-animation { animation: pulse 2s infinite; }
</style>
HTML;

ob_start();
?>


<!-- Filigrane Léopard -->
<svg class="watermark-leopard" viewBox="0 0 100 100" aria-hidden="true">
    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="0.2" />
    <path d="M30 50 Q 50 20 70 50 T 30 50" fill="none" stroke="currentColor" stroke-width="0.2" opacity="0.5"/>
</svg>

<!-- Section Héro -->
<section class="hero-section" data-aos="fade-in" data-aos-duration="1000">
    <div class="hero-carousel swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url('/public/images/centre financier.jpg');"></div>
            <div class="swiper-slide" style="background-image: url('/public/images/centre financier.jpg');"></div>
            <div class="swiper-slide" style="background-image: url('/public/images/centre financier.jpg');"></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="hero-glow" aria-hidden="true"></div>
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="container hero-stage">
        <div class="hero-title-wrapper" data-aos="fade-right" data-aos-duration="800" data-aos-delay="200">
            <h3 class="hero-title">Mise en place <br>de la chaîne informatisée<br>de la recette publique</h3>
            <br><br>
            <div class="hero-underline-custom"></div>
        </div>
        
        <br><br>
        <div class="hero-content-wrapper" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
            <div class="hero-button-side">
                <a href="<?php echo home_h(home_link($heroItem ?? [], 'realisation')); ?>" class="hero-btn-custom">
                    <span>En savoir plus</span>
                </a>
            </div>
            <div class="hero-controls-bottom" aria-label="Navigation du carrousel" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                <button type="button" class="hero-prev" aria-label="Slide précédent"><i class="bi bi-arrow-left"></i></button>
                <button type="button" class="hero-next" aria-label="Slide suivant"><i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>
</section>

<!-- Section Gouvernance -->
<section class="section-shell" data-aos="fade-up" data-aos-duration="1000">
    <div class="container governance-section">
        <div class="governance-grid">
            <div class="governance-text" data-aos="fade-right" data-aos-duration="800">
                <h2>Visualisez le Projet <br>Gouvernance Financière</h2>
                <p><?php echo home_h(home_excerpt($featuredItem['description'] ?? 'Le Directeur Général des Impôts, Monsieur Barnabé Mukadi Muamba, dresse un bilan des réalisations de la DGI en 2025.', 180)); ?></p>
                <div class="governance-links">
                    <a href="<?php echo home_h(home_link($featuredItem ?? [], $featuredItem['content_type'] ?? 'article')); ?>">En savoir plus</a>
                    <a href="#" class="youtube-link">
                      <i class="bi bi-youtube"></i> YouTube
                    </a>

                </div>
            </div>
            <div class="governance-card" style="background-image: linear-gradient(135deg, rgba(25,14,103,0.78), rgba(25,14,103,0.92)), url('<?php echo home_h(home_image($featuredItem ?? [], '/public/images/d6aa7c59153499f8c21f31ede2d928d8e0f9d23a.png')); ?>');" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <h3><?php echo home_h($featuredItem['title'] ?? "En direct de l'Assemblée nationale"); ?></h3>
            </div>
        </div>
    </div>
</section>

<!-- Section Transformation Digitale (Timeline Design Landing Page) -->
<section class="timeline-section">
    <div class="container">
        <header class="header-section text-center" data-aos="fade-up" data-aos-duration="800">
            <h2 class="main-title">Transformation digitale des<br>Régies financières en RDC</h2>
            <div class="tri-color-bar">
                <div class="bar-blue"></div>
                <div class="bar-yellow"></div>
                <div class="bar-red"></div>
            </div>
        </header>

        <div class="timeline-container">
            <?php foreach ($timelineCards as $index => $item): ?>
                <?php
                $isRight = ($index % 2) === 1;
                $bodyClass = $isRight ? 'card-body-yellow' : 'card-body-blue';
                $iconClass = $index === 0 ? '' : 'icon-blue';
                $animationDelay = $index * 150;
                $sideClass = $isRight ? 'right-side ms-auto' : 'left-side';
                ?>
                <div class="timeline-row" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo $animationDelay; ?>">
                    <div class="timeline-line" aria-hidden="true"></div>
                    <?php if (!$isRight): ?>
                        <div class="timeline-content <?php echo $sideClass; ?>">
                            <div class="card-custom">
                                <img src="<?php echo home_h(home_image($item, '/public/images/0a0ab46ab0741BSN7gxmPWYCAKJgA9aH4yNuERpTvs4uiX.png')); ?>" alt="<?php echo home_h($item['title'] ?? 'Réalisation'); ?>">
                                <div class="<?php echo $bodyClass; ?>">
                                    <p class="phase-desc"><?php echo home_h(home_excerpt($item['description'] ?? '', 110)); ?></p>
                                    <h3 class="phase-years"><?php echo home_h($item['badge_text'] ?? ''); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-icon <?php echo $iconClass; ?>"><i class="bi bi-calendar3"></i></div>
                    <?php else: ?>
                        <div class="timeline-icon <?php echo $iconClass; ?>"><i class="bi bi-calendar3"></i></div>
                        <div class="timeline-content <?php echo $sideClass; ?>">
                            <div class="card-custom">
                                <img src="<?php echo home_h(home_image($item, '/public/images/0a0ab46ab0741BSN7gxmPWYCAKJgA9aH4yNuERpTvs4uiX.png')); ?>" alt="<?php echo home_h($item['title'] ?? 'Réalisation'); ?>">
                                <div class="<?php echo $bodyClass; ?>">
                                    <p class="phase-desc"><?php echo home_h(home_excerpt($item['description'] ?? '', 110)); ?></p>
                                    <h3 class="phase-years"><?php echo home_h($item['badge_text'] ?? ''); ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="watermark-seal">
            <img src="/public/images/armoiri.png" alt="Sceau de la RDC">
        </div>
    </div>
</section>

<!-- Section Derniers Articles -->
<section class="articles-section">
    <div class="container">
        <header class="header-section text-center" data-aos="fade-up" data-aos-duration="800">
            <h2 class="main-title">NOS DERNIERS ARTICLES</h2>
            <div class="tri-color-bar">
                <div class="bar-blue"></div>
                <div class="bar-yellow"></div>
                <div class="bar-red"></div>
            </div>
        </header>

        <div style="height:50px;"></div>
        <div class="row g-4">
            <?php foreach ($articleCards as $index => $item): ?>
                <div class="col-md-3" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="article-card">
                        <img src="<?php echo home_h(home_image($item, '/public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg')); ?>" alt="<?php echo home_h($item['title'] ?? 'Article'); ?>">
                        <div class="article-card-body">
                            <h5 class="article-card-title"><?php echo home_h($item['title'] ?? 'Article'); ?></h5>
                            <p class="article-card-desc"><?php echo home_h($item['badge_text'] ?? ($item['section_key'] ?? '')); ?></p>
                            <a href="<?php echo home_h(home_link($item, 'article')); ?>" class="article-link">En savoir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="articles-footer" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
            <button class="btn-articles">Voir toutes actualités</button>
        </div>
    </div>
</section>

<!-- Section Quelques Chiffres -->
<section class="stats-section" data-aos="fade-up" data-aos-duration="1000" aria-label="Quelques chiffres">
    <div class="container">
        <div class="home-stats-row">
            <h2 class="home-stats-title" data-aos="fade-up" data-aos-duration="600">Quelques<br>Chiffres</h2>
            <div class="home-stats-divider" aria-hidden="true"></div>
            <div class="home-stat" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="80">
                <div class="home-stat-number">21&nbsp;000</div>
                <p class="home-stat-label mb-0">Utilisateurs formés <br>dans l'ensemble de la RDC</p>
            </div>
            

            <div class="home-stat" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="160">
                <div class="home-stat-number">100</div>
                <p class="home-stat-label mb-0">Utilisateurs actifs</p>
            </div>
            
            
            <div class="home-stat" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="160">
                <div class="home-stat-number">3&nbsp;000</div>
                <p class="home-stat-label mb-0">Recettes</p>
            </div>
            <div class="home-stats-divider" aria-hidden="true"></div>
        </div>
    </div>
</section>

<!-- Section Bailleurs de Fonds -->
<section class="funding-section" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
        <div class="funding-row">
            <span class="funding-label" data-aos="fade-right" data-aos-duration="800">les bailleurs <br>de fonds</span>
            <div class="funding-divider" aria-hidden="true"></div>
            <div class="funding-logos">
                <div class="funding-logo-block" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <img src="/public/images/logo.webp" alt="Ministère des Finances">
                </div>
                <div class="funding-logo-block" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <img src="/public/images/eu_flag.jpg" alt="Union européenne">
                    <span class="eu-note">Financé par<br>l'Union européenne</span>
                </div>
                <div class="funding-partner" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                    <img src="/public/images/republique_francaise_rvb.png" alt="République française">
                    <img src="/public/images/afd_logo.webp" alt="AFD">
                </div>
            </div>
            <div class="funding-divider" aria-hidden="true"  style="margin-left:50px;"></div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();

$extraFooter = <<<'HTML'
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    AOS.init({ duration: 1000, once: false, mirror: true, offset: 100, easing: 'ease-in-out' });
    
    const heroSwiper = new Swiper('.hero-carousel', {
        loop: true, autoplay: { delay: 5000, disableOnInteraction: false }, effect: 'fade',
        fadeEffect: { crossFade: true }, pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.hero-next', prevEl: '.hero-prev' }
    });

    const animateStats = () => {
        document.querySelectorAll('.home-stat-number').forEach(counter => {
            if (counter.classList.contains('animated')) return;
            counter.classList.add('animated');
            const rawText = (counter.textContent || '').replace(/\s+/g, '');
            const hasKm = rawText.toUpperCase().includes('KM');
            const numeric = parseInt(rawText.replace(/[^\d]/g, ''), 10);
            if (!Number.isFinite(numeric) || numeric <= 0) return;

            let current = 0; const duration = 1600; const stepTime = 20; const increment = numeric / (duration / stepTime);
            const update = () => {
                current += increment; const value = current < numeric ? Math.ceil(current) : numeric;
                counter.textContent = hasKm ? `${value.toLocaleString('fr-FR')}KM` : value.toLocaleString('fr-FR');
                if (current < numeric) setTimeout(update, stepTime);
            };
            update();
        });
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) { animateStats(); observer.unobserve(entry.target); } });
    }, { threshold: 0.5 });
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) observer.observe(statsSection);

    document.querySelectorAll('.hero-controls-bottom button').forEach(btn => {
        btn.addEventListener('click', function() { this.style.transform = 'scale(0.95)'; setTimeout(() => this.style.transform = '', 200); });
    });
</script>
HTML;

$content .= $extraFooter;
require_once __DIR__ . '/layout.php';
?>