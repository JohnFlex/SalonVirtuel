<?php
	if (session_status()!=PHP_SESSION_NONE)
		session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Accueil</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    </head>
    <body>
        <div class="navbar">
            <h1>Titre du site</h1>
            <h2 class="titre1">Accueil</h2>
            <div>
                <a href="Inscription.php">Inscription</a>
                <a href="Connection.php">Connexion</a>
                <a href="GuestConnect.php">Connexion direct</a>
            </div>
        </div>

        <p>Bonjour je suis beau</p>

    </body>
</html>
