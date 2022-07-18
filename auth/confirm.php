<?php
$user_id = $_GET['id'];
$token = $_GET['token'];

require '../elements/db.php';

$query = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$query->execute([$user_id]);
$user = $query->fetch();
session_start();

if ($user && $user->confirmation_token == $token) {
    $query = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?');
    $query->execute([$user_id]);

    $_SESSION['flash']['success'] = "Votre compte a bien ete valide.";
    $_SESSION['auth'] = $user;
    header('Location: account.php');
} else {
    $_SESSION['flash']['danger'] = "ce token n'est plus valide.";
    header('Location: login.php');
}