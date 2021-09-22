<?php 
require_once('../initialize.php');
include_once(CONEXION_PATH . '/conexion.php');

$nNumDocuIdentidad = h(trim($_POST['nNumDocuIdentidad']));
$id_cliente = '';

$query = "SELECT * FROM cliente WHERE num_docu_ident = '$nNumDocuIdentidad'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	$id_cliente = trim($row['id']);
} else {
	enviarMsg('error','El cliente no existe en la base de datos.');
}

if (!(empty($id_cliente))) {
	$query = "SELECT
	t.tipo_deposito,
	b.nombre_banco,
	d.monto,
	d.fecha,
	u.usuario
	FROM deposito d
	INNER JOIN tipo_deposito t ON t.id = d.id_tipo_deposito
	INNER JOIN usuario u ON u.id = d.id_usuario
	LEFT JOIN banco b ON b.id = d.id_tipo_banco
	WHERE d.id_cliente = '$id_cliente' AND d.estado = '1'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) > 0) {
		$html = '<table class="table">
		<thead class="table-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Fecha del depósito</th>
				<th scope="col">Tipo de depósito</th>
				<th scope="col">Monto depositado</th>
				<th scope="col">Registrado por</th>
			</tr>
		</thead>
		<tbody>';

		$contador = 1;
		$monto_total = 0;

		while ($row = mysqli_fetch_array($result)) {
			$tipo_deposito = trim($row['tipo_deposito']);
			$nombre_banco = trim($row['nombre_banco']);
			$monto = trim($row['monto']);
			$fecha = trim($row['fecha']);
			$usuario = trim($row['usuario']);

			if (!(empty($nombre_banco))) {
				$nombre_banco = '(' . $nombre_banco . ')';
			}
			$html .= '
			<tr>
	          <th scope="row">' . $contador . '</th>
	          <td>' . $fecha . '</td>
	          <td>' . $tipo_deposito . $nombre_banco . '</td>
	          <td  align ="right">' . $monto . '</td>
	          <td>' . $usuario . '</td>
	        </tr>';

	        $monto_total = $monto_total + $monto;
	        $contador++;
		}

		$html .= '</tbody>
		</table>';

		$data = array('estado' => 'ok'
		,'tabla' => $html
		,'saldo' => $monto_total);
		exit(json_encode($data));
	} else {
		$msg = '<div class="alert alert-primary d-flex align-items-center" role="alert">
		  <i class="fas fa-info-circle"> </i>
		  <div>
		    &nbsp; El cliente no posee depósitos.
		  </div>
		</div>';

		$data = array('estado' => 'ok'
		,'tabla' => $msg
		,'saldo' => '0');
		exit(json_encode($data));
	}
}

function enviarMsg($estado, $msg){
	$data = array('estado' => $estado
	,'msg' => $msg);
	exit(json_encode($data));
}
?>