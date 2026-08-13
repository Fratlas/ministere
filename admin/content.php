<?php
session_start();
require_once '../config/database.php';
require_once '../app/models/ContentItem.php';
require_once 'file_upload_handler.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$sections = [
    'articles' => [
        'type' => 'article',
        'label' => 'Articles',
        'title' => 'Gestion des articles',
        'section_label' => 'Categorie',
        'badge_label' => 'Badge',
        'order_label' => 'Ordre'
    ],
    'documents' => [
        'type' => 'document',
        'label' => 'Documents',
        'title' => 'Gestion des documents',
        'section_label' => 'Categorie',
        'badge_label' => 'Type de fichier',
        'order_label' => 'Ordre'
    ],
    'realisations' => [
        'type' => 'realisation',
        'label' => 'Realisations DGI',
        'title' => 'Gestion des realisations DGI',
        'section_label' => 'Sous-section',
        'badge_label' => 'Periode',
        'order_label' => 'Ordre',
        'help' => 'Publie sur la timeline accueil et la page /realisations (DGI).',
        'section_options' => ['DGI', 'Phase 1', 'Phase 2', 'Phase 3', 'Timeline']
    ],
    'realisations_dgda' => [
        'type' => 'realisation_dgda',
        'label' => 'Realisations DGDA',
        'title' => 'Gestion des realisations DGDA',
        'section_label' => 'Sous-section',
        'badge_label' => 'Periode',
        'order_label' => 'Ordre',
        'help' => 'Publie sur la page /realisations-dgda.',
        'section_options' => ['DGDA', 'Douanes', 'Flux de donnees', 'Autre']
    ],
    'realisations_dgrad' => [
        'type' => 'realisation_dgrad',
        'label' => 'Realisations DGRAD',
        'title' => 'Gestion des realisations DGRAD',
        'section_label' => 'Sous-section',
        'badge_label' => 'Periode',
        'order_label' => 'Ordre',
        'help' => 'Publie sur la page /realisations-dgrad.',
        'section_options' => ['DGRAD', 'Recettes administratives', 'LOGIRAD', 'Autre']
    ],
    'realisations_autres' => [
        'type' => 'realisation_autre',
        'label' => 'Autres realisations',
        'title' => 'Gestion des autres realisations',
        'section_label' => 'Regie / Theme',
        'badge_label' => 'Periode',
        'order_label' => 'Ordre',
        'help' => 'Publie dans la section Autres realisations sur /realisations#autres.',
        'section_options' => ['BCC', 'Tresor', 'DTO', 'Citoyen', 'Transversal', 'Autre']
    ]
];

$documentCategories = [
    "Rapports d'Activités" => [
        'mode' => 'year',
        'type_label' => 'Année',
    ],
    'Textes Réglementaires' => [
        'mode' => 'type',
        'type_label' => 'Type de texte',
        'types' => ['Décrets', 'Arrêtés', 'Circulaires', 'Projet de loi'],
    ],
    "Appels d'offres" => [
        'mode' => 'year',
        'type_label' => 'Année',
    ],
    'Autres ressources' => [
        'mode' => 'type',
        'type_label' => 'Type de ressource',
        'types' => ['Guides utilisateurs', 'Tutoriels', 'Bulletin', 'Statistiques'],
    ],
];

$documentYears = [];
for ($year = (int) date('Y'); $year >= 2015; $year--) {
    $documentYears[] = (string) $year;
}
$documentYears[] = 'Archives';

$sectionKey = $_GET['section'] ?? 'articles';
if (!isset($sections[$sectionKey])) {
    $sectionKey = 'articles';
}

$config = $sections[$sectionKey];
$contentModel = new ContentItem();
$fileUploadHandler = new FileUploadHandler();
$message = '';
$error = '';

