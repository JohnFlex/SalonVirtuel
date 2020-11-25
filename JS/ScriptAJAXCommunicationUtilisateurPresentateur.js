// Variables globales

//let utilisateurId = 7;
let boolEnAttente = false;

// On attend le chargement du document
window.onload = () =>{
    // On charge les nouveaux messages
    setInterval(chargeReunion, 1000);
}

/**
 * Charge les derniers messages en Ajax et les insère dans la discussion
 */
function chargeReunion()
{
    if (boolEnAttente)
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
                    // On a une réponse
                    // On convertit la réponse en objet JS
                    console.log(this.response);
                    let Reponses = JSON.parse(this.response);

                    //Reponse.reverse();

                    for(let Reponse of Reponses)
                    {
                        //Ici on peut récupérer les informations reçues.
                        console.log("ID Presentateur : "+Reponse.ID_Avatar_Presentateur);
                        console.log("ID Stand : "+Reponse.ID_Stand);
                    }
                }
                else
                {
                    // On gère les erreurs
                    let erreur = JSON.parse("erreur"+this.response);
                    alert(erreur.message);
                }
            }
        }
        // On ouvre la requête
        xmlhttp.open("GET", "ajax/PrepReunion.php?ID_Utilisateur="+utilisateurId);

        // On envoie
        xmlhttp.send();
    }
}

function rentrerEnFile()