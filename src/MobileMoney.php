<?php
declare(strict_types=1);

require_once __DIR__ . '/PaiementAbstrait.php';

class MobileMoney extends PaiementAbstrait
{
    public function __construct(
        string $payeur,
        private readonly string $operateur
    ) {
        parent::__construct($payeur);

        if (trim($operateur) === '') {
            throw new InvalidArgumentException('L’opérateur Mobile Money est obligatoire.');
        }
    }

    public function getLibelle(): string
    {
        return 'Mobile Money (' . $this->operateur . ')';
    }

    protected function frais(float $montant): float
    {
        return min($montant * 0.02, 5000.0);
    }
}
