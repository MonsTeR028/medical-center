# SAE3-01
## Auteurs
- Florian CHASSELOUP (chas0025)
- Clement DAVID (davi0063)
- Karim RYSMAN (rysm0002)
- Romaric PERICHARD (peri0060)
- Tristan AUDINOT (audi0010)

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