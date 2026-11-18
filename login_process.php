<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: login.php'); exit; }

$ip       = $_SERVER['REMOTE_ADDR'];
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Rate limit: 5 failed attempts per IP per 15 minutes
$stmt = $pdo->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND attempted_at > (NOW() - INTERVAL 15 MINUTE)');
$stmt->execute([$ip]);
if ($stmt->fetchColumn() >= 5) {
    http_response_code(429);
    exit('Too many failed attempts. Try again in 15 minutes.');
}

$user = false;
if ($username !== '' && $password !== '') {
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($user && password_verify($password, $user['password_hash'])) {
    $pdo->prepare('DELETE FROM login_attempts WHERE ip = ?')->execute([$ip]);
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('Location: dashboard.php');
    exit;
}

$pdo->prepare('INSERT INTO login_attempts (ip) VALUES (?)')->execute([$ip]);
header('Location: login.php?error=1');
exit;
