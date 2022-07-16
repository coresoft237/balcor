<?php

require 'vendor/autoload.php';
require 'class/Compte.php';

if (isset($_POST['save_excel_data'])) {
    $filename = $_FILES['import_file']['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileName = $_FILES['import_file']['tmp_name'];

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $data_json = json_encode($data);

        $fichier = 'C:' . DIRECTORY_SEPARATOR . 'dsf' . DIRECTORY_SEPARATOR . 'balance.json';

        $directory = dirname($fichier);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        if (!file_exists($fichier)) {
            touch($fichier);
        }

        file_put_contents($fichier, $data_json);

        $donnees_balance = file_get_contents($fichier);

        $pdo = new PDO('mysql:dbname=plan;host=127.0.0.1', 'root', '');
        $query = $pdo->query("SELECT * FROM plans");
        $donnees_plan = $query->fetchAll(PDO::FETCH_ASSOC);

        $query = $pdo->query("SELECT * FROM tests");
        $donnees_tests = $query->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // var_dump($donnees_tests);
        // echo '</pre>';

        $new_donnees_balance = json_decode($donnees_balance);

        $comptes_bons = [];
        $comptes_mauvais = [];
        $all_comptes = [];

        foreach ($donnees_plan as $donnee_plan) {
            foreach ($new_donnees_balance as $donnee_balance) {
                $all_comptes[] = $donnee_balance[0];

                $donnee_plan_length = strlen($donnee_plan['numero']);
                $substr_donnee_balance_length = strlen(substr($donnee_balance[0], 0, $donnee_plan_length));

                if ($donnee_plan_length === $substr_donnee_balance_length) {
                    if (strval(substr($donnee_balance[0], 0, $donnee_plan_length)) === $donnee_plan['numero']) {
                        $comptes_bons[] = $donnee_balance[0];
                    }
                }
            }
        }
    }

    foreach ($all_comptes as $all_compte) {
        if (in_array($all_compte, $comptes_bons)) {
            // echo "Le compte $all_compte est bon.";
        } else {
            // echo "Le compte $all_compte est mauvais. <br>";
            // $comptes_mauvais["conformite"][] = $donnees_tests[0]['nom'];
            $comptes_mauvais[] = $all_compte;
        }
    }
}

$comptes_mauvais_conformite = [];

$comptes_mauvais_conformite['comptes'] = array_unique($comptes_mauvais);
$comptes_mauvais_conformite['nom'] = $donnees_tests[0]['nom'];
$comptes_mauvais_conformite['description'] = $donnees_tests[0]['description'];

// echo '<pre>';
// var_dump($comptes_mauvais_conformite);
// echo '</pre>';

$mes_comptes = [];

foreach($data as $row) {

    $numero = $row['0'];
    $libelle = $row['1'];
    $debit_ouv = $row['2'];
    $credit_ouv = $row['3'];
    $debit_mou = $row['4'];
    $credit_mou = $row['5'];
    $debit_solde = $row['6'];
    $credit_solde = $row['7'];

    $mes_comptes[] = new Compte($numero, $libelle, $debit_ouv, $credit_ouv, $debit_mou, $credit_mou, $debit_solde, $credit_solde);
}

$comptes_mauvais = array_unique($comptes_mauvais);
$comptes_bons = array_unique($comptes_bons);


$comptes_bons_1 = [];
$comptes_bons_1_complet_avec_debit_solde = [];


foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '1') {
        $comptes_bons_1[] = $compte_bon;
    }
}

foreach ($mes_comptes as $mon_compte) {
    // echo '<pre>';
    // var_dump($mon_compte->numero);
    // echo '</pre>';
    foreach ($comptes_bons_1 as $compte_bon_1) {
        // echo '<pre>';
        // var_dump($comptes_bons_1);
        // echo '</pre>';
        
        if (($mon_compte->numero == $compte_bon_1) && !empty($mon_compte->debit_solde)) {
            $comptes_bons_1_complet_avec_debit_solde[] = $mon_compte->debit_solde;
            // $comptes_bons_1_complet_avec_debit_solde['debit'] = $mon_compte->debit_solde;
            // $comptes_bons_1_complet_avec_debit_solde['credit'] = $mon_compte->credit_solde;
        }
    }
}

// echo '<pre>';
// var_dump(array_values($comptes_bons_1_complet_avec_debit_solde));
// echo '</pre>';

// echo '<pre>';
// var_dump($mes_comptes[0]->debit_solde);
// echo '</pre>';
