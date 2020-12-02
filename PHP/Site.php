<?php 
    session_start();
    
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerStand.php");
    require_once("Objets/managerRessource.php");
    require_once("Objets/managerEmplacement.php");
	require_once("Objets/managerUtilisateur.php");
	require_once("Objets/managerPresentateur.php");
	
	$db = connect_bd();
	$managerPresentateur = new managerPresentateur($db);
    $managerStand = new managerStand($db);
    $managerRes = new managerRessource($db);
    $managerEmplacement = new managerEmplacement($db);
	$managerUtilisateur = new managerUtilisateur($db);

    $stands = $managerStand->selectStands();
    $stands->setFetchMode(PDO::FETCH_ASSOC);

    $emplacements = $managerEmplacement->selectEmplacements();
    $emplacements->setFetchMode(PDO::FETCH_ASSOC);
    $emplacements = $emplacements->fetchAll();

    $dom = new DOMDocument('1.0', 'iso-8859-1');
    echo '<input type="hidden" id="id" value="'.$_SESSION['user_id'].'">';
    echo '<input type="hidden" id="name" value="'.$_SESSION['user_name'].'">';
    echo '<input type="hidden" id="skin" value="'.$managerUtilisateur->selectSkin($_SESSION['user_id']).'">';
?>
<!DOCTYPE html>
<html>
    <head>
    	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
    	<link href="../CSS/style_salon.css" rel="stylesheet">
        <title>Ici c'est le site</title>
        <meta charset="utf-8">
		<script type="text/javascript" src="../JS/ScriptAJAXCommunicationUtilisateurPresentateur.js"></script>

		<style>
			* {
				z-index:0;
			}
			iframe {
				z-index:1;
				position: absolute;
				margin : 1%;
			}

			#closebutton {
				z-index:2;
				position:absolute;
				top:62;
				left:412;
			}
            
            		body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/*Button to open waiting line*/
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  left: 28px;
  width: 280px;
  z-index: 9;
  display: none;
}

/* The popup waiting line - hidden by default */
.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  left: 15px;
  border: 3px solid #f1f1f1;
  z-index: 50;
}

/* Add styles to the form container */
.form-container {
    width: 300px;
    max-width: 300px;
    padding: 10px;
    background-color: #5d8ab7;
    text-align: center;
    margin: 50% auto;
    
    
}

/* Set a style for the Join button */
/*
.form-container .btn1 {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.4;
  border: 3px solid chartreuse;
}
*/
            

            
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
#QuitterFile {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}

