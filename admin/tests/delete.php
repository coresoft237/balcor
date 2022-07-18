<?php
$pdo = new PDO('mysql:dbname=plan;host=127.0.0.1', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

try {
    $query = $pdo->prepare('DELETE FROM tests WHERE id = :id');
    $query->execute([
        'id' => $_GET['id']
    ]);

    header('Location: /admin/tests/index.php');
} catch (PDOException $e) {
    $error = $e->getMessage();
}
