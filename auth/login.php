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
                        <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../elements/footer.php'; ?>