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
                Background:"Blue",
                organisateur:"temp",
                nbPersonne:0,
            
            cree:<?php echo !empty($stand->getPositionX())? "true" : "false"; ?>
        });
    <?php endforeach ?>

    console.log(Stand);


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
            sol.className = "Stand";
            sol.id = "build";
            sol.setAttribute("x",standX);
            sol.setAttribute("y",standY);
            j = j+2;
            sol.addEventListener("click", CreationStand);
            sol.addEventListener("click", Information);
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
        let build = document.getElementsByClassName("Stand");
        for(var i=0;i<9;i++){
           
        if(e.target == build[i] && Stand[i].cree == false)
        {
            test = i;
            //Stand[i].nom = prompt("Le nom du stand");
            
            //console.log("Stand : ",i);
            var crea = document.createElement("form");
            crea.id = "creation_stand";
            crea.method = "POST";
            crea.action = "creerStand.php";
            document.body.appendChild(crea);

            /*
            var input = document.createElement("input");
            input.type = "text";
            input.id = "nom_stand";
            input.name ="Libelle_Stand";
            input.placeholder = "Le nom du stand";
            crea.appendChild(input);

            var input = document.createElement("input");
            input.type = "text";
            input.id = "categorie_stand";
            input.name ="Categorie_Stand";
            input.placeholder = "La catégorie du stand";
            crea.appendChild(input);

            var input = document.createElement("input");
            input.type = "text";
            input.id = "resume_stand";
            input.name ="Information_Stand";
            input.placeholder = "Le résumé du stand";
            crea.appendChild(input);

            var input = document.createElement("input");
            input.type = "color";
            input.id = "CouleurStand";
            input.name ="Couleur_Stand";
            input.placeholder = "Couleur du Stand";
            crea.appendChild(input);
            */
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
            /*
            var btn = document.createElement("button");
            btn.id = "validation";
            btn.innerHTML = "Validation";
            btn.addEventListener("click",onValidation);
            crea.appendChild(btn);
            */
            crea.submit();
        }
    }
        //console.log(build);<input type="file">
    }

    function Information (e)
    {
        var fennetre = false
        for(var i=0;i<Stand.length;i++){
            console.log(Stand[i].InfoActive);
            if(Stand[i].InfoActive == true)
            {   
                console.log("biquette");
                fennetre = true;
            }
        }
        //console.log(fennetre);
        for(var i=0;i<9;i++){
        if(e.target== build[i] && Stand[i].cree == true && fennetre == false)
        {
            console.log("J'ai les infos de ",i);
            var info = document.createElement("div");
            info.className = "InfoStand";
            info.id = "Info";
            document.body.appendChild(info);
            var titre = document.createElement("h1");
            titre.innerHTML = Stand[i].nom;
            document.getElementById("Info").appendChild(titre);
            //-----------------------------------------------------
            /*for (var j =0;j<5;j++)
            {
                var phrase =document.createElement("p");
                phrase.innerHTML = "Info "+ (j+1);
                document.getElementById("Info").appendChild(phrase);
            }*/
            var phrase =document.createElement("p");
            phrase.innerHTML = Stand[i].categorie;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = Stand[i].organisateur;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = Stand[i].Resume;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = Stand[i].nbPersonne;
            document.getElementById("Info").appendChild(phrase);
            var phrase =document.createElement("p");
            phrase.innerHTML = Stand[i].placemax;
            document.getElementById("Info").appendChild(phrase);
            //------------------------------------------------------
            var fermer = document.createElement("button");
            fermer.id = "Fermeture";
            fermer.innerHTML = "Fermer";
            fermer.addEventListener("click",fermerfenetre);
            document.getElementById("Info").appendChild(fermer);
            Stand[i].InfoActive = true;
            saveInfo = i;
            
        }
        }
      

        
    }

    var saveInfo = 0;
    function fermerfenetre ()
    {
        effacer =document.getElementById("Info");
        effacer.parentElement.removeChild(effacer);
        Stand[saveInfo].InfoActive = false;

    }


    //var formulaire = document.getElementById("formulaire");
    
    var test = 0;
    function onValidation() {
        var nomform = document.getElementById("nom_stand");
        var orgaform = document.getElementById("orgarnisateur_stand");
        var cateform = document.getElementById("categorie_stand");
        var max = document.getElementById("maxplace");
        var resum = document.getElementById("resume_stand");
        var CouleurStand = document.getElementById("CouleurStand");
        Stand[test].nom = nomform.value;
        Stand[test].placemax = max.value;
        Stand[test].organisateur = orgaform.value;
        Stand[test].categorie = cateform.value;
        Stand[test].Resume = resum.value;//
        Stand[test].cree = true;
        Stand[test].Background = CouleurStand.value;
        crea =document.getElementById("creation_stand");
        crea.parentElement.removeChild(crea);
        build[test].innerHTML = Stand[test].nom;
        build[test].style.background = Stand[test].Background;
    }
    
BuildSalon();
</script>
</body>



</html> 