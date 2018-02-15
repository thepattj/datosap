<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

		/*$url = "http://38.65.137.59:8081/ServicioEstaciones/Service1.svc/MandarOperacion";*/	
		/*$peticion = "status";*/
		$url = $_POST['direcion'];
		$peticion = $_POST['estado'];
		$port = $_POST['p'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => $port,
		  CURLOPT_URL => "$url",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "Content-Disposition: form-data; name=\"json_data\"\r\n\r\n{\"operacion\":\"$peticion\"}\r\n",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; "
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	
	
	
	
?>