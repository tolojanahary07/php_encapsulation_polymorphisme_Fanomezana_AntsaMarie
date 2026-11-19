# TP POO PHP — Encapsulation et polymorphisme

**Binôme :**
- Membre 1 : NOM ET PRÉNOM
- Membre 2 : NOM ET PRÉNOM

## 1. Environnement

- PHP 8.1 minimum
- Aucun framework
- Aucune base de données

## 2. Arborescence

```text
tp-poo-NOM1-NOM2/
├── src/
│   ├── CompteBancaire.php
│   ├── SoldeInsuffisantException.php
│   ├── MoyenPaiement.php
│   ├── PaiementAbstrait.php
│   ├── Especes.php
│   ├── CarteBancaire.php
│   ├── MobileMoney.php
│   ├── Recu.php
│   ├── Caisse.php
│   └── Cheque.php
├── tests.php
└── README.md
```

## 3. Exécution

Ouvrir un terminal dans le dossier du projet puis exécuter :

```bash
php tests.php
```

## 4. Réponses aux questions du TP 1

### Q1. Pourquoi ne pas écrire de méthode `setSolde()` ?

On ne crée pas de méthode `setSolde()` parce qu'elle permettrait de modifier directement le solde sans respecter les règles bancaires. Le solde doit changer uniquement avec les méthodes métier `deposer()`, `retirer()` et `virerVers()`. Ces méthodes vérifient les montants et empêchent un solde négatif.

### Q2. Que se passe-t-il si on écrit `$a->numero = 'X';` ? Recopiez le message d'erreur.

La propriété `numero` est déclarée `public readonly`. Après sa création, elle ne peut plus être modifiée. PHP déclenche donc une erreur de type `Error`.

Message attendu sous PHP 8.1 ou plus :

```text
Cannot modify readonly property CompteBancaire::$numero
```

### Q3. `getHistorique()` renvoie le tableau privé : l'appelant peut-il modifier l'historique interne ? Pourquoi ?

Non, l'appelant ne peut pas modifier directement le tableau privé avec le tableau retourné. En PHP, les tableaux sont transmis par valeur (avec une optimisation appelée copy-on-write). Une modification de la copie retournée ne modifie donc pas le tableau interne de l'objet. L'historique ne contient ici que des valeurs simples.

## 5. Réponses aux questions du TP 2

### Q4. Pourquoi utiliser à la fois une interface et une classe abstraite ?

L'interface `MoyenPaiement` définit le contrat commun que tous les moyens de paiement doivent respecter : `payer()` et `getLibelle()`. La classe abstraite `PaiementAbstrait` fournit le code commun : elle conserve le payeur, vérifie que le montant est positif et construit le reçu. Les classes concrètes n'ont ensuite qu'à définir leur libellé et leurs frais.

### Q5. Que se passe-t-il si une classe enfant de `PaiementAbstrait` oublie de définir `frais()` ?

PHP déclenche une erreur fatale au moment où la classe enfant est déclarée ou chargée, car elle n'a pas implémenté la méthode abstraite obligatoire `frais()`.

## 6. Explication des frais

- Espèces : 0 Ar.
- Carte bancaire : 1,5 % du montant.
- Mobile Money : 2 % du montant, avec un maximum de 5 000 Ar.
- Chèque : 1 000 Ar de frais fixes.

Pour le test demandé :
- Carte : 100 000 Ar + 1 500 Ar = 101 500 Ar.
- Mobile Money : 300 000 Ar + 5 000 Ar = 305 000 Ar.
- Total de la journée : **406 500 Ar**.

La classe `Cheque` démontre le polymorphisme : elle est ajoutée sans aucune modification de `Caisse.php`.

## 7. Choix techniques

- Les propriétés sensibles sont privées ou `readonly`.
- Les montants sont contrôlés avant les opérations.
- Un virement vérifie le solde avant de modifier les deux comptes.
- `Caisse` utilise le type `MoyenPaiement` et ne contient ni `instanceof`, ni `switch`, ni condition sur le type de paiement.
- `Recu` est immuable grâce à ses propriétés `readonly`.
