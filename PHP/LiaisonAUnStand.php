<?php

	//fonction permettant la connexion
	function ConnecServ(){
			
		//mise en place du script de connexion
			$dsn="mysql:dbname=".BASE.";host=".SERVEUR;
			
		//tentative de connexion à la base de données
			try{
				$connexion=new PDO($dsn,USER,PASSWD);
			}
			
		//affichage d'éventuelles erreurs
			catch(PDOExecption $e){
				printf("Echec de la connexion : %s\n", $e->getMessage());
				exit();
			}
			
		//renvoi de la connexion
			return $connexion;
	}
	// Send variables for the MySQL database class.
	//nom du serveur
		define('SERVEUR',"ormcomcplh778.mysql.db");

	//nom de la base de données
		define('BASE',"ormcomcplh778");

	//nom de l'utisateur
		define('USER',"ormcomcplh778");

	//mot de passe
		define('PASSWD',"R8frzgZzN5S8");

			
	$conn = ConnecServ();

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
    
  </head>
  <body>
    
	<h1>Lié un présentateur à un stand</h1>

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
	
    <footer>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
  </body>
</html>