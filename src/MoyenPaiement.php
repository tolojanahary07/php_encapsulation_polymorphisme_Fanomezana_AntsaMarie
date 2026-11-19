<?php
declare(strict_types=1);

interface MoyenPaiement
{
    public function payer(float $montant): Recu;

    public function getLibelle(): string;
}