if (isset($_GET['delete'])) {
    $itemId = (int) $_GET['delete'];
    $item = $contentModel->getById($itemId);

    if (!$item || $item['content_type'] !== $config['type']) {
        $error = 'Contenu introuvable pour cette section.';
    } else {
        // Supprimer le fichier associé si existe
        if (!empty($item['file_url'])) {
            $fileUploadHandler->deleteFile($item['file_url']);
        }

        $contentModel->delete($itemId, $config['type']);
        $message = 'Contenu supprime avec succes.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_url = '';
    
    // Traiter l'upload de fichier si présent et c'est la section documents
    if ($sectionKey === 'documents' && isset($_FILES['document_file']) && $_FILES['document_file']['size'] > 0) {
        $upload_result = $fileUploadHandler->handleUpload($_FILES['document_file']);
        if ($upload_result['success']) {
            $file_url = $upload_result['url'];
        } else {
            $error = 'Erreur lors de l\'upload du fichier: ' . $upload_result['error'];
        }
    } else if (!empty($_POST['file_url'])) {
        // Utiliser le fichier existant si aucun nouveau fichier n'a été uploadé
        $file_url = $_POST['file_url'];
    }
    
    if (!$error) {
        $sectionValue = trim($_POST['section_key'] ?? '');
        $badgeValue = trim($_POST['badge_text'] ?? '');

        if ($sectionKey === 'documents') {
            $categoryConfig = $documentCategories[$sectionValue] ?? null;
            if ($categoryConfig && ($categoryConfig['mode'] ?? '') === 'year') {
                $badgeValue = trim($_POST['doc_year'] ?? '');
            } elseif ($categoryConfig) {
                $badgeValue = trim($_POST['doc_type'] ?? '');
            }
        }

        $payload = [
            'content_type' => $config['type'],
            'section_key' => $sectionValue,
            'badge_text' => $badgeValue,
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image_url' => trim($_POST['image_url'] ?? ''),
            'link_url' => trim($_POST['link_url'] ?? ''),
            'meta_text' => trim($_POST['meta_text'] ?? ''),
            'icon_class' => trim($_POST['icon_class'] ?? ''),
            'file_url' => $file_url,
            'display_order' => (int) ($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        if (($_POST['form_mode'] ?? 'create') === 'edit' && !empty($_POST['id'])) {
            // Si on édite et qu'aucun nouveau fichier n'a été uploadé, garder l'ancien
            if (!$file_url && !empty($_POST['id'])) {
                $existing = $contentModel->getById((int) $_POST['id']);
                $payload['file_url'] = $existing['file_url'] ?? null;
            }
            $contentModel->update((int) $_POST['id'], $payload);
            $message = 'Contenu mis a jour avec succes.';
        } else {
            $contentModel->create($payload);
            $message = 'Contenu ajoute avec succes.';
        }
    }
}

$items = $contentModel->getAllByType($config['type'], false);
$editItem = null;

if (isset($_GET['edit'])) {
    $candidate = $contentModel->getById((int) $_GET['edit']);
    if ($candidate && $candidate['content_type'] === $config['type']) {
        $editItem = $candidate;
    }
}

function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$docEdit = [
    'category' => '',
    'year' => '',
    'type' => '',
];

if ($editItem && $sectionKey === 'documents') {
    $docEdit['category'] = (string) ($editItem['section_key'] ?? '');
    $docCategoryConfig = $documentCategories[$docEdit['category']] ?? null;
    $existingBadge = (string) ($editItem['badge_text'] ?? '');
    if ($docCategoryConfig && ($docCategoryConfig['mode'] ?? '') === 'year') {
        $docEdit['year'] = $existingBadge;
    } else {
        $docEdit['type'] = $existingBadge;
    }
}

$isRealisationSection = str_starts_with($sectionKey, 'realisations');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des contenus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #003a76 0%, #00254d 100%); color: #fff; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; display: block; padding: 10px 0; }
        .sidebar a.active, .sidebar a:hover { color: #fff; font-weight: 700; }
        .content-shell { padding: 28px; }
        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
        .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.04em; }
        .form-label { font-weight: 700; }
        .muted { color: #6c757d; }
        .section-tabs { display: flex; flex-wrap: wrap; gap: 8px; }
        .section-tabs .btn { font-size: 0.82rem; }
        .category-picker { display: grid; gap: 8px; }
        .category-option {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 10px 12px;
            border: 1px solid #dbe3ef;
            border-radius: 10px;
            background: #f9fbfe;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease;
        }
        .category-option:hover { border-color: #9ec5ef; background: #f1f7fd; }
        .category-option:has(input:checked) {
            border-color: #0d6efd;
            background: rgba(13, 110, 253, 0.08);
            font-weight: 700;
        }
        .category-option input { margin: 0; }
        .admin-help {
            border-left: 4px solid #0d6efd;
            background: #eef5ff;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 0.92rem;
            color: #355272;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-xl-2 sidebar p-4">
                <h4 class="mb-4">Admin</h4>
                <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a class="<?php echo $sectionKey === 'articles' ? 'active' : ''; ?>" href="content.php?section=articles"><i class="bi bi-file-earmark-text"></i> Articles</a>
                <a class="<?php echo $sectionKey === 'documents' ? 'active' : ''; ?>" href="content.php?section=documents"><i class="bi bi-file-earmark-pdf"></i> Documents</a>
                <a class="<?php echo $sectionKey === 'realisations' ? 'active' : ''; ?>" href="content.php?section=realisations"><i class="bi bi-stars"></i> Realisations DGI</a>
                <a class="<?php echo $sectionKey === 'realisations_dgda' ? 'active' : ''; ?>" href="content.php?section=realisations_dgda"><i class="bi bi-building"></i> Realisations DGDA</a>
                <a class="<?php echo $sectionKey === 'realisations_dgrad' ? 'active' : ''; ?>" href="content.php?section=realisations_dgrad"><i class="bi bi-bank"></i> Realisations DGRAD</a>
                <a class="<?php echo $sectionKey === 'realisations_autres' ? 'active' : ''; ?>" href="content.php?section=realisations_autres"><i class="bi bi-collection"></i> Autres realisations</a>
                <hr class="border-light opacity-25">
                <a href="index.php?logout"><i class="bi bi-box-arrow-right"></i> Deconnexion</a>
            </div>

            <div class="col-lg-9 col-xl-10 content-shell">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <h2 class="mb-1"><?php echo h($config['title']); ?></h2>
                        <p class="muted mb-0">Gestion du contenu public synchronise avec l'admin.</p>
                    </div>
                    <div class="section-tabs">
                        <?php foreach ($sections as $key => $section): ?>
                            <a class="btn btn<?php echo $key === $sectionKey ? '' : '-outline'; ?>-primary btn-sm" href="content.php?section=<?php echo h($key); ?>">
                                <?php echo h($section['label']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo h($message); ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo h($error); ?></div>
                <?php endif; ?>

                <div class="row g-4">
                    <div class="col-12 col-xl-7">
                        <div class="panel-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Liste des contenus</h4>
                                <span class="badge text-bg-primary"><?php echo count($items); ?> element(s)</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Titre</th>
                                            <th><?php echo h($config['section_label']); ?></th>
                                            <?php if ($sectionKey === 'documents'): ?>
                                                <th>Annee / Type</th>
                                            <?php else: ?>
                                                <th><?php echo h($config['badge_label']); ?></th>
                                            <?php endif; ?>
                                            <?php if ($sectionKey === 'documents'): ?>
                                                <th>Fichier</th>
                                            <?php endif; ?>
                                            <th>Statut</th>
                                            <th>Ordre</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold"><?php echo h($item['title']); ?></div>
                                                    <div class="small muted"><?php echo h(substr($item['description'], 0, 90)); ?></div>
                                                </td>
                                                <td><?php echo h($item['section_key'] ?: '-'); ?></td>
                                                <td>
                                                    <?php
                                                        $detail = $item['badge_text'] ?: $item['meta_text'];
                                                        if (!$detail && $item['content_type'] === 'document') {
                                                            $detail = strtoupper((string) $item['icon_class']);
                                                        }
                                                        echo h($detail ?: '-');
                                                    ?>
                                                </td>
                                                <?php if ($sectionKey === 'documents'): ?>
                                                    <td>
                                                        <?php if (!empty($item['file_url'])): ?>
                                                            <a href="<?php echo h($item['file_url']); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Telecharger le fichier">
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <?php if ((int) ($item['is_active'] ?? 1) === 1): ?>
                                                        <span class="badge text-bg-success">Publie</span>
                                                    <?php else: ?>
                                                        <span class="badge text-bg-secondary">Brouillon</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo h($item['display_order']); ?></td>
                                                <td class="text-nowrap">
                                                    <a class="btn btn-sm btn-warning" href="content.php?section=<?php echo h($sectionKey); ?>&edit=<?php echo (int) $item['id']; ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger" href="content.php?section=<?php echo h($sectionKey); ?>&delete=<?php echo (int) $item['id']; ?>" onclick="return confirm('Supprimer cet element ?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-5">
                        <div class="panel-card p-4">
                            <h4 class="mb-3"><?php echo $editItem ? 'Modifier' : 'Ajouter'; ?> un contenu</h4>

                            <?php if (!empty($config['help'])): ?>
                                <div class="admin-help mb-3">
                                    <i class="bi bi-info-circle me-1"></i><?php echo h($config['help']); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="form_mode" value="<?php echo $editItem ? 'edit' : 'create'; ?>">
                                <input type="hidden" name="id" value="<?php echo $editItem['id'] ?? ''; ?>">
                                <input type="hidden" name="file_url" value="<?php echo h($editItem['file_url'] ?? ''); ?>">

                                <div class="mb-3">
                                    <label class="form-label"><?php echo h($config['section_label']); ?></label>
                                    <?php if ($sectionKey === 'documents'): ?>
                                        <div class="category-picker" id="docCategoryPicker">
                                            <?php foreach ($documentCategories as $catName => $catConfig): ?>
                                                <?php $isChecked = ($docEdit['category'] === $catName); ?>
                                                <label class="category-option">
                                                    <input type="radio" name="section_key" value="<?php echo h($catName); ?>" data-mode="<?php echo h($catConfig['mode']); ?>" <?php echo $isChecked ? 'checked' : ''; ?> required>
                                                    <span><?php echo h($catName); ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php elseif ($isRealisationSection && !empty($config['section_options'])): ?>
                                        <select name="section_key" class="form-select" required>
                                            <option value="">-- Choisir --</option>
                                            <?php foreach ($config['section_options'] as $option): ?>
                                                <option value="<?php echo h($option); ?>" <?php echo (($editItem['section_key'] ?? '') === $option) ? 'selected' : ''; ?>><?php echo h($option); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted d-block mt-1">Exemples : Phase 1, DGDA, BCC, Transversal...</small>
                                    <?php else: ?>
                                        <input type="text" name="section_key" class="form-control" value="<?php echo h($editItem['section_key'] ?? ''); ?>" placeholder="Ex: DGI, Budget, Actualite">
                                    <?php endif; ?>
                                </div>

                                <?php if ($sectionKey === 'documents'): ?>
                                    <div class="mb-3" id="docYearField">
                                        <label class="form-label" for="docYearSelect">Annee</label>
                                        <select name="doc_year" id="docYearSelect" class="form-select">
                                            <option value="">-- Choisir une annee --</option>
                                            <?php foreach ($documentYears as $yearOption): ?>
                                                <option value="<?php echo h($yearOption); ?>" <?php echo ($docEdit['year'] === $yearOption) ? 'selected' : ''; ?>><?php echo h($yearOption); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="docTypeField" hidden>
                                        <label class="form-label" for="docTypeSelect" id="docTypeLabel">Type de fichier</label>
                                        <select name="doc_type" id="docTypeSelect" class="form-select">
                                            <option value="">-- Choisir un type --</option>
                                        </select>
                                    </div>
                                <?php else: ?>
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo h($config['badge_label']); ?></label>
                                        <input type="text" name="badge_text" class="form-control" value="<?php echo h($editItem['badge_text'] ?? ''); ?>" placeholder="<?php echo $isRealisationSection ? 'Ex: 2015 - 2018' : 'Ex: 12 MARS 2024'; ?>">
                                        <?php if ($isRealisationSection): ?>
                                            <small class="text-muted d-block mt-1">Periode affichee sur la carte (ex: 2018 - 2024).</small>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">Titre</label>
                                    <input type="text" name="title" class="form-control" required value="<?php echo h($editItem['title'] ?? ''); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="4" required><?php echo h($editItem['description'] ?? ''); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Image URL</label>
                                    <input type="text" name="image_url" class="form-control" value="<?php echo h($editItem['image_url'] ?? ''); ?>" placeholder="<?php echo $isRealisationSection ? '/public/images/mon-image.jpg' : 'Optionnel'; ?>">
                                    <?php if ($isRealisationSection): ?>
                                        <small class="text-muted d-block mt-1">Image affichee sur la carte de realisation.</small>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lien URL</label>
                                    <input type="text" name="link_url" class="form-control" value="<?php echo h($editItem['link_url'] ?? ''); ?>" placeholder="Optionnel">
                                </div>

                                <?php if ($sectionKey === 'documents'): ?>
                                    <div class="mb-3">
                                        <label class="form-label">Taille du fichier</label>
                                        <input type="text" name="meta_text" class="form-control" value="<?php echo h($editItem['meta_text'] ?? ''); ?>" placeholder="Ex: 4.2 MB">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Format du fichier</label>
                                        <select name="icon_class" class="form-select">
                                            <option value="pdf" <?php echo (($editItem['icon_class'] ?? 'pdf') === 'pdf') ? 'selected' : ''; ?>>PDF</option>
                                            <option value="excel" <?php echo (($editItem['icon_class'] ?? '') === 'excel') ? 'selected' : ''; ?>>Excel</option>
                                            <option value="word" <?php echo (($editItem['icon_class'] ?? '') === 'word') ? 'selected' : ''; ?>>Word</option>
                                            <option value="file" <?php echo (($editItem['icon_class'] ?? '') === 'file') ? 'selected' : ''; ?>>Autre</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Fichier a telecharger</label>
                                        <input type="file" name="document_file" class="form-control" accept=".pdf,.xlsx,.xls,.docx,.doc,.zip">
                                        <small class="text-muted d-block mt-2">Formats acceptes: PDF, Excel, Word, ZIP (max 50MB)</small>
                                        <?php if (!empty($editItem['file_url'])): ?>
                                            <div class="alert alert-info mt-2 mb-0">
                                                <small>Fichier actuel: 
                                                    <a href="<?php echo h($editItem['file_url']); ?>" target="_blank" class="text-info">
                                                        <i class="bi bi-download"></i> Telecharger
                                                    </a>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="meta_text" value="<?php echo h($editItem['meta_text'] ?? ''); ?>">
                                    <input type="hidden" name="icon_class" value="<?php echo h($editItem['icon_class'] ?? ''); ?>">
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ordre d'affichage</label>
                                            <input type="number" name="display_order" class="form-control" value="<?php echo h($editItem['display_order'] ?? 0); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?php echo (!isset($editItem) || (int)($editItem['is_active'] ?? 1) === 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_active">Publier</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary"><?php echo $editItem ? 'Mettre a jour' : 'Ajouter'; ?></button>
                                    <?php if ($editItem): ?>
                                        <a href="content.php?section=<?php echo h($sectionKey); ?>" class="btn btn-secondary">Annuler</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($sectionKey === 'documents'): ?>
    <script>
        (function () {
            const picker = document.getElementById('docCategoryPicker');
            const yearField = document.getElementById('docYearField');
            const typeField = document.getElementById('docTypeField');
            const yearSelect = document.getElementById('docYearSelect');
            const typeSelect = document.getElementById('docTypeSelect');
            const typeLabel = document.getElementById('docTypeLabel');
            if (!picker || !yearField || !typeField) return;

            const NOMENCLATURE = <?php echo json_encode($documentCategories, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
            const savedType = <?php echo json_encode($docEdit['type'], JSON_UNESCAPED_UNICODE); ?>;

            function getSelectedCategory() {
                const checked = picker.querySelector('input[name="section_key"]:checked');
                return checked ? checked.value : '';
            }

            function refreshDocFields() {
                const category = getSelectedCategory();
                if (!category) {
                    yearField.hidden = true;
                    typeField.hidden = true;
                    yearSelect.required = false;
                    typeSelect.required = false;
                    return;
                }

                const config = NOMENCLATURE[category] || { mode: 'year', type_label: 'Type de fichier', types: [] };
                const isYear = config.mode === 'year';

                yearField.hidden = !isYear;
                typeField.hidden = isYear;
                yearSelect.required = isYear;
                typeSelect.required = !isYear;

                if (!isYear) {
                    typeLabel.textContent = config.type_label || 'Type de fichier';
                    const options = ['<option value="">-- Choisir un type --</option>'];
                    (config.types || []).forEach((option) => {
                        const selected = option === savedType ? ' selected' : '';
                        options.push(`<option value="${option.replace(/"/g, '&quot;')}"${selected}>${option}</option>`);
                    });
                    typeSelect.innerHTML = options.join('');
                }
            }

            picker.addEventListener('change', refreshDocFields);
            refreshDocFields();
        })();
    </script>
    <?php endif; ?>
</body>
</html>
