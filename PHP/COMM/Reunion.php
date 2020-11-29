<?php 

include 'ConnexionBD.php';
session_start();

//Si on est présentateur, on s'ajoute à la base de données de la réunion,
//Sinon on crée juste la requete pour prendre les clés de l'api
if ($_GET['role'] = 1) {
	$Grole = 1;

	$queryAjoutPresentateur = 'UPDATE DB_SALON_Reunions SET ID_Avatar_Presentateur ="'.$_GET['ID_Pres'].'" WHERE ID_Avatar = "'.$_GET['ID_User'].'";';

	if ($connection->query($queryAjoutPresentateur) === TRUE) {
		echo "Record updated successfully";
	}
	else{
		echo "Error updating record: " . $connection->error;
	}

	$query_API = 'SELECT API_Visible_Key, API_Hidden_Key, Numero_Reunion, Nom_Avatar AS nom FROM DB_SALON_Presentateur WHERE ID_Avatar = "'. $_GET['ID_Pres'].'";';
}
else{

	$query_API = 'SELECT API_Visible_Key, API_Hidden_Key, Numero_Reunion, DB_SALON_Utilisateur.Nom_Avatar AS nom FROM DB_SALON_Presentateur, DB_SALON_Reunions, DB_SALON_Utilisateur WHERE DB_SALON_Utilisateur.ID_Avatar = DB_SALON_Reunions.ID_Avatar AND DB_SALON_Presentateur.ID_Avatar = DB_SALON_Reunions.ID_Avatar_Presentateur AND DB_SALON_Reunions.ID_Avatar = "'. $_GET['ID_User'].'";';

}

//On prends les clés de l'api selon la requete de qui on est
if($result = mysqli_query($connection,$query_API)) {
    while($rows = mysqli_fetch_assoc($result)){
		$Gapi_key = $rows['API_Visible_Key'];
		$Gapi_secret = $rows['API_Hidden_Key'];
		$Gmeeting_number = $rows['Numero_Reunion'];
		$UserName = $rows['nom'];
    }
    
    mysqli_free_result($result);
}else {
	echo "Fail api code request";
	exit();
}

$connection->close();

//Generation de la signature pour la réunion
$signatureFinal = generate_signature($Gapi_key,$Gapi_secret,$Gmeeting_number,$Grole);

function generate_signature ( $api_key, $api_secret, $meeting_number, $role){

    $time = time() * 1000 - 30000;

    $data = base64_encode($api_key . $meeting_number . $time . $role);

    $hash = hash_hmac('sha256', $data, $api_secret, true);

    $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);

    return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
}

?>


<html lang="fr">
<head>
    <!-- import #zmmtg-root css -->
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.8.1/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.8.1/css/react-select.css" />
<head>

<body>

	<!-- import ZoomMtg dependencies -->
	<script src="https://source.zoom.us/1.8.1/lib/vendor/react.min.js"></script>
	<script src="https://source.zoom.us/1.8.1/lib/vendor/react-dom.min.js"></script>
	<script src="https://source.zoom.us/1.8.1/lib/vendor/redux.min.js"></script>
	<script src="https://source.zoom.us/1.8.1/lib/vendor/redux-thunk.min.js"></script>
	<script src="https://source.zoom.us/1.8.1/lib/vendor/jquery.min.js"></script>
	<script src="https://source.zoom.us/1.8.1/lib/vendor/lodash.min.js"></script>

	<!-- import ZoomMtg -->
	<script src="https://source.zoom.us/zoom-meeting-1.8.1.min.js"></script>
	

	
	<script>

		ZoomMtg.preLoadWasm();
		ZoomMtg.prepareJssdk();

		const zoomMeeting = document.getElementById("zmmtg-root")


		GetSignature();

		function GetSignature(){
			
			ZoomMtg.init(
				{
					debug: true, 
    				leaveUrl: 'https://2orm.com/SALON/PHP/COMM/QuitterFile.php'}
			);
			ZoomMtg.join({
    			meetingNumber: '<?php echo $meeting_number?>',
    			userName: '<?php echo $UserName?>',
    			userEmail: '',
    			passWord: 'CACA',
    			apiKey: '<?php echo $api_key?>',
    			signature: '<?php echo $signatureFinal;?>',
    			success: function(res){console.log(res)},
    			error: function(res){console.log(res)}
 			});
		}
	</script>

	
</body>
</html>