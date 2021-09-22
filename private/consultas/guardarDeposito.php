<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$id_cliente = h(trim($_POST['id_cliente']));
$id_tipo_deposito = h(trim($_POST['id_tipo_deposito']));
$id_tipo_banco = h(trim($_POST['id_banco']));
$monto = h(trim($_POST['nMontoAdepositar']));
$monto = str_replace(',', '', $monto);
$id_usuario = $_SESSION['ApuestaTotal_idUsuario'];

if (esVacio($id_cliente)) {
	enviarMsg('error','El sistema no puede detectar al cliente, vuelva a realizar la consulta.');
}

if (esVacio($monto)) {
	enviarMsg('error','El sistema no detecta el monto, vuelva a realizar la consulta.');
}

if (!(is_numeric($monto) & preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $monto))) {
	enviarMsg('error','En monto ingresado no es un número.');
}

if($id_tipo_deposito != 1){
	$id_tipo_banco = '';
}

$query = "INSERT INTO deposito (id_cliente, id_tipo_deposito, id_tipo_banco, monto, id_usuario)
VALUES ('$id_cliente', '$id_tipo_deposito', '$id_tipo_banco', '$monto', '$id_usuario')";
if(mysqli_query($conn, $query)){
    enviarMsg('ok','Depósito guardado exitosamente.');
} else{
    enviarMsg('error','No se pudo guardar el deposito.' . mysqli_error($conn) );
}

function enviarMsg($estado, $msg){
	$data = array('estado' => $estado
	,'msg' => $msg);
	exit(json_encode($data));
}

function esVacio($variable){
	return is_null($variable) || empty($variable) || $variable == 0;
}
?>