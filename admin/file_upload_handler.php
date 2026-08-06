<?php
/**
 * Gestionnaire d'upload de fichiers pour l'admin
 * Permet l'upload de documents (PDF, Excel, Word)
 */

class FileUploadHandler {
    private $upload_dir = __DIR__ . '/../public/documents/uploads';
    private $max_file_size = 50 * 1024 * 1024; // 50MB
    private $allowed_extensions = ['pdf', 'xlsx', 'xls', 'docx', 'doc', 'zip'];
    private $base_url = '/public/documents/uploads';

    public function __construct() {
        // Créer le répertoire s'il n'existe pas
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }

    /**
     * Traiter l'upload d'un fichier document
     * 
     * @param array $file Le fichier depuis $_FILES
     * @return array ['success' => bool, 'url' => string, 'filename' => string, 'error' => string]
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
            return ['success' => false, 'error' => 'Le fichier dépasse la taille limite de 50MB'];
        }

        // Vérifier l'extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowed_extensions)) {
            return ['success' => false, 'error' => 'Type de fichier non autorisé. Extensions acceptées: ' . implode(', ', $this->allowed_extensions)];
        }

        // Générer un nom de fichier unique et sûr
        $filename = $this->generateUniqueFilename($ext);
        $filepath = $this->upload_dir . '/' . $filename;

        // Vérifier le type MIME selon l'extension
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        // MIME types autorisés par extension
        $allowed_mimes = [
            'pdf' => ['application/pdf'],
            'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            'xls' => ['application/vnd.ms-excel', 'application/x-msexcel'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'doc' => ['application/msword', 'application/x-msword'],
            'zip' => ['application/zip', 'application/x-zip-compressed']
        ];

        if (isset($allowed_mimes[$ext]) && !in_array($mime_type, $allowed_mimes[$ext])) {
            return ['success' => false, 'error' => 'Le fichier n\'est pas un ' . strtoupper($ext) . ' valide'];
        }

        // Déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['success' => false, 'error' => 'Erreur lors de l\'upload du fichier'];
        }

        // Retourner l'URL relative
        $relative_path = str_replace('\\', '/', substr($filepath, strlen(dirname(__DIR__))));
        return [
            'success' => true,
            'url' => $relative_path,
            'filename' => pathinfo($file['name'], PATHINFO_FILENAME),
            'size' => $file['size']
        ];
    }

    /**
     * Supprimer un fichier uploadé
     */
    public function deleteFile($file_url) {
        // Vérifier si c'est un fichier uploadé
        if (strpos($file_url, '/public/documents/uploads') === false) {
            return ['success' => false, 'error' => 'Impossible de supprimer ce fichier'];
        }

        // Construire le chemin local
        $local_path = dirname(__DIR__) . $file_url;

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

    /**
     * Obtenir l'extension d'une URL de fichier
     */
    public static function getFileExtension($file_url) {
        return strtolower(pathinfo($file_url, PATHINFO_EXTENSION));
    }

    /**
     * Formater la taille du fichier
     */
    public static function formatFileSize($bytes) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
?>
