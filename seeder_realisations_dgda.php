<?php
// filepath: d:\ministre\seeder_realisations_dgda.php
require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Suppression des anciennes réalisations DGDA pour réinitialiser
    $db->prepare("DELETE FROM content_items WHERE content_type = 'realisation_dgda'")->execute();
    
    // Définition des réalisations DGDA conformes à la maquette
    $realisations_dgda = [
        [
            'content_type' => 'realisation_dgda',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Fiabilisation du répertoire des assujettis',
            'description' => 'Mise à jour et validation des données des contribuables pour une meilleure traçabilité.',
            'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=600&auto=format&fit=crop',
            'link_url' => '',
            'meta_text' => json_encode([
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/3342/3342137.png'
            ]),
            'icon_class' => null,
            'display_order' => 1,
            'is_active' => 1
        ],
        [
            'content_type' => 'realisation_dgda',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Extension du répertoire des assujettis',
            'description' => 'Ajout de nouveaux contribuables identifiés sur le territoire national.',
            'image_url' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=600&auto=format&fit=crop',
            'link_url' => '',
            'meta_text' => json_encode([
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/3342/3342137.png'
            ]),
            'icon_class' => null,
            'display_order' => 2,
            'is_active' => 1
        ],
        [
            'content_type' => 'realisation_dgda',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Renforcement des capacités',
            'description' => 'Formation des agents et cadres sur les nouveaux outils de gestion numérique.',
            'image_url' => 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?q=80&w=600&auto=format&fit=crop',
            'link_url' => '',
            'meta_text' => json_encode([
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/3342/3342137.png'
            ]),
            'icon_class' => null,
            'display_order' => 3,
            'is_active' => 1
        ],
        [
            'content_type' => 'realisation_dgda',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Mise en place d\'un ERP',
            'description' => 'Déploiement d\'un système intégré de gestion des ressources et des recettes.',
            'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop',
            'link_url' => '',
            'meta_text' => json_encode([
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/3342/3342137.png'
            ]),
            'icon_class' => null,
            'display_order' => 4,
            'is_active' => 1
        ],
        [
            'content_type' => 'realisation_dgda',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Centralisation des données',
            'description' => 'Création d\'une base de données unifiée pour toutes les directions provinciales.',
            'image_url' => '',
            'link_url' => '',
            'meta_text' => json_encode([
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/3342/3342137.png',
                'is_gradient' => true
            ]),
            'icon_class' => null,
            'display_order' => 5,
            'is_active' => 1
        ],
        [
            'content_type' => 'realisation_dgda',
            'section_key' => 'DGDA',
            'badge_text' => '',
            'title' => 'Câblage et matériel divers',
            'description' => 'Installation de l\'infrastructure réseau et équipements informatiques.',
            'image_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc51?q=80&w=600&auto=format&fit=crop',
            'link_url' => '',
            'meta_text' => json_encode([
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/3342/3342137.png'
            ]),
            'icon_class' => null,
            'display_order' => 6,
            'is_active' => 1
        ]
    ];
    
    $stmt = $db->prepare("
        INSERT INTO content_items
        (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, display_order, is_active)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    foreach ($realisations_dgda as $item) {
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
            $item['display_order'],
            $item['is_active']
        ]);
    }
    
    echo "Les seeders des réalisations DGDA ont été exécutés avec succès !";
} catch (Exception $e) {
    echo "Erreur lors de l'exécution des seeders : " . $e->getMessage();
}
?>