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

/**
 * Les comptes qui commencent par 1
 */

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '1') {
        $comptes_bons_1[] = $compte_bon;
    }
}

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_bons_1 as $compte_bon_1) {
        if (($mon_compte->numero == $compte_bon_1) && !empty($mon_compte->debit_solde)) {
            $comptes_bons_1_complet_avec_debit_solde[] = $mon_compte->debit_solde;
        }
    }
}

/**
 * Les comptes qui commencent par 109 et 2 sauf 28 et 29
 */

$comptes_bons_109_et_2 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 3)) === '109' OR strval(substr($compte_bon, 0, 1)) === '2') {
        $comptes_bons_109_et_2[] = $compte_bon;
    }
}


foreach ($comptes_bons_109_et_2 as $key => $value) {
    if (strval(substr($value, 0, 2)) === '28' || strval(substr($value, 0, 2)) === '29') {
        unset($comptes_bons_109_et_2[$key]);
    }
}

/**
 * Les comptes qui commencent par 3 sauf 39
 */

$comptes_bons_3_sauf_39 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '3') {
        $comptes_bons_3_sauf_39[] = $compte_bon;
    }
}


foreach ($comptes_bons_3_sauf_39 as $key => $value) {
    if (strval(substr($value, 0, 2)) === '39') {
        unset($comptes_bons_3_sauf_39[$key]);
    }
}

/**
 * Les comptes qui commencent par 409 et 411
 */

$comptes_bons_409_et_411 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 3)) === '409' || strval(substr($compte_bon, 0, 3)) === '411') {
        $comptes_bons_409_et_411[] = $compte_bon;
    }
}


$comptes_bons_55_et_57 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 2)) === '55' || strval(substr($compte_bon, 0, 2)) === '57' || strval(substr($compte_bon, 0, 3)) === '585') {
        $comptes_bons_55_et_57[] = $compte_bon;
    }
}

$comptes_pas_credit_ouv_et_credit_solde = array_merge($comptes_bons_109_et_2, $comptes_bons_3_sauf_39, $comptes_bons_409_et_411, $comptes_bons_55_et_57);

$comptes_complet_pas_credit_ouv = [];

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_pas_credit_ouv_et_credit_solde as $compte_pas_credit_ouv_et_credit_solde) {
        if (($mon_compte->numero == $compte_pas_credit_ouv_et_credit_solde) && !empty($mon_compte->credit_ouv)) {
            $comptes_complet_pas_credit_ouv[] = $mon_compte->credit_ouv;
        }
    }
}

$comptes_complet_pas_credit_solde = [];

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_pas_credit_ouv_et_credit_solde as $compte_pas_credit_ouv_et_credit_solde) {
        if (($mon_compte->numero == $compte_pas_credit_ouv_et_credit_solde) && !empty($mon_compte->credit_solde)) {
            $comptes_complet_pas_credit_solde[] = $mon_compte->credit_solde;
        }
    }
}


/**
 * Les comptes qui commencent par 6 et 2 sauf 603
 */

$comptes_bons_6_sauf_603 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '6') {
        $comptes_bons_6_sauf_603[] = $compte_bon;
    }
}


foreach ($comptes_bons_6_sauf_603 as $key => $value) {
    if (strval(substr($value, 0, 3)) === '603') {
        unset($comptes_bons_6_sauf_603[$key]);
    }
}

/**
 * Les comptes qui commencent par 1 sauf 109
 */

$comptes_bons_1_sauf_109 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '1') {
        $comptes_bons_1_sauf_109[] = $compte_bon;
    }
}


foreach ($comptes_bons_1_sauf_109 as $key => $value) {
    if (strval(substr($value, 0, 3)) === '109') {
        unset($comptes_bons_1_sauf_109[$key]);
    }
}

/**
 * Les comptes qui commencent par 7 sauf 73
 */

$comptes_bons_7_sauf_73 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '7') {
        $comptes_bons_7_sauf_73[] = $compte_bon;
    }
}


foreach ($comptes_bons_7_sauf_73 as $key => $value) {
    if (strval(substr($value, 0, 2)) === '73') {
        unset($comptes_bons_7_sauf_73[$key]);
    }
}

/**
 * Les comptes qui commencent par 28, 29, 39
 */

$comptes_bons_28_29_39 = [];

foreach ($comptes_bons as $compte_bon) {
    if (
        strval(substr($compte_bon, 0, 2)) === '28' ||
        strval(substr($compte_bon, 0, 2)) === '29' ||
        strval(substr($compte_bon, 0, 2)) === '39'
    ) {
        $comptes_bons_28_29_39[] = $compte_bon;
    }
}

