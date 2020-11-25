<?php
	require_once("PDO_Connect/PDO_Connect.php");
	require_once("Objets/managerUtilisateur.php");
	require_once("Objets/managerPresentateur.php");
	require_once("Objets/managerAdministrateur.php");


	$conn = connect_bd();
	if(isset($_POST["nom"]) && isset($_POST["mdp"]))
	{
		//Faire un Select From Utilisateur si rowcount()>0 c'est OK
		//Sinon Faire un Select From Presentateur si rowcount()>0 c'est OK
		//Sinon Faire un Select From Administrateur si rowcount()>0 c'est OK
		//Sinon Nom et MDP invalide.

		$managerUtilisateur = new managerUtilisateur($conn);
		$managerPresentateur = new managerPresentateur($conn);
		$managerAdministrateur = new managerAdministrateur($conn);

		if ($managerUtilisateur->existUtilisateurByName($_POST["nom"], $_POST["mdp"]))
		{
			session_start();
			$_SESSION['user_name']=$_POST["nom"];
			$_SESSION['user_type']="Utilisateur";
			header("Location: Site.php");
		}
		elseif ($managerPresentateur->existPresentateurByName($_POST["nom"], $_POST["mdp"]))
		{
			session_start();
			$_SESSION['user_name']=$_POST["nom"];
			$_SESSION['user_type']="Presentateur";
			header("Location: SitePresentateur.php");
		}
		elseif($managerAdministrateur->existAdministrateurByName($_POST["nom"], $_POST["mdp"]))
		{
			session_start();
			$_SESSION['user_name']=$_POST["nom"];
			$_SESSION['user_type']="Administrateur";
			header("Location: SiteAdministrateur.php");
		}
		else
		{
			echo"<script> alert('Nom ou Mot de passe Incorrect');</script>";
		}
	}
?>

<!DOCTYPE html>
<HTML>
	<HEAD>
		<meta charset="utf-8"/>
		<title>Inscription</title>
		<lang = fr/>
		<style type="text/css"></style>
		<link rel="stylesheet" type="text/css" href="../CSS/style.css"> 
		<link rel="shortcut icon" type="image/x-icon" href="">     
	</HEAD>
	<BODY>
		<header>
			<div id="createAc">
				<h2>Pas encore inscrit ?</h2>
        		<a href="Inscription.php">Inscription</a>
        	</div>
        	<div id="date">
				<h2>Salon Virtuel</h2>
        		<?php setlocale(LC_TIME, 'fra_fra'); echo  strftime('%Y-%m-%d %H:%M:%S');; ?>
        	</div>
		</header>
		<form method="POST" action="#">
			<h2>Connection</h2>
			<label for="nom">Pseudo : </label><input type="text"  id="pseudo" name="nom" placeholder="Pseudo" onchange="" required>
			<label for="mdp"> Mot de Passe : </label><input type="password" id="pass" name="mdp" placeholder="password"   required>
			<input type="submit" name="sub" id="sup" value="Connection">
		</form>
	</BODY>
    <footer>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
</HTML>