#gameSnake{
    position: fixed;
    left: 50%;
    margin-left: -300px;
    margin-top: -300px;
    top: 50%;
  
}
            
		</style>
    </head>
        
    <body>
    <header>
    	<div class="navbar">
            <h1>Titre du site</h1>
            <h2 class="titre2">Salon</h2>
            <div>
            	<a href="Accueil.php"><img src="../Contenus/images/logout-rounded.png" alt="Deconnexion" style="height:1.45em; width: 1.45em;"></a>
            	<a href="compteUtilisateur.php"><img src="../Contenus/images/Rouage.png" alt="Paramètres" style="height:1.45em; width: 1.45em;"></a>
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
    <div class="corps" id="corps">
		<div id="test"></div>
		<iframe id="jeu" width="500" height="500" style="display:none"></iframe>
		<button id="closebutton" style="display:none" onclick="fermerJeu();">Fermer le jeu</button>
		<canvas id="salon" width="500" height="500"></canvas>
	</div>

    <script>
			var Stand = [];

		  <?php foreach ($emplacements as $emplacement): ?>

				<?php $stand = $managerStand->selectStandByPos($emplacement["Position_X_Emplacement"],$emplacement["Position_Y_Emplacement"]); ?>
				<?php 

					$stmt = $managerRes->selectRessourceByStandId($stand->getId());
					$stmt->setFetchMode(PDO::FETCH_ASSOC);
					if($stmt->rowCount() > 0) {
						$result = $stmt->fetchAll();
						$img = "";
						foreach ($result as $row) {
							$img = $row["Lien_Ressource"];
						}
						if ((strpos($img, '.png') !== false)||(strpos($img, '.jpg') !== false) || (strpos($img, '.bmp') !== false)) {
	
						} else {
							$img = "null";
						}
					} else {
						$img = "null";
					}
					
					$presentateur = $managerPresentateur->selectPresentateurByStand($stand->getId());
					if ($presentateur->getNom() != "") {
						 $orga = $presentateur->getNom();
					} else {
						$orga = "";
					}
				

        		?>

					Stand.push({
						Id:'<?php echo $stand->getId()?>',
						nom:"<?php echo $stand->getLibelle()?>",
						categorie:"<?php echo $stand->getCategorie() ?>",
						Resume:"<?php echo $stand->getInformation() ?>",
						InfoActive:false,
						Background:"<?php echo $emplacement['Couleur_Element'] ?>",
						organisateur:"<?php echo $orga ?>",
						nbPersonne:0,
						X:<?php echo $emplacement['Position_X_Emplacement'] ?>,
						Y:<?php echo $emplacement['Position_Y_Emplacement'] ?>,
						image: '<?php echo $img ?>',
						cree:<?php echo !empty($stand->getPositionX())? "true" : "false"; ?>
				  	});

			  <?php endforeach ?>
			  const SCALE = 1;
			  const WIDTH = 32;
			  const HEIGHT = 48;
			  const SCALED_WIDTH = SCALE * WIDTH;
			  const SCALED_HEIGHT = SCALE * HEIGHT;
			  const CYCLE_LOOP = [0, 1, 0, 2];
			  const FACING_DOWN = 1;
			  const FACING_UP = 1;
			  const FACING_LEFT = 0;
			  const FACING_RIGHT = 1;
			  const FRAME_LIMIT = 12;
			  const MOVEMENT_SPEED = 1;
			  const COLLISION_OFFSET = 10

			  var keyPresses = {};
			  var currentDirection = FACING_DOWN;
			  var currentLoopIndex = 0;
			  var frameCount = 0;
			  var img = new Image();


			  var canvas = document.getElementById("salon");
			  var Clicker = false;

			  var ctx2d = canvas.getContext("2d");
			  var player = document.getElementById("player");

			  var size = 4;

			  var standWidth = canvas.width/size;
			  var standHeight = canvas.height/size;

			  var standCoordGridX = canvas.width/(size/1.5);
			  var standCoordGridY = canvas.height/(size/1.5);

			  var visiteur = {x:140,y:140,w:WIDTH,h:HEIGHT};

			  var currentColor = "red";
			  var inter;

		  function renderStand(stand) {
			  ctx2d.fillStyle = stand.Background;
			  ctx2d.fillRect((stand.X-1)*standCoordGridX,(stand.Y-1)*standCoordGridY,standWidth,standHeight);

			  ctx2d.font = '12px serif';
			  ctx2d.fillStyle = "white";
			  ctx2d.fillText(stand.nom, (stand.X-1)*standCoordGridX+5, (stand.Y-1)*standCoordGridY+15,100);
		  }

		  function collisionStand(stand) {
			  if (Clicker == false) {
				  if((visiteur.x+visiteur.w-COLLISION_OFFSET >= (stand.X-1)*standCoordGridX) && (visiteur.x+COLLISION_OFFSET <= (stand.X-1)*standCoordGridX+standWidth) && (visiteur.y+visiteur.h-COLLISION_OFFSET >= (stand.Y-1)*standCoordGridY) && (visiteur.y+COLLISION_OFFSET <= (stand.Y-1)*standCoordGridY+standHeight)) {
					  if (stand.cree && !stand.InfoActive) {
						  stand.InfoActive == true;
						  Information(stand);
					  }
				  } else {
					  if (stand.InfoActive) {
						  fermerfenetre(stand);
					  }
				  }
			  }
		  }

		  window.addEventListener('keydown', keyDownListener);
			  function keyDownListener(event) {
				  keyPresses[event.key] = true;
			  }

			  window.addEventListener('keyup', keyUpListener);
			  function keyUpListener(event) {
				  keyPresses[event.key] = false;
			  }

			  function loadImage() {
			  	  path = document.getElementById("skin").value;
			  	  //console.log("Console.log de path : "+path);
				  if (path == null) {
					  path = "Contenus/images/AVATAR/Man.png";
				  } 
				  img.src = '../'+path;
				  img.onload = function() {
					  window.requestAnimationFrame(gameLoop);
				  };
			  }

			  function drawFrame(frameX, frameY, canvasX, canvasY) {
				  ctx2d.drawImage(img,
								  frameX * WIDTH, frameY * HEIGHT, WIDTH, HEIGHT,
								  canvasX, canvasY, SCALED_WIDTH, SCALED_HEIGHT);
			  }

			  loadImage();

			  function gameLoop() {
				  ctx2d.clearRect(0, 0, canvas.width, canvas.height);
				  ctx2d.fillStyle =  "rgb(255,255,255)";
				  ctx2d.fillRect(0,0,canvas.width,canvas.height);

				  Stand.forEach(stand => {
					  renderStand(stand);

				  });

				  var hasMoved = false;

				  if (keyPresses.z || keyPresses.ArrowUp) {
					  moveCharacter(0, -MOVEMENT_SPEED, FACING_UP);
					  hasMoved = true;
				  } else if (keyPresses.s || keyPresses.ArrowDown) {
					  moveCharacter(0, MOVEMENT_SPEED, FACING_DOWN);
					  hasMoved = true;
				  }

				  if (keyPresses.q || keyPresses.ArrowLeft) {
					  moveCharacter(-MOVEMENT_SPEED, 0, FACING_LEFT);
					  hasMoved = true;
				  } else if (keyPresses.d || keyPresses.ArrowRight) {
					  moveCharacter(MOVEMENT_SPEED, 0, FACING_RIGHT);
					  hasMoved = true;
				  }

				  if (hasMoved) {
					  frameCount++;
					  if (frameCount >= FRAME_LIMIT) {
						  frameCount = 0;
						  currentLoopIndex++;
						  if (currentLoopIndex >= CYCLE_LOOP.length) {
							  currentLoopIndex = 0;
						  }
					  }
					  Stand.forEach(stand => {
						  collisionStand(stand);
					  })
				  }

				  if (!hasMoved) {
					  currentLoopIndex = 0;
				  }

				  drawFrame(CYCLE_LOOP[currentLoopIndex], currentDirection, visiteur.x, visiteur.y);

				  window.requestAnimationFrame(gameLoop);
			  }

			  function moveCharacter(deltaX, deltaY, direction) {
				  if (visiteur.x + deltaX > 0 && visiteur.x + SCALED_WIDTH + deltaX < canvas.width) {
					  visiteur.x += deltaX;
				  }
				  if (visiteur.y + deltaY > 0 && visiteur.y + SCALED_HEIGHT + deltaY < canvas.height) {
					  visiteur.y += deltaY;
				  }
				  currentDirection = direction;
			  }

		function Information (stand)
		{
		    var info = document.createElement("div");
		    var corps = document.getElementById("corps");
		    info.className = "InfoStand";
		    info.id = "Info";

		    corps.appendChild(info);

		    var titre = document.createElement("h1");
		    titre.innerHTML = stand.nom;
		    document.getElementById("Info").appendChild(titre);

		    var phrase =document.createElement("p");
		    phrase.innerHTML = "Catégorie : "+stand.categorie;
		    document.getElementById("Info").appendChild(phrase);

		    var phrase =document.createElement("p");
		    phrase.innerHTML = "Organisateur : "+stand.organisateur;
		    document.getElementById("Info").appendChild(phrase);

		    var phrase =document.createElement("p");
		    phrase.innerHTML = stand.Resume;
		    document.getElementById("Info").appendChild(phrase);

		    var phrase =document.createElement("p");
		    phrase.innerHTML = "Nombre de personnes : "+stand.nbPersonne;
		    document.getElementById("Info").appendChild(phrase);

		    var filAttend = document.createElement("button"); //bouton pour rentrer dans la file d'attente
		    filAttend.id = "Attend";
		    filAttend.innerHTML = "Entrée dans la file d'attente";
		    filAttend.addEventListener("click",function(){FileAttentePopUp(stand)});
		    document.getElementById("Info").appendChild(filAttend);

		    /*
		    var fermer = document.createElement("button");
		    fermer.id = "Fermeture";
		    fermer.innerHTML = "Fermer";
		    fermer.addEventListener("click",fermerfenetre);
		    document.getElementById("Info").appendChild(fermer);
		    */
		    stand.InfoActive = true;
		}

		/*================================================
		Partie File Attente + Game
		================================================*/

