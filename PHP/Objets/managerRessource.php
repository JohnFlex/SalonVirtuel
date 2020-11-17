<?php
require_once("objRessource.php");

class managerRessource
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

	public function insertRessource(Ressource $R)
	//BUT : Insérer une ressource pour stand dans la base de donnée
	//ENTREE : Un objet Ressource
	//SORTIE : /
	{
		$req = "INSERT INTO DB_SALON_Ressource (Libelle_Ressource, Lien_Ressource) VALUES (:LIBELLE, :LIEN)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":LIBELLE", $R->getLibelle(), PDO::PARAM_STR);
			$stmt->bindValue(":LIEN", $R->getLien(), PDO::PARAM_STR);

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

	public function selectRessources()
	//BUT : Récupérer toutes les ressources
	//ENTREE : /
	//SORTIE : La liste des ressources
	{
		$req = "SELECT * FROM DB_SALON_Ressource";

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

	public function selectRessourceByLibelle($Libelle)
	//BUT : Récupérer une ressource grâce à son libelle
	//ENTREE : Une chaîne de caractère (le libelle)
	//SORTIE : /
	{
		$req = "SELECT * FROM DB_SALON_Ressource WHERE Libelle_Ressource = :LIBELLE";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":LIBELLE", $Libelle, PDO::PARAM_STR);

			$stmt->execute();

			$R = new Ressource;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];
				
				$tab = array(
					"Id" => $valueStmt['ID_Ressource'],
					"Libelle" => $valueStmt['Libelle_Ressource'],
					"Lien" => $valueStmt['Lien_Ressource']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Libelle" => "",
					"Lien" => ""
					);
			}

			$R->hydrate($tab);

			return $R;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectRessourceById($Id)
	//BUT : Récupérer une ressource grâce à son Id
	//ENTREE : Un integer (l'Id)
	//SORTIE : /
	{
		$req = "SELECT * FROM DB_SALON_Ressource WHERE ID_Ressource = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $Libelle, PDO::PARAM_STR);

			$stmt->execute();

			$R = new Ressource;

			if($stmt->rowCount() > 0)
			{
				$valueStmt = $stmt->fetchAll()[0];
				
				$tab = array(
					"Id" => $valueStmt['ID_Ressource'],
					"Libelle" => $valueStmt['Libelle_Ressource'],
					"Lien" => $valueStmt['Lien_Ressource']
					);
			}else{
				$tab = array(
					"Id" => "",
					"Libelle" => "",
					"Lien" => ""
					);
			}

			$R->hydrate($tab);

			return $R;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function insertContenir($id_stand,$id_res) 
    {
        $req = "INSERT INTO DB_SALON_Contenir VALUES (:ID_Stand,:ID_Ressource)";
        try 
        {
            $stmt = $this->db->prepare($req);

            $stmt->bindValue(":ID_Stand",$id_stand,PDO::PARAM_INT);
            $stmt->bindValue(":ID_Ressource",$id_res,PDO::PARAM_INT);

            $stmt->execute();
        }
        catch(PDOException $error)
        {
            echo "<script>console.log('".$error->getMessage()."')</script>";
        }
    }

    /*End*/
}
?>