<?php
		 // -- CONNECTION TO MYSQL -- //
	include "datos_mysql.php";	
 
	$opcion = $_REQUEST['opcion'];
	if(isset($_REQUEST['usuario']))
		$usuario = $_REQUEST['usuario'];
	if(isset($_REQUEST['clave']))
		$pass = $_REQUEST['clave']; 
    if(isset($_REQUEST['idevento']))
		$idevento = $_REQUEST['idevento'];
    if(isset($_REQUEST['foto']))
		$foto = $_REQUEST['foto'];
    if(isset($_REQUEST['titulo']))
		$titulo = $_REQUEST['titulo']; 
    if(isset($_REQUEST['detalle']))
		$detalle = $_REQUEST['detalle']; 
    if(isset($_REQUEST['idubicacion']))
		$idubicacion = $_REQUEST['idubicacion'];
    if(isset($_REQUEST['nombre']))
		$nombre = $_REQUEST['nombre']; 
    if(isset($_REQUEST['apellido']))
		$apellido = $_REQUEST['apellido'];
	switch($opcion)
	{
		case 1:
			$query = "CALL iniciar_sesion('$usuario', '$pass')";
			if (!$res=$conexion->query($query))
				$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
			{
					$aux=($res->fetch_assoc());
					$vector = $aux;
			}
			break;
		case 2:
			$query = "SELECT idevento,titulo,detalle,usuario from evento where estatus=1;";
			if (!$res=$conexion->query($query))
					$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
			{
					$i=0;
					while($aux = $res->fetch_assoc())
					{$vector[$i] = $aux; $i++;}
					
			}
			break;
		case 3:
			$query = "SELECT idevento,titulo,detalle,usuario,fechahora,foto, descripcion as ubicacion from evento, ubicacion where idevento='".$idevento."' and id=ubicacion.id;";
//			$query = "SELECT idevento,titulo,detalle,usuario,fechahora,foto from evento where idevento='".$idevento."' ;";
			if (!$res=$conexion->query($query))
					$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
			{
					$i=0;
					while($aux = $res->fetch_assoc())
					{$vector = $aux; $i++;}
					
			}
			break;
        case 4:
            $query = "INSERT INTO evento (usuario, titulo, detalle, idubicacion, foto) VALUES('$usuario', '$titulo', '$detalle', '$idubicacion', '$foto')";
            if (!$res=$conexion->query($query))
					$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
			{
					$vector['R'] = "Exito";
					
			}
            break;
        case 5:
            $query = "SELECT descripcion from ubicacion";
            if (!$res=$conexion->query($query))
					$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
            {
                $i=0;
                while($aux = $res->fetch_assoc())
                {$vector[$i] = $aux; $i++;}
            }
            break;
        case 6:
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
            $numerodeletras=10; //numero de letras para generar el texto
            $cadena = ""; //variable para almacenar la cadena generada
            for($i=0;$i<$numerodeletras;$i++)
            {
                $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
            entre el rango 0 a Numero de letras que tiene la cadena */
            }
            $query = "UPDATE usuarios SET pass='$cadena' WHERE usuario='$usuario'";
            if (!$res=$conexion->query($query))
					$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
			{
				mail($usuario, "Restablecimiento de Clave SECUNEG", "Su nueva clave es $cadena");	
                $vector['R'] = "Clave enviada al correo";
					
			}
            break;
        case 7:
            $query = "CALL registro('$usuario', '$pass', '$nombre', '$apellido')";
			if (!$res=$conexion->query($query))
				$vector['R'] = "CALL failed: (" . $conexion->errno . ") " . $conexion->error;
			else
			{
					$aux=($res->fetch_assoc());
					$vector = $aux;
			}
			break;
		default:
            
			
	}
	$json_string = json_encode($vector);
	echo $json_string;

?>
