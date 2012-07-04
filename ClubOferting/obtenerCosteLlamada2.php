<?php header('P3P: CP="CAO PSA OUR"'); session_start();

if (!isset($mainFolder))
   $mainFolder = "../";
include($mainFolder . "Lib/library.inc");
include($mainFolder . "Lib/facturas.inc");
include($mainFolder . "Lib/baseServicioClubOferting.inc");
include($mainFolder . "Lib/main.inc");
include("./Lib/ClubOfertingLlamada.inc");
if (openDatabase() == false)
	exit();

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// Comprobamos el operador de origen
unset ($operadorOrigen);
if ($_GET["operadorOrigen"] < 90)
	$operadorOrigen = obtenerNombreOperador ($_GET["operadorOrigen"]);

if (!isset($operadorOrigen)){
	echo "<error><msg>operadorOrigen incorrecto</msg><error>";
	exit();
}

// Comprobamos el operador de destino
unset ($operadorDestino);
if ($_GET["operadorDestino"] <= 3)
	$operadorDestino = obtenerNombreOperador ($_GET["operadorDestino"]);

if (!isset ($operadorDestino)){
	echo "<error><msg>operadorDestino incorrecto</msg><error>";
	exit();
}

// Comprobamos la fecha
if (strlen ($_GET["fecha"]) != 12){
	echo "<error><msg>fecha incorrecta</msg><error>";
	exit();
}
if (!ereg("^[0-9]+$", $_GET["fecha"])) {
	echo "<error><msg>fecha incorrecta</msg><error>";
	exit();
}

$dia = substr ($_GET["fecha"], 0, 2);
$mes = substr ($_GET["fecha"], 2, 2);
$año = substr ($_GET["fecha"], 4, 4);
$hora = substr ($_GET["fecha"], 8, 2);
$minuto = substr ($_GET["fecha"], 10, 2);

if ($hora > 59 || $hora < 0 || $minuto > 59 || $minuto < 0 || checkdate ($mes,$dia,$año) == FALSE){
	echo "<error><msg>fecha incorrecta</msg><error>";
	exit();
}

$tipo = $_GET["tipo"];
if ($tipo != "VOZ" && $tipo != "SMS"){
	echo "<error><msg>tipo incorrecto</msg><error>";
	exit();
}

$duracion = $_GET["duracion"];
if ($tipo == "VOZ"){
	if (!ereg("^[0-9]+$", $_GET["fecha"]) || $duracion <= 0){
		echo "<error><msg>duracion incorrecta</msg><error>";
		exit();
	}
}else
	$duracion = 0;


// 	Provisionalmente
if (!isset($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting'])) {
	$_SESSION['miembroClubOferting'] = session_id();
	$_SESSION['passwordClubOferting'] = session_id();
	crearUsuarioProvisionalFrom($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting'], "ClubOferting");
}

$login = $_SESSION['miembroClubOferting'];
$password = $_SESSION['passwordClubOferting'];
$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
$result = mysql_query($sql);
if ($result == 0) {
	echo "<error><msg>Error en base de datos</msg></error>";
//		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
	if (esProvisional ($login, $password)){
			borrarUsuario ($login, $password);
			unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
//		session_regenerate_id();
	}

	exit();
}
$row_array = mysql_fetch_row($result);
$idMiembro = $row_array[0];
$nFacturas = obtenerNumeroDeFacturasMiembro($idMiembro);

$idFactura = 0;
$edad_titular = 0;
$idParentesco = 3;
$descripcion = "";
//	$numeros_moviles_llamantes = array();
$numeros = 0;

$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
$content .= "<factura>\r\n";
$content .= "<version>1.0</version>\r\n";
$content .= "<numero_movil_llamante>123456789</numero_movil_llamante>\r\n";
$content .= "<titular>".$login."</titular>\r\n";
$content .= "<periodo>";
$content .= $dia."/".$mes."/".$año." - ";
$content .= $dia."/".$mes."/".$año;
$content .= "</periodo>\r\n";
$content .= "<coste>9999</coste>\r\n";
$content .= "<operador>".$operadorOrigen."</operador>\r\n";
$content .= "<llamadas>\r\n";
$content .= "<llamada>\r\n";
$content .= "<numero_movil_llamado>987654321</numero_movil_llamado>\r\n";
$content .= "<operador>".$operadorDestino."</operador>\r\n";
$content .= "<tipo>".$tipo."</tipo>\r\n";
$content .= "<ambito>LOCAL</ambito>\r\n";
$content .= "<fecha>".$dia."/".$mes."/".$año." ".$hora.":".$minuto.":00</fecha>\r\n";
$content .= "<duracion>".$duracion."</duracion>\r\n";
$content .= "<coste>9999</coste>\r\n";
$content .= "<zona_internacional>1</zona_internacional>\r\n";
$content .= "</llamada>\r\n";
$content .= "</llamadas>\r\n";
$content .= "</factura>\r\n";

$n = procesarFactura($content, $idMiembro, $edad_titular, $idParentesco, $descripcion, $idFactura);
if ($n == "ALREADY_EXISTS") {
	echo "<error><msg>No ha sido posible realizar los calculos</msg></error>";
	$error = true;
	if (esProvisional ($login, $password)){
		borrarUsuario ($login, $password);
		unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
	}
	exit(0);
}
else if ($n[0] == '!') {
	echo "<error><msg>No ha sido posible realizar los calculos</msg></error>";
	insertarErrorProcesoFactura($idMiembro, $destination, $n);
	$error = true;
	if (esProvisional ($login, $password)){
		borrarUsuario ($login, $password);
		unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
	}
	exit(0);
}

$numero_movil_llamante = $n;
$facturas = array();
$facturas[0] = $idFactura;

// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
$costes = obtenerCostesClubOferting($facturas, $numero_movil_llamante);

// ----------------
// Servicios Ahorro
// ----------------

$idContratos = obtenerContratosClubOferting();
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
				AplicarServiciosAhorroALlamadasSeleccionadasClubOferting($factura, $idContrato, $idCompatibilidad, false, $numero_movil_llamante);
			}
		}
	}
}
//     Información básica sobre el mejor contrato y compatibilidad
$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
		SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
		) AND idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1)
		GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";

