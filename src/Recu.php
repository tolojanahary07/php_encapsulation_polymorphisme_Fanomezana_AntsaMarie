<?php
declare(strict_types=1);

class Recu
{
    public function __construct(
        public readonly string $libelle,
        public readonly float $montant,
        public readonly float $frais
    ) {
        if ($montant <= 0) {
            throw new InvalidArgumentException('Le montant doit être supérieur à 0.');
        }
        if ($frais < 0) {
            throw new InvalidArgumentException('Les frais ne peuvent pas être négatifs.');
        }
    }

    public function total(): float
    {
        return $this->montant + $this->frais;
    }
}
