<?php
require_once('../private/initialize.php');
$page_title = 'Apuesta Total - Login'; 
include(SHARED_PATH . '/header.php');
?>

<link href="<?php echo url_for('/dist/css/signin.css'); ?>" rel="stylesheet">
    
<main class="form-signin">
  <form id="frmIniciarSesion" name="frmIniciarSesion">
    <img class="mb-4" src="<?php echo url_for('/dist/img/logo.png'); ?>" alt="" width="300" height="67">
    <h1 class="h3 mb-3 fw-normal">Gestión de Cuentas</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" autofocus="">
      <label for="usuario">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña">
      <label for="contrasena">Contraseña</label>
    </div>

    <button id="btnIniciarSesion" class="w-100 btn btn-lg btn-primary" type="button"><i class="fas fa-unlock-alt"></i> Iniciar Sesión</button>
    <button id="btnIniciarSesionGif" class="w-100 btn btn-lg btn-primary" type="button"  style="display: none;"><img src="<?php echo url_for('/dist/img/loading.gif'); ?>" width="32px"></button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
  </form>
</main>

<?php include(SHARED_PATH ."/scripts.php"); ?>
<script type="text/javascript" src="js/index.js"></script>
<?php include(SHARED_PATH ."/footer.php"); ?>