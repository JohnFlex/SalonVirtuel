INSERT INTO DB_SALON_Stand
(Libelle_Stand)
VALUES
("The World"),
("Star Platinum"),
("D4C"),
("Starlight Unicorn"),
("Highway to Hell"),
("Killer Queen");


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


INSERT INTO DB_SALON_Attendre
(ID_Avatar,ID_Stand,Position_Liste)
VALUES
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Dio"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),1),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Jotaro"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),2),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Josuke"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "D4C"),1),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Joseph"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),3),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Georges"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),4),
((SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = "Cesar"),(SELECT ID_Stand FROM DB_SALON_Stand WHERE Libelle_Stand = "The World"),5);


SELECT * FROM DB_SALON_Attendre A, DB_SALON_Utilisateur U WHERE A.ID_Avatar = U.ID_Avatar AND Nom_Avatar = "Cesar";