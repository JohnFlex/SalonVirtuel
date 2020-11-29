<?php
    require_once("./PDO_Connect/PDO_Connect.php");
    require_once("./Objets/managerStand.php");
    require_once("./Objets/managerRessource.php");
    require_once("./Objets/managerEmplacement.php");

    $db = connect_bd();
    $managerStand = new managerStand($db);
    $managerRes = new managerRessource($db);
    $managerEmplacement = new managerEmplacement($db);

    $stands = $managerStand->selectStands();
    $stands->setFetchMode(PDO::FETCH_ASSOC);

    $emplacements = $managerEmplacement->selectEmplacements();
    $emplacements->setFetchMode(PDO::FETCH_ASSOC);
    $emplacements = $emplacements->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Salon Virtuel</title>
    <link href="../CSS/style.css" rel="stylesheet" />
    <link href="../CSS/style_salon.css" rel="stylesheet" />
</head>
<body>
    <button class="Bouton" id="creation">
        
    </button>
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




    //Creation du salon
    var cree = document.getElementById("creation");
    //cree.addEventListener("click",BuildSalon);
    
    var InfoActive = false;
    function BuildSalon()
    {

        //console.log("Hola");
        var salon = document.createElement("div");
        salon.className = "Salon";
        salon.id = "Salon";
        document.body.appendChild(salon);
        cree.style.visibility = "hidden";

        var j = 0;
        var k = 6;
        var l = 8;
        var standX = 1;
        var standY = 1;
        // 6 8 16 18 
        for(i=0;i<25;i++)
        {
        //console.log("k :", k);
        //console.log("j :", j);
        //console.log("i :", i);
        //console.log("l :", l);
        var sol = document.createElement("div");
        if (i == j && i != k&& i != l)
        {
            //console.log("Stand");
            var findStand = Stand.find(element => element.X == standX && element.Y == standY);
            sol.className = "Stand";
            sol.id = "build";
            sol.setAttribute("x",standX);
            sol.setAttribute("y",standY);
            sol.style.background = findStand.Background;
            sol.innerHTML = findStand.nom;
            sol.setAttribute("cree",findStand.cree);
            j = j+2;
            if(!findStand.cree) {
                sol.addEventListener("click", CreationStand);
            } else {
                sol.addEventListener("click", Information);
            }
            
            standX++;
            if (standX > 3) {
                standX = 1;
                standY++;
            }
        }
        else
        {
            //console.log("sol");
            sol.className = "sol";
        }
        if (i == k)
        {
            k = k+10;
        
            j = j+2;
           sol.className = "sol";
            //console.log("saut");
        }
        if ( i == l)
        {

            l = l+10;
            j = j+2;
           sol.className = "sol";
            //console.log("saut2");
        }
        document.getElementById("Salon").appendChild(sol);//getElementsByClassName("Salon")[i]
        }

    }

    function CreationStand(e)
    {
        //console.log("Bonjour Jojo");
        if(e.target.getAttribute("cree") == "false")
        {

            var crea = document.createElement("form");
            crea.id = "creation_stand";
            crea.method = "POST";
            crea.action = "creerStand.php";
            document.body.appendChild(crea);

            var input = document.createElement("input");
            input.type = "hidden";
            input.id = "PositionX";
            input.name ="Position_X_Emplacement";
            input.value = e.target.getAttribute("x");
            crea.appendChild(input);

            var input = document.createElement("input");
            input.type = "hidden";
            input.id = "PositionY";
            input.name ="Position_Y_Emplacement";
            input.value = e.target.getAttribute("y");
            crea.appendChild(input);

            crea.submit();
        }
    
    }
    fenetre = false
    function Information (e)
    {
        
        if(e.target.getAttribute("cree") == "true" && fenetre == false)
        {
            var findStand = Stand.find(element => element.X == e.target.getAttribute("x") && element.Y == e.target.getAttribute("y"));
            //console.log("J'ai les infos de ",i);
            var info = document.createElement("div");
            info.className = "InfoStand";
            info.id = "Info";
            document.body.appendChild(info);
            var titre = document.createElement("h1");
            titre.innerHTML = findStand.nom;
            document.getElementById("Info").appendChild(titre);

            console.log(findStand);
            var phrase =document.createElement("p");
            phrase.innerHTML = findStand.categorie;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = findStand.organisateur;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = findStand.Resume;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = findStand.nbPersonne;
            document.getElementById("Info").appendChild(phrase);
            //------------------------------------------------------
            var fermer = document.createElement("button");
            fermer.id = "Fermeture";
            fermer.innerHTML = "Fermer";
            fermer.addEventListener("click",fermerfenetre);
            document.getElementById("Info").appendChild(fermer);
            findStand.InfoActive = true;
            saveInfo = i;
            fenetre = true;
        } else {
            fermerfenetre();
            Information(e);
        }
      
    }

    var saveInfo = 0;
    function fermerfenetre ()
    {
        effacer =document.getElementById("Info");
        effacer.parentElement.removeChild(effacer);
        //Stand[saveInfo].InfoActive = false;
        fenetre = false;
    }
    
BuildSalon();
</script>
</body>



</html> 