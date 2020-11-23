<?php
require_once("objAdministrateur.php");

class managerAdministrateur
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

	public function insertAdministrateur(Administrateur $U)
	//BUT : Insérer un Administrateur dans le base de donnée
	//ENTREE : Un objet Administrateur
	//SORTIE : /
	{
		$req = "INSERT INTO DB_SALON_Administrateur(Nom_Administrateur, MDP_Administrateur) VALUES (:NOM, :MDP)";

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

	public function existAdministrateurByName($name, $MDP)
	//BUT : Vérifier si un Administrateur existe
	//ENTREE : Un nom
	//SORTIE : Un booléen
	{
		$req = "SELECT * FROM DB_SALON_Administrateur WHERE Nom_Administrateur = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				return password_verify($MDP, $valueStmt["MDP_Administrateur"]);
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

	public function existAdministrateurById($num)
	//BUT : Vérifier si un Administrateur existe
	//ENTREE : Un ID
	//SORTIE : Un booléen
	{
		$req = "SELECT * FROM DB_SALON_Administrateur WHERE ID_Administrateur = :ID";

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

	public function selectAdministrateurs()
	//BUT : Récupérer tous les Administrateurs
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des Administrateurs
	{
		$req = "SELECT * FROM DB_SALON_Administrateur";

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

	public function selectAdministrateurByName($name)
	//BUT : Récupérer un Administrateur grâce à son pseudo
	//ENTREE : Le nom de l'Administrateur
	//SORTIE : Un objet Administrateur contenant les informations de l'Administrateur
	{
		$req = "SELECT * FROM DB_SALON_Administrateur WHERE Nom_Administrateur = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			$U = new Administrateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Administrateur'],
					"Nom" => $valueStmt['Nom_Administrateur'],
					"MDP" => $valueStmt['MDP_Administrateur']
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

	public function selectAdministrateurById($id)
	//BUT : Récupérer un Administrateur grâce à son id
	//ENTREE : L'id de l'Administrateur
	//SORTIE : Un objet Administrateur contenant les informations de l'Administrateur
	{
		$req = "SELECT * FROM DB_SALON_Administrateur WHERE ID_Administrateur = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $id, PDO::PARAM_INT);

			$stmt->execute();

			$U = new Administrateur;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Administrateur'],
					"Nom" => $valueStmt['Nom_Administrateur'],
					"MDP" => $valueStmt['MDP_Administrateur']
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