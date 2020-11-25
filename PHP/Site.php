<?php 
    require_once ("PDO_Connect/PDO_Connect.php");
    require_once ("Objets/managerStand.php");
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ici c'est le site</title>
        <meta charset="utf-8">
    </head>
    <body>
    <header>
        <?php
            if(isset($_SESSION['user_name'])){
                echo "vous êtes : ".$_SESSION['user_name'];
            }      
        ?>
    </header>
        <h1>Site</h1>
        <?php
            $managerStand = new managerStand(connect_bd());
            
            $resultat = $managerStand->selectStands();
            //var_dump($resultat);
            $resultat=$resultat->fetchAll();

            echo "<h3>Liste des stands</h3>";
            foreach ($resultat as $result)
            {
                //var_dump($result);
                echo "<div>".$result["Libelle_Stand"]."</div>";
            }

            $resultat = $managerStand->selectStandsDispo();
            //var_dump($resultat);
            $resultat=$resultat->fetchAll();
            //var_dump($resultat);
            echo "<h3>Liste des stands disponibles</h3>";
            foreach ($resultat as $result)
            {
                //var_dump($result);
                echo "<div>".$result["Libelle_Stand"]."</div>";
            }
        ?>
    <footer>
        <a href="Accueil.php">Deconnexion</a>
    </footer>
    </body>
</html>
