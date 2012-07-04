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
<link rel="stylesheet" href="queOfrecemos.css" type="text/css" />

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
      &iexcl;Consulta nuestra nueva sección de <a href="noticias.php">noticias</a>!
    </td>
  </tr>
</table>




	

 

</div>



<div id="areaTexto">



	<div id="contenido">
	
<div id="textoContenido">
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;En <strong>Ahorramovil</strong> ofrecemos a través de nuestra página web una serie de servicios generales orientados a conseguir el <strong>máximo ahorro</strong> en telefonía móvil. Estos servicios se caracterizan por una enorme sencillez de uso y una gran potencia, flexibilidad y utilidad.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><h4><strong><a href="#T1">1. Optimizaci&oacute;n costes telefon&iacute;a m&oacute;vil</a></strong></h4></td>
          	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><a href="#T11">&nbsp;&nbsp;&nbsp;1.1. Particulares</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T12">&nbsp;&nbsp;&nbsp;1.2. Aut&oacute;nomos</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T13">&nbsp;&nbsp;&nbsp;1.3. Empresas</a></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><h4><strong><a href="#T2">2. Aplicaciones web para empresas y webmasters</a></strong></h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><a href="#T21">&nbsp;&nbsp;&nbsp;2.1. Servicio de c&aacute;lculo para una llamada</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T22">&nbsp;&nbsp;&nbsp;2.2. Servicio de orientaci&oacute;n</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T23">&nbsp;&nbsp;&nbsp;2.3. Servicio de c&aacute;lculo de ahorro</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T24">&nbsp;&nbsp;&nbsp;2.4. Personalización zona de usuario</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T25">&nbsp;&nbsp;&nbsp;2.5. Servios web a medida</a></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><h4><strong><a href="#T3">3. Consultor&iacute;a</a></strong></h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><a href="#T31">&nbsp;&nbsp;&nbsp;3.1. Estudios tarifarios para operadoras</a></td>
            <td width="5">
        </tr>
		<tr>
        	<td><a href="#T32">&nbsp;&nbsp;&nbsp;3.2. Estudios estad&iacute;sticos</a></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td><h4><strong><a href="#T4">4. Publicidad en nuestra web</a></strong></h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><a name="T1" id="T1"></a>&nbsp;&nbsp;&nbsp;<strong>1.</strong> Sin duda, el servicio m&aacute;s universal que ofrecemos en <strong>Ahorramovil</strong> es el que permite a los usuarios, atrav&eacute;s del env&iacute;o de sus facturas electr&oacute;nicas, optimizar su consumo en telefon&iacute;a m&oacute;vil de manera r&aacute;pida y sencilla, obteniendo ahorros de hasta el 50%. Si quieres saber más detalles sobre como en <strong>Ahorramovil</strong> somos capaces de hacer todo esto haz clic <a href="#T5">aquí</a>.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T11" id="T11"></a>1.1. Servicio  de c&aacute;lculo del mejor operador, contrato y servicios de ahorro para particulares</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio es gratuito para usuarios particulares con contrato o tarjeta, o para aquellos que  deseen introducir sus llamadas de forma manual. Este servicio permite analizar  hasta cuatro meses de consumo por l&iacute;nea. El n&uacute;mero de l&iacute;neas es ilimitado. En este  servicio se incluye la gesti&oacute;n de las facturas y la generaci&oacute;n de los informes  detallados para cada l&iacute;nea.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><div align="right"><em>El coste de este servicio es de 0 &euro;</em></div></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4>Servicio de agrupaci&oacute;n de l&iacute;neas</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio puede contratarse como complemento. Consiste en poder agrupar l&iacute;neas  para forzar a que el sistema recomiende el mismo operador, contrato y servicios  de ahorro para todas ellas.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><div align="right"><em>El coste de este servicio es de 5 &euro;</em></div></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T12" id="T12"></a>1.2. Servicio  de c&aacute;lculo del mejor operador, contrato y servicios de ahorro para aut&oacute;nomos</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio es  gratuito para usuarios aut&oacute;nomos con contrato y hasta cinco l&iacute;neas. Este  servicio permite analizar hasta cuatro meses de consumo por l&iacute;nea. Este  servicio incluye la gesti&oacute;n de las facturas y la generaci&oacute;n de informes  detallados para cada l&iacute;nea.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><div align="right"><em>El coste de este servicio es de 0 &euro; *</em></div></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4>Servicio de agrupaci&oacute;n de l&iacute;neas</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio puede contratarse como complemento. Consiste en poder agrupar l&iacute;neas  para forzar a que el sistema recomiende el mismo operador, contrato y servicios  de ahorro para todas ellas.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><div align="right"><em>El coste de este servicio es de 5 &euro;</em></div></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr><td><h5>*Este  servicio est&aacute; limitado a 5 l&iacute;neas. Para m&aacute;s l&iacute;neas ver servicios para empresas</h5></td>
		<td width="5"></tr>        
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T13" id="T13"></a>1.3. Servicio  de c&aacute;lculo del mejor operador, contrato y servicios de ahorro para empresas</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio permite  gestionar un n&uacute;mero ilimitado de l&iacute;neas, as&iacute; como un n&uacute;mero ilimitado de meses  de consumo por l&iacute;nea. Este servicio incluye la gesti&oacute;n de las facturas, la  generaci&oacute;n de informes detallados por l&iacute;nea y el servicio de agrupaci&oacute;n de l&iacute;neas.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><em>Este servicio tiene un coste de 1 &euro; por factura enviada, el cobro se realizar&aacute;  cada mes computando las facturas que han sido enviadas durante el mes en curso.</em></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4>Servicio de consultor&iacute;a  en telefon&iacute;a m&oacute;vil para empresas</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio consiste  en la presentaci&oacute;n de un informe completo, exhaustivo y detallado de los  consumos en telefon&iacute;a m&oacute;vil del cliente y la recomendaci&oacute;n del plan de ahorro  que m&aacute;s se adapte a sus necesidades. El cliente &uacute;nicamente debe facilitar el  acceso a las facturas electr&oacute;nicas de sus l&iacute;neas de telefon&iacute;a m&oacute;vil y en Ahorramovil nos encargamos del  resto.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><em>El  coste de este servicio es el equivalente al ahorro obtenido durante el primer  mes de uso del plan de ahorro proporcionado respecto al mes anterior al uso del  mismo.</em></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><a name="T2" id="T2"></a>&nbsp;&nbsp;&nbsp;<strong>2.</strong> En <strong>Ahorramovil</strong> ofrecemos la posibilidad  de integrar su potente motor de c&aacute;lculo en cualquier p&aacute;gina web. Si deseas  ofrecer a tus clientes o usuarios un servicio potente, sencillo de utilizar,  &uacute;til y de calidad, en <strong>Ahorramovil</strong> te lo ponemos f&aacute;cil.  Conseguir&aacute;s fidelizar a tus usuarios o  clientes y ofrecerles herramientas para que ahorren dinero.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T21" id="T21"></a>2.1. Servicio de c&aacute;lculo para  una llamada</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio consiste  en que el usuario puede consultar para una llamada dada cual es el operador,  contrato y servicio de ahorro con el que obtendr&iacute;a m&aacute;s ahorro.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><em>El coste es gratuito  si en la p&aacute;gina web se indica expl&iacute;citamente que el servicio es proporcionado  por Ahorramovil. En caso de que el  servicio quede integrado sin ninguna referencia a Ahorramovil su coste ser&aacute; de 10 &euro; al mes.</em></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T22" id="T22"></a>2.2. Servicio  de orientaci&oacute;n seg&uacute;n h&aacute;bitos de consumo aproximados</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este  servicio consiste en que el usuario puede introducir sus h&aacute;bitos de consumo y  consultar que operador, contrato y servicios de ahorro son los que m&aacute;s se  adaptan a los mismos.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><em>Este  servicio tiene un coste de 10 &euro; al mes si se indica expl&iacute;citamente que el servicio es proporcionado por Ahorramovil. En caso de que el  servicio quede integrado sin ninguna referencia a Ahorramovil su coste ser&iacute;a de 30  &euro; al mes.</em></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T23" id="T23"></a>2.3. Servicio de c&aacute;lculo de  ahorro</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Este servicio consiste en ofrecer la posibilidad al usuario o cliente de enviar una factura para que nuestro potente motor de c&aacute;lculo encuentre cual es el mejor operador, contrato  y servicios de ahorro. Si quieres saber más detalles sobre como en <strong>Ahorramovil</strong> somos capaces de hacer todo esto haz clic <a href="#T5">aquí</a>.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><em>Este  servicio tiene un coste de 50 &euro; al mes si se indica expl&iacute;citamente que el  servicio es proporcionado por Ahorramovil. En caso de que el  servicio quede integrado sin ninguna referencia a Ahorramovil su coste ser&iacute;a de 200  &euro; al mes.</em></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T24" id="T24"></a>2.4. Servicios a medida en tu zona de usuario</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;En <strong>Ahorramovil</strong> ponemos a tu disposici&oacute;n la posibilidad de que personalices y potencies tu zona de usuario  con aquellas caracter&iacute;sticas que consideres de utilidad. Te ofrecemos la  posibilidad de que nos plantees aquellas caracter&iacute;sticas que desear&iacute;as que  tuviese tu zona de usuario y, gratuitamente, la evaluaremos y estudiaremos su viabilidad y coste. Si lo que nos propones es &uacute;til para todos los usuarios lo implementaremos gratis y a&ntilde;adiremos en nuestra web un reconocimiento expl&iacute;cito a tu aportaci&oacute;n.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T25" id="T25"></a>2.5. Servicios  web a medida</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;En <strong>Ahorramovil</strong>, en nuestro af&aacute;n por ofrecer el mayor abanico de posibilidades y la mayor flexibilidad a nuestros  clientes, ofrecemos un servicio gratuito de estudio de aplicaciones a medida. As&iacute;, si necesitas alg&uacute;n servicio relacionado con el c&aacute;lculo de tarifas y crees  que podemos ayudarte, no dudes en ponerte en contacto con nosotros y  plantearnos el reto. Gratuitamente analizaremos tu propuesta, la viabilidad de la misma y, eventualmente, el coste y nos pondremos en contacto contigo para, esperamos, llevarla a cabo.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><a name="T3" id="T3"></a>&nbsp;&nbsp;&nbsp;<strong>3. </strong>En <strong>Ahorramovil</strong>, aprovechando nuestro  potente motor de c&aacute;lculo, nuestro volumen de visitas mensuales (alrededor de  <strong>15000</strong>), as&iacute; como nuestra base de datos con m&aacute;s de <strong>280000</strong> llamadas analizadas,  ofrecemos una serie de servicios de alto valor a&ntilde;adido para sectores especializados  como medios de comunicaci&oacute;n, operadoras m&oacute;viles virtuales, operadoras  convencionales, empresas del sector, etc.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T31" id="T31"></a>3.1. Estudios  tarifarios</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Con el punto de mira  puesto en los operadores m&oacute;viles, ya sean virtuales o con infraestructura  propia, en Ahorramovil ofrecemos la  posibilidad de realizar estudios tarifarios sobre posibles futuras tarifas.  Nuestra base de datos, en la que contamos con miles de facturas,&nbsp; y apoy&aacute;ndonos&nbsp;  en nuestro motor de c&aacute;lculo, nos permite conocer datos tan interesantes  como el porcentaje de personas que ahorrar&iacute;an dinero con esas nuevas tarifas,  el dinero que ahorrar&iacute;an, etc. Podemos tambi&eacute;n realizar simulaciones sobre  peque&ntilde;as variaciones tarifarias para ajustar las mismas con el objetivo de  maximizar los beneficios al tiempo que maximizamos el n&uacute;mero de potenciales  clientes que ahorrar&iacute;an dinero. Incluso podemos proponer tarifas que colocar&iacute;an  la misma entre las m&aacute;s recomendadas por nuestro motor de c&aacute;lculo. El coste de  este servicio depende de la magnitud del estudio a realizar, si est&aacute;s  interesado en este tipo de estudios ponte en contacto con nosotros y de manera  gratuita evaluaremos la viabilidad y el coste de la misma.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T32" id="T32"></a>3.2. Estudios estad&iacute;sticos</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;Pensando en los medios  de comunicaci&oacute;n, portales de telefon&iacute;a generalista, etc. En <strong>Ahorramovil</strong> ofrecemos, gracias a  la informaci&oacute;n de h&aacute;bitos de consumo extra&iacute;da de las miles de facturas  analizadas, la posibilidad de realizar todo tipo de estudios estad&iacute;sticos como  cuales son los tipos de llamadas m&aacute;s usuales, los contratos m&aacute;s recomendados,  las horas con m&aacute;s tr&aacute;fico, y miles de otros par&aacute;metros o combinaciones de los  mismos. Si deseas ofrecer esta informaci&oacute;n a tus clientes o usuarios, o si te  interesa este tipo de informaci&oacute;n por&nbsp;  cualquier motivo comercial, no dudes en propon&eacute;rnoslos y  gratuitamente&nbsp; estudiaremos la viabilidad  y, eventualmente,&nbsp; el coste de tu  propuesta.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><h4><a name="T4" id="T4"></a>4. Publicidad</h4></td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify">&nbsp;&nbsp;&nbsp;En <strong>Ahorramovil</strong> te ofrecemos la  posibilidad de anunciarte en nuestra web. Si est&aacute;s relacionado de alg&uacute;n modo  con la telefon&iacute;a m&oacute;vil, ya seas operador, portal web, distribuidor de  terminales, fabricante, etc. Puedes beneficiarte de las m&aacute;s de <strong>15000 entradas</strong>  mensuales en nuestra web a&ntilde;adiendo tu publicidad en nuestra p&aacute;gina.</td>
            <td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr>
        	<td align="justify"><em>El coste de un banner  en la p&aacute;gina principal es de 100 &euro; al mes. En alguna otra p&aacute;gina tiene un  coste de 50 &euro; al mes. Siempre visible durante la navegaci&oacute;n por la web de <strong>Ahorramovil</strong> tiene un coste de 200 &euro; al mes.</em></td>
        	<td width="5">
        </tr>
		<tr><td>&nbsp;</td><td width="5"></tr>
		<tr height="5px"><td bgcolor="#CC9900"></td><td width="5"></tr>
		<tr><td>&nbsp;</td><td width="5"></tr>	</table>
	<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="justify"><a name="T5" id="T5"></a><strong>Ahorramovil</strong> es la &uacute;nica aplicaci&oacute;n web que calcula el coste de tus facturas segun todas las tarifas de telefon&iacute;a m&oacute;vil del mercado. A diferencia de otras webs que solo calculan el coste de una llamada hipot&eacute;tica, <strong>Ahorramovil calcula el coste de llamadas reales en base a todas las tarifas de todas las operadoras simulando el coste de tus facturas</strong>.<br />
      <br />
      Es la &uacute;nica forma de saber exactamente que contrato o tarjeta se ajusta mas a tus necesidades, puesto que <strong>es un c&aacute;lculo mediante el cual podr&aacute;s ver como habr&iacute;a sido tu factura de haber tenido otro contrato</strong>. Ya no habr&aacute; que responder nunca m&aacute;s a preguntas del tipo: usted llama por la ma&ntilde;ana o por la tarde? llama m&aacute;s a fijos o a m&oacute;viles ? A que n&uacute;meros llama m&aacute;s a menudo? La respuesta gen&eacute;rica y aproximada a estas preguntas en que se basan las operadoras para orientar el cliente no son garant&iacute;a de escoger el mejor contrato para tus necesidades. La &uacute;nica forma es hacer un c&aacute;lculo exhaustivo de todas la llamadas. <br />
          <br />
      <strong>Ahorramovil</strong> ofrece una forma muy sencilla de realizar estos c&aacute;lculos.<strong> Solo debes enviarnos tus facturas (una o mas) en formato PDF </strong>y Ahorramovil calcular&aacute; <strong>autom&aacute;ticamente de forma immediata</strong> el coste de dichas facturas con todos los contratos del mercado. As&iacute; <strong>podr&aacute;s escoger el contrato que te ahorre mas dinero</strong>. <strong>Cuantas m&aacute;s facturas envies, m&aacute;s fiable ser&aacute; la elecci&oacute;n </strong>puesto que se dispone de mas informaci&oacute;n sobre tus h&aacute;bitos reales de consumo.<br />
      <br />
           <strong>Ahorramovil</strong> genera un <a href="informeReal.html" target="_blank">informe</a> con la siguiente informaci&oacute;n: <br />
          <br />
