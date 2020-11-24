ALTER TABLE DB_SALON_Attendre RENAME TO DB_SALON_Reunions;

ALTER TABLE DB_SALON_Reunions DROP COLUMN Position_Liste;

ALTER TABLE DB_SALON_Reunions ADD Heure_Arrivee INT;

DROP TABLE IF EXISTS DB_SALON_Emplacement;
CREATE TABLE IF NOT EXISTS DB_SALON_Emplacement
(
    Position_X_Emplacement int,
    Position_Y_Emplacement int,
    Couleur_Element varchar(7) DEFAULT "#000000",
	CONSTRAINT PK_Emplacement PRIMARY KEY (Position_X_Emplacement,Position_Y_Emplacement) /*Création de la clef primaire.*/
) ENGINE=InnoDB;

ALTER TABLE DB_SALON_Stand
ADD Categorie_Stand varchar(25),
ADD Information_Stand varchar(255),
ADD Position_X_Emplacement int,
ADD Position_Y_Emplacement int;

ALTER TABLE DB_SALON_Stand
ADD CONSTRAINT FK_Position_Emplacement FOREIGN KEY(Position_X_Emplacement,Position_Y_Emplacement) REFERENCES DB_SALON_Emplacement(Position_X_Emplacement,Position_Y_Emplacement);


ALTER TABLE DB_SALON_Reunions ADD (ID_Avatar_Presentateur INT(11),
FOREIGN KEY (ID_Avatar_Presentateur) REFERENCES DB_SALON_Presentateur(ID_AVATAR));

ALTER TABLE DB_SALON_Reunions ADD Numero_Reunion varchar(25) Unique;



ALTER TABLE DB_SALON_Presentateur ADD API_Visible_Key varchar(30);
ALTER TABLE DB_SALON_Presentateur ADD API_Hidden_Key varchar(50);
ALTER TABLE DB_SALON_Presentateur ADD Numero_Reunion varchar(100);
