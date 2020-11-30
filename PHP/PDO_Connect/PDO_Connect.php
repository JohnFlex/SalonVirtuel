<?php
/*define('BASE','ormcomcplh778');
define('SERVER','ormcomcplh778.mysql.db');
define('USER','ormcomcplh778');
define('PASSWD','R8frzgZzN5S8');*/

define('BASE','testdb');
define('SERVER','localhost');
define('USER','root');
define('PASSWD','');

function connect_bd()
{
	$dsn = "mysql:dbname=".BASE.";host=".SERVER;
	try
	{
		$connexion = new PDO($dsn, USER, PASSWD);
		echo "<script>console.log('Connexion réussie')</script>";
		return $connexion;
	}
	catch(PDOException $e)
	{
		printf("Echec de la connexion : %s\n", $e->getMessage());
		exit();
	}
}
?>