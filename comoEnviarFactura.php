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
<link rel="stylesheet" href="comoEnviarFactura.css" type="text/css" />

<script type="text/JavaScript">
<!--
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body id="inicio" onload="MM_preloadImages('imagenesmastreces/contenido/enviarfact1.gif')">
<div id="wrapper">

	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/encabezadoComoEnviarFacturas/encabezado.gif" alt="" usemap="#Map3" id="Image1" />
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
    <td><p><span>&iexcl;Actualizamos las tarifas constantemente!</span><br/>
Nuevos contratos, nuevos operadores, etc...<br/></p>
      &iexcl;Consulta nuestros <a href="queOfrecemos.php">servicios</a>!<br/>
      <br/>
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
    <td width="398"><div align="justify">Ahorramovil ofrece una manera muy sencilla para que envies tus facturas. Solo debes descargar de la página web de tu operador todas las facturas que desees.</div></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
</table>
<img src="imagenesmastreces/contenido/comoEnviarFacturas.gif" alt="" usemap="#Map4" />
<map name="Map4" id="Map4">
  <area shape="rect" coords="15,19,81,229" alt="Como enviar facturas"  href="#" onClick="MM_openBrWindow('popup.html','','width=640,height=650,scrollbars=no')">
<area shape="rect" coords="86,101,281,235" href="enviarFactura.php" alt="" />
</map>
	
	
	<table width="418" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398"><div align="justify">Una vez descargadas en tu PC, debes enviarnoslas mediante el enlace que encontrarás en la página de inicio, o en tu zona de usuario si ya estás dado de alta o haciendo click <a href="enviarFactura.php">AQUI</a></div></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="398">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
</table>
<div id="botonanimado"><img src="imagenesmastreces/contenido/botonEnviar.gif" alt="" usemap="#Map" /></div>
<map name="Map" id="Map"><area shape="rect" coords="113,8,303,46" href="enviarFactura.php" alt="" />
</map> 
	 
	</div>
	
	
    <div id="div_estadisticas">
         <IFRAME id="iframe_estadisticas" frameborder="0" src="barraDerecha.php">No se soportan iframes!</IFRAME>
    </div>
	
			
</div>

<div id="div_pie">
    <IFRAME id="iframe_pie" frameborder="0" src="pie.php">No se soportan iframes!</IFRAME>
</div>
</div>

<map name="Map3" id="Map3">
  <area shape="rect" coords="472,127,515,142" href="index.php" alt="" />
<area shape="rect" coords="521,128,618,140" href="quienesSomos.php" alt="" />
<area shape="rect" coords="622,128,690,142" href="queOfrecemos.php" alt="" />
<area shape="rect" coords="694,125,770,142" href="contacto.php" alt="" />
</map></body>

</html>
