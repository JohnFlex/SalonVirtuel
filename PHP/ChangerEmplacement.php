<?php

	//fonction permettant la connexion
//	function ConnecServ(){
//			
//		//mise en place du script de connexion
//			$dsn="mysql:dbname=".BASE.";host=".SERVEUR;
//			
//		//tentative de connexion � la base de donn�es
//			try{
//				$connexion=new PDO($dsn,USER,PASSWD);
//			}
//			
//		//affichage d'�ventuelles erreurs
//			catch(PDOExecption $e){
//				printf("Echec de la connexion : %s\n", $e->getMessage());
//				exit();
//			}
//			
//		//renvoi de la connexion
//			return $connexion;
//	}
//	// Send variables for the MySQL database class.
//	//nom du serveur
//		define('SERVEUR',"ormcomcplh778.mysql.db");
//
//	//nom de la base de donn�es
//		define('BASE',"ormcomcplh778");
//
//	//nom de l'utisateur
//		define('USER',"ormcomcplh778");
//
//	//mot de passe
//		define('PASSWD',"R8frzgZzN5S8");
//
//			
//	$conn = ConnecServ();

    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerUtilisateur.php");
	require_once("Objets/managerPresentateur.php");
    require_once("Objets/managerAdministrateur.php");
    require_once("Objets/managerEmplacement.php");
    require_once("Objets/managerStand.php");
    
    $conn = connect_bd();
    $managerStand = new managerStand($conn);
    $managerEmplacement = new managerEmplacement($conn);

	if(isset($_POST["ID_Stand"])){
        $previousStand = $managerStand->selectStandById($_POST['ID_Stand']);
        $previousEmplacement = $managerEmplacement->selectEmplacementById($previousStand->getPositionX(),$previousStand->getPositionY());
        $couleur = $previousEmplacement->getCouleur();

        $previousEmplacement->setCouleur("#000000");
        $managerEmplacement->updateEmplacement($previousEmplacement);
        
        $pos = $_POST["Position"];

        $pos = explode(";",$pos);

        $mStand = array(
            "Id" => $_POST['ID_Stand'],
            "PositionX" => $pos[0],
            "PositionY" => $pos[1]
        );

        $stand = new Stand;
        $stand->hydrate($mStand);
        $managerStand->updateStandEmplacement($stand);

        $mEmplacement = array(
            "PositionX" => $pos[0],
            "PositioNY" => $pos[1],
            "Couleur" => $couleur
        );

        $emplacement = new Emplacement;
        $emplacement->hydrate($mEmplacement);

        $managerEmplacement->updateEmplacement($emplacement);

        header("Location: ChangerEmplacement.php");

	}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    
  </head>
  <body>
      
      <header>
            <div class="navbar">
                <h1><a href="SiteAdministrateur.php" class="TitreSite" >Titre du site</a></h1>
                <h2 class="titre2">Changer l'emplacement d'un stand</h2>
                
                <div>
                    <a href="Accueil.php">Deconnexion</a>
                
                    <a href="SwitchPresentateurUtilisateur.php"> Administration des roles</a>
                    <a href="LiaisonAUnStand.php">Liaison au stand</a>
                    
                    
                </div>
            </div>
        </header>
      
    
    <div class="ChangerEmplacement"> 
        <h1>Changer l'emplacement d'un stand</h1>

        <form action="#" method="post" id="CHANGEREMPLACEMENT" name="ChangerEmplacementStand">

            <?php
                echo "<label>Stand : </label>";
                echo "<select name=\"ID_Stand\">";
                $stmt = $managerStand->selectStands();
                foreach($stmt as $row){
                    echo "<option value=\"".$row['ID_Stand']."\">".$row["ID_Stand"]."- ".$row['Libelle_Stand']."</option>";
                }
                echo "</select><br>";

                echo "<label>Emplacement : </label>";
                echo "<select name=\"Position\">";
                $stmt = $managerEmplacement->selectEmplacements();
                foreach($stmt as $row){
                    echo "<option value=\"".$row['Position_X_Emplacement'].";".$row['Position_Y_Emplacement']."\">".$row["Position_X_Emplacement"]."- ".$row['Position_Y_Emplacement']."</option>";
                }
                echo "</select><br>";
            ?>

            <input type="submit" value="Valider" id="BOUTONLSP" name="BoutonLSP" />

        </form><br>
    </div> 
	
    <footer>
<!--        <a href="SiteAdministrateur.php">Retour Accueil</a>-->
    </footer>
  </body>
</html>