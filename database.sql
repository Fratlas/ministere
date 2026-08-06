-- =====================================================
-- BASE DE DONNÉES - Ministère des Finances
-- =====================================================
-- Structure SQL complète et données d'initialisation
-- Système de gestion des projets et contenus
-- =====================================================

-- Utiliser la base de données
USE u223322817_mini;

-- =====================================================
-- TABLE: projects
-- Description: Stockage des projets et réalisations
-- =====================================================
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL COMMENT 'Catégorie du projet (Numérisation, Fiscalité, etc.)',
    title VARCHAR(255) NOT NULL COMMENT 'Titre du projet',
    description TEXT NOT NULL COMMENT 'Description détaillée du projet',
    status VARCHAR(50) NOT NULL COMMENT 'Statut: En cours, Terminé, Planifié',
    image_url VARCHAR(500) COMMENT 'URL de l\'image du projet',
    update_date VARCHAR(100) COMMENT 'Date de mise à jour',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
    INDEX idx_category (category),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des projets';

-- =====================================================
-- TABLE: admin_users
-- Description: Utilisateurs administrateurs
-- =====================================================
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL COMMENT 'Nom d\'utilisateur (unique)',
    password VARCHAR(255) NOT NULL COMMENT 'Mot de passe hashé (Bcrypt)',
    email VARCHAR(100) COMMENT 'Email de l\'administrateur',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création du compte',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Dernière modification',
    is_active TINYINT(1) DEFAULT 1 COMMENT 'Compte actif ou non',
    last_login TIMESTAMP NULL COMMENT 'Dernière connexion',
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des administrateurs';

-- =====================================================
-- TABLE: content_items
-- Description: Contenus dynamiques (articles, documents, réalisations)
-- =====================================================
CREATE TABLE IF NOT EXISTS content_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_type VARCHAR(30) NOT NULL COMMENT 'Type: article, document, realisation',
    section_key VARCHAR(120) COMMENT 'Clé de section (Actualite, Communique, etc.)',
    badge_text VARCHAR(120) COMMENT 'Texte du badge (ex: 12 MARS 2024)',
    title VARCHAR(255) NOT NULL COMMENT 'Titre du contenu',
    description TEXT NOT NULL COMMENT 'Description du contenu',
    image_url VARCHAR(500) COMMENT 'URL de l\'image associée',
    link_url VARCHAR(500) COMMENT 'URL de lien externe',
    meta_text VARCHAR(120) COMMENT 'Texte de métadonnée (ex: taille de fichier)',
    icon_class VARCHAR(50) COMMENT 'Classe CSS pour l\'icône',
    display_order INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    is_active TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Contenu actif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Dernière modification',
    INDEX idx_content_type (content_type),
    INDEX idx_is_active (is_active),
    INDEX idx_display_order (display_order),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des contenus dynamiques';

-- =====================================================
-- DONNÉES INITIALES
-- =====================================================

-- =====================================================
-- Insertion: Administrateur par défaut
-- Username: admin
-- Password: admin123
-- =====================================================
INSERT INTO admin_users (username, password, email, is_active) VALUES 
('admin', '$2y$10$8HxPDnVV/SNVQ3jL8H.pTuKPY7L7Q0z0Jq5K9L1M0Z2A8B7C6D5E4', 'admin@ministere.cd', 1);

-- =====================================================
-- Insertion: Projets d'exemple
-- =====================================================
INSERT INTO projects (category, title, description, status, image_url, update_date) VALUES 
('Numérisation', 'Plateforme Intégrée LOGIRAD', 'Optimisation des recettes administratives, judiciaires, domaniales et de participations à travers une interface sécurisée.', 'En cours', 'public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png', '12 MARS 2024'),

('Fiscalité', 'Déploiement ISYS-REGIES', 'Système informatique de gestion des recettes budgétaires pour une transparence accrue des flux financiers.', 'Terminé', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '05 JAN 2024'),

