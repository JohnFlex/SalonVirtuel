<?php
class Attente
{
	//Membres privés
	private $ID_Avatar;
	private $ID_Avatar_Presentateur;
	private $ID_Stand;
	private $Heure_Arrivee;


	//Fonctions membres
	//Le hydrate (Ou le constructeur)
	public function hydrate(array $donnees)
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
	public function getIdAvatar()
	{
		return $this->ID_Avatar;
	}

	public function getIdPresentateur()
	{
		return $this->ID_Avatar_Presentateur;
	}

	public function getIdStand()
	{
		return $this->ID_Stand;
	}

	public function getHeure()
	{
		return $this->Heure_Arrivee;
	}

	//Les setters
	public function setIdAvatar($num)
	{
		$this->ID_Avatar = $num;
	}

	public function setIdPresentateur($num)
	{
		$this->ID_Avatar_Presentateur = $num;
	}

	public function setIdStand($num)
	{
		$this->ID_Stand = $num;
	}

	public function setHeure($num)
	{
		$this->Heure_Arrivee = $num;
	}


	//Autres
	public function __toString()
	{
		return "Utilisateur : ID_Attente=".$this->getId().", Libelle_Attente=".$this->getLibelle();
	}
}
?>
