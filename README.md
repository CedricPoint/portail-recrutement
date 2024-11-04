# Portail de Recrutement pour PME

Ce projet est un portail de recrutement conçu pour les petites et moyennes entreprises (PME) afin de faciliter la publication d'offres d'emploi et la gestion des candidatures. Ce portail permet aux candidats de postuler aux offres après s'être inscrits et connectés. Le projet est construit avec PHP, MySQL, HTML, CSS et Bootstrap.

## Démo

Vous pouvez accéder à une démo en ligne ici : [recrutement.informaclique.fr](https://recrutement.informaclique.fr/)

## Fonctionnalités

- **Gestion des Offres d'Emploi** : Les entreprises peuvent ajouter, modifier, et supprimer des offres d'emploi.
- **Gestion des Candidatures** : Les entreprises peuvent consulter les candidatures reçues, télécharger les CV, marquer les candidatures comme traitées, et supprimer celles qui ne sont plus nécessaires.
- **Inscription et Connexion** : Les candidats doivent s'inscrire et se connecter pour accéder aux fonctionnalités de postulation.
- **Tableau de Bord Entreprise** : Les entreprises peuvent voir et gérer les offres d'emploi qu'elles ont publiées et les candidatures reçues.
- **Tableau de Bord Candidat** : Les candidats peuvent voir les offres d'emploi disponibles et postuler directement.

## Installation

1. **Cloner le Dépôt**

   ```sh
   git clone https://github.com/votre-utilisateur/votre-repository.git
   cd votre-repository
   ```

2. **Configuration de la Base de Données**
   - Créez une base de données MySQL et importez le fichier `database.sql` fourni pour créer les tables nécessaires.
   - Mettez à jour le fichier `db.php` avec vos informations d'identification MySQL :
     ```php
     <?php
     $servername = "votre_serveur";
     $username = "votre_nom_utilisateur";
     $password = "votre_mot_de_passe";
     $dbname = "votre_base_de_donnees";
     $conn = new mysqli($servername, $username, $password, $dbname);
     ?>
     ```

3. **Installation sur Serveur Web**
   - Copiez les fichiers du projet dans le répertoire de votre serveur web (par exemple, Apache ou Nginx).
   - Assurez-vous que le dossier `uploads/` dispose des permissions d'écriture pour permettre l'upload des CV.

4. **Accéder à l'Application**
   - Ouvrez votre navigateur et accédez à l'URL de votre serveur (par exemple, `http://localhost/votre-repository`).

## Utilisation

- **Entreprises** : Inscrivez-vous comme entreprise pour publier des offres d'emploi et gérer les candidatures reçues.
- **Candidats** : Inscrivez-vous en tant que candidat pour consulter les offres et postuler en ligne.

## Technologies Utilisées

- **Frontend** : HTML, CSS, Bootstrap
- **Backend** : PHP, MySQL

## Contribuer

Les contributions sont les bienvenues ! Veuillez créer une issue ou une pull request pour toute amélioration, correction de bug, ou nouvelle fonctionnalité.

## Licence

Ce projet est sous licence MIT. Veuillez consulter le fichier `LICENSE` pour plus d'informations.

## Auteurs

- **Cédric FRANK** - Créateur du projet

## Contact

Pour toute question ou demande d'informations supplémentaires, vous pouvez contacter [Informaclique](https://informaclique.fr/).
