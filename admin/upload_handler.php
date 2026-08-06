<?php
/**
 * Gestionnaire d'upload d'images pour l'admin
 */

class ImageUploadHandler {
    private $upload_dir = __DIR__ . '/../public/images/uploads';
    private $max_file_size = 5 * 1024 * 1024; // 5MB
    private $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $base_url = '/public/images/uploads';

    public function __construct() {
        // Créer le répertoire s'il n'existe pas
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }

    /**
     * Traiter l'upload d'un fichier image
     * 
     * @param array $file Le fichier depuis $_FILES
     * @return array ['success' => bool, 'url' => string, 'error' => string]
     */
    public function handleUpload($file) {
        // Vérifier si le fichier a été uploadé
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'Aucun fichier uploadé'];
        }

        // Vérifier les erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => $this->getUploadError($file['error'])];
        }

        // Vérifier la taille du fichier
        if ($file['size'] > $this->max_file_size) {
            return ['success' => false, 'error' => 'Le fichier dépasse la taille limite de 5MB'];
        }

        // Vérifier l'extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowed_extensions)) {
            return ['success' => false, 'error' => 'Type de fichier non autorisé. Extensions acceptées: ' . implode(', ', $this->allowed_extensions)];
        }

        // Générer un nom de fichier unique et sûr
        $filename = $this->generateUniqueFilename($ext);
        $filepath = $this->upload_dir . '/' . $filename;

        // Vérifier le type MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mime_type, $allowed_mimes)) {
            return ['success' => false, 'error' => 'Le fichier n\'est pas une image valide'];
        }

        // Déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['success' => false, 'error' => 'Erreur lors de l\'upload du fichier'];
        }

        // Retourner l'URL relative
        $relative_path = str_replace('\\', '/', substr($filepath, strlen(dirname(__DIR__))));
        return ['success' => true, 'url' => $relative_path];
    }

    /**
     * Supprimer une image uploadée
     */
    public function deleteImage($image_url) {
        // Vérifier si c'est une image uploadée (contient /public/images/uploads)
        if (strpos($image_url, '/public/images/uploads') === false) {
            return ['success' => false, 'error' => 'Impossible de supprimer cette image'];
        }

        // Construire le chemin local
        $local_path = dirname(__DIR__) . $image_url;

        if (file_exists($local_path) && is_file($local_path)) {
            if (unlink($local_path)) {
                return ['success' => true];
            }
            return ['success' => false, 'error' => 'Erreur lors de la suppression du fichier'];
        }

        return ['success' => false, 'error' => 'Fichier non trouvé'];
    }

    /**
     * Générer un nom de fichier unique
     */
    private function generateUniqueFilename($ext) {
        $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        
        // Vérifier que le fichier n'existe pas déjà
        while (file_exists($this->upload_dir . '/' . $filename)) {
            $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        }

        return $filename;
    }

    /**
     * Obtenir le message d'erreur d'upload
     */
    private function getUploadError($code) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la limite du serveur',
            UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la limite du formulaire',
            UPLOAD_ERR_PARTIAL => 'L\'upload a été interrompu',
            UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été uploadé',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant',
            UPLOAD_ERR_CANT_WRITE => 'Impossible d\'écrire le fichier',
            UPLOAD_ERR_EXTENSION => 'Upload interrompu par une extension PHP'
        ];

        return $errors[$code] ?? 'Erreur d\'upload inconnue';
    }
}
?>
