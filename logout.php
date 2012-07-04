<?php session_start(); session_regenerate_id(); ?>
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
	unset($_SESSION['miembro'], $_SESSION['password']);
	$_SESSION['miembro'] = session_id();
	$_SESSION['password'] = session_id();
	crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
?>
<link rel="stylesheet" href="ahorramovil.css" type="text/css" />

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
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
</head>

<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	  <table border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td height="117" valign="top"><img src="imagenesmastreces/encabezado/home1.gif" width="303" height="117" /><img src="imagenesmastreces/encabezado/bunneranimat.gif" width="475" height="117" /></td>
    </tr>
	<tr>
      <td><img src="imagenesmastreces/encabezado/home3.gif" usemap="#Map" href="queOfrecemos.php"></td>
	  </tr>
	  </table>
                 
			
  </div>
	
	 
  

	<div id="login">

<form action="zonaUsuario.php" method="post" name="LoginForm" id="LoginForm" target="_self" onsubmit="return ValidateLoginForm();">

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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    	<span class="Estilo4">¡Gracias por confiar en Ahorramovil!</span><br/><br/>
    	Date de alta <a href="alta.php">aqu&iacute;</a>.
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
	
	<table width="418" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><img src="imagenesmastreces/contenido/tabla1a.gif" /></td>
  </tr>
  <tr height="10">
    <td width="2"></td>
    <td style="background-color:#F2AE0A;"></td>
	<td width="2"></td>
  </tr>
  <tr>
    <td width="2"></td>
    <td width="414" style="background-color:#F2AE0A;">Bienvenidos a la web de Ahorramovil, la aplicación web <strong>independiente</strong> que te calcula <strong>gratis</strong> el ahorro real en tu factura de telefonía móvil en cuesti&oacute;n de <strong>minutos</strong>!</td>
    <td width="2"></td>
  </tr>
  <tr>
    <td width="2"></td>
    <td height="10" style="background-color:#F2AE0A;"></td>
    <td width="2"></td>
  </tr>
  <tr height="25">
    <td width="2"></td>
    <td valign="bottom" style="background-color:#F2AE0A;" align="right"><a href="queOfrecemos.php">Más información...</a>&nbsp;&nbsp;</td>
	<td width="2"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="imagenesmastreces/contenido/tabla1b.gif" /></td>
  </tr>
  <tr>
    <td colspan="3" height="6"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="imagenesmastreces/contenido/tabla2a.gif" /></td>
  </tr>
  <tr>
    <td width="2"></td>
    <td width="414" style="background-color:#CEE00A">Accede a la web de tu operador, bájate en formato PDF o TXT tu factura y envíanosla mediante nuestro formulario... Así de sencillo, en unos instantes sabrás conseguir el máximo ahorro.</td>
    <td width="2"></td>
  </tr>
  <tr>
    <td width="2"></td>
    <td height="10" style="background-color:#CEE00A;"></td>
    <td width="2"></td>
  </tr>
  <tr height="25">
    <td width="2"></td>
    <td valign="bottom" style="background-color:#CEE00A" align="right"><a href="comoEnviarFactura.php">Sigue los pasos...</a>&nbsp;&nbsp;</td>
	<td width="2"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="imagenesmastreces/contenido/tabla2b.gif" /></td>
  </tr>
  <tr>
    <td colspan="3" height="6"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="imagenesmastreces/contenido/tabla3a.gif" /></td>
  </tr>
  <tr>
    <td width="2"></td>
    <td width="414" style="background-color:#B9C8D3">¿Ya tienes tus facturas en formato PDF o TXT y quieres saber cuanto puedes ahorrarte?</td>
    <td width="2"></td>
  </tr>
  <tr>
    <td width="2"></td>
    <td height="10" style="background-color:#B9C8D3;"></td>
    <td width="2"></td>
  </tr>
  <tr height="25">
    <td width="2"></td>
    <td valign="bottom" style="background-color:#B9C8D3" align="right"><a href="enviarFactura.php">Envía tus facturas!</a>&nbsp;&nbsp;</td>
	<td width="2"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="imagenesmastreces/contenido/tabla3b.gif" /></td>
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
  <area shape="rect" coords="470,12,517,24" href="index.php" alt="" />
<area shape="rect" coords="518,12,621,25" href="quienesSomos.php" alt="" />
<area shape="rect" coords="620,12,692,24" href="queOfrecemos.php" alt="" />
<area shape="rect" coords="692,12,776,25" href="contacto.php" alt="" />
</map>
</body>

</html>
