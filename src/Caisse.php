<?php
declare(strict_types=1);

require_once __DIR__ . '/MoyenPaiement.php';
require_once __DIR__ . '/Recu.php';

class Caisse
{
    private float $totalJour = 0.0;

    public function encaisser(MoyenPaiement $paiement, float $montant): Recu
    {
        $recu = $paiement->payer($montant);
        $this->totalJour += $recu->total();

        return $recu;
    }

    public function getTotalJour(): float
    {
        return $this->totalJour;
    }
}
