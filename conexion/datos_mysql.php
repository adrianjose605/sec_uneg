 <?php
// -- CONNECTION TO MYSQL -- //
	$server     = 'localhost'; 
	$username   = 'root'; 
	$password   = ''; 
	$database   = 'sql5109534'; 
	$conexion = new mysqli();
	@$conexion->connect($server, $username, $password, $database);	
	if ($conexion->connect_error){		die('Error de conexión: ' . $conexion->connect_error); 
	}
	$conexion->set_charset("utf8");	
?>