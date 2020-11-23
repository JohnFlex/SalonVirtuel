
<!DOCTYPE html>
<html>
    <head>
        <title>Accueil</title>
        <meta charset="utf-8">
    </head>
    <body>
		<?php
			require_once("./PDO_Connect/PDO_Connect.php");
			require_once("./Objets/managerUtilisateur.php");
			if(!isset($_SESSION['user_name'])){
				session_start();
				$conn = connect_bd();
				$manager = new managerUtilisateur($conn);
				$tmpUtilisateur = $manager->insertTempUtilisateur();
				$tmpUtilisateur = insertTempUtilisateur()
				$_SESSION['user_name']=$tmpUtilisateur["Nom"];

				$_SESSION['user_ID']=$tmpUtilisateur["Id"];

				$_SESSION['user_Statue']=0;

			}else{
				echo "vous êtes : ".$_SESSION['user_name'];
			}
		?>

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
        <div>
            <a href="Connection.php">Connexion</a>
        </div>
    </body>
</html>
