<?php
session_start();
require_once('../initialize.php');
$usuario = trim($_POST['usuario']);
$clave = trim($_POST['contrasena']);

if( empty($usuario) OR empty($clave) ){
	enviarMsg('error','Ingrese el usuario o la contraseña.');
} else {
	include_once(CONEXION_PATH . '/conexion.php');
	// $contrasena = md5($usuario.$clave);
	$contrasena = $clave;

	$query = "SELECT * FROM usuario WHERE usuario = '$usuario'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$contrasenaResult = trim($row['password']);
		$estado = $row['estado'];
		$id = $row['id'];
		$nombre = $row['nombre'];
		$cargo = $row['cargo'];
		if ($contrasenaResult != $contrasena) {
			enviarMsg('error','Contraseña incorrecta.');
		} else if ($estado != 1) {
			enviarMsg('error','El usuario se encuentra deshabilitado.');
		} else {
			$_SESSION['ApuestaTotal_idUsuario'] = $id;
			$_SESSION['ApuestaTotal_nombre'] = $nombre;
			$_SESSION['ApuestaTotal_cargo'] = $cargo;

			enviarMsg('ok','Inicio de sesión correcto.');
		}		
	} else {
		enviarMsg('error','El usuario ' . $usuario . ' no existe en la base de datos.');
	}
}

function enviarMsg($estado, $msg){
	$data = array('estado' => $estado
	,'msg' => $msg);
	exit(json_encode($data));
}
?>