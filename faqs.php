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
<link rel="stylesheet" href="faqs.css" type="text/css" />

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
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/encabezadoFaqs/encabezadoFaqs.gif" alt="" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
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
    <td>
    	<?php
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
	
	<table width="418" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq1">&iquest;Por qu&eacute; enviar facturas?</a></div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq2">&iquest;Cuantas facturas he de enviar?</a> </div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq3">&iquest;Por qu&eacute; darme de alta?</a> </div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq4">¿Como puedo enviar facturas? </a></div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq5">¿Como puedo enviar facturas MOVISTAR?</a></div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq6">¿Como puedo enviar facturas VODAFONE?</a></div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="10" height="20">&nbsp;</td>
    <td width="398" height="20"><div align="center"><a href="#faq7">¿Como puedo enviar facturas ORANGE?</a></div></td>
    <td width="10" height="20">&nbsp;</td>
  </tr>
</table>
<div id="textoContenido">


<a name="faq1" id="faq1">
<strong>¿Por qué enviar facturas?</strong></a><br />
<br />
La única manera fiable de escoger un contrato u otro es haciendo cálculos de lo que te hubieran costado todas tus llamadas con esos contratos. Algunas páginas web ofrecen servicios de esta índole basándose en preguntas al usuario del estilo: a que hora llamas? a que teléfonos... Las respuestas genéricas y aproximadas a estas preguntas no son garantía de escoger el mejor contrato para tus necesidades. La única forma es hacer un cálculo exhaustivo de todas la llamadas.
<br /><br />
<strong>Ahorramovi</strong>l es una aplicación web que ofrece todo su potencial de cálculo para simular el coste de todas tus llamadas con todos los contratos del mercado. Por eso necesitamos tus facturas.
<br />
<br />
Las facturas que envies seran, una vez tratadas para hacer los cálculos, eliminadas. Puedes ver nuestra política de privacidad <a href="privacidad.php">AQUI</a><br />
<br /><br /><br />

<a name="faq2" id="faq2">
<strong>¿Cuantas facturas he de enviar?</strong></a><br />
<br />

Para tener una total fiabilidad en la elección, se debe disponer de una muestra aceptable de llamadas. Solo de esta forma se dispondrá de una buena aproximación a tus hábitos de consumo reales. 
<br /><br />
El mínimo aconsejable son 2 facturas, y con 4 facturas la muestra es mas que suficiente.
<br /><br />
Para enviar mas de una factura será necesario que te des de <a href="alta.php">ALTA</a> en la aplicación. Además si te das de alta podrás visualizar tus informes y gestionar el envio o la eliminación de tus facturas. 
<br />
<br /><br /><br />

<a name="faq3" id="faq3">
<strong>¿Por que darme de alta?</strong></a>
<br />
<br />
Ahorramovil ofrece la posibilidad de enviar una factura y obtener el correspondiente informe. Pero si quieres enviar mas facturas, deberás darte de alta y accederás así a tu zona de usuario, desde donde podrás enviar mas facturas, visualizar tus informes, o eliminar facturas que ya hayas enviado. 
<br />
<br />
Puedes darte de alta en cualquier momento. Incluso si te das de alta una vez enviada la primera factura, te será guardada la información en tu nueva cuenta de usuario. 
<br />
<br />
Pudes darte de alta pulsando <a href="alta.php" target="_self">AQUI</a>.
<br />
<br /><br /><br />

<a name="faq4" id="faq4">
<strong>¿Como puedo enviar facturas?</strong></a>
<br />
<br />
Ahorramovil ofrece una manera muy sencilla para que envies tus facturas. Solo debes descargar de la página web de tu operador todas las facturas que desees en formato PDF. 
<br />
<br />
Una vez descargadas en tu PC, debes enviarnoslas mediante el enlace que encontrarás en la página de incio, o en tu zona de usuario si ya estás dado de alta o haciendo click <a href="enviarFactura.php">AQUI</a>. 
<br />
<br />
<br />
<br />
<a name="faq5" id="faq5">
<strong>¿Como puedo enviar facturas MOVISTAR?</strong></a>
<br />
<br />
Para enviar facturas Movistar debes acceder al canal cliente de Movistar y una vez allí darte de alta en el caso que aun no lo estés. Después debes descargar las facturas que desees en formato PDF. 
<br />
<br />
Una vez introducidos el NIF/CIF/Pasaporte/T.residente y la contraseña según te hayas dado de alta podrás acceder a la zona de Tus facturas desde donde podrás descargar tus facturas en formato PDF. 
<br />
<br />
<strong>Muy importante:</strong> las facturas de Movistar estan compuestas por 2 ficheros: uno de resumen y otro de detalles.<strong> Debes enviar el fichero de detalles</strong> o en caso contrario Ahorramovil no podrá hacer los cálculos.
<br />
<br />
Puedes acceder al canal cliente de Movistar haciendo click<a href="https://www.canalcliente.movistar.es/"> AQUI</a><br />
<br />
<br />
<br />

<a name="faq6" id="faq6">
<strong>¿Como puedo enviar facturas VODAFONE?</strong></a>
<br />
<br />
Para enviar facturas Vodafone debes acceder a Mi Vodafone y una vez allí darte de alta en el caso que aun no lo estás. Después debes descargar las facturas que desees en formato PDF. 
<br />
<br />
Una vez introducidos el número de teléfono y la contraseña según te hayas dado de alta , podrás acceder a la zona de Mi consumo y posteriormente a la zona de factura electrónica, desde donde podrás descargar las 3 últimas facturas en formato PDF. 
<br />
<br />
Puedes acceder a Mi Vodafone haciendo clik <a href="https://mivodafone.vodafone.es/Mivf/VIndexServicios.jsp">AQUI</a><br />
<br />
<br />
<br />

<a name="faq7" id="faq7">
<strong>¿Como puedo enviar facturas ORANGE?</strong></a>
<br />
<br />
Para enviar facturas Orange debes acceder al servicio Factura on-line de Orange y una vez allí darte de alta en el caso que aun no lo estás. Después debes descargar las facturas que desees en formato de texto, en concreto la opción de detalles de llamada en formato extendido.
<br />
<br />
Puedes acceder a Factura on-line haciendo clik<a href="http://movil.orange.es/servicio_al_cliente/contrato/factura_on_line/index.html"> AQUI
</a><br />
<br />
<br />
<br />




</div>

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
