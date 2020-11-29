<?php
// Ce fichier reçoit les données en json et enregistre le message
require_once("../COMM/Add_In_Queue.php");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if(isset($_GET['Stand'])&&(isset($_GET['UserName'])))
    {
        Rejoindre_File_D_Attente($_GET['Stand'],$_GET['UserName']);
    }
}