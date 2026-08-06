# Guide d'Upload d'Images pour l'Admin

## Vue d'ensemble
L'admin peut maintenant télécharger des fichiers image directement depuis le panneaux d'administration, en plus de pouvoir utiliser des URLs externes.

## Fonctionnalités

### Upload de fichiers
- **Types acceptés**: JPG, JPEG, PNG, GIF, WebP
- **Taille maximale**: 5 MB par fichier
- **Validation**: Les fichiers sont vérifiés par type MIME pour plus de sécurité

### Comment ça fonctionne

#### Ajouter un projet avec une image
1. Allez dans "Ajouter projet" depuis le dashboard
2. Remplissez les champs du formulaire
3. Choisissez entre:
   - **Upload un fichier**: Cliquez sur le champ "Upload une image" et sélectionnez un fichier depuis votre ordinateur
   - **OU URL externe**: Entrez une URL complète (https://...)
4. Cliquez sur "Ajouter"

#### Modifier l'image d'un projet
1. Allez dans "Modifier projet"
2. L'image actuelle est affichée
3. Pour changer l'image:
   - Upladez un nouveau fichier
   - Ou entrez une nouvelle URL
   - Laissez vide pour garder l'image actuelle

## Détails techniques

### Où sont stockées les images?
Les images uploadées sont stockées dans `/public/images/uploads/`

### Structure des fichiers
- Les fichiers uploadés reçoivent des noms aléatoires uniques
- Les noms de fichier originaux ne sont pas conservés pour des raisons de sécurité
- Les URLs sont stockées en base de données et générées au format: `/public/images/uploads/[nom_aleatoire].[extension]`

### Classe ImageUploadHandler
Fichier: `admin/upload_handler.php`

La classe `ImageUploadHandler` gère:
- Validation de la taille du fichier
- Vérification du type MIME
- Génération de noms uniques
- Gestion des erreurs

## Messages d'erreur courants

| Erreur | Cause | Solution |
|--------|-------|----------|
| "Aucun fichier uploadé" | Pas de fichier sélectionné | Sélectionnez un fichier |
| "Le fichier dépasse la taille limite de 5MB" | Fichier trop volumineux | Réduisez la taille de l'image |
| "Type de fichier non autorisé" | Format non supporté | Utilisez JPG, PNG, GIF ou WebP |
| "Le fichier n'est pas une image valide" | Type MIME invalide | Vérifiez que c'est vraiment une image |

## Sécurité

- Vérification du type MIME (pas seulement l'extension)
- Noms de fichier aléatoires pour éviter l'énumération
- Limitation de la taille des fichiers
- Validation stricte du type d'image