&#8226;&nbsp;Contrato y servicios de ahorro que te hubieran ahorrado mas dinero.<br />
&#8226;&nbsp;Contrato y servicios de ahorro que te hubieran ahorrado mas dinero de tu propio operador (en el caso que el mejor contrato sea de otro operador).<br />
      &#8226;&nbsp;Tel&eacute;fonos a los que tendr&iacute;as que aplicar los servicios de ahorro (para el mejor contrato y el mejor de tu operador si no es el mismo).<br />
&#8226;&nbsp;Dinero que te hubieras ahorrado (para el mejor contrato y el mejor de tu operador si no es el mismo).<br />
&#8226;&nbsp; Lista de tel&eacute;fonos ordenados por consumo.<br />
 &#8226;&nbsp; Tabla con todos los contratos con todos los costes de todas las facturas. <br />
&#8226;&nbsp;Tabla con todos los contratos y mejores servicios de ahorro para cada contrato de todas las facturas.<br />
<br/>
      <strong>Ahorramovil </strong>adem&aacute;s de realizar el c&aacute;lculo propone al usuario los tel&eacute;fonos a los que aplicar los servicios de ahorro buscando el ahorro m&aacute;ximo, lo que le convierte en la &uacute;nica aplicaci&oacute;n del mercado con estas prestaciones.<br/>
      <br/>
      <strong>Deja de ir a ciegas</strong> entre los m&uacute;ltiples contratos y servicios de ahorro que ofrecen las operadoras! <strong>Ahorramovil te indicar&aacute; </strong>de forma objetiva <strong>la opci&oacute;n que te har&aacute; ahorrar mas dinero! </strong>
      
    </div></td>
    <td width="5"></td>
  </tr>
</table>

	
<!--	<table width="418" border="0" cellspacing="0" cellpadding="0">
    <tr height="75">
    <td width="20"></td>
    <td width="378" >&nbsp;</td>
	<td width="20"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td  width="378" ><div align="justify"><strong>Ahorramovil</strong> es la &uacute;nica aplicaci&oacute;n web que calcula el coste de tus facturas segun todas las tarifas de telefon&iacute;a m&oacute;vil del mercado. A diferencia de otras webs que solo calculan el coste de una llamada hipot&eacute;tica, <strong>Ahorramovil calcula el coste de llamadas reales en base a todas las tarifas de todas las operadoras simulando el coste de tus facturas</strong></div></td>
	<td width="20"></td>
  </tr>
  <tr height="75">
    <td width="20"></td>
    <td width="378"  >&nbsp;</td>
	<td width="20"></td>
  </tr>
  </table>
-->
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
  <area shape="rect" coords="470,12,517,24" href="index.php" alt="" />
<area shape="rect" coords="518,12,621,25" href="quienesSomos.php" alt="" />
<area shape="rect" coords="620,12,692,24" href="queOfrecemos.php" alt="" />
<area shape="rect" coords="692,12,776,25" href="contacto.php" alt="" />
</map>
</body>

</html>
