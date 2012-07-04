<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<link rel="stylesheet" href="zonaUsuarioActualizarCalculos.css" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
<script type="text/JavaScript">
function validateAndSubmit(nfacturas) {
	var sels = 0;
	for (var i = 0; i < nfacturas; i++) {
		var check = document.getElementById("Check" + i);
		if (check.checked == true)
			sels = sels + 1;
	}
	if (sels == 0)
		alert("Debes seleccionar alguna factura");
	else	
		document.FormularioEliminar.submit();
}
</script>
</head>
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

	$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = '$idMiembro' GROUP BY numero_movil_llamante";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numeros_moviles_llamantes = array();
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$numeros_moviles_llamantes[$i] = $row_array[0];
	}
	$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = '$idMiembro'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numeroFacturas = mysql_num_rows($result);

	$numero_movil_llamante = $_POST["Telefono"];
	if (isset($numero_movil_llamante)) {
		borrarResultados($idMiembro, $numero_movil_llamante);
		$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);

		// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
		$costes = obtenerCostes($facturas);

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
						AplicarServiciosAhorroALlamadasSeleccionadas($factura, $idContrato, $idCompatibilidad, true);
					}
				}
			}	
		}
	}
	else {
		$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = '$idMiembro' GROUP BY numero_movil_llamante";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			$numero_movil_llamante = $row_array[0];
	
			borrarResultados($idMiembro, $numero_movil_llamante);
			$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);
	
			// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
			$costes = obtenerCostes($facturas);
	
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
							AplicarServiciosAhorroALlamadasSeleccionadas($factura, $idContrato, $idCompatibilidad, true);
						}
					}
				}	
			}
		}
	}
?>

<body id="inicio">
<div id="wrapper">
	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/EncabezadoUsuario/encabezadoUsuario.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
	  </tr>
      </table>
  </div>
	

  <div id="login">
<table width="152" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="10" height="10"></td>
    <td width="24" height="10"></td>
    <td width="5" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10" height="30"></td>
    <td height="30" colspan="3" valign="middle">
      <div align="center" class="Estilo4">
        <?php
		if (count($numeros_moviles_llamantes) == 0)
			echo "No tienes ningún teléfono analizado";
		else if (count($numeros_moviles_llamantes) == 1)
			echo "Tienes 1 teléfono analizado";
		else
			echo "Tienes " . count($numeros_moviles_llamantes) . " teléfonos analizados";
		?>    
      </div>    </td>
    <td width="10" height="30"></td>
  </tr>
  <tr>
    <td width="10" height="10"></td>
    <td width="24" height="10"></td>
    <td width="5" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10" height="30"></td>
    <td height="30" colspan="3" valign="middle">
      <div align="center" class="Estilo4">
        <?php
		if ($numeroFacturas == 0)
			echo "No tienes facturas";
		else if ($numeroFacturas == 1)
			echo "Tienes 1 factura";
		else
			echo "Tienes " . $numeroFacturas . " facturas";
		?>    
      </div>    </td>
    <td width="10" height="30"></td>
  </tr>
  <tr>
    <td width="10" height="15"></td>
    <td width="24" height="15"></td>
    <td width="5" height="15"></td>
    <td height="15"></td>
    <td width="10" height="15"></td>
  </tr>
  <tr>
    <td width="10" height="24"></td>
    <td height="24" colspan="3"><a href="logout.php"><img src="imagenesmastreces/navegacioni/logout.gif" alt="" border="0" style="cursor:pointer" /></a></td>
    <td width="10" height="24"></td>
  </tr>
  <tr>
    <td width="10" height="25"></td>
    <td height="25" colspan="3"><div align="center"><a href="logout.php">Salir</a></div></td>
    <td width="10" height="25"></td>
  </tr>  
  <tr>
    <td width="10" height="15"></td>
    <td width="24" height="15"></td>
    <td width="5" height="15"></td>
    <td height="15"></td>
    <td width="10" height="15"></td>
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
  <table width="378"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="388" height="80"></td>
      <td width="13" height="80"></td>
      <td width="189" height="80"></td>
    </tr>    
    <tr>
      <td colspan="3">
      	<div align="center"><strong>&iexcl;Tu informe ha sido actualizado correctamente!</strong></div>
      </td>
    </tr>    
    <tr>
      <td height="20" colspan="3"></td>
    </tr>    
    <tr>
      <td height="20" colspan="3"><div align="center"><a href="zonaUsuario.php">Volver a la zona de Usuario</a></div></td>
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
  <area shape="rect" coords="472,127,515,142" href="index.php" alt="" />
<area shape="rect" coords="521,128,618,140" href="quienesSomos.php" alt="" />
<area shape="rect" coords="622,128,690,142" href="queOfrecemos.php" alt="" />
<area shape="rect" coords="694,125,770,142" href="contacto.php" alt="" />
</map></body>

</html>