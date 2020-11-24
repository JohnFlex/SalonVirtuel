<?php
    /*
    if (!$_SESSION) {
        header('Location: Accueil.php');
    }
    */
    require_once("./PDO_Connect/PDO_Connect.php");
    require_once("./Objets/managerStand.php");
    require_once("./Objets/managerRessource.php");

    if (isset($_POST["Position_X_Emplacement"])) {
        $posx = $_POST["Position_X_Emplacement"];
        $posy = $_POST["Position_Y_Emplacement"];
    } else {
        $posx = "";
        $posy = "";
    }

    $db = connect_bd();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Création d'un stand</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form id="creation_stand" class="" method="post" action="#">
            <label for="nom">Nom du stand :</label>
            <input type="text" id="Libelle_Stand" name="Libelle_Stand" placeholder="Nom du stand" size="15" required />

            <input type="hidden" name="Position_X_Emplacement" value="<?php echo $posx ?>">
            <input type="hidden" name="Position_Y_Emplacement" value="<?php echo $posy ?>">

            <label for="nom">Catégorie :</label>
            <input type="text" id="Categorie_Stand" name="Categorie_Stand" placeholder="Catégorie" size="15" />

            <label for="nom">Informations :</label>
            <textarea name="Information_Stand" placeholder="Description"></textarea>

            <input type="button" id="ajout_ressource" onclick="ajoutRessource();" value="Ajouter une ressource" />
            <input type="button" iqd="delete_ressource" onclick="deleteRessource();" value="Enlever une ressource" />

            <input type="submit" id="submit_button" name="submit_button"  class="" value="Créer" />
        </form>
        <script>
            var i = 0;
            function ajoutRessource() {
                //Création de nouveaux champs pour ajouter une ressource
                let form = document.getElementById("creation_stand"); //Récupérer le form
                let button = document.getElementById("ajout_ressource"); //Récupérer le bouton ajout pour insérer avant

                div = document.createElement("div");

                //Création du label d'une ressource
                labelRes = document.createElement("label");
                labelRes.innerHTML = "Ressource "+(i+1)+" :";
                div.appendChild(labelRes);

                //Création du label de l'input nom de la ressource
                label = document.createElement("label");
                label.setAttribute("for","Libelle_Ressource"+i);
                label.innerHTML = "Nom de la ressource : ";
                div.appendChild(label);

                //Création de l'input nom de la ressource
                input = document.createElement("input");
                input.setAttribute("name","Libelle_Ressource[]");
                input.setAttribute("placeholder","Nom de la ressource");
                input.setAttribute("size","20");
                input.setAttribute("maxlength","20");
                div.appendChild(input);

                //Création du label de l'input lien de la ressource
                label = document.createElement("label");
                label.setAttribute("for","Lien_Ressource"+i);
                label.innerHTML = "Lien de la ressource : ";
                div.appendChild(label);

                //Création de l'input lien de la ressource
                input = document.createElement("input");
                input.setAttribute("name","Lien_Ressource[]");
                input.setAttribute("type","url");
                input.setAttribute("placeholder","http://example.com");
                input.setAttribute("pattern","http://.*");
                input.setAttribute("size","50");
                input.setAttribute("maxlength","100");
                div.appendChild(input);

                button.insertAdjacentElement("beforebegin",div);
                i++;
            }

            function deleteRessource() {
                let button = document.getElementById("ajout_ressource"); //Récupérer le bouton ajout pour insérer avant
                let div = button.previousSibling;//Récupère l'élément précédent le boutton

                if (typeof(div) == "object" && div.firstChild) {
                    //Si l'élément est bien la ressource alors on la supprime
                    div.remove()
                    i--
                }
            }
        </script>
    </body>
    <footer>
        <a href="Accueil.php">Retour Accueil</a>
    </footer>
</html>

<?php
    /* Si l'utilisateur a rentré un libellé de stand : création du stand */
    if(isset($_POST['Libelle_Stand']) && !empty($_POST['Libelle_Stand'])) {
        

        $mStand = array(
            'Libelle' => $_POST['Libelle_Stand'],
            'Information' => $_POST['Information_Stand'],
            'Categorie' => $_POST['Categorie_Stand'],
        );

        $stand = new Stand;
        $stand->hydrate($mStand);
        $idStand = $managerStand->insertStand($stand); //insére et récupère l'id auto_increment

        /* Si l'utilisateur a rentré un libellé de ressource : création de la ressource*/
        if (isset($_POST['Libelle_Ressource']) && !empty($_POST['Libelle_Ressource'])) {
            

            /* Pour chaque ressource entrée, insertion dans ressource et contenir */
            foreach($_POST['Libelle_Ressource'] as $res) {
                foreach($_POST['Lien_Ressource'] as $url) {
                    $mRessource = array(
                        'Libelle' => $res,
                        'Lien' => $url
                    );
                }
                $res = new Ressource;
                $res->hydrate($mRessource);
                $idRes = $managerRes->insertRessource($res); //insére et récupère l'id auto_increment

                $managerRes->insertContenir($idStand,$idRes);
            }
        }
    }
?>

