<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site administrateur</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    </head>
    <body>
        
           
        <header>
            <div class="navbar">
                <h1>Titre du site</h1>
                <h2 class="titre3">Site administrateur</h2>
                
                <div class="cssAdmin">
                    <a href="Accueil.php"><img src="../Contenus/images/logout-rounded.png" alt="Deconnexion" style="height:1.45em; width: 1.45em;"></a>
                
                    <a href="SwitchPresentateurUtilisateur.php"> Administration des roles</a>
                    <a href="LiaisonAUnStand.php">Liaison au stand</a>
                    <a href="ChangerEmplacement.php">Changer l'emplacement d'un stand</a>
                </div>
            </div>
        </header>
        <footer>
		  <?php
                //session_start();
			 if(isset($_SESSION['user_name'])){
				    echo "vous êtes : ".$_SESSION['user_name'];
			 }
				
		  ?>
           
        </footer>
    </body>
</html>
