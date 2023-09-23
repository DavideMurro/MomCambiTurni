<?php
require ("../config/config.php");


$respose = false;


unset($_COOKIE["mom_user"]);
setcookie("mom_user", "", time()-1, "/");

$_SESSION = array();
session_destroy();


$respose = true;

echo $respose;

?>