<?php
$pdo = new PDO('mysql:dbname=plan;host=127.0.0.1', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

$error = null;
$success = null;

try {
    if (isset($_POST['numero'], $_POST['libell'])) {
        $query = $pdo->prepare('UPDATE tests SET numero = :numero, libell = :libell WHERE id = :id');
        $query->execute([
            'numero' => $_POST['numero'],
            'libell' => $_POST['libell'],
            'id' => $_GET['id']
        ]);

        header('Location: /plans/index.php');
    }

    $query = $pdo->prepare('SELECT * FROM plans WHERE id = :id');
    $query->execute([
        'id' => $_GET['id']
    ]);
    $plan = $query->fetch();
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require '../elements/header.php';
?>

<p>
    <a class="btn btn-info" href="/plans/index.php">Liste des comptes</a>
</p>


<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
    <div class="row mb-5">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Editer un compte</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nom" class="form-label">Compte</label>
                            <input type="text" name="nom" value="<?= htmlentities($plan->numero) ?>" id="nom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Libelle</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Entrez une description"><?= htmlentities($plan->libelle) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Sauvegarder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php require '../elements/footer.php'; ?>
