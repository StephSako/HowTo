
## Projet personnel réalisé avec le Framework PHP Symfony4 et librairie CSS Materialize

## A quoi ce site sert-il ?

commentfaire.ddns.net permet à tous les internautes de pouvoir partager leurs connaissances dans des catégories diverses et variées comme l'informatique, le sport ou encore le life style. Ainsi, un système de commentaires a été mis en place permettant aux autres utilisateurs de pouvoir donner leur avis sur le contenu, liker, signaler le contenu s'il ne respecte pas les règles ou envoyer une suggestion directement au créateur du tutoriel.

Ils ont également la possibilité de créer des forums afin de lancer des discussions ou des débats avec la communauté.

#### Listing

Voici les pages principales du site, listant les tutoriels et forums avec un système de pagination.
Deux panneaux latéraux listent toutes les catégories disponibles ainsi que les 8 tutoriels et forums les plus récents.

<p align="center"><image listing tutoriels></p>
<p align="center"><image listing forums></p>

#### Navbar

Différentes fonctionnalités sont disponibles dans la navbar :
	* Accéder à la page des tutoriels et des forums
	* Accéder à son compte
	* Rechercher un titre de tutoriel, forum ou nom d'un utilisateur à partir d'un mot clef

<p align="center"><img src="https://image.noelshack.com/fichiers/2019/36/1/1567432030-navbar.png"></p>

	* Si connecté en tant qu'administrateur, accès au CRUD
	* Se déconnecté
	

#### Création

Il est possible de créer un tutoriel ou un forum à l'aide d'un bouton flottant.
<p align="center"><image bouton flottant></p>

Il permet alors d'accéder aux formulaires de création des posts :
Pour les tutoriels, il est possible d'imager ces propos par une photo (fonctionnalité permettant d'uploader plusieurs images en cours de développement ...).

<p align="center"><image formualire creation tutoriel></p>
<p align="center"><image formualire creation forums></p>

### Profils

#### Utilisateurs

Afin de pouvoir poster, répondre et intéragir pleinement avec le site, les utilisateurs devront créer un compte qu'ils pourront alors gérer : modification des informations personnelles (modification du mot de passe en travaux ...), visionnage de ses tutoriels, forums et commentaires postés, et suggestions reçues d'autres utilisateurs.

<p align="center"><image compte></p>
<p align="center"><image compte infos persos></p>
<p align="center"><image forums></p>

Par conséquent, si le visiteur n'est pas anthentifié, des fonctionnalités lui seront alors bloquées.
<p align="center"><image not connected></p>


#### Administrateurs

Quant aux administrateurs, ils ont l'accès à un CRUD / back-office leur permettant de gérer les posts, utilisateurs, signalement enregistrés et contacts de visiteurs leur ayant posé question.

<p align="center"><image back office></p>

#### Responsive

Le site est responsive grâce au système de grille de la librairie CSS Materialize.

<p align="center"><image responsive></p>
