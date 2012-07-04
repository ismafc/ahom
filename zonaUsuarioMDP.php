<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UFT-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<link rel="stylesheet" href="zonaUsuarioMDP.css" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
<script type="text/JavaScript">
function isAValidEmail(inputValue) {
	var foundAt = false;
	var foundDot = false;
	var atPosition = -1;
	var dotPosition = -1;
	// Step through each character of the e-mail
	// address and set a flag when (and if) an
	// @ sign and a dot are detected.
	for (var i = 0; i <= inputValue.length; i++) {
		if (inputValue.charAt(i) == '@' ) {
			foundAt = true;
			atPosition = i;
		}
		else if (inputValue.charAt(i) == '.') {
			foundDot = true;
			dotPosition = i;
		}
	}
	
	// If both an @ symbol and a dot were found, and
	// in the correct order (@ must come first)...
	if ((foundAt && foundDot) && (atPosition < dotPosition)) // It's a valid e-mail address.		
		return true;
	else // The e-mail address is invalid.		
		return false;
}

function validateAndSubmit() {
	if (document.FormularioAlta.Usuario.value == "") {
		alert("Introduce un nombre de Usuario (Nick)... el campo está vacío");
		document.FormularioAlta.Usuario.focus();
		return false;
	}
	if (document.FormularioAlta.Usuario.value.length < 4) {
		alert("El nombre de Usuario (Nick) debe tener almenos cuatro carácteres");
		document.FormularioAlta.Usuario.focus();
		return false;
	}
	if (document.FormularioAlta.Password.value == "") {
		alert("Introduce una contraseña... el campo está vacío");
		document.FormularioAlta.Password.focus();
		return false;
	}
	if (document.FormularioAlta.Password.value.length < 4) {
		alert("La contraseña debe tener almenos cuatro carácteres");
		document.FormularioAlta.Password.focus();
		return false;
	}
	if (document.FormularioAlta.Password.value != document.FormularioAlta.Password1.value) {
		alert("Las dos contraseñas no coinciden... Por favor, vuelve a escribirlas");
		document.FormularioAlta.Password.value = "";
		document.FormularioAlta.Password1.value = "";
		document.FormularioAlta.Password.focus();
		return false;
	}
	if (document.FormularioAlta.Nombre.value == "") {
		alert("Introduce tu nombre... el campo está vacío");
		document.FormularioAlta.Nombre.focus();
		return false;
	}
	if (document.FormularioAlta.Mail.value == "") {
		alert("Introduce tu correo electrónico... el campo está vacío");
		document.FormularioAlta.Mail.focus();
		return false;
	}
	if (!isAValidEmail(document.FormularioAlta.Mail.value)) {
		alert("La dirección de correo parece incorrecta... Por favor, vuelve a escribirla");
		document.FormularioAlta.Mail.focus();
		return false;
	}
	//document.FormularioAlta.submit();
	return true;
}
</script>
<?php
	include("./Lib/main.inc");
	include("./Lib/base.inc");
	include("./Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	
	$idMiembro = "";
	unset($nombreUsuario);
	unset($loginUsuario);
	unset($passwordUsuario);
	unset($correoUsuario);
	if (!esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
		$nombreUsuario = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
		$loginUsuario = obtenerLoginUsuario($_SESSION['miembro'], $_SESSION['password']);
		$passwordUsuario = obtenerPasswordUsuario($_SESSION['miembro'], $_SESSION['password']);
		$correoUsuario = obtenerCorreoUsuario($_SESSION['miembro'], $_SESSION['password']);
		$idMiembro = $_SESSION['miembro'];
	}

	$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = (SELECT id FROM miembros WHERE Login = '$idMiembro') GROUP BY numero_movil_llamante";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numeros_moviles_llamantes = array();
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$numeros_moviles_llamantes[$i] = $row_array[0];
	}
	$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = (SELECT id FROM miembros WHERE Login = '$idMiembro')";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numeroFacturas = mysql_num_rows($result);
?>
</head>
<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/EncabezadoUsuario/encabezadoUsuario.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
	  </tr>
      </table>
  </div>
	
	<div id="encabezado2">
	
  </div>
	 
  

  <div id="login">
