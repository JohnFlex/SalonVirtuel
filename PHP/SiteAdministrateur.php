<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site administrateur</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Site administrateur</h1>
               
        <div>
            <a href="SwitchPresentateurUtilisateur.php">Page Administrateur quant au passage d'un utilisateur en pr�sentateur</a>
        </div>
    <footer>
		<?php
            session_start();
			if(isset($_SESSION['user_name'])){
				echo "vous �tes : ".$_SESSION['user_name'];
			}
				
		?>
        <a href="Accueil.php">Deconnexion</a>
    </footer>
    </body>
</html>
