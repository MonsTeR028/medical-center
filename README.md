# Guide Utilisateur - Medical Center

## 📖 Introduction
Medical Center est une application web destinée aux professionnels de la santé, leur permettant de commander des médicaments à partir d'une vaste base de données.

### ✨ Fonctionnalités principales
- 👤 Système de gestion de comptes
- 📦 Gestion des commandes et du stock
- 🔍 Catalogue et moteur de recherche avancé

> **Note** : Ce projet est réalisé dans un cadre universitaire. Bien qu'il soit pleinement fonctionnel, aucune vente réelle de médicaments n'a lieu.

## 👥 Auteurs
- **Florian CHASSELOUP**
- **Clement DAVID**
- **Karim RYSMAN**
- **Romaric PERICHARD**
- **Tristan AUDINOT**

---

## 👔 Pour un futur recruteur
- [Lien vers le figma : (password : audi-figma)](https://www.figma.com/design/5HtMTW8gaXapJ9yAMJ8SKW/SAE---MedicalCenter?node-id=0-1&t=R9jsdyCxqeCrw29A-1)

## 🚀 Installation et Configuration

### 📌 Prérequis
Avant d'installer le projet, assurez-vous d'avoir :
- **PHP** (8.x recommandé)
- **Composer** (gestionnaire de dépendances PHP)
- **Symfony CLI** (optionnel mais recommandé)
- **MySQL** ou **MariaDB**
- **PHPStorm** (recommandé) avec les extensions :
  - "Symfony Support"
  - "PHP CS Fixer"

### 📥 Installation
Clonez le dépôt et installez les dépendances :
```bash
composer install
```

### ⚙️ Configuration de l'environnement
1. Dupliquez le fichier `.env` en `.env.local`.
2. Modifiez `.env.local` avec vos identifiants :
```dotenv
DATABASE_URL="mysql://VOTRE_LOGIN:PASSWORD@mysql/VOTRE_LOGIN_pharmacie?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```
3. Créez la base de données :
```bash
composer db
```

### 🖥️ Démarrage du serveur
Lancez le serveur avec :
```bash
composer start
```
Puis accédez à : [https://127.0.0.1:8000/](https://127.0.0.1:8000/)

---

## ✅ Vérifications et Qualité du Code

### 🔍 Vérification du code
```bash
composer test:phpcs  # Vérification PHP
composer test:twigcs  # Vérification Twig
composer test  # Vérification complète
```

### 🔧 Correction automatique
```bash
composer fix:phpcs  # Correction PHP
composer fix:twigcs  # Correction Twig
composer fix  # Correction complète
```

---

## 🔑 Comptes de Test
### 👥 Utilisateur standard
```bash
Email : mickey@example.com
Mot de passe : test
```

### 🛠️ Administrateur
```bash
Email : batman@example.com
Mot de passe : test
```

---

## 🎯 Bonnes Pratiques Git

### 📌 Structuration des commits
- Utilisez des messages clairs (`feat: ajout de la gestion des commandes`).
- Respectez la convention _Conventional Commits_.

### 🌿 Gestion des branches
- Travaillez sur des branches spécifiques (`feature/nom-fonctionnalité`).
- Faites des **pull requests** avant de fusionner.

### 📜 Documentation et maintenance
- Ajoutez un fichier `CONTRIBUTING.md`.
- Rédigez des **tests unitaires et fonctionnels**.

---

## 📩 Contact et Support
Pour toute question ou contribution, contactez les auteurs ou ouvrez une issue sur GitHub.

🚀 **Bon développement !**

