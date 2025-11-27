<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Account;

final class AccountTest extends TestCase
{
    /**
     * Vérifie qu'un nouveau compte (Lucas) a un solde initial à 0
     */
    public function testCreationLucasSoldeZero(): void
    {
        $account = new Account('Lucas', 'lucas@example.com');
        $solde = $account->getSolde();
        $this->assertSame(0.0, $solde, 'Nouveau compte doit avoir solde = 0');
    }

    /**
     * Vérifie qu'un dépôt de 50€ sur le compte Emma augmente correctement le solde
     */
    public function testDepotEmmaAugmenteSolde(): void
    {
        $account = new Account('Emma', 'emma@example.com');
        $account->deposer(50.0);
        $this->assertSame(50.0, $account->getSolde(), 'Dépôt de 50€ doit porter solde à 50€');
    }

    /**
     * Vérifie qu'une dépense de 30€ sur le compte Noah (après dépôt 100€) diminue le solde à 70€
     */
    public function testDepenseNoahDiminueSolde(): void
    {
        $account = new Account('Noah', 'noah@example.com');
        $account->deposer(100.0);
        $account->depense(30.0);
        $this->assertSame(70.0, $account->getSolde(), 'Dépense 30€ après 100€ doit laisser 70€');
    }

    /**
     * Vérifie qu'une dépense supérieure au solde (Léa : 50€ > 20€) lève une exception
     */
    public function testDepenseSuperieureSoldeLeaLanceException(): void
    {
        $account = new Account('Léa', 'lea@example.com');
        $account->deposer(20.0);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Solde insuffisant');
        $account->depense(50.0);
    }

    /**
     * Vérifie que l'allocation hebdomadaire de Chloé est bien fixée à 15€
     */
    public function testFixerAllocationChloe(): void
    {
        $account = new Account('Chloé', 'chloe@example.com');
        $account->fixerAllocationHebdomadaire(15.0);
        $this->assertSame(15.0, $account->getAllocationHebdomadaire(), 'Allocation doit être 15€');
    }

    /**
     * Vérifie que l'application de l'allocation (Hugo) ajoute bien 10€ au solde
     */
    public function testAppliquerAllocationHugoAjouteSolde(): void
    {
        $account = new Account('Hugo', 'hugo@example.com');
        $account->fixerAllocationHebdomadaire(10.0);
        $account->appliquerAllocation();
        $this->assertSame(10.0, $account->getSolde(), 'Allocation 10€ doit porter solde à 10€');
    }
}
