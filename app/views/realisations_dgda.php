<?php
// filepath: d:\ministre\app\views\realisations_dgda.php
$title = 'Réalisations DGDA - Ministère des Finances';

$extraHead = <<<'HTML'
<style>
    :root {
        --dgda-blue: #0077c8;
        --dgda-dark-blue: #005a9c;
        --rdc-yellow: #f7d117;
        --rdc-red: #ce1021;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        color: #333;
        background-color: #fff;
    }

    /* Navbar */
    .navbar {
        background-color: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .navbar-brand img {
        max-height: 50px;
    }
    .nav-link {
        font-weight: 600;
        color: #333 !important;
        text-transform: uppercase;
        font-size: 0.85rem;
        margin: 0 10px;
    }
    .btn-contact {
        background-color: var(--dgda-blue);
        color: white;
        border-radius: 5px;
        padding: 8px 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    /* Hero Section */
    .hero-section-dgda {
        background-color: var(--dgda-blue);
        color: white;
        padding: 80px 0;
        text-align: center;
        position: relative;
    }
    .hero-section-dgda h1 {
        font-weight: 800;
        font-size: 3.5rem;
        margin-bottom: 20px;
    }
    .hero-section-dgda p {
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto 30px;
        opacity: 0.9;
    }
    .hero-divider {
        height: 4px;
        width: 150px;
        margin: 0 auto;
        display: flex;
    }
    .divider-blue { background: #0096FF; flex: 1; }
    .divider-yellow { background: var(--rdc-yellow); flex: 1; }
    .divider-red { background: var(--rdc-red); flex: 1; }

    /* Main Content */
    .section-title {
        text-align: center;
        font-weight: 800;
        color: #2c3e50;
        margin: 60px 0 50px;
        font-size: 2.2rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Cards Style */
    .realisation-card {
        border: none;
        border-radius: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
        overflow: hidden;
        margin-bottom: 30px;
    }
    .realisation-card:hover {
        transform: translateY(-5px);
    }
    .card-header-title {
        background-color: var(--dgda-blue);
        color: white;
        padding: 20px;
        text-align: center;
        font-weight: 700;
        min-height: 85px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }
    .card-img-container {
        position: relative;
        height: 250px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .card-overlay-icon {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 60px;
        opacity: 0.8;
    }

    /* Footer */
    footer {
        background-color: var(--dgda-dark-blue);
        color: white;
        padding: 60px 0 0;
        margin-top: 80px;
        border-bottom: 10px solid;
        border-image: linear-gradient(to right, var(--dgda-blue) 33%, var(--rdc-yellow) 33% 66%, var(--rdc-red) 66%) 1;
    }
    .footer-logo {
        max-height: 50px;
        margin-bottom: 20px;
    }
    .footer-links h5 {
        font-weight: 700;
        margin-bottom: 25px;
        text-transform: uppercase;
        font-size: 1rem;
    }
    .footer-links ul {
        list-style: none;
        padding: 0;
    }
    .footer-links ul li {
        margin-bottom: 12px;
    }
    .footer-links ul li a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .footer-links ul li a:hover {
        color: white;
        padding-left: 5px;
    }
    .footer-bottom {
        padding: 30px 0;
        border-top: 1px solid rgba(255,255,255,0.1);
        margin-top: 40px;
    }
    .social-icons a {
        color: white;
        font-size: 1.2rem;
        margin-right: 15px;
        opacity: 0.8;
    }
</style>
HTML;

ob_start();
?>

<!-- Hero Section -->
<header class="hero-section-dgda">
    <div class="container">
        <h1>NOS RÉALISATIONS</h1>
        <p>Découvrez les étapes clés de la transformation financière de la République Démocratique du Congo.</p>
        <div class="hero-divider">
            <div class="divider-blue"></div>
            <div class="divider-yellow"></div>
            <div class="divider-red"></div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="container">
    <h2 class="section-title">Appui à la Direction Générale des Douanes et Accises (DGDA)</h2>

    <div class="row">
        <?php
        $dgdaLocalImages = [
            '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
            '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
            '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg',
            '/public/images/f663549282975146595d4e207e87dd7a1d17dd64.jpg',
            '/public/images/da92d29a089dcc3ff8cfadcd62c37f99f8480021.png',
            '/public/images/vid.png',
        ];
        $dgdaIconUrl = '/public/images/logo.webp';
        ?>
        <?php if (!empty($realisations)): ?>
            <?php foreach ($realisations as $index => $item): ?>
                <?php 
                // Parser les métadonnées JSON si elles existent
                $meta = [];
                if (!empty($item['meta_text'])) {
                    $meta = json_decode($item['meta_text'], true) ?? [];
                }
                
                // Force local photos from /public/images when DB image is empty or external URL.
                $fallbackImage = $dgdaLocalImages[$index % count($dgdaLocalImages)];
                $rawImageUrl = trim((string) ($item['image_url'] ?? ''));
                $isExternalImage = stripos($rawImageUrl, 'http://') === 0 || stripos($rawImageUrl, 'https://') === 0;
                $imageUrl = ($rawImageUrl !== '' && !$isExternalImage) ? $rawImageUrl : $fallbackImage;
                $iconUrl = $dgdaIconUrl;
                $itemId = (int) ($item['id'] ?? 0);
                $detailUrl = 'detail.php?type=realisation_dgda' . ($itemId > 0 ? '&id=' . $itemId : '');
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="realisation-card">
                        <div class="card-header-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="card-img-container">
                            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <img src="<?php echo htmlspecialchars($iconUrl); ?>" class="card-overlay-icon" alt="icon">
                        </div>
                        <div class="p-3 text-center">
                            <a href="<?php echo htmlspecialchars($detailUrl); ?>" class="btn btn-sm btn-outline-primary fw-bold">En savoir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Afficher les données statiques par défaut si aucune donnée en base -->
            <div class="col-md-6 col-lg-4">
                <div class="realisation-card">
                    <div class="card-header-title">Fiabilisation du répertoire des assujettis</div>
                    <div class="card-img-container">
                        <img src="/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png" alt="Bureau">
                        <img src="/public/images/logo.webp" class="card-overlay-icon" alt="icon">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="realisation-card">
                    <div class="card-header-title">Extension du répertoire des assujettis</div>
                    <div class="card-img-container">
                        <img src="/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg" alt="Réunion">
                        <img src="/public/images/logo.webp" class="card-overlay-icon" alt="icon">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="realisation-card">
                    <div class="card-header-title">Renforcement des capacités</div>
                    <div class="card-img-container">
                        <img src="/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg" alt="Formation">
                        <img src="/public/images/logo.webp" class="card-overlay-icon" alt="icon">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="realisation-card">
                    <div class="card-header-title">Mise en place d'un ERP</div>
                    <div class="card-img-container">
                        <img src="/public/images/f663549282975146595d4e207e87dd7a1d17dd64.jpg" alt="Technologie">
                        <img src="/public/images/logo.webp" class="card-overlay-icon" alt="icon">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="realisation-card">
                    <div class="card-header-title">Centralisation des données</div>
                    <div class="card-img-container" style="background: linear-gradient(135deg, #004e92, #000428);">
                        <img src="/public/images/logo.webp" class="card-overlay-icon" style="position: relative; right: auto; bottom: auto; width: 100px; opacity: 1;" alt="icon">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="realisation-card">
                    <div class="card-header-title">Câblage et matériel divers</div>
                    <div class="card-img-container">
                        <img src="/public/images/vid.png" alt="Infrastructure">
                        <img src="/public/images/logo.webp" class="card-overlay-icon" alt="icon">
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>