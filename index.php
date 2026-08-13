<?php
// Simple MVC Router

require_once __DIR__ . '/config/database.php';

function serveStaticPage($file) {
    $path = __DIR__ . '/' . $file;
    if (is_file($path)) {
        readfile($path);
        exit;
    }

    http_response_code(404);
    echo "Page not found";
    exit;
}

function loadPageController() {
    $controllerPath = __DIR__ . '/app/controllers/PageController.php';
    if (is_file($controllerPath)) {
        require_once $controllerPath;
        return true;
    }

    return false;
}

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? $_SERVER['REQUEST_URI'];
$basePath = '/'; // Adjust if needed

// Remove base path
if (strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
}

$request = trim($request, '/');
$parts = explode('/', $request);

$controller = $parts[0] ?? 'project';
$action = $parts[1] ?? 'index';
$id = $parts[2] ?? null;

if ($request === '' || $request === 'index.php' || $request === 'index.html') {
    $controller = '';
    $action = 'index';
}

switch ($controller) {
    case '':
        require_once __DIR__ . '/app/controllers/PageController.php';
        $controllerObj = new PageController();
        $controllerObj->index();
        break;
    case 'projects':
        $redirectPath = '/activites';
        if ($action === 'filter') {
            $redirectPath .= '/filter';
        } elseif (is_numeric($action)) {
            $redirectPath .= '/' . $action;
        }
        $queryString = $_SERVER['QUERY_STRING'] ?? '';
        if ($queryString !== '') {
            $redirectPath .= '?' . $queryString;
        }
        header('Location: ' . $redirectPath, true, 301);
        exit;
    case 'activites':
        require_once __DIR__ . '/app/controllers/ProjectController.php';
        $controllerObj = new ProjectController();
        if ($action === 'filter') {
            $controllerObj->filter();
        } elseif (is_numeric($action)) {
            $controllerObj->show($action);
        } else {
            $controllerObj->index();
        }
        break;
    case 'activite':
        require_once __DIR__ . '/app/controllers/ProjectController.php';
        $controllerObj = new ProjectController();
        if ($action === 'filter') {
            $controllerObj->filter();
        } elseif (is_numeric($action)) {
            $controllerObj->show($action);
        } else {
            $controllerObj->index();
        }
        break;
    case 'admin':
        // Admin routes
        require_once __DIR__ . '/admin/index.php';
        break;
    case 'about':
        if (loadPageController()) {
            $controllerObj = new PageController();
            $controllerObj->about();
        } else {
            serveStaticPage('about.html');
        }
        break;
    case 'realisations':
        if (loadPageController()) {
            $controllerObj = new PageController();
            $controllerObj->realisations();
        } else {
            serveStaticPage('realisations.html');
        }
        break;
    case 'realisations-dgda':
        if (loadPageController()) {
            $controllerObj = new PageController();
            $controllerObj->realisations_dgda();
        } else {
            http_response_code(404);
            echo "Page not found";
        }
        break;
    case 'realisations-dgrad':
        if (loadPageController()) {
            $controllerObj = new PageController();
            $controllerObj->realisations_dgrad();
        } else {
            require_once __DIR__ . '/realisations-dgrad.php';
        }
        break;
    case 'documents':
        if (loadPageController()) {
            $controllerObj = new PageController();
            $controllerObj->documents();
        } else {
            serveStaticPage('documents.html');
        }
        break;
    case 'contact':
        require_once __DIR__ . '/app/controllers/PageController.php';
        $controllerObj = new PageController();
        $controllerObj->contact();
        break;
    default:
        http_response_code(404);
        echo "Page not found";
        break;
}
?>
