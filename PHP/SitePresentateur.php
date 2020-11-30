<?php
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerPresentateur.php");

    $conn = connect_bd();

    session_start();
    if isset($_SESSION["user_id"])
    {
        echo '<input type="hidden" id="id" value="'.$_SESSION["user_id"].'"/>';
    }

    $dom = new DOMDocument('1.0', 'iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
        <title>Ici c'est le site présentateur</title>
    </head>
    <body>
        <header>
            <div class="navbar">
                <h1>Titre du site</h1>
                <h2 class="titre3">Site présentateur</h2>
                <div class="cssAdmin">
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
                        }
                    ?>
                </div>
            </div>
        </header>
        <div id="container" class="container">
            <?php
                $mP = new managerPresentateur($conn);

                $X = $mP->issetStand($_SESSION['user_name']);

                if($X < 1)
                {
                    echo"<a href='creerStand.php'><img src='../Contenus/images/STANDS/Stand02_RotateA.png' alt='Image de Stand'>Création d'un Stand</a>";
                }
                else
                {
                    echo"<a href='modifierStand.php'><img src='../Contenus/images/STANDS/Stand02_RotateA.png' alt='Image de Stand'>Gestion d'un Stand</a>";

                    $_SESSION['stand_id']=$X;

                    <echo '<script type="text/javascript" src="../JS/ScriptAJAXPresentateur.js"></script>';
                }

                /*var_dump($_SESSION['user_name']);
                var_dump($_SESSION["stand_id"]);*/
            ?>
        </div>
    <footer>
    </footer>
    </body>
</html>
