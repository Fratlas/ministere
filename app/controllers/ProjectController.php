<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private const PER_PAGE = 2;

    private $projectModel;

    public function __construct() {
        $this->projectModel = new Project();
    }

    public function index() {
        $this->renderListing($this->projectModel->getAllProjects(), false);
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

        if ($status) {
            $projects = array_values(array_filter($projects, function ($p) use ($status) {
                return $p['status'] === $status;
            }));
        }

        if ($category) {
            $projects = array_values(array_filter($projects, function ($p) use ($category) {
                return $p['category'] === $category;
            }));
        }

        if ($search) {
            $search = trim((string) $search);
            $projects = array_values(array_filter($projects, function ($p) use ($search) {
                return stripos($p['title'], $search) !== false
                    || stripos($p['description'], $search) !== false;
            }));
        }

        $this->renderListing($projects, true);
    }

    private function renderListing(array $projects, bool $isFilter): void {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $totalItems = count($projects);
        $totalPages = max(1, (int) ceil($totalItems / self::PER_PAGE));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * self::PER_PAGE;

        $projectsPage = array_slice($projects, $offset, self::PER_PAGE);

        $queryParams = array_filter([
            'search' => isset($_GET['search']) ? trim((string) $_GET['search']) : null,
            'category' => $_GET['category'] ?? null,
            'status' => $_GET['status'] ?? null,
        ], function ($value) {
            return $value !== null && $value !== '';
        });

        $paginationBase = $isFilter ? '/projects/filter' : '/projects';
        $paginationUrl = function (int $targetPage) use ($paginationBase, $queryParams): string {
            $params = $queryParams;
            if ($targetPage > 1) {
                $params['page'] = $targetPage;
            }
            $query = http_build_query($params);

            return $query === '' ? $paginationBase : $paginationBase . '?' . $query;
        };

        require_once __DIR__ . '/../views/activite_new.php';
    }
}
?>