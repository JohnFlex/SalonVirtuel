<?php 



$servername = "ormcomcplh778.mysql.db";
$username = "ormcomcplh778";
$password = "R8frzgZzN5S8";
$dbname = "ormcomcplh778";


 //Connection vers la Base de données
    
    $connection = mysqli_connect($servername,$username,$password,$dbname);

    if (mysqli_connect_errno()) {
        printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
    }



?>