/**
 * Les comptes qui commencent par 585
 */

$comptes_bons_585 = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 3)) === '585') {
        $comptes_bons_585[] = $compte_bon;
    }
}

/**
 * Les comptes qui commencent par 8 et 8 + chiffre impaire
 */

$comptes_bons_8_plus_chiffre_impair = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '8') {
        $comptes_bons_8_plus_chiffre_impair[] = $compte_bon;
    }
}


foreach ($comptes_bons_8_plus_chiffre_impair as $key => $value) {
    if (
        strval(substr($value, 0, 2)) === '82' ||
        strval(substr($value, 0, 2)) === '84' ||
        strval(substr($value, 0, 2)) === '86' ||
        strval(substr($value, 0, 2)) === '88'
    ) {
        unset($comptes_bons_8_plus_chiffre_impair[$key]);
    }
}

/**
 * Les comptes qui commencent par 8 et 8 + chiffre pair
 */

$comptes_bons_8_plus_chiffre_pair = [];

foreach ($comptes_bons as $compte_bon) {
    if (strval(substr($compte_bon, 0, 1)) === '8') {
        $comptes_bons_8_plus_chiffre_pair[] = $compte_bon;
    }
}


foreach ($comptes_bons_8_plus_chiffre_pair as $key => $value) {
    if (
        strval(substr($value, 0, 2)) === '81' ||
        strval(substr($value, 0, 2)) === '83' ||
        strval(substr($value, 0, 2)) === '85' ||
        strval(substr($value, 0, 2)) === '87' ||
        strval(substr($value, 0, 2)) === '89'
    ) {
        unset($comptes_bons_8_plus_chiffre_pair[$key]);
    }
}

$comptes_pas_debit_ouv_credit_ouv_et_credit_solde = array_merge($comptes_bons_6_sauf_603, $comptes_bons_8_plus_chiffre_impair, $comptes_bons_585, $comptes_bons_1_sauf_109, $comptes_bons_7_sauf_73, $comptes_bons_8_plus_chiffre_pair);

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_pas_debit_ouv_credit_ouv_et_credit_solde as $compte_pas_debit_ouv_credit_ouv_et_credit_solde) {
        if (($mon_compte->numero == $compte_pas_debit_ouv_credit_ouv_et_credit_solde) && !empty($mon_compte->credit_ouv)) {
            $comptes_complet_pas_credit_ouv[] = $mon_compte->credit_ouv;
        }
    }
}

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_pas_debit_ouv_credit_ouv_et_credit_solde as $compte_pas_debit_ouv_credit_ouv_et_credit_solde) {
        if (($mon_compte->numero == $compte_pas_debit_ouv_credit_ouv_et_credit_solde) && !empty($mon_compte->credit_solde)) {
            $comptes_complet_pas_credit_solde[] = $mon_compte->credit_solde;
        }
    }
}

$comptes_complet_pas_debit_ouv = [];

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_pas_debit_ouv_credit_ouv_et_credit_solde as $compte_pas_debit_ouv_credit_ouv_et_credit_solde) {
        if (($mon_compte->numero == $compte_pas_debit_ouv_credit_ouv_et_credit_solde) && !empty($mon_compte->debit_ouv)) {
            $comptes_complet_pas_debit_ouv[] = $mon_compte->debit_ouv;
        }
    }
}

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_bons_28_29_39 as $compte_bon_28_29_39) {
        if (($mon_compte->numero == $compte_bon_28_29_39) && !empty($mon_compte->debit_ouv)) {
            $comptes_complet_pas_debit_ouv[] = $mon_compte->debit_ouv;
        }
    }
}

$comptes_complet_pas_debit_solde = [];

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_pas_debit_ouv_credit_ouv_et_credit_solde as $compte_pas_debit_ouv_credit_ouv_et_credit_solde) {
        if (($mon_compte->numero == $compte_pas_debit_ouv_credit_ouv_et_credit_solde) && !empty($mon_compte->debit_solde)) {
            $comptes_complet_pas_debit_solde[] = $mon_compte->debit_solde;
        }
    }
}

foreach ($mes_comptes as $mon_compte) {
    foreach ($comptes_bons_28_29_39 as $compte_bon_28_29_39) {
        if (($mon_compte->numero == $compte_bon_28_29_39) && !empty($mon_compte->debit_solde)) {
            $comptes_complet_pas_debit_solde[] = $mon_compte->debit_solde;
        }
    }
}


// echo '<pre>';
// var_dump($comptes_bons_8_plus_chiffre_impair);
// echo '</pre>';
// exit();


