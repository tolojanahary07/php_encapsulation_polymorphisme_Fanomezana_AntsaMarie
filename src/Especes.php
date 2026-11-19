<?php
declare(strict_types=1);

require_once __DIR__ . '/PaiementAbstrait.php';

class Especes extends PaiementAbstrait
{
    public function getLibelle(): string
    {
        return 'Espèces';
    }

    protected function frais(float $montant): float
    {
        return 0.0;
    }
}
