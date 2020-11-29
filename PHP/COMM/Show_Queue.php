<?php

include 'ConnexionBD.php';
session_start();


$_SESSION["stand_id"] = 11;

//Rend le présentateur actuel disponible dans la base de données
//ENTREE : N/A
//SORTIE : Le présentateur qui est actuellement connecté est rendu disponible dans la base de données
function Rendre_Le_Presentateur_Disponible()
{
    $query_setPresDispo = 'UPDATE DB_SALON_Presentateur SET ID_Activite = 2 WHERE Nom_Avatar LIKE "%'.$_SESSION['user_name'].'%" ; ';
    if ($connection->query($query_setPresDispo) === TRUE) {
        echo "You are now available. Users can join queue !";
    }
    else echo "Error updating record: " . $connection->error;
    
}

//Redirige sur la page avec la réunion en transmettant les paramètres du présentateur connecté
//ENTREE : N/A
//SORTIE : Redirection sur la page de réunion avec les bonnes infos
function Demarrer_La_Reunion()
{

    Verifier_Si_Les_Cles_De_L_API_Sont_Rentrees();

    $urlReunion = "Reunion.php?role=1&stand=".$_SESSION["stand_id"]."&ID_Pres=".Recuperer_ID_Presentateur_Actuellement_Connecte()."&ID_User=".Recuperer_Le_Premier_Utilisateur_De_La_File_Pour_Un_Stand($_SESSION["stand_id"]);

    header("Location : ".$urlReunion);
}

//Recupère l'ID du premier utilisateur pour un stand donné
//ENTREE : ID du stand du présentateur
//SORTIE : ID de l'avatar du premier utilisateur du stand
function Recuperer_Le_Premier_Utilisateur_De_La_File_Pour_Un_Stand($numeroStand)
{
    $querry = "SELECT ID_Avatar, MIN(Heure_Arrivee), ID_Avatar_Presentateur FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$numeroStand.";";
    if($result = mysqli_query($connection,$querry)) {
        while($rows = mysqli_fetch_assoc($result)){
           return $rows['ID_Avatar'];

        }

        mysqli_free_result($result);
    }else echo "Error connection : Failed to get last user";
}

//Recupère le nombre total d'utilisateur dans une file d'attente pour un stand donné
//ENTREE : ID du stand du présentateur
//SORTIE : Le nombre d'utilisateurs dans la file bla bla
function Recuperer_Le_Nombre_Total_De_Personnes_Qui_Attendent_Dans_La_File_D_Attente_Pour_Un_Stand($numeroStand)
{
    $querry_file_length = "SELECT COUNT(DB_SALON_Reunions.ID_Avatar) AS total FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$numeroStand.";";

    if($result = mysqli_query($connection,$querry_file_length)) {
        while($rows = mysqli_fetch_assoc($result)){
            return $rows['total'];
        }
        mysqli_free_result($result);
    }
    else echo "Error connetion : Failed to get total users number";

}

function Recuperer_ID_Presentateur_Actuellement_Connecte()
{
    $queryMyID = 'SELECT * FROM DB_SALON_Presentateur WHERE DB_SALON_Presentateur.Nom_Avatar LIKE "'. $_SESSION['user_name'].'";';
    if($result = mysqli_query($connection,$queryMyID)) {
        
        while($rows = mysqli_fetch_assoc($result)){
            return $rows['ID_Avatar'];
            
        }

        mysqli_free_result($result);
    }else echo "Error connection : Failed to get Presentateur ID";
    
}


//Arrête la possibilité de réunion si les clés API ne sont pas renseignées
function Verifier_Si_Les_Cles_De_L_API_Sont_Rentrees(){
    $queryAPIInfos = 'SELECT * FROM DB_SALON_Presentateur WHERE ID_Avatar = '.Recuperer_ID_Presentateur_Actuellement_Connecte().';';
    if($result = mysqli_query($connection,$queryAPIInfos)) {
        while($rows = mysqli_fetch_assoc($result)){
            $tempKey = $rows['Numero_Reunion'];
            if ($tempKey == "") {
                echo "Vos codes API ne sont pas renseignés !";
                exit();
            }
        }
        mysqli_free_result($result);
    }
    else echo "Error connetion : Failed to get total users number";
}

?>
