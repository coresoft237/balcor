<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../elements/functions.php';
logged_only();
 
if (isset($_GET['id']) && isset($_GET['token'])) {
    require_once '../elements/db.php';
    $query = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $query->execute([$_GET['id'], $_GET['token']]);
    $user = $query->fetch();

    if ($user) {
        if (!empty($_POST)) {
            if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                $_SESSION['flash']['success'] = "Votre mot de passe a bien ete modifie";
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }
        }
    } else {
        $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
 
require '../elements/header.php'; 
?>

<div class="container">
    <h1>Bonjour <?= $_SESSION['auth']->username ?></h1>

    <div class="row mb-5">
        <div class="col-md-6 mt-4 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Reinitialiser mon mot de passe</h4>
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
                        <button type="submit" class="btn btn-primary mt-3">Reinitialiser mon mot de passe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../elements/footer.php'; ?>