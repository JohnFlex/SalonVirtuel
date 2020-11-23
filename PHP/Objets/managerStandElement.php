<?php
require_once("objStandElement.php");

class managerStandElement
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

	public function insertStandElement(StandElement $S)
	//BUT : Insérer un stand dans le base de donnée
	//ENTREE : Un objet stand
	//SORTIE : /
	{
		$req = "INSERT INTO DB_SALON_Stand_Element(Nom_Element,Couleur_Element) VALUES (:NOM,:COULEUR)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

            //$stmt->bindValue(":ID", $S->getId(), PDO::PARAM_INT);
            $stmt->bindValue(":NOM", $S->getNom(), PDO::PARAM_STR);
            $stmt->bindValue(":COULEUR", $S->getCouleur(), PDO::PARAM_STR);

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

	public function selectStandElements()
	//BUT : Récupérer tous les stands
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des stands
	{
		$req = "SELECT * FROM DB_SALON_Stand_Element";

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

	public function selectStandElementById($id)
	//BUT : Récupérer un stand grâce à son id
	//ENTREE : L'id de stand
	//SORTIE : Un objet stand contenant les informations du stand
	{
		$req = "SELECT * FROM DB_SALON_Stand_Element WHERE ID_Stand_Element = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $id, PDO::PARAM_INT);

			$stmt->execute();

			$S = new StandElement;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];

				$tab = array(
					"Id" => $valueStmt['ID_Stand_Element'],
                    "Nom" => $valueStmt['Nom_Element'],
                    "Couleur" => $valueStmt['Couleur_Element']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Nom" => "",
                    "Couleur" => ""
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
    

	public function updateStandElement(StandElement $S) {
		$req = "UPDATE DB_SALON_Stand_Element SET Nom_Element = :NOM, Couleur_Element = :COULEUR WHERE ID_Stand_Element = :ID";
		try {
			$stmt = $this->db->prepare($req);

            $stmt->bindValue(":NOM", $S->getNom(), PDO::PARAM_STR);
            $stmt->bindValue(":COULEUR", $S->getCouleur(), PDO::PARAM_STR);

			$stmt->bindValue(":ID",$S->getId(),PDO::PARAM_INT);

			$stmt->execute();

		} catch(PDOException $e) {
            echo "Erreur : ".$e->getMessage();
        }
	}

	/*End*/
}
?>