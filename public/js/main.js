// INICIO DEL DOCUMENT READY
$(document).ready(function() {

	// INICIO FORMATOS INPUT
	$('.money').mask('00,000.00', {reverse: true});
	// FIN FORMATOS INPUT

	// INICIO FORMATO DE NUMERO DE DOCUMENTO DE INDENTIDAD
	$("#sTipoDocuIdentidad").change(function () {
		$("#sTipoDocuIdentidad option:selected").each(function () {
			sTipoDocuIdentidad = $(this).val();
			var datos = { 'id' : sTipoDocuIdentidad};

			$.ajax({
				url: '../private/consultas/numDigitosTipoDocuIdentidad.php',  
				type: 'POST',
				data:  datos,
				cache: false,
				dataType:'json',
				success: function(data){
					if (data.estado == 'ok') {
						var numDigitos = data.numDigitos
						var posee_numeros = data.posee_numeros
						var posee_letras = data.posee_letras
						var claseFormat = '.maskNumeDocuIdentidad'
						asignarFormatoInput(numDigitos, posee_numeros, posee_letras, claseFormat);
						$('#nNumDigitos').val(numDigitos);
					} else {
						$("#nNumDocuIdentidad").focus();
					}
				},
			    error: function() {
			        alert('¡Hubo algún error al realizar la llamada AJAX!');
			    }
			});

		});
	});
	// FIN FORMATO DE NUMERO DE DOCUMENTO DE INDENTIDAD


	// INICIO SELECT TIPO DEPOSITO CHANGE
	$("#id_tipo_deposito").change(function () {
		$("#id_tipo_deposito option:selected").each(function () {
			id_tipo_deposito = $(this).val();
			if (id_tipo_deposito == 1) {
				$("#divBancos").show();
				$("#id_banco").focus();
			} else if (id_tipo_deposito == 2) {
				$("#divBancos").hide();
				$("#nMontoAdepositar").focus();
			}
		});
	});
	// FIN SELECT TIPO DEPOSITO CHANGE


	// INICIO SELECT TIPO BANCO CHANGE
	$("#id_banco").change(function () {
		$("#nMontoAdepositar").focus();
	});
	// FIN SELECT TIPO BANCO CHANGE


	// INICIO ASIGNAR FORMATO A INPUT
	$("#sTipoDocuIdentidad").change();
	// FIN ASIGNAR FORMATO A INPUT


	// INICIO CONSULTAR CLIENTE
	$("#btnConsultar").click(function () {
		var id_cliente_tmp = 0;
		var nNumDocuIdentidad = $.trim($('#nNumDocuIdentidad').val());
		var nNumDigitos = $.trim($('#nNumDigitos').val());
		if(nNumDocuIdentidad == ''){ alertify.error('Debe de ingresar el número de documento'); $("#nNumDocuIdentidad").focus();} else
		if(nNumDigitos != nNumDocuIdentidad.length ){ alertify.error('El número de digitos del documento debe de ser ' + nNumDigitos + ', no ' + nNumDocuIdentidad.length + '.'); $("#nNumDocuIdentidad").focus();} else
		{
			$("#btnConsutar").hide();
	    	$("#btnConsutarGif").show();
	    	var datos = $("#frmConsultar").serialize();
			$.ajax({
				url: '../private/consultas/buscarCliente.php',  
				type: 'POST',
				data:  datos,
				cache: false,
				dataType:'json',
				success: function(data){
					if (data.estado == 'ok') {
						id_cliente_tmp = data.id_cliente;
						$('#id_cliente').val(data.id_cliente);
						$('#id_tipo_docu_ident').val(data.id_tipo_docu_ident);
						$('#num_docu_ident').val(data.num_docu_ident);
						$('#primer_apellido').val(data.primer_apellido);
						$('#primer_apellido').val(data.primer_apellido);
						$('#segundo_apellido').val(data.segundo_apellido);
						$('#nombres').val(data.nombres);
						$('#email').val(data.email);
						$('#telefono').val(data.telefono);
						$('#frmDatosCliente select').attr('readonly', 'readonly');
						$('#frmDatosCliente input').attr('readonly', 'readonly');
						buscarDepositosCliente(id_cliente_tmp,'no');						
						$("#rowVentanaDesposito").show();
						$("#nNumDocuIdentidad").val('');
					} else {
						id_cliente_tmp = 0;
						$('#id_cliente').val(data.id_cliente);
						alertify.error(data.msg);
						$("#rowVentanaDesposito").hide();
					}
					$("#btnConsutar").show();
	    			$("#btnConsutarGif").hide();
				},
			    error: function() {
			    	$('#id_cliente').val(data.id_cliente);
			    	id_cliente_tmp = 0;
			        alert('¡Hubo algún error al realizar la llamada AJAX!');
			        $("#btnConsutar").show();
	    			$("#btnConsutarGif").hide();
			    }
			});
		}
		
	});
	// FIN CONSULTAR CLIENTE


	// INICIO GUARDAR DEPOSITO
	$("#btnGuardarDeposito").click(function () {
		var id_tipo_deposito = $.trim($('#id_tipo_deposito').val());
		var id_banco = $.trim($('#id_banco').val());
		var nMontoAdepositar = $.trim($('#nMontoAdepositar').val());
		if(id_tipo_deposito == ''){ alertify.error('Debe de seleccionar el tipo de deposito'); $("#id_tipo_deposito").focus();} else
		if(id_tipo_deposito == '1' & id_banco == '' ){ alertify.error('Debe de seleccionar el banco donde realizo el deposito'); $("#id_banco").focus();} else
		if(nMontoAdepositar == ''){ alertify.error('Debe de ingresar el monto a depositar'); $("#nMontoAdepositar").focus();} else
		{
			alertify.confirm("¿Esta seguro de guardar el depósito?", 'Clic en "OK" si desea guardar el depósito.', function(){ 
				$("#btnGuardarDeposito").hide();
		    	$("#btnGuardarDepositoGif").show();
		    	id_cliente = $('#id_cliente').val();
		    	var datos = $("#frmAgregarDeposito").serialize() + '&id_cliente=' + id_cliente;
				$.ajax({
					url: '../private/consultas/guardarDeposito.php',  
					type: 'POST',
					data:  datos,
					cache: false,
					dataType:'json',
					success: function(data){
						if (data.estado == 'ok') {
							alertify.success(data.msg);
							$("#btnCancelarDeposito").click();
							buscarDepositosCliente(id_cliente,'no');
						} else {
							alertify.error(data.msg);
						}
						$("#btnGuardarDeposito").show();
		    			$("#btnGuardarDepositoGif").hide();
					},
				    error: function() {
				        alert('¡Hubo algún error al realizar la llamada AJAX!');
				        $("#btnGuardarDeposito").show();
		    			$("#btnGuardarDepositoGif").hide();
				    }
				});
			},
		    function(){
		        alertify.error('No se guardo ningun depósito');
		    });
		}
		
	});
	// FIN GUARDAR DEPOSITO


	// INICIO CANCELAR DEPOSITO
	$("#btnCancelarDeposito").click(function () {
		$('#modalAgregarDeposito').modal('hide');
		$('#divBancos').hide();
		$("#frmAgregarDeposito")[0].reset()	
	});
	// FIN GUARDAR DEPOSITO


	// INICIO VER MODAL AGREGAR DEPOSITO
	$("#btnModalAgregarDeposito").click(function () { 
		$("#frmAgregarDeposito")[0].reset()	
		$('#divBancos').hide();
		$('#modalAgregarDeposito').modal('show');		
		var id_cliente = $("#id_cliente").val();
    	var datos = { 'id_cliente' : id_cliente};
		$.ajax({
			url: '../private/consultas/nombreCliente.php',  
			type: 'POST',
			data:  datos,
			cache: false,
			dataType:'json',
			success: function(data){
				if (data.estado == 'ok') {
					$("#nombre_cliente").val(data.nombre);
				} else {
					alertify.error(data.msg);
				}
			},
		    error: function() {
		        alert('¡Hubo algún error al realizar la llamada AJAX!');
		    }
		});
		$('#id_tipo_deposito').focus();
	});
	// FIN VER MODAL AGREGAR DEPOSITO


	// INICIO ACTUALIZAR TABLA DE DEPOSITOS
	$("#btnActualizarTablaDeposito").click(function () { 
		id_cliente = $('#id_cliente').val();
		buscarDepositosCliente(id_cliente,'si');
	});
	// FIN ACTUALIZAR TABLA DE DEPOSITOS


	// INICIO USABILIDAD
	$("#nNumDocuIdentidad").keyup(function () {
	    var nNumDocuIdentidad = $(this).val().replace(/(['"])/g, "");
	    var nNumDigitos = $('#nNumDigitos').val();
	    if (nNumDocuIdentidad.trim().length >= nNumDigitos) {
			$("#btnConsultar").click();
	    }
	});

	$('#nNumDocuIdentidad').keypress(function(e){
		if(e.which == 13){
			event.preventDefault();
			$("#btnConsultar").click();
		}
	});
	// FIN USABILIDAD

});
// FIN DEL DOCUMENT READY


function asignarFormatoInput(numDigitos, posee_numeros, posee_letras, claseFormat, inputFormat){
var digitos = '';
if (numDigitos > 1 & numDigitos < 50){
	$(claseFormat).val('');

	for (var i = 0; i < numDigitos; i++) {
	   digitos = digitos + '0';
	}

	if (posee_numeros == 1 & posee_letras == 1) {
		$(claseFormat).mask(digitos, {'translation': {0: {pattern: /[A-Za-z0-9]/}}});
	} else if (posee_numeros == 1) {
		$(claseFormat).mask(digitos, {'translation': {0: {pattern: /[0-9]/}}});
	} else if (posee_letras == 1) {
		$(claseFormat).mask(digitos, {'translation': {0: {pattern: /[A-Za-z]/}}});
	}

	$(claseFormat).focus();
}
}


function buscarDepositosCliente(id_cliente, notificar){
	$('#tblDepositos').html('<div class="text-center"><img src="dist/img/loader-icon.gif" alt="Buscando" width="25%"></div>');
	var datos = { 'id_cliente' : id_cliente};
	$.ajax({
		url: '../private/consultas/buscarDepositosCliente.php',  
		type: 'POST',
		data:  datos,
		cache: false,
		dataType:'json',
		success: function(data){
			if (data.estado == 'ok') {
				$('#tblDepositos').html(data.tabla);
				$('#lblSaldo').text('El saldo actual del cliente es: ' + data.saldo);
				if (notificar == 'si') {
					alertify.success('La tabla de depósitos se actualizo correctamente');
				}
			} else {
				alertify.error(data.msg);
			}
		},
	    error: function() {
	        alert('¡Hubo algún error al realizar la llamada AJAX!');
	    }
	});
}