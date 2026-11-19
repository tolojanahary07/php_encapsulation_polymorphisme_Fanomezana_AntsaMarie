<?php
declare(strict_types=1);

require_once __DIR__ . '/src/SoldeInsuffisantException.php';
require_once __DIR__ . '/src/CompteBancaire.php';

require_once __DIR__ . '/src/MoyenPaiement.php';
require_once __DIR__ . '/src/Recu.php';
require_once __DIR__ . '/src/PaiementAbstrait.php';
require_once __DIR__ . '/src/Especes.php';
require_once __DIR__ . '/src/CarteBancaire.php';
require_once __DIR__ . '/src/MobileMoney.php';
require_once __DIR__ . '/src/Caisse.php';
require_once __DIR__ . '/src/Cheque.php';

$a = new CompteBancaire('MG-001', 'Rakoto');
$b = new CompteBancaire('MG-002', 'Rasoa');

$a->deposer(150000);
$a->virerVers($b, 40000);

echo $a->getSolde(), ' / ', $b->getSolde(), PHP_EOL;
echo '<br>';
try {
    $b->virerVers($a, 999999);
} catch (SoldeInsuffisantException $e) {
    echo 'Refusé : Solde insuffisant', PHP_EOL;
}

echo $a->getSolde(), ' / ', $b->getSolde(), PHP_EOL;
echo '<br>';
$caisse = new Caisse();

$recuCarte = $caisse->encaisser(
    new CarteBancaire('Rakoto', '1234 5678 9012 1234'),
    100000
);

$recuMobile = $caisse->encaisser(
    new MobileMoney('Rasoa', 'MVola'),
    300000
);

echo PHP_EOL;
echo 'Carte : ', number_format($recuCarte->total(), 0, ',', ' '), ' Ar', PHP_EOL;
echo '<br>';
echo 'Mobile Money : ', number_format($recuMobile->total(), 0, ',', ' '), ' Ar', PHP_EOL;
echo '<br>';
echo 'Total : ', number_format($caisse->getTotalJour(), 0, ',', ' '), ' Ar', PHP_EOL;

$caisse->encaisser(new Cheque('Andry'), 50000);

$caisse->encaisser(new Especes('Miora'), 10000);
