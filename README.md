# Projet académique 2019-2020
Une plateforme d'échange entre étudiant.e.s et enseignant.e.s de l'ESSFAR, application web réalisée en juin-juillet 2020 avec des camarades de classe (Audrey Kamga, Donald Happi, Litisia Douanguim, et Patrick Fogaing).

## Vue d'ensemble
**ESSFAR interaction** est une plateforme via laquelle les étudiant.e.s de l'ESSFAR ont la possibilité de **poser des questions et attendre des réponses** de la part de leurs enseignant.e.s. Un ou plusieurs administrateur.trice.s gère.nt le système en y inscrivant les étudiant.e.s et les enseignant.e.s, et en modifiant leurs informations. Ils peuvent par ailleurs, pour une raison ou pour une autre, réassigner une question à un.e autre enseignant.e, supprimer des utilisateur.trice.s, etc.

## Prise en main
A supposer que le dossier **ESSFAR-interaction** du projet se trouve dans **xampp/htdocs**, et que les services **Apache** et **MySQL** de Xampp sont démarrés, les étapes suivantes sont à suivre minutieusement:

*Le script `essfar_interaction.sql` contient quelques insertions dans les différentes tables, en exécutant ce dernier, vouz pouvez skip les 4 prochains tirets et démarrer avec une base de données contenant quelques lignes juste pour vous faire un aperçu.*

- Créez la base de données, en exécutant le script SQL `create.sql` (via *MySQL Workbench*, *phpMyAdmin*, ...)
- Créez un.e administrateur.trice en l'insérant de manière brute dans la base de données (fournir son nom, son prénom, son adresse mail et son mot de passe)
- Insérez également dans la table `niveaux` les différents niveaux des étudiant.e.s
- Remplissez ensuite la table `ues` avec toutes les unités d'enseignement

***Vraiment désolé pour toutes ces manipulations un peu forcées et quelque peu embêtantes, c'est juste qu'au moment de la conception de ce projet je ne faisais que débuter en programmation, j'espère que vous comprendrez :)***

- Ouvrez un navigateur et tapez *http://localhost/ESSFAR-interaction* pour accéder à la page d'accueil et rentrez les identifiants d'un.e administrateur.trice (adresse mail et mot de passe)
- Une fois connecté.e, une page qui devait initialement servir de dashboard (mais cela n'a malheureusement pas été fait) s'affiche, il y'a en outre 3 onglets : **Enregistrer**, **Modifier** et **Réaffecter question**
- Vous l'aurez compris, l'onglet **Enregistrer** permet d'insérer de nouveaux utilisateur.trice.s. Rentrez leurs informations, saisissez votre mot de passe d'admin et validez
- Il est ensuite possible, à partir du second onglet, de modifier certaines informations (niveau d'un.e étudiant.e, unités d'enseignement rattachées à un.e enseignant.e ou à un niveau) ou de supprimer un.e utilisateur.trice
- L'option **Réaffecter question** permet tout simplement d'assigner une question à un.e autre enseignant.e (de la même UE bien évidemment), peut-être parce que l'enseignant.e sollicité.e est indisponible ou pour toute autre raison. Les questions non traitées s'affichent sur cette page et l'admin n'a qu'à cliquer sur celle qu'il.elle désire réaffecter, choisir le.la nouvel.le enseignant.e dans la partie droite de l'écran et valider. Un filtre de questions est également disponible à la gauche de l'écran

Si vous vous connectez en tant qu'étudiant.e, vous pouvez poser vos questions via le boutton dédié. Les questions posées sont visibles sur cette même interface. En cliquant sur une question, son libellé et la réponse éventuelle s'affichent dans l'onglet de droite et un filtre de questions est par ailleurs disponible sur l'onglet de gauche.

L'enseignant.e connecté a quant à lui.elle un visuel sur les questions qui lui ont été adressées et peut donc y répondre.

Bonne chance pour la suite, je reste ouvert à toute éventuelle question !
