ALTER TABLE DB_SALON_Attendre RENAME TO DB_SALON_Reunions;

ALTER TABLE DB_SALON_Reunions DROP COLUMN Position_Liste;

ALTER TABLE DB_SALON_Reunions ADD Heure_Arrivee Time;

ALTER TABLE DB_SALON_Reunions ADD Numero_Reunion varchar(25) Unique;

DROP TABLE IF EXISTS DB_SALON_Stand_Element;
CREATE TABLE IF NOT EXISTS DB_SALON_Stand_Element
(
	ID_Stand_Element INT AUTO_INCREMENT,
    Nom_Element varchar(15),
    Couleur_Element varchar(7),
	CONSTRAINT PK_Stand_Element PRIMARY KEY (ID_Stand_Element) /*Création de la clef primaire.*/
) ENGINE=InnoDB;

DROP TABLE IF EXISTS DB_SALON_Emplacement;
CREATE TABLE IF NOT EXISTS DB_SALON_Emplacement
(
    Position_X_Emplacement int,
    Position_Y_Emplacement int,
    ID_Mur_Gauche int,
    ID_Mur_Droite int,
    ID_Sol int;
	CONSTRAINT PK_Emplacement PRIMARY KEY (Position_X_Emplacement,Position_Y_Emplacement) /*Création de la clef primaire.*/
    CONSTRAINT FK_Mur_Gauche FOREIGN KEY(ID_Mur_Gauche) REFERENCES DB_SALON_Stand_Element(ID_Stand_Element),
    CONSTRAINT FK_Mur_Droite FOREIGN KEY(ID_Mur_Droite) REFERENCES DB_SALON_Stand_Element(ID_Stand_Element),
    CONSTRAINT FK_Sol FOREIGN KEY(ID_Sol) REFERENCES DB_SALON_Stand_Element(ID_Stand_Element);
) ENGINE=InnoDB;

ALTER TABLE DB_SALON_Stand
ADD Categorie_Stand varchar(25),
ADD Information_Stand varchar(255),
ADD Position_X_Emplacement int,
ADD Position_Y_Emplacement int;

ALTER TABLE DB_SALON_Stand
ADD CONSTRAINT FK_Position_Emplacement FOREIGN KEY(Position_X_Emplacement,Position_Y_Emplacement) REFERENCES DB_SALON_Emplacement(Position_X_Emplacement,Position_Y_Emplacement);