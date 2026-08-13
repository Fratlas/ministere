-- =====================================================
-- Seeder : Timeline accueil (3 réalisations)
-- Usage  : exécuter dans phpMyAdmin / MySQL
-- =====================================================

USE u223322817_mini;

DELETE FROM content_items WHERE content_type = 'realisation';

INSERT INTO content_items
    (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, display_order, is_active)
VALUES
(
    'realisation',
    'Phase 1',
    '2015 – 2018',
    'Élaboration diagnostique et montage',
    'Réalisation du diagnostic de l''existant, montage des projets et déploiement des réseaux d''interconnexion entre les régies financières.',
    '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
    '#',
    NULL,
    NULL,
    1,
    1
),
(
    'realisation',
    'Phase 2',
    '2018 – 2024',
    'Plateformes ISYS-REGIES, LOGIRAD, ERP',
    'Lancement et déploiement des plateformes ISYS-REGIES, LOGIRAD, du Progiciel de Gestion Intégrée (ERP) à la DGI et de l''Entrepôt des données financières de l''État.',
    '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
    '#',
    NULL,
    NULL,
    2,
    1
),
(
    'realisation',
    'Phase 3',
    '2018 – 2024',
    'Plateforme citoyenne',
    'Mise en œuvre et déploiement de la plateforme citoyenne de téléservices sur l''étendue de la République pour améliorer l''accès aux services publics.',
    '/public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg',
    '#',
    NULL,
    NULL,
    3,
    1
);

-- Corriger une eventuelle image deja en base avec un ancien nom de fichier invalide
UPDATE content_items
SET image_url = '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png'
WHERE image_url LIKE '%0a0ab46ab0741BSN7gxmPWYCAKJgA9aH4yNuERpTvs4uiX.png%';

SELECT id, badge_text, title, display_order
FROM content_items
WHERE content_type = 'realisation'
ORDER BY display_order;
