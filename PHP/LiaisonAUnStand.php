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
    
    $conn = connect_bd();

	if(isset($_POST["SELECTPRESENTATEUR"])){
		$sql="UPDATE DB_SALON_Presentateur SET ID_Stand=".$_POST["SELECTSTAND"]." WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		echo "success";
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
                <h2 class="titre2">Liaison au stand</h2>
                
                <div>
                    <a href="Accueil.php"><img src="../Contenus/images/logout-rounded.png" alt="Deconnexion" style="height:1.45em; width: 1.45em;"></a>
                
                    <a href="SwitchPresentateurUtilisateur.php"> Administration des roles</a>
                    <a href="ChangerEmplacement.php">Changer l'emplacement d'un stand</a>
                    
                    
                </div>
            </div>
        </header>
      
    
    <div class="LiaisonPresentStand"> 
        <h1>Li� un pr�sentateur � un stand</h1>

        <form action="#" method="post" id="LIAISONPRESENTATEURSTAND" name="LiasonPresentateurStand">

            <?php

                echo "<select name=\"SELECTPRESENTATEUR\">";
                $sql="SELECT * FROM `DB_SALON_Presentateur` ";
                foreach($conn->query($sql) as $row){
                    if($row['ID_Stand']!=NULL){
                        $sql2="SELECT * FROM DB_SALON_Stand WHERE ID_Stand = ".$row['ID_Stand'];
                        foreach($conn->query($sql2) as $row2){
                            echo "<option value=\"".$row['ID_Avatar']."\">".$row['Nom_Avatar']." (stand : ".$row2["ID_Stand"]."- ".$row2["Libelle_Stand"].")</option>";
                        }
                    }else{
                        echo "<option value=\"".$row['ID_Avatar']."\">".$row['Nom_Avatar']."</option>";
                    }
                }
                echo "</select><br>";
                echo "<select name=\"SELECTSTAND\">";
                $sql="SELECT * FROM `DB_SALON_Stand` ";
                foreach($conn->query($sql) as $row){
                    echo "<option value=\"".$row['ID_Stand']."\">".$row["ID_Stand"]."- ".$row['Libelle_Stand']."</option>";
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