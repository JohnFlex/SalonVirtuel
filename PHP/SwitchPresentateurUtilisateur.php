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
		$sql="insert into DB_SALON_Utilisateur(ID_Avatar,Nom_Avatar,MDP_Utilisateur) SELECT ID_Avatar, Nom_Avatar, MDP_Presentateur FROM DB_SALON_Presentateur WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$sql="DELETE FROM DB_SALON_Presentateur WHERE ID_Avatar=".$_POST["SELECTPRESENTATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		echo "success";
	}

	if(isset($_POST["SELECTUTILISATEUR"])){
		$sql="insert into DB_SALON_Presentateur(ID_Avatar,Nom_Avatar,MDP_Presentateur,ID_Activite,ID_Stand) SELECT ID_Avatar, Nom_Avatar, MDP_Utilisateur,".$_POST["SELECTSTATUE"].",NULL FROM DB_SALON_Utilisateur WHERE ID_Avatar=".$_POST["SELECTUTILISATEUR"].";";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		$sql="DELETE FROM DB_SALON_Utilisateur WHERE ID_Avatar=".$_POST["SELECTUTILISATEUR"].";";
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
	<?php

		if(!isset($_SESSION['user_name'])){
			session_start();

			$_SESSION['user_name']="guestTest";

			$_SESSION['user_ID']=0;

		}else{
			echo "vous êtes : ".$_SESSION['user_name'];
		}
	?>
    
	<h1>Changer un présentateur en utilisateur</h1>

	<form action="#" method="post" id="PRESENTATEURTOUTILISATEUR" name="PresentateurToUtilisateur">

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

	<h1>Changer un utilisateur en présentateur</h1>

	<form action="#" method="post" id="UTILISATEURTOPRESENTATEUR" name="UtilisateurToPresentateur">

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
	
    <footer>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
  </body>
</html>
