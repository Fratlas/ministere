<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/admin">Admin Panel</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/admin">Liste des Projets</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Modifier un Projet</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo $project['category']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $project['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $project['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="En cours" <?php echo $project['status'] == 'En cours' ? 'selected' : ''; ?>>En cours</option>
                    <option value="Terminé" <?php echo $project['status'] == 'Terminé' ? 'selected' : ''; ?>>Terminé</option>
                    <option value="Planifié" <?php echo $project['status'] == 'Planifié' ? 'selected' : ''; ?>>Planifié</option>
                </select>
            </div>
            <div class="mb-3">
                <?php if ($project['image_url']): ?>
                    <div class="mb-2">
                        <strong>Image actuelle:</strong><br>
                        <img src="<?php echo htmlspecialchars($project['image_url']); ?>" alt="Aperçu" style="max-width: 200px; max-height: 200px;">
                    </div>
                <?php endif; ?>
                <label for="image_file" class="form-label">Changer l'image (uploader)</label>
                <input type="file" class="form-control" id="image_file" name="image_file" accept="image/*">
                <small class="form-text text-muted">Formats acceptés: JPG, PNG, GIF, WebP. Taille max: 5MB. Laisser vide pour garder l'image actuelle.</small>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">OU URL de l'image</label>
                <input type="url" class="form-control" id="image_url" name="image_url" value="<?php echo $project['image_url']; ?>" placeholder="https://...">
            </div>
            <div class="mb-3">
                <label for="update_date" class="form-label">Date de mise à jour</label>
                <input type="text" class="form-control" id="update_date" name="update_date" value="<?php echo $project['update_date']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>
</html>