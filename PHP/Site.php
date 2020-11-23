<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le sit</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Site</h1>
    <footer>
		<?php
			require_once("PHP/objUtilisateur.php");
			if(!isset($_SESSION['user_name'])){
				session_start();
				$tmpUtilisateur = insertTempUtilisateur()
				$_SESSION['user_name']=$tmpUtilisateur["Nom"];

				$_SESSION['user_ID']=$tmpUtilisateur["Id"];

				$_SESSION['user_Statue']=0;

			}else{
				echo "vous êtes : ".$_SESSION['user_name'];
			}
		?>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
    </body>
</html>
