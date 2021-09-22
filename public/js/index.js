// INICIO DEL DOCUMENT READY
$(document).ready(function() {

	// INICIO INICIAR SESION
	$("#btnIniciarSesion").click(function () {
		var usuario = $('#usuario').val().trim();
		var contrasena = $('#contrasena').val().trim();
		if(usuario == ''){ alertify.error('Debe de ingresar el usuario'); $("#usuario").focus();} else
		if(contrasena == ''){ alertify.error('Debe de ingresar la contraseña'); $("#contrasena").focus();} else
		{
			$("#btnIniciarSesion").hide();
	    	$("#btnIniciarSesionGif").show();
	    	var datos = $("#frmIniciarSesion").serialize();
			$.ajax({
				url: '../private/consultas/login.php',  
				type: 'POST',
				data:  datos,
				cache: false,
				dataType:'json',
				success: function(data){
					if (data.estado == 'ok') {
						window.location.replace("main.php");
					} else {
						alertify.error(data.msg);
					}
					$("#btnIniciarSesion").show();
	    			$("#btnIniciarSesionGif").hide();
				},
			    error: function() {
			        alert('¡Hubo algún error al realizar la llamada AJAX!');
			        $("#btnIniciarSesion").show();
	    			$("#btnIniciarSesionGif").hide();
			    }
			});
		}
		
	});
	// FIN INICIAR SESION

});
// FIN DEL DOCUMENT READY