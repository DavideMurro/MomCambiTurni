<?php
require ("../config/config.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$username = $request->username;
$password = $request->password;
if(isset($request->ricordami)) {
	$ricordami = $request->ricordami;
} else {
	$ricordami = false;
}



$respose = false;

$params = [$username, $password];
$sql = "SELECT matricola, nome, cognome, mail, telefono, admin, ultimo_accesso, ultimo_visti  
		FROM utenti 
		WHERE matricola = ? AND password = ?";
require("query.php");

if(!empty($rows)) {
	$row = $rows[0];
	$respose = true;

	//mi salvo lo user
	$_SESSION["mom_user"] = $row;
	if($ricordami) {
		setcookie("mom_user", serialize($row), time() + (86400*365), "/"); // 86400 = 1 day
	} else {
		unset($_COOKIE["mom_user"]);
		setcookie("mom_user", "", time()-1, "/");
	}
    

} else {
	$respose = false;
}


echo $respose;

?>
