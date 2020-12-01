<?php

 //Connection vers la Base de données
function Connexion()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "DB_SALON";

	/*$servername = "ormcomcplh778.mysql.db";
	$username = "ormcomcplh778";
	$password = "R8frzgZzN5S8";
	$dbname = "ormcomcplh778";*/


	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	return $connection;
}

$connection=Connexion();




?>
