<?php
// On vérifie la méthode utilisée
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On est en GET
    // On vérifie si on a reçu un id
    if(isset($_GET['ID_Presentateur']))
    {
        // On se connecte à la base
        require_once('ConnexionALaBDD.php');
        $db = ConnexionBDD();

        // On écrit la requête
        $sql = 'SELECT Count(ID_Avatar) as nbUtilisateur FROM DB_SALON_Reunions WHERE ID_Stand = (SELECT ID_Stand FROM DB_SALON_Presentateur WHERE ID_Avatar = '.$_GET["ID_Presentateur"].');';

        // On exécute la requête
        $query = $db->query($sql);

        // On récupère les données
        $resultat = $query->fetchAll();

        // On encode en JSON
        $resultatJson = json_encode($resultat);

        // On envoie
        echo $resultatJson;
    }
}else
{
    // Mauvaise méthode
    http_response_code(405);
    echo json_encode(['message' => 'Mauvaise méthode']);
}