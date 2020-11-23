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
            session_start();
			if(isset($_SESSION['user_name'])){
				echo "vous êtes : ".$_SESSION['user_name'];
			}
				
		?>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
    </body>
</html>
