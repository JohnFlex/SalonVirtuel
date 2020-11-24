<?php
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerPresentateur.php");

    $conn = connect_bd();

    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site présentateur</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Site présentateur</h1>
        <div>
            <?php
                $mP = new managerPresentateur($conn);

                $X = $mP->issetStand($_SESSION['user_name']);

                if($X < 1)
                {
                    echo"<a href='creerStand.php'>Création d'un Stand</a>";
                }
                else{
                    echo"<a href='Accueil.php'>Oui</a>";
                }
            ?>
        </div>
    <footer>
		<?php
			if(isset($_SESSION['user_name'])){
				echo "vous êtes : ".$_SESSION['user_name'];
			}
				
		?>
        <a href="Accueil.php">Deconnexion</a>
    </footer>
    </body>
</html>
