<?php 
session_start();

include 'ConnexionBD.php';

$query_API = 'SELECT * FROM DB_SALON_Presentateur WHERE ID_Avatar = "'. $_GET['ID_Pres'].'";';

if($result = mysqli_query($connection,$query_API)) {
    while($rows = mysqli_fetch_assoc($result)){
		$Gapi_key = $rows['API_Visible_Key'];
		$Gapi_secret = $rows['API_Hidden_Key'];
		$Gmeeting_number = $rows['Numero_Reunion'];
    }
    
    mysqli_free_result($result);
}else echo "Fail connection 1";

echo $_GET['ID_Pres']." ".$_GET['ID_User'];

$queryAjoutPresentateur = 'UPDATE DB_SALON_Reunions SET ID_Avatar_Presentateur ="'.$_GET['ID_Pres'].'" WHERE ID_Avatar = "'.$_GET['ID_User'].'";';

if ($connection->query($queryAjoutPresentateur) === TRUE) {
  echo "Record updated successfully";
}else {
  echo "Error updating record: " . $connection->error;
}

$connection->close();

//if(mysqli_query($connection,$queryAjoutPresentateur))
//{
//    echo "c'est ajouté";
//}
//else
//{
//    echo "c'est pas ajouté"
//}
//
//mysqli_close($connection);


/*
$Gapi_secret = '1ja0rXBkPuD5BAnGZ49IzSnurEHdW8koC97k';
$Gapi_key = 'H5lLtUUVTWq2BTw-ICNX9g';
$Gmeeting_number = 2412265718;
*/

if(isset($_GET["role"])){
	$Grole = $_GET["role"];
}
else {
	$Grole = 0;
}


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
			
			var signature = '<?php echo $signatureFinal;?>';

			ZoomMtg.init(
				{
					debug: true, 
    				leaveUrl: 'https://2orm.com/SALON/PHP/COMM/QuitterFile.php'}
			);
			ZoomMtg.join({
    			meetingNumber: 2412265718,
    			userName: 'User name',
    			userEmail: '',
    			passWord: 'CACA',
    			apiKey: 'H5lLtUUVTWq2BTw-ICNX9g',
    			signature: signature,
    			success: function(res){console.log(res)},
    			error: function(res){console.log(res)}
 		});
		}

		
		

	</script>

	
</body>
</html>