<?php 
    session_start();
    //$_SESSION["stand_id"]=14;
    //$_SESSION["user_name"];
    //$_SESSION["user_type"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site pr�sentateur stand</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Site pr�sentateur Stand</h1>
        <div>
            Ici on va g�rer la connexion � la communication
        </div>
    <footer>
		<?php
			if(isset($_SESSION['user_name'])){
				echo "vous �tes : ".$_SESSION['user_name'];
			}
				
		?>
        <a href="Accueil.php">Deconnexion</a>
        <a href="COMM/Show_Queue.php">Menu de r�union</a>
    </footer>
    </body>
</html>
