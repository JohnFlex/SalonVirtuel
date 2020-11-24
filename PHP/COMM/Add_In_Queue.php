<?php 

session_start();

include 'ConnexionBD.php';

Rejoindre_File_D_Attente(11);

//Permet de rejoindre une file d'attente
//ENTREE : Numéro du stand à rejoindre par l'utilisateur qui est connecté en ce moment
//SORTIE : Entrée dans la table "Réunions"
function Rejoindre_File_D_Attente($numeroStandARejoindre){

    $temps_arrive = date("His");

    if(Verifier_Si_Utilisateur_Est_Deja_En_File_D_Attente(Recup_ID_Utilisateur_En_Cours(),$numeroStandARejoindre)){
        exit();
    }

    $requete = "INSERT INTO DB_SALON_Reunions(ID_Avatar, ID_Stand, Heure_Arrivee) VALUES (".Recup_ID_Utilisateur_En_Cours()."," .$numeroStandARejoindre.",".$temps_arrive.");";
   
    //Check la connection a la file
    if(mysqli_query( $connection, $requete)){
        echo "Vous etes ajouté a la file d'attente";
        
    }
    else echo "Erreur d'ajout à la file d'attente";
}

//Permet de quitter une réunion
//ENTREE : Numéro du stand à rejoindre par l'utilisateur qui est connecté en ce moment
//SORTIE : Suppression de l'entrée correspondante dans la table "Réunions"
function Quitter_Reunion($numeroStandAQuitter){

    if ( !Verifier_Si_Utilisateur_Est_Deja_En_File_D_Attente(Recup_ID_Utilisateur_En_Cours(), $numeroStandAQuitter)) {
        exit();
    }

    $queryQuitFile = 'DELETE FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Avatar = "'.Recup_ID_Utilisateur_En_Cours().'";';
    
    if ($connection->query($queryQuitFile) === TRUE) 
    {
        echo "Delete Succes";
        //header("Location:Add_In_Queue.php");
    }else 
    {
        echo "Error updating record: " . $connection->error;
    }

    $connection->close();
}


//Verifie si l'utilisateur connecté en ce moment est en file d'attente
//ENTREE : Le numéro du stand où l'on veut vérifier si l'utilisateur est connecté dans la file d'attente
//SORTIE : TRUE si il est dans une file, FALSE si il n'est pas dans une file
function Verifier_Si_Utilisateur_Est_Deja_En_File_D_Attente($id_stand_actuel){

    $querry_verif = "SELECT * FROM DB_SALON_Reunions";
    if($querry_run_verif = mysqli_query($connection, $querry_verif)){
        while($row = mysqli_fetch_assoc($querry_run_verif)){
            if ($row['ID_Stand'] == $id_stand_actuel && $row['ID_Avatar'] == Recup_ID_Utilisateur_En_Cours()) {
                echo "Vous etes déjà dans une file d'attente";
                
                return true;
            }
            else echo "ErreurVerif";
        }
    }
    else{
        echo "Erreur envoi de la requete";
    }

    return false;

}


//Récupère l'ID de l'utilisateur en récupérant la variable $_SESSION['user_name'] (l'utilisateur connecté en cours)
//ENTREE : N/A
//SORTIE : L'ID de l'utilisateur de la session
function Recup_ID_Utilisateur_En_Cours(){
    $querry = "SELECT * FROM DB_SALON_Utilisateur WHERE DB_SALON_Utilisateur.Nom_Avatar LIKE '". $_SESSION['user_name']."' ; ";
    
    if($querry_run = mysqli_query($connection, $querry)){
        while($row = mysqli_fetch_assoc($querry_run)){
            $idUser = $row["ID_Avatar"];
        }
    }
    return $idUser;
}



/*
function EtatReunion()
{
        $querryEtat = "SELECT ID_Avatar, MIN(Heure_Arrivee), ID_Avatar_Presentateur FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$thisStand.";";
        
        if($result = mysqli_query($connection,$querry)) 
        {
            while($rows = mysqli_fetch_assoc($result))
            {
                //$_SESSION['LastFoundUserForThisStand'] = $rows['ID_Avatar'];
                $occuper = $rows['ID_Avatar_Presentateur'];
                //printf("%s(%s)\n",$rows["id"],$rows["temps"]); //verification 
            }
        
            
        }
        
        if($occuper != null)
        {
            echo " le présentateur du salon est actuellement en réunion" ;

        }
        else
        {
            echo " le présentateur du salon est libre" ;

        }
        
        
        echo '<form action="Add_In_Queue.php" method="GET">
    <input type="hidden" name="reunionQuit" value="true">
    <input type="submit" value="Quitter la file">
    </form>' ;
}*/
    
?>