<table width="152" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="10" height="10"></td>
    <td width="24" height="10"></td>
    <td width="5" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10" height="30"></td>
    <td height="30" colspan="3" valign="middle">
      <div align="center" class="Estilo4">
        <?php
		if (count($numeros_moviles_llamantes) == 0)
			echo "No tienes ningún teléfono analizado";
		else if (count($numeros_moviles_llamantes) == 1)
			echo "Tienes 1 teléfono analizado";
		else
			echo "Tienes " . count($numeros_moviles_llamantes) . " teléfonos analizados";
		?>    
      </div>    </td>
    <td width="10" height="30"></td>
  </tr>
  <tr>
    <td width="10" height="10"></td>
    <td width="24" height="10"></td>
    <td width="5" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10" height="30"></td>
    <td height="30" colspan="3" valign="middle">
      <div align="center" class="Estilo4">
        <?php
		if ($numeroFacturas == 0)
			echo "No tienes facturas";
		else if ($numeroFacturas == 1)
			echo "Tienes 1 factura";
		else
			echo "Tienes " . $numeroFacturas . " facturas";
		?>    
      </div>    </td>
    <td width="10" height="30"></td>
  </tr>
  <tr>
    <td width="10" height="15"></td>
    <td width="24" height="15"></td>
    <td width="5" height="15"></td>
    <td height="15"></td>
    <td width="10" height="15"></td>
  </tr>
  <tr>
    <td width="10" height="24"></td>
    <td height="24" colspan="3"><a href="logout.php"><img src="imagenesmastreces/navegacioni/logout.gif" alt="" border="0" style="cursor:pointer" /></a></td>
    <td width="10" height="24"></td>
  </tr>
  <tr>
    <td width="10" height="25"></td>
    <td height="25" colspan="3"><div align="center"><a href="logout.php">Salir</a></div></td>
    <td width="10" height="25"></td>
  </tr>  
  <tr>
    <td width="10" height="15"></td>
    <td width="24" height="15"></td>
    <td width="5" height="15"></td>
    <td height="15"></td>
    <td width="10" height="15"></td>
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
<form name="FormularioAlta" id="FormularioAlta" method="post" action="ProcesarActualizarUsuario.php" onsubmit="return validateAndSubmit();">
  <table width="378"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="20" colspan="3"></td>
      </tr>    
    <tr>
      <td colspan="3"><div align="center"><strong>Actualiza los campos que desees</strong></div></td>
      </tr>    
    <tr>
      <td height="20" colspan="3"></td>
      </tr>    
    <tr>
      <td width="288" height="30"><div align="right">Usuario (Nick)</div></td>
      <td width="13"></td>
      <td width="289" height="30">
        <div align="left">
          <label>
          <input type="text" name="Usuario" maxlength="31" value="<?php echo $loginUsuario; ?>"/>
          </label>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right">Contrase&ntilde;a</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left">
          <input type="password" name="Password" maxlength="15" value="<?php echo $passwordUsuario; ?>"/>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right">Repite la Contrase&ntilde;a</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left">
          <input type="password" name="Password1" maxlength="15" value="<?php echo $passwordUsuario; ?>"/>
        </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right">Nombre</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left">
          <input type="text" name="Nombre" maxlength="31" value="<?php echo $nombreUsuario; ?>"/>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right">Correo electrónico</div></td>
      <td></td>
      <td height="30"><div align="left">
        <input type="text" name="Mail" maxlength="63" value="<?php echo $correoUsuario; ?>"/>
      </div></td>
    </tr>
    <tr>
      <td width="288" height="20"></td>
      <td width="13" height="20"></td>
      <td width="289" height="20"></td>
    </tr>    
    <tr>
      <td height="22" colspan="3">
        
          <div align="center">
            <input name="Submit2" id="Submit2" type="submit" value="" />
          </div></td>
      </tr>
    <tr>
      <td width="288" height="30"></td>
      <td width="13" height="30"></td>
      <td width="289" height="30"></td>
    </tr>    
    <tr>
      <td height="20" colspan="3"><div align="center"><a href="zonaUsuario.php">Volver a la zona de Usuario</a></div></td>
    </tr>
  </table>
</form>
  <table width="378"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td></td>
    </tr>        
  </table>
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
