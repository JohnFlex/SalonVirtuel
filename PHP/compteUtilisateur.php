<?php 
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerStand.php");
    require_once("Objets/managerRessource.php");
    require_once("Objets/managerEmplacement.php");

    $db = connect_bd();

    session_start();
    $dom = new DOMDocument('1.0', 'iso-8859-1');
    echo '<input type="hidden" id="id" value="'.$_SESSION['user_id'].'">';
    echo '<input type="hidden" id="name" value="'.$_SESSION['user_name'].'">';
?>
<!DOCTYPE html>
<html>
    <head>
    	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
    	<link href="../CSS/style_salon.css" rel="stylesheet">
        <title>Gestion du compte</title>
        <meta charset="utf-8">
        <script type="text/javascript" src="../JS/ScriptAJAXCommunicationUtilisateurPresentateur.js"></script>
    </head>
    <body>
    <header>
    	<div class="navbar">
            <h1>Titre du site</h1>
            <h2 class="titre2">Gestion du compte</h2>
            <div>
            	<a href="Accueil.php">Deconnexion</a>
                <?php
		            if(isset($_SESSION['user_name']))
		            {
		            	$link = $dom->createElement('a');

		            	$noeudTexteLink = $dom->createTextNode("Compte : ".$_SESSION['user_name']);

		            	$link->appendChild($noeudTexteLink);

		            	$link->setAttribute("href", "site.php");

		            	$dom->appendChild($link);

		            	echo $dom->saveHTML();

		            	$dom->removeChild($link);

		                //echo "<a href=''>".$_SESSION['user_name']."</a>";
		            }      
		        ?>
            </div>
        </div>
    </header>

	   

    <footer>
    </footer>
    </body>
</html>
