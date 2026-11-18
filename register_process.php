<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: register.php'); exit; }

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

$errors = [];
if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) $errors[] = 'Username must be 3-30 letters, numbers or underscores.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) $errors[] = 'Invalid email address.';
if (strlen($password) < 8)                             $errors[] = 'Password must be at least 8 characters.';
if ($password !== $confirm)                            $errors[] = 'Passwords do not match.';

if (!$errors) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) $errors[] = 'Username or email already in use.';
}

if ($errors) {
    foreach ($errors as $e) echo '<p>' . htmlspecialchars($e) . '</p>';
    echo '<a href="register.php">Go back</a>';
    exit;
}

try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $hash]);
} catch (PDOException $e) {
    echo '<p>Username or email already in use.</p><a href="register.php">Go back</a>';
    exit;
}

header('Location: login.php?registered=1');
exit;
