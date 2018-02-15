<?php  
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
/* Connect to the local server using Windows Authentication and   
specify the AdventureWorks database as the database in use. */  
//$serverName = "192.168.16.5";  
$serverName = "138.122.98.73";
$connectionInfo = array( "Database"=>"Corporativo", "UID"=>"sa", "PWD"=>"ControlGas2016.");  
$conn = sqlsrv_connect( $serverName, $connectionInfo);  
if( $conn === false ){  
     echo "Could not connect.\n";  
     die( print_r( sqlsrv_errors(), true));  
}  
/*---------LLENADO DE PROMEDIO POR DESGLOCE DE MESES---------*/
	/*$tsql_callSP = "{call LlenadoPromedio( ? )}";  
	//$correo = $_POST['correo'];
	//$pass = $_POST['contrasena'];
	$estacion = 2;
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
	}*/ //CARGA LOS DATOS QUE TIENE EL USUARIO

/*---------DESGLOCE DE FECHAS POR DIAS-----------------------*/
$tsql_callSP = "{call LlenadoConsultaFechaConsulta( ?, ?, ? )}";
	$inicio = '01/02/2018';
	$fin = '05/02/2018';
	$estac = 1;
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
	}if( $stmt3 === false ){  
	     echo "Error in executing statement 3.\n";  
	     die( print_r( sqlsrv_errors(), true)); 
	     echo "ERROR DE DATOS";
	} //CARGA LOS DATOS QUE TIENE EL USUARIO
/*Free the statement and connection resources. */  
sqlsrv_close( $conn);  
?>