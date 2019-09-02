DROP TABLE IF EXISTS FORUM_REPORTING;
DROP TABLE IF EXISTS TUTORIAL_REPORTING;
DROP TABLE IF EXISTS REPORTING_LABEL;
DROP TABLE IF EXISTS INFORMATIONS;
DROP TABLE IF EXISTS SUGGESTION_FORUM;
DROP TABLE IF EXISTS SUGGESTION_TUTORIAL;
DROP TABLE IF EXISTS LIKE_TUTORIAL;
DROP TABLE IF EXISTS LIKE_FORUM;
DROP TABLE IF EXISTS ANSWER_FORUM;
DROP TABLE IF EXISTS ANSWER_TUTORIAL;
DROP TABLE IF EXISTS TUTORIAL;
DROP TABLE IF EXISTS FORUM;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS USER;

CREATE TABLE USER(
	id INT(10) NOT NULL AUTO_INCREMENT,
	filename VARCHAR(255) NOT NULL,
    	lastname VARCHAR(30) NOT NULL,
	firstname VARCHAR(30) NOT NULL,
	mail VARCHAR(45) NOT NULL,
	password VARCHAR(100) NOT NULL,
	is_Admin BOOLEAN NOT NULL,
	updated_at DATETIME,
	CONSTRAINT id_USER_PK PRIMARY KEY (id)
);

CREATE TABLE CATEGORY(
	id INT(2) NOT NULL AUTO_INCREMENT,
   	label VARCHAR(20) NOT NULL,
	color TINYTEXT NOT NULL,
	CONSTRAINT id_CATEGORY_Pk PRIMARY KEY (id)
);

