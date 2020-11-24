<?php 

//$_SESSION['user_name'] = "Josuke";



//Set the variables

$temps_arrive = "";

//$thisStand = 11;

include 'ConnexionBD.php';


//Connection a la file d'attente
if(isset($_GET['rejoindre_reunion'])){

    //Set du temps a la time zone du serveur
    $temps_arrive = date("His");

    //Reprise de l'id dans la db Utilisateur
    $querry = "SELECT * FROM DB_SALON_Utilisateur WHERE DB_SALON_Utilisateur.Nom_Avatar LIKE '". $_SESSION['user_name']."' ; ";
    
    if($querry_run = mysqli_query($connection,$querry)){
        while($row = mysqli_fetch_assoc($querry_run)){
            $idUser = $row["ID_Avatar"];
        }
    }

    $querry_verif = "SELECT * FROM DB_SALON_Reunions";
    if($querry_run_verif = mysqli_query($connection,$querry_verif)){
        while($row = mysqli_fetch_assoc($querry_run_verif)){
            if ($row['ID_Stand'] == $thisStand && $row['ID_Avatar'] == $idUser) {
                echo "Vous etes déjà dans une file pour ce stand !";
                EtatReunion();
                exit();
            }
            else{
                echo "ErreurVerif";
            }
        }
    }
    
    //Insert de donnee dans la db Reunion
    $requete = "INSERT INTO DB_SALON_Reunions(ID_Avatar, ID_Stand, Heure_Arrivee) VALUES (".$idUser."," .$thisStand.",".$temps_arrive.");";
   
    //Check la connection a la file
    if(mysqli_query( $connection,$requete)){
        echo "Vous etes ajouté a la file d'attente";
        EtatReunion();
    }
    else echo "Erreur d'ajout à la file d'attente";
    
    
    
    
}

if($_GET['reunionQuit']=="true")
{
    $querry = "SELECT ID_Avatar, MIN(Heure_Arrivee), ID_Avatar_Presentateur FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$thisStand.";";
    
    if($result = mysqli_query($connection,$querry)) {
    while($rows = mysqli_fetch_assoc($result)){
        $user= $rows['ID_Avatar'];
        //$occuper = $rows['ID_Avatar_Presentateur'];
        //printf("%s(%s)\n",$rows["id"],$rows["temps"]); //verification 
    }
         mysqli_free_result($result);
}else echo "Fail connection 1";

    
    
    
        $queryQuitFile = 'DELETE FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Avatar = "'. $user.'";';
        
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
}
    
?>


<!--
<form action="Add_In_Queue.php" method="GET">
    <input type="hidden" name="reunionStart" value="true">
    <input type="submit" value="Quitter la file">
</form>
-->
