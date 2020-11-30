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
		    
		    var MonCanvas = document.getElementById("salon");
		    var Clicker = false;

		    var ctx2d = MonCanvas.getContext("2d");
		    var player = document.getElementById("player");
		    setInterval(update,0);
		    var speed = 1;

		    var canvasSize = 500;
		    let keysPressed = []; //Gestion des inputs

		    var size = 4;

		    var standWidth = canvasSize/size;
		    var standHeight = canvasSize/size;

		    var standCoordGridX = canvasSize/(size/1.5);
		    var standCoordGridY = canvasSize/(size/1.5);

		    var visiteur = {x:140,y:140,w:25,h:25};
		    var positionX = 40;
		    var positionY = 45;

		    document.addEventListener("keydown",keyDownHandler);
		    document.addEventListener("keyup",keyUpHandler);

		    var currentColor = "red";
		    var inter;

		    function update()
		    {
		        ctx2d.clearRect(0,0,canvasSize,canvasSize);
		        ctx2d.fillStyle =  "rgb(255,255,255)";
		        ctx2d.fillRect(0,0,canvasSize,canvasSize);

		        Stand.forEach(stand => {
		            renderStand(stand);
		            
		        }); 
		        renderVisiteur();
		    }

		function renderVisiteur() {
		    ctx2d.fillStyle = "black";
		    ctx2d.fillRect(visiteur.x-1,visiteur.y-1,visiteur.w+2,visiteur.h+2);
		    ctx2d.fillStyle = currentColor;
		    ctx2d.fillRect(visiteur.x,visiteur.y,visiteur.w,visiteur.h);
		}


		function keyDownHandler(event) {
		//Pression sur une touche
		//event.preventDefault();
		    keysPressed[event.code] = true;
		    if (inter) {
		                
		    } else {
		        inter = setInterval(manage,1);
		    }
		}

		function keyUpHandler(event) {
		//Touche relachée
		    keysPressed[event.code] = false;
		}

		function manage() {
		//Gestion des touches pour déplacer les blocks
		    if (keysPressed["ArrowDown"]) {
		        moveTop(speed);
		    }
		    if (keysPressed["ArrowUp"]) {
		        moveTop(-speed);
		    }
		    if (keysPressed["ArrowLeft"]) {
		        moveLeft(-speed);
		    }
		    if (keysPressed["ArrowRight"]) {
		        moveLeft(speed);
		    }
		    Stand.forEach(stand => {
		        collisionStand(stand);
		    });
		}

		function moveTop(speed) {
		    if (visiteur.y+speed > 0 && visiteur.y+visiteur.h+speed < canvasSize) {
		        visiteur.y += speed;
		    }
		}

		function moveLeft(speed) {
		    if (visiteur.x+speed > 0 && visiteur.x+visiteur.w+speed < canvasSize) {
		        visiteur.x += speed;
		    }
		}

		function renderStand(stand) {
		    ctx2d.fillStyle = stand.Background;
		    ctx2d.fillRect((stand.X-1)*standCoordGridX,(stand.Y-1)*standCoordGridY,standWidth,standHeight);
		}

		function collisionStand(stand) {
		    if (Clicker == false) {
		        if((visiteur.x+visiteur.w >= (stand.X-1)*standCoordGridX) && (visiteur.x <= (stand.X-1)*standCoordGridX+standWidth) && (visiteur.y+visiteur.h >= (stand.Y-1)*standCoordGridY) && (visiteur.y <= (stand.Y-1)*standCoordGridY+standHeight)) {
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
		    filAttend.addEventListener("click",FileAttente);
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

		function FileAttente ()
		{
		    console.log("Hola je suis dans la file");

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
		        console.log("normalement j'ai quitté fdp");
		        effacer = document.getElementById("CaseFileAttend");
		        effacer.parentElement.removeChild(effacer);

		    }
		    
		    function Lejeu()
		    {
		        console.log("Je joue !");
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
