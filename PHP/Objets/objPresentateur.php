<?php
class Presentateur
{
	//Membres privés
	private $ID_Avatar;
	private $Nom_Avatar;
	private $MDP_Presentateur;
	private $ID_Activite;
	private $ID_Stand;


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
		//echo "<script>console.log(\"Destruction de l'élement\")</script>";
	}


	//Les getters
	public function getIdAvatar()
	{
		return $this->ID_Avatar;
	}

	public function getNom()
	{
		return $this->Nom_Avatar;
	}

	public function getMDP()
	{
		return $this->MDP_Presentateur;
	}

	public function getIdActivite()
	{
		return $this->ID_Activite;
	}

	public function getIdStand()
	{
		return $this->ID_Stand;
	}

	//Les setters
	public function setIdAvatar($num)
	{
		$this->ID_Avatar = $num;
	}

	public function setNom($name)
	{
		$this->Nom_Avatar = $name;
	}

	public function setMDP($MDP)
	{
		$this->MDP_Presentateur = $MDP;
	}

	public function setIdActivite($num)
	{
		$this->ID_Activite = $num;
	}

	public function setIdStand($num)
	{
		$this->ID_Stand = $num;
	}


	//Autres
	public function __toString()
	{
		return "Utilisateur : ID_Avatar=".$this->getIdAvatar().", Nom_Avatar=".$this->getNom();
	}
}
?>
