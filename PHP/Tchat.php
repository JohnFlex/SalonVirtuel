<!DOCTYPE html>
<html>
    <head>
        <title>Tchat</title>
        <meta charset="utf-8">
        <script type="text/javascript" src="../JS/scripts.js"></script>
    </head>
    <body>
		<?php

			if(!isset($_SESSION['user_name'])){
				session_start();

				$_SESSION['user_name']="guestTest";

				$_SESSION['user_ID']=0;

			}else{
				echo "vous êtes : ".$_SESSION['user_name'];
			}
		?>
        <h1>Tchat</h1>
        <div class="col-12 my-1">
            <div class="p-2" id="discussion">
            </div>
        </div>
        <div class="col-12 saisie">
            <div class="input-group">
                <input type="text" class="form-control" id="texte" placeholder="Entrez votre texte">
                <div class="input-group-append">
                    <span class="input-group-text" id="valid"><i class="la la-check"></i></span>
                </div>
            </div>
        </div>
    </body>
</html>
