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

			if(!isset($_SESSION['user_name'])){
				session_start();

				$_SESSION['user_name']="guestTest";

				$_SESSION['user_ID']=0;

			}else{
				echo "vous êtes : ".$_SESSION['user_name'];
			}
		?>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
    </body>
</html>
