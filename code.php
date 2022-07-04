<?php 

require 'core.php'; 
require 'elements/header.php'; 

?>

<div class="row">
    <div class="col-md-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Comptes</th>
                    <th scope="col">Libelles</th>
                    <th scope="col">Debit_Ouv</th>
                    <th scope="col">Credit_Ouv</th>
                    <th scope="col">Debit_Mou</th>
                    <th scope="col">Credit_Mou</th>
                    <th scope="col">Debit_Solde</th>
                    <th scope="col">Credit_Solde</th>
            </thead>
            <tbody>
                <?php foreach ($mes_comptes as $key => $single_compte): ?>
                    <tr>
                        <th scope="row"><?= $key + 1 ?></th>
                        <td><?= $single_compte->numero ?></td>
                        <td><?= strtolower($single_compte->libelle) ?></td>
                        <td><?= $single_compte->debit_ouv ?></td>
                        <td><?= $single_compte->credit_ouv ?></td>
                        <td><?= $single_compte->debit_mou ?></td>
                        <td><?= $single_compte->credit_mou ?></td>
                        <td><?= $single_compte->debit_solde ?></td>
                        <td><?= $single_compte->credit_solde ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">STATISTIQUES</div>
                    <div class="col-md-6"><?= '<strong class="text-center">' . count($mes_comptes) . '</strong> comptes' ?></div>
                </div>
            </div>
            <div class="card-body">
                <div class="list-group">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-end">Comptes</h5>
                                <?php foreach ($comptes_mauvais as $un_compte): ?>
                                    <a href="#" class="list-group-item list-group-item-action list-group-item-danger"><?= $un_compte ?></a>
                                <?php endforeach ?>
                            </div>
                            <div class="col-md-6">
                                <h5>invalides</h5>
                                <div class="card p-1">
                                    <?= '<strong class="text-center">' . count($comptes_mauvais) . '</strong> <span class="text-center">comptes invalides</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mt-3 text-end">Comptes</h5>
                                <?php foreach ($comptes_bons as $un_compte): ?>
                                    <a href="#" class="list-group-item list-group-item-action list-group-item-success"><?= $un_compte ?></a>
                                <?php endforeach ?>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mt-3">valides</h5>
                                <div class="card p-1">
                                    <?= '<strong class="text-center">' . count($comptes_bons) . '</strong> <span class="text-center">comptes valides</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'elements/footer.php'; ?>
