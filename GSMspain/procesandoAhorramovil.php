<?php header('P3P: CP="CAO PSA OUR"'); session_start(); 
	include("./../Lib/main.inc");
	include("./../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Error BD";
		exit();
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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META name="description" content="Esta p�gina permite conocer cuanto se puede ahorrar en la factura de telefon�a m�vil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefon�a, m�vil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefon�a m�vil. Aplicaci�n web para calcular el mejor operador, contrato y servicio de ahorro</title>
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
var counter = 0;

var xmlhttp = false;

try {
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (e) {
		xmlhttp = false;
	}
}
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
	xmlhttp = new XMLHttpRequest();
}

function ProcesarPorcentaje() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var obj = document.getElementById("textocompletando");
			obj.innerHTML = "Completado: " + xmlhttp.responseText + "%";
		}
	}
}

function ObtenerPorcentaje(idMiembro) {
	xmlhttp.open("GET", "porcentaje.php?idMiembro=" + idMiembro);
	xmlhttp.onreadystatechange = ProcesarPorcentaje;
	xmlhttp.send(null);
}


function CambiarColorTexto(idMiembro) {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	if (framemsg.style.visibility=="visible") {
		var textodiv = document.getElementById("textocompletando");
		if (color == "#FF0000")
			color = "#000000";
		else
			color = "#FF0000";
		textodiv.style.color=color;
		counter++;
		if (counter > 3) {
			ObtenerPorcentaje(idMiembro);
			counter = 0;
		}
	}
	setTimeout("CambiarColorTexto(" + idMiembro + ")", 500);
}
//-->
</script>
</head>
<body style="background-color:#FFFFFF" onLoad="javascript:setTimeout('CambiarColorTexto(<?php echo $idMiembro; ?>)', 500)">
<div id="procesandodiv" align="center">
	<table width="486" height="0" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td height="53" width="93"><img src="imagenes/rueda1.gif" alt="" /></td>
		    <td height="53" width="300">
           	  <div id="textocompletando" align="center" class="news" style="color:#FF0000"><strong>Completado: 0%</strong></div>
          </td>
		    <td height="53" width="93"><img src="imagenes/rueda1.gif" alt="" /></td>
		</tr>
	</table>
</div>
</body>
</html>