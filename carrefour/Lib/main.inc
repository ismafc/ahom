<?php
// 0 = No existe
// 1 = Existe y es de un usuario provisional
// 2 = Existe y es de un usuario logado
function estadoFactura($periodo, $coste, $numero_movil_llamante) {
	$sql = "SELECT Estado FROM miembros WHERE id = (
				SELECT idMiembro FROM facturas WHERE periodo = '$periodo' AND coste = '$coste' AND numero_movil_llamante = '$numero_movil_llamante'
			)";
	$result = mysql_query($sql);
	if ($result == 0) {
		exit();
	}
	if (mysql_num_rows($result) == 0)
		return 0;
	$row_array = mysql_fetch_row($result);
	if ($row_array[0] == "PROVISIONAL")
		return 1;
	else
		return 2;
}

function login($usuario, $password) {
	$sql = "SELECT id FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0)
		exit();
	if (mysql_num_rows($result) == 0)
		return false;
	return true;
}

function obtenerNumeroDeFacturasMiembro($idMiembro) {
	$sql = "SELECT COUNT(id) FROM facturas WHERE idMiembro='$idMiembro'";
	$result = mysql_query($sql);
	if ($result == 0)
		return 0;
	if (mysql_num_rows($result) == 0)
		return 0;
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerCosteRealFacturas($idMiembro, $movilLlamante) {
	$sql = "SELECT SUM(coste) FROM facturas WHERE id IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$movilLlamante'
			)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerCostesRealesFacturas($idsFacturas) {
	$i = 0;
	foreach ($idsFacturas as $idFactura) {
		$sql = "SELECT coste FROM facturas WHERE id = '$idFactura'";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		else
		{
			$row_array = mysql_fetch_row($result);
			$costes[$i++] = $row_array[0];
		}
	}
	return $costes;
}

// Devolvemos un array que contiene los ids de todos los contratos ordenados por operador
function obtenerContratos() {
	$sql = "SELECT id FROM contratos ORDER BY idOperador";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$idContratos[$i] = $row_array[0];
	}
	return $idContratos;
}

// Devolvemos un array que contiene los ids de las facturas del usuario dado y el movil llamante dado
function obtenerFacturas($idUsuario, $llamante) {
	$ids = array();
	$sql = "SELECT id FROM facturas WHERE idMiembro = '$idUsuario' AND numero_movil_llamante = '$llamante'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			$ids[$i] = $row_array[0];
		}
	}
	return $ids;
}

// Devolvemos los
// costes de las facturaa para ese contrato
function obtenerCostesFacturas($idsFacturas, $idContrato, $guardarResultadosDetallados) {
	$i = 0;
	foreach ($idsFacturas as $idFactura)
		$costes[$i++] = obtenerCosteFactura($idFactura, $idContrato, $guardarResultadosDetallados);
	return $costes;
}

