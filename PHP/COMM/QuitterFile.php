<?php

session_start();


if($_SESSION['user_type'] == "Presentateur")
{
    //Connection vers la Base de données
    try
    {
        $bdd = new PDO('mysql:host=ormcomcplh778.mysql.db;dbname=ormcomcplh778;charset=utf8','ormcomcplh778','R8frzgZzN5S8');
    }
    catch(Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    
    
    $reponse = $bdd->query("SELECT MIN(Heure_Arrivee), DB_SALON_Reunions.ID_Avatar, DB_SALON_Reunions.ID_Stand FROM DB_SALON_Reunions, DB_SALON_Presentateur WHERE (DB_SALON_Presentateur.Nom_Avatar LIKE '".$_SESSION['user_name']."') AND DB_SALON_Presentateur.ID_Stand = DB_SALON_Reunions.ID_Stand");

    $donnees = $reponse->fetch();

    //supprime l'élément de la table correspondant à l'id du presentateur qui arrive à la page
    $bdd->exec('DELETE FROM DB_SALON_Reunions WHERE DB_SALON_Reunions.ID_Avatar = "'.$donnees["ID_Avatar"].'" AND DB_SALON_Reunions.ID_Stand = "'.$donnees['ID_Stand'].'" ;');


    $reponse->closeCursor();

    //changer vers la file d'attente quand elle existera
    header("Location:../Site.php");
    
}
else
{
    //changer vers le salon quand elle existera
    header("Location:../Site.php");
}



?>
