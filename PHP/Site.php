<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Site</h1>
    <footer>
		<?php
			if(isset($_SESSION['user_name'])){
				echo "vous �tes : ".$_SESSION['user_name'];
			}
				
		?>
        <a href="Accueil.php">Deconnexion</a>
    </footer>
    </body>
</html>
