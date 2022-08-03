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
                            <td style="padding: 0; background-color: #dc3545;"><button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 100px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite solde" data-bs-content="Ce compte ne doit pas avoir un montant a cette position"><?= $single_compte->credit_solde ?></button></td>
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
        <div class="card mb-3" style="max-width: 18rem;">
            <div class="card-header">
                <h6>Conformite Amortissements</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($comptes_complet_debit_mou as $compte_complet_debit_mou): ?>
                        <?php foreach($comptes_complet_credit_mou as $compte_complet_credit_mou): ?>
                            <?php if($compte_complet_debit_mou === $compte_complet_credit_mou): ?>
                                <button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 250px;" class="btn btn-success" data-bs-toggle="popover" title="Conformite amortissements" data-bs-content="Ce compte 68 a un mouvement debit egal au mouvement credit du compte 28">
                                    <li class="list-group-item bg-success text-white">
                                        <?= $compte_complet_debit_mou ?> est <?= ' = a ' ?> <?= $compte_complet_credit_mou ?>
                                    </li>
                                </button>
                            <?php else: ?>
                                <button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 250px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite amortissements" data-bs-content="Ce compte 68 a un mouvement debit different du mouvement credit du compte 28">
                                    <li class="list-group-item bg-danger text-white">
                                        <?= $compte_complet_debit_mou ?> est <?= ' != de ' ?> <?= $compte_complet_credit_mou ?>
                                    </li>
                                </button>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>

        <div class="card mb-3" style="max-width: 18rem;">
            <div class="card-header">
                <h6>Conformite Provisions</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($comptes_complet_debit_mou_69 as $compte_complet_debit_mou): ?>
                        <?php foreach($comptes_complet_credit_mou_29 as $compte_complet_credit_mou): ?>
                            <?php if($compte_complet_debit_mou === $compte_complet_credit_mou): ?>
                                <button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 250px;" class="btn btn-success" data-bs-toggle="popover" title="Conformite provisions" data-bs-content="Ce compte 69 a un mouvement debit egal au mouvement credit du compte 29">
                                    <li class="list-group-item bg-success text-white">
                                        <?= $compte_complet_debit_mou ?> est <?= ' = a ' ?> <?= $compte_complet_credit_mou ?>
                                    </li>
                                </button>
                            <?php else: ?>
                                <button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 250px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite provisions" data-bs-content="Ce compte 69 a un mouvement debit different du mouvement credit du compte 29">
                                    <li class="list-group-item bg-danger text-white">
                                        <?= $compte_complet_debit_mou ?> est <?= ' != de ' ?> <?= $compte_complet_credit_mou ?>
                                    </li>
                                </button>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>

        <div class="card mb-3" style="max-width: 18rem;">
            <div class="card-header">
                <h6>Conformite VNC</h6>
            </div>
            
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php if(array_sum($comptes_complet_debit_solde) >= array_sum($comptes_complet_credit_solde)): ?>
                        <button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 250px;" class="btn btn-success" data-bs-toggle="popover" title="Conformite VNC" data-bs-content="Le cumul de comptes 211 a 218, 241 a 248 etc... egal au cumul des compte 29">
                            <li class="list-group-item bg-success text-white">
                                <?= array_sum($comptes_complet_debit_solde) ?> est <?= ' >= a ' ?> <?= array_sum($comptes_complet_credit_solde) ?>
                            </li>
                        </button>
                    <?php else: ?>
                        <button type="button" style="border: 0; border-radius: 0; margin: 0;  width: 250px;" class="btn btn-danger" data-bs-toggle="popover" title="Conformite VNC" data-bs-content="Le cumul de comptes 211 a 218, 241 a 248 etc... est different du cumul des compte 29">
                            <li class="list-group-item bg-danger text-white">
                                <?= array_sum($comptes_complet_debit_solde) ?> est <?= ' <= a ' ?> <?= array_sum($comptes_complet_credit_solde) ?>
                            </li>
                        </button>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require 'elements/footer.php'; ?>