CREATE TABLE TUTORIAL(
	id INT(10) AUTO_INCREMENT,
	title TEXT(100) NOT NULL,
	filename VARCHAR(255),
	id_USER INT(25) NOT NULL,
	content TEXT(65535) NOT NULL,
	dateCreation DATETIME NOT NULL,
	id_CATEGORY INT(2) NOT NULL,
	updated_at DATETIME,
	CONSTRAINT id_TUTORIAL_Pk PRIMARY KEY (id),
	CONSTRAINT id_CATEGORY_Fk FOREIGN KEY (id_CATEGORY) REFERENCES CATEGORY(id),
	CONSTRAINT id_USER_T_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE FORUM(
	id INT(10) AUTO_INCREMENT,
	id_USER INT(25) NOT NULL,
	content TEXT(65535) NOT NULL,
	dateCreation DATETIME NOT NULL,
	title TEXT(100) NOT NULL,
	CONSTRAINT id_FORUM_Pk PRIMARY KEY (id),
	CONSTRAINT id_USER_F_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE ANSWER_FORUM(
	id_FORUM INT(10) NOT NULL,
   	id INT(10) NOT NULL AUTO_INCREMENT,
	id_USER INT(25) NOT NULL,
	dateResponse DATETIME NOT NULL,
	content TEXT(65535) NOT NULL,
	CONSTRAINT id_ANSWER_FORUM_Pk PRIMARY KEY (id),
	CONSTRAINT id_FORUM_A_Fk FOREIGN KEY (id_FORUM) REFERENCES FORUM(id),
	CONSTRAINT id_USER_ANSWERER_F_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE ANSWER_TUTORIAL(
	id_TUTORIAL INT(10) NOT NULL,
   	id INT(10) NOT NULL AUTO_INCREMENT,
	id_USER INT(25) NOT NULL,
	dateResponse DATETIME NOT NULL,
	content TEXT(65535) NOT NULL,
	CONSTRAINT id_ANSWER_TUTORIAL_Pk PRIMARY KEY (id),
	CONSTRAINT id_TUTORIAL_A_Fk FOREIGN KEY (id_TUTORIAL) REFERENCES TUTORIAL(id),
	CONSTRAINT id_USER_ANSWERER_T_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE LIKE_TUTORIAL(
	id INT(10) NOT NULL AUTO_INCREMENT,
	id_TUTORIAL INT(10) NOT NULL,
	id_USER INT(25) NOT NULL,
	CONSTRAINT id_LIKE_TUTORIAL_Pk PRIMARY KEY (id),
	CONSTRAINT id_TUTORIAL_LIKE_Fk FOREIGN KEY (id_TUTORIAL) REFERENCES TUTORIAL(id),
	CONSTRAINT id_USER_T_LIKE_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE LIKE_FORUM(
	id INT(10) NOT NULL AUTO_INCREMENT,
	id_FORUM INT(10) NOT NULL,
	id_USER INT(25) NOT NULL,
	CONSTRAINT id_LIKE_FORUM_Pk PRIMARY KEY (id),
	CONSTRAINT id_FORUM_LIKE_Fk FOREIGN KEY (id_FORUM) REFERENCES FORUM(id),
	CONSTRAINT id_USER_F_LIKE_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE SUGGESTION_TUTORIAL(
	id INT(10) NOT NULL AUTO_INCREMENT,
	id_TUTORIAL INT(10) NOT NULL,
	id_USER INT(25) NOT NULL,
	content TEXT(65535) NOT NULL,
	CONSTRAINT id_SUGGESTION_Pk PRIMARY KEY (id),
	CONSTRAINT id_TUTORIAL_ST_Fk FOREIGN KEY (id_TUTORIAL) REFERENCES TUTORIAL(id),
	CONSTRAINT id_USER_T_from_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE SUGGESTION_FORUM(
	id INT(10) NOT NULL AUTO_INCREMENT,
	id_FORUM INT(10) NOT NULL,
	id_USER INT(25) NOT NULL,
	content TEXT(65535) NOT NULL,
	CONSTRAINT id_SUGGESTION_Pk PRIMARY KEY (id),
	CONSTRAINT id_FORUM_SF_Fk FOREIGN KEY (id_FORUM) REFERENCES FORUM(id),
	CONSTRAINT id_USER_F_from_Fk FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE INFORMATIONS(
	id INT(10) NOT NULL AUTO_INCREMENT,
	content TEXT(65535) NOT NULL,
	id_USER INT(25) NOT NULL,
	dateDemande DATETIME NOT NULL,
	CONSTRAINT id_INFORMATIONS_Pk PRIMARY KEY (id),
	CONSTRAINT id_USER_Infos FOREIGN KEY (id_USER) REFERENCES USER(id)
);

CREATE TABLE REPORTING_LABEL(
	id int(10) NOT NULL AUTO_INCREMENT,
 	label tinytext NOT NULL,
	CONSTRAINT REPORTING_LABEL_Pk PRIMARY KEY (id)
);

CREATE TABLE FORUM_REPORTING(
  id int(10) NOT NULL AUTO_INCREMENT,
  id_FORUM int(10) NOT NULL,
  id_USER int(25) NOT NULL,
  id_REPORTING_LABEL int(10) NOT NULL,
  CONSTRAINT id_FORUM_REPORTING_Pk PRIMARY KEY (id),
  CONSTRAINT id_FORUM_REPORT_Fk FOREIGN KEY (id_FORUM) REFERENCES FORUM(id),
  CONSTRAINT id_USER_REPORT_FOR_Fk FOREIGN KEY (id_USER) REFERENCES USER(id),
  CONSTRAINT id_REPORTING_LABEL_FOR_Fk FOREIGN KEY (id_REPORTING_LABEL) REFERENCES REPORTING_LABEL(id)
);

CREATE TABLE TUTORIAL_REPORTING(
  id int(10) NOT NULL AUTO_INCREMENT,
  id_TUTORIAL int(10) NOT NULL,
  id_USER int(25) NOT NULL,
  id_REPORTING_LABEL int(10) NOT NULL,
  CONSTRAINT id_TUTORIAL_REPORTING_Pk PRIMARY KEY (id),
  CONSTRAINT id_TUTORIAL_REPORT_Fk FOREIGN KEY (id_TUTORIAL) REFERENCES TUTORIAL(id),
  CONSTRAINT id_USER_REPORT_TUTO_Fk FOREIGN KEY (id_USER) REFERENCES USER(id),
  CONSTRAINT id_REPORTING_LABEL_TUTO_Fk FOREIGN KEY (id_REPORTING_LABEL) REFERENCES REPORTING_LABEL(id)
);

INSERT INTO CATEGORY (label, color) VALUES ('Informatique', 'cyan lighten-3'), ('Électronique', 'blue lighten-3'), ('Musique', 'yellow lighten-3'), ('Cuisine', 'brown lighten-3'), ('Life Style', 'pink lighten-3'), ('Jeux Video', 'red lighten-3'), ('Art', 'blue-grey lighten-3'), ('Sport', 'green lighten-3'), ('Inclassable', 'orange lighten-3');

INSERT INTO USER (lastname, firstname, mail, password, filename, is_Admin) VALUES
('MACHON', 'Theo', 'machon@et.esiea.fr', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'machon_theopoulos_1.jpg', TRUE),
('SAKOVITCH', 'Stephen', 'sakovitch@et.esiea.fr', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'sakovitch_stephen_2.jpeg', TRUE),
('OUTEMZABET', 'Nesrine', 'outemzabet@et.esiea.fr', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'outemzabet_nesrine_3.jpg', TRUE),
('PINSARD', 'Florian', 'pinsard@et.esiea.fr', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'pinsard_florian_4.jpg', TRUE),
('BON', 'Jean', 'jean.bon@gmail.com', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'default.png', FALSE),
('REUS', 'Marco', 'marco.reus@gmail.com', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'default.png', FALSE),
('TAIE', 'Flavien', 'flavien.taie@gmail.com', '$2a$12$mLoXQx60nIAywIhAeP3OYO20/fqTxAAzTKP7Qws2LQONYXiGqSS46', 'taie_flavien_7.jpeg', FALSE);

INSERT INTO TUTORIAL (id_USER, content, dateCreation, id_CATEGORY, title) VALUES
(1, 'L\'objectif de ce projet est de programmer en langage C, un jeu de bataille de tanks. Le but est d\'éliminer tous les tanks ennemis tout en protégeant le petit oiseau (Titi).', '1998-09-24', 2, 'Premier tutoriel'),
(3, 'La FIG 1 montre un exemple de jeu réalisé avec un affichage sur le terminal.', '1998-10-25', 4, 'Installer Ubuntu'),
(2, 'Sur ce plan de jeu, on peut distinguer : un tank jaune qui est le tank appartenant au joueur.', '2018-11-23', 6, 'Pécher a la cuillere'),
(5, 'un petit oiseau (Titi), encerclé par des briques rouges. Notre mission consiste à protéger cet oiseau des obus de l\'ennemi.', '2018-03-11', 1, 'Tutoriel toto'),
(2, 'des briques blanches, qui sont dures et cassables uniquement que par des tirs de tanks ultra-blindés', '2018-05-21', 1, 'Je sais plus'),
(7, 'Vous pouvez dessiner vos propres modeles de tanks (fortement conseillé)', '2018-12-05', 8, 'Demarrer sa voiture'),
(4, 'Ce plan de jeu se trouve à la base dans un fichier \'.txt\' y compris le décor. Pour alléger l\'affichage, le plan doit etre figé sur l\'écran afin d\'éviter de recharger ce dernier à chaque fois pour ne pas ralentir l\'exécution.', '2018-07-09', 2, 'Eteindre un feu de camp');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(5, 'De l\'art délicat de relancer une franchise. Parler de Star Wars, c\'est s\'attaquer à un mythe face auquel la prudence est de mise. Objet de culte sans égal, la saga a souffert d\'une prélogie décevante pour les fans, ce qui poussera George Lucas à arrêter les frais et vendre Lucasfilm à Disney en octobre 2012. Ils annoncent par la même occasion un 7e film, aux alentours de 2015.

C\'est en revenant au plus près de la source originelle que JJ va insuffler à la nouvelle trilogie qu\'il commence le souffle de s\'émanciper de ses augustes aînés.
Comment relancer une franchise lorsque son créateur n\'est plus là ? C\'est tout le dilemme qui incombait à JJ Abrams. En effet, le réalisateur new-yorkais devait trouver le compromis entre tradition et modernité, entre faire de son Star Wars une oeuvre à part entière mais qui trouve naturellement sa place dans la saga. Le choix de reprendre une structure calquée sévèrement sur le premier Star Wars n\'est donc pas anodin : comme un renouveau, JJ va proposer une réécriture des bases afin de faire le lien entre les deux univers. C\'est en revenant au plus près de la source originelle que JJ va insuffler à la nouvelle trilogie qu\'il commence le souffle de s\'émanciper de ses augustes aînés.

C\'est une vraie volonté de réconciliation que propose Star Wars, réunissant toutes les générations vers un futur commun.
Le manque de risque du film lui fut reproché. Pourtant, au regard des événements passés, cela semble cohérent. Là où la prélogie s\'était principalement ratée, c\'est en laissant de côté les fans de la première heure par ces trop nombreux changements (Star Wars 8 sera la preuve finale que le changement dans cette saga est une chose à proscrire aux yeux des fans). C\'est une vraie volonté de réconciliation que propose Star Wars, réunissant toutes les générations vers un futur commun.

Rey […] constitue un des personnages les plus emballants de l\'industrie du blockbuster.
Outre cet hommage, il faut quand même que le film ne se contente pas de la vague copie. C\'est là que réside le paradoxe ; les anciens ne sont finalement que prétexte, quand ces derniers ne se contente pas de juste toucher un chèque (ah, Harrison…), les nouveaux eux construisent leur légende. Si l\'écriture du métrage est stéréotypée, on peut notamment ressortir une Rey qui constitue un des personnages les plus emballants de l\'industrie du blockbuster.

Que reste-t-il alors ? Hommage agréable, qui convient aux fans et aux néophytes, c\'est un pari réussi que de relancer la machine pour Abrams. Simple, efficace, il ouvre une nouvelle ère Star Wars, en réalisant comme il faut les ponts avec ses origines. De l\'art délicat de relancer une franchise, JJ aura réussi à offrir un des blockbusters les plus agréables de ces dernières années.

Et vous, qu\'en pensez vous ?', '2018-07-09', 'La critique cinéma : Star Wars VII');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(4, 'De belles surprises dans les prises de paroles, des élèves qui habituellement sont passifs ont eu envie de prendre part au débat ; des efforts d\'expression orale, de vrais souvenirs de cours d\'histoire. Un point rassurant : il a été pour eux très difficile d\'être les avocats du diable. En tant qu\'observateur j\'ai dû donner un petit coup de main pour que les choses se fassent plus naturellement. Du côté justicier loyal pas de souci pour argumenter et un bel état d\'esprit a émergé de ces réflexions.

L\'expérience est à améliorer pour qu\'elle soit un peu moins chronophage et pour engager davantage les élèves dans la prise de parole. Mais pour une première, l\'expérience est plutôt concluante, et il semblerait que le cloisonnement habituel entre les disciplines se soit rompu, au moins temporairement.', '2018-07-09', 'Objectifs pédagogiques disciplinaires et transversaux');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(7, 'Quel est, pour vous, le meilleur système d\'exploitation pour développeur ? Windows ? MacOSX ? Linux ? Quelle distribution de Linux ?','2018-07-09', 'Le meilleur OS ?');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(3, 'Quel instrument de musique pour débutant ? Piano ? Guitare ? Armonica ?', '2018-07-09', 'Instrument pour débutant');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(3, 'Faut-il interdire le stationnement des véhicules aux étudiants ?', '2018-07-09', 'Stationnement parking à Ivry');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(2, 'Pensez-vous que Mickael Jackson est mort ? :/', '2018-07-09', 'Théorie Michael Jackson');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(1, 'Nouvelle regles sur le site :

Tout comportement injurieux ou irrespectueux sera sanctionné par un bannissement définitif.', '2018-07-09', 'Nouvelle modération');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(2, 'Est-ce une bonne chose de nos jours de devenir une célébrité d\'Internet ?', '2018-09-15', 'Se faire connaitre sur Internet');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(6, 'Que pensez-vous du dernier Raspberry Pi 4 ?', '2018-04-19', 'Raspberry Pi 4 B');

INSERT INTO FORUM (id_USER, content, dateCreation, title) VALUES
(5, 'L\'école doit-elle revoir le règement intérieur concernant la validation des notes ?', '2018-11-16', 'Validation des notes');

/* ANSWER TUTORIAL */

INSERT INTO ANSWER_TUTORIAL (id_USER, id_TUTORIAL, dateResponse, content) VALUES
(1, 1, '2017-10-02', 'J\'aime Ubuntu'),
(7, 1, '2018-12-03', 'J\'installe cela ce soir'),
(5, 1, '2018-10-24', 'Interessant'),
(6, 1, '2018-10-03', 'Ce tutoriel est bien fait'),
(2, 1, '2018-03-02', 'Petit canard dans l\'eau'),
(1, 1, '2018-11-04', 'Ce tutoriel est pratique'),

(1, 2, '2016-02-23', 'J\'aime Ubuntu'),
(7, 2, '2015-03-12', 'J\'installe cela ce soir'),
(5, 2, '2019-02-17', 'Interessant ...'),
(2, 2, '2015-03-16', 'Bof'),
(2, 2, '2016-04-09', 'Petit canard dans l\'eau'),
(1, 2, '2019-12-25', 'Ce tutoriel est pratique'),

(6, 3, '2014-06-11', 'Inutile, fascinant'),
(4, 3, '2013-04-15', 'J\'ai promis d\'etre hardcore'),
(3, 3, '2018-10-24', 'K double napalm'),
(2, 3, '2018-07-24', 'Je vais essayer ce turoriel'),
(2, 3, '2018-03-02', 'Bon travail les pelos'),
(5, 3, '2018-11-04', 'Ce soir c\'est match !!'),

(6, 4, '2018-11-05', 'Inutile, fascinant'),
(4, 4, '2018-12-03', 'J\'ai promis d\'etre hardcore'),
(3, 4, '2018-10-24', 'K double napalm'),
(2, 4, '2018-07-24', 'Je vais essayer ce turoriel'),
(2, 4, '2018-03-02', 'Bon travail les pelos'),
(5, 4, '2018-11-04', 'Ce soir c\'est match !!'),

(1, 5, '2018-11-05', 'J\'aime Ubuntu'),
(7, 5, '2018-12-03', 'J\'installe cela ce soir'),
(5, 5, '2018-10-24', 'Interessant ...'),
(3, 5, '2018-07-24', 'LOL ceci est genial'),
(2, 5, '2018-03-02', 'Petit canard dans l\'eau'),
(1, 5, '2018-11-04', 'Ce tutoriel est pratique'),

(6, 6, '2018-11-05', 'Inutile, fascinant'),
(4, 6, '2018-12-03', 'J\'ai promis d\'etre hardcore'),
(3, 6, '2018-10-24', 'K double napalm'),
(2, 6, '2018-07-24', 'Je vais essayer ce turoriel'),
(2, 6, '2018-03-02', 'Bon travail les pelos'),
(5, 6, '2018-11-04', 'Ce soir c\'est match !!'),

(1, 7, '2018-11-05', 'J\'aime Ubuntu'),
(7, 7, '2018-12-03', 'J\'installe cela ce soir'),
(5, 7, '2018-10-24', 'Interessant ...'),
(3, 7, '2018-07-24', 'LOL ceci est genial'),
(2, 7, '2018-03-02', 'Petit canard dans l\'eau'),
(1, 7, '2018-11-04', 'Ce tutoriel est pratique XDDDDDDDDD');

/* ANSWER FORUM */

INSERT INTO ANSWER_FORUM (id_USER, id_FORUM, dateResponse, content) VALUES
(1, 1, '2018-10-03', 'Je n\'ai pas vu ce film :/ ...'),
(5, 1, '2014-11-16', 'J\'en aie entendu que du bien.'),
(6, 1, '2015-09-04', 'Excellente analyse merci !'),
(4, 1, '2018-06-01', 'C\'est dur de comprendre'),
(3, 1, '2019-02-14', 'La fin est assez décevante'),
(2, 1, '2018-09-15', 'Il faut demander au acteurs eux-mêmes.'),
(4, 1, '2017-10-14', 'Le réalisateur doit être d\'accord avec vous.'),

(1, 3, '2017-06-16', 'Pour un développeur, une distribution Linux est adaptée.'),
(5, 3, '2019-04-16', 'Windows est indispensable !'),
(6, 3, '2015-07-18', 'Kubuntu est une distro légère.'),
(4, 3, '2014-03-14', 'MacOSX pour les designer !'),
(3, 3, '2017-05-19', 'Linux >>>>>'),
(2, 3, '2016-01-02', 'Je pense qu\'un Dual Boot Windows/Debian est parfait !!!'),
(4, 3, '2018-11-04', 'Je n\'ai pas d\'avis car cela dépend de chacun ...'),

(1, 2, '2017-12-13', 'C\'est une bonne découverte pour les enfants !'),
(5, 2, '2015-01-15', 'Super outil'),
(6, 2, '2016-02-18', 'Les textes ne sont pas assez développés'),
(4, 2, '2018-04-17', 'Merci !'),
(2, 2, '2015-05-17', 'Ce sont des documents rares !'),

(1, 4, '2018-12-25', 'L\'armonica ??? XD'),
(5, 4, '2015-06-17', 'Le piano est difficile à apprendre'),
(6, 4, '2016-10-24', 'La guitare est un instrument classe ...'),

(1, 5, '2018-02-19', 'C\'est compliqué de se stationner à l\'école ...'),
(5, 5, '2018-10-07', 'Créons alors de nouvelles places de parking'),
(6, 5, '2018-08-08', 'Je suis d\'accord, pour les professeurs.'),
(4, 5, '2018-07-26', 'La plupart des place dehors sont payantes :/'),

(1, 6, '2016-04-18', 'Nous ne saurons jamais ... c\'est un mystère !'),
(5, 6, '2016-11-28', 'Il est mort en 2009 officiellement par la police ... plus d\'espoir !'),
(6, 6, '2013-02-25', 'Je pense qu\'il reviendra dans quelques années !!!'),

(4, 8, '2018-07-24', 'C\'est difficile d\'être anonyme après cela !'),
(3, 8, '2018-08-25', 'Il n\'est pas possible d\'être tranquille dans la rue.'),
(2, 8, '2018-06-29', 'Cela me plairaît bien !'),
(4, 8, '2018-03-15', 'Beaucoup de personnes regrettent de nos jours !'),

(4, 9, '2018-07-24', 'C\'est super il sera davantage performant !'),
(3, 9, '2018-08-25', 'Un Raspberry Pi 3B+ est suffisant pour héberger son site web !! La preuve :)'),
(2, 9, '2018-06-29', 'Je vais l\'acheter tout de suite je ne savais pas !! XD'),

(1, 10, '2017-05-28', 'Il doit être plus sévère'),
(5, 10, '2018-10-29', 'Le directeur est juste !'),
(6, 10, '2018-06-14', 'Je ne le changerai pas personnellement.'),
(4, 10, '2018-07-24', 'Il sera revu pour les étudiants sérieux !');

INSERT INTO LIKE_TUTORIAL (id_USER, id_TUTORIAL) VALUES (4,6), (7,4), (5,5),
(3,1), (3,2), (3,3), (3,4), (3,5), (3,6), (3,7), (2,1), (2,2), (2,3), (2,4), (2,5), (2,6), (2,7);

INSERT INTO LIKE_FORUM (id_USER, id_FORUM) VALUES
(1,1), (1,4), (4,6), (7,4), (5,5), (3,1), (3,2), (3,3),
(3,4), (3,5), (3,6), (3,7), (2,1), (2,2), (2,3), (2,4), (2,5), (2,6), (2,7);

INSERT INTO SUGGESTION_FORUM (id_USER, id_FORUM, content) VALUES
(1,6,'Tu devrais être moins mystérieux.'),
(3,8,'La guitare doit etre tenu a gauche.'),
(4,9,'Le spin est lifte normalement.'),
(4,1,'Je te conseille de faire ta representation a Paris.'),
(5,2,'Ameliore ton orthographe.'),
(6,3,'Tu devrais mettre ta partition systeme a 55 GO.'),
(7,3,'Utilise Ubuntu ... Linux >>>>'),
(1,4,'Rachete un cable cela serait judicieux');

INSERT INTO SUGGESTION_TUTORIAL (id_USER, id_TUTORIAL, content) VALUES
(1,3,'Ameliore ton vocabulaire technique'),
(4,5,'Le plan devrait etre mieux realise');

INSERT INTO INFORMATIONS (content, id_USER, dateDemande) VALUES
('Bonjour. Pouvez-vous me contacter demain s\'il vous plait ? Merci.', 5, '2018-11-24'),
('Quels sont vos noms ?', 6, '2019-02-25'),
('Dans quelle ville etes-vous installes ?', 7, '2015-04-29');

INSERT INTO REPORTING_LABEL (label) VALUES
('Contenu à caractère sexuel'),
('Contenu violent ou abject'),
('Contenu offensant ou haineux'),
('Actes dangereux et pernicieux'),
('Maltraitance d\'enfants'),
('Incitation au terrorisme'),
('Spam ou contenu trompeur'),
('Non-respect de mes droits'),
('Problème relatif aux sous-titres');

INSERT INTO FORUM_REPORTING (id_FORUM, id_USER, id_REPORTING_LABEL) VALUES
(1, 2, 3),
(3, 1, 1),
(4, 5, 7),
(8, 4, 5),
(5, 3, 9);

INSERT INTO TUTORIAL_REPORTING (id_TUTORIAL, id_USER, id_REPORTING_LABEL) VALUES
(2, 1, 8),
(5, 1, 4),
(4, 2, 5),
(1, 6, 1),
(3, 2, 2);
