<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<link rel="stylesheet" href="resultados.css" type="text/css" />
<script type="text/JavaScript">
function showHideLayers() {
	esperadiv = document.getElementById("espera");
	esperadiv.style.visibility = "visible";
	wrapperdiv = document.getElementById("wrapper");
	wrapperdiv.style.visibility = "hidden";
}
</script>
<style type="text/css">
<!--
.Estilo35 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Estilo42 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #646562; font-weight: bold; }
.Estilo45 {font-size: 14px;}

.Estilo33 {
	font-size: 30pt;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
}


.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	font-weight: bold;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.Estilo4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
}
.Estilo36 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
.Estilo37 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
-->
    </style>
<!--
.Estilo33 {
	font-size: 30pt;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
}
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	font-weight: bold;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.Estilo4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
}
-->
</head>
<body>
<div id="espera" style="visibility:hidden; position:absolute; left:0; top:0; width:100%">
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
            	<div id="Porcentaje" align="center"><strong>...recalculando...</strong></div>            </td>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		</tr>
	</table>
    </div>
</div>
<div id="wrapper">
<?php
	include("./Lib/library.inc");
	include("./Lib/main.inc");
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

	$edad_titular = 0;
	$idParentesco = 3;
	$descripcion = "";
	$numeros_moviles_llamantes = array();
	$numeros = 0;

//$_FILES['userfile']['name'][0] = $HTTP_POST_FILES['userfile']['name'][0];
//$_FILES['userfile']['tmp_name'][0] = $HTTP_POST_FILES['userfile']['tmp_name'][0];
//$_FILES['userfile']['type'][0] = $HTTP_POST_FILES['userfile']['type'][0];
//$_FILES['userfile']['size'][0] = $HTTP_POST_FILES['userfile']['size'][0];
//$_FILES['userfile']['name'][1] = $HTTP_POST_FILES['userfile']['name'][1];
	
	$numero_movil_llamante = $_POST["telefono"];
	$verResumenTelefonos = $_POST["resumentelefonos"];
	$verTablaContratos = $_POST["tablacontratos"];
	$verTablaServicios = $_POST["tablaservicios"];
	$verLlamadasSimuladas = $_POST["llamadassimuladas"];
?>

<table width="100%" align="center" cellpadding="0" cellspacing="0" background="imagenesmastreces/encabezadoInforme/encabezadoInforme.gif">
  <tr>
    <td><div align="center"><img src="imagenesmastreces/encabezadoInforme/logoInforme.gif"></div></td>
  </tr>
</table>
	  <br>
<table width="100%" height="60" border="2" cellpadding="5" cellspacing="0" bordercolor="#A46200" bgcolor="#FFE4CA">
  <tr>
    <td align="center">
    <?php
	// --------------------------
	// Presentación de resultados
	// --------------------------
	$resultados = crearTablaResultadosBasicos($idMiembro, $numero_movil_llamante);
	$estimacionAhorroAnualA = $resultados[0];
	$estimacionAhorroAnualB = $resultados[1];
	$idResultadoBasicoMejor = $resultados[2];
	$idResultadoBasicoMejorOperadorMiembro = $resultados[3];
	if ($estimacionAhorroAnualA > 1) {
		?></td>
  </tr>
</table><br>
<?php
		if ($verResumenTelefonos == "1") {
?>
<br><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="Estilo35">Los n&uacute;meros a los que m&aacute;s llamas</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#B0010A"></td>
  </tr>
</table><br>
<?php
			crearTablaResumenTelefonos($idMiembro, $numero_movil_llamante);
		}
		if ($verTablaContratos == "1") {
?>
<br><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="Estilo35">Simulaci&oacute;n de los costes de tus facturas con todos los contratos</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#B0010A"></td>
  </tr>
</table><br>
<?php		
			crearTablaResultadosContratos($idMiembro, $numero_movil_llamante);
		}
		if ($verTablaServicios == "1") {
?>
<br><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="Estilo35">Simulaci&oacute;n de los costes de tus facturas con los mejores servicios de ahorro para cada contrato</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#B0010A"></td>
  </tr>
</table><br>
<?php		
			crearTablaResultadosContratosCompatibilidades($idMiembro, $numero_movil_llamante);
		}
		if ($verLlamadasSimuladas == "1") {
?>
<br><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="Estilo35">Simulaci&oacute;n de tus llamadas con el mejor contrato y servicio de ahorro</td>
  </tr>
  <tr>
    <td height="1" bgcolor="#B0010A"></td>
  </tr>
</table><br>
<?php		
			crearTablaCostesDetallados($idResultadoBasicoMejor);
			if ($idResultadoBasicoMejorOperadorMiembro != 0 && $estimacionAhorroAnualB > 1) {
				?>
				<br><br><br>
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
				  <tr>
					<td align="center" class="Estilo35">Simulaci&oacute;n  de tus llamadas con el mejor contrato y servicio de ahorro de tu operador </td>
				  </tr>
				  <tr>
					<td height="1" bgcolor="#B0010A"></td>
				  </tr>
				</table><br>
				<?php
				crearTablaCostesDetallados($idResultadoBasicoMejorOperadorMiembro);
			}
		}
	}	
	else {
	?>	
	</td>
  </tr>
</table>
<br>
<?php
	}
?>
<br><br><br>
<div id="pie">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="50%" class="Estilo42">
    	<?php
			if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
		?>
		    	&iquest;Quieres enviar más facturas? Date de alta <a href="alta.php">aqu&iacute;</a> gratis!.
        <?php
			}
			else {
				$nombreusu = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
				echo $nombreusu;
		?>, ve a tu <a href="zonaUsuario.php">Zona de Usuario</a>
        <?php
			}
		?>
    </td>
	<td width="50%"><div align="center"><span class="Estilo42">Ir al <a href="index.php" target="_self">Inicio</a></span></div></td>
  </tr>
  </table>
  </div>

  <br><br><br>
</div>
</body>
</html>