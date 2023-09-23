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
$sql = "DELETE FROM cambi
		WHERE utente_inserimento = ? AND id = ?";
require("query.php");


if(isset($delete) && $delete) {
	$response["status"] = true;
	$response["response"] = $delete;
} else {
	$response["status"] = false;
	$response["response"] = "Eliminazione non riuscita";
}


echo json_encode($response);

?>
