<?php 

require 'core.php'; 
require 'elements/header.php'; 

?>

<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
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
                        <?php if (in_array($single_compte->numero, array_values($comptes_mauvais_conformite)[0])): ?>
                            <td style="padding: 0; background-color: #dc3545;"><button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 100px;" class="btn btn-danger" data-bs-toggle="popover" title="<?= array_values($comptes_mauvais_conformite)[1] ?>" data-bs-content="<?= array_values($comptes_mauvais_conformite)[2] ?>"><?= $single_compte->numero ?></button></td>
                        <?php else: ?>
                            <!-- style="background-color: #20c997;" -->
                            <td><?= $single_compte->numero ?></td>
                        <?php endif ?>
                        <td><?= strtolower($single_compte->libelle) ?></td>

                        <?php if (isset($single_compte->debit_ouv) && in_array($single_compte->debit_ouv, array_values($comptes_complet_pas_debit_ouv))): ?>
                            <td style="padding: 0; background-color: #dc3545;"><button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 100px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite solde" data-bs-content="Ce compte ne doit pas avoir un montant a cette position"><?= $single_compte->debit_ouv ?></button></td>
                        <?php else: ?>
                            <!-- style="background-color: #20c997;" -->
                            <td><?= $single_compte->debit_ouv ?></td>
                        <?php endif ?>
                        

                        <?php if (isset($single_compte->credit_ouv) && in_array($single_compte->credit_ouv, array_values($comptes_complet_pas_credit_ouv))): ?>
                            <td style="padding: 0; background-color: #dc3545;"><button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 100px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite solde" data-bs-content="Ce compte ne doit pas avoir un montant a cette position"><?= $single_compte->credit_ouv ?></button></td>
                        <?php else: ?>
                            <!-- style="background-color: #20c997;" -->
                            <td><?= $single_compte->credit_ouv ?></td>
                        <?php endif ?>


                        <td><?= $single_compte->debit_mou ?></td>
                        <td><?= $single_compte->credit_mou ?></td>

                        <?php if (isset($single_compte->debit_solde) && in_array($single_compte->debit_solde, array_values($comptes_complet_pas_debit_solde))): ?>
                            <td style="padding: 0; background-color: #dc3545;"><button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 100px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite solde" data-bs-content="Ce compte ne doit pas avoir un montant a cette position"><?= $single_compte->debit_solde ?></button></td>
                        <?php else: ?>
                            <!-- style="background-color: #20c997;" -->
                            <td><?= $single_compte->debit_solde ?></td>
                        <?php endif ?>
                        
                        <?php if (isset($single_compte->credit_solde) && in_array($single_compte->credit_solde, array_values($comptes_complet_pas_credit_solde))): ?>
                            <td style="padding: 0; background-color: #dc3545;"><button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 100px;" class="btn btn-danger" data-bs-toggle="popover" title="Attention" data-bs-content="Ce compte ne doit pas avoir un montant a cette position"><?= $single_compte->credit_solde ?></button></td>
                        <?php else: ?>
                            <!-- style="background-color: #20c997;" -->
                            <td><?= $single_compte->credit_solde ?></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
        <?php foreach($comptes_complet_debit_mou as $compte_complet_debit_mou): ?>
            <?php foreach($comptes_complet_credit_mou as $compte_complet_credit_mou): ?>
                <?php if($compte_complet_debit_mou === $compte_complet_credit_mou): ?>
                    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header">
                            <h6>Conformite Amortissements</h6>
                        </div>

                        <div class="card-body">
                            <p>Correcte</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                        <div class="card-header">
                            <h6>Conformite Amortissements</h6>
                        </div>

                        <div class="card-body">
                            <p>Incorrecte</p>
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        <?php endforeach ?>

        <?php foreach($comptes_complet_debit_mou_69 as $compte_complet_debit_mou): ?>
            <?php foreach($comptes_complet_credit_mou_29 as $compte_complet_credit_mou): ?>
                <?php if($compte_complet_debit_mou === $compte_complet_credit_mou): ?>
                    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header">
                            <h6>Conformite Provisions</h6>
                        </div>

                        <div class="card-body">
                            <p>Correcte</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                        <div class="card-header">
                            <h6>Conformite Provisions</h6>
                        </div>

                        <div class="card-body">
                            <p>Incorrecte</p>
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        <?php endforeach ?>


        <?php if(array_sum($comptes_complet_debit_solde) >= array_sum($comptes_complet_credit_solde)): ?>
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    <h6>Conformite VNC</h6>
                </div>

                <div class="card-body">
                    <p><?= array_sum($comptes_complet_debit_solde) ?> est <?= ' >= ' ?> <?= array_sum($comptes_complet_credit_solde) ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    <h6>Conformite VNC</h6>
                </div>

                <div class="card-body">
                    <p><?= array_sum($comptes_complet_debit_solde) ?> est <?= ' <= ' ?> <?= array_sum($comptes_complet_credit_solde) ?></p>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<?php require 'elements/footer.php'; ?>
