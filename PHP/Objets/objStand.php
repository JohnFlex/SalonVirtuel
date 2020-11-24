<?php
class Stand
{
	//Membres privés
	private $ID_Stand;
	private $Libelle_Stand;
	private $Categorie_Stand;
	private $Information_Stand;
	private $Position_X_Element;
    private $Position_Y_Element;


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
		//echo "<script>console.log(\"Destruction de l'élement\")</script>";
	}


	//Les getters
	public function getId()
	{
		return $this->ID_Stand;
	}

	public function getLibelle()
	{
		return $this->Libelle_Stand;
	}

	public function getCategorie()
	{
		return $this->Categorie_Stand;
	}
	public function getInformation()
	{
		return $this->Information_Stand;
	}
	public function getPositionX()
	{
		return $this->Position_X_Element;
	}
	public function getPositionY()
	{
		return $this->Position_Y_Element;
    }


	//Les setters
	public function setId($num)
	{
		$this->ID_Stand = $num;
	}

	public function setLibelle($str)
	{
		$this->Libelle_Stand = $str;
	}
	public function setInformation($str)
	{
		$this->Information_Stand = $str;
	}
	public function setCategorie($str)
	{
		$this->Categorie_Stand = $str;
	}
	public function setPositionX($num)
	{
		$this->Position_X_Element = $num;
	}
	public function setPositionY($num)
	{
		$this->Position_Y_Element = $num;
    }



	//Autres
	public function __toString()
	{
		return "Utilisateur : ID_Stand=".$this->getId().", Libelle_Stand=".$this->getLibelle().", Information_Stand=".$this->getInformation().", Categorie_Stand=".$this->getCategorie();
	}
}
?>
