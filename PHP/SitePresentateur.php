<?php
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerPresentateur.php");

    $conn = connect_bd();

    session_start();

    $dom = new DOMDocument('1.0', 'iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
        <title>Ici c'est le site présentateur</title>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
        <div class="navbar">
            <h1>Titre du site</h1>
            <h2 class="titre1">Site présentateur</h2>
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
		
    </footer>
    </body>
</html>
