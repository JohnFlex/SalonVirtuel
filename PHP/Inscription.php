<!Doctype HTML>
<HTML>
	<HEAD>
		<meta charset="utf-8"/>
		<title>Inscription</title>
		<lang = fr/>
		<style type="text/css"></style>
		<link rel="stylesheet" type="text/css" href=""> 
		<link rel="shortcut icon" type="image/x-icon" href="">     
	</HEAD>
	<BODY>
		<?php

			if(!isset($_SESSION['user_name'])){
				session_start();

				$_SESSION['user_name']="guestTest";

				$_SESSION['user_ID']=0;

			}else{
				echo "vous êtes : ".$_SESSION['user_name'];
			}
		?>

		<form method="POST" action="finInscription.php">
			<label for="nom">Pseudo : </label><input type="text"  id="pseudo" name="nom" placeholder="Pseudo" oninput="verifNom(v1);v1=verifNom(v1);verifAllTrue(v1,v2,v3);" onchange="" required><span class="desc">ne pas utiliser de caracter spécial</span><br>
			<label for="mdp"> Mot de Passe : </label><input type="password" id="pass" name="mdp" placeholder="password"  oninput="verifPassword(v2); v2 =verifPassword(v2);verifAllTrue(v1,v2,v3);" required><span class="desc">doit au moins contenir 1 Majuscule, 1 Minuscule et 1 Chiffre</span><br>
			<label for="cmdp"> Confirmation Mot de Passe : </label><input type="password" id="cpass" name="cmdp" oninput="verifCPassword(v3); v3 = verifCPassword(v3);verifAllTrue(v1,v2,v3);" placeholder="password" required><br> 
			<input type="submit" name="sub" id="sup" value="s'inscrire" disabled="true">
		</form>

		<script type="text/javascript">
			
			let v1 = false;
			let v2 = false;
			let v3 = false;

			function verifNom(v1)
			{
				v1 = true;
				let i= 0;
				let nom = document.getElementById('pseudo');
				let regex = /[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]/;
				
				while(v1 && (i < nom.value.length))
				{
					//console.log(nom.value);
					//console.log(nom.value.substring(i,i+1));
   					
  					if(!nom.value.substring(i,i+1).match(regex))
  					{
  						v1 = false;
  					}
  					//console.log(v1);
  					i++;
  				}



  				if (v1) 
  				{
  					nom.style.backgroundColor = "#2ecc71";
  				}
  				else
  				{
  					nom.style.backgroundColor = "#B53471";
  				}	
  				return v1;
			}


			function verifPassword(v2)
			{
				v2 = true;
				let i= 0;
				let nom = document.getElementById('pass');
				let regex1 = /[a-z]/;
				let regex2 = /[A-Z]/;
				let regex3 = /[0-9]/;

				
   				//console.log(nom.value);
  				if(!nom.value.match(regex1) || !nom.value.match(regex2) || !nom.value.match(regex3))
  				{
	  					v2 = false;
	  				}
	  				//console.log(v);
	  			if (v2) 
	  			{
	  				nom.style.backgroundColor = "#2ecc71";
	  			}
	  			else
	  			{
	  				nom.style.backgroundColor = "#B53471";
	  			}	
	  			return v2;
			}

				function verifCPassword(v3)
				{
					v3 = true;
					let nom1 = document.getElementById('pass');
					let nom2 = document.getElementById('cpass');


					if (nom1.value != nom2.value) 
					{
						v3 = false;
					}

					if (v3) 
	  				{
	  					nom2.style.backgroundColor = "#2ecc71";
	  				}
	  				else
	  				{
	  					nom2.style.backgroundColor = "#B53471";
	  				}

	  				return v3;
				}

				function verifAllTrue(v1,v2,v3)
				{
					let sub = document.getElementById("sup");
					if (v1 && v2 && v3)
					{
						sub.disabled =false;
					}
					else
					{
						sub.disabled = true;
					}
				}

			</script>

		<!-- faire un formulaire de recherche de personne avec le nom ou prenom ou email ou date de naissance (banParam,banValues) -->
	
    <footer>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
	</BODY>
</HTML>
