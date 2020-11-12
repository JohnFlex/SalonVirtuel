<?php
require_once("objPresentateur.php");

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

	public function insertPresentateur(Presentateur $P)
	//BUT : Insérer un Presentateur dans le base de donnée
	//ENTREE : Un objet Presentateur
	//SORTIE : /
	{
		$req = "INSERT INTO Presentateur(ID_Avatar, Nom_Avatar, MDP_Avatar, ID_Activite, ID_Stand) VALUES (:ID, :NOM, :MDP, :ACTIVITE, :STAND)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $P->getIdAvatar(), PDO::PARAM_INT);
			$stmt->bindValue(":NOM", $P->getNom(), PDO::PARAM_STR);
			$stmt->bindValue(":MDP", $P->getMDP(), PDO::PARAM_STR);
			$stmt->bindValue(":ACTIVITE", $P->getIdActivite(), PDO::PARAM_INT);
			$stmt->bindValue(":STAND", $P->getIdStand(), PDO::PARAM_INT);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
		}
	}

	public function selectPresentateurs()
	//BUT : Récupérer tous les Presentateurs
	//ENTREE : /
	//SORTIE : Une table contenant l'ensemble des Presentateurs
	{
		$req = "SELECT * FROM Presentateur";

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
			return "";
		}
	}

	public function selectPresentateurByName($name)
	//BUT : Récupérer un Presentateur grâce à son pseudo
	//ENTREE : Le nom du Presentateur
	//SORTIE : Un objet Presentateur contenant les informations du Presentateur
	{
		$req = "SELECT * FROM Presentateur WHERE Nom_Avatar = :NOM";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":NOM", $name, PDO::PARAM_STR);

			$stmt->execute();

			$P = new Presentateur;

			$tab = array(
				"IdAvatar" => $stmt['ID_Avatar'];
				"Nom" => $stmt['Nom_Avatar'];
				"MDP" => $stmt['MDP_Presentateur'];
				"IdActivite" => $stmt['ID_Activite'];
				"IdStand" = > $stmt['ID_Stand'];
				);

			$P->hydrate($tab);

			return $P;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			return "";
		}
	}

	public function selectPresentateurById($id)
	//BUT : Récupérer un Presentateur grâce à son id
	//ENTREE : L'id du Presentateur
	//SORTIE : Un objet Presentateur contenant les informations du Presentateur
	{
		$req = "SELECT * FROM Presentateur WHERE ID_Avatar = :ID";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":ID", $id, PDO::PARAM_INT);

			$stmt->execute();

			$P = new Presentateur;

			$tab = array(
				"IdAvatar" => $stmt['ID_Avatar'];
				"Nom" => $stmt['Nom_Avatar'];
				"MDP" => $stmt['MDP_Presentateur'];
				"IdActivite" => $stmt['ID_Activite'];
				"IdStand" = > $stmt['ID_Stand'];
				);

			$P->hydrate($tab);

			return $P;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			return "";
		}
	}

	public function selectActivite(Presentateur $P)
	//BUT : Obtenir le libelle de l'activité d'un présentateur P
	//ENTREE : Un présentateur P
	//SORTIE : Une chaine de caractères contenant le libelle de l'activité
	{
		$req = "SELECT Libelle_Activite FROM Activite WHERE ID_Activite = :ACTIVITE";

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
			return "";
		}
	}

	/*End*/
}
?>