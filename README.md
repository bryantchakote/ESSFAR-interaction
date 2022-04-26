# Projet académique 2019-2020
Une plateforme d'échange entre étudiants et enseignants de l'ESSFAR, application web from scratch.

## Vue d'ensemble
**ESSFAR interaction** est une plateforme via laquelle les étudiants de l'ESSFAR ont la possibilité de **poser des questions et attendre des réponses** de la part de leurs enseignants. Un ou plusieurs administrateur(s) gère(nt) le système en y inscrivant les étudiants et les enseignants et en modifiant leurs informations. Ils peuvent par ailleurs, pour une raison ou pour une autre réassigner une question à un autre enseignant, supprimer des utilisateurs, etc.

## Prise en main
A supposer que le dossier **ESSFAR-interaction** du projet se trouve dans **xampp/htdocs**, et que les services **Apache** et **MySQL** de Xampp sont démarrés, les étapes suivantes sont à suivre minutieusement:
- Créer la base de données, en exécutant le script SQL `essfar_interaction.sql`
- Créer un administrateur en l'insérant de manière brute dans la base de données (fournir son nom, son prénom, son adresse mail et son mot de passe)
- Insérer également dans la table `niveaux` les différents niveaux
- Remplir la table `ues` avec toutes les unités d'enseignement
***Vraiment désolé pour toutes ces manipulations un peu forcées et quelque peu embêtantes, c'est juste qu'au moment de la conception de ce projet je ne faisais que débuter en programmation, j'espère que vous comprendrez :)***
- Ouvrir un navigateur, taper **http://localhost/ESSFAR-interaction** pour accéder à la page d'accueil et rentrer les identifiants d'un administrateur (adresse mail et mot de passe)
- Une fois connecté, une page qui devait initialement servir de dashboard (mais cela n'a malheureusement pas été fait) s'affiche, il y'a en outre 3 onglets : **Enregistrer**, **Modifier** et **Réaffecter question**
- Vous l'aurez compris, l'onglet **Enregistrer** permet d'insérer de nouveaux utilisateurs. Rentrez leurs informations, saisissez votre mot de passe d'admin et validez
- Il est ensuite possible, à partir du second onglet, de modifier certaines informations (niveau d'un étudiant, unités d'enseignement rattachées à un enseignant ou à un niveau) ou de supprimer un utilisateur
- L'option **Réaffecter question** permet tout simplement d'assigner une question à un autre enseignant (de la même UE bien évidemment), peut-être parce que l'enseignant sollicité est indisponible ou pour toute autre raison. Les questions non traitées s'affichent sur cette page et l'admin n'a qu'à cliquer sur celle qu'il désire réaffecter, choisir le nouvel enseignant dans la partie droite de l'écran et valider. Un filtre de questions est également disponible à la gauche de l'écran

SI vous vous connectez en tant qu'étudiant, vous pouvez poser vos questions via le boutton dédié. Les questions posées sont visibles sur cette même interface. En cliquant sur une question, son libellé et la réponse éventuelle s'affichent dans l'onglet de droite et un filtre de questions est par ailleurs disponible sur l'onglet de gauche.

L'enseignant connecté a quant à lui un visuel sur les questions qui lui ont été adressées et peut donc y répondre.