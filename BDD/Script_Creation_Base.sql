DROP DATABASE IF EXISTS DB_SALON;
CREATE DATABASE IF NOT EXISTS DB_SALON;
USE DB_SALON;


DROP TABLE IF EXISTS Element_Avatar;
CREATE TABLE IF NOT EXISTS Element_Avatar
(
	ID_Element_Avatar INT AUTO_INCREMENT,
	Lien_Avatar varchar(100), /*Va contenir le lien de l'image ou du morceau d'avatar en relatif ou absolu, sera amené à changer en fonction des choix de l'équipe front et design.*/
	CONSTRAINT PK_Element_Avatar PRIMARY KEY (ID_Element_Avatar) /*Création de la clef primaire.*/
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Avatar;
CREATE TABLE IF NOT EXISTS Avatar
(
	ID_Avatar INT AUTO_INCREMENT,
	CONSTRAINT PK_Avatar PRIMARY KEY (ID_Avatar) /*Création de la clef primaire.*/
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Composer;
CREATE TABLE IF NOT EXISTS Composer
(
	ID_Avatar INT,
	ID_Element_Avatar INT,
	CONSTRAINT PK_Composer PRIMARY KEY (ID_Avatar, ID_Element_Avatar), /*Création de la clef primaire.*/
	CONSTRAINT FK_Composer_Avatar FOREIGN KEY (ID_Avatar) REFERENCES Avatar (ID_Avatar),
	CONSTRAINT FK_Composer_Element_Avatar FOREIGN KEY (ID_Element_Avatar) REFERENCES Element_Avatar (ID_Element_Avatar)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Utilisateur;
CREATE TABLE IF NOT EXISTS Utilisateur
(
	ID_Avatar INT,
	Nom_Avatar varchar(100),
	MDP_Utilisateur varchar(100) DEFAULT "",
	CONSTRAINT PK_Utilisateur PRIMARY KEY (ID_Avatar), /*Création de la clef primaire.*/
	CONSTRAINT FK_Utilisateur_Avatar FOREIGN KEY (ID_Avatar) REFERENCES Avatar (ID_Avatar),
	CONSTRAINT UK_Utilisateur UNIQUE (Nom_Avatar)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Activite;
CREATE TABLE IF NOT EXISTS Activite
(
	ID_Activite INT AUTO_INCREMENT,
	Libelle_Activite varchar(50),
	CONSTRAINT PK_Activite PRIMARY KEY (ID_Activite) /*Création de la clef primaire.*/
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Stand;
CREATE TABLE IF NOT EXISTS Stand
(
	ID_Stand INT AUTO_INCREMENT,
	Libelle_Stand varchar(100),
	CONSTRAINT PK_Stand PRIMARY KEY (ID_Stand), /*Création de la clef primaire.*/
	CONSTRAINT UK_Stand UNIQUE (Libelle_Stand)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Attendre;
CREATE TABLE IF NOT EXISTS Attendre
(
	ID_Avatar INT,
	ID_Stand INT,
	Position_Liste INT NOT NULL,
	CONSTRAINT PK_Attendre PRIMARY KEY (ID_Avatar, ID_Stand),
	CONSTRAINT FK_Attendre_Avatar FOREIGN KEY (ID_Avatar) REFERENCES Utilisateur (ID_Avatar),
	CONSTRAINT FK_Attendre_Stand FOREIGN KEY (ID_Stand) REFERENCES Stand (ID_Stand)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Presentateur;
CREATE TABLE IF NOT EXISTS Presentateur
(
	ID_Avatar INT,
	Nom_Avatar varchar(100),
	MDP_Presentateur varchar(100),
	ID_Activite INT,
	ID_Stand INT,
	CONSTRAINT PK_Presentateur PRIMARY KEY (ID_Avatar), /*Création de la clef primaire.*/
	CONSTRAINT FK_Presentateur_Avatar FOREIGN KEY (ID_Avatar) REFERENCES Avatar (ID_Avatar),
	CONSTRAINT FK_Presentateur_Stand FOREIGN KEY (ID_Stand) REFERENCES Stand (ID_Stand),
	CONSTRAINT FK_Presentateur_Activite FOREIGN KEY (ID_Activite) REFERENCES Activite (ID_Activite),
	CONSTRAINT UK_Presentateur UNIQUE (Nom_Avatar)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS LogZoom;
CREATE TABLE IF NOT EXISTS LogZoom
(
	ID_Avatar INT,
	Pseudo_Zoom varchar(100),
	MDP_Zoom varchar(100), /*Il faudra crypter le mot de passe*/
	CONSTRAINT PK_LogZoom PRIMARY KEY (ID_Avatar), /*Création de la clef primaire.*/
	CONSTRAINT FK_LogZoom_Presentateur FOREIGN KEY (ID_Avatar) REFERENCES Presentateur (ID_Avatar)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Avis;
CREATE TABLE IF NOT EXISTS Avis
(
	ID_Avis INT AUTO_INCREMENT,
	ID_Stand INT,
	Libelle_Avis varchar(100),
	CONSTRAINT PK_Avis PRIMARY KEY (ID_Avis), /*Création de la clef primaire.*/
	CONSTRAINT FK_Avis FOREIGN KEY (ID_Stand) REFERENCES Stand (ID_Stand)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Ressource;
CREATE TABLE IF NOT EXISTS Ressource
(
	ID_Ressource INT AUTO_INCREMENT,
	Libelle_Ressource varchar(100),
	Lien_Ressource varchar(100),
	CONSTRAINT PK_Ressource PRIMARY KEY (ID_Ressource) /*Création de la clef primaire.*/
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Administrateur;
CREATE TABLE IF NOT EXISTS Administrateur
(
	ID_Administrateur INT AUTO_INCREMENT,
	Nom_Administrateur varchar(100),
	MDP_Administrateur varchar(100),
	CONSTRAINT PK_Administratrice PRIMARY KEY (ID_Administrateur) /*Création de la clef primaire.*/
)ENGINE=InnoDB;

DROP TABLE IF EXISTS Contenir;
CREATE TABLE IF NOT EXISTS Contenir
(
	ID_Ressource INT,
	ID_Stand INT,
	CONSTRAINT PK_Contenir PRIMARY KEY (ID_Ressource, ID_Stand), /*Création de la clef primaire.*/
	CONSTRAINT FK_Contenir_Ressource FOREIGN KEY (ID_Ressource) REFERENCES Ressource (ID_Ressource),
	CONSTRAINT FK_Contenir_Stand FOREIGN KEY (ID_Stand) REFERENCES Stand (ID_Stand)
) ENGINE=InnoDB;
