<?php
$pdo = new PDO('mysql:dbname=plan;host=127.0.0.1', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;

try {
  $query = $pdo->query('SELECT * FROM plans');
  $plans = $query->fetchAll();
} catch (PDOException $e) {
  $error = $e->getMessage();
}

require '../../elements/admin/admin_header.php';
?>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>

<p>
  <a class="btn btn-success" href="/admin/plans/add.php">Ajouter un compte</a>
</p>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">noms</th>
      <th scope="col">descriptions</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($plans as $plan): ?>
        <tr>
            <th scope="row"><?= $plan->id ?></th>
            <td><?= htmlentities($plan->numero) ?></td>
            <td><?= htmlentities($plan->libelle) ?></td>
            <td>
              <a class="btn btn-primary" href="/admin/plans/edit.php?id=<?= $plan->id ?>"><i class="fas fa-pen-to-square"></i></a>
              <a class="btn btn-danger" href="/admin/plans/delete.php?id=<?= $plan->id ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce test ?')"><i class="fas fa-trash-can"></i></a>
            </td>
        </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php endif ?>

<?php require '../../elements/admin/admin_footer.php'; ?>
