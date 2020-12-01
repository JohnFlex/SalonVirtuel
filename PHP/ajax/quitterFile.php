<?php
// Ce fichier reçoit les données en json et enregistre le message
require_once("../COMM/Add_In_Queue.php");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if(isset($_GET['UserId']))
    {
        // On se connecte à la base
        require_once('ConnexionALaBDD.php');
        $db = ConnexionBDD();

        // On écrit la requête
        $sql = 'DELETE FROM DB_SALON_Reunions WHERE ID_Avatar = '.$_GET["ID_Utilisateur"].';';

        // On exécute la requête
        $query = $db->query($sql);

        // On récupère les données
        $resultat = $query->fetchAll();

        // On encode en JSON
        $resultatJson = json_encode($resultat);

        // On envoie
        echo $resultatJson;
    }
}