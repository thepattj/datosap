<?php  
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
/* Connect to the local server using Windows Authentication and   
specify the AdventureWorks database as the database in use. */  
$serverName = "192.168.16.5";  
$connectionInfo = array( "Database"=>"Corporativo", "UID"=>"sa", "PWD"=>"ControlGas2016.");  
$conn = sqlsrv_connect( $serverName, $connectionInfo);  
if( $conn === false ){  
     echo "Could not connect.\n";  
     die( print_r( sqlsrv_errors(), true));  
}  

$bandera = $_POST['flag'];

if($bandera == 'inicioSes'){
	$tsql_callSP = "{call LogInApp( ?, ? )}";  
	$correo = $_POST['correo'];
	$pass = $_POST['contrasena'];
	$params = array(   
	                 array($correo),  
	                 array($pass)  
	               );  

	/* Execute the query. */ 
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);  
	if ( $stmt3 ){
		$next_result = sqlsrv_next_result($stmt3);  
		if( $next_result ){
			while( $row = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC)){
				echo $row['Respuesta']."*";
		        echo $row['ModuloSemaforo']."*";
		        echo $row['ModuloSemaforoEstacionesValidas']."*";
		        echo $row['ModuloCortes']."*";
		        echo $row['ModuloCortesEstacionesValidas'];
		    }  
		}  
		elseif( is_null($next_result)){  
		     echo "No more results.\n";  
		}else{  
		     echo "Error in moving to next result.\n";  
		     die(print_r(sqlsrv_errors(), true));  
		} 
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} //CARGA LOS DATOS QUE TIENE EL USUARIO
}

if($bandera == 'consolida'){
	$tsql_callSP = "{call LlenadoConsolidado( ? ) }";
	$estac = $_POST['est'];
	$params = array(
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	/*echo "debe entrar aqui al stmt3";*/
	/*echo $stmt3;*/
	if($stmt3){
		//echo "entra al if";
		//echo "Rows affectd: ".sqlsrv_rows_affected($stmt3)."<br>";
		//echo $stmt3;
		//$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {		    
		    echo $obj['CodGas']."*".$obj['Abr']."*".$obj['fecha']."*".number_format($obj['TotalVenta'])."*".number_format($obj['TotalLitros'])."*"; 
		}
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3 <br>";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	}
}

if($bandera == 'inicioSer'){
	$tsql_callSP = "{call LlenarSemaforoEstaciones( ? )}";
	$estac = $_POST['est'];
	$params = array(
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	if($stmt3){
		//echo "Rows affectd: ".sqlsrv_rows_affected($stmt3)."<br>";
		//echo $stmt3;
		//$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo $obj['Abr']."*".$obj['DirWSEstacion']."*"; 
		}
	} //CARGA LAS ESTACIONES
}

if($bandera == 'inicioFin'){
	$tsql_callSP = "{call LlenarPaginaPrincipal }";
	$estac = '';
	/*$estac = '1,1,1,1,1,1';*/
	$params = array(
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP);
	if($stmt3){
		/*$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));*/
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo $obj['CodGas']."*".$obj['Abr']."*".$obj['dirImagen']."*"; 
		    										//ESTA HAY QUE QUITARLE LA HORA
		}
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} //CARGA LAS ESTACIONES
}

if($bandera == 'cargaFin'){ //CARGA EL CORTE
	$tsql_callSP = "{call LlenadoUltimoCorte( ? ) }";
	$estac = $_POST['idesta'];
	/*$estac = '1,1,1,1,1,1';*/
	$params = array(
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	if($stmt3){
		/*$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));*/
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo $obj['Abr']."*".number_format($obj['TotalVenta'])."*".$obj['fecha']."*".$obj['PrecioMagna']."*".$obj['PrecioPremium']."*".$obj['PrecioDiesel']."*".number_format($obj['LitrosMagna'])."*".number_format($obj['LitrosPremium'])."*".number_format($obj['LitrosDiesel'])."*".number_format($obj['TotalLitros'])."*".$obj['PorVentLitMagna']."*".$obj['PorVentLitPremium']."*".$obj['PorVentLitDiesel']."*"; 
		    										//ESTA HAY QUE QUITARLE LA HORA
		}
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	}
}

