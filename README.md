# Memo _Symfony

### Problèmes

* Problème timezone:<br>
Database > Properties > Advanced > serverTimeZone => CET

* Problème phpMyAdmin avec PHP 7.2:<br>
Changer ligne 613 : sudo nano -c /usr/share/phpmyadmin/libraries/sql.lib.php<br>
en ((count($analyzed_sql_results['select_expr']) == 1)

* Comptatibilité avec Apache:<br>
composer require symfony/apache-pack

### Installations/créations

* Installer composer:<br>
php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"<br>
sudo apt install composer<br>
* Vérifier l'installation:<br>
php composer.phar --version)<br>
* Mettre à jour composer:<br>
php composer.phar self-update

* Créer un projet Symfony:<br>
composer create-project symfony/website-skeleton mon_projet

* Désigner un projet du type "Symfony" dans Intellij:<br>
File -> Settings -> Languages & Framework -> PHP -> Symfony

* Fichier de configuration de la BDD:<br>
.env

### Commandes générales

* Lister les commandes disponibles<br>
php bin/console

* Lister les classes en autowiring:<br>
php bin/console debug:autowiring

* Vider le cache:<br>
- prod : php bin/console cache:clear --env=prod --no-debug<br>
- dev  : php bin/console cache:clear

* Lancer le serveur interne de php:<br>
php bin/console server:run<br>
php -S 127.0.0.1:8000 -t public (web debug toolbar enabled)

* Générer un controller
php bin/console make:controller

### Git

* Initialiser dépôt Git:<br>
echo "# HowToDo_Symfony" >> README.md<br>
git init<br>
git add *<br>
git commit -m "First commit"<br>
git remote add origin https://github.com/StephSako/__________.git<br>
git push -u origin master

### Base de données

* Créer une BDD: (modifier infos BDD dans .env au préalable)<br>
php bin/console doctrine:database:create

* Générer une Entity de la BDD:<br>
php bin/console make:entity

* Générer/mettre à jour les entités d'une BDD existante:<br>
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

* Générer Setters/Getters des Entities:<br>
php bin/console make:entity --regenerate

* Générer Entity's Repository:<br>
1) Ajouter **@ORM\Entity(repositoryClass="App\Repository\MyClassRepository")** dans l'annotation de l'entité<br>
2) **php bin/console make:entity --regenerate**

* Installer le composant fixtures:
composer require orm-fixtures --dev

* Créer une fixture:
php bin/console make:fixtures

* Lancer une fixture:
php bin/console doctrine:fixtures:load --append

### Formulaires

* Générer un formulaire (Type):
php bin/console make:form

### Déploiement
> rsync -av ./ user@server:~/www/{...}/ --include=public/build --include=vendor--exclude-from=.gitignore --exclude=".*"

### SASS
* Déployer SASS
./dart-sass/sass style.scss style.css

