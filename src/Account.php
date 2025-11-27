<?php

declare(strict_types=1);

namespace App;

/**
 * Compte d'argent de poche pour adolescent (MyWeeklyAllowance)
 */
final class Account
{
    // Solde actuel du compte (0 par défaut)
    private float $solde = 0.0;

    // Allocation hebdomadaire (0 par défaut)
    private float $allocationHebdo = 0.0;

    // Nom et email de l'adolescent
    private string $nom;
    private string $email;

    /**
     * Crée un nouveau compte avec solde initial 0
     */
    public function __construct(string $nom, string $email)
    {
        $this->nom = $nom;
        $this->email = $email;
    }

    // Retourne le solde actuel
    public function getSolde(): float
    {
        return $this->solde;
    }

    // Ajoute de l'argent au solde
    public function deposer(float $montant): void
    {
        $this->solde += $montant;
    }

    // Retire de l'argent (exception si solde insuffisant)
    public function depense(float $montant): void
    {
        if ($montant > $this->solde) {
            throw new \InvalidArgumentException('Solde insuffisant');
        }
        $this->solde -= $montant;
    }

    // Définit l'allocation hebdomadaire
    public function fixerAllocationHebdomadaire(float $montant): void
    {
        $this->allocationHebdo = $montant;
    }

    // Retourne l'allocation hebdomadaire
    public function getAllocationHebdomadaire(): float
    {
        return $this->allocationHebdo;
    }

    // Ajoute l'allocation au solde
    public function appliquerAllocation(): void
    {
        $this->solde += $this->allocationHebdo;
    }
}
