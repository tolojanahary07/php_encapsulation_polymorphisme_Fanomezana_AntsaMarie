<?php
declare(strict_types=1);

require_once __DIR__ . '/PaiementAbstrait.php';

class CarteBancaire extends PaiementAbstrait
{
    private readonly string $numeroMasque;

    public function __construct(string $payeur, string $numeroCarte)
    {
        parent::__construct($payeur);

        $chiffres = preg_replace('/\D+/', '', $numeroCarte) ?? '';
        if (strlen($chiffres) < 4) {
            throw new InvalidArgumentException('Le numéro de carte doit contenir au moins 4 chiffres.');
        }

        $this->numeroMasque = '**** ' . substr($chiffres, -4);
    }

    public function getLibelle(): string
    {
        return 'Carte ' . $this->numeroMasque;
    }

    protected function frais(float $montant): float
    {
        return $montant * 0.015;
    }
}
