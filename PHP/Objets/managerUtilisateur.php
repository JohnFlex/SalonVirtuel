<?php
require_once("objUtilisateur.php");

class managerUtilisateur
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

	public function insertUtilisateur(Utilisateur $U)
	//BUT : Insérer un utilisateur dans le base de donnée
	//ENTREE : Un objet utilisateur
	//SORTIE : /
	{
		$req = "INSERT INTO DB_SALON_Avatar() VALUES(); INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur) VALUES ((Select MAX(ID_Avatar) FROM DB_SALON_Avatar), :NOM, :MDP)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $U->getNom(), PDO::PARAM_STR);
			$stmt->bindValue(":MDP", $U->getMDP(), PDO::PARAM_STR);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function insertTempUtilisateur()
	//BUT : Insérer un utilisateur temporaire dans la base de donnée
	//ENTREE : /
	//SORTIE : Un objet utilisateur
	{
		$req = "INSERT INTO DB_SALON_Avatar() VALUES(); 

				INSERT INTO DB_SALON_Utilisateur(ID_Avatar, Nom_Avatar, MDP_Utilisateur) 
				VALUES (
					(Select MAX(ID_Avatar) FROM DB_SALON_Avatar), 
					CONCAT('GUEST',(Select MAX(ID_Avatar) FROM DB_SALON_Avatar)),
					''
				);";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->execute();

			$lastId = $this->db->lastInsertId();

			$U = new Utilisateur;

			$tab = array(
				"Id" => $lastId,
				"Nom" => "GUEST".$lastId,
				"MDP" => ""
			);

			$U->hydrate($tab);

			return $U;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function existUtilisateurByName($name)
	//BUT : Vérifier si un utilisateur existe
	//ENTREE : Un nom
	//SORTIE : Un booléen
	{
		$req = "SELECT * FROM DB_SALON_Utilisateur WHERE Nom_Avatar = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount() > 0)
			{
				return true;
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function existUtilisateurById($num)
	//BUT : Vérifier si un utilisateur existe
	//ENTREE : Un ID
	//SORTIE : Un booléen
	{
		$req = "SELECT * FROM DB_SALON_Utilisateur WHERE ID_Avatar = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $num, PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount() > 0)
			{
				return true;
			}else{
				return false;
			}
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectUtilisateurs()
	//BUT : Récupérer tous les utilisateurs
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des utilisateurs
	{
		$req = "SELECT * FROM DB_SALON_Utilisateur";

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

	public function selectUtilisateurByName($name)
	//BUT : Récupérer un utilisateur grâce à son pseudo
	//ENTREE : Le nom de l'utilisateur
	//SORTIE : Un objet utilisateur contenant les informations de l'utilisateur
	{
		$req = "SELECT * FROM DB_SALON_Utilisateur WHERE Nom_Avatar = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			$U = new Utilisateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Avatar'],
					"Nom" => $valueStmt['Nom_Avatar'],
					"MDP" => $valueStmt['MDP_Utilisateur']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Nom" => "",
					"MDP" => ""
					);
			}

			$U->hydrate($tab);

			return $U;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectUtilisateurById($id)
	//BUT : Récupérer un utilisateur grâce à son id
	//ENTREE : L'id de l'utilisateur
	//SORTIE : Un objet utilisateur contenant les informations de l'utilisateur
	{
		$req = "SELECT * FROM DB_SALON_Utilisateur WHERE ID_Avatar = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $id, PDO::PARAM_INT);

			$stmt->execute();

			$U = new Utilisateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Avatar'],
					"Nom" => $valueStmt['Nom_Avatar'],
					"MDP" => $valueStmt['MDP_Utilisateur']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Nom" => "",
					"MDP" => ""
					);
			}

			$U->hydrate($tab);

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