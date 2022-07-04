<?php 

require 'core.php'; 
require 'elements/header.php'; 

?>

<div class="row">
    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
        <table class="table table-bordered text-capitalise text-center">
            <thead>
                <tr>
                    <th scope="col">Comptes</th>
                    <th scope="col">Libelles</th>
                    <th colspan="2" scope="col">Ouvertures</th>
                    <th colspan="2" scope="col">Mouvements</th>
                    <th colspan="2" scope="col">Soldes</th>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mes_comptes as $key => $single_compte): ?>
                    <tr>
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
    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">STATISTIQUES</div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6"><?= '<strong class="text-center">' . count($mes_comptes) . '</strong> comptes' ?></div>
                </div>
            </div>
            <div class="card-body">
                <div class="list-group">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <h5 class="text-end">Comptes</h5>
                                <?php foreach ($comptes_mauvais as $un_compte): ?>
                                    <a href="#" class="list-group-item list-group-item-action list-group-item-danger"><?= $un_compte ?></a>
                                <?php endforeach ?>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <h5>invalides</h5>
                                <div class="card p-1">
                                    <?= '<strong class="text-center">' . count($comptes_mauvais) . '</strong> <span class="text-center">comptes invalides</span>' ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <h5 class="mt-3 text-end">Comptes</h5>
                                <?php foreach ($comptes_bons as $un_compte): ?>
                                    <a href="#" class="list-group-item list-group-item-action list-group-item-success"><?= $un_compte ?></a>
                                <?php endforeach ?>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
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
