<?php 

include 'ConnexionBD.php';
session_start();
$Gapi_key = "";
$Gapi_secret = "";
$Gmeeting_number = "";
$UserName= "";
$query_API= "";
//Si on est présentateur, on s'ajoute à la base de données de la réunion,
//Sinon on crée juste la requete pour prendre les clés de l'api
if ($_GET['role'] == 1) {
	$Grole = 1;

	$queryAjoutPresentateur = 'UPDATE DB_SALON_Reunions SET ID_Avatar_Presentateur ="'.$_GET['ID_Pres'].'" WHERE ID_Avatar = "'.$_GET['ID_User'].'";';

	if ($connection->query($queryAjoutPresentateur) == TRUE) {
		echo "<script>console.log('Record updated successfully')</script>";
	}
	else{
		echo "<script>console.log('Error updating record: ". $connection->error."')</script>";
	}

	$query_API = 'SELECT API_Visible_Key, API_Hidden_Key, Numero_Reunion, Nom_Avatar AS nom FROM DB_SALON_Presentateur WHERE ID_Avatar = "'. $_GET['ID_Pres'].'";';
}
else{

	$query_API = 'SELECT API_Visible_Key, API_Hidden_Key, Numero_Reunion, DB_SALON_Utilisateur.Nom_Avatar AS nom FROM DB_SALON_Presentateur, DB_SALON_Reunions, DB_SALON_Utilisateur WHERE DB_SALON_Utilisateur.ID_Avatar = DB_SALON_Reunions.ID_Avatar AND DB_SALON_Presentateur.ID_Avatar = DB_SALON_Reunions.ID_Avatar_Presentateur AND DB_SALON_Reunions.ID_Avatar = "'. $_GET['ID_User'].'";';

}

//On prends les clés de l'api selon la requete de qui on est
//echo "<script>console.log('".$query_API."')</script>";

//var_dump(mysqli_query($connection,$query_API));
//echo "<script>console.log('Condition = ".mysqli_query($connection,$query_API)."')</script>";
require_once "../PDO_Connect/PDO_Connect.php";
$connection=connect_bd();
/*if(*/
	$result = $connection->prepare($query_API);
	//$result = mysqli_query($connection,$query_API)) /*{*/
    echo "<script>console.log('".$query_API."')</script>";
    $result->execute();
	echo "<script>console.log('Test')</script>";
    echo "<script>console.log('".$result->rowCount()."')</script>";
    if ($result->rowCount()>0)
    {
    	echo "<script>console.log('".$result->rowCount()."')</script>";
    	$result->setFetchMode(PDO::FETCH_ASSOC);
    	foreach ($result as $rows)
    	{
    		//echo "<script>console.log('Creation des inputs cachés')</script>";
			$Gapi_key = $rows['API_Visible_Key'];
			//echo '<input type="hidden" id="api_key" value="'.$rows['API_Visible_Key'].'"/>';
			$Gapi_secret = $rows['API_Hidden_Key'];
			//echo '<input type="hidden" id="api_secret" value="'.$rows['API_Hidden_Key'].'"/>';
			$Gmeeting_number = $rows['Numero_Reunion'];
			//echo '<input type="hidden" id="meeting_number" value="'.$rows['Numero_Reunion'].'"/>';
			$UserName = $rows['nom'];
			//echo '<input type="hidden" id="UserName" value="'.$rows['nom'].'"/>';
    	}
    	/*while($rows = mysqli_fetch_assoc($result))
    	{
			
	    }
	    mysqli_free_result($result);*/
    }
    else {
	echo "Fail api code request";
	//exit();
	}

    
/*}else {
	echo "Fail api code request";
	exit();
}*/

//	$connection->close();

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
			/*if(document.getElementById("meeting_number")!=null)
			{
				ZoomMtg.join({
    			meetingNumber: document.getElementById("meeting_number").value,
    			userName: document.getElementById("UserName").value,
    			userEmail: '',
    			passWord: '1819',
    			apiKey: document.getElementById("api_key").value,
    			signature: '<?php //echo $signatureFinal;?>',
    			success: function(res){console.log(res)},
    			error: function(res){console.log(res)}
 				});
			}
			else
			{*/
				ZoomMtg.join({
    			meetingNumber: '<?php echo $Gmeeting_number;?>',
    			userName: '<?php echo $UserName;?>',
    			userEmail: '',
    			passWord: '1819',
    			apiKey: '<?php echo $Gapi_key;?>',
    			signature: '<?php echo $signatureFinal;?>',
    			success: function(res){console.log(res)},
    			error: function(res){console.log(res)}
 				});
			//}
			
		}
	</script>
	
</body>
</html>