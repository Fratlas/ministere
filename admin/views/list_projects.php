<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Projets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/admin">Admin Panel</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">Retour au site</a>
                <a class="nav-link" href="/admin?action=add">Ajouter Projet</a>
                <a class="nav-link" href="?logout=1">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Gestion des Projets</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?php echo $project['id']; ?></td>
                    <td><?php echo $project['title']; ?></td>
                    <td><?php echo $project['category']; ?></td>
                    <td><?php echo $project['status']; ?></td>
                    <td>
                        <a href="/admin?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="/admin?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>