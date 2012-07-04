<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<link rel="stylesheet" href="main.css" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="JavaScript">
<!--
var color = "#FF0000";

function CambiarColorTexto() {
	var textodiv = document.getElementById("textocompletando");
	if (color == "#FF0000")
		color = "#000000";
	else
		color = "#FF0000";
	textodiv.style.color=color;
	setTimeout("CambiarColorTexto()", 500);
}
//-->
</script>
</head>
<body style="background-color:#FFFFFF" onload="javascript:setTimeout('CambiarColorTexto()', 500)">
<div id="procesandodiv" align="center">
	<table width="486" height="0" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td height="53" width="93"><img src="imagenes/rueda1.gif" alt="" /></td>
		    <td height="53" width="300">
           	  <div id="textocompletando" align="center" class="news" style="color:#FF0000"><strong>Completando el c&aacute;lculo...</strong> espera unos segundos</div>
          </td>
		    <td height="53" width="93"><img src="imagenes/rueda1.gif" alt="" /></td>
		</tr>
	</table>
</div>
</body>
</html>