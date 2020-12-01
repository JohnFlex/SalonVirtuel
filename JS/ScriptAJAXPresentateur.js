// Variables globales

//MONOBEHAVIOUR <== I miss you <3
let PresentateurId;
let Disponible=false;
let DIVcontainer=null;
let monConteneur=null;
let divDisponible=null;
let divFile=null;
let boutonReunion=null;


// On attend le chargement du document
window.onload = () =>{
    PresentateurId = document.getElementById('id').value;

    DIVcontainer = document.getElementById('container');

    monConteneur = document.createElement("div");

    divDisponible = document.createElement("div");
    divDisponible.setAttribute("id","divdispo");

    let labelDisponible = document.createElement("label");
    labelDisponible.setAttribute("for","spandispo");
    labelDisponible.setAttribute("id","labeldispo");
    labelDisponible.innerHTML="Vous êtes actuellement : ";
    let spanDisponible = document.createElement("span");
    spanDisponible.setAttribute("name","spandispo");
    spanDisponible.setAttribute("id","spandispo");
    spanDisponible.innerHTML="Indisponible";

    divDisponible.appendChild(labelDisponible);
    divDisponible.appendChild(spanDisponible);

    let divBoutonDisponible = document.createElement("div");
    let BoutonDisponible = document.createElement("button");
    BoutonDisponible.setAttribute("id","BoutonDisponible");
    BoutonDisponible.setAttribute("onclick","changeDispo();");
    BoutonDisponible.innerHTML="Devenir Disponible";
    divBoutonDisponible.appendChild(BoutonDisponible);
    divDisponible.appendChild(divBoutonDisponible);

    divFile = document.createElement("div");
    divFile.setAttribute("id","divfile");

    let labelFile = document.createElement("label");
    labelFile.setAttribute("for","spanfile");
    labelFile.setAttribute("id","labelfile");
    labelFile.innerHTML="Nombre d'utilisateur dans la file : ";
    let spanFile = document.createElement("span");
    spanFile.setAttribute("name","spanfile");
    spanFile.setAttribute("id","spanfile");
    spanFile.innerHTML="0";

    divFile.appendChild(labelFile);
    divFile.appendChild(spanFile);

    boutonReunion = document.createElement("a");
    boutonReunion.setAttribute("id","boutonreunion");
    boutonReunion.setAttribute("href","COMM/Show_Queue.php");
    boutonReunion.innerHTML="Lancer la Réunion";
    boutonReunion.disabled=true;

    monConteneur.appendChild(divDisponible);
    monConteneur.appendChild(BoutonDisponible);
    monConteneur.appendChild(divFile);
    monConteneur.appendChild(boutonReunion);
    DIVcontainer.appendChild(monConteneur);

    setInterval(nbUtilisateurFile, 1000);
}

function LancerLaReunion()
{
    document.location.href="https://2orm.com/SALON/PHP/COMM/Show_Queue.php"
}


function nbUtilisateurFile()
{
    // On instancie XMLHttpRequest
    let xmlhttp = new XMLHttpRequest();

    // On gère la réponse
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4)
        {
            if(this.status == 200)
            {
                boolEnAttente=false;
                // On a une réponse
                // On convertit la réponse en objet JS
                if (this.response!="")
                {
                    let Reponses = JSON.parse(this.response);

                    for(let Reponse of Reponses)
                    {
                        document.getElementById('spanfile').innerHTML=Reponse.nbUtilisateur;
                        if (Reponse.nbUtilisateur>0)
                        {
                            document.getElementById('boutonreunion').disabled=false;
                        }
                        else
                        {
                            document.getElementById('boutonreunion').disabled=true;
                        }
                    }
                }
            }
            else
            {
                console.log(this.response);
            }
        }
    }
    // On ouvre la requête
    xmlhttp.open("GET", "ajax/CompteUtilisateurFile.php?ID_Presentateur="+PresentateurId);

    // On envoie
    xmlhttp.send();
}

function changeDispo()
{
    // On instancie XMLHttpRequest
    let xmlhttp = new XMLHttpRequest();

    // On gère la réponse
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4)
        {
            if(this.status == 200)
            {
                boolEnAttente=false;
                if (this.response!="")
                {
                    // On a une réponse
                    // On convertit la réponse en objet JS
                    let Reponses = JSON.parse(this.response);

                    for(let Reponse of Reponses)
                    {
                        //console.log(Reponse.ID_Activite);
                        if (Reponse.ID_Activite==2)
                        {
                            document.getElementById("spandispo").innerHTML="Disponible";
                            document.getElementById("BoutonDisponible").innerHTML="Devenir Indisponible";
                        }
                        else
                        {
                            document.getElementById("spandispo").innerHTML="Indisponible";
                            document.getElementById("BoutonDisponible").innerHTML="Devenir Disponible";
                        }
                    }
                }
            }
            else
            {
                console.log(this.response);
            }
        }
    }

    //console.log(document.getElementById("spandispo").innerHTML=="Disponible");
    // On ouvre la requête
    if (document.getElementById("spandispo").innerHTML=="Disponible")
    {
        xmlhttp.open("GET", "ajax/DispoPresentateur.php?ID_Presentateur="+PresentateurId+"&Disponible=True");
    }
    else
    {
        xmlhttp.open("GET", "ajax/DispoPresentateur.php?ID_Presentateur="+PresentateurId+"&Disponible=False");
    }
    // On envoie
    xmlhttp.send();
}