<?php
require_once("objStand.php");

class managerStand
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

	public function insertStand(Stand $S)
	//BUT : Insérer un stand dans le base de donnée
	//ENTREE : Un objet stand
	//SORTIE : /
	{
		$req = "INSERT INTO DB_SALON_Stand(Libelle_Stand,Information_Stand,Categorie_Stand,Position_X_Emplacement,Position_Y_Emplacement) VALUES (:LIBELLE,:INFORMATION,:CATEGORIE,:X,:Y)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			//$stmt->bindValue(":ID", $S->getId(), PDO::PARAM_INT);
			$stmt->bindValue(":LIBELLE", $S->getLibelle(), PDO::PARAM_STR);
			$stmt->bindValue(":INFORMATION", $S->getInformation(), PDO::PARAM_STR);
			$stmt->bindValue(":CATEGORIE", $S->getCategorie(), PDO::PARAM_STR);
			$stmt->bindValue(":X", $S->getPositionX(), PDO::PARAM_INT);
            $stmt->bindValue(":Y", $S->getPositionY(), PDO::PARAM_INT);

			$stmt->execute();

			$lastId = $this->db->lastInsertId();
			return $lastId;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectStands()
	//BUT : Récupérer tous les stands
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des stands
	{
		$req = "SELECT * FROM DB_SALON_Stand";

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

	public function selectStandById($id)
	//BUT : Récupérer un stand grâce à son id
	//ENTREE : L'id de stand
	//SORTIE : Un objet stand contenant les informations du stand
	{
		$req = "SELECT * FROM DB_SALON_Stand WHERE ID_Stand = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $id, PDO::PARAM_INT);

			$stmt->execute();

			$S = new Stand;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Stand'],
					"Libelle" => $valueStmt['Libelle_Stand'],
					"Categorie" => $valueStmt['Categorie_Stand'],
					"Information" => $valueStmt['Information_Stand'],
					"PositionX" => $valueStmt['Position_X_Emplacement'],
					"PositionY" => $valueStmt['Position_Y_Emplacement']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Libelle" => "",
					"Categorie" => "",
					"Information" => "",
					"PositionX" => "",
					"PositionY" => ""
					);
			}

			$S->hydrate($tab);

			return $S;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectStandByLibelle($str)
	//BUT : Récupérer un stand grâce à son libelle
	//ENTREE : Le libelle d'un stand
	//SORTIE : Un objet stand contenant les informations du stand
	{
		$req = "SELECT * FROM DB_SALON_Stand WHERE ID_Stand = :LIBELLE";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":LIBELLE", $str, PDO::PARAM_STR);

			$stmt->execute();

			$S = new Stand;

	
			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Stand'],
					"Libelle" => $valueStmt['Libelle_Stand'],
					"Categorie" => $valueStmt['Categorie_Stand'],
					"Information" => $valueStmt['Information_Stand'],
					"PositionX" => $valueStmt['Position_X_Emplacement'],
					"PositionY" => $valueStmt['Position_Y_Emplacement']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Libelle" => "",
					"Categorie" => "",
					"Information" => "",
					"PositionX" => "",
					"PositionY" => ""
					);
			}

			$S->hydrate($tab);

			return $S;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function updateStand(Stand $S) {
		$req = "UPDATE DB_SALON_Stand SET Libelle_Stand = :LIBELLE , Information_Stand = :INFORMATION , Categorie_Stand = :CATEGORIE , Position_X_Emplacement = :X , Position_Y_Emplacement = :Y  WHERE ID_Stand = :ID";
		try {
			$stmt = $this->db->prepare($req);
			$stmt->bindValue(":LIBELLE",$S->getLibelle(),PDO::PARAM_STR);
			$stmt->bindValue(":INFORMATION", $S->getInformation(), PDO::PARAM_STR);
			$stmt->bindValue(":CATEGORIE", $S->getCategorie(), PDO::PARAM_STR);
            $stmt->bindValue(":X", $S->getPositionX(), PDO::PARAM_INT);
			$stmt->bindValue(":Y", $S->getPositionY(), PDO::PARAM_INT);
			
			$stmt->bindValue(":ID",$S->getId(),PDO::PARAM_INT);

			$stmt->execute();


		} catch(PDOException $e) {
            echo "Erreur : ".$e->getMessage();
        }
	}

	public function updateStandEmplacement(Stand $S)
	{
		$req = "UPDATE DB_SALON_Stand SET Position_X_Emplacement = :X, Position_Y_Emplacement = :Y  WHERE ID_Stand = :ID";
		try {
			$stmt = $this->db->prepare($req);
            $stmt->bindValue(":X", $S->getPositionX(), PDO::PARAM_INT);
			$stmt->bindValue(":Y", $S->getPositionY(), PDO::PARAM_INT);
			
			$stmt->bindValue(":ID",$S->getId(),PDO::PARAM_INT);

			$stmt->execute();

		} catch(PDOException $e) {
            echo "Erreur : ".$e->getMessage();
        }
	}

	/*End*/
}
?>