<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$id_cliente = h(trim($_POST['id_cliente']));

$query = "SELECT * FROM cliente WHERE id = '$id_cliente'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	$primer_apellido = trim($row['primer_apellido']);
	$segundo_apellido = trim($row['segundo_apellido']);
	$nombres = trim($row['nombres']);

	$nombre = $nombres . ' ' . $primer_apellido . ' ' . $segundo_apellido;

	$data = array('estado' => 'ok'
	,'nombre' => $nombre);
	exit(json_encode($data));
} else {
	enviarMsg('error','El cliente no existe en la base de datos.');
}

function enviarMsg($estado, $msg){
	$data = array('estado' => $estado
	,'msg' => $msg);
	exit(json_encode($data));
}
?>