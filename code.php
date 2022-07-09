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
</div>

<?php require 'elements/footer.php'; ?>
