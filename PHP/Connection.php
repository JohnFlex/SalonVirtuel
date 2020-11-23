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
    <footer>
		<div>
        	<a href="Inscription.php">Inscription</a>
        </div>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
</HTML>


<?php
	require_once("./PDO_Connect/PDO_Connect.php");
	require_once("./Objets/managerUtilisateur.php");

	//var_dump($_POST["nom"]);
	//var_dump($_POST["mdp"]);


	$conn = connect_bd();

	if(isset($_POST["nom"]) && isset($_POST["mdp"]))
	{
		//Faire un Select From Utilisateur si rowcount()>0 c'est OK
		//Sinon Faire un Select From Presentateur si rowcount()>0 c'est OK
		//Sinon Faire un Select From Administrateur si rowcount()>0 c'est OK
		//Sinon Nom et MDP invalide.

		$tab = array("Nom" =>$_POST["nom"], "MDP" => $_POST["mdp"]);

		$manager = new managerUtilisateur($conn);

		$Ut1 = new Utilisateur;

		$Ut1->hydrate($tab);

		//var_dump($Ut1->getMDP());


		$verifUt = $manager->selectUtilisateurByName($Ut1->getNom());
		//var_dump($verifUt->getMDP());

		if($verifUt->getNom() == $Ut1->getNom() && password_verify($Ut1->getMDP(),$verifUt->getMDP()))
		{		
			echo"<script> alert('Connection au salon');</script>";

			session_start();

			$_SESSION['user_name']=$_POST["nom"];

	
			/****Faire la différenciation****/
			$_SESSION['user_type']="Utilisateur"; //A changer.

			$sql="SELECT ID_Avatar FROM `DB_SALON_Utilisateur` WHERE Nom_Avatar=".$_POST["nom"];
			foreach($conn->query($sql) as $row)
			{
				$_SESSION['user_ID']=$row["ID_Avatar"];
			}
			/********/


			//A FAIRE : SET LE NOM DE SESSION (Verifier si c'est un utilisateur ou un presentateur)

			header("Location: Site.php");
		}
		else
		{
			echo"<script> alert('Nom ou Mot de passe Incorrect');</script>";
		}
	}
?>