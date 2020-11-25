<?php
	require_once("PDO_Connect/PDO_Connect.php");
	require_once("Objets/managerUtilisateur.php");
	require_once("Objets/managerPresentateur.php");
	require_once("Objets/managerAdministrateur.php");

	function Recup_ID_Utilisateur($nomUtilisateur)
	{
	    $querry = "SELECT ID_Avatar FROM DB_SALON_Utilisateur WHERE Nom_Avatar = '". $nomUtilisateur."' ; ";
	    
	    try
	    {
	    	$connexion = connect_bd();

	    	$stmt = $connexion->prepare($querry);
   			
   			$stmt->execute();

   			$result = $stmt->fetchAll();

   			foreach ($result as $row)
   			{
   				return $row["ID_Avatar"];
   			}	    	
	    }
	    catch(Exception $e)
	    {
	    	echo $e->getMessage();
	    	return -1;
	    }
	}



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
			$_SESSION['user_id']=Recup_ID_Utilisateur($_POST["nom"]);
			//echo "User ID : ".$_SESSION['user_id'];
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
    <footer>
		<div>
        	<a href="Inscription.php">Inscription</a>
        </div>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
</HTML>