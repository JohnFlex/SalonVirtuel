<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site pr�sentateur</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Site pr�sentateur</h1>
        <div>
            <a href="creerStand.php">Cr�ation d'un Stand</a>
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
