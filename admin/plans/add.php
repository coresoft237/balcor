<?php
$pdo = new PDO('mysql:dbname=plan;host=127.0.0.1', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

$error = null;

try {
    if (isset($_POST['numero'], $_POST['libelle'])) {
        $query = $pdo->prepare('INSERT INTO tests (numero, libelle) VALUES (:numero, :libelle)');
        $query->execute([
            'numero' => $_POST['numero'],
            'libelle' => $_POST['libelle']
        ]);

        header('Location: /admin/plans/index.php');
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require '../../elements/admin/admin_header.php';
?>

<p>
    <a class="btn btn-info" href="/admin/plans/index.php">Liste des comptes</a>
</p>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
    <div class="row mb-5">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Ajouter un compte</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nom" class="form-label">Compte</label>
                            <input type="text" name="nom" id="nom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Libelle</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Entrez une description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Sauvegarder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php require '../../elements/admin/admin_footer.php'; ?>
