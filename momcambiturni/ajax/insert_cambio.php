<?php
require ("../config/config.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$form = $request->form;

$user = $_SESSION["mom_user"];


$response = [];
$response["status"] = false;
$response["response"] = '';

$form->data = new DateTime($form->data);
$form->data = $form->data->format('Y-m-d');
// se non ho data fine mi prendo quella di inizio
if($form->datafine) {
    $form->datafine = new DateTime($form->datafine);
	$form->datafine = $form->datafine->format('Y-m-d');
} else {
	$form->datafine = $form->data;
}

$form->riposo->cedo = new DateTime($form->riposo->cedo);
$form->riposo->cedo = $form->riposo->cedo->format('Y-m-d');
$form->riposo->cerco = new DateTime($form->riposo->cerco);
$form->riposo->cerco = $form->riposo->cerco->format('Y-m-d');




if($form->fl_riposo) {
	//controllo non abbia già inserito in questa data
    $params = [$form->fl_riposo, $form->riposo->cerco, $user["matricola"]];
    $sql = "SELECT DATE_FORMAT(giorno_cerco, '%d/%m/%Y') AS giorno_cerco_format
            FROM cambi
            WHERE fl_riposo = ? AND giorno_cerco = ? AND utente_inserimento = ?";
    require("query.php");
    
    if(!$rows || !$rows[0]) {
    	$params = [$form->riposo->cedo, $form->riposo->cerco, $form->note, $form->fl_riposo, $user["matricola"]];
        $sql = "INSERT INTO cambi
              (inserimento, giorno, giorno_cerco, note, fl_riposo, utente_inserimento)
              VALUES
              (NOW(), ?, ?, ?, ?, ?)";
        require("query.php");
        
        
        if(isset($insert) && $insert) {
            $response["status"] = true;
            $response["response"] = $insert;
        } else {
            $response["status"] = false;
            $response["response"] = "Inserimento non riuscito";
        }
    } else {
    	$response["status"] = false;
		$response["response"] = "Hai già inserito la data " . $rows[0]["giorno_cerco_format"] . " nel CERCO";
    }

} else {
	$diff = date_diff(date_create($form->datafine), date_create($form->data)); 
	$diff = $diff->d; 
    $data = $form->data;

	while($diff >= 0) {
    	$rows = null;
        $params = [0, $data, $user["matricola"]];
        $sql = "SELECT DATE_FORMAT(giorno, '%d/%m/%Y') AS giorno_format
                FROM cambi
                WHERE fl_riposo = ? AND giorno = ? AND utente_inserimento = ?";
        require("query.php");

        if(!$rows || !$rows[0]) {
            $params = [$data, $form->ora->inizio, $form->ora->fine, $form->numero_turno, $form->note, 0, $user["matricola"]];
            $sql = "INSERT INTO cambi
              (inserimento, giorno, ora_inizio, ora_fine, numero_turno, note, fl_riposo, utente_inserimento)
              VALUES
              (NOW(), ?, ?, ?, ?, ?, ?, ?)";
            require("query.php");
            
            if(isset($insert) && $insert) {
                $response["status"] = true;
                $response["response"] = $insert;
            } else {
                $response["status"] = false;
                $response["response"] = "Inserimento non riuscito";
            }
        } else {
            $response["status"] = false;
            $response["response"] = "Hai già inserito la data " . $rows[0]["giorno_format"];
        }

        $data = date('Y-m-d', strtotime(' +1 day', strtotime($data)));
        $diff--;
    }
}


echo json_encode($response);

?>
