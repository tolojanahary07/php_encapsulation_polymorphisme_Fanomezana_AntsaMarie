<?php
declare(strict_types=1);

require_once __DIR__ . '/MoyenPaiement.php';
require_once __DIR__ . '/Recu.php';

abstract class PaiementAbstrait implements MoyenPaiement
{
    public function __construct(
        protected readonly string $payeur
    ) {
        if (trim($payeur) === '') {
            throw new InvalidArgumentException('Le nom du payeur est obligatoire.');
        }
    }

    final public function payer(float $montant): Recu
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException('Le montant doit être supérieur à 0.');
        }

        return new Recu(
            $this->getLibelle(),
            $montant,
            $this->frais($montant)
        );
    }

    abstract protected function frais(float $montant): float;
}
