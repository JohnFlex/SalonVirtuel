<?php
	
	require_once("./PDO_Connect/PDO_Connect.php");
	require_once("./Objets/managerUtilisateur.php");


	var_dump($_POST["nom"]);
	var_dump($_POST["mdp"]);



	$conn = connect_bd();
	$tab = array("Nom" =>$_POST["nom"], "MDP" => password_hash($_POST["mdp"], PASSWORD_DEFAULT));

	$manager  = new managerUtilisateur($conn);

	$Ut1 = new Utilisateur;

	$Ut1->hydrate($tab);



	$verifUt = $manager->selectUtilisateurByName($Ut1->getNom());

	if($verifUt->getNom() == $Ut1->getNom())
	{
		header("Location: Inscription.php");
	}
	else
	{
		$manager->insertUtilisateur($Ut1);
		header("Location: Connection.php");
	}

?>