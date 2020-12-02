<!DOCTYPE html>
<html>
    <head>
        <title>Guest Inscription</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Create Guest</h1>
        
    </body>
</html>

<?php
    require_once("./PDO_Connect/PDO_Connect.php");
    require_once("./Objets/managerUtilisateur.php");


    $conn = connect_bd();
    $manager = new managerUtilisateur($conn);
    
    //$u = new Utilisateur;
    $u = $manager->insertTempUtilisateur(); // recuperation du Guest


    session_start();
    $_SESSION['user_name']=$u->getNom();
    $_SESSION['user_type']="Utilisateur";
    $_SESSION['user_id']=$u->getId();
    //echo "User ID : ".$_SESSION['user_id'];
    header("Location: Site.php");


    //var_dump($u);

    /*
        Connection a la session
    */
?>