function obtenerCosteFactura($idFactura, $idContrato, $guardarResultadosDetallados) {
	$sql = "SELECT fraccion_minima, unidad_tarificacion, cuota_mensual, consumo_minimo, base_consumo_gratis, consumo_gratis FROM contratos WHERE id = '$idContrato'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$fraccion_minima = $row_array[0];
	$unidad_tarificacion = $row_array[1];
	$cuota_mensual = $row_array[2];
	$consumo_minimo = $row_array[3];
	$base_consumo_gratis = $row_array[4];
	$consumo_gratis = $row_array[5];
	$sql = "SELECT numero_telefono_llamado, idTipoLlamada, idTipoDia, inicio_llamada, duracion, idZonaInternacional, coste, id FROM llamadas WHERE idFactura = '$idFactura'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numero_llamadas = mysql_num_rows($result);
	$coste_total_calculado = 0;
	$idLlamada[0] = 0;
	$coste_simulado_llamada[0] = 0;
	for ($i = 0; $i < $numero_llamadas; $i++) {
		$coste_simulado_llamada[$i] = 0;
		$row_array = mysql_fetch_row($result);
		$numero_telefono_llamado = $row_array[0];
		$idTipoLlamada = $row_array[1];
		$idTipoDia = $row_array[2];
		$inicio_llamada = $row_array[3];
		$duracion = $row_array[4];
		$idZonaInternacional = $row_array[5];
		$coste_llamada_factura = $row_array[6];
		$idLlamadas[$i] = $row_array[7];
		$inicio_llamada_segundos = substr($inicio_llamada, 11, 2) * 3600 + substr($inicio_llamada, 14, 2) * 60 + substr($inicio_llamada, 17, 2);
		// Llamada Especial
		if ($idTipoLlamada == 18) {
			$coste_simulado_llamada[$i] = $coste_llamada_factura;
		}
		// MMS
		else if ($idTipoLlamada >= 8 && $idTipoLlamada <= 10) {
			$coste_simulado_llamada[$i] = $coste_llamada_factura;
		}
		// Internacionales y videollamadas
		else if ($idTipoLlamada >= 11 && $idTipoLlamada <= 17) {
			$coste_simulado_llamada[$i] = $coste_llamada_factura;
		}
		// Fijos y móviles
		else {
			$sql1 = "SELECT establecimiento_llamada, coste, intervalo_desde, intervalo_hasta FROM costes WHERE idContrato = '$idContrato' AND idTipoDia = '$idTipoDia' AND idTipoLlamada = '$idTipoLlamada' AND '$inicio_llamada_segundos' >= franja_hora_inicio AND '$inicio_llamada_segundos' < franja_hora_fin ORDER BY intervalo_desde";
			$result1 = mysql_query($sql1);
			if ($result1 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			if (mysql_num_rows($result1) == 0) {
				echo "<b>No hay coste definido para la llamada en el contrato " . $idContrato . "</b>";
				exit();
			}
			if ($duracion <= $fraccion_minima)
				$duracion_calculo = $fraccion_minima;
			else {
				$resto = $duracion % $unidad_tarificacion;
				$duracion_calculo = (int)($duracion / $unidad_tarificacion);
				if ($resto > 0)
					$duracion_calculo++;
				$duracion_calculo *= $unidad_tarificacion;
			}
			for ($franja = 0; $franja < mysql_num_rows($result1); $franja++) {
				$row_array1 = mysql_fetch_row($result1);
				$establecimiento_llamada = $row_array1[0];
				$coste_contrato = $row_array1[1];
				$intervalo_desde = $row_array1[2];
				$intervalo_hasta = $row_array1[3];
				if ($duracion_calculo > $intervalo_hasta) {
					$coste_simulado_llamada[$i] += ($intervalo_hasta - $intervalo_desde) * $coste_contrato;
					$coste_simulado_llamada[$i]	= $coste_simulado_llamada[$i] + $establecimiento_llamada;
				}
				else if ($duracion_calculo <= $intervalo_hasta) {
					$coste_simulado_llamada[$i] += ($duracion_calculo - $intervalo_desde) * $coste_contrato;
					$coste_simulado_llamada[$i]	= $coste_simulado_llamada[$i] + $establecimiento_llamada;
					break;
				}
				else {
					echo "<b>No hay franja definida</b>";
					exit();
				}
			}			
		}

		$coste_total_calculado += $coste_simulado_llamada[$i];		
	}
	if ($coste_total_calculado > $base_consumo_gratis) {
		if ($coste_total_calculado - $consumo_gratis > $base_consumo_gratis)
			$coste_total_calculado = $coste_total_calculado - $consumo_gratis;
		else
			$coste_total_calculado = $base_consumo_gratis;
	}
	if ($coste_total_calculado < $consumo_minimo)
		$coste_total_calculado = $consumo_minimo;
	$coste_total_calculado += $cuota_mensual;
	$coste_total_calculado *= 1.16;

	$fecha = date("Y-m-d H:i:s");
	$sql3 = "SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato'";
	$result3 = mysql_query($sql3);
	if ($result3 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result3) != 0) {
		for ($i = 0; $i < mysql_num_rows($result3); $i++) {
			$row_array3 = mysql_fetch_row($result3);
			$sql4 = "DELETE FROM resultados_basicos WHERE id = '$row_array3[0]'";
			$result4 = mysql_query($sql4);
			if ($result4 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
		}
	}

	$sql2 = "INSERT INTO resultados_basicos (idFactura, idContrato, fecha, coste) VALUES ('$idFactura', '$idContrato', '$fecha', '$coste_total_calculado')";
	$result2 = mysql_query($sql2);
	if ($result2 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if ($guardarResultadosDetallados == true)
		guardarResultadosDetallados($idLlamadas, $coste_simulado_llamada, $numero_llamadas, $idFactura, $idContrato);
	return $coste_total_calculado;
}

function guardarResultadosDetallados($idLlamadas, $coste_simulado_llamada, $numero_llamadas, $idFactura, $idContrato, $idCompatibilidad = NULL)
{
	$sql = "INSERT INTO resultados_detallados (idLlamada, idResultadoBasico, coste) VALUES ";
	for ($i = 0; $i < $numero_llamadas; $i++) {
		$csl = $coste_simulado_llamada[$i];
		$idl = $idLlamadas[$i];
		$sql = $sql . "('$idl', (SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato'";
		if (empty($idCompatibilidad) == false)
			$sql = $sql . " AND idCompatibilidad = '$idCompatibilidad'";
		$sql = $sql . "),'$csl')";
		if ($i < $numero_llamadas - 1)
			$sql = $sql . ",";
	}
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
}

function obtenerIdOperadorProbable($prefijo) {
	$sql = "SELECT identificacion_operador.idOperador FROM identificacion_operador WHERE prefijo='$prefijo'";
	$result = mysql_query($sql);
	if ($result == 0)
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		if (mysql_num_rows($result) != 1)
			echo "<b>No puede haber más de un operador para el prefijo " . $prefijo . "</b>";
		$row_array = mysql_fetch_row($result);
		return $row_array[0];
	}
}

function obtenerTipoDia($fecha) {
	$fecha_hora = date("Y-m-d", strtotime($fecha));	
	$sql = "SELECT calendario.idTipoDia FROM calendario WHERE fecha='$fecha_hora'";
	$result = mysql_query($sql);
	if ($result == 0)
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		if (mysql_num_rows($result) != 1)
			echo "<b>No puede haber más de un tipo de dia para la fecha " . $fecha . "</b>";
		$row_array = mysql_fetch_row($result);
		return $row_array[0];
	}
}

