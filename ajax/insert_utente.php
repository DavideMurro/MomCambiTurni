<?php
require ("../config/config.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$utente = $request->utente;
$delete = $request->delete;

$user = $_SESSION["mom_user"];


$response = [];
$response["status"] = false;
$response["response"] = '';


if($user["admin"] == 1) {
	if(!$delete) {
		$params = [$utente->matricola, $utente->password, $utente->nome, $utente->cognome, $utente->mail, $utente->telefono, $utente->password, $utente->nome, $utente->cognome, $utente->mail, $utente->telefono];
		$sql = "INSERT INTO utenti
			(matricola, password, nome, cognome, mail, telefono)
			VALUES
			(?, ?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE password = ?, nome = ?, cognome = ?, mail = ?, telefono = ?";
		require("query.php");

		$response["status"] = true;
		$response["response"] = $insert;

	} else {
		$params = [$utente->matricola];
		$sql = "DELETE FROM utenti
				WHERE matricola = ?";
		require("query.php");

		$response["status"] = true;
		$response["response"] = $delete;
	}

} else {
	$response["status"] = false;
	$response["response"] = 'Non sei admin';
}


echo json_encode($response);

?>
