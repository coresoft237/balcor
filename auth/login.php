<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      
      require '../elements/functions.php';

    if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
        require_once '../elements/db.php';

        $query = $pdo->prepare('SELECT * FROM users WHERE email = :email AND confirmed_at IS NOT NULL');
        $query->execute([
            'email' => $_POST['email']
        ]);
        $user = $query->fetch();

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = 'Vous etes maintenant connecte !';
            header('Location: account.php');
            exit();
        } else {
            $_SESSION['flash']['danger'] = 'Email ou mot de passe incorrect !';
        }
    }
?>
<?php require '../elements/header.php'; ?>

<div class="container">
    <div class="row mb-5">
        <div class="col-md-6 mt-4 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Se connecter</h4>
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group ml-4 my-2">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        <div class="form-group my-2">
                            <button class="btn btn-primary btn-block" type="submit">Se connecter</button>
                        </div>
                        <div class="d-flex justify-content-between align-content-center">
                            <a class="btn btn-link" href="/auth/remember.php">Mot de passe oublié !</a>
                            <a href="/auth/register.php" class="text-dark font-weight-bold">Créer un compte !</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../elements/footer.php'; ?>