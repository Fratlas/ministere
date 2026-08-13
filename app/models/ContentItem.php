<?php
require_once __DIR__ . '/../../config/database.php';

class ContentItem {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Throwable $e) {
            $this->db = null;
        }
    }

    public function getAllByType($contentType, $activeOnly = true) {
        if (!$this->db) {
            return $this->fallbackByType($contentType, $activeOnly);
        }

        try {
            $activeClause = $activeOnly ? " AND is_active = 1" : "";
            $stmt = $this->db->prepare("
                SELECT * FROM content_items
                WHERE content_type = ?" . $activeClause . "
                ORDER BY display_order ASC, created_at DESC
            ");
            $stmt->execute([$contentType]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return $this->fallbackByType($contentType, $activeOnly);
        }
    }

    public function getById($id) {
        if (!$this->db) {
            foreach ($this->fallbackItems() as $item) {
                if ((int) $item['id'] === (int) $id) {
                    return $item;
                }
            }

            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM content_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        if (!$this->db) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO content_items
            (content_type, section_key, badge_text, title, description, image_url, link_url, meta_text, icon_class, file_url, display_order, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['content_type'],
            $data['section_key'] ?? null,
            $data['badge_text'] ?? null,
            $data['title'],
            $data['description'],
            $data['image_url'] ?? null,
            $data['link_url'] ?? null,
            $data['meta_text'] ?? null,
            $data['icon_class'] ?? null,
            $data['file_url'] ?? null,
            $data['display_order'] ?? 0,
            $data['is_active'] ?? 1
        ]);
    }

    public function update($id, $data) {
        if (!$this->db) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE content_items
            SET section_key = ?, badge_text = ?, title = ?, description = ?, image_url = ?, link_url = ?, meta_text = ?, icon_class = ?, file_url = ?, display_order = ?, is_active = ?
            WHERE id = ? AND content_type = ?
        ");

        return $stmt->execute([
            $data['section_key'] ?? null,
            $data['badge_text'] ?? null,
            $data['title'],
            $data['description'],
            $data['image_url'] ?? null,
            $data['link_url'] ?? null,
            $data['meta_text'] ?? null,
            $data['icon_class'] ?? null,
            $data['file_url'] ?? null,
            $data['display_order'] ?? 0,
            $data['is_active'] ?? 1,
            $id,
            $data['content_type']
        ]);
    }

    public function delete($id, $contentType = null) {
        if (!$this->db) {
            return false;
        }

        if ($contentType !== null) {
            $stmt = $this->db->prepare("DELETE FROM content_items WHERE id = ? AND content_type = ?");
            return $stmt->execute([$id, $contentType]);
        }

        $stmt = $this->db->prepare("DELETE FROM content_items WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function fallbackByType($contentType, $activeOnly = true) {
        return array_values(array_filter($this->fallbackItems(), function ($item) use ($contentType, $activeOnly) {
            if ($item['content_type'] !== $contentType) {
                return false;
            }

            return !$activeOnly || (int) ($item['is_active'] ?? 1) === 1;
        }));
    }

    private function fallbackItems() {
        return [
            [
                'id' => 101,
                'content_type' => 'article',
                'section_key' => 'Actualite',
                'badge_text' => '12 MARS 2024',
                'title' => 'Modernisation de la chaine de recette',
                'description' => 'Le ministere accelere la modernisation des procedures de collecte et de suivi des recettes publiques.',
                'image_url' => '/public/images/9fe3b95f3d4bbd9a00803da129b576653e10be87.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 201,
                'content_type' => 'realisation',
                'section_key' => 'Phase 1',
                'badge_text' => '2015 – 2018',
                'title' => 'Élaboration diagnostique et montage',
                'description' => 'Réalisation du diagnostic de l\'existant, montage des projets et déploiement des réseaux d\'interconnexion entre les régies financières.',
                'image_url' => '/public/images/0a0ab46ab0741BSN7gxmPWYCAKJgA9aH4yNuERpTvs4uiX.png',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 202,
                'content_type' => 'realisation',
                'section_key' => 'Phase 2',
                'badge_text' => '2018 – 2024',
                'title' => 'Plateformes ISYS-REGIES, LOGIRAD, ERP',
                'description' => 'Lancement et déploiement des plateformes ISYS-REGIES, LOGIRAD, du Progiciel de Gestion Intégrée (ERP) à la DGI et de l\'Entrepôt des données financières de l\'État.',
                'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 2,
                'is_active' => 1,
            ],
            [
                'id' => 203,
                'content_type' => 'realisation',
                'section_key' => 'Phase 3',
                'badge_text' => '2018 – 2024',
                'title' => 'Plateforme citoyenne',
                'description' => 'Mise en œuvre et déploiement de la plateforme citoyenne de téléservices sur l\'étendue de la République pour améliorer l\'accès aux services publics.',
                'image_url' => '/public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 3,
                'is_active' => 1,
            ],
            [
                'id' => 401,
                'content_type' => 'realisation_dgda',
                'section_key' => 'DGDA',
                'badge_text' => '2018 - 2024',
                'title' => 'Fiabilisation du repertoire des assujettis',
                'description' => 'Mise a jour et validation des donnees des contribuables pour une meilleure tracabilite.',
                'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 402,
                'content_type' => 'realisation_dgda',
                'section_key' => 'DGDA',
                'badge_text' => '2018 - 2024',
                'title' => 'Extension du repertoire des assujettis',
                'description' => 'Ajout de nouveaux contribuables identifies sur le territoire national.',
                'image_url' => '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 2,
                'is_active' => 1,
            ],
            [
                'id' => 501,
                'content_type' => 'realisation_dgrad',
                'section_key' => 'DGRAD',
                'badge_text' => '2020 - 2024',
                'title' => 'Modernisation du systeme de recouvrement',
                'description' => 'Digitalisation des services administratifs et domaniaux de la DGRAD.',
                'image_url' => '/public/images/f5e8488f8c3a13bf3dab164a3be46274ca0f4ef6.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 502,
                'content_type' => 'realisation_dgrad',
                'section_key' => 'DGRAD',
                'badge_text' => '2020 - 2024',
                'title' => 'Formation des agents DGRAD',
                'description' => 'Renforcement des capacites sur les nouveaux outils de gestion numerique.',
                'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 2,
                'is_active' => 1,
            ],
            [
                'id' => 301,
                'content_type' => 'document',
                'section_key' => "Rapports d'Activités",
                'badge_text' => '2026',
                'title' => 'Rapport d activite annuel 2026',
                'description' => 'Bilan des reformes et des resultats macroeconomiques de l exercice en cours.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '8.4 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
                'created_at' => '2026-01-15 09:00:00',
                'updated_at' => '2026-01-15 09:00:00',
            ],
            [
                'id' => 302,
                'content_type' => 'document',
                'section_key' => "Rapports d'Activités",
                'badge_text' => '2024',
                'title' => 'Rapport d activite annuel 2024',
                'description' => 'Synthese des actions menees et des indicateurs de performance du ministere.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '10.2 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 2,
                'is_active' => 1,
                'created_at' => '2024-06-12 09:00:00',
                'updated_at' => '2024-06-12 09:00:00',
            ],
            [
                'id' => 303,
                'content_type' => 'document',
                'section_key' => "Rapports d'Activités",
                'badge_text' => '2020',
                'title' => 'Rapport d activite annuel 2020',
                'description' => 'Archives des activites et realisations de la periode 2020.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '6.1 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 3,
                'is_active' => 1,
                'created_at' => '2020-03-10 09:00:00',
                'updated_at' => '2020-03-10 09:00:00',
            ],
            [
                'id' => 304,
                'content_type' => 'document',
                'section_key' => 'Textes Réglementaires',
                'badge_text' => 'Décrets',
                'title' => 'Decret portant organisation du ministere',
                'description' => 'Texte reglementaire fixant l organisation administrative du ministere des Finances.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '1.2 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 4,
                'is_active' => 1,
                'created_at' => '2024-10-24 09:00:00',
                'updated_at' => '2024-10-24 09:00:00',
            ],
            [
                'id' => 305,
                'content_type' => 'document',
                'section_key' => 'Textes Réglementaires',
                'badge_text' => 'Arrêté ministériel',
                'title' => 'Arrete portant nomination des membres de la commission budgetaire',
                'description' => 'Arrete fixant la composition et les attributions de la commission technique budgetaire.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '0.8 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 5,
                'is_active' => 1,
                'created_at' => '2024-03-18 09:00:00',
                'updated_at' => '2024-03-18 09:00:00',
            ],
            [
                'id' => 306,
                'content_type' => 'document',
                'section_key' => 'Textes Réglementaires',
                'badge_text' => 'Circulaires',
                'title' => 'Circulaire relative aux procedures de recouvrement',
                'description' => 'Directives applicables aux services de recouvrement des recettes publiques.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '0.6 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 6,
                'is_active' => 1,
                'created_at' => '2024-02-08 09:00:00',
                'updated_at' => '2024-02-08 09:00:00',
            ],
            [
                'id' => 307,
                'content_type' => 'document',
                'section_key' => 'Autres ressources',
                'badge_text' => 'Guides utilisateurs',
                'title' => 'Guide utilisateur de la plateforme citoyenne',
                'description' => 'Manuel pas a pas pour les usagers des services numeriques du ministere.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '2.4 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 7,
                'is_active' => 1,
                'created_at' => '2024-05-05 09:00:00',
                'updated_at' => '2024-05-05 09:00:00',
            ],
            [
                'id' => 308,
                'content_type' => 'document',
                'section_key' => 'Autres ressources',
                'badge_text' => 'Tutoriels',
                'title' => 'Tutoriel video de declaration en ligne',
                'description' => 'Support de formation pour la declaration et le paiement des taxes en ligne.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '15.0 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 8,
                'is_active' => 1,
                'created_at' => '2024-04-12 09:00:00',
                'updated_at' => '2024-04-12 09:00:00',
            ],
        ];
    }
}
?>
