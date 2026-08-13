-- =====================================================
-- Seeder : Réalisations DGDA (6 cartes – maquette Figma)
-- Images : mêmes photos locales que la page DGI
-- Usage  : exécuter dans phpMyAdmin ou mysql CLI
-- =====================================================

USE u223322817_mini;

DELETE FROM content_items WHERE content_type = 'realisation_dgda';

INSERT INTO content_items
    (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, display_order, is_active)
VALUES
(
    'realisation_dgda',
    'DGDA',
    '',
    'Fiabilisation du répertoire des assujettis',
    'Mise à jour et validation des données des contribuables pour une meilleure traçabilité.',
    '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
    '#',
    NULL,
    NULL,
    1,
    1
),
(
    'realisation_dgda',
    'DGDA',
    '',
    'Extension du répertoire des assujettis',
    'Ajout de nouveaux contribuables identifiés sur le territoire national.',
    '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg',
    '#',
    NULL,
    NULL,
    2,
    1
),
(
    'realisation_dgda',
    'DGDA',
    '',
    'Renforcement des capacités',
    'Formation des agents et cadres sur les nouveaux outils de gestion numérique.',
    '/public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg',
    '#',
    NULL,
    NULL,
    3,
    1
),
(
    'realisation_dgda',
    'DGDA',
    '',
    'Mise en place d''un ERP',
    'Déploiement d''un système intégré de gestion des ressources et des recettes.',
    '/public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg',
    '#',
    NULL,
    NULL,
    4,
    1
),
(
    'realisation_dgda',
    'DGDA',
    '',
    'Centralisation des données',
    'Création d''une base de données unifiée pour toutes les directions provinciales.',
    '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
    '#',
    NULL,
    NULL,
    5,
    1
),
(
    'realisation_dgda',
    'DGDA',
    '',
    'Câblage et matériel divers',
    'Installation de l''infrastructure réseau et équipements informatiques.',
    '/public/images/d6aa7c59153499f8c21f31ede2d928d8e0f9d23a.png',
    '#',
    NULL,
    NULL,
    6,
    1
);

-- Vérification
SELECT id, title, image_url, display_order
FROM content_items
WHERE content_type = 'realisation_dgda'
ORDER BY display_order;
