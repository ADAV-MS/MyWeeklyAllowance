<?php

declare(strict_types=1);

namespace App;

/**
 * Compte d'argent de poche pour adolescent (MyWeeklyAllowance)
 */
final class Account
{
    private float $solde = 0.0;
    private float $allocationHebdo = 0.0;
    private string $nom;
    private string $email;

    /**
     * Crée un compte valide avec solde initial 0
     */
    public function __construct(string $nom, string $email)
    {
        $this->validerNom($nom);
        $this->validerEmail($email);
        $this->nom = trim($nom);
        $this->email = $email;
    }

    /**
     * Getters publics
     */
    public function getSolde(): float
    {
        return $this->solde;
    }

    public function getAllocationHebdomadaire(): float
    {
        return $this->allocationHebdo;
    }

    /**
     * Actions métier avec validations
     */
    public function deposer(float $montant): void
    {
        $this->validerMontantPositif($montant);
        $this->solde += $montant;
    }

    public function depense(float $montant): void
    {
        $this->validerMontantPositif($montant);
        if ($montant > $this->solde) {
            throw new \InvalidArgumentException('Solde insuffisant');
        }
        $this->solde -= $montant;
    }

    public function fixerAllocationHebdomadaire(float $montant): void
    {
        $this->validerMontantNonNegatif($montant);
        $this->allocationHebdo = $montant;
    }

    public function appliquerAllocation(): void
    {
        $this->solde += $this->allocationHebdo;
    }

    /**
     * Méthodes de validation privées
     */
    private function validerNom(string $nom): void
    {
        if (empty(trim($nom))) {
            throw new \InvalidArgumentException('Le nom ne peut pas être vide');
        }
    }

    private function validerEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email invalide');
        }
    }

    private function validerMontantPositif(float $montant): void
    {
        if ($montant <= 0) {
            throw new \InvalidArgumentException('Le montant doit être positif');
        }
    }

    private function validerMontantNonNegatif(float $montant): void
    {
        if ($montant < 0) {
            throw new \InvalidArgumentException('L\'allocation ne peut pas être négative');
        }
    }
}
