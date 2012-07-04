<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<?php
	include("./Lib/main.inc");
	include("./Lib/base.inc");
	include("./Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
	
	$nombreUsuario = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
	$login = $_SESSION['miembro'];
	$password = $_SESSION['password'];
	$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$idMiembro = $row_array[0];
	
	$fechacreacion = date("Y-m-d H:i:s");
	$correo = $_POST["Mail"];
	$tipoConsulta = $_POST["TipoConsulta"];
	$texto = $_POST["Consulta"];
	$sql = "INSERT INTO consultas (idMiembro, correo, tipo, texto, estado, fecha) VALUES ('$idMiembro', '$correo', '$tipoConsulta', '$texto', 'NUEVA', '$fechacreacion')";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
?>
<link rel="stylesheet" href="contacto.css" type="text/css" />

<script type="text/JavaScript">
function ValidateLoginForm() {
	if (document.LoginForm.Usuario.value == "") {
		alert("Introduce un nombre de Usuario (Nick)... el campo está vacío");
		document.LoginForm.Usuario.focus();
		return false;	
	}
	if (document.LoginForm.Usuario.value.length < 4) {
		alert("El nombre de Usuario (Nick) debe tener almenos cuatro carácteres");
		document.LoginForm.Usuario.focus();
		return false;
	}
	if (document.LoginForm.Password.value == "") {
		alert("Introduce una contraseña... el campo está vacío");
		document.LoginForm.Password.focus();
		return false;	
	}
	if (document.LoginForm.Password.value.length < 4) {
		alert("La contraseña debe tener almenos cuatro carácteres");
		document.LoginForm.Password.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/encabezadoPrivacidad/encabezadoPrivacidad.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
	  </tr>
      </table>
  </div>
	
  <div id="encabezado2">
	
  </div>
	 
  

	<div id="login">
      <form action="zonaUsuario.php" method="post" id="LoginForm" target="_self" onsubmit="return ValidateLoginForm();">
        <table width="152" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td height="15" valign="top">Usuario</td>
          </tr>
          <tr>
            <td><input name="Usuario" type="text" id="Usuario" /></td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="15" valign="top">Password</td>
          </tr>
          <tr>
            <td><input name="Password" type="password" id="Password" /></td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td><input name="Entrar" type="submit"  id="Entrar" value="" />
            </td>
          </tr>
          <tr>
            <td height="25"></td>
          </tr>
        </table>
      </form>
	  <table width="152" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><?php
			if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
		?>
            &iquest;No eres usuario? Date de alta <a href="alta.php">aqu&iacute;</a>.
            <?php
			}
			else {
				if (isset($nombreUsuario))
					echo $nombreUsuario . ", ";				
			?>ya puedes ir a tu <a href="zonaUsuario.php">Zona de Usuario</a>
            <?php
			}
		?>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
  <tr>
    <td colspan="5"><p><span>&iexcl;Actualizamos las tarifas constantemente!</span><br/>
Nuevos contratos, nuevos operadores, etc...<br/>
    </p>
      &iexcl;Consulta nuestros <a href="queOfrecemos.php">servicios</a>!<br/><br/>
      &iexcl;Consulta nuestra nueva sección de <a href="noticias.php">noticias</a>!
    </td>
  </tr>
      </table>
  </div>
  <div id="areaTexto">



	<div id="contenido">
  <form name="FormularioAlta" id="FormularioAlta" method="post" action="ProcesarContacto.php" onsubmit="return validateAndSubmit();">
  <table width="378"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="200" height="20"></td>
      <td width="8" height="20"></td>
      <td width="170" height="20"></td>
    </tr>    
    <tr>
      <td colspan="3"><div align="center"><strong>Gracias por ponerte en contacto con nosotros<?php
	  if (isset($nombreUsuario))
	  	echo ", " . $nombreUsuario;
	  ?>
      </strong></div></td>
    </tr>    
    <tr>
      <td width="200" height="20"></td>
      <td width="8" height="20"></td>
      <td width="170" height="20"></td>
    </tr>    
    <tr>
      <td colspan="3"><div align="center"><strong>&iexcl;En breve tendrás noticias nuestras!</strong></div></td>
    </tr>    
    <tr>
      <td width="200" height="20"></td>
      <td width="8" height="20"></td>
      <td width="170" height="20"></td>
    </tr>    
  </table>
</form>

	</div>
	
	
    <div id="div_estadisticas">
         <IFRAME id="iframe_estadisticas" frameborder="0" src="barraDerecha.php">No se soportan iframes!</IFRAME>
    </div>
	
			
</div>

<div id="div_pie">
    <IFRAME id="iframe_pie" frameborder="0" src="pie.php">No se soportan iframes!</IFRAME>
</div>
</div>

<map name="Map" id="Map">
  <area shape="rect" coords="472,127,515,142" href="index.php" alt="" />
<area shape="rect" coords="521,128,618,140" href="quienesSomos.php" alt="" />
<area shape="rect" coords="622,128,690,142" href="queOfrecemos.php" alt="" />
<area shape="rect" coords="694,125,770,142" href="contacto.php" alt="" />
</map></body>

</html>
