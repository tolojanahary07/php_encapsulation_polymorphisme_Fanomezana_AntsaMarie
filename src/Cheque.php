<?php
declare(strict_types=1);

require_once __DIR__ . '/PaiementAbstrait.php';

class Cheque extends PaiementAbstrait
{
    public function getLibelle(): string
    {
        return 'Chèque';
    }

    protected function frais(float $montant): float
    {
        return 1000.0;
    }
}
