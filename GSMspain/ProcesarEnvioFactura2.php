<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html>
<head>
	<title>Resultados del cálculo</title>
<link rel="stylesheet" href="main.css" type="text/css" />
<style type="text/css">
.Estilo1 {color:#003399}
.Estilo2 {
	font-size: 10px;
	color: #6196A6;
}
.Estilo5 {
	color: #C4541A;
	font-weight: bold;
}
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {
	color: #6196A6;
	font-size: 10px;
	font-weight: bold;
}
.Estilo11 {font-size: 10}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script language="JavaScript">
<!--
function OcultarEspera() {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	var frameaho = parent.document.getElementById("fahorramovil");
	var maintable = parent.document.getElementById("maintableahorramovil");
	maintable.height="680";
	framemsg.style.visibility="hidden";
	framemsg.height="0";
	frameaho.style.visibility="visible";
	frameaho.height="680";
	return false;
}
//-->
</script>
</head>
<body style="background-color:#FFFFFF" onLoad="OcultarEspera();">
<div align="center">
	<table width="589" border="0" cellpadding="0" cellspacing="0">
		<tr>
            <td width="10"></td>
			<td height="17" valign="center" bgcolor="ECF1F5" class="tablafina_titulo">
            	<div align="center">&iexcl;Encuentra la mejor opción para ti!</div>
            </td>
            <td width="10"></td>
		</tr>
		<tr>
            <td height="10" width="10"></td>
			<td height="10"></td>
            <td height="10" width="10"></td>
		</tr>
	</table>
  
<?php
	include("./../Lib/library.inc");
	include("./../Lib/main.inc");
	include("./../Lib/base.inc");
	if (openDatabase() == false)
		exit();

	// 	Provisionalmente
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisionalFrom($_SESSION['miembro'], $_SESSION['password'], "GSMSPAIN");
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
<table width="589" border="2" cellpadding="5" cellspacing="0" bordercolor="#A46200" bgcolor="#FFE4CA">
    <tr>
        <td align="center" >
			<div align="center">
				<?php
					// --------------------------
					// Presentación de resultados
					// --------------------------
					$resultados = crearTablaResultadosBasicos($idMiembro, $numero_movil_llamante);
                ?>	
			</div>
		</td>
	</tr>
</table>
<table width="589" border="0" cellspacing="0" cellpadding="10">
    <tr>
        <td height="15" valign="middle">
            <div align="center" class="verdanapeque">(*) Si quieres enviar m&aacute;s facturas entra en <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">Ahorramovil</a> con los siguientes datos:            </div>
      </td>
    </tr>
    <tr>
        <td height="15" valign="middle">
            <div align="center" class="verdanapeque">Usuario: <span class="menu_izq"><?php echo $login; ?></span>&nbsp;Contrase&ntilde;a: <span class="menu_izq"><?php echo $password; ?></span>						
            </div>
      </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
</table>
<table width="589" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height="20" colspan="3" valign="middle">
            <div align="center" class="news">Servicio proporcionado por <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">www.ahorramovil.com</a>                    
            </div>
      </td>
    </tr>
    <tr>
        <td height="10" colspan="3"></td>
    </tr>
</table>

<table width="589" height="50" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="10"></td>
      <td>
          <div align="center">
              <a href="http://www.ahorramovil.com" target="_blank">
                  <img src="imagenes/logoInforme.gif" alt="" border="0" class="f1w" />                      </a>                  </div>
      </td>
        <td width="10"></td>
    </tr>
</table>
<table width="589" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="15" valign="middle">
          <div align="center" class="verdanapeque">
           	  <a href="http://www.gsmspain.com/tarifas" target="_top" class="menu_izq">Vorver al formulario inicial</a>          </div>
      </td>
    </tr>
    <tr>
        <td height="30"></td>
    </tr>
</table>
</div>
</body>
</html>