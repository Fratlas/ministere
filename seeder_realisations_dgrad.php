<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/models/ContentItem.php';

echo "Création des réalisations DGRAD...\n";

$contentModel = new ContentItem();

$realisationsDgrad = [
    [
        'title' => 'Modernisation du système de recouvrement',
        'description' => 'Mise en place d\'un système informatisé moderne pour le recouvrement des recettes administratives et domaniales, avec automatisation des processus et traçabilité des opérations.',
        'badge_text' => '2023-2024',
        'image_url' => '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
        'section_key' => 'Recouvrement',
        'display_order' => 1
    ],
    [
        'title' => 'Digitalisation des services administratifs',
        'description' => 'Développement d\'une plateforme en ligne pour les services administratifs, permettant aux citoyens et entreprises d\'effectuer leurs démarches à distance.',
        'badge_text' => '2023-2024',
        'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
        'section_key' => 'Digitalisation',
        'display_order' => 2
    ],
    [
        'title' => 'Formation des agents DGRAD',
        'description' => 'Programme de renforcement des capacités des agents de la DGRAD sur les nouvelles technologies de l\'information et les meilleures pratiques de gestion.',
        'badge_text' => '2022-2023',
        'image_url' => '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg',
        'section_key' => 'Formation',
        'display_order' => 3
    ],
    [
        'title' => 'Mise en place d\'un ERP intégré',
        'description' => 'Déploiement d\'un système ERP intégré pour la gestion unifiée des finances, des ressources humaines et des opérations domaniales.',
        'badge_text' => '2022-2023',
        'image_url' => '/public/images/f663549282975146595d4e207e87dd7a1d17dd64.jpg',
        'section_key' => 'Technologie',
        'display_order' => 4
    ],
    [
        'title' => 'Centralisation des données domaniales',
        'description' => 'Création d\'une base de données centralisée pour le suivi et la gestion du patrimoine domanial de l\'État, avec cartographie et inventaire complet.',
        'badge_text' => '2021-2022',
        'image_url' => '/public/images/da92d29a089dcc3ff8cfadcd62c37f99f8480021.png',
        'section_key' => 'Données',
        'display_order' => 5
    ],
    [
        'title' => 'Optimisation des processus de recouvrement',
        'description' => 'Réingénierie des processus de recouvrement pour réduire les délais, améliorer l\'efficacité et augmenter les taux de collecte des recettes.',
        'badge_text' => '2021-2022',
        'image_url' => '/public/images/vid.png',
        'section_key' => 'Optimisation',
        'display_order' => 6
    ]
];

foreach ($realisationsDgrad as $index => $realisation) {
    $payload = [
        'content_type' => 'realisation_dgrad',
        'section_key' => $realisation['section_key'],
        'badge_text' => $realisation['badge_text'],
        'title' => $realisation['title'],
        'description' => $realisation['description'],
        'image_url' => $realisation['image_url'],
        'display_order' => $realisation['display_order'],
        'is_active' => 1
    ];
    
    try {
        $contentModel->create($payload);
        echo "✓ Création: " . $realisation['title'] . "\n";
    } catch (Exception $e) {
        echo "✗ Erreur lors de la création: " . $realisation['title'] . " - " . $e->getMessage() . "\n";
    }
}

echo "\nTerminé!\n";
?>
