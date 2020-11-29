<?php
    /*
    if (!$_SESSION) {
        header('Location: Accueil.php');
    }
    */
    session_start();
    require_once("./PDO_Connect/PDO_Connect.php");
    require_once("./Objets/managerStand.php");
    require_once("./Objets/managerRessource.php");
    require_once("./Objets/managerEmplacement.php");
    require_once("./Objets/managerPresentateur.php");

    $db = connect_bd();

    $managerPres = new managerPresentateur($db);


    $id_stand = $managerPres->selectPresentateurByName($_SESSION['user_name'])->getIdStand();

    $managerStand = new managerStand($db);
    $managerRes = new managerRessource($db);
    $managerEmplacement = new managerEmplacement($db);

    $standToUpdate = $managerStand->selectStandById($id_stand);
    $emplacement = $managerEmplacement->selectEmplacementById($standToUpdate->getPositionX(),$standToUpdate->getPositionY());

    /* Si l'utilisateur a rentré un libellé de stand : création du stand */
    if(isset($_POST['Libelle_Stand']) && !empty($_POST['Libelle_Stand'])) {
        

        $mStand = array(
            'Id' => $_POST['ID_Stand'],
            'Libelle' => $_POST['Libelle_Stand'],
            'Categorie' => $_POST['Categorie_Stand'],
            'Information' => $_POST['Information_Stand'],
            'PositionX' => $_POST['Position_X_Emplacement'],
            'PositionY' => $_POST['Position_Y_Emplacement']
        );

        $stand = new Stand;
        $stand->hydrate($mStand);
        $managerStand->updateStand($stand);

        $mEmplacement = array(
            'PositionX' => $_POST['Position_X_Emplacement'],
            'PositionY' => $_POST['Position_Y_Emplacement'],
            'Couleur' => $_POST['Couleur_Element']
        );

        $newEmplacement = new Emplacement;
        $newEmplacement->hydrate($mEmplacement);

        $managerEmplacement->updateEmplacement($newEmplacement);
        
        /* Si l'utilisateur a rentré un libellé de ressource : création de la ressource*/
        if (isset($_POST['Libelle_Ressource']) && !empty($_POST['Libelle_Ressource'])) {
            /* Pour chaque ressource entrée, insertion dans ressource et contenir */
            for($i=0 ; $i < count($_POST['Libelle_Ressource']);$i++) {
                if(isset($_POST['ID_Ressource'][$i])) {
                    $mRessource = array(
                        'Libelle' => $_POST['Libelle_Ressource'][$i],
                        'Lien' => $_POST['Lien_Ressource'][$i],
                        'Id' => $_POST['ID_Ressource'][$i]
                    );
                    $res = new Ressource;
                    $res->hydrate($mRessource);
                    $managerRes->updateRessource($res);
                } else {
                    $mRessource = array(
                        'Libelle' => $_POST['Libelle_Ressource'][$i],
                        'Lien' => $_POST['Lien_Ressource'][$i],
                    );
                    $res = new Ressource;
                    $res->hydrate($mRessource);
                    $managerRes->updateRessource($res);
                    $idRes = $managerRes->insertRessource($res); //insére et récupère l'id auto_increment
                    $managerRes->insertContenir($id_stand,$idRes);
                }
            }

            if (isset($_POST['ID_Ressource_Delete']) && !empty($_POST['ID_Ressource_Delete'])) {
                foreach($_POST['ID_Ressource_Delete'] as $id) {
                    $managerRes->deleteRessourceById($id);
                }
            }

            
        }
    header('Location: modifierStand.php');
    }

    $dom = new DOMDocument('1.0', 'iso-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
        <title>Modifier un stand</title>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <div class="navbar">
                <h1>Titre du site</h1>
                <h2 class="titre1">Modifier un stand</h2>
                <div>
                    <a href="Accueil.php">Deconnexion</a>
                    <a href="SitePresentateur.php">Retour Gestion</a>
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
        <form id="creation_stand" class="" method="post" action="#">
            <label for="nom">Nom du stand :</label>
            <input type="text" id="Libelle_Stand" name="Libelle_Stand" placeholder="Nom du stand" size="15" required value="<?php echo $standToUpdate->getLibelle(); ?>" />
            
            <label for="nom">Catégorie :</label>
            <input type="text" id="Categorie_Stand" name="Categorie_Stand" placeholder="Catégorie" size="15" value="<?php echo $standToUpdate->getCategorie(); ?>" />

            <label for="nom">Informations :</label>
            <textarea name="Information_Stand" placeholder="Description" value="<?php echo $standToUpdate->getInformation(); ?>"></textarea>


            <label for="couleur_mur_gauche">Couleur du sol :</label>
            <input type="color" name="Couleur_Element" value="<?php echo $emplacement->getCouleur(); ?>" />


            <input type="hidden" name="ID_Stand" value="<?php echo $standToUpdate->getId();?>" />
            <input type="hidden" name="Position_X_Emplacement" value="<?php echo $standToUpdate->getPositionX(); ?>"/>
            <input type="hidden" name="Position_Y_Emplacement" value="<?php echo $standToUpdate->getPositionY(); ?>"/>
            <?php 
                $i = 0;
                $stmtRes = $managerRes->selectRessourceByStandId($id_stand);
                $stmtRes->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmtRes->rowCount() > 0) {
                    $dom = new DOMDocument('1.0','utf-8');
                    foreach ($stmtRes as $row) {
                        $div = $dom->createElement("div");
                        $dom->appendChild($div);

                        $labelRes = $dom->createElement("label","Ressource ".$i." : ");
                        $div->appendChild($labelRes);
                        foreach($row as $key => $value) {
                            switch($key) {
                                case 'Libelle_Ressource' :
                                    $label = $dom->createElement("label","Nom de la ressource : ");
                                    $div->appendChild($label);
                                    $label->setAttribute("for","Libelle_Ressource");
                                    
                                    $input = $dom->createElement("input");
                                    $div->appendChild($input);
                                    $input->setAttribute("type","text");
                                    $input->setAttribute("name","Libelle_Ressource[]");
                                    $input->setAttribute("size",20);
                                    $input->setAttribute("maxlength",20);
                                    $input->setAttribute("placeholder","Nom de la ressource");
                                    $input->setAttribute("value",$value);
                                    
                                break;
                                case 'Lien_Ressource' :
                                    $label = $dom->createElement("label","Lien de la ressource : ");
                                    $div->appendChild($label);
                                    $label->setAttribute("for","Lien_Ressource");
                                    
                                    $input = $dom->createElement("input");
                                    $div->appendChild($input);
                                    $input->setAttribute("type","text");
                                    $input->setAttribute("name","Lien_Ressource[]");
                                    $input->setAttribute("size",50);
                                    $input->setAttribute("maxlength",100);
                                    $input->setAttribute("placeholder","http://example.com");
                                    $input->setAttribute("pattern","http://.*");
                                    $input->setAttribute("value",$value);
                                break;
                                case 'ID_Ressource' :
                                    $input = $dom->createElement("input");
                                    $div->appendChild($input);
                                    $input->setAttribute("type","hidden");
                                    $input->setAttribute("value",$value);
                                    $input->setAttribute("name","ID_Ressource[]");
                                break;
                            }
                           
                        }
                        $i++;
                    }
                    echo $dom->saveHTML();
                }
            
            ?>
            <input type="button" id="ajout_ressource" onclick="ajoutRessource();" value="Ajouter une ressource" />
            <input type="button" id="delete_ressource" onclick="deleteRessource();" value="Enlever une ressource" />

            <input type="submit" id="submit_button" name="submit_button"  class="" value="Modifier" />
        </form>
        <script>
            var i = <?php echo $i-1 ?>;
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
                let div = button.previousElementSibling;//Récupère l'élément précédent le boutton
                
                console.log(div);
                if (typeof(div) == "object" && div.firstChild) {
                    //Si l'élément est bien la ressource alors on la supprime
                    if(div.childNodes[1].name == "ID_Ressource[]") {
                        let hidden = document.createElement("input");
                        hidden.setAttribute("value",div.childNodes[1].value);
                        hidden.setAttribute("name","ID_Ressource_Delete[]");
                        hidden.setAttribute("type","hidden");
                        button.insertAdjacentElement('afterend',hidden);
                    }
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