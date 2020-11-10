<?php
class Utilisateur
{
	//Membres privés
	private $ID_Avatar;
	private $Nom_Avatar;
	private $MDP_Utilisateur;


	//Fonctions membres
	//Le hydrate (Ou le constructeur)
	public function hydrate(array $donnees)
	//Fonction hydrate, avec le hachage du MDP
	{
		foreach($donnees as $key => $value)
		{
			if($key = "MDP")
			{
				password_hash($value, PASSWORD_DEFAULT);
			}

			//On récupère le nom du setter correspondant à l'attribut.
			$method = "set".ucfirst($key);

			//Si le setter correspondant existe.
			if(method_exists($this, $method))
			{
				//On appelle le setter.
				$this->$method($value);
			}
		}
	}

	//Le destructeur
	public function __destruct()
	{
		echo "<script>console.log(\"Destruction de l'élement\")</script>";
	}


	//Les getters
	public function getId()
	{
		return $this->ID_Avatar;
	}

	public function getNom()
	{
		return $this->Nom_Avatar;
	}

	public function getMDP()
	{
		return $this->MDP_Utilisateur;
	}

	//Les setters
	public function setId($num)
	{
		$this->ID_Avatar = $num;
	}

	public function setNom($name)
	{
		$this->Nom_Avatar = $name;
	}

	public function setMDP($MDP)
	{
		$this->MDP_Utilisateur = $MDP;
	}


	//Autres
	public function __toString()
	{
		return "Utilisateur : ID_Avatar=".$this->getId().", Nom_Avatar=".$this->getNom();
	}
}
?>