function actualizarMovilesDudosos($idTipoLlamada, $idOperador, $idMiembro, $telefono_llamado, $telefono_llamante) {
	if ($idTipoLlamada > 1000 && $idTipoLlamada != 1018) {
		echo $idTipoLlamada . "<br>";
		$idOperadorPropuesto = 0;
		if ($idTipoLlamada == 1003 || $idTipoLlamada == 1005 || $idTipoLlamada == 1008 || $idTipoLlamada == 1012 || $idTipoLlamada == 1015)
			$idOperadorPropuesto = 1; // MOVISTAR
		else if ($idTipoLlamada == 1004 || $idTipoLlamada == 1007 || $idTipoLlamada == 1010 || $idTipoLlamada == 1014 || $idTipoLlamada == 1017)
			$idOperadorPropuesto = 2; // ORANGE
		else if ($idTipoLlamada == 1002 || $idTipoLlamada == 1006 || $idTipoLlamada == 1009 || $idTipoLlamada == 1013 || $idTipoLlamada == 1016)
			$idOperadorPropuesto = 3; // VODAFONE
		$idOperadoresPosibles[0] = 0;
		if ($idOperador == 3) { // VODAFONE
			$idOperadoresPosibles[0] = 1;
			$idOperadoresPosibles[1] = 2;
		}
		else if ($idOperador == 2) { // ORANGE
			$idOperadoresPosibles[0] = 1;
			$idOperadoresPosibles[1] = 3;
		}
		else if ($idOperador == 1) { // MOVISTAR
			$idOperadoresPosibles[0] = 2;
			$idOperadoresPosibles[1] = 3;
		}
		for ($i = 0; $i < count($idOperadoresPosibles); $i++) {
			$idOperadorPosible = $idOperadoresPosibles[$i];
			$sql = "INSERT INTO moviles_dudosos (numero_movil_llamante, numero_movil, idMiembro, idOperadorPropuesto, idOperadorPosible) VALUES ('$telefono_llamante', '$telefono_llamado', '$idMiembro', '$idOperadorPropuesto', '$idOperadorPosible')";
			$result = mysql_query($sql);
		}
	}
}

