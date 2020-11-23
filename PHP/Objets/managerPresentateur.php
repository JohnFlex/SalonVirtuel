<?php
require_once("objPresentateur.php");
require_once("objUtilisateur.php");
require_once("objStand.php");

class managerPresentateur
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

	public function insertPresentateur(Utilisateur $U, Stand $S)
	//BUT : Insérer un Presentateur dans le base de donnée
	//ENTREE : Un objet Utilisateur et un objet Stand
	//SORTIE : /
	{
		$req = "DELETE FROM DB_SALON_Utilisateur WHERE Nom_Avatar = :NOM; INSERT INTO DB_SALON_Presentateur(ID_Avatar, Nom_Avatar, MDP_Presentateur, ID_Activite, ID_Stand) VALUES (:ID, :NOM, :MDP, 1, :STAND)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $U->getId(), PDO::PARAM_INT);
			$stmt->bindValue(":NOM", $U->getNom(), PDO::PARAM_STR);
			$stmt->bindValue(":MDP", $U->getMDP(), PDO::PARAM_STR);
			$stmt->bindValue(":STAND", $S->getId(), PDO::PARAM_INT);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
		}
	}

	public function existPresentateurByName($name, $MDP)
	//BUT : Vérifier si un Presentateur existe
	//ENTREE : Un nom
	//SORTIE : Un booléen
	{
		$req = "SELECT * FROM DB_SALON_Presentateur WHERE Nom_Avatar = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				return password_verify($MDP, $valueStmt["MDP"]);
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			return false;
		}
	}

	public function existPresentateurById($num)
	//BUT : Vérifier si un Presentateur existe
	//ENTREE : Un ID
	//SORTIE : Un booléen
	{
		$req = "SELECT * FROM DB_SALON_Presentateur WHERE ID_Avatar = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $num, PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				return password_verify($MDP, $valueStmt["MDP"]);
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			return false;
		}
	}

	public function selectPresentateurs()
	//BUT : Récupérer tous les Presentateurs
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des Presentateurs
	{
		$req = "SELECT * FROM DB_SALON_Presentateur";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectPresentateurByName($name)
	//BUT : Récupérer un Presentateur grâce à son pseudo
	//ENTREE : Le nom du Presentateur
	//SORTIE : Un objet Presentateur contenant les informations du Presentateur
	{
		$req = "SELECT * FROM DB_SALON_Presentateur WHERE Nom_Avatar = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			$P = new Presentateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"IdAvatar" => $valueStmt['ID_Avatar'],
					"Nom" => $valueStmt['Nom_Avatar'],
					"MDP" => $valueStmt['MDP_Presentateur'],
					"IdActivite" => $valueStmt['ID_Activite'],
					"IdStand" => $valueStmt['ID_Stand']
					);
			}else{
				$tab = array(
					"IdAvatar" => "",
					"Nom" => "",
					"MDP" => "",
					"IdActivite" => "",
					"IdStand" => ""
					);
			}

			$P->hydrate($tab);

			return $P;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectPresentateurById($id)
	//BUT : Récupérer un Presentateur grâce à son id
	//ENTREE : L'id du Presentateur
	//SORTIE : Un objet Presentateur contenant les informations du Presentateur
	{
		$req = "SELECT * FROM DB_SALON_Presentateur WHERE ID_Avatar = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $id, PDO::PARAM_INT);

			$stmt->execute();

			$P = new Presentateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"IdAvatar" => $valueStmt['ID_Avatar'],
					"Nom" => $valueStmt['Nom_Avatar'],
					"MDP" => $valueStmt['MDP_Presentateur'],
					"IdActivite" => $valueStmt['ID_Activite'],
					"IdStand" => $valueStmt['ID_Stand']
					);
			}else{
				$tab = array(
					"IdAvatar" => "",
					"Nom" => "",
					"MDP" => "",
					"IdActivite" => "",
					"IdStand" => ""
					);
			}

			$P->hydrate($tab);

			return $P;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectActivite(Presentateur $P)
	//BUT : Obtenir le libelle de l'activité d'un présentateur P
	//ENTREE : Un présentateur P
	//SORTIE : Une chaine de caractères contenant le libelle de l'activité
	{
		$req = "SELECT Libelle_Activite FROM DB_SALON_Activite WHERE ID_Activite = :ACTIVITE";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ACTIVITE", $P->getIdActivite(), PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;
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