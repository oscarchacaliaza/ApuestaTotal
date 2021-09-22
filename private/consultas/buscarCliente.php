<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$nNumDocuIdentidad = h(trim($_POST['nNumDocuIdentidad']));
$sTipoDocuIdentidad = h(trim($_POST['sTipoDocuIdentidad']));

$query = "SELECT * FROM cliente WHERE num_docu_ident = '$nNumDocuIdentidad' AND id_tipo_docu_ident = '$sTipoDocuIdentidad'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	$id_cliente = trim($row['id']);
	$id_tipo_docu_ident = trim($row['id_tipo_docu_ident']);
	$num_docu_ident = trim($row['num_docu_ident']);
	$primer_apellido = trim($row['primer_apellido']);
	$segundo_apellido = trim($row['segundo_apellido']);
	$nombres = trim($row['nombres']);
	$email = trim($row['email']);
	$telefono = trim($row['telefono']);

	$data = array('estado' => 'ok'
	,'id_cliente' => $id_cliente
	,'id_tipo_docu_ident' => $id_tipo_docu_ident
	,'num_docu_ident' => $num_docu_ident
	,'primer_apellido' => $primer_apellido
	,'segundo_apellido' => $segundo_apellido
	,'nombres' => $nombres
	,'email' => $email
	,'telefono' => $telefono);
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