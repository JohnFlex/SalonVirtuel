<?php
class Ressource
{
	//Membres privés
	private $ID_Ressource;
	private $Libelle_Ressource;
	private $Lien_Ressource;


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
	public function getId()
	{
		return $this->ID_Ressource;
	}

	public function getLibelle()
	{
		return $this->Libelle_Ressource;
	}

	public function getLien()
	{
		return $this->Lien_Ressource;
	}

	//Les setters
	public function setId($num)
	{
		$this->ID_Ressource = $num;
	}

	public function setLibelle($str)
	{
		$this->Libelle_Ressource = $str;
	}

	public function setLien($str)
	{
		$this->Lien_Ressource = $str;
	}


	//Autres
	public function __toString()
	{
		return "Utilisateur : ID_Stand=".$this->getId().", Libelle_Stand=".$this->getLibelle();
	}
}
?>
