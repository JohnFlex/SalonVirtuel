<?php
class Emplacement
{
	//Membres privés
	private $Position_X_Element;
    private $Position_Y_Element;
    private $Couleur_Element;

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
	public function getPositionX()
	{
		return $this->Position_X_Element;
	}
	public function getPositionY()
	{
		return $this->Position_Y_Element;
	}
	public function getCouleur()
	{
		return $this->Couleur_Element;
	}

    
	//Les setters

	public function setPositionX($num)
	{
		$this->Position_X_Element = $num;
	}
	public function setPositionY($num)
	{
		$this->Position_Y_Element = $num;
    }
	public function setCouleur($str)
	{
		$this->Couleur_Element = $str;
	}


	//Autres
	public function __toString()
	{
		return "Utilisateur : Position_X_Element=".$this->getPositonX().", Position_Y_Element=".$this->getPositionY().", Couleur=".$this->getCouleur();
	}
}
?>
