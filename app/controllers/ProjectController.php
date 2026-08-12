<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $projectModel;

    public function __construct() {
        $this->projectModel = new Project();
    }

    public function index() {
        $projects = $this->projectModel->getAllProjects();
        require_once __DIR__ . '/../views/activite_new.php';
    }

    public function show($id) {
        $project = $this->projectModel->getProjectById($id);
        if (!$project) {
            http_response_code(404);
            echo "Activité introuvable";
            return;
        }
        require_once __DIR__ . '/../views/activite_detail.php';
    }

    public function filter() {
        $status = $_GET['status'] ?? null;
        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;

        $projects = $this->projectModel->getAllProjects();

        // Filter by status
        if ($status) {
            $projects = array_filter($projects, function($p) use ($status) {
                return $p['status'] === $status;
            });
        }

        // Filter by category
        if ($category) {
            $projects = array_filter($projects, function($p) use ($category) {
                return $p['category'] === $category;
            });
        }

        // Filter by search
        if ($search) {
            $projects = array_filter($projects, function($p) use ($search) {
                return stripos($p['title'], $search) !== false || stripos($p['description'], $search) !== false;
            });
        }

        $projects = array_values($projects);
        require_once __DIR__ . '/../views/activite_new.php';
    }
}
?>