$result = mysql_query($sql);
if ($result == 0) {
	echo "<error><msg>No ha sido posible generar el XML de resultados</msg></error>";
	exit();
}
if (mysql_num_rows($result) == 0) {
	echo "<error><msg>No ha sido posible calcular el mejor contrato para la llamada</msg></error>";
	return 0;
}

$row_array = mysql_fetch_row($result);
$idResultadoBasicoMejor = $row_array[0];
$costeContratoMasServicioAhorro = $row_array[3];

$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
$result = mysql_query($sql);
if ($result == 0) {
	echo "<error><msg>No ha sido posible generar el XML de resultados</msg></error>";
	exit();
}
$row_array = mysql_fetch_row($result);
$idMejorOperador = $row_array[2];
$nombreMejorContrato = $row_array[0];
$nombreMejorOperador = $row_array[1];
$idOperadorMiembro = obtenerIdOperadorMiembro($idMiembro, $numero_movil_llamante);

echo "<costeLlamada>";
echo "<mejorContrato>";
echo "<nombre>".$nombreMejorContrato." (".$nombreMejorOperador.")</nombre>";

// Servicios de ahorro
$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
$result = mysql_query($sql);
if ($result != 0) {
	$numero_de_servicios_ahorro = mysql_num_rows($result);
	if ($numero_de_servicios_ahorro > 0){
		echo "<serviciosAhorro>";
		for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<nombre>".$row_array[1]."</nombre>";
		}
		echo "</serviciosAhorro>";
	}
}
echo "<coste>";
echo sprintf("%.2f", $costeContratoMasServicioAhorro);
echo "</coste>";
echo "</mejorContrato>";

if ($idOperadorMiembro != $idMejorOperador){
	$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
			SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
			) AND idContrato IN (
			SELECT id FROM contratos WHERE idOperador = '$idOperadorMiembro'
			)
			GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
	$result = mysql_query($sql);
	if ($result != 0) {
		$row_array = mysql_fetch_row($result);
		$idResultadoBasicoMejorOperadorMiembro = $row_array[0];
		$costeContratoMasServicioAhorroOperadorMiembro = $row_array[3];
		$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
		$result = mysql_query($sql);
		if ($result != 0) {
			$row_array = mysql_fetch_row($result);
			echo "<mejorContratoOperadorOrigen>";
			echo "<nombre>".$row_array[0]." (".$row_array[1].")</nombre>";

			// Servicios de ahorro
			$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro' GROUP BY idServicioAhorro";
			$result = mysql_query($sql);
			if ($result != 0) {
				$numero_de_servicios_ahorro = mysql_num_rows($result);
				if ($numero_de_servicios_ahorro > 0){
					echo "<serviciosAhorro>";
					for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
						$row_array = mysql_fetch_row($result);
						echo "<nombre>".$row_array[1]."</nombre>";
					}
					echo "</serviciosAhorro>";
				}
			}
			echo "<coste>";
			echo sprintf("%.2f", $costeContratoMasServicioAhorroOperadorMiembro);
			echo "</coste>";
			echo "</mejorContratoOperadorOrigen>";
		}
	}
}
echo "</costeLlamada>";

if (esProvisional ($login, $password)){
    borrarUsuario ($login, $password);
    unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
}
?>