//		var seconds = 0;
//		var min = 0;
//		var time=0;
//        var timer;
//		time = setInterval(function()
//		{
//		seconds++;
//		if (seconds >= 60){
//
//		min++;
//        seconds=0;
//        //console.log(min+ " "+seconds);
//		}
//        timer = document.getElementById("TimeInLine").innerHTML = min + "M" + seconds + "S";
//		}, 1000);
		function FileAttentePopUp(stand){

			rentrerEnFile(stand.nom,document.getElementById('name').value);
			
			var openButton = document.createElement("button");
			openButton.className = "open-button";
			openButton.onclick = "openForm()";
			openButton.innerHTML = "Waiting Line";

			var chatPopup = document.createElement("div");
			chatPopup.className = "chat-popup";
			chatPopup.id = "myForm";

			var formContainer = document.createElement("div");
			formContainer.className = "form-container";
			formContainer.id = "form-container";
            

			var waitline = document.createElement("h1");
		    waitline.id= "TitreFile";
		    waitline.innerHTML = "File Attente";
		    formContainer.appendChild(waitline);

			var standName = document.createElement("h1");
		    standName.id= "stand-Name";
		    standName.innerHTML = stand.nom;
		    formContainer.appendChild(standName);

//			var peopleInLine = document.createElement("p");
//			peopleInLine.innerHTML = "People in waiting line: " + stand.nbPersonne;
//			formContainer.appendChild(peopleInLine);

//			var TimeInLine = document.createElement("p");
//			TimeInLine.innerHTML = "Time in waiting line: " + timer; //Problem
//			formContainer.appendChild(TimeInLine);

			var butPlay = document.createElement("button");
			butPlay.type = "submit";
			butPlay.className = "btn";
			butPlay.onclick = "playGame()";
			butPlay.innerHTML = "Play";
			formContainer.appendChild(butPlay);

//			var butJoin = document.createElement("button");
//			butJoin.type = "submit";
//			butJoin.className = "btn1";
//			butJoin.innerHTML = "Join";
//			formContainer.appendChild(butJoin);

			var filQuitter= document.createElement("button"); //creation bouton pour quitter la file d'attente
		    filQuitter.type = "submit";
			filQuitter.id= "QuitterFile";
		    filQuitter.className ="btn";
		    filQuitter.innerHTML = "Quitter la file";
			formContainer.appendChild(filQuitter);

		    filQuitter.addEventListener("click", QuitterFileAtt);

		    

			//var butCancel = document.createElement("button");
//			butJoin.type = "submit";
//			butJoin.className = "btn cancel";
//			butJoin.onclick = "closeForm()";
//			butJoin.innerHTML = "Close";
			//formContainer.appendChild(butCancel);
            //document.body.appendChild(formContainer);
            document.getElementById("test").prepend(formContainer);

			butPlay.addEventListener("click", function() {
				Lejeu(stand.image);
			});

			function QuitterFileAtt ()//fonction pour quitter la file d'attente
		    {
		        //console.log("normalement j'ai quitté fdp");
		        effacer = document.getElementById("form-container");
		        effacer.parentElement.removeChild(effacer);

		        //NOTE R.S. : Appeler la fonction quitter la file.
		        quitterFile();

		    }

			function Lejeu(img)
		    {
		        console.log("Je joue !");
				jeu = document.getElementById("jeu");
				jeu.style.display = "block";
				jeu.setAttribute("src","../HTML/GameSnake.html?"+img);
				close = document.getElementById("closebutton");
				close.style.display = "block";
				jeu.focus();
		    }

			function openForm() {
			document.getElementById("myForm").style.display = "block";
			}

			function closeForm() {
			document.getElementById("myForm").style.display = "none";
			}

		}
		    function fermerfenetre (stand)
		    {
		        effacer =document.getElementById("Info");
		        effacer.parentElement.removeChild(effacer);
		        //Stand[saveInfo].InfoActive = false;
		        stand.InfoActive = false;
		        Clicker = false;
		    }

			function fermerJeu()
			{
				jeu = document.getElementById("jeu");
				jeu.style.display = "none";
				jeu.setAttribute("src","");
				close = document.getElementById("closebutton");
				close.style.display = "none";
			}
	</script>
    <footer>
    </footer>
    </body>
</html>
