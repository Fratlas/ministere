<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Charger les réalisations DGRAD depuis la base de données
    require_once __DIR__ . '/app/models/ContentItem.php';
    $contentModel = new ContentItem();
    $realisations = $contentModel->getAllByType('realisation_dgrad');
    
    // Si aucune réalisation trouvée, créer des données de test
    if (empty($realisations)) {
        $realisations = [
            [
                'id' => 1,
                'title' => 'Test Réalisation DGRAD',
                'description' => 'Ceci est une réalisation de test pour la DGRAD',
                'image_url' => '/public/images/logo.webp',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
    }

    // Inclure la vue
    require_once __DIR__ . '/app/views/realisations_dgrad.php';
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
    echo "<br>Trace: " . $e->getTraceAsString();
}
?>
