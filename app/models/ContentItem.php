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
                'section_key' => 'DGI',
                'badge_text' => '2015 - 2018',
                'title' => 'Realisations a la Direction Generale des Impots',
                'description' => 'Montage strategique des projets et deploiement des reseaux d interconnexion.',
                'image_url' => '/public/images/0a0ab46ab0741BSN7gxmPWYCAKJgA9aH4yNuERpTvs4uiX.png',
                'link_url' => '#',
                'meta_text' => null,
                'icon_class' => null,
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
            ],
            [
                'id' => 301,
                'content_type' => 'document',
                'section_key' => 'Rapport annuel',
                'badge_text' => 'Rapport',
                'title' => 'Rapport d activite annuel 2023',
                'description' => 'Analyse des recettes, des depenses et des principales reformes menees durant l exercice 2023.',
                'image_url' => null,
                'link_url' => '#',
                'meta_text' => '12.8 MB',
                'icon_class' => 'pdf',
                'file_url' => null,
                'display_order' => 1,
                'is_active' => 1,
            ],
        ];
    }
}
?>
