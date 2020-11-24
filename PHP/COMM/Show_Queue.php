<?php

//$thisStand = 11;


session_start();

//$_SESSION['user_name'] = "Joseph";

include 'ConnexionBD.php';


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
    
    

    $urlReunion = "Reunion.php?role=1&stand=".$thisStand."&ID_Pres=".$myId."&ID_User=".$_SESSION['LastFoundUserForThisStand'];
    echo $urlReunion;

    header("Location : ".$urlReunion);
}



//1.Recuperer les infos de la table
$querry = "SELECT ID_Avatar, MIN(Heure_Arrivee), ID_Avatar_Presentateur FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$thisStand.";";

$querry_file_length = "SELECT COUNT(DB_SALON_Reunions.ID_Avatar) AS total FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Stand = ".$thisStand.";";


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


echo "Premier de la file : ".$_SESSION['LastFoundUserForThisStand']. "\n Total file : ".$total.". ";
//if($occuper != null)
//{
//    echo "Premier de la file : ".$_SESSION['LastFoundUserForThisStand']. "\n Total file : ".$total.". le présentateur du salon est actuellement en réunion" ;
//
//}
//else
//{
//     echo "Premier de la file : ".$_SESSION['LastFoundUserForThisStand']. "\n Total file : ".$total.". le présentateur du salon est libre" ;
//        
//    echo '<form action="Show_Queue.php" method="GET">
//    <input type="hidden" name="reunionStart" value="true">
//    <input type="submit" value="Démarrer la réunion avec le prochain visiteur">
//</form>' ;
//   
//}

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


/*
//2.Afficher les gens dans la file d'attente pour le stand précis
if($result = mysqli_querry($connection,$querry)) 
    {

        //Recupération des tableaux associatif
        while($rows = mysqli_fetch_assoc($result)){
            printf("%s(%s)\n",$rows["id"],$rows["temps"]); //verification 
        }
    
    //Envoyer l'utilisateur dans la page
    //include 'LancerLaReunion.php';
    
    //Libération des résultats
    $mysqli_free_result($result);
    }
//3.Lancer la réunion avec le premier de la file
//4.Indiquer aux autres que le présentateur est en réunion.
*/
/*
if($_SESSION["InReunion"] == false) //InReunion devrait être passer dans une session pour l'utiliser tel une var Static.
{
include 'LancerLaReunion.php'; //Appel de la page lancer la réunion
}else if ($_SESSION["InReunion"] == true){//Si il y a déjà quelqu'un en reunion

    if($result = mysqli_querry($connection,$querry)) 
    {

        //Recupération des tableaux associatif
        while($rows = mysqli_fetch_assoc($result)){
            printf("(%s)\n",$rows["temps"]); //verification 
            $temps_arrive = floatval($rows["temps"]);
            if($PlusLongTempsDarriver < $temps_arrive){
                $PlusLongTempsDarriver = $temps_arrive;
                $id = intval($rows["id"]);
            }
        }
    
    //Envoyer l'utilisateur dans la page
    //include 'LancerLaReunion.php';
    
    //Libération des résultats
    $mysqli_free_result($result);
    }

//Pour fermer le lien de la connection
mysqli_close($link);

}*/





?>


<form action="Show_Queue.php" method="GET">
    <input type="hidden" name="reunionStart" value="true">
    <input type="submit" value="Démarrer la réunion avec le prochain visiteur">
</form>
