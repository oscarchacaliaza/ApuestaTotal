<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$id = h(trim($_POST['id']));

$query = "SELECT * FROM tipo_docu_identidad WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	$numDigitos = trim($row['digitos']);
	$posee_numeros = trim($row['posee_numeros']);
	$posee_letras = trim($row['posee_letras']);
	$data = array('estado' => 'ok'
	,'numDigitos' => $numDigitos
	,'posee_numeros' => $posee_numeros
	,'posee_letras' => $posee_letras);
	exit(json_encode($data));
} else {
	enviarMsg('error','El usuario ' . $usuario . ' no existe en la base de datos.');
}

function enviarMsg($estado, $msg){
	$data = array('estado' => $estado
	,'msg' => $msg);
	exit(json_encode($data));
}
?>