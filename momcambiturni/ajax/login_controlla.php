<?php
require ("../config/config.php");


$response = [];
$response["status"] = false;
$response["response"] = '';


if(isset($_COOKIE["mom_user"])) {
	$_SESSION["mom_user"] = unserialize($_COOKIE["mom_user"]);
}

if(isset($_SESSION["mom_user"])) {
	$username = $_SESSION["mom_user"]["matricola"];

	$params = [$username];
	$sql = "SELECT matricola, nome, cognome, mail, telefono, admin, ultimo_accesso, ultimo_visti  
			FROM utenti 
			WHERE matricola = ?";
	require("query.php");

	if(!empty($rows)) {
		$row = $rows[0];

		//mi salvo lo user
		$_SESSION["mom_user"] = $row;
        
        
        //update ultimo accesso
        $params = [$username];
        $sql = "UPDATE utenti 
                SET ultimo_accesso = NOW() 
                WHERE matricola = ?";
        require("query.php");


		$response["status"] = true;
		$response["response"] = $_SESSION["mom_user"];

	} else {
		$response["status"] = false;
		$response["response"] = 'Utente eliminato o inesistente';
	}
} else {
	$response["status"] = false;
	$response["response"] = 'Sessione scaduta';
}


echo json_encode($response);

?>
