<?php
$htmlFiles = ['index.html', 'about.html', 'contact.html', 'documents.html', 'realisations.html', 'projets.php', 'detail.php', 'app/views/home.php', 'app/views/layout.php'];
$newFooter = <<<'EOD'
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
EOD;

$count = 0;
foreach ($htmlFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $content = preg_replace('/<footer class="main-footer">.*?<\/footer>/s', $newFooter, $content);
        file_put_contents($file, $content);
        $count++;
    }
}
echo "Remplacement effectue sur $count fichiers.";
?>
