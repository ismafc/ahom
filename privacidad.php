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
<link rel="stylesheet" href="privacidad.css" type="text/css" />

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
.Estilo20 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>

<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/encabezadoPrivacidad/encabezadoPrivacidad.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>      </td>
	  </tr>
      </table>
  </div>
	
  <div id="encabezado2">
	
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
          <td><?php
			if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
		?>
            &iquest;No eres usuario? Date de alta <a href="alta.php">aqu&iacute;</a>.
            <?php
			}
			else {
				$nombreusu = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
				if (isset($nombreusu))
					echo $nombreusu . ", ";				
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
	  


      <p>	En cumplimiento de lo establecido en la Ley Organica 15/1999, de 13 de diciembre, de Protecci&oacute;n de Datos de Car&aacute;cter Personal, te informamos que los datos de car&aacute;cter personal que nos facilites con objeto de darte de alta como usuario pasaran a formar parte de nuestra base de datos. As&iacute; mismo te informamos de la posibilidad de ejercer tus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n y oposici&oacute;n de tus datos de car&aacute;cter personal en <a href="mailto:contacto@ahorramovil.com">contacto@ahorramovil.com</a>.  Estos datos no ser&aacute;n cedidos ni vendidos a terceros. </p>
      <p>&nbsp;</p>
      <p> En lo referente a la informaci&oacute;n contenida en las facturas enviadas por el usuario, te informamos que solo se extraer&aacute;n aquellos datos imprescindibles para realizar los c&aacute;lculos, concretamente el<strong> nombre del titular del contrato</strong>, el<strong> n&uacute;mero del tel&eacute;fono asignado al contrato</strong>, el <strong>coste global de la factura</strong>, el <strong>periodo de facturaci&oacute;n</strong>, y los datos relativos a cada llamada, concretamente, el <strong>n&uacute;mero de tel&eacute;fono llamado</strong>, el <strong>tipo de llamada</strong>, la <strong>fecha y hora de realizaci&oacute;n de la llamada</strong>, la <strong>duraci&oacute;n de la llamada</strong> y el <strong>coste de la llamada</strong>. En ning&uacute;n caso se extraen otros datos que pueda contener la factura como el DNI, la direcci&oacute;n del titular, el n&uacute;mero de factura&hellip; y dem&aacute;s informaci&oacute;n de car&aacute;cter personal. </p>
      <p>&nbsp;</p>
      <p>El fichero enviado con los datos de la factura ser&aacute; autom&aacute;ticamente eliminado una vez extra&iacute;da la informaci&oacute;n descrita anteriormente. Estos datos ser&aacute;n totalmente privados y solo ser&aacute;n accesibles por el propio usuario, que podr&aacute; eliminarlos cuando desee. Estos datos no ser&aacute;n cedidos ni vendidos a terceros.</p>
      <p>&nbsp;</p>
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
