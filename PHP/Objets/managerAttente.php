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
		$req = "INSERT INTO Attendre(ID_Avatar, ID_Stand, Position_Liste) VALUES (:AVATAR, :STAND, :POSITION)";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":AVATAR", $A->getIdAvatar(), PDO::PARAM_INT);
			$stmt->bindValue(":STAND", $A->getIdStand(), PDO::PARAM_INT);
			$stmt->bindValue(":LIBELLE", $A->getLibelle(), PDO::PARAM_STR);

			$stmt->execute();
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function deleteAttente() //A FAIRE

	public function selectAttenteByAvatar(Utilisateur $U)
	//BUT : Obtenir la position dans la liste d'attente d'un utilisateur, ainsi que le stand pour lequel il patiente
	//ENTREE : Un objet Utilisateur
	//SORTIE : Un objet Attente
	{
		$req = "SELECT * FROM Attendre WHERE ID_Avatar = :AVATAR";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":AVATAR", $A->getIdAvatar(), PDO::PARAM_INT);

			$stmt->execute();

			$A = new Attente;

			$tab = array(
				"IdAvatar" => $stmt['ID_Avatar'];
				"IdStand" => $stmt['ID_Stand'];
				"Position" => $stmt['Position_Liste'];
				);

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
		$req = "SELECT * FROM Attendre WHERE ID_Stand = :STAND";

		//Envoie de la requête à la base
		try
		{
			$stmt = $this->db->prepare($req);

			$stmt->bindValue(":STAND", $A->getIdStand(), PDO::PARAM_INT);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $error)
		{
			echo "<script>console.log('".$error->getMessage()."')</script>";
			exit();
		}
	}

	public function selectAttenteByPositionAndStand() //A FAIRE

	public function selectUtilisateurByPositionAndStand() //A FAIRE

	public function selectUtilisateurByAvatar() //A FAIRE

	/*End*/
}
?>