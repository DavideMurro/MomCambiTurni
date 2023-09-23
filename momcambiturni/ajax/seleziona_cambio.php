<?php
require ("../config/config.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$id = $request->id;

$user = $_SESSION["mom_user"];


$response = [];
$response["status"] = false;
$response["response"] = '';

$params = [$user["matricola"], $id];
$sql = "UPDATE cambi
		SET utente_prenotato = ?
		WHERE id = ?";
require("query.php");


if(isset($update) && $update) {
	$response["status"] = true;
	$response["response"] = $user["matricola"];
} else {
	$response["status"] = false;
	$response["response"] = "Impossibile aggiornare lo stato";
}


echo json_encode($response);

?>
