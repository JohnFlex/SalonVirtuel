<?php
	require_once("PDO_Connect/PDO_Connect.php");
	require_once("Objets/managerPresentateur.php");
	require_once("Objets/managerUtilisateur.php");
	require_once("Objets/objUtilisateur.php");

	$conn = connect_bd();

	if(isset($_POST["SELECTPRESENTATEUR"])){
		$sql="insert into DB_SALON_Utilisateur(ID_Avatar,Nom_Avatar,MDP_Utilisateur) SELECT ID_Avatar, Nom_Avatar, MDP_Presentateur FROM DB_SALON_Presentateur WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$sql="DELETE FROM DB_SALON_Presentateur WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		echo "success";
	}

	$mP = new managerPresentateur($conn);
	$mU = new managerUtilisateur($conn);

	if(isset($_POST["SELECTUTILISATEUR"]) && isset($_POST["SELECTSTATUE"])){
		$U = new Utilisateur;

		$U = $mU->selectUtilisateurById($_POST["SELECTUTILISATEUR"]);

		$X = $mP->insertPresentateur($U);
		if($X)
		{
			echo "success";
		}else{
			echo "Failure";
		}
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
                <h2 class="titre2">Administration des roles</h2>
                
                <div >
                    <a href="Accueil.php">Deconnexion</a>
                
                    <a href="LiaisonAUnStand.php">Liaison au stand</a>
                    
                </div>
            </div>
        </header>
        <div>
            <div class="formeT1">
            <h1>Changer un présentateur en utilisateur</h1>

            <form action="#" method="post" id="PRESENTATEURTOUTILISATEUR" name="PresentateurToUtilisateur" >

                <?php

                    echo "<select name=\"SELECTPRESENTATEUR\">";
                    $sql="SELECT * FROM `DB_SALON_Presentateur` ";
                    foreach($conn->query($sql) as $row){
                        echo "<option value=\"".$row['ID_Avatar']."\">".$row['Nom_Avatar']."</option>";
                    }
                    echo "</select><br>";
                ?>

                <input type="submit" value="Valider" id="BOUTONPTU" name="BoutonPTU" />

            </form><br>
        </div>
              <div class="formeT2">
            <h1>Changer un utilisateur en présentateur</h1>

            <form action="#" method="post" id="UTILISATEURTOPRESENTATEUR" name="UtilisateurToPresentateur" >

                <?php

                    echo "<select name=\"SELECTUTILISATEUR\">";
                    $sql="SELECT * FROM `DB_SALON_Utilisateur` ";
                    foreach($conn->query($sql) as $row){
                        echo "<option value=\"".$row['ID_Avatar']."\">".$row['Nom_Avatar']."</option>";
                    }
                    echo "</select><br>";
                    echo "<select name=\"SELECTSTATUE\">";
                    $sql="SELECT * FROM `DB_SALON_Activite` ";
                    foreach($conn->query($sql) as $row){
                        echo "<option value=\"".$row['ID_Activite']."\">".$row['Libelle_Activite']."</option>";
                    }
                    echo "</select><br>";
                ?>

                <input type="submit" value="Valider" id="BOUTONUTP" name="BoutonUTP" />

            </form><br>
            </div>
        </div>
    <footer>
<!--        <a href="Accueil.php">Retour Accueil</a>-->
    </footer>
  </body>
</html>
