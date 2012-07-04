<html>
<head>
<title>PHP&MySQL Test</title>
</head>
<body>
<?php
function recalcularEstadisticasPara($idMiembro, $numero_movil_llamante) {
	// Información básica sobre el mejor contrato y compatibilidad
	$resultados = array();
	$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE idFactura IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
			) GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) == 0) {
		echo "<br><span class=\"Estilo36\"><b>No hay informe que mostrar. Deberías enviar facturas.</b></span><br><br>";
		return;
	}
	$row_array = mysql_fetch_row($result);
	$idResultadoBasicoMejor = $row_array[0];
	$idResultadoBasicoMejorOperadorMiembro = 0;
	$costeContratoMasServicioAhorro = $row_array[3];
	$costeContratoMasServicioAhorroMejor = $costeContratoMasServicioAhorro;
	$costeTotalReal = obtenerCosteRealFacturas($idMiembro, $numero_movil_llamante);
	$ahorro = $costeTotalReal - $costeContratoMasServicioAhorro;
	$numeroFacturas = obtenerNumeroFacturas($idMiembro, $numero_movil_llamante);
	$estimacionAhorroAnualA = ($ahorro * 12) / $numeroFacturas;
	echo "<span class=\"Estilo36\">";
	if (strpos($numero_movil_llamante,",") === false)
		echo "<br>Para el teléfono <b>" . $numero_movil_llamante . "</b><br><br>";
	else
		echo "<br>Para los teléfonos <b>" . $numero_movil_llamante . "</b><br><br>";
	if ($estimacionAhorroAnualA <= 1)
		echo "<br><b>Ya tienes el mejor contrato y servicios de ahorro posibles... enhorabuena!</b><br><br>";
	else {
		$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
		$idMejorOperador = $row_array[2];
		$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$numero_de_servicios_ahorro = mysql_num_rows($result);
		if ($numero_de_servicios_ahorro > 0) 
			echo "Hemos encontrado un contrato y algún servicio de ahorro con el que habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";
		else
			echo "Hemos encontrado un contrato con el que habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";

		echo "El ahorro anual estimado sería de <b>" . sprintf("%.2f", $estimacionAhorroAnualA) . " €</b><br><br>";
		echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorro) / $costeTotalReal) . " %</b><br><br>";

	}
	actualizarEstadisticasBasicas($idMiembro, $numero_movil_llamante, $costeTotalReal, $costeContratoMasServicioAhorroMejor);

	$resultados[0] = $estimacionAhorroAnualA;
	$resultados[1] = 0;
	$resultados[2] = $idResultadoBasicoMejor;
	$resultados[3] = 0;
	return $resultados;
}
?>
<?php
	include("../Lib/library.inc");
	include("../Lib/main.inc");
	include("../Lib/facturas.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false)
		exit();

	$idMiembro = $row_array[0];

	// 	No permitimos enviar más de una factura a un usuario provisional
	$sql = "SELECT miembros.id, facturas.numero_movil_llamante FROM miembros, facturas WHERE miembros.id = facturas.idMiembro GROUP BY miembros.id, facturas.numero_movil_llamante";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($j = 0; $j < mysql_num_rows($result); $j++) {
		$row_array = mysql_fetch_row($result);
		recalcularEstadisticasPara($row_array[0], $row_array[1]);
	}
?>
</body>
</html>