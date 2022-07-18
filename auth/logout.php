<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous etes maintenant deconnecte.";
header('Location: login.php');