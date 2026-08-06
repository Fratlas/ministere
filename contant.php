<?php
require_once __DIR__ . '/app/models/ContentItem.php';

// Charger les réalisations depuis la base de données
$contentModel = new ContentItem();
$realisations = $contentModel->getAllByType('realisation');

// Inclure la vue des réalisations
require_once __DIR__ . '/app/views/realisations.php';
?>
