<!Doctype HTML>
<HTML>
	<HEAD>
		<meta charset="utf-8"/>
		<title>Inscription</title>
		<lang = fr/>
		<style type="text/css"></style>
		<link rel="stylesheet" type="text/css" href=""> 
		<link rel="shortcut icon" type="image/x-icon" href="">     
	</HEAD>
	<BODY>

		<form method="POST" action="#">
			<label for="nom">Pseudo : </label><input type="text"  id="pseudo" name="nom" placeholder="Pseudo" onchange="" required><span class="desc">ne pas utiliser de caracter spécial</span><br>
			<label for="mdp"> Mot de Passe : </label><input type="password" id="pass" name="mdp" placeholder="password"   required><span class="desc">doit au moins contenir 1 Majuscule, 1 Minuscule et 1 Chiffre</span><br>
			<input type="submit" name="sub" id="sup" value="Connection">
		</form>
	</BODY>
</HTML>


<?php
	require_once("./PDO_Connect/PDO_Connect.php");
	require_once("./Objets/managerUtilisateur.php");

	//var_dump($_POST["nom"]);
	//var_dump($_POST["mdp"]);


	$conn = connect_bd();
	$tab = array("Nom" =>$_POST["nom"], "MDP" => $_POST["mdp"]);

	$manager  = new managerUtilisateur($conn);

	$Ut1 = new Utilisateur;

	$Ut1->hydrate($tab);

	//var_dump($Ut1->getMDP());



	$verifUt = $manager->selectUtilisateurByName($Ut1->getNom());
	//var_dump($verifUt->getMDP());

	if($verifUt->getNom() == $Ut1->getNom() &&  password_verify($Ut1->getMDP(),$verifUt->getMDP()))
	{		
		echo"<script> alert('Connection au salon');</script>'";
			
	}
	else
	{
		echo"<script> alert('Nom ou Mot de passe Incorect');</script>";
	}
?>