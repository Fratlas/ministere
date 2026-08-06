<?php
session_start();
require_once '../config/database.php';
require_once 'upload_handler.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$db = Database::getInstance();
$conn = $db->getConnection();
$uploadHandler = new ImageUploadHandler();

$action = $_GET['action'] ?? 'list';
$message = '';
$error = '';

function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Traiter l'upload d'image si présent
$image_url = '';
$image_url_from_form = $_POST['image_url'] ?? '';

if (isset($_FILES['image_file']) && $_FILES['image_file']['size'] > 0) {
    $upload_result = $uploadHandler->handleUpload($_FILES['image_file']);
    if ($upload_result['success']) {
        $image_url = $upload_result['url'];
    } else {
        $error = $upload_result['error'];
    }
} else if ($image_url_from_form) {
    // Utiliser l'URL du formulaire si aucun fichier n'a été uploadé
    $image_url = $image_url_from_form;
}

// ADD PROJECT
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($error) {
        $error = 'Erreur lors de l\'upload: ' . $error;
    } else {
        $stmt = $conn->prepare("INSERT INTO projects (category, title, description, status, image_url, update_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['category'],
            $_POST['title'],
            $_POST['description'],
            $_POST['status'],
            $image_url,
            $_POST['update_date']
        ]);
        $message = 'Projet ajoute avec succes';
        $action = 'list';
    }
}

// EDIT PROJECT
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($error) {
        $error = 'Erreur lors de l\'upload: ' . $error;
    } else {
        // Si une nouvelle image est uploadée, utiliser son URL. Sinon, garder l'ancienne
        if (!$image_url) {
            // Récupérer l'image existante si aucune nouvelle n'est fournie
            $stmt = $conn->prepare("SELECT image_url FROM projects WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            $image_url = $existing['image_url'];
        }
        
        $stmt = $conn->prepare("UPDATE projects SET category=?, title=?, description=?, status=?, image_url=?, update_date=? WHERE id=?");
        $stmt->execute([
            $_POST['category'],
            $_POST['title'],
            $_POST['description'],
            $_POST['status'],
            $image_url,
            $_POST['update_date'],
            $_POST['id']
        ]);
        $message = 'Projet modifie avec succes';
        $action = 'list';
    }
}

// DELETE PROJECT
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    $message = 'Projet supprime';
}

$stmt = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editProject = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $editProject = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stats = [
    'total' => count($projects),
    'in_progress' => count(array_filter($projects, fn($p) => $p['status'] === 'En cours')),
    'finished' => count(array_filter($projects, fn($p) => $p['status'] === 'Termine' || $p['status'] === 'Terminé')),
    'planned' => count(array_filter($projects, fn($p) => $p['status'] === 'Planifie' || $p['status'] === 'Planifié'))
];

