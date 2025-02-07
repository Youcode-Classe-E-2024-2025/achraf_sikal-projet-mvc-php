# Projet MVC OOP

Ce projet est une implémentation d'une architecture MVC (Modèle-Vue-Contrôleur) en PHP. Il vise à offrir une structure bien organisée pour le développement d'applications web modulaires et évolutives.

## 📌 Fonctionnalités
- Architecture MVC bien structurée
- Gestion des routes
- Connexion à la base de données avec PDO
- Gestion des erreurs et exceptions
- Séparation claire entre la logique métier et l'affichage

## 🛠️ Technologies utilisées
- **Langage** : PHP 8+
- **Base de données** : PostgreSQL (support via PDO)
- **Framework CSS** : bootstrap
- **JavaScript** : Pour les interactions dynamiques (si nécessaire)

## 🚀 Installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/Youcode-Classe-E-2024-2025/achraf_sikal-projet-mvc-php.git
   ```
2. **Se déplacer dans le projet**
   ```bash
   cd achraf_sikal-projet-mvc-php
   ```
3. **Configurer la base de données**
   - Importer le fichier SQL dans votre base de données
   - Modifier le fichier de configuration `.env` ou `config/database.php` avec vos informations de connexion

4. **Lancer le serveur local**
   ```bash
   php -S localhost:8000 -t public/
   ```
5. **Accéder à l'application**
   - Ouvrez votre navigateur et allez sur : `http://localhost:8000`

## 📂 Structure du projet
```
/achraf_sikal-projet-mvc-php
│── app/
|   │── config/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Core/
│── public/
│── .env
│── README.md
```
- **app/** : Contient les fichiers principaux du modèle, de la vue et du contrôleur
- **public/** : Contient les fichiers accessibles au public (CSS, JS, assets, index.php)
- **config/** : Contient la configuration de l'application

## 📝 Contribution
Les contributions sont les bienvenues ! Suivez ces étapes :
1. **Fork** le projet
2. Créez une nouvelle branche : `git checkout -b feature/ma-fonctionnalite`
3. Apportez vos modifications et validez-les : `git commit -m "Ajout d'une nouvelle fonctionnalité"`
4. Poussez la branche : `git push origin feature/ma-fonctionnalite`
5. Créez une **Pull Request**


---
✉️ **Contact** : Si vous avez des questions, n'hésitez pas à me contacter !
