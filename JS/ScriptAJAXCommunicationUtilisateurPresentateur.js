// Variables globales

let utilisateurId;
let boolEnAttente = false;

// On attend le chargement du document
window.onload = () =>{
    // On charge les nouveaux messages
    utilisateurId = document.getElementById('id').value;
    setInterval(verifPresentateur, 1000);
    //console.log(utilisateurId);
}

/**
 * Charge les derniers messages en Ajax et les insère dans la discussion
 */
function chargeReunion()
{
    /*if (boolEnAttente)
    {*/
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
                    //console.log(this.response);
                    if (this.response!="")
                    {
                        let Reponses = JSON.parse(this.response);

                        //Reponse.reverse();7

                        for(let Reponse of Reponses)
                        {
                            //Ici on peut récupérer les informations reçues.
                            //console.log("ID Presentateur : "+Reponse.ID_Avatar_Presentateur);
                            //console.log("ID Stand : "+Reponse.ID_Stand);
                            //console.log("Reunion.php?stand="+Reponse.ID_Stand+/*"&ID_Pres="+Reponse.ID_Avatar_Presentateur+*/"&ID_User="+utilisateurId);
                            window.location.href =("COMM/Reunion.php?stand="+Reponse.ID_Stand/*+"&ID_Pres=25"*/+/*Reponse.ID_Avatar_Presentateur+*/"&ID_User="+utilisateurId);
                        }
                    }
                }
                else
                {
                    // On gère les erreurs
                    /*let erreur = JSON.parse(this.response);
                    alert(erreur.message);*/
                    console.log(this.response);
                }
            }
        }
        // On ouvre la requête
        xmlhttp.open("GET", "ajax/PrepReunion.php?ID_Utilisateur="+utilisateurId);

        // On envoie
        xmlhttp.send();
    //}
}

function rentrerEnFile(stand_name,user_name)
{
    // On instancie XMLHttpRequest
    
    let xmlhttp = new XMLHttpRequest()

    // On gère la réponse
    xmlhttp.onreadystatechange = function()
    {
        // On vérifie si la requête est terminée
        if(this.readyState == 4)
        {
            if(this.status == 200)
            {
                console.log("L'enregistrement a réussi");
                //Condition d'apparition du Confirm.
                boolEnAttente=true;
            }
            else
            {
                console.log("L'enregistrement a échoué");
            }
        }
    }

    xmlhttp.open("GET", "ajax/ajoutFileAttente.php?Stand="+stand_name+"&UserName="+user_name);

    // On envoie
    xmlhttp.send();
}

function verifPresentateur()
{
    if (boolEnAttente)
    {
        // On instancie XMLHttpRequest
        
        let xmlhttp = new XMLHttpRequest()

        // On gère la réponse
        xmlhttp.onreadystatechange = function()
        {
            // On vérifie si la requête est terminée
            if(this.readyState == 4)
            {
                if(this.status == 200)
                {
                    if (this.response!="")
                    {
                        let Reponses = JSON.parse(this.response);

                        for(let Reponse of Reponses)
                        {
                           if (Reponse.ID_Avatar_Presentateur!=null)
                           {
                                if (Confirm("La réunion est prête, souhaitez-vous la rejoindre ?"))
                                {
                                    chargeReunion();
                                }
                                else
                                {
                                    quitterFile();
                                }
                           }
                        }
                    }
                }
                else
                {
                    // On gère les erreurs
                    console.log(this.response);
                }
            }
        }

        xmlhttp.open("GET", "ajax/verifPresentateurCoteClient.php?UserId="+utilisateurId);

        // On envoie
        xmlhttp.send();
    }
}

function quitterFile()
{
    // On instancie XMLHttpRequest
    
    let xmlhttp = new XMLHttpRequest()

    // On gère la réponse
    xmlhttp.onreadystatechange = function()
    {
        // On vérifie si la requête est terminée
        if(this.readyState == 4)
        {
            if(this.status == 200)
            {
                boolEnAttente=false;

                alert("Vous avez quitté la file d'attente.");
            }
            else
            {
                // On gère les erreurs
                console.log(this.response);
            }
        }
    }

    xmlhttp.open("GET", "ajax/quitterFile.php?UserId="+utilisateurId);

    // On envoie
    xmlhttp.send();
}