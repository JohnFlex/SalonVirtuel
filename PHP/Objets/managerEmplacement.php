<?php
require_once("objEmplacement.php");

class managerEmplacement
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
		//echo "<script>console.log(\"Destruction de l'élement\")</script>";
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

	public function insertEmplacement(Emplacement $S)
	//BUT : Insérer un stand dans le base de donnée
	//ENTREE : Un objet stand
	//SORTIE : /
	{
		$req = "INSERT INTO DB_SALON_Emplacement(Position_X_Emplacement,Position_Y_Emplacement,Couleur_Element) VALUES (:X,:Y,:COULEUR)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			//$stmt->bindValue(":ID", $S->getId(), PDO::PARAM_INT);
            $stmt->bindValue(":X", $S->getPositionX(), PDO::PARAM_INT);
            $stmt->bindValue(":Y", $S->getPositionY(), PDO::PARAM_INT);
            $stmt->bindValue(":COULEUR", $S->getCouleur(), PDO::PARAM_STR);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectEmplacements()
	//BUT : Récupérer tous les stands
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des stands
	{
		$req = "SELECT * FROM DB_SALON_Emplacement";

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

	public function selectEmplacementById($posX,$posY)
	//BUT : Récupérer un stand grâce à son id
	//ENTREE : L'id de stand
	//SORTIE : Un objet stand contenant les informations du stand
	{
		$req = "SELECT * FROM DB_SALON_Emplacement WHERE Position_X_Emplacement = :X AND Position_Y_Emplacement = :Y";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

            $stmt->bindValue(":X", $posX, PDO::PARAM_INT);
            $stmt->bindValue(":Y", $posY, PDO::PARAM_INT);

			$stmt->execute();

            $S = new Emplacement;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];
				$tab = array(
                    "PositionX" => $valueStmt['Position_X_Emplacement'],
                    "PositionY" => $valueStmt['Position_Y_Emplacement'],
                    "Couleur" => $valueStmt['Couleur_Element'],
					);
			}else{
				$tab = array(
                    "PositionX" => "",
                    "PositionY" => "",
                    "Couleur" => "",
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

	public function updateEmplacement(Emplacement $S) {
		$req = "UPDATE DB_SALON_Emplacement SET Couleur_Element = :COULEUR WHERE Position_X_Emplacement = :X AND Position_Y_Emplacement = :Y";
		try {
			$stmt = $this->db->prepare($req);
            $stmt->bindValue(":X", $S->getPositionX(), PDO::PARAM_INT);
            $stmt->bindValue(":Y", $S->getPositionY(), PDO::PARAM_INT);
            $stmt->bindValue(":COULEUR", $S->getCouleur(), PDO::PARAM_STR);

			$stmt->execute();

		} catch(PDOException $e) {
            echo "Erreur : ".$e->getMessage();
        }
	}

	/*End*/
}
?>