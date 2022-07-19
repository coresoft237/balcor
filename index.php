<?php require 'elements/header.php'; ?>

<?php if(isset($_SESSION['auth'])): ?>
    <div class="row mb-5">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Importez votre fichier excel svp !</h4>
                </div>

                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="import_file" class="form-control">
                            <button type="submit" class="btn btn-primary mt-3" name="save_excel_data">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row mb-5">
        <div class="col-md-12 mt-4">
            <div class="alert alert-info text-center p-5">
                <h3>S'il vous plait creez vous un compte pour corriger votre balance</h3>
            </div>
        </div>
    </div>
<?php endif ?>




<div class="alert alert-warning">
    <h4><span style="font-weight: bold;">NB :</span> Le tableur excel doit respecter le caneva suivant !</h4>
</div>

<img src="images/tableur-2.png" style="margin:auto; width: 100%; height: 50%;" class="mb-5" alt="">

<?php require 'elements/footer.php'; ?>