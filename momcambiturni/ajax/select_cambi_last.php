<?php
require ("../config/config.php");


$response = [];
$response["status"] = false;
$response["response"] = [];

$user = $_SESSION["mom_user"];
$username = $user["matricola"];
$ultimo_visti = $user["ultimo_visti"];


$sql = "SET lc_time_names = 'it_IT'";
require("query.php");


$params = [$ultimo_visti];
$sql = "SELECT *, DATE_FORMAT(giorno, '%d/%m/%Y %W') AS giorno_format, DATE_FORMAT(giorno_cerco, '%d/%m/%Y %W') AS giorno_fine_format, DATE_FORMAT(giorno_cerco, '%d/%m/%Y %W') AS giorno_cerco_format, DATE_FORMAT(ora_inizio, '%H:%i') AS ora_inizio, DATE_FORMAT(ora_fine, '%H:%i') AS ora_fine  
		FROM cambi
			LEFT JOIN utenti ON utente_inserimento = matricola
        WHERE giorno >= CURDATE() AND inserimento >= ?
		ORDER BY inserimento DESC";
require("query.php");
if(!empty($rows)) {
	$response["status"] = true;
	$response["response"] = $rows;
} else {
	$response["status"] = false;
	$response["response"] = 'Nessuna nuova richiesta cambio turno o riposo inserita';
}

//risetto ultimo_visti
$params = [$username];
$sql = "UPDATE utenti 
        SET ultimo_visti = NOW() 
        WHERE matricola = ?";
require("query.php");


echo json_encode($response);
?>