('Infrastructure', 'Interconnexion des Régies Financières', 'Mise en place d\'un réseau fibre optique haute performance reliant les directions provinciales à Kinshasa.', 'Planifié', 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', 'JUIN 2024'),

('Ressources Humaines', 'Programme "21000 Experts"', 'Formation massive des agents et cadres des régies financières sur les nouveaux outils de gestion numérique.', 'En cours', 'public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', 'PHASE 2 SUR 4'),

('Législation', 'Nouveau Code des Accises', 'Révision du cadre législatif pour l\'adapter aux standards internationaux et lutter contre la fraude.', 'En cours', 'public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg', 'EN DISCUSSION'),

('Transparence', 'Portail Open Budget', 'Accès public aux données budgétaires en temps réel pour renforcer la redevabilité de l\'État.', 'Terminé', 'public/images/d6aa7c59153499f8c21f31ede2d928d8e0f9d23a.png', 'NOV 2023');

-- =====================================================
-- Insertion: Contenus dynamiques (Articles, Documents, Réalisations)
-- =====================================================

-- Actualités
INSERT INTO content_items (content_type, section_key, badge_text, title, description, image_url, link_url, icon_class, display_order, is_active) VALUES 
('article', 'Actualite', '12 MARS 2024', 'Modernisation de la chaîne de recette', 'Le ministère accélère la modernisation des procédures de collecte et de suivi des recettes publiques.', 'public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg', '#', 'fas fa-newspaper', 1, 1),

('article', 'Communique', '08 MARS 2024', 'Réunion de pilotage sur les réformes', 'Les équipes techniques ont fait le point sur les chantiers de digitalisation et de gouvernance financière.', 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', '#', 'fas fa-bullhorn', 2, 1),

('article', 'Budget', '28 FEV 2024', 'Point sur la loi de finances', 'Présentation des priorités budgétaires et des prochaines étapes de mise en œuvre.', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '#', 'fas fa-file-alt', 3, 1),

('article', 'Innovation', '15 FEV 2024', 'Nouveaux outils de transparence', 'Le portail public des données financières s\'enrichit de nouvelles fonctionnalités de consultation.', 'public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', '#', 'fas fa-lightbulb', 4, 1);

-- Documents
INSERT INTO content_items (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, display_order, is_active, created_at) VALUES 
('document', 'Textes réglementaires', 'Loi de finances', 'Projet de loi de finances pour l\'exercice 2025', 'Présentation détaillée du budget de l\'État pour l\'année civile 2025, incluant les prévisions de recettes et dépenses.', NULL, '#', '4.2 MB', 'pdf', 1, 1, '2024-10-24 09:00:00'),

('document', 'Autres ressources', 'Rapport annuel', 'Rapport d\'activité annuel 2023 - Ministère des Finances', 'Bilan exhaustif des réformes engagées et des résultats macroéconomiques de la RDC durant l\'année écoulée.', NULL, '#', '12.8 MB', 'pdf', 2, 1, '2024-06-12 09:00:00'),

('document', 'Autres ressources', 'Statistiques', 'Bulletin trimestriel de la dette publique - Q1 2024', 'Analyse de l\'évolution de la dette publique intérieure et extérieure de la République Démocratique du Congo.', NULL, '#', '1.5 MB', 'pdf', 3, 1, '2024-05-05 09:00:00'),

('document', 'Textes réglementaires', 'Arrêté ministériel', 'Arrêté portant nomination des membres de la commission budgétaire', 'Décret officiel fixant la composition et les attributions de la commission technique de préparation budgétaire.', NULL, '#', '0.8 MB', 'pdf', 4, 1, '2024-03-18 09:00:00');

-- Réalisations
INSERT INTO content_items (content_type, section_key, badge_text, title, description, image_url, link_url, icon_class, display_order, is_active) VALUES 
('realisation', 'DGI', '2015 - 2018', 'Système Informatique DGI (Phase I)', 'Montage stratégique des projets et déploiement des réseaux d\'interconnexion pour la modernisation de la DGI.', 'public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png', '#', 'fas fa-project-diagram', 1, 1),

('realisation', 'DGDA', '2018 - 2024', 'Système Informatique DGDA', 'Mise en service des ERP et des entrepôts de données pour renforcer la traçabilité des recettes publiques.', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '#', 'fas fa-database', 2, 1),

('realisation', 'Plateforme citoyenne', '2020 - 2024', 'Plateforme Numérique Citoyenne', 'Déploiement d\'une interface pour simplifier les déclarations et paiements des contribuables.', 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', '#', 'fas fa-users', 3, 1);

-- Réalisations DGDA
INSERT INTO content_items (content_type, section_key, badge_text, title, description, image_url, link_url, icon_class, display_order, is_active) VALUES
('realisation_dgda', 'DGDA', '2018 - 2024', 'Appui à la Direction Générale des Douanes et Accises', 'Renforcement des outils de suivi et de traçabilité des recettes douanières.', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '#', 'fas fa-database', 1, 1);

-- Réalisations DGRAD
INSERT INTO content_items (content_type, section_key, badge_text, title, description, image_url, link_url, icon_class, display_order, is_active) VALUES
('realisation_dgrad', 'DGRAD', '2020 - 2024', 'Appui à la Direction Générale des Recettes Administratives', 'Modernisation du recouvrement des recettes administratives, domaniales et de participations.', 'public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', '#', 'fas fa-bank', 1, 1);

-- =====================================================
-- FIN DE LA STRUCTURE
-- =====================================================

-- Verificazioni e statistiques
SELECT COUNT(*) as total_projects FROM projects;
SELECT COUNT(*) as total_admins FROM admin_users;
SELECT COUNT(*) as total_content_items FROM content_items;
SELECT content_type, COUNT(*) as count FROM content_items GROUP BY content_type;

-- =====================================================
-- NOTES D'INSTALLATION
-- =====================================================
-- 1. Créer la base de données "u223322817_mini" si elle n'existe pas
-- 2. Exécuter ce fichier SQL
-- 3. Vérifier que les tables ont été créées avec succès
-- 4. L'administrateur par défaut a pour identifiants:
--    - Username: admin
--    - Password: admin123
-- 5. Les données d'exemple sont automatiquement insérées
-- =====================================================
