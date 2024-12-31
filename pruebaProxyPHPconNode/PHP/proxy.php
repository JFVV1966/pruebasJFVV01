<?php
// Redirige una llamada recibida al servidor Node


$servidor = "localhost";
$puerto = 8000;

$params = $_SERVER['QUERY_STRING'];

$url = "http://" . $servidor . ":" . $puerto . "?" . $params;


$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

curl_setopt($handle, CURLOPT_HTTPHEADER, array('mi_cabecera: ABC_XYZ'));

/*
if ($metodo == "POST") {
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, $_POST);	// Directamente lo recibido en $_POST se lo pasamos a la ESP32
	//curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
	curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // Los POST los trabajamos como multipart/form-data
}
*/


$result = curl_exec($handle);	

if ($result === false) {
	header('HTTP/1.1 425 Error ejecucion CURL');
	exit;
}

header('HTTP/1.1 ' . curl_getinfo($handle, CURLINFO_RESPONSE_CODE));
echo $result;

curl_close($handle);



?>