<?php
require_once __DIR__ . '/../app/models/ContentItem.php';

header('Content-Type: application/json; charset=utf-8');

$type = $_GET['type'] ?? '';

$allowedTypes = ['article', 'document', 'realisation', 'realisation_dgda', 'realisation_dgrad', 'realisation_autre'];
if (!in_array($type, $allowedTypes, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid content type']);
    exit;
}

$limit = isset($_GET['limit']) ? max(1, (int) $_GET['limit']) : null;

$model = new ContentItem();
$items = $model->getAllByType($type);

if ($limit !== null) {
    $items = array_slice($items, 0, $limit);
}

echo json_encode([
    'type' => $type,
    'items' => $items
], JSON_UNESCAPED_UNICODE);
?>
