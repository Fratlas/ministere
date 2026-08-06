<?php
session_start();

require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: /admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('SELECT id, password FROM admin_users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $username;
            header('Location: /admin/dashboard.php');
            exit;
        }

        $error = 'Identifiants invalides';
    } catch (Throwable $e) {
        $error = 'Erreur MySQL: ' . $e->getMessage();
    }
}

require_once __DIR__ . '/views/login.php';
