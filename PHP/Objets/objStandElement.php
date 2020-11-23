<?php
class StandElement
{
	//Membres privés
	private $ID_Stand_Element;
	private $Nom_Element;
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
	public function getId()
	{
		return $this->ID_Stand_Element;
    }
    public function getNom()
    {
        return $this->Nom_Element;
    }
	public function getCouleur()
	{
		return $this->Couleur_Element;
	}

	//Les setters
	public function setId($num)
	{
		$this->ID_Stand_Element = $num;
    }
    public function setNom($str)
    {
        $this->Nom_Element = $str;
    }
	public function setCouleur($str)
	{
		$this->Couleur_Element = $str;
	}


	//Autres
	public function __toString()
	{
		return "Utilisateur : ID_Stand_Element=".$this->getId().", Nom_Stand=".$this->getNom().", Couleur_Element=".$this->getCouleur();
	}
}
?>
