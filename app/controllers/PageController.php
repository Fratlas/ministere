<?php
class PageController {
    private function renderHtmlPage($file, $title) {
        $source = file_get_contents($file);
        $extraHead = '';

        if (preg_match('#<style>(.*?)</style>#s', $source, $styleMatch)) {
            $extraHead = '<style>' . $styleMatch[1] . '</style>';
        }

        $content = '';
        if (preg_match('#<body\b[^>]*>(.*)</body>#is', $source, $bodyMatch)) {
            $content = $bodyMatch[1];
            $content = preg_replace('#<nav class="navbar navbar-expand-lg">.*?</nav>#s', '', $content, 1);
            $content = preg_replace('#<footer class="main-footer">.*?</footer>#s', '', $content, 1);
        }

        require __DIR__ . '/../views/layout.php';
    }

    public function index() {
        require_once __DIR__ . '/../views/home.php';
    }

    public function about() {
        require_once __DIR__ . '/../views/about.php';
    }

    public function realisations() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/ContentItem.php';
        
        $contentModel = new ContentItem();
        $realisations = $contentModel->getAllByType('realisation');
        
        require_once __DIR__ . '/../views/realisations.php';
    }

    public function realisations_dgda() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/ContentItem.php';
        
        $contentModel = new ContentItem();
        $realisations = $contentModel->getAllByType('realisation_dgda');
        
        require_once __DIR__ . '/../views/realisations_dgda.php';
    }

    public function realisations_dgrad() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/ContentItem.php';
        
        $contentModel = new ContentItem();
        $realisations = $contentModel->getAllByType('realisation_dgrad');
        
        require_once __DIR__ . '/../views/realisations_dgrad.php';
    }

    public function documents() {
        $staticView = __DIR__ . '/../../documents.html';
        if (is_file($staticView)) {
            $this->renderHtmlPage($staticView, 'Documents - Ministere des Finances');
            return;
        }

        $title = 'Documents - Ministere des Finances';
        ob_start();
        ?>

        <section class="hero-section">
            <div class="container">
                <h1>DOCUMENTS</h1>
                <p>Documents officiels et publications</p>
                <div class="hero-divider"></div>
            </div>
        </section>

        <div class="content-wrapper">
            <div class="container">
                <p>Page Documents en developpement.</p>
            </div>
        </div>

        <?php
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layout.php';
    }

    public function contact() {
        require_once __DIR__ . '/../views/contact.php';
    }
}
?>
