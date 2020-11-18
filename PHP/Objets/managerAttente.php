<?php
require_once("objAttente.php");
require_once("objUtilisateur.php");
require_once("objStand.php");

class managerAttente
{
	//Membres privés
	private $db;

	//Fonction membres
	//Le hydrate (Ou le constructeur)
	public function __construct($_db)
	{
		$this->setDb($_db);
	}

	//Le destructeur
	public function __destruct()
	{
		echo "<script>console.log(\"Destruction de l'élement\")</script>";
	}


	//Les getters
	public function getDb()
	{
		return $this->db;
	}

	//Les setters
	public function setDb($conn)
	{
		$this->db = $conn;
	}


	//Autres
	public function __toString()
	{
		return "Database=".$this->getDb();
	}

	public function insertAttente(Attente $A)
	//BUT : Insérer une personne dans une liste d'attente d'un stand
	//ENTREE : Un objet Attente
	//SORTIE : /
	{
		$currentTime = time();

		$req = "INSERT INTO DB_SALON_Reunions(ID_Avatar, ID_Stand, Heure_Arrivee) VALUES (:AVATAR, :STAND, :TEMPS)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":AVATAR", $A->getIdAvatar(), PDO::PARAM_INT);
			$stmt->bindValue(":STAND", $A->getIdStand(), PDO::PARAM_INT);
			$stmt->bindValue(":TEMPS", $currentTime, PDO::PARAM_INT);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function deleteAttentesByStand(Stand $S)
	//BUT : Supprimer la liste d'attente d'un stand en entier
	//ENTREE : Un objet Stand
	//SORTIE : /
	{
		$req = "DELETE FROM DB_SALON_Reunions WHERE ID_Stand = :STAND";

		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":STAND", $S->getIdStand(), PDO::PARAM_INT);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function deleteAttenteByUtilisateur(Utilisateur $U)
	//BUT : Supprimer une personne dans une liste d'attente d'un stand
	//ENTREE : Un objet Utilisateur
	//SORTIE : /
	{
		$req = "DELETE FROM DB_SALON_Reunions WHERE ID_Avatar = (SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = :NOM)";

		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $U->getNom(), PDO::PARAM_STR);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectAttenteByAvatar(Utilisateur $U)
	//BUT : Obtenir la position dans la liste d'attente d'un utilisateur, ainsi que le stand pour lequel il patiente
	//ENTREE : Un objet Utilisateur
	//SORTIE : Un objet Attente
	{
		$req = "SELECT A.ID_Avatar, A.ID_Stand, A.Heure_Arrivee FROM DB_SALON_Reunions A, DB_SALON_Utilisateur U WHERE A.ID_Avatar = U.ID_Avatar AND Nom_Avatar = :AVATAR";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":AVATAR", $U->getNom(), PDO::PARAM_STR);

			$stmt->execute();

			$A = new Attente;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];
				
				$tab = array(
					"IdAvatar" => $valueStmt['ID_Avatar'],
					"IdStand" => $valueStmt['ID_Stand'],
					"Position" => $valueStmt['Heure_Arrivee']
					);
			}else{
				$tab = array(
					"IdAvatar" => "",
					"IdStand" => "",
					"Position" => ""
					);
			}

			$A->hydrate($tab);

			return $A;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectAttentesByStand(Stand $S)
	//BUT : Obtenir la liste d'attente d'un stand en entier
	//ENTREE : Un objet Stand
	//SORTIE : La liste d'attente
	{
		$req = "SELECT * FROM DB_SALON_Reunions A, DB_SALON_Stand S WHERE A.ID_Stand = S.ID_Stand AND Libelle_Stand = :STAND ORDER BY Heure_Arrivee";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":STAND", $S->getLibelle(), PDO::PARAM_STR);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectFirstUtilisateurByStand(Stand $S)
	//BUT : Obtenir la première personne dans liste d'attente d'un stand, puis le supprime dans la file d'attente
	//ENTREE : Un objet Stand
	//SORTIE : Un objet Utilisateur
	{
		$req = "SELECT Nom_Avatar FROM DB_SALON_Utilisateur U, DB_SALON_Reunions A, DB_SALON_Stand S WHERE U.ID_Avatar = A.ID_Avatar AND A.ID_Stand = S.ID_Stand AND Heure_Arrivee = (SELECT MIN(Heure_Arrivee) FROM DB_SALON_Reunions A, DB_SALON_Stand S WHERE A.ID_Stand = S.ID_Stand AND Libelle_Stand = :STAND) AND Libelle_Stand = :STAND";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":STAND", $S->getLibelle(), PDO::PARAM_STR);

			$stmt->execute();

			$U = new Utilisateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];
				
				$tab = array(
					"Nom" => $valueStmt['Nom_Avatar']
					);
			}else{
				$tab = array(
					"Nom" => ""
					);
			}

			$U->hydrate($tab);

			$this->deleteAttenteByUtilisateur($U); //!!!!! SUPPRESSION DE L'UTILISATEUR DANS LA FILE D'ATTENTE !!!!!

			return $U;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	/*End*/
}
?>