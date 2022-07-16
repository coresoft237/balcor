<?php
$pdo = new PDO('mysql:dbname=plan;host=127.0.0.1', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

$error = null;

try {
    if (isset($_POST['nom'], $_POST['description'])) {
        $query = $pdo->prepare('INSERT INTO tests (nom, description) VALUES (:nom, :description)');
        $query->execute([
            'nom' => $_POST['nom'],
            'description' => $_POST['description']
        ]);

        header('Location: /tests/index.php');
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require '../elements/header.php';
?>

<p>
    <a class="btn btn-info" href="/tests/index.php">Liste des tests</a>
</p>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
    <div class="row mb-5">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Editer un test</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Entrez une description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Sauvegarder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php require '../elements/footer.php'; ?>