if($bandera == 'fechaFin'){ //CARGA POR EL RANGO DE FECHAS
	/*$tsql_callSP = "{call LlenadoConsultaFecha( ?, ?, ? )}";
	$inicio = $_POST['fecini'];
	$fin = $_POST['fecfin'];
	$estac = $_POST['idesta'];
	//echo $inicio.$fin.$estac;
	$params = array(
				 array($inicio),
				 array($fin),
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	if($stmt3){
		//echo "Rows affectd: ".sqlsrv_rows_affected($stmt3)."<br>";
		//echo $stmt3;
		//$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo number_format($obj['VentaTotalMagna'])."*".number_format($obj['VentaTotalPremium'])."*".number_format($obj['VentaTotalDiesel'])."*".number_format($obj['TotalVenta'])."*".number_format($obj['LitrosTotalMagna'])."*".number_format($obj['LitrosTotalPremium'])."*".number_format($obj['LitrosTotalDiesel'])."*".number_format($obj['TotalLitros'])."*".$obj['PorLitrosTotalMagna']."*".$obj['PorLitrosTotalPremium']."*".$obj['PorLitrosTotalDiesel']."*".$obj['PrecioPromedioMagna']."*".$obj['PrecioPromedioPremium']."*".$obj['PrecioPromedioDiesel']."*"; 
		}
	}*/
	$tsql_callSP = "{call LlenadoConsultaFechaConsulta( ?, ?, ? )}";
	$inicio = $_POST['fecini'];
	$fin = $_POST['fecfin'];
	$estac = $_POST['idesta'];
	//echo $inicio.$fin.$estac;
	$params = array(
				 array($inicio),
				 array($fin),
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	if($stmt3){
		//echo "Rows affectd: ".sqlsrv_rows_affected($stmt3)."<br>";
		//echo $stmt3;
		//$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo number_format($obj['VentaTotalMagna'])."*".number_format($obj['VentaTotalPremium'])."*".number_format($obj['VentaTotalDiesel'])."*".number_format($obj['TotalVenta'])."*".number_format($obj['LitrosTotalMagna'])."*".number_format($obj['LitrosTotalPremium'])."*".number_format($obj['LitrosTotalDiesel'])."*".number_format($obj['TotalLitros'])."*".$obj['PorLitrosTotalMagna']."*".$obj['PorLitrosTotalPremium']."*".$obj['PorLitrosTotalDiesel']."*".$obj['PrecioPromedioMagna']."*".$obj['PrecioPromedioPremium']."*".$obj['PrecioPromedioDiesel']."*".$obj['fecha']."*"; 
		}
	}
	if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} //CARGA LOS DATOS QUE TIENE EL USUARIO
}

if($bandera == 'ventaFin'){
	$tsql_callSP = "{call LlenadoTotalesPromedio( ? ) }";
	$estac = $_POST['idesta'];
	/*$estac = '1,1,1,1,1,1';*/
	$params = array(
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	if($stmt3){
		/*$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));*/
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo number_format($obj['VentaTotalMagna'])."*".number_format($obj['VentaTotalPremium'])."*".number_format($obj['VentaTotalDiesel'])."*".number_format($obj['TotalVenta'])."*".number_format($obj['LitrosTotalMagna'])."*".number_format($obj['LitrosTotalPremium'])."*".number_format($obj['LitrosTotalDiesel'])."*".number_format($obj['TotalLitros'])."*".$obj['PromLitrosTotalMagna']."*".$obj['PromLitrosTotalPremium']."*".$obj['PromLitrosTotalDiesel']."*".$obj['PrecioPromedioMagna']."*".$obj['PrecioPromedioPremium']."*".$obj['PrecioPromedioDiesel']."*";
		    										//ESTA HAY QUE QUITARLE LA HORA
		   /*echo $obj['VentaTotalMagna']."*";*/
		}
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} 
}

if($bandera == 'promedioFin'){
	/*$tsql_callSP = "{call LlenadoTotalesPromedio( ? ) }";
	$estac = $_POST['idesta'];
	//$estac = '1,1,1,1,1,1';
	$params = array(
				 array($estac)
	            );
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
	if($stmt3){
		//$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo number_format($obj['VentaPromedioMagna'])."*".number_format($obj['VentaPromedioPremium'])."*".number_format($obj['VentaPromedioDiesel'])."*".number_format($obj['TotalPromVenta'])."*".number_format($obj['LitrosPromedioMagna'])."*".number_format($obj['LitrosPromedioPremium'])."*".number_format($obj['LitrosPromedioDiesel'])."*".number_format($obj['TotalPromLitros'])."*".$obj['PromLitrosPromedioMagna']."*".$obj['PromLitrosPromedioPremium']."*".$obj['PromLitrosPromedioDiesel']."*".$obj['PrecioPromedioMagna']."*".$obj['PrecioPromedioPremium']."*".$obj['PrecioPromedioDiesel']."*";
		    										//ESTA HAY QUE QUITARLE LA HORA
		   //echo $obj['VentaTotalMagna']."*";
		}
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} */
	$tsql_callSP = "{call LlenadoPromedio( ? )}";
	$estacion = $_POST['idesta'];
	$params = array(   
	                 array($estacion)  
	               );  

	//Execute the query.
	$stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);  
	if($stmt3){
		//$product = sqlsrv_fetch_object( $stmt3, "Estacion", array($i));
		while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
		    echo number_format($obj['VentaPromedioMagna'])."*".number_format($obj['VentaPromedioPremium'])."*".number_format($obj['VentaPromedioDiesel'])."*".number_format($obj['TotalPromVenta'])."*".number_format($obj['LitrosPromedioMagna'])."*".number_format($obj['LitrosPromedioPremium'])."*".number_format($obj['LitrosPromedioDiesel'])."*".number_format($obj['TotalPromLitros'])."*".$obj['PromLitrosPromedioMagna']."*".$obj['PromLitrosPromedioPremium']."*".$obj['PromLitrosPromedioDiesel']."*".$obj['PrecioPromedioMagna']."*".$obj['PrecioPromedioPremium']."*".$obj['PrecioPromedioDiesel']."*".$obj['MesAno']."*";
		  	//ESTA HAY QUE QUITARLE LA HORA
		   //echo $obj['VentaTotalMagna']."*";
		}
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} //CARGA LOS DATOS QUE TIENE EL USUARIO
}
/*Free the statement and connection resources. */  
sqlsrv_close( $conn);  
?>