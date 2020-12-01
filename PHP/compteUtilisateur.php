<?php 
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerUtilisateur.php");

    $db = connect_bd();

    session_start();
    $dom = new DOMDocument('1.0', 'iso-8859-1');
    echo '<input type="hidden" id="id" value="'.$_SESSION['user_id'].'">';
    echo '<input type="hidden" id="name" value="'.$_SESSION['user_name'].'">';

	if(isset($_GET["ID"]))
	{
		$managerUtilisateur = new managerUtilisateur($db);

		$B = $managerUtilisateur->changeSkin($_SESSION['user_name'], $_GET["ID"]);

		header("Location: Site.php");
	}
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

		            	$link->setAttribute("href", "Site.php");

		            	$dom->appendChild($link);

		            	echo $dom->saveHTML();

		            	$dom->removeChild($link);

		                //echo "<a href=''>".$_SESSION['user_name']."</a>";
		            }      
		        ?>
            </div>
        </div>
    </header>

    <form method="GET" action="#" class="Connexion">

		<label for="ID">Skin : </label>
		<div>
			<label>HOMME 1 : </label><input type="radio" name="ID" value="1"> <img src="../Contenus/images/AVATAR/man.png" class="imgAvatar">
			<label>HOMME 2 : </label><input type="radio" name="ID" value="2"> <img src="../Contenus/images/AVATAR/man2.png" class="imgAvatar">
			<label>HOMME 3 : </label><input type="radio" name="ID" value="3"> <img src="../Contenus/images/AVATAR/man3.png" class="imgAvatar">
			<label>FEMME 1 : </label><input type="radio" name="ID" value="4"> <img src="../Contenus/images/AVATAR/Woman.png" class="imgAvatar">
			<label>FEMME 2 : </label><input type="radio" name="ID" value="5"> <img src="../Contenus/images/AVATAR/Woman2.png" class="imgAvatar">
			<label>FEMME 3 : </label><input type="radio" name="ID" value="6"> <img src="../Contenus/images/AVATAR/Woman3.png" class="imgAvatar">
		</div>
		<input type="submit" name="sub" id="sup" value="Valider">
	</form>

    <footer>
    </footer>
    </body>
</html>
