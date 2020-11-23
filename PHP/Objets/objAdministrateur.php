<?php
class Utilisateur
{
	//Membres privés
	private $ID_Administrateur;
	private $Nom_Administrateur;
	private $MDP_Administrateur;


	//Fonctions membres
	//Le hydrate (Ou le constructeur)
	public function hydrate(array $donnees)		//ATTENTION A BIEN HACHER LE MDP
	{
		foreach($donnees as $key => $value)
		{
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
		return $this->ID_Administrateur;
	}

	public function getNom()
	{
		return $this->Nom_Administrateur;
	}

	public function getMDP()
	{
		return $this->MDP_Administrateur;
	}

	//Les setters
	public function setId($num)
	{
		$this->ID_Administrateur = $num;
	}

	public function setNom($name)
	{
		$this->Nom_Administrateur = $name;
	}

	public function setMDP($MDP)
	{
		$this->MDP_Administrateur = $MDP;
	}


	//Autres
	public function __toString()
	{
		return "Administrateur : ID_Administrateur=".$this->getId().", Nom_Administrateur=".$this->getNom();
	}
}
?>
