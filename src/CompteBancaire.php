<?php
declare(strict_types=1);

require_once __DIR__ . '/SoldeInsuffisantException.php';

class CompteBancaire
{
    private float $solde = 0.0;

    /** @var array<int, array{operation: string, montant: float, detail: string}> */
    private array $historique = [];

    public function __construct(
        public readonly string $numero,
        public readonly string $titulaire
    ) {
        if (trim($numero) === '' || trim($titulaire) === '') {
            throw new InvalidArgumentException('Le numéro et le titulaire sont obligatoires.');
        }
    }

    public function getSolde(): float
    {
        return $this->solde;
    }

    public function deposer(float $montant): void
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException('Le montant du dépôt doit être supérieur à 0.');
        }

        $this->solde += $montant;
        $this->ajouterHistorique('Dépôt', $montant, 'Dépôt sur le compte');
    }

    public function retirer(float $montant): void
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException('Le montant du retrait doit être supérieur à 0.');
        }

        if ($montant > $this->solde) {
            throw new SoldeInsuffisantException(
                'Solde insuffisant : solde disponible ' . $this->solde . ' Ar.'
            );
        }

        $this->solde -= $montant;
        $this->ajouterHistorique('Retrait', $montant, 'Retrait du compte');
    }

    public function virerVers(CompteBancaire $dest, float $montant): void
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException('Le montant du virement doit être supérieur à 0.');
        }

        // On vérifie toutes les conditions avant de modifier l'un des comptes.
        if ($montant > $this->solde) {
            throw new SoldeInsuffisantException(
                'Solde insuffisant'
            );
        }

        // Les deux modifications sont faites après validation : le virement est atomique.
        $this->solde -= $montant;
        $dest->solde += $montant;

        $this->ajouterHistorique('Virement envoyé', $montant, 'Vers ' . $dest->numero);
        $dest->ajouterHistorique('Virement reçu', $montant, 'De ' . $this->numero);
    }

    /**
     * Retourne une copie du tableau d'historique.
     *
     * @return array<int, array{operation: string, montant: float, detail: string}>
     */
    public function getHistorique(): array
    {
        return $this->historique;
    }

    private function ajouterHistorique(string $operation, float $montant, string $detail): void
    {
        $this->historique[] = [
            'operation' => $operation,
            'montant' => $montant,
            'detail' => $detail,
        ];
    }
}
