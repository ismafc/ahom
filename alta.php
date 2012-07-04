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
	
?>
<link rel="stylesheet" href="alta.css" type="text/css" />
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
	if (document.FormularioAlta.UsuarioAlta.value == "") {
		alert("Introduce un nombre de Usuario (Nick)... el campo está vacío");
		document.FormularioAlta.UsuarioAlta.focus();
		return false;
	}
	if (document.FormularioAlta.UsuarioAlta.value.length < 4) {
		alert("El nombre de Usuario (Nick) debe tener almenos cuatro carácteres");
		document.FormularioAlta.UsuarioAlta.focus();
		return false;
	}
	if (document.FormularioAlta.PasswordAlta.value == "") {
		alert("Introduce una contraseña... el campo está vacío");
		document.FormularioAlta.PasswordAlta.focus();
		return false;
	}
	if (document.FormularioAlta.PasswordAlta.value.length < 4) {
		alert("La contraseña debe tener almenos cuatro carácteres");
		document.FormularioAlta.PasswordAlta.focus();
		return false;
	}
	if (document.FormularioAlta.PasswordAlta.value != document.FormularioAlta.PasswordAlta1.value) {
		alert("Las dos contraseñas no coinciden... Por favor, vuelve a escribirlas");
		document.FormularioAlta.PasswordAlta.value = "";
		document.FormularioAlta.PasswordAlta1.value = "";
		document.FormularioAlta.PasswordAlta.focus();
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
      <td><img src="imagenesmastreces/EncabezadoUsuario/encabezadoUsuario.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
	  </tr>
      </table>
	</div>
	
    <div id="login">
      <form action="zonaUsuario.php" method="post" target="_self" name="LoginForm" id="LoginForm" onsubmit="return ValidateLoginForm()">
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
          <td height="10"></td>
        </tr>
        <tr>
          <td><div align="left"><strong>Al darte de alta podr&aacute;s:</strong></div></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;Enviar varias facturas...</div></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;De varios tel&eacute;fonos...</div></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;Ver tus informes...</div></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;...</div></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
  <tr>
    <td><p><span>&iexcl;Actualizamos las tarifas constantemente!</span><br/>
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
<?php
if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
?>
  <form name="FormularioAlta" id="FormularioAlta" method="post" action="ProcesarAlta.php" onsubmit="return validateAndSubmit();">
  <table width="378"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="288" height="20"></td>
      <td width="13" height="20"></td>
      <td width="289" height="20"></td>
    </tr>    
    <tr>
      <td colspan="3"><div align="center"><strong>Rellena los siguientes campos... y empieza a ahorrar!</strong></div></td>
      </tr>    
    <tr>
      <td width="288" height="30"></td>
      <td width="13" height="30"></td>
      <td width="289" height="30"></td>
    </tr>    
    <tr>
      <td width="288" height="30"><div align="right" class="Estilo2">Usuario (Nick)</div></td>
      <td width="13">&nbsp;</td>
      <td width="289" height="30">
        <div align="left" class="Estilo2">
          <label>
          <input type="text" name="UsuarioAlta" maxlength="31"/>
          </label>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right" class="Estilo2">Contrase&ntilde;a</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left" class="Estilo2">
          <input type="password" name="PasswordAlta" maxlength="15"/>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right" class="Estilo2">Repite la Contrase&ntilde;a</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left" class="Estilo2">
          <input type="password" name="PasswordAlta1" maxlength="15"/>
        </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right" class="Estilo2">Nombre</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left" class="Estilo2">
          <input type="text" name="Nombre" maxlength="31"/>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right" class="Estilo2">Correo electrónico</div></td>
      <td>&nbsp;</td>
      <td height="30"><div align="left" class="Estilo2">
        <input type="text" name="Mail" maxlength="63"/>
      </div></td>
    </tr>
    <tr>
      <td height="30"><div align="right" class="Estilo2">
        <input type="reset" name="Submit" id="Submit" value="" />
      </div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left" class="Estilo2">
          <input name="Submit2" id="Submit2" type="submit" value="" />
      </div></td>
    </tr>
  </table>
</form>
<?php
	}
	else {
?>
<table width="378" height="90" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><div align="center"> Ya est&aacute;s dado de alta en el sistema.</div></td>
  </tr>
  <tr>
    <td height="30"><div align="center"></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center">Puedes ir a tu zona de usuario pulsando <strong><a href="zonaUsuario.php">AQU&Iacute;</a>.</strong></div></td>
  </tr>
</table>
<?php
}
?>
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
