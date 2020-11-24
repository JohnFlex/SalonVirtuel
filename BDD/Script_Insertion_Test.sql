INSERT INTO DB_SALON_Emplacement
(Position_X_Emplacement,Position_Y_Emplacement)
VALUES
(1,1),
(1,2),
(1,3),
(2,1),
(2,2),
(2,3),
(3,1),
(3,2),
(3,3);

INSERT INTO DB_SALON_Stand
(Libelle_Stand,Position_X_Emplacement,Position_Y_Emplacement)
VALUES
("The World",1,1),
("Star Platinum",2,1),
("D4C",3,1),
("Starlight Unicorn",2,1),
("Highway to Hell",2,2),
("Killer Queen",3,2);


INSERT INTO DB_SALON_Avatar()VALUES();
INSERT INTO DB_SALON_Utilisateur
(ID_Avatar, Nom_Avatar, MDP_Utilisateur)
VALUES
((SELECT MAX(ID_Avatar) FROM DB_SALON_Avatar), "Dio", "XXX");

INSERT INTO DB_SALON_Avatar()VALUES();INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur)VALUES
((SELECT MAX(ID_Avatar) FROM DB_SALON_Avatar), "Jotaro", "XXX");
INSERT INTO DB_SALON_Avatar()VALUES();INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur)VALUES
((SELECT MAX(ID_Avatar) FROM DB_SALON_Avatar), "Joseph", "XXX");
INSERT INTO DB_SALON_Avatar()VALUES();INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur)VALUES
((SELECT MAX(ID_Avatar) FROM DB_SALON_Avatar), "Josuke", "XXX");
INSERT INTO DB_SALON_Avatar()VALUES();INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur)VALUES
((SELECT MAX(ID_Avatar) FROM DB_SALON_Avatar), "Georges", "XXX");
INSERT INTO DB_SALON_Avatar()VALUES();INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur)VALUES
((SELECT MAX(ID_Avatar) FROM DB_SALON_Avatar), "Cesar", "XXX");


INSERT INTO DB_SALON_Reunions
(ID_Avatar,ID_Stand,Position_Liste)
VALUES
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Dio"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),1),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Jotaro"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),2),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Josuke"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "D4C"),1),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Joseph"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),3),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Georges"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),4),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Cesar"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),5);


SELECT * FROM DB_SALON_Reunions A, DB_SALON_Utilisateur U WHERE A.ID_Avatar = U.ID_Avatar AND Nom_Avatar = "Cesar";

