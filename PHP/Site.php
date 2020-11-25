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

            $tabStand=Array();

            $tabStandDispo=Array();

            //echo "<h3>Liste des stands</h3>";
            foreach ($resultat as $result)
            {
                //var_dump($result);
                array_push($tabStand,$result["Libelle_Stand"]);
                //echo "<div>".$result["Libelle_Stand"]."</div>";
            }

            $resultat = $managerStand->selectStandsDispo();
            //var_dump($resultat);
            $resultat=$resultat->fetchAll();
            //var_dump($resultat);
            //echo "<h3>Liste des stands disponibles</h3>";
            foreach ($resultat as $result)
            {
                //var_dump($result);
                array_push($tabStandDispo,$result["Libelle_Stand"]);
                //echo "<div>".$result["Libelle_Stand"]."</div>";
            }

            $dom = new DOMDocument("1.00","iso-8859-1");
            //echo "<h3>Document créé</h3>";
            foreach ($tabStand as $stand)
            {
                //var_dump($stand);
                if(in_array($stand, $tabStandDispo))
                {
                    $div = $dom->createElement("div");
                    $h3 = $dom->createElement("h3",$stand);
                    $button = $dom->createElement("button","Rejoindre la file d'attente");

                    $div->appendChild($h3);
                    $div->appendChild($button);

                    $dom->appendChild($div);
                }
                else
                {
                    $div = $dom->createElement("div");
                    $h3 = $dom->createElement("h3",$stand);

                    $div->appendChild($h3);

                    $dom->appendChild($div);
                }
            }
            echo $dom->saveHTML();
        ?>
    <footer>
        <a href="Accueil.php">Deconnexion</a>
        <?php
            var_dump($_SESSION);
        ?>
    </footer>
    </body>
</html>