function cambiarTipoLlamada($idMiembro, $telefono, $idOperador) {
	$sql = "SELECT llamadas.id, llamadas.idTipoLlamada FROM llamadas, facturas WHERE numero_telefono_llamado = '$telefono' AND facturas.id = llamadas.idFactura AND idFactura IN (SELECT id FROM facturas WHERE idMiembro = '$idMiembro')";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$idLlamada = $row_array[0];
		$idTipoLlamadaOriginal = $row_array[1];
		switch ($idOperador) {
			case 0: // Operador indefinido
				$sql1 = "UPDATE llamadas SET idTipoLlamada = 18 WHERE id = '$idLlamada'";
				$result1 = mysql_query($sql1);
				if ($result1 == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				break;
			case 1: // Operador Movistar
				$idTipoLlamadaFinal = $idTipoLlamadaOriginal;
				switch ($idTipoLlamadaOriginal) {
					case 2:
					case 4:
						$idTipoLlamadaFinal = 3;
						break;
					case 6:
					case 7:
						$idTipoLlamadaFinal = 5;
						break;
					case 9:
					case 10:
						$idTipoLlamadaFinal = 8;
						break;
					case 13:
					case 14:
						$idTipoLlamadaFinal = 12;
						break;
					case 16:
					case 17:
						$idTipoLlamadaFinal = 15;
						break;
				}
				$sql1 = "UPDATE llamadas SET idTipoLlamada = '$idTipoLlamadaFinal' WHERE id = '$idLlamada'";
				$result1 = mysql_query($sql1);
				if ($result1 == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				break;
			case 2: // Operador ORANGE
				$idTipoLlamadaFinal = $idTipoLlamadaOriginal;
				switch ($idTipoLlamadaOriginal) {
					case 2:
					case 3:
						$idTipoLlamadaFinal = 4;
						break;
					case 5:
					case 6:
						$idTipoLlamadaFinal = 7;
						break;
					case 8:
					case 9:
						$idTipoLlamadaFinal = 10;
						break;
					case 12:
					case 13:
						$idTipoLlamadaFinal = 14;
						break;
					case 15:
					case 16:
						$idTipoLlamadaFinal = 17;
						break;
				}
				$sql1 = "UPDATE llamadas SET idTipoLlamada = '$idTipoLlamadaFinal' WHERE id = '$idLlamada'";
				$result1 = mysql_query($sql1);
				if ($result1 == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				break;
			case 3: // Operador Vodafone
				$idTipoLlamadaFinal = $idTipoLlamadaOriginal;
				switch ($idTipoLlamadaOriginal) {
					case 3:
					case 4:
						$idTipoLlamadaFinal = 2;
						break;
					case 5:
					case 7:
						$idTipoLlamadaFinal = 6;
						break;
					case 8:
					case 10:
						$idTipoLlamadaFinal = 9;
						break;
					case 12:
					case 14:
						$idTipoLlamadaFinal = 13;
						break;
					case 15:
					case 17:
						$idTipoLlamadaFinal = 16;
						break;
				}
				$sql1 = "UPDATE llamadas SET idTipoLlamada = '$idTipoLlamadaFinal' WHERE id = '$idLlamada'";
				$result1 = mysql_query($sql1);
				if ($result1 == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				break;
		}
		if ($idOperador != 0) {
			$sql2 = "DELETE FROM moviles_dudosos WHERE idMiembro = '$idMiembro' AND numero_movil = '$telefono'";
			$result2 = mysql_query($sql2);
			if ($result2 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}			
		}
	}
}

function obtenerNombreOperador($id) {
	$sql = "SELECT nombre FROM operadores WHERE id = '$id'";
	$result = mysql_query($sql);
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function insertarErrorProcesoFactura($idMiembro, $archivo, $error) {
	$sql = "INSERT INTO errores_proceso_facturas (idMiembro, archivo, error) VALUES ('$idMiembro', '$archivo', '$error')";
	$result = mysql_query($sql);
}

function existe($n, $numeros_moviles_llamantes) {
	foreach ($numeros_moviles_llamantes as $nn) {
		if ($n == $nn)
			return true;
	}
	return false;
}

function obtenerNumeroDeClientes() {
	$sql = "SELECT COUNT(id) FROM miembros WHERE Estado <> 'PROVISIONAL'";
	$result = mysql_query($sql);
	if ($result == 0)
		return "0.00";
	if (mysql_num_rows($result) == 0)
		return "0.00";
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerNumeroDeFacturas() {
	$sql = "SELECT COUNT(id) FROM facturas";
	$result = mysql_query($sql);
	if ($result == 0)
		return 0;
	if (mysql_num_rows($result) == 0)
		return 0;
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function crearUsuarioCarrefour($usuario, $password) {
	if (!login($usuario, $password)) {
		$fechacreacion = date("Y-m-d H:i:s");
		$sql = "INSERT INTO miembros (Login, Password, Creado, Estado, Fax) VALUES ('$usuario', '$password', '$fechacreacion', 'PROVISIONAL', 'CARREFOUR')";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
}

function crearTablaResultadosBasicosRestringidaCarrefour($idMiembro, $numero_movil_llamante) {
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
		echo "<br>No hay informe que mostrar. Deberías enviar facturas.";
		exit();
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
	if ($estimacionAhorroAnualA <= 1) {
		echo "<br>¡Enhorabuena! No podemos garantizarte que tus llamadas sean más baratas con nosotros.<br><br>";
		echo "Aun así te invitamos a que descubras nuestras promociones y la telefonía móvil más sencilla y barata haciendo clic <a href=\"http://www.carrefour.es/movil/servicios/tarjeta-prepago.html\" target=\"_parent\">aquí</a>.<br><br>";
	}
	else {
		$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
		echo "<br>¡Aviso importante! Te recomendamos: <b>" . $row_array[0] . "</b><br><br>";
		if (strpos($numero_movil_llamante,",") === false)
			echo "<br>Para el teléfono <em>" . $numero_movil_llamante . "</em><br><br>";
		else
			echo "<br>Para los teléfonos <em>" . $numero_movil_llamante . "</em><br><br>";
		$idMejorOperador = $row_array[2];
		$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$numero_de_servicios_ahorro = mysql_num_rows($result);
		if ($numero_de_servicios_ahorro > 0) 
			echo "Hemos encontrado un contrato y algún servicio de ahorro con el que habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b>";
		else {
			if ($numeroFacturas == 1)
				echo "Con los consumos de tu factura te hubieras ahorrado <em>" . sprintf("%.2f", $ahorro) . " €</em>";
			else
				echo "Con los consumos de tus " . $numeroFacturas . " facturas te hubieras ahorrado <em>" . sprintf("%.2f", $ahorro) . " €</em>";
		}
		echo " (<a href=\"#\" onclick=\"LanzarResultadosDetalladosCarrefour(" . $numero_movil_llamante . ")\">detalles</a>)<br><br>";
		
		echo "El ahorro anual estimado sería de <em>" . sprintf("%.2f", $estimacionAhorroAnualA) . " €</em><br><br>";

		echo "Si quieres saber como ahorrarte esos <em>" . sprintf("%.2f", $estimacionAhorroAnualA) . " €</em> haz clic <a href=\"https://www.carrefour.es/movil/portabilidad.asp\" target=\"_parent\">aquí</a><br><br>";
//		echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorro) / $costeTotalReal) . " %</b><br><br>";

	}
//	actualizarEstadisticasBasicas($idMiembro, $numero_movil_llamante, $costeTotalReal, $costeContratoMasServicioAhorroMejor);

	$resultados[0] = $estimacionAhorroAnualA;
	$resultados[1] = 0;
	$resultados[2] = $idResultadoBasicoMejor;
	$resultados[3] = 0;
	return $resultados;
}


?>