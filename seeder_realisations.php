<?php
require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Suppression des anciennes réalisations pour réinitialiser
    $db->prepare("DELETE FROM content_items WHERE content_type = 'realisation'")->execute();
    
    // Définition des nouvelles réalisations conformes à la maquette
    $realisations = [
        [
            'content_type' => 'realisation',
            'section_key' => 'DGI',
            'badge_text' => '2015 - 2018',
            'title' => 'Réalisations à la Direction Générale des Impôts (DGI)',
            'description' => "Montage stratégique des projets et déploiement des réseaux d'interconnexion. Cette phase a permis de poser les bases infrastructurelles de la modernisation des régies financières sur l'ensemble du territoire national.",
            'image_url' => 'public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
            'link_url' => 'detail.php?type=realisation',
            'meta_text' => json_encode([
                'badge_color' => 'blue',
                'dot_color' => 'yellow',
                'dot_icon' => 'bi bi-star-fill',
                'link_text' => 'En savoir plus',
                'link_icon' => 'bi bi-chevron-right'
            ]),
            'icon_class' => null,
            'display_order' => 1
        ],
        [
            'content_type' => 'realisation',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Appui à la Direction Générale des Douanes et Accises (DGDA)',
            'description' => "Mise en service des ERP et des entrepôts de données financières. Une révolution dans la traçabilité des recettes publiques et la gestion transparente des ressources de l'État.",
            'image_url' => 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
            'link_url' => 'detail.php?type=realisation',
            'meta_text' => json_encode([
                'dot_color' => 'blue',
                'dot_icon' => 'bi bi-cloud-fill',
                'link_text' => 'Consulter le rapport',
                'link_icon' => 'bi bi-file-earmark-text'
            ]),
            'icon_class' => null,
            'display_order' => 2
        ],
        [
            'content_type' => 'realisation',
            'section_key' => 'Plateforme',
            'badge_text' => '2018 - 2024|2018 - 2024',
            'title' => 'Mise en œuvre de la plateforme citoyenne',
            'description' => "Déploiement national d'une interface directe avec les contribuables pour simplifier les déclarations et les paiements, renforçant le civisme fiscal sur l'étendue de la République.",
            'image_url' => 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg',
            'link_url' => 'detail.php?type=realisation',
            'meta_text' => json_encode([
                'badge_color' => 'yellow',
                'badge_color_2' => 'red',
                'dot_color' => 'red',
                'dot_icon' => 'bi bi-graph-up',
                'link_text' => 'Voir les statistiques',
                'link_icon' => 'bi bi-bar-chart-fill'
            ]),
            'icon_class' => null,
            'display_order' => 3
        ]
    ];
    
    $stmt = $db->prepare("
        INSERT INTO content_items
        (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, display_order)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    foreach ($realisations as $item) {
        $stmt->execute([
            $item['content_type'],
            $item['section_key'],
            $item['badge_text'],
            $item['title'],
            $item['description'],
            $item['image_url'],
            $item['link_url'],
            $item['meta_text'],
            $item['icon_class'],
            $item['display_order']
        ]);
    }
    
    echo "Les seeders de la page Réalisations ont été exécutés avec succès !";
} catch (Exception $e) {
    echo "Erreur lors de l'exécution des seeders : " . $e->getMessage();
}
?>
