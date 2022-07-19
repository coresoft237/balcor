<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  
  require '../elements/functions.php';
logged_only();

if (!empty($_POST)) {
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
    } else {
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once '../elements/db.php';
        $query = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $query->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien ete mis a jour !";
    }
}
require '../elements/header.php'; 
?>

<div class="container">
    <h1>Bonjour <?= $_SESSION['auth']->username ?></h1>

    <div class="row mb-5">
        <div class="col-md-6 mt-4 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Changer de mot de passe</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Changer mon mot de passe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../elements/footer.php'; ?>