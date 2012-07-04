<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>

<link rel="stylesheet" href="enviarFactura.css" type="text/css" />

<script type="text/JavaScript">


var idMiembro;
var nFacturas;
var pagina_requerida;

function procesarPorcentaje() {
    if (pagina_requerida.readyState == 4) {
        if (pagina_requerida.status == 200) {
			var porcentaje = pagina_requerida.responseText;
            showProgressBar(porcentaje);
	        if (porcentaje != "100") {
	            setTimeout("poll()", 2000);
	        }
        }
    }
}

function llamarasincrono(url)
{
    if (window.XMLHttpRequest) {
        pagina_requerida = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        pagina_requerida = new ActiveXObject("Microsoft.XMLHTTP");
    }
    pagina_requerida.open("GET", url, true);
}

function showProgressBar(porcentaje) {
	var po = window.document.getElementById("Porcentaje");
	po.innerHTML = "<strong>Completado: " + porcentaje + "%</strong>";
}

function poll() {
    var url = "porcentaje.php?idMiembro=" + idMiembro + "&nFacturas=" + nFacturas;
    llamarasincrono(url);
    pagina_requerida.onreadystatechange = procesarPorcentaje;
    pagina_requerida.send(null);
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  idMiembro = args[6];
  nFacturas = args[7];
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
  setTimeout("poll()", 1000);
}

function clickMovistar() {
	document.FormularioMovistar.submit();
	return true;
}

function clickOrange() {
	document.FormularioOrange.submit();
	return true;
}

function clickVodafone() {
	document.FormularioVodafone.submit();
	return true;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
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

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
</head>



<?php
	include("./Lib/library.inc");
	include("./Lib/main.inc");
	include("./Lib/facturas.inc");
	include("./Lib/base.inc");
	if (openDatabase() == false)
		exit();

	// 	Provisionalmente
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
	
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
	$nFacturas = obtenerNumeroDeFacturasMiembro($idMiembro);
?>



<body onload="MM_preloadImages('imagenesmastreces/contenido/enviarmovistar.gif','imagenesmastreces/contenido/enviarmovistar1.gif','imagenesmastreces/contenido/enviarorange1.gif','imagenesmastreces/contenido/enviarvodafone1.gif')">



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
    <td><input name="Entrar" type="submit"  id="Entrar" value="" />	</td>
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
	<div id="Movistar">
	  <form action="ProcesarEnvioFactura.php" method="post" enctype="multipart/form-data" target="_self" id="FormularioMovistar" name="FormularioMovistar">
        <table width="418" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="55" valign="middle"></td>
            <td width="44" height="55" valign="middle"></td>
            <td height="55" align="center"></td>
            </tr>
          <tr>
            <td width="11" height="49" valign="middle">
            <!--<input type="submit" id="EMovistar" name="EMovistar" value="" /> -->            </td>
            <td width="44" height="49" valign="top" onclick="clickMovistar()"><a href="#"><img src="imagenesmastreces/contenido/enviarmovistar.gif" alt="Enviar factura Movistar" name="ImagenEnviarMovistar" id="ImagenEnviarMovistar" onmouseover="MM_swapImage('ImagenEnviarMovistar','','imagenesmastreces/contenido/enviarmovistar1.gif',1)" onmouseout="MM_swapImgRestore()" onclick="MM_showHideLayers('wrapper','','hide','espera','','show',<?php echo $idMiembro . ", " . $nFacturas; ?>)"/></a></td>
            <td height="49" align="center" valign="middle"><input type="file" id="FacturaPdfMovistar1b" name="FacturaPdfMovistar1b" /></td>
            </tr>
        </table>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	    </form>
	</div>
	<div id="Vodafone">
	  <form action="ProcesarEnvioFactura.php" method="post" enctype="multipart/form-data" target="_self" id="FormularioVodafone" name="FormularioVodafone">
        <table width="418" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="55" valign="middle"></td>
            <td width="44" height="55" valign="middle"></td>
            <td height="55" align="center"></td>
          </tr>
          <tr>
            <td width="11" height="49" valign="middle">
            <!--<input type="submit" id="EMovistar" name="EMovistar" value="" /> -->            </td>
            <td width="44" height="49" valign="top" onclick="clickVodafone()"><a href="#"><img src="imagenesmastreces/contenido/enviarvodafone.gif" alt="Enviar factura Vodafone" name="ImagenEnviarVodafone" width="44" height="44" id="ImagenEnviarVodafone" onmouseover="MM_swapImage('ImagenEnviarVodafone','','imagenesmastreces/contenido/enviarvodafone1.gif',1)" onmouseout="MM_swapImgRestore()" onclick="MM_showHideLayers('wrapper','','hide','espera','','show',<?php echo $idMiembro . ", " . $nFacturas; ?>)"/></a></td>
            <td height="49" align="center" valign="middle"><input type="file" id="FacturaPdfVodafone1" name="FacturaPdfVodafone1" /></td>
            </tr>
        </table>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	    </form>
    </div>
	<div id="Orange">
	  <form action="ProcesarEnvioFactura.php" method="post" enctype="multipart/form-data" target="_self" id="FormularioOrange" name="FormularioOrange">
        <table width="418" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="56" valign="middle"></td>
            <td width="44" height="56" valign="middle"></td>
            <td height="56" align="center"></td>
          </tr>
          <tr>
            <td width="11" height="48" valign="middle">
            <!--<input type="submit" id="EMovistar" name="EMovistar" value="" /> -->            </td>
            <td width="44" height="48" valign="top" onclick="clickOrange()"><a href="#"><img src="imagenesmastreces/contenido/enviarorange.gif" alt="Enviar factura Orange" name="ImagenEnviarOrange" width="44" height="44" id="ImagenEnviarOrange" onmouseover="MM_swapImage('ImagenEnviarOrange','','imagenesmastreces/contenido/enviarorange1.gif',1)" onmouseout="MM_swapImgRestore()" onclick="MM_showHideLayers('wrapper','','hide','espera','','show',<?php echo $idMiembro . ", " . $nFacturas; ?>)"/></a></td>
            <td height="48" align="center" valign="middle"><input type="file" id="FacturaPdfOrange1" name="FacturaPdfOrange1" /></td>
            </tr>
        </table>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	    </form>
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

<div id="espera">
    <div id="cabecera_espera" align="center">
	<table width="780" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td><div align="center"><img src="imagenesmastreces/encabezadoComoEnviarFacturas/encabezado3.gif" /></div></td>
		</tr>
	</table>
    </div>
    <div id="mensaje_espera" align="center">
	<table width="780" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td><div align="center">El programa está calculando</div></td>
		</tr>
		<tr>
		    <td><div align="center">Esta operación puede tardar algunos segundos. Espere por favor...</div></td>
		</tr>
	</table>
    </div>
    <div id="progreso_espera" align="center">
	<table width="586" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		    <td height="53" width="400">
            	<div id="Porcentaje" align="center"><strong>Completado: 0%</strong></div>            </td>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		</tr>
	</table>
    </div>
</div>
</body>

</html>
