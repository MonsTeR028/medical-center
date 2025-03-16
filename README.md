# Medical Center
Médical center est une application web complète, permettant au professionnel de la santé de commander des médicaments parmi une vague base de données, comprenant :
- Un système de compte
- Un système de commande et de stock
- Un système de catalogue et recherche

Bien qu'il s'agisse d'un projet universitaire, et qu'il n'existe pas réellement de vente de médicament le site est parfaitement fonctionnel.

## Auteurs
- Florian CHASSELOUP
- Clement DAVID
- Karim RYSMAN
- Romaric PERICHARD
- Tristan AUDINOT

## Installation / Configuration
```shell
composer install # Installation des dépendances du projet 
```
Dans la configuration de PHPStorm
- Activez le greffon « Symfony Support »
- Ainsi que PHP CS Fixer

## Création de la base de données

- Dupliquez le fichier .env en .env.local.  
- Modifiez ce nouveau fichier en ajustant cette ligne avec vos identifiants de bases de données :
```dotenv
DATABASE_URL="mysql://VOTRE_LOGIN:PASSWORD@mysql/VOTRE_LOGIN_pharmacie?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```
- Exécutez la commande suivante :
```shell
composer db
```

## Accès au serveur Web

Lancez le serveur Web local avec cette commande :
```bash
composer start
```

Naviguez ensuite à partir de cette adresse : <https://127.0.0.1:8000/>

## Vérifications de code

Lancez la vérification du code PHP :
```bash
composer test:phpcs
```

Lancez la vérification du code Twig :
```bash
composer test:twigcs
```

Lancez la correction du code PHP :
```bash
composer fix:phpcs
```

Lancez la correction du code Twig :
```bash
composer fix:twigcs
```

Lancez la vérification PHP et Twig :
```bash
composer test
```

Lancez la correction du code PHP et Twig :
```bash
composer fix
```

## Utilisateur de test 
Compte utilisateur :
```bash
    email : mickey@example.com
    mdp : test
```
Compte administrateur : 
```bash
    email : batman@example.com
    mdp : test
```

