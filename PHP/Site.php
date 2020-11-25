<?php 
    require_once ("PDO_Connect/PDO_Connect.php");
    require_once ("Objets/managerStand.php");
    session_start();

    $dom = new DOMDocument('1.0', 'iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
    	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
        <title>Ici c'est le site</title>
        <meta charset="utf-8">
    </head>
    <body>
    <header>
    	<div class="navbar">
            <h1>Titre du site</h1>
            <h2 class="titre1">Salon</h2>
            <div>
            	<a href="Accueil.php">Deconnexion</a>
                <?php
		            if(isset($_SESSION['user_name']))
		            {
		            	$link = $dom->createElement('a');

		            	$noeudTexteLink = $dom->createTextNode("Compte : ".$_SESSION['user_name']);

		            	$link->appendChild($noeudTexteLink);

		            	$dom->appendChild($link);

		            	echo $dom->saveHTML();

		            	$dom->removeChild($link);

		                //echo "<a href=''>".$_SESSION['user_name']."</a>";
		            }      
		        ?>
            </div>
        </div>
    </header>
        <?php
            $managerStand = new managerStand(connect_bd());
            
            $resultat = $managerStand->selectStands();
            $resultat=$resultat->fetchAll();

            echo "<h3>Liste des stands</h3>";

            $ul = $dom->createElement("ul");

            foreach ($resultat as $result)
            {
            	$li = $dom->createElement("li");
            	$noeudTexteLi = $dom->createTextNode($result["Libelle_Stand"]);

            	$li->appendChild($noeudTexteLi);

            	$ul->appendChild($li);
            }

            $dom->appendChild($ul);
            echo $dom->saveHTML();

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
    </footer>
    </body>
</html>
