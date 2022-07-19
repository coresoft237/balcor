<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// require 'functions.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title><?= $title ?? 'Mon site' ?></title>
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="/index.php">BALCOR</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/index.php">Accueil</a>
          </li>
        </ul>
        <div class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <?php if(isset($_SESSION['auth'])): ?>
              <li class="nav-item">
                <a class="nav-link text-light" aria-current="page" href="/auth/logout.php">Se deconnecter</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" aria-current="page" href="/admin/admin.php">Administration</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link text-light" aria-current="page" href="/auth/login.php">se connecter</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" aria-current="page" href="/auth/register.php">s'inscrire</a>
              </li>
            <?php endif ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">
    <?php if(isset($_SESSION['flash'])): ?>
      <?php foreach($_SESSION['flash'] as $type => $message): ?>
        <div class="alert alert-<?= $type ?>">
          <?= $message ?>
        </div>
      <?php endforeach ?>
      <?php unset($_SESSION['flash']) ?>
    <?php endif ?>