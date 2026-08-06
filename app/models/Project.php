<?php
require_once __DIR__ . '/../../config/database.php';

class Project {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Throwable $e) {
            $this->db = null;
        }
    }

    public function getAllProjects() {
        if (!$this->db) {
            return $this->fallbackProjects();
        }

        try {
            $stmt = $this->db->query("SELECT * FROM projects ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return $this->fallbackProjects();
        }
    }

    public function getProjectById($id) {
        if (!$this->db) {
            foreach ($this->fallbackProjects() as $project) {
                if ((int) $project['id'] === (int) $id) {
                    return $project;
                }
            }

            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProject($data) {
        if (!$this->db) {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO projects (category, title, description, status, image_url, update_date) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['category'], $data['title'], $data['description'], $data['status'], $data['image_url'], $data['update_date']]);
    }

    public function updateProject($id, $data) {
        if (!$this->db) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE projects SET category = ?, title = ?, description = ?, status = ?, image_url = ?, update_date = ? WHERE id = ?");
        return $stmt->execute([$data['category'], $data['title'], $data['description'], $data['status'], $data['image_url'], $data['update_date'], $id]);
    }

    public function deleteProject($id) {
        if (!$this->db) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM projects WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getProjectsByStatus($status) {
        if (!$this->db) {
            return array_values(array_filter($this->fallbackProjects(), function ($project) use ($status) {
                return $project['status'] === $status;
            }));
        }

        $stmt = $this->db->prepare("SELECT * FROM projects WHERE status = ? ORDER BY created_at DESC");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectsByCategory($category) {
        if (!$this->db) {
            return array_values(array_filter($this->fallbackProjects(), function ($project) use ($category) {
                return $project['category'] === $category;
            }));
        }

        $stmt = $this->db->prepare("SELECT * FROM projects WHERE category = ? ORDER BY created_at DESC");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function fallbackProjects() {
        return [
            [
                'id' => 1,
                'category' => 'Numerisation',
                'title' => 'Plateforme Integree LOGIRAD',
                'description' => 'Optimisation des recettes administratives, judiciaires, domaniales et de participations a travers une interface securisee.',
                'status' => 'En cours',
                'image_url' => '/public/images/0a0ab46ab0741a4e546c25da9cf4ee67782151e3.png',
                'update_date' => '12 MARS 2024',
                'created_at' => '2024-03-12 00:00:00',
            ],
            [
                'id' => 2,
                'category' => 'Fiscalite',
                'title' => 'Deploiement ISYS-REGIES',
                'description' => 'Systeme informatique de gestion des recettes budgetaires pour une transparence accrue des flux financiers.',
                'status' => 'Termine',
                'image_url' => '/public/images/c9e30edbc22dfe5104a5bb070369bd34457a9fb6.jpg',
                'update_date' => '05 JAN 2024',
                'created_at' => '2024-01-05 00:00:00',
            ],
            [
                'id' => 3,
                'category' => 'Infrastructure',
                'title' => 'Interconnexion des Regies Financieres',
                'description' => 'Mise en place d un reseau fibre optique haute performance reliant les directions provinciales a Kinshasa.',
                'status' => 'Planifie',
                'image_url' => '/public/images/a262919e89729dbd75cfdb9e248fa2d40e2ca169.jpg',
                'update_date' => 'JUIN 2024',
                'created_at' => '2024-06-01 00:00:00',
            ],
        ];
    }
}
?>