$displayProjects = $projects;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --navy: #082d5a;
            --navy-2: #0d3f77;
            --blue: #0d8bdc;
            --light: #f4f7fb;
            --card: rgba(255,255,255,0.92);
        }

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(13,139,220,0.12), transparent 26%),
                linear-gradient(180deg, #f7fbff 0%, #eef4fb 100%);
            color: #15202b;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--navy) 0%, #031d3a 100%);
            color: white;
            position: sticky;
            top: 0;
            box-shadow: 12px 0 40px rgba(0,0,0,0.1);
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(255,255,255,0.08);
        }

        .sidebar a {
            color: rgba(255,255,255,0.92);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 8px;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.12);
            transform: translateX(4px);
        }

        .content {
            padding: 28px;
        }

        .admin-hero {
            background: linear-gradient(135deg, rgba(13,139,220,0.96), rgba(8,45,90,0.96));
            color: white;
            border-radius: 28px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(8, 45, 90, 0.18);
            animation: heroDrift 8s ease-in-out infinite;
        }

        .admin-hero::after {
            content: '';
            position: absolute;
            inset: auto -90px -90px auto;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255,255,255,0.09);
        }

        .admin-hero::before {
            content: '';
            position: absolute;
            inset: 12px auto auto -120px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            animation: floatBlob 10s ease-in-out infinite;
        }

        .kpi-card,
        .panel-card,
        .form-section {
            background: var(--card);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.55);
            border-radius: 22px;
            box-shadow: 0 14px 42px rgba(15, 23, 42, 0.08);
        }

        .kpi-card {
            padding: 22px;
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            animation: liftFade 0.7s ease both;
        }

        .kpi-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 46px rgba(15, 23, 42, 0.14);
            border-color: rgba(13, 139, 220, 0.22);
        }

        .kpi-card .icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 1.35rem;
            color: white;
        }

        .icon-blue { background: linear-gradient(135deg, #0d8bdc, #2c6bed); }
        .icon-green { background: linear-gradient(135deg, #0bbf7b, #08a06a); }
        .icon-gold { background: linear-gradient(135deg, #f4b400, #e97d00); }
        .icon-indigo { background: linear-gradient(135deg, #6c63ff, #3f51b5); }

        .kpi-value {
            font-size: 2rem;
            font-weight: 900;
            line-height: 1;
        }

        .kpi-label {
            color: #5b6472;
            font-weight: 600;
        }

        .panel-card {
            padding: 24px;
            animation: liftFade 0.7s ease both;
        }

        .table-wrap {
            overflow: hidden;
            border-radius: 18px;
        }

        .table thead th {
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #5b6472;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        .table tbody tr {
            transition: background 0.2s ease, transform 0.2s ease;
            animation: rowFade 0.45s ease both;
        }

        .table tbody tr:hover {
            background: rgba(13, 139, 220, 0.03);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue), #2d6bff);
            border: none;
        }

        .btn-warning,
        .btn-danger,
        .btn-secondary {
            border: none;
        }

        .form-section {
            padding: 24px;
            animation: liftFade 0.8s ease both;
        }

        .field-label {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #5b6472;
            margin-bottom: 8px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: inherit;
            background: rgba(255,255,255,0.82);
            border-radius: 18px;
            padding: 18px 20px;
            border: 1px solid rgba(255,255,255,0.55);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            animation: liftFade 0.7s ease both;
        }

        .quick-link:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
            border-color: rgba(13, 139, 220, 0.2);
        }

        .quick-link i {
            font-size: 1.4rem;
            color: var(--blue);
        }

        .message {
            border-radius: 18px;
            border: none;
        }

        .badge {
            letter-spacing: 0.03em;
        }

        @keyframes liftFade {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes rowFade {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heroDrift {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        @media (max-width: 991.98px) {
            .sidebar {
                min-height: auto;
                position: static;
            }
            .content {
                padding: 18px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-lg-3 col-xl-2 sidebar p-4 p-xl-4">
                <div class="brand-chip mb-4">
                    <div class="rounded-circle bg-white bg-opacity-10 p-2">
                        <i class="bi bi-shield-lock fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Admin Panel</div>
                        <div class="small text-white-50">Ministere des Finances</div>
                    </div>
                </div>

                <a class="active" href="dashboard.php"><i class="bi bi-speedometer2"></i> Vue generale</a>
                <a href="dashboard.php?action=list"><i class="bi bi-list-ul"></i> Activités</a>
                <a href="dashboard.php?action=add"><i class="bi bi-plus-circle"></i> Ajouter projet</a>
                <a href="content.php?section=articles"><i class="bi bi-file-earmark-text"></i> Contenus</a>
                <a href="content.php?section=documents"><i class="bi bi-file-earmark-pdf"></i> Documents</a>
                <a href="content.php?section=realisations"><i class="bi bi-stars"></i> Realisations DGI</a>
                <a href="content.php?section=realisations_dgda"><i class="bi bi-building"></i> Realisations DGDA</a>
                <a href="content.php?section=realisations_dgrad"><i class="bi bi-bank"></i> Realisations DGRAD</a>
                <hr class="border-light opacity-25 my-4">
                <a href="index.php?logout"><i class="bi bi-box-arrow-right"></i> Deconnexion</a>
            </div>

            <div class="col-lg-9 col-xl-10 content">
                <div class="admin-hero mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index:1;">
                        <div>
                            <div class="text-uppercase small fw-bold opacity-75 mb-2">Pilotage central</div>
                            <h1 class="h2 fw-black mb-2">Tableau de bord d'administration</h1>
                            <p class="mb-0 opacity-75">Gestion rapide des activités, contenus et sections publiques du site.</p>
                        </div>
                        <div class="text-end">
                            <div class="small opacity-75">Connecte en tant que</div>
                            <div class="fw-bold fs-5"><?php echo h($_SESSION['admin_username']); ?></div>
                        </div>
                    </div>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-success message mb-4" role="alert"><?php echo h($message); ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger message mb-4" role="alert"><?php echo h($error); ?></div>
                <?php endif; ?>

                <?php if ($action === 'list'): ?>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-xl-3">
                            <div class="kpi-card">
                                <div class="icon icon-blue"><i class="bi bi-folder2-open"></i></div>
                                <div class="kpi-value"><?php echo h($stats['total']); ?></div>
                                <div class="kpi-label">Activités total</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="kpi-card">
                                <div class="icon icon-green"><i class="bi bi-lightning-charge"></i></div>
                                <div class="kpi-value"><?php echo h($stats['in_progress']); ?></div>
                                <div class="kpi-label">En cours</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="kpi-card">
                                <div class="icon icon-gold"><i class="bi bi-check2-circle"></i></div>
                                <div class="kpi-value"><?php echo h($stats['finished']); ?></div>
                                <div class="kpi-label">Termines</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="kpi-card">
                                <div class="icon icon-indigo"><i class="bi bi-calendar2-week"></i></div>
                                <div class="kpi-value"><?php echo h($stats['planned']); ?></div>
                                <div class="kpi-label">Planifies</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <a href="dashboard.php?action=add" class="quick-link">
                                <div>
                                    <div class="fw-bold">Nouvel Activité</div>
                                    <div class="small text-muted">Ajouter un chantier, une action ou une realisation</div>
                                </div>
                                <i class="bi bi-plus-circle"></i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="content.php?section=articles" class="quick-link">
                                <div>
                                    <div class="fw-bold">Contenus publics</div>
                                    <div class="small text-muted">Articles, documents et realisations</div>
                                </div>
                                <i class="bi bi-window-stack"></i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="index.php" class="quick-link">
                                <div>
                                    <div class="fw-bold">Voir le site</div>
                                    <div class="small text-muted">Ouvrir la version publique</div>
                                </div>
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="panel-card mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                            <div>
                                <h4 class="mb-1">Gestion des activités</h4>
                                <p class="text-muted mb-0">Liste complete des activités en base.</p>
                            </div>
                            <a href="dashboard.php?action=add" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-plus me-2"></i> Ajouter
                            </a>
                        </div>

                        <div class="table-wrap table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Titre</th>
                                        <th>Categorie</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($displayProjects as $project): ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo h($project['title']); ?></td>
                                            <td><?php echo h($project['category']); ?></td>
                                            <td>
                                                <span class="badge text-bg-info"><?php echo h($project['status']); ?></span>
                                            </td>
                                            <td><?php echo h($project['update_date']); ?></td>
                                            <td class="text-end">
                                                <a href="dashboard.php?action=edit&id=<?php echo (int) $project['id']; ?>" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil"></i></a>
                                                <a href="dashboard.php?delete=<?php echo (int) $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer ?')"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($action === 'add'): ?>
                    <div class="form-section">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-1">Ajouter une activité</h4>
                                <p class="text-muted mb-0">Renseigne les informations principales d'u projet d'activité.</p>
                            </div>
                            <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill">Retour</a>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Titre</div>
                                        <input type="text" name="title" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Categorie</div>
                                        <input type="text" name="category" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="field-label">Description</div>
                                <textarea name="description" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Statut</div>
                                        <select name="status" class="form-select form-select-lg" required>
                                            <option>En cours</option>
                                            <option>Termine</option>
                                            <option>Planifie</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Date</div>
                                        <input type="text" name="update_date" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="field-label">Upload une image</div>
                                <input type="file" name="image_file" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-2">Formats acceptés: JPG, PNG, GIF, WebP. Taille max: 5MB</small>
                            </div>
                            <div class="mb-4">
                                <div class="field-label">OU URL de l'image</div>
                                <input type="url" name="image_url" class="form-control" placeholder="https://...">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">Ajouter</button>
                                <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                            </div>
                        </form>
                    </div>

                <?php elseif ($action === 'edit' && $editProject): ?>
                    <div class="form-section">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-1">Modifier l'activité</h4>
                                <p class="text-muted mb-0">Ajuste les details et mets a jour le suivi.</p>
                            </div>
                            <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill">Retour</a>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo (int) $editProject['id']; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Titre</div>
                                        <input type="text" name="title" class="form-control form-control-lg" value="<?php echo h($editProject['title']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Categorie</div>
                                        <input type="text" name="category" class="form-control form-control-lg" value="<?php echo h($editProject['category']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="field-label">Description</div>
                                <textarea name="description" class="form-control" rows="5" required><?php echo h($editProject['description']); ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Statut</div>
                                        <select name="status" class="form-select form-select-lg" required>
                                            <option value="En cours" <?php if ($editProject['status'] === 'En cours') echo 'selected'; ?>>En cours</option>
                                            <option value="Termine" <?php if ($editProject['status'] === 'Termine' || $editProject['status'] === 'Terminé') echo 'selected'; ?>>Termine</option>
                                            <option value="Planifie" <?php if ($editProject['status'] === 'Planifie' || $editProject['status'] === 'Planifié') echo 'selected'; ?>>Planifie</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="field-label">Date</div>
                                        <input type="text" name="update_date" class="form-control form-control-lg" value="<?php echo h($editProject['update_date']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <?php if ($editProject['image_url']): ?>
                            <div class="mb-4">
                                <div class="field-label">Image actuelle</div>
                                <div class="mb-2">
                                    <img src="<?php echo h($editProject['image_url']); ?>" alt="Image du projet" style="max-width: 200px; max-height: 200px; border-radius: 4px;">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="mb-4">
                                <div class="field-label">Upload une nouvelle image</div>
                                <input type="file" name="image_file" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-2">Formats acceptés: JPG, PNG, GIF, WebP. Taille max: 5MB. Laisser vide pour garder l'image actuelle.</small>
                            </div>
                            <div class="mb-4">
                                <div class="field-label">OU URL de l'image</div>
                                <input type="url" name="image_url" class="form-control" value="<?php echo h($editProject['image_url']); ?>" placeholder="https://...">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">Modifier</button>
                                <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
