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
		define('SERVEUR',"localhost");

	//nom de la base de données
		define('BASE',"db_salon");

	//nom de l'utisateur
		define('USER',"root");

	//mot de passe
		define('PASSWD',"");

			
	$conn = ConnecServ();

	if(isset($_POST["SELECTPRESENTATEUR"])){
		$sql="insert into utilisateur(ID_Avatar,Nom_Avatar,MDP_Utilisateur) SELECT ID_Avatar, Nom_Avatar, MDP_Presentateur FROM presentateur WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$sql="DELETE FROM presentateur WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
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
    
	<h1>Changer un présentateur en utilisateur</h1>

	<form action="#" method="post" id="PRESENTATEURTOUTILISATEUR" name="PresentateurToUtilisateur">

		<?php
			
			echo "<select name=\"SELECTPRESENTATEUR\">";
			$sql="SELECT * FROM `presentateur` ";
			foreach($conn->query($sql) as $row){
				echo "<option value=\"".$row['ID_Avatar']."\">".$row['Nom_Avatar']."</option>";
			}
			echo "</select><br>";
		?>
		
		<input type="submit" value="Valider" id="BOUTONPTU" name="BoutonPTU" />

	</form>

  </body>
</html>
