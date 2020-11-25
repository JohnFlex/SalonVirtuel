<?php

include 'ConnexionBD.php';
session_start();

$query_setPresDispo = 'UPDATE DB_SALON_Presentateur SET ID_Activite = 2 WHERE Nom_Avatar LIKE "%'.$_SESSION['user_name'].'%" ; ';
if ($connection->query($query_setPresDispo) === TRUE) {
    echo "You are now available. Users can join queue !";
  }else {
    echo "Error updating record: " . $connection->error;
  }

// Ici rendre le présentateur dispo

$_SESSION["stand_id"] = 11;

//$_SESSION['user_name'] = "Joseph";




if ($_GET['reunionStart'] == "true")
{
    $queryMyID = 'SELECT * FROM DB_SALON_Presentateur WHERE DB_SALON_Presentateur.Nom_Avatar LIKE "'. $_SESSION['user_name'].'";';
    if($result = mysqli_query($connection,$queryMyID)) {
        
        while($rows = mysqli_fetch_assoc($result)){
            $myId = $rows['ID_Avatar'];
            echo $myId;
        }

        mysqli_free_result($result);
    }else echo "Fail connection 0";
    
    

    $urlReunion = "Reunion.php?role=1&stand=".$_SESSION["stand_id"]."&ID_Pres=".$myId."&ID_User=".$_SESSION['LastFoundUserForThisStand'];
    echo $urlReunion;

    header("Location : ".$urlReunion);
}



//1.Recuperer les infos de la table
$querry = "SELECT ID_Avatar, MIN(Heure_Arrivee), ID_Avatar_Presentateur FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$_SESSION["stand_id"].";";

$querry_file_length = "SELECT COUNT(DB_SALON_Reunions.ID_Avatar) AS total FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$_SESSION["stand_id"].";";

if($result = mysqli_query($connection,$querry)) {
    while($rows = mysqli_fetch_assoc($result)){
        $_SESSION['LastFoundUserForThisStand'] = $rows['ID_Avatar'];
        //$occuper = $rows['ID_Avatar_Presentateur'];
        //printf("%s(%s)\n",$rows["id"],$rows["temps"]); //verification 
    }
    
    //Envoyer l'utilisateur dans la page
    //include 'LancerLaReunion.php';
    
    //Libération des résultats
    mysqli_free_result($result);
}else echo "Fail connection 1";


if($result = mysqli_query($connection,$querry_file_length)) {
    while($rows = mysqli_fetch_assoc($result)){
        $total = $rows['total'];
        //printf("%s(%s)\n",$rows["id"],$rows["temps"]); //verification 
    }
    
    //Envoyer l'utilisateur dans la page
    //include 'LancerLaReunion.php';
    
    //Libération des résultats
    mysqli_free_result($result);
}
else echo "Fail connection 2";


if ($total != 0) {
    echo "Premier de la file : ".$_SESSION['LastFoundUserForThisStand']. "\n Total file : ".$total.". ";
}
else echo "Il n'y a personne dans la file !";
/*

if($_GET['reunionQuit']=="true")
{
    
        
    if($result = mysqli_query($connection,$querry)) {
        while($rows = mysqli_fetch_assoc($result))
        {
            $_SESSION['LastFoundUserForThisStand'] = $rows['ID_Avatar'];
        
    }
    $queryQuitFile = 'DELETE FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Avatar = "'. $_SESSION['LastFoundUserForThisStand'].'";';
        
    if ($connection->query($queryQuitFile) === TRUE) 
    {
        header("Location:Add_In_Queue.php");
    }else 
    {
        echo "Error updating record: " . $connection->error;
    }

        $connection->close();
    }
    
    
}

*/

?>


<form action="Show_Queue.php" method="GET">
    <input type="hidden" name="reunionStart" value="true">
    <input type="submit" value="Démarrer la réunion avec le prochain visiteur">
</form>
