<?php
require ("../config/config.php");


$response = [];
$response["status"] = false;
$response["response"] = [];


$sql = "SET lc_time_names = 'it_IT'";
require("query.php");


$sql = "SELECT *, DATE_FORMAT(giorno, '%d/%m/%Y %W') AS giorno_format, DATE_FORMAT(giorno_cerco, '%d/%m/%Y %W') AS giorno_fine_format, DATE_FORMAT(ora_inizio, '%H:%i') AS ora_inizio, DATE_FORMAT(ora_fine, '%H:%i') AS ora_fine  
		FROM cambi
			LEFT JOIN utenti ON utente_inserimento = matricola
		WHERE fl_riposo = 0 AND giorno >= CURDATE() AND DATE_FORMAT(ora_inizio, '%H') < 11
		ORDER BY giorno, ora_inizio";
require("query.php");
if(!empty($rows)) {
	$response["status"]["mattina"] = true;
	$response["response"]["mattina"] = $rows;
} else {
	$response["status"]["mattina"] = false;
	$response["response"]["mattina"] = 'Nessuna richiesta cambio turno inserita';
}


$sql = "SELECT *, DATE_FORMAT(giorno, '%d/%m/%Y %W') AS giorno_format, DATE_FORMAT(giorno_cerco, '%d/%m/%Y %W') AS giorno_fine_format, DATE_FORMAT(ora_inizio, '%H:%i') AS ora_inizio, DATE_FORMAT(ora_fine, '%H:%i') AS ora_fine  
		FROM cambi
			LEFT JOIN utenti ON utente_inserimento = matricola
		WHERE fl_riposo = 0 AND giorno >= CURDATE() AND DATE_FORMAT(ora_inizio, '%H') >= 11
		ORDER BY giorno, ora_inizio";
require("query.php");
if(!empty($rows)) {
	$response["status"]["pomeriggio"] = true;
	$response["response"]["pomeriggio"] = $rows;
} else {
	$response["status"]["pomeriggio"] = false;
	$response["response"]["pomeriggio"] = 'Nessuna richiesta cambio turno inserita';
}


$sql = "SELECT *, DATE_FORMAT(giorno, '%d/%m/%Y %W') AS giorno_format, DATE_FORMAT(giorno_cerco, '%d/%m/%Y %W') AS giorno_cerco_format  
		FROM cambi
			LEFT JOIN utenti ON utente_inserimento = matricola
		WHERE fl_riposo = 1 AND (giorno_cerco >= CURDATE() || giorno >= CURDATE())
		ORDER BY giorno_cerco, giorno";
require("query.php");
if(!empty($rows)) {
	$response["status"]["riposo"] = true;
	$response["response"]["riposo"] = $rows;
} else {
	$response["status"]["riposo"] = false;
	$response["response"]["riposo"] = 'Nessuna richiesta riposo inserita';
}


echo json_encode($response);

?>
