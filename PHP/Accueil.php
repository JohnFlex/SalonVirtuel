<!DOCTYPE html>
<html>
	<head>
		<title>Accuei</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Accueil</h1>
		<div>
			<a href="Inscription.php">Inscription</a>
		</div>
		<div>
			<a href="creerStand.php">Création d'un Stand</a>
		</div>
		<div>
 			<a href="SwitchPresentateurUtilisateur.php">Page Administrateur quant au passage d'un utilisateur en présentateur</a>
		</div>

<?php
	require_once("PDO_Connect/PDO_Connect.php");

	require_once("Objets/objUtilisateur.php");
	require_once("Objets/objPresentateur.php");
	require_once("Objets/objStand.php");
	require_once("Objets/objRessource.php");
	require_once("Objets/objAttente.php");

	require_once("Objets/managerUtilisateur.php");
	require_once("Objets/managerPresentateur.php");
	require_once("Objets/managerStand.php");
	require_once("Objets/managerRessource.php");
	require_once("Objets/managerAttente.php");

	$connexion = connect_bd();

	$mU = new managerUtilisateur($connexion);

	$U = new Utilisateur;

	$tab = array(
		"Nom" => "JeanJacquedu42",
		"MDP" => "XXX"
	);

	$U->hydrate($tab);

	$mU->insertUtilisateur($U);

	$name = "JeanJacquedu42";

	$U = $mU->selectUtilisateurByName($name);

	echo $U->__toString();
	echo "<br>";


	$mS = new managerStand($connexion);

	$S = new Stand;

	$tab = array(
		"Libelle" => "Le stand de jacky"
	);

	$S->hydrate($tab);

	$mS->insertStand($S);

	$name = "Le stand de jacky";

	$S = $mS->selectStandByLibelle($name);

	echo $S->__toString();
	echo "<br>";


	$mP = new managerPresentateur($connexion);

	$mP->insertPresentateur($U, $S);

	$P = new Presentateur;

	$name = "JeanJacquedu42";

	$P = $mP->selectPresentateurByName($name);

	echo $P->__toString();
?>

	</body>
</html>