<?php

function debug($variable) {
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($length) {
    $alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only() {
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder a cette page";
        header('Location: login.php');
        exit();
    }
}

function reconnect_from_cookie() {
    if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
        require_once '../elements/db.php';
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $query = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $query->execute([$user_id]);
        $user = $query->fetch();

        if ($user) {
            $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ratonlaveurs');
            if ($expected == $remember_token) {
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
            } else {
                setcookie('remember', null, -1);
            }
        } else {
            setcookie('remember', null, -1);
        }
    }
}