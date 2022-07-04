<?php
class Compte {

    public $numero;
    public $libelle;
    public $debit_ouv;
    public $credit_ouv;
    public $debit_mou;
    public $credit_mou;
    public $debit_solde;
    public $credit_solde;

    public function __construct(
        $numero = null,
        $libelle = null,
        $debit_ouv = null,
        $credit_ouv = null,
        $debit_mou = null,
        $credit_mou = null,
        $debit_solde = null,
        $credit_solde = null
    )
    {
        $this->numero = $numero;
        $this->libelle = $libelle;
        $this->debit_ouv = $debit_ouv;
        $this->credit_ouv = $credit_ouv;
        $this->debit_mou = $debit_mou;
        $this->credit_mou = $credit_mou;
        $this->debit_solde = $debit_solde;
        $this->credit_solde = $credit_solde;
    }

    public function toJSON(): string
    {
        return json_encode([
            'numero' => $this->numero,
            'libelle' => $this->libelle,
            'debit_ouv' => $this->debit_ouv,
            'credit_ouv' => $this->credit_ouv,
            'debit_mou' => $this->debit_mou,
            'credit_mou' => $this->credit_mou,
            'debit_solde' => $this->debit_solde,
            'credit_solde' => $this->credit_solde
        ]);
    }
}