<?php
// Configuration MySQL pour l'environnement en ligne
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $host = '127.0.0.1';
            $port = '3306';
            $db = 'u223322817_mini';
            $user = 'u223322817_mini';
            $pass = 'Fratlas@1997';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->createTables();
        } catch (PDOException $e) {
            throw new RuntimeException("Erreur MySQL: " . $e->getMessage(), 0, $e);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    private function createTables() {
        $sql = "
        CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category VARCHAR(100) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            status VARCHAR(50) NOT NULL,
            image_url VARCHAR(500),
            update_date VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS content_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content_type VARCHAR(30) NOT NULL,
            section_key VARCHAR(120) DEFAULT NULL,
            badge_text VARCHAR(120) DEFAULT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            image_url VARCHAR(500) DEFAULT NULL,
            link_url VARCHAR(500) DEFAULT NULL,
            meta_text VARCHAR(120) DEFAULT NULL,
            icon_class VARCHAR(50) DEFAULT NULL,
            file_url VARCHAR(500) DEFAULT NULL,
            display_order INT NOT NULL DEFAULT 0,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $this->pdo->exec($sql);

        $stmt = $this->pdo->query("SELECT COUNT(*) FROM admin_users");
        if ($stmt->fetchColumn() == 0) {
            $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
            $this->pdo->exec("INSERT INTO admin_users (username, password, email) VALUES ('admin', '$adminPassword', 'admin@ministere.cd')");
        }

        $stmt = $this->pdo->query("SELECT COUNT(*) FROM projects");
        if ($stmt->fetchColumn() == 0) {
            $this->insertSampleData();
        }

        $stmt = $this->pdo->query("SELECT COUNT(*) FROM content_items");
        if ($stmt->fetchColumn() == 0) {
            $this->insertSampleContent();
        }
    }

    private function insertSampleData() {
        $projects = [
            ['Numérisation', 'Plateforme Intégrée LOGIRAD', 'Optimisation des recettes administratives, judiciaires, domaniales et de participations à travers une interface sécurisée.', 'En cours', 'public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png', '12 MARS 2024'],
            ['Fiscalité', 'Déploiement ISYS-REGIES', 'Système informatique de gestion des recettes budgétaires pour une transparence accrue des flux financiers.', 'Terminé', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '05 JAN 2024'],
            ['Infrastructure', 'Interconnexion des Régies Financières', 'Mise en place d\'un réseau fibre optique haute performance reliant les directions provinciales à Kinshasa.', 'Planifié', 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', 'JUIN 2024'],
            ['Ressources Humaines', 'Programme "21000 Experts"', 'Formation massive des agents et cadres des régies financières sur les nouveaux outils de gestion numérique.', 'En cours', 'public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', 'PHASE 2 SUR 4'],
            ['Législation', 'Nouveau Code des Accises', 'Révision du cadre législatif pour l\'adapter aux standards internationaux et lutter contre la fraude.', 'En cours', 'public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg', 'EN DISCUSSION'],
            ['Transparence', 'Portail Open Budget', 'Accès public aux données budgétaires en temps réel pour renforcer la redevabilité de l\'État.', 'Terminé', 'public/images/d6aa7c59153499f8c21f31ede2d928d8e0f9d23a.png', 'NOV 2023']
        ];

        $stmt = $this->pdo->prepare("INSERT INTO projects (category, title, description, status, image_url, update_date) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($projects as $project) {
            $stmt->execute($project);
        }
    }

    private function insertSampleContent() {
        $contentItems = [
            ['article', 'Actualite', '12 MARS 2024', 'Modernisation de la chaine de recette', 'Le ministere accelere la modernisation des procedures de collecte et de suivi des recettes publiques.', 'public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg', '#', null, null, 1],
            ['article', 'Communique', '08 MARS 2024', 'Reunion de pilotage sur les reformes', 'Les equipes techniques ont fait le point sur les chantiers de digitalisation et de gouvernance financiere.', 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', '#', null, null, 2],
            ['article', 'Budget', '28 FEV 2024', 'Point sur la loi de finances', 'Presentation des priorites budgetaires et des prochaines etapes de mise en oeuvre.', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '#', null, null, 3],
            ['article', 'Innovation', '15 FEV 2024', 'Nouveaux outils de transparence', 'Le portail public des donnees financieres s enrichit de nouvelles fonctionnalites de consultation.', 'public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', '#', null, null, 4],
            ['document', 'Textes réglementaires', 'Loi de finances', 'Projet de loi de finances pour l exercice 2025', 'Presentation detaillee du budget de l Etat pour l annee civile 2025, incluant les previsions de recettes et depenses.', null, '#', '4.2 MB', 'pdf', 1],
            ['document', 'Autres ressources', 'Rapport annuel', 'Rapport d activite annuel 2023 - Ministere des Finances', 'Bilan exhaustif des reformes engagees et des resultats macroeconomiques de la RDC durant l annee ecoulee.', null, '#', '12.8 MB', 'pdf', 2],
            ['document', 'Autres ressources', 'Statistiques', 'Bulletin trimestriel de la dette publique - Q1 2024', 'Analyse de l evolution de la dette publique interieure et exterieure de la Republique Democratique du Congo.', null, '#', '1.5 MB', 'pdf', 3],
            ['document', 'Textes réglementaires', 'Arrete ministeriel', 'Arrete portant nomination des membres de la commission budgetaire', 'Decret officiel fixant la composition et les attributions de la commission technique de preparation budgetaire.', null, '#', '0.8 MB', 'pdf', 4],
            ['realisation', 'DGI', '2015 - 2018', '2015 - 2018', 'Montage strategique des projets et deploiement des reseaux d interconnexion pour la modernisation de l²a DGI.', 'public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png', '#', null, null, 1],
            ['realisation', 'DGDA', '2018 - 2024', '2018 - 2024', 'Mise en service des ERP et des entrepots de donnees pour renforcer la traabilite des recettes publiques.', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '#', null, null, 2],
            ['realisation', 'Plateforme citoyenne', '2020 - 2024', '2020 - 2024', 'Deploiement d une interface pour simplifier les declarations et paiements des contribuables.', 'public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg', '#', null, null, 3],
            ['realisation_dgda', 'DGDA', '2018 - 2024', 'Appui a la Direction Generale des Douanes et Accises', 'Renforcement des outils de suivi et de tracabilite des recettes douanieres.', 'public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg', '#', null, null, 1],
            ['realisation_dgrad', 'DGRAD', '2020 - 2024', 'Appui a la Direction Generale des Recettes Administratives', 'Modernisation du recouvrement des recettes administratives, domaniales et de participations.', 'public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg', '#', null, null, 1]
        ];

        $stmt = $this->pdo->prepare("
            INSERT INTO content_items
            (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, display_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($contentItems as $item) {
            $stmt->execute($item);
        }
    }
}
?>
