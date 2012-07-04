<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Procesado de facturas</title>
<link rel="stylesheet" href="ProcesarEnvioFactura.css" type="text/css" />
<style type="text/css">
.Estilo1 {color: #FFFFFF}
</style>
</head>

<body>
<div id="wrapper">
	<div id="encabezado">
	  <table border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td height="117" valign="top"><img src="imagenesmastreces/encabezadoComoEnviarFacturas/encabezado3.gif"></td>
    </tr>
	  </table>
  </div>
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

	$numero_movil_llamante = $_POST["Telefono"];
	$telefonos[0] = "";
	$idOperadores[0] = "";
	$i = 0;
	$telefono = "Telefono" . $i;
	while (isset($_POST[$telefono])) {
		$telefonos[$i] = $_POST[$telefono];
		$operador = "Operador" . $i;
		$idOperadores[$i] = $_POST[$operador];
		$i++;
		$telefono = "Telefono" . $i;
	}

	for ($i = 0; $i < count($telefonos); $i++)
		cambiarTipoLlamada($idMiembro, $telefonos[$i], $idOperadores[$i]);

	$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);

	// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
	$costes = obtenerCostes($facturas, $numero_movil_llamante);

	// ----------------
	// Servicios Ahorro
	// ----------------

	$idContratos = obtenerContratos();
	foreach($idContratos as $idContrato) {
		$idsCompatibilidades = ObtenerCompatibilidades($idContrato);
		if (empty($idsCompatibilidades) == false) {
			foreach ($idsCompatibilidades as $idCompatibilidad) {
				ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante);
				$idsServiciosAhorro = ObtenerServiciosAhorro($idCompatibilidad, $idContrato);
				GenerarResultadosBasicosServiciosAhorro($facturas, $idContrato, $idCompatibilidad);
				foreach ($idsServiciosAhorro as $idServicioAhorro) {
					$telefonos = ObtenerTelefonos($idServicioAhorro, $idMiembro, $numero_movil_llamante);
					if (count($telefonos) > 0) {
						GenerarResultadosNumerosServiciosAhorro($facturas, $idContrato, $idCompatibilidad, $idServicioAhorro, $telefonos);
						EliminarTelefonosYaSeleccionados($idMiembro, $numero_movil_llamante, $idServicioAhorro, $facturas, $idContrato, $idCompatibilidad);
					}
				}
			}
			ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante);
	
			// Vamos a calcular los costes de los resultados básicos con los servicios de ahorro
			foreach ($facturas as $factura) {
				foreach ($idsCompatibilidades as $idCompatibilidad) {
					AplicarServiciosAhorroALlamadasSeleccionadas($factura, $idContrato, $idCompatibilidad, false, $numero_movil_llamante);
				}
			}
		}	
	}
?>
<form action="VerResultados.php" method="post" name="DatosVerResultados" target="_self" id="DatosVerResultados">
<table width="779" height="60" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"><img src="imagenesmastreces/contenido/informea.gif" width="779" height="52"></td>
  </tr>
  <tr>
    <td align="center" style="background-color:#CEE00A">
    <?php
	// --------------------------
	// Presentación de resultados
	// --------------------------
	$resultados = crearTablaResultadosBasicosRestringida($idMiembro, $numero_movil_llamante);
	?>	</td>
  </tr>
  
<?php
	$estimacionAhorroAnualA = $resultados[0];
	if ($estimacionAhorroAnualA > 1) {
		echo "<input type=\"hidden\" name=\"telefono\" value=\"" . $numero_movil_llamante . "\">";
		echo "<input type=\"hidden\" name=\"resumentelefonos\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"tablacontratos\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"tablaservicios\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"llamadassimuladas\" value=\"0\">";
	?>
		  <tr>
		    <td style="background-color:#CEE00A">&nbsp;</td>
    </tr>
		  <tr>
		    <td style="background-color:#CEE00A">&nbsp;</td>
    </tr>
		  <tr>
		    <td style="background-color:#CEE00A"><div id="botonDetallados" align="center">
		      <input name="Ver" type="submit" id="Ver" value="">
		    </div></td>
		  </tr>
    <?php
	}
	?>
  <tr>
    <td align="center"><img src="imagenesmastreces/contenido/informeb.gif" width="779" height="52"></td>
  </tr>
</table>
</form>
<br/>
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
</div>
</body>
</html>