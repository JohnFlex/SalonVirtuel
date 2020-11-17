<!DOCTYPE html> <!-- Ceci est un modèle de base, penser à faire une copie avant de faire des modifications -->
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="icon" href="">
		<link rel="stylesheet" type="text/css" href="">
		<link rel="shortcut icon" type="image/x-icon" href="">
		<script type="text/javascript" src="">
			
		</script>
		<title>
			Cours de web
		</title>
	</head>

	<body>

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