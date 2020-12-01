<?php 
    require_once("PDO_Connect/PDO_Connect.php");
    require_once("Objets/managerStand.php");
    require_once("Objets/managerRessource.php");
    require_once("Objets/managerEmplacement.php");

    $db = connect_bd();
    $managerStand = new managerStand($db);
    $managerRes = new managerRessource($db);
    $managerEmplacement = new managerEmplacement($db);

    $stands = $managerStand->selectStands();
    $stands->setFetchMode(PDO::FETCH_ASSOC);

    $emplacements = $managerEmplacement->selectEmplacements();
    $emplacements->setFetchMode(PDO::FETCH_ASSOC);
    $emplacements = $emplacements->fetchAll();

    session_start();
    $dom = new DOMDocument('1.0', 'iso-8859-1');
    echo '<input type="hidden" id="id" value="'.$_SESSION['user_id'].'">';
    echo '<input type="hidden" id="name" value="'.$_SESSION['user_name'].'">';
?>
<!DOCTYPE html>
<html>
    <head>
    	<link rel="stylesheet" type="text/css" href="../CSS/style.css">
    	<link href="../CSS/style_salon.css" rel="stylesheet">
        <title>Ici c'est le site</title>
        <meta charset="utf-8">
        <script type="text/javascript" src="../JS/ScriptAJAXCommunicationUtilisateurPresentateur.js"></script>
    </head>
    <body>
    <header>
    	<div class="navbar">
            <h1>Titre du site</h1>
            <h2 class="titre2">Salon</h2>
            <div>
            	<a href="Accueil.php">Deconnexion</a>
                <?php
		            if(isset($_SESSION['user_name']))
		            {
		            	$link = $dom->createElement('a');

		            	$noeudTexteLink = $dom->createTextNode("Compte : ".$_SESSION['user_name']);

		            	$link->appendChild($noeudTexteLink);

		            	$link->setAttribute("href", "compteUtilisateur.php");

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
    	<canvas id="salon" width="500" height="500"></canvas>
	</div>

	<?php 
	$file_pointer = 'Content_Game/Fenetre_file_attente.html';
	if (file_exists($file_pointer)) {
		echo "The file $file_pointer exists";
	}else {
		echo "The file $file_pointer does not exists";
	}
	
	?>

    <script>
				var Stand = [];
		  
		  <?php foreach ($emplacements as $emplacement): ?>
				  
			  <?php $stand = $managerStand->selectStandByPos($emplacement["Position_X_Emplacement"],$emplacement["Position_Y_Emplacement"]) ?>
					  Stand.push({
						  Id:'<?php echo $stand->getId()?>',
						  nom:'<?php echo $stand->getLibelle()?>',
						  categorie:'<?php echo $stand->getCategorie() ?>',
						  Resume:'<?php echo $stand->getInformation() ?>',
						  InfoActive:false,
						  Background:"<?php echo $emplacement['Couleur_Element'] ?>",
						  organisateur:"Organisateur",
						  nbPersonne:0,
						  X:<?php echo $emplacement['Position_X_Emplacement'] ?>,
						  Y:<?php echo $emplacement['Position_Y_Emplacement'] ?>,
					  
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
				  img.src = '../Contenus/images/AVATAR/Man.png';
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
		    phrase.innerHTML = stand.organisateur;
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
		    filAttend.addEventListener("click",function(){FileAttente(stand.nom)});
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
		function FileAttentePopUp(stand){
			include 'Content_Game/Fenetre_file_attente.html'; 
		}
		function FileAttente (stand)
		{
			//rentrerEnFile(,);
			//console.log(stand);	
			rentrerEnFile(stand,document.getElementById('name').value);
		    //console.log("Hola je suis dans la file");

		    var fil = document.createElement("div");
		    var corps = document.getElementById("corps");
		    fil.id= "CaseFileAttend";
		    
		    corps.appendChild(fil);

		    var PersFil = document.createElement("div");
		    PersFil.id = "nbPersonne";
		    PersFil.innerHTML = "Perso/MaxPerso";
		    document.getElementById("CaseFileAttend").appendChild(PersFil);

		    var PersNomStand = document.createElement("div");
		    PersNomStand.id = "nomStand";
		    PersNomStand.innerHTML = "Nom du stand";
		    document.getElementById("CaseFileAttend").appendChild(PersNomStand);

		    var filnom = document.createElement("h4");
		    filnom.id= "TitreFile";
		    filnom.innerHTML = "File Attente";
		    document.getElementById("CaseFileAttend").appendChild(filnom);

		    var filTemps= document.createElement("div");
		    filTemps.id= "TempsEstime";
		    filTemps.className="caseFile";
		    filTemps.innerHTML="Temps estime";
		    document.getElementById("CaseFileAttend").appendChild(filTemps);

		    var filplusinfo= document.createElement("div");
		    filplusinfo.id= "PlusInfo";
		    filplusinfo.className="caseFile";
		    filplusinfo.innerHTML = "Plus d'info sur le stand";
		    document.getElementById("CaseFileAttend").appendChild(filplusinfo);

		    var filQuitter= document.createElement("button"); //creation bouton pour quitter la file d'attente
		    filQuitter.id= "QuitterFile";
		    filQuitter.className="ButtonFile";
		    filQuitter.innerHTML = "Quitter la file"; 
		    
		    filQuitter.addEventListener("click", QuitterFileAtt);
		    
		    document.getElementById("CaseFileAttend").appendChild(filQuitter);

		    var filJeu= document.createElement("button"); //creation bouton pour jouer au jeu
		    filJeu.id= "JouerJeu";
		    filJeu.className="ButtonFile";
		    filJeu.innerHTML = "Jouer au jeu"; 
		    
		    filJeu.addEventListener("click", Lejeu);
		    
		    document.getElementById("CaseFileAttend").appendChild(filJeu);
		    function QuitterFileAtt ()//fonction pour quitter la file d'attente
		    {
		        //console.log("normalement j'ai quitté fdp");
		        effacer = document.getElementById("CaseFileAttend");
		        effacer.parentElement.removeChild(effacer);

		        //NOTE R.S. : Appeler la fonction quitter la file.
		        quitterFile();

		    }
		    
		    function Lejeu()
		    {
		        //console.log("Je joue !");
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
	</script>

    <footer>
    </footer>
    </body>
</html>
