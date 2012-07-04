<html>
<head>
<title>Limpiar Base de datos!</title>
</head>
<body>
<?php
	include("../Lib/library.inc");
	include("../Lib/main.inc");
	include("../Lib/facturas.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "No se puedo acceder a la base de datos!<br />";
		echo "</body></html>";
		exit();
	}


	$sql = "DELETE FROM llamadas WHERE idFactura NOT IN (SELECT id FROM facturas)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de llamadas!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM facturas WHERE idMiembro NOT IN (SELECT id FROM miembros)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de facturas los miembros inexistentes!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM facturas WHERE idOperador NOT IN (SELECT id FROM operadores)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de facturas los operadores inexistentes!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM facturas WHERE idParentesco NOT IN (SELECT id FROM parentescos)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de facturas los parentescos inexistentes!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM costes WHERE idContrato NOT IN (SELECT id FROM contratos)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de costes!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM costes_ahorro WHERE idServicioAhorro NOT IN (SELECT id FROM servicios_ahorro)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de costes_ahorro!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM compatibilidades WHERE idContrato NOT IN (SELECT id FROM contratos) OR idServicioAhorro NOT IN (SELECT id FROM servicios_ahorro)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de compatibilidades!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM llamadas_a_revisar WHERE idFactura NOT IN (SELECT id FROM facturas)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de llamadas_a_revisar!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM moviles_dudosos WHERE idMiembro NOT IN (SELECT id FROM miembros)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de moviles_dudosos!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM resultados_basicos WHERE idContrato NOT IN (SELECT id FROM contratos) OR idFactura NOT IN (SELECT id FROM facturas)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de resultados_basicos!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM resultados_detallados WHERE idLlamada NOT IN (SELECT id FROM llamadas) OR idResultadoBasico NOT IN (SELECT id FROM resultados_basicos)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de resultados_detallados!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro NOT IN (SELECT id FROM servicios_ahorro) OR idResultadoBasico NOT IN (SELECT id FROM resultados_basicos)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de resultados_numeros_servicios_ahorro!";
		echo "</body></html>";
		exit();
	}

	$sql = "DELETE FROM resumen_telefonos WHERE idMiembro NOT IN (SELECT id FROM miembros)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b> No se pudo borrar de la tabla de resumen_telefonos!";
		echo "</body></html>";
		exit();
	}

	echo "Limpieza OK!";
?>
</body>
</html>