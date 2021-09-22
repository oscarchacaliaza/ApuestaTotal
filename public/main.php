<?php
require_once('../private/initialize.php');
$page_title = 'Apuesta Total - Intranet'; 
include(SHARED_PATH . '/header.php');
include(SHARED_PATH . '/sidebar.php');
include_once(CONEXION_PATH . '/conexion.php');
?>

<main class="page-content">
	<div class="container">
    	<h4>Depósitos</h4>
  		<hr>

	    <div class="row">
			<div class="col-md-12">
				<div class="card card-body">
					<form id="frmConsultar">
						<div class="row g-3">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select class="form-select" id="sTipoDocuIdentidad" name="sTipoDocuIdentidad">
									<?php
									$query = "SELECT * FROM tipo_docu_identidad";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_array($result)) {
									 	echo '<option value="' . $row['id'] . '">' . $row['documento'] . '</option>';
									}
									?>
								</select>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="nNumDocuIdentidad" name="nNumDocuIdentidad" class="form-control maskNumeDocuIdentidad" style="text-transform: uppercase;" placeholder="N° de documento" autocomplete="off" autofocus>
								<input type="hidden" id="nNumDigitos" name="nNumDigitos">
							</div>
							<button type="button" id="btnConsultar" name="btnConsultar" class="btn btn-success col-4"><i class="fas fa-search"></i> Consultar</button>
							<button type="button" id="btnConsutarGif" name="btnConsutarGif" class="btn btn-success col-4" style="display: none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="32px"></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<br>

		<div class="row" id="rowVentanaDesposito" style="display:none">
			<div class="col-md-4">
				<div class="card card-body">
					<form id="frmDatosCliente" class="row g-3">
						<input type="hidden" id="id_cliente" name="id_cliente">
						<div class="col-md-12">
							<label for="id_tipo_docu_ident" class="form-label">Tipo de Documento de Identidad</label>
							<select class="form-select" id="id_tipo_docu_ident">
								<?php
								$query = "SELECT * FROM tipo_docu_identidad";
								$result = mysqli_query($conn, $query);
								while ($row = mysqli_fetch_array($result)) {
								 	echo '<option value="' . $row['id'] . '">' . $row['documento'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-12">
							<label for="num_docu_ident" class="form-label">Número de Documento de Identidad</label>
							<input type="text" class="form-control" id="num_docu_ident">
						</div>
						<div class="col-12">
							<label for="primer_apellido" class="form-label">Primer Apellido</label>
							<input type="text" class="form-control" id="primer_apellido">
						</div>
						<div class="col-md-12">
							<label for="segundo_apellido" class="form-label">Segundo Apellido</label>
							<input type="text" class="form-control" id="segundo_apellido">
						</div>
						<div class="col-md-12">
							<label for="nombres" class="form-label">Nombres</label>
							<input type="text" class="form-control" id="nombres">
						</div>
						<div class="col-md-12">
							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control" id="email">
						</div>
						<div class="col-md-12">
							<label for="telefono" class="form-label">Número telefónico</label>
							<input type="text" class="form-control" id="telefono">
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card card-body">
					<form id="frmTransacciones" class="row g-3">
						<div class="col-md-6">
						    <button type="button" class="btn btn-success" id="btnModalAgregarDeposito" data-bs-toggle="button" autocomplete="off"><i class="fas fa-plus"></i> Agregar Depósito</button>
						</div>
						<div class="col-md-6 d-grid gap-2 d-md-flex justify-content-md-end">
						    <button type="button" class="btn btn-primary" id="btnActualizarTablaDeposito" data-bs-toggle="button" autocomplete="off"><i class="fas fa-sync"></i> Actualizar tabla de depósitos</button>
						</div>
						<div class="table-responsive-sm" id="tblDepositos">
						</div>
						<div class="col-md-12">
						    <label id="lblSaldo" name="lblSaldo" class="form-label" style="font-weight: bold; font-size: 15px;"></label>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>	    
</main>


<div class="modal fade" id="modalAgregarDeposito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar depósito</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="frmAgregarDeposito">
					<div class="mb-3">
						<label for="nombre_cliente" class="col-form-label">Cliente:</label>
						<input type="text" class="form-control" id="nombre_cliente" readonly>
					</div>
					<div class="mb-3">
						<label for="id_tipo_deposito" class="col-form-label">Tipo de depósito:</label>
						<select class="form-select" id="id_tipo_deposito" name="id_tipo_deposito">
							<option value="">Seleccione el tipo de despósito</option>
							<?php
							$query = "SELECT * FROM tipo_deposito WHERE estado = 1";
							$result = mysqli_query($conn, $query);
							while ($row = mysqli_fetch_array($result)) {
							 	echo '<option value="' . $row['id'] . '">' . $row['tipo_deposito'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="mb-3" id="divBancos" style="display:none">
						<label for="id_banco" class="col-form-label">Tipo de banco:</label>
						<select class="form-select" id="id_banco" name="id_banco">
							<option value="">Seleccione el banco</option>
							<?php
							$query = "SELECT * FROM banco WHERE estado = 1";
							$result = mysqli_query($conn, $query);
							while ($row = mysqli_fetch_array($result)) {
							 	echo '<option value="' . $row['id'] . '">' . $row['nombre_banco'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="mb-3">
						<label for="nMontoAdepositar" class="col-form-label">Monto(en soles):</label>
						<input type="text" class="form-control money" id="nMontoAdepositar" name="nMontoAdepositar" autocomplete="off">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="btnCancelarDeposito"><i class="far fa-window-close"></i> Cancelar operación</button>
				<button type="button" class="btn btn-success" id="btnGuardarDeposito"><i class="far fa-save"></i> Guardar depósito</button>
				<button type="button" class="btn btn-success" id="btnGuardarDepositoGif" style="display:none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="24px"> Guardando</button>
			</div>
		</div>
	</div>
</div>


<?php include(SHARED_PATH .'/scripts.php'); ?>
<script type="text/javascript" src="js/main.js"></script>
<?php include(SHARED_PATH .'/footer.php'); ?>
