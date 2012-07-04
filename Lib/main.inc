<?php
function crearUsuarioProvisionalFrom($usuario, $password, $from) {
	if (!login($usuario, $password)) {
		$fechacreacion = date("Y-m-d H:i:s");
		$sql = "INSERT INTO miembros (Login, Password, Creado, Estado, Fax) VALUES ('$usuario', '$password', '$fechacreacion', 'PROVISIONAL', '$from')";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error y" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
}

function crearUsuarioProvisional($usuario, $password) {
	if (!login($usuario, $password)) {
		$fechacreacion = date("Y-m-d H:i:s");
		$sql = "INSERT INTO miembros (Login, Password, Creado, Estado) VALUES ('$usuario', '$password', '$fechacreacion', 'PROVISIONAL')";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error y" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
}

function esProvisional($usuario, $password) {
	$sql = "SELECT Estado FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0)
		exit();
	$row_array = mysql_fetch_row($result);
	if ($row_array[0] == "PROVISIONAL")
		return true;
	else
		return false;
}

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

function traspasarFactura($user1, $password1, $user2, $password2) {
	$sql = "UPDATE facturas SET idMiembro = (
				SELECT id FROM miembros WHERE Login = '$user2' AND Password = '$password2'
			) WHERE idMiembro = (
				SELECT id FROM miembros WHERE Login = '$user1' AND Password = '$password1'
			)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error j" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
}

function login($usuario, $password) {
	$sql = "SELECT id, Estado FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error login 1 " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) == 0)
		return false;

	$row_array = mysql_fetch_row($result);
	if ($row_array[1] == 'PROVISIONAL') {
		$sql = "UPDATE miembros SET Estado = 'INACTIVO' WHERE Login = '$usuario' AND Password = '$password'";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error login 2 " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
	return true;
}

function borrarUsuario($usuario, $password) {
	$sql = "DELETE FROM miembros WHERE Login = '$usuario' AND Password = '$password' AND Estado = 'PROVISIONAL'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error k" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
}

function obtenerNombreUsuario($usuario, $password) {
	$sql = "SELECT Nombre FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0)
		exit();
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerPasswordUsuario($usuario, $password) {
	$sql = "SELECT Password FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0)
		exit();
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerLoginUsuario($usuario, $password) {
	$sql = "SELECT Login FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0)
		exit();
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerCorreoUsuario($usuario, $password) {
	$sql = "SELECT Correo FROM miembros WHERE Login = '$usuario' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0)
		exit();
	$row_array = mysql_fetch_row($result);
	return $row_array[0];
}

function obtenerFechaActual() {
	$diasemananumero = date("w");
	$mesnumero = date("n");
	$mes = "";
	$diasemana = "";
	switch ($diasemananumero) {
		case 0:
			$diasemana = "Domingo";
			break;
		case 1:
			$diasemana = "Lunes";
			break;
		case 2:
			$diasemana = "Martes";
			break;
		case 3:
			$diasemana = "Miércoles";
			break;
		case 4:
			$diasemana = "Jueves";
			break;
		case 5:
			$diasemana = "Viernes";
			break;
		case 6:
			$diasemana = "Sábado";
			break;
	}
	switch ($mesnumero) {
		case 1:
			$mes = "Enero";
			break;
		case 2:
			$mes = "Febrero";
			break;
		case 3:
			$mes = "Marzo";
			break;
		case 4:
			$mes = "Abril";
			break;
		case 5:
			$mes = "Mayo";
			break;
		case 6:
			$mes = "Junio";
			break;
		case 7:
			$mes = "Julio";
			break;
		case 8:
			$mes = "Agosto";
			break;
		case 9:
			$mes = "Septiembre";
			break;
		case 10:
			$mes = "Octubre";
			break;
		case 11:
			$mes = "Noviembre";
			break;
		case 12:
			$mes = "Diciembre";
			break;
	}
	return $diasemana . ", " . date("d-") . $mes . date("-Y");
}

function obtenerDescripcionesFacturas($idsFacturas) {
	$i = 0;
	foreach ($idsFacturas as $idFactura) {
		$sql = "SELECT descripcion, periodo FROM facturas WHERE id = '$idFactura'";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error m" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		else
		{
			$row_array = mysql_fetch_row($result);
			if ($row_array[0] == "")
				$descripciones[$i++] = $row_array[1];
			else
				$descripciones[$i++] = $row_array[0];
		}
	}
	return $descripciones;
}

function obtenerCosteRealFacturas($idMiembro, $movilLlamante) {
	$sql = "SELECT SUM(coste) FROM facturas WHERE id IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$movilLlamante'
			)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error n" . mysql_errno() . ": " . mysql_error() . "</b>";
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
			echo "<b>Error o" . mysql_errno() . ": " . mysql_error() . "</b>";
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
	$sql = "SELECT id FROM contratos WHERE descatalogado = 0 ORDER BY idOperador";
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

function obtenerUltimaFactura($idUsuario) {
	$sql = "SELECT id FROM facturas WHERE idMiembro = '$idUsuario' ORDER BY id DESC";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		$row_array = mysql_fetch_row($result);
		return $row_array[0];
	}
	return 0;
}

// Devolvemos el id del operador del número llamante
// Escogemos la última factura enviada por el usuario (por si se ha cambiado)
function obtenerIdOperadorMiembro($idUsuario, $llamante) {
	$sql = "SELECT idOperador FROM facturas WHERE idMiembro = '$idUsuario' AND numero_movil_llamante = '$llamante' ORDER BY id DESC";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		if (mysql_num_rows($result) == 0) {
			echo "<b>El usuario no tiene facturas!</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
		$ids = $row_array[0];
	}
	return $ids;
}

function ObtenerCompatibilidades($idContrato) {
	$sql = "SELECT idCompatibilidad FROM compatibilidades WHERE idContrato = '$idContrato' GROUP BY idCompatibilidad";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else {
		if (mysql_num_rows($result) == 0)
			return false;
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			$idsCompatibilidades[$i] = $row_array[0];
		}
	}
	return $idsCompatibilidades;
}

function ObtenerServiciosAhorro($idCompatibilidad, $idContrato) {
	$sql = "SELECT idServicioAhorro FROM compatibilidades WHERE idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else {
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			$idsServiciosAhorro[$i] = $row_array[0];
		}
	}
	return $idsServiciosAhorro;
}

function borrarResultados($idMiembro, $numero_movil_llamante) {
	$sql = "DELETE FROM resultados_basicos WHERE idFactura IN (SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante')";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
}


function ObtenerTelefonos($idServicioAhorro, $idMiembro, $numero_movil_llamante) {
	$sql = "SELECT combinacion FROM combinaciones_servicios_ahorro WHERE idServicioAhorro = '$idServicioAhorro' GROUP BY combinacion";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$combinacion_seleccionada = -1;
	$coste_combinacion_seleccionada = -1;
	$numero_combinaciones = mysql_num_rows($result);
	for ($i = 0; $i < $numero_combinaciones; $i++) {
		$row_array = mysql_fetch_row($result);
		$sql1 = "SELECT idTipoLlamada, NumeroLineas FROM combinaciones_servicios_ahorro WHERE idServicioAhorro = '$idServicioAhorro' AND combinacion = '$row_array[0]'";
		$result1 = mysql_query($sql1);
		if ($result1 == 0) {
			echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$telefonos_de_la_combinacion = array();
		$coste_combinacion = 0;
		for ($k = 0; $k < mysql_num_rows($result1); $k++) {
			$row_array1 = mysql_fetch_row($result1);
			if (empty($row_array1[0]) == false)
				$sql2 = "SELECT numero_telefono_llamado, coste FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante' AND idTipoLlamada = '$row_array1[0]' ORDER BY coste DESC";
			else 
				$sql2 = "SELECT numero_telefono_llamado, coste FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante' AND idTipoLlamada <> 18 ORDER BY coste DESC";
			$result2 = mysql_query($sql2);
			$numero_lineas = 0;
			for ($j = 0; $numero_lineas < $row_array1[1] && $j < mysql_num_rows($result2); $j++) {
				$row_array2 = mysql_fetch_row($result2);
				if (array_search($row_array2[0], $telefonos_de_la_combinacion) === false) {
					$telefonos_de_la_combinacion[count($telefonos_de_la_combinacion)] = $row_array2[0];
					$coste_combinacion += $row_array2[1];
					$numero_lineas++;
				}
			}
		}
		if ($coste_combinacion > $coste_combinacion_seleccionada) {
			$coste_combinacion_seleccionada = $coste_combinacion;
			$combinacion_seleccionada = $row_array[0];
		}
	}

	// Para afinar el cálculo de los servicios de ahorro, hacemos esta consulta para obtener
	// los costes fijos de añadir teléfonos al servicio de ahorro que luego compararemos con los
	// costes de las llamadas de esos teléfonos
	$sqlAfinar = "SELECT cuota_mensual, condicion_cuota_mensual, cuota_vodafone, cuota_movistar, cuota_amena, cuota_fijo FROM servicios_ahorro WHERE id = '$idServicioAhorro'";
	$resultAfinar = mysql_query($sqlAfinar);
	if ($resultAfinar == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_arrayAfinar = mysql_fetch_row($resultAfinar);

	// Ahora ya sabemos la combinación del servicio de ahorro que da mayor coste y por tanto es la elegida para escoger los teléfonos		
	$sql3 = "SELECT idTipoLlamada, NumeroLineas FROM combinaciones_servicios_ahorro WHERE idServicioAhorro = '$idServicioAhorro' AND combinacion = '$combinacion_seleccionada'";
	$result3 = mysql_query($sql3);
	if ($result3 == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$coste_total_numeros_seleccionados = 0;
	$telefonos = array();
	$k = 0;
	for ($i = 0; $i < mysql_num_rows($result3); $i++) {
		$row_array3 = mysql_fetch_row($result3);
		if (empty($row_array3[0]) == false)
			$sql4 = "SELECT numero_telefono_llamado, coste, idTipoLlamada FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante' AND idTipoLlamada = '$row_array3[0]' ORDER BY coste DESC";
		else
			$sql4 = "SELECT numero_telefono_llamado, coste, idTipoLlamada FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante' AND idTipoLlamada <> 18 ORDER BY coste DESC";
		$result4 = mysql_query($sql4);
		$numero_lineas = 0;
		for ($j = 0; $numero_lineas < $row_array3[1] && $j < mysql_num_rows($result4); $j++) {
			$row_array4 = mysql_fetch_row($result4);
			if (array_search($row_array4[0], $telefonos) === false) {
				if ($row_array4[2] == 2 && $row_array4[1] > $row_arrayAfinar[2]) {
/*					if ($idServicioAhorro == 17) {
						echo "Tel = " . $row_array4[0] . ", coste = " . $row_array4[1] . ", coste de añadir = " . $row_arrayAfinar[2] . "<br>";
					}*/
					$telefonos[$k++] = $row_array4[0];
					$coste_total_numeros_seleccionados += $row_array4[1];
					$numero_lineas++;
				}
				else if ($row_array4[2] == 3 && $row_array4[1] > $row_arrayAfinar[3]) {
					$telefonos[$k++] = $row_array4[0];
					$coste_total_numeros_seleccionados += $row_array4[1];
					$numero_lineas++;
				}
				else if ($row_array4[2] == 4 && $row_array4[1] > $row_arrayAfinar[4]) {
					$telefonos[$k++] = $row_array4[0];
					$coste_total_numeros_seleccionados += $row_array4[1];
					$numero_lineas++;
				}
				else if ($row_array4[2] == 1 && $row_array4[1] > $row_arrayAfinar[5]) {
					$telefonos[$k++] = $row_array4[0];
					$coste_total_numeros_seleccionados += $row_array4[1];
					$numero_lineas++;
				}
			}
		}
	}
	if ($coste_total_numeros_seleccionados <= $row_arrayAfinar[0])
		$telefonos = array();
	return $telefonos;
}

function AplicarServiciosAhorroALlamadasSeleccionadas($idFactura, $idContrato, $idCompatibilidad, $guardarResultadosDetallados, $numero_movil_llamante) {
	$sql2 = "SELECT fraccion_minima, unidad_tarificacion, cuota_mensual, consumo_minimo, base_consumo_gratis, consumo_gratis FROM contratos WHERE id = '$idContrato'";
	$result2 = mysql_query($sql2);
	if ($result2 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array2 = mysql_fetch_row($result2);
	$fraccion_minima = $row_array2[0];
	$unidad_tarificacion = $row_array2[1];
	$cuota_mensual_contrato = $row_array2[2];
	$consumo_minimo_contrato = $row_array2[3];
	$base_consumo_gratis_contrato = $row_array2[4];
	$consumo_gratis_contrato = $row_array2[5];
/*
	$sqlsss = "SELECT idLlamada FROM resultados_detallados WHERE idResultadoBasico = (
					SELECT MIN(id) FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato'
				)";
	$resultsss = mysql_query($sqlsss);
	for ($i = 0; $i < mysql_num_rows($resultsss); $i++) {
		$row_arraysss = mysql_fetch_row($resultsss);
		echo "<b>" . $row_arraysss[0] . "</b><br>";
	}
	echo "<b>...............</b><br>";
*/
	$sqlIDRB = "SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'";
	$resultIDRB = mysql_query($sqlIDRB);
	if ($resultIDRB == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_arrayIDRB = mysql_fetch_row($resultIDRB);
	$idResultadoBasico = $row_arrayIDRB[0];
/*
	$sql = "SELECT numero_telefono_llamado, idTipoLlamada, idTipoDia, inicio_llamada, duracion, idZonaInternacional, llamadas.id, resultados_detallados.coste FROM llamadas, resultados_detallados WHERE resultados_detallados.idLlamada = llamadas.id AND resultados_detallados.idResultadoBasico = (SELECT MIN(id) FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato') AND llamadas.id IN (
				SELECT idLlamada FROM resultados_detallados WHERE idResultadoBasico = (
					SELECT MIN(id) FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato'
				)
			)";*/
	$sql = "SELECT numero_telefono_llamado, idTipoLlamada, idTipoDia, inicio_llamada, duracion, idZonaInternacional, llamadas.id, resultados_detallados.coste FROM ((resultados_detallados INNER JOIN resultados_basicos ON resultados_basicos.id = resultados_detallados.idResultadoBasico) INNER JOIN llamadas ON
resultados_detallados.idLlamada = llamadas.id) WHERE resultados_basicos.idFactura = '$idFactura' AND resultados_basicos.idContrato = '$idContrato'";
			
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error p" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numero_llamadas = mysql_num_rows($result); 
	for ($i = 0; $i < $numero_llamadas; $i++) {
		$row_array = mysql_fetch_row($result);
		$numero_telefono_llamado = $row_array[0];
		$idTipoLlamada = $row_array[1];
		$idTipoDia = $row_array[2];
		$inicio_llamada = $row_array[3];
		$duracion = $row_array[4];
		$idZonaInternacional = $row_array[5];
		$idLlamadas[$i] = $row_array[6];
		$coste_llamada_contrato = $row_array[7];
/*		
		$sql0 = "SELECT idServicioAhorro FROM resultados_numeros_servicios_ahorro WHERE numero_telefono = '$numero_telefono_llamado' AND idResultadoBasico = (
					SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'
				)";
*/				
		$sql0 = "SELECT idServicioAhorro FROM resultados_numeros_servicios_ahorro WHERE numero_telefono = '$numero_telefono_llamado' AND idResultadoBasico = '$idResultadoBasico'";
				
		$result0 = mysql_query($sql0);
		if ($result0 == 0) {
			echo "<b>Error q" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		if (mysql_num_rows($result0) != 1) {
			$coste_simulado_llamada[$i] = $coste_llamada_contrato;
		}
		else {
			$row_array0 = mysql_fetch_row($result0);
			$idServicioAhorro = $row_array0[0];
		
			$inicio_llamada_segundos = substr($inicio_llamada, 11, 2) * 3600 + substr($inicio_llamada, 14, 2) * 60 + substr($inicio_llamada, 17, 2);
			// Llamada Especial
			if ($idTipoLlamada == 18) {
				$coste_simulado_llamada[$i] = $coste_llamada_contrato;
			}
			// MMS
			else if ($idTipoLlamada >= 8 && $idTipoLlamada <= 10) {
				$coste_simulado_llamada[$i] = $coste_llamada_contrato;
			}
			// Internacionales y videollamadas
			else if ($idTipoLlamada >= 11 && $idTipoLlamada <= 17) {
				$coste_simulado_llamada[$i] = $coste_llamada_contrato;
			}
			// Fijos y móviles
			else {
				$sql1 = "SELECT establecimiento_llamada, coste, intervalo_desde, intervalo_hasta, porcentaje_descuento_total, porcentaje_descuento_tiempo FROM costes_ahorro WHERE idServicioAhorro = '$idServicioAhorro' AND idTipoDia = '$idTipoDia' AND idTipoLlamada = '$idTipoLlamada' ORDER BY intervalo_desde";
				$result1 = mysql_query($sql1);
				if ($result1 == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				if (mysql_num_rows($result1) == 0)
					$coste_simulado_llamada[$i] = $coste_llamada_contrato;
				else {
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
						$coste_servicio_ahorro = $row_array1[1];
						$intervalo_desde = $row_array1[2];
						$intervalo_hasta = $row_array1[3];
						$porcentaje_descuento_total = $row_array1[4];
						$porcentaje_descuento_tiempo = $row_array1[5];
						if (empty($coste_servicio_ahorro) == TRUE && empty($establecimiento_llamada) == TRUE) {
							// DESCUENTOS SOBRE COSTES DE CONTRATO
							$coste_simulado_llamada[$i] = $coste_llamada_contrato * (1 - $porcentaje_descuento_total / 100);
							$sql9 = "SELECT establecimiento_llamada, coste, intervalo_desde, intervalo_hasta FROM costes WHERE idContrato = '$idContrato' AND idTipoDia = '$idTipoDia' AND idTipoLlamada = '$idTipoLlamada' AND '$inicio_llamada' >= franja_hora_inicio AND '$inicio_llamada' < franja_hora_fin ORDER BY intervalo_desde";
							$result9 = mysql_query($sql9);
							if ($result9 == 0) {
								echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
								exit();
							}
							if (mysql_num_rows($result9) == 0) {
								echo "<b>No hay coste definido para la llamada en el contrato " . $idContrato . "</b>";
								exit();
							}
							$row_array9 = mysql_fetch_row($result9);
							$coste_simulado_llamada[$i] = ($coste_llamada_contrato - $row_array9[0])* (1 - $porcentaje_descuento_tiempo / 100);
						}
						else {
							// NUEVOS COSTES
							if ($duracion_calculo > $intervalo_hasta) {
								$coste_simulado_llamada[$i] += ($intervalo_hasta - $intervalo_desde) * $coste_servicio_ahorro;
								$coste_simulado_llamada[$i]	= $coste_simulado_llamada[$i] + $establecimiento_llamada;
							}
							else if ($duracion_calculo <= $intervalo_hasta) {
								$coste_simulado_llamada[$i] += ($duracion_calculo - $intervalo_desde) * $coste_servicio_ahorro;
								$coste_simulado_llamada[$i]	= $coste_simulado_llamada[$i] + $establecimiento_llamada;
								break;
							}
							else {
								echo "<b>No hay franja definida</b>";
								exit();
							}
						}
					}
				}
			}
		}
		$coste_total_calculado += $coste_simulado_llamada[$i];		
	}
	if ($guardarResultadosDetallados == true)
		guardarResultadosDetallados($idLlamadas, $coste_simulado_llamada, $numero_llamadas, $idFactura, $idContrato, $idCompatibilidad);
/*	else {
			$sqlDEL = "DELETE FROM resultados_detallados WHERE idResultadoBasico = (
							SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND
																	idContrato = '$idContrato' AND
																	idCompatibilidad = '$idCompatibilidad'
						)";
			$resultDEL = mysql_query($sqlDEL);
			if ($resultDEL == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}		
			echo "Borrado!<br>";
	}*/

//
// SUMAMOS LAS CUOTAS MENSUALES DE CADA SERVICIO DE AHORRO DE LA COMPATIBILIDAD
//
/*
	$sql6 = "SELECT cuota_mensual, condicion_cuota_mensual FROM servicios_ahorro WHERE id IN (
				SELECT idServicioAhorro FROM resultados_numeros_servicios_ahorro WHERE idResultadoBasico = (
					SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'
				) GROUP BY idServicioAhorro
			 )";
*/
	$sql6 = "SELECT cuota_mensual, condicion_cuota_mensual FROM servicios_ahorro WHERE id IN (
				SELECT idServicioAhorro FROM resultados_numeros_servicios_ahorro WHERE idResultadoBasico = '$idResultadoBasico' GROUP BY idServicioAhorro
			 )";
	$result6 = mysql_query($sql6);
	if ($result6 == 0) {
		echo "<b>Error s" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result6); $i++) {
		$row_array6 = mysql_fetch_row($result6);
		if ($coste_total_calculado < $row_array6[1] || $row_array6[1] == 0)
			$coste_total_calculado += $row_array6[0];
	}

//
// SUMAMOS LAS CUOTAS MENSUALES DE CADA NUMERO DE TELÉFONO SEGUN SU SERVICIO DE AHORRO
//
/*
	$sql3 = "SELECT numero_telefono, idServicioAhorro FROM resultados_numeros_servicios_ahorro WHERE idResultadoBasico = (
				SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'
			)";
*/
	$sql3 = "SELECT numero_telefono, idServicioAhorro FROM resultados_numeros_servicios_ahorro WHERE idResultadoBasico = '$idResultadoBasico'";
	$result3 = mysql_query($sql3);
	if ($result3 == 0) {
		echo "<b>Error t" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result3); $i++) {
		$row_array3 = mysql_fetch_row($result3);
		$telefono = $row_array3[0];
		$idServicioAhorro = $row_array3[1];
		/*
		$sql4 = "SELECT idTipoLlamada FROM llamadas WHERE numero_telefono_llamado = '$telefono' AND id IN (
					SELECT idLlamada FROM resultados_detallados WHERE idResultadoBasico IN (
						SELECT id FROM resultados_basicos WHERE idFactura IN (
							SELECT id FROM facturas WHERE idMiembro = (SELECT idMiembro FROM facturas WHERE id = '$idFactura')
						) AND idContrato = '$idContrato'
					)
				)";*/
		//$sql4 = "SELECT idTipoLlamada FROM ((resultados_detallados INNER JOIN resultados_basicos ON resultados_basicos.id = resultados_detallados.idResultadoBasico) INNER JOIN llamadas ON resultados_detallados.idLlamada = llamadas.id) WHERE numero_telefono_llamado = '$telefono' AND resultados_basicos.idFactura = '$idFactura' AND resultados_basicos.idContrato = '$idContrato'";
		$sql4 = "SELECT idTipoLlamada FROM ((resultados_detallados INNER JOIN resultados_basicos ON resultados_basicos.id = resultados_detallados.idResultadoBasico) INNER JOIN llamadas ON resultados_detallados.idLlamada = llamadas.id) WHERE numero_telefono_llamado = '$telefono' AND resultados_basicos.idContrato = '$idContrato'";
				
		$result4 = mysql_query($sql4);
		if ($result4 == 0) {
			echo "<b>Error u" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		if (mysql_num_rows($result4) == 0) {
			echo "<b>Tiene que haber almenos una llamada o mensaje al teléfono " . $telefono . "</b>";
			exit();
		}
		$row_array4 = mysql_fetch_row($result4);
		if ($row_array4[0] == 2 || $row_array4[0] == 6 || $row_array4[0] == 9 || $row_array4[0] == 13 || $row_array4[0] == 16)
			$operador = 3; // VODAFONE
		else if ($row_array4[0] == 3 || $row_array4[0] == 5 || $row_array4[0] == 8 ||$row_array4[0] == 12 ||$row_array4[0] == 15)
			$operador = 1; // MOVISTAR
		else if ($row_array4[0] == 4 || $row_array4[0] == 7 || $row_array4[0] == 10 ||$row_array4[0] == 14 ||$row_array4[0] == 17)
			$operador = 2; // ORANGE
		else
			$operador = 0; // FIJO
		
		$sql5 = "SELECT cuota_vodafone, cuota_movistar, cuota_amena, cuota_fijo FROM servicios_ahorro WHERE id = '$idServicioAhorro'";
		$result5 = mysql_query($sql5);
		if ($result5 == 0) {
			echo "<b>Error v" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array5 = mysql_fetch_row($result5);
		if ($operador == 0) // Fijo
			$coste_total_calculado += $row_array5[3];
		else if ($operador == 1) // MOVISTAR
			$coste_total_calculado += $row_array5[1];
		else if ($operador == 2) // ORANGE
			$coste_total_calculado += $row_array5[2];
		else if ($operador == 3) // VODAFONE
			$coste_total_calculado += $row_array5[0];
	}

	// Para el contrato
	$consumo_minimo_contrato = $consumo_minimo_contrato * (mb_substr_count($numero_movil_llamante, ",") + 1);
	$cuota_mensual_contrato = $cuota_mensual_contrato * (mb_substr_count($numero_movil_llamante, ",") + 1);
	$base_consumo_gratis_contrato = $base_consumo_gratis_contrato * (mb_substr_count($numero_movil_llamante, ",") + 1);
	$consumo_gratis_contrato = $consumo_gratis_contrato * (mb_substr_count($numero_movil_llamante, ",") + 1);
	if ($coste_total_calculado > $base_consumo_gratis_contrato) {
		if ($coste_total_calculado - $consumo_gratis_contrato > $base_consumo_gratis_contrato)
			$coste_total_calculado = $coste_total_calculado - $consumo_gratis_contrato;
		else
			$coste_total_calculado = $base_consumo_gratis_contrato;
	}
	if ($coste_total_calculado < $consumo_minimo_contrato)
		$coste_total_calculado = $consumo_minimo_contrato;
	$coste_total_calculado += $cuota_mensual_contrato;
	$coste_total_calculado *= 1.16;
	
	$fecha = date("Y-m-d H:i:s");
	$sql2 = "UPDATE resultados_basicos SET fecha = '$fecha', coste = '$coste_total_calculado' WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'";
	$result2 = mysql_query($sql2);
	if ($result2 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
}

function eliminarResultadosDetallados($idFactura, $idContrato) {
	$sqlDEL = "DELETE FROM resultados_detallados WHERE idResultadoBasico IN (
					SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND
															idContrato = '$idContrato'
				)";
	$resultDEL = mysql_query($sqlDEL);
	if ($resultDEL == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	//echo "Borrada factura " . $factura . " y contrato " . $idContrato . "!<br>";
}

function EliminarTelefonosYaSeleccionados($idMiembro, $numero_movil_llamante, $idServicioAhorro, $facturas, $idContrato, $idCompatibilidad) {
	$sql = "DELETE FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante' AND numero_telefono_llamado IN (SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idResultadoBasico = (SELECT id FROM resultados_basicos WHERE idFactura = '$facturas[0]' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'))";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error w" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}		
}

function GenerarResultadosNumerosServiciosAhorro($facturas, $idContrato, $idCompatibilidad, $idServicioAhorro, $telefonos) {
	foreach ($facturas as $factura) {
		$sql2 = "INSERT INTO resultados_numeros_servicios_ahorro (idResultadoBasico, numero_telefono, idServicioAhorro) VALUES ";
		$i = 0;
		foreach ($telefonos as $telefono) {
			$sql2 = $sql2 . "((SELECT id FROM resultados_basicos WHERE idFactura = '$factura' AND idCompatibilidad = '$idCompatibilidad' AND idContrato = '$idContrato'), '$telefono', '$idServicioAhorro')";
			if ($i < count($telefonos) - 1)
				$sql2 = $sql2 . ",";
			$i++;
		}
		$result2 = mysql_query($sql2);			
		if ($result2 == 0) {
			echo $sql2 . "<br>";
			echo "<b>Error x" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
}

function GenerarResultadosBasicosServiciosAhorro($facturas, $idContrato, $idCompatibilidad) {
	$sql = "INSERT INTO resultados_basicos (idFactura, idContrato, idCompatibilidad) VALUES ";
	$i = 0;
	foreach ($facturas as $factura) {
		$sql = $sql . "('$factura', '$idContrato', '$idCompatibilidad')";
		if ($i < count($facturas) - 1)
			$sql = $sql . ",";
		$i++;
	}
	//echo $sql . "<br>";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error" . mysql_errno() . ": " . mysql_error() . " : No se pudo insertar en resultados básicos</b>";
		exit();
	}
}

function ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante) {
	$sql1 = "DELETE FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante'";
	$result1 = mysql_query($sql1);
	
/*	$sql2 = "SELECT numero_telefono_llamado, MIN(idTipoLlamada), SUM(coste), COUNT(numero_telefono_llamado), SUM(duracion) FROM llamadas WHERE idFactura IN (SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante') GROUP BY numero_telefono_llamado ORDER BY SUM(coste) DESC";*/
	$sql2 = "SELECT numero_telefono_llamado, MIN(idTipoLlamada), SUM(llamadas.coste), COUNT(numero_telefono_llamado), SUM(duracion) FROM (llamadas INNER JOIN facturas ON facturas.id=llamadas.idFactura) WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante' GROUP BY numero_telefono_llamado ORDER BY SUM(llamadas.coste) DESC";
	
	$result2 = mysql_query($sql2);
	if ($result2 == 0) {
		echo "<b>Error y" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else {
		$contador_numeros = mysql_num_rows($result2);
		if ($contador_numeros > 0) {
			$sql3 = "INSERT INTO resumen_telefonos (idMiembro, numero_telefono_llamante, numero_telefono_llamado, idTipoLlamada, numero_llamadas, tiempo_llamado, coste) VALUES ";
			for ($i = 0; $i < $contador_numeros; $i++) {
				$row_array2 = mysql_fetch_row($result2);
				if ($row_array2[1] == 6 || $row_array2[1] == 9 || $row_array2[1] == 13 || $row_array2[1] == 16)
					$idtipollamadasimple = 2;
				else if ($row_array2[1] == 5 || $row_array2[1] == 8 ||$row_array2[1] == 12 ||$row_array2[1] == 15)
					$idtipollamadasimple = 3;
				else if ($row_array2[1] == 7 || $row_array2[1] == 10 ||$row_array2[1] == 14 ||$row_array2[1] == 17)
					$idtipollamadasimple = 4;
				else
					$idtipollamadasimple = $row_array2[1];
				$sql3 = $sql3 . "('$idMiembro', '$numero_movil_llamante', '$row_array2[0]', '$idtipollamadasimple', '$row_array2[3]', '$row_array2[4]', '$row_array2[2]')";
				if ($i < $contador_numeros - 1)
					$sql3 = $sql3 . ",";			
			}
			$result3 = mysql_query($sql3);
		}
	}
}


// Devuelve un vector donde cada fila es un contrato
// En cada fila hay una lista con los costes de las facturas
function obtenerCostes($idsFacturas, $numero_movil_llamante) {
	$sql = "SELECT id FROM contratos WHERE descatalogado = 0";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$costes_contrato = obtenerCostesFacturas($idsFacturas, $row_array[0], true, $numero_movil_llamante);
		$costes[$i] = $costes_contrato;
	}
	return $costes;
}

// Devolvemos los
// costes de las facturaa para ese contrato
function obtenerCostesFacturas($idsFacturas, $idContrato, $guardarResultadosDetallados, $numero_movil_llamante) {
	$i = 0;
	foreach ($idsFacturas as $idFactura)
		$costes[$i++] = obtenerCosteFactura($idFactura, $idContrato, $guardarResultadosDetallados, $numero_movil_llamante);
	return $costes;
}

function obtenerCosteFactura($idFactura, $idContrato, $guardarResultadosDetallados, $numero_movil_llamante) {
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
				echo "<b>No hay coste definido para el dia " . $idTipoDia . ", el tipo de llamada " . $idTipoLlamada . " y la franja " . $inicio_llamada_segundos . " en el contrato " . $idContrato . "</b>";
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
	$consumo_minimo = $consumo_minimo * (mb_substr_count($numero_movil_llamante, ",") + 1);
	$cuota_mensual = $cuota_mensual * (mb_substr_count($numero_movil_llamante, ",") + 1);
	$base_consumo_gratis = $base_consumo_gratis * (mb_substr_count($numero_movil_llamante, ",") + 1);
	$consumo_gratis = $consumo_gratis * (mb_substr_count($numero_movil_llamante, ",") + 1);
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
			$sql5 = "DELETE FROM resultados_detallados WHERE idResultadoBasico = '$row_array3[0]'";
			$result5 = mysql_query($sql5);
			if ($result5 == 0) {
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
	$sqlid = "SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato'";
	if (isset($idCompatibilidad))
		$sqlid = $sqlid . " AND idCompatibilidad = '$idCompatibilidad'";
        else
		$sqlid = $sqlid . " AND idCompatibilidad IS NULL";
        //echo $sqlid . "<br>";
	$resultid = mysql_query($sqlid);
	if ($resultid == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_arrayid = mysql_fetch_row($resultid);
	$idrb = $row_arrayid[0];

	$sql = "INSERT INTO resultados_detallados (idLlamada, idResultadoBasico, coste) VALUES ";
	for ($i = 0; $i < $numero_llamadas; $i++) {
		$csl = $coste_simulado_llamada[$i];
		$idl = $idLlamadas[$i];
//		$sql = $sql . "('$idl', (SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato = '$idContrato'";
//		if (empty($idCompatibilidad) == false)
//			$sql = $sql . " AND idCompatibilidad = '$idCompatibilidad'";
//		$sql = $sql . "),'$csl')";
		$sql = $sql . "('$idl', '$idrb', '$csl')";
		if ($i < $numero_llamadas - 1)
			$sql = $sql . ",";
	}
	//echo $sql . "<br>";
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
		echo "<b>Error z" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		if (mysql_num_rows($result) == 0)
			echo "No se encontró un operador asociado al prefijo <b>" . $prefijo . "</b><br>";
		$row_array = mysql_fetch_row($result);
		return $row_array[0];
	}
}

function obtenerTipoDia($fecha) {
	$fecha_hora = date("Y-m-d", strtotime($fecha));	
	$sql = "SELECT calendario.idTipoDia FROM calendario WHERE fecha='$fecha_hora'";
	$result = mysql_query($sql);
	if ($result == 0)
		echo "<b>Error e" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		//echo "Fecha = " . $fecha . " (resultados = " . mysql_num_rows($result) . ")";
		if (mysql_num_rows($result) != 1)
			echo "<b>No puede haber más de un tipo de dia para la fecha " . $fecha . "</b><br>";
		$row_array = mysql_fetch_row($result);
		return $row_array[0];
	}
}

function actualizarEstadisticasBasicas($idMiembro, $telefono, $coste_real, $coste_calculado) {
	$sql0 = "SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$telefono'";
	$result0 = mysql_query($sql0);
	$numero_facturas = mysql_num_rows($result0);
	$fecha = date("Y-m-d H:i:s");
	$sql = "INSERT INTO estadisticas_basicas (idMiembro, telefono, coste_real, coste_calculado, fecha, numero_facturas) VALUES 
											 ('$idMiembro', '$telefono', '$coste_real', '$coste_calculado', '$fecha', '$numero_facturas')";
	$result = mysql_query($sql);
	if ($result == 0) {
		$sql1 = "UPDATE estadisticas_basicas SET fecha = '$fecha', coste_real = '$coste_real', coste_calculado = '$coste_calculado', numero_facturas = '$numero_facturas' WHERE idMiembro = '$idMiembro' AND telefono = '$telefono'";
		$result1 = mysql_query($sql1);
		if ($result1 == 0) {
			// Revisar!!
		}
	}
}

function crearTablaResultadosBasicos($idMiembro, $numero_movil_llamante) {
	// Información básica sobre el mejor contrato y compatibilidad
	$resultados = array();
	$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
			) AND idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1)
			GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) == 0) {
		echo "<br><span class=\"Estilo36\"><b>Deberías recalcular tu informe para el teléfono " . $numero_movil_llamante . "</b></span><br><br>";
        echo "<span class=\"Estilo36\" align=\"center\" valign=\"middle\">Haz clic en el siguiente botón... ";
       	echo "<a href=\"actualizarCalculos.php?Telefono=" . $numero_movil_llamante . "\">";
		echo "<img src=\"imagenesmastreces/contenido/botonRecalcular.gif\" border=\"0\" style=\"cursor:pointer;text-decoration:none\" alt=\"Recalcular informe\" onclick=\"showHideLayers()\"/>";
        echo "</a></span><br/><br/>";
		$resultados[0] = 0;
		$resultados[1] = 0;
		$resultados[2] = 0;
		$resultados[3] = 0;
		return $resultados;
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
		echo "<br>Informe para el teléfono <b>" . $numero_movil_llamante . "</b><br><br>";
	else
		echo "<br>Informe para los teléfonos <b>" . $numero_movil_llamante . "</b><br><br>";
	if ($estimacionAhorroAnualA <= 1)
		echo "<br><b>Ya tienes el mejor contrato y servicios de ahorro posibles... enhorabuena!</b><br><br></span>";
	else {
		$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
		$idMejorOperador = $row_array[2];
		echo "<br>El mejor contrato para tu consumo es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";
		$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$numero_de_servicios_ahorro = mysql_num_rows($result);
		if ($numero_de_servicios_ahorro > 0) 
			echo "Deberías aplicar los siguientes servicios de ahorro:<br><br>";
		for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<b>" . $row_array[1] . "</b> a los teléfonos ";
			$sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejor'";
			$result1 = mysql_query($sql1);
			if ($result1 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$numero_de_telefonos = mysql_num_rows($result1);
			for ($j = 0; $j < $numero_de_telefonos; $j++) {
				$row_array1 = mysql_fetch_row($result1);
				echo "<b>" . $row_array1[0] . "</b>";
				if ($j < $numero_de_telefonos - 1)
					echo ", ";
			}
			echo "<br><br>";
		}	
	
		if ($numero_de_servicios_ahorro > 0) 
			echo "Con este contrato y servicios de ahorro habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";
		else
			echo "Con este contrato habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";

		echo "El ahorro anual estimado sería de <b>" . sprintf("%.2f", $estimacionAhorroAnualA) . " €</b><br><br>";
		echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorro) / $costeTotalReal) . " %</b><br><br>";

		$estimacionAhorroAnualB = 0;
		$idOperadorMiembro = obtenerIdOperadorMiembro($idMiembro, $numero_movil_llamante);
		if ($idOperadorMiembro != $idMejorOperador) {
			$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
					SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
				) AND idContrato IN (
					SELECT id FROM contratos WHERE idOperador = '$idOperadorMiembro'
				)
				GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$row_array = mysql_fetch_row($result);
			$idResultadoBasicoMejorOperadorMiembro = $row_array[0];
			$costeContratoMasServicioAhorro = $row_array[3];
			if ($costeContratoMasServicioAhorro < $costeContratoMasServicioAhorroMejor)
				$costeContratoMasServicioAhorroMejor = $costeContratoMasServicioAhorro;
			$costeTotalReal = obtenerCosteRealFacturas($idMiembro, $numero_movil_llamante);
			$ahorro = $costeTotalReal - $costeContratoMasServicioAhorro;
			$numeroFacturas = obtenerNumeroFacturas($idMiembro, $numero_movil_llamante);
			$estimacionAhorroAnualB = ($ahorro * 12) / $numeroFacturas;
			if ($estimacionAhorroAnualB > 1) {
				echo "<br>";
				$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
				$result = mysql_query($sql);
				if ($result == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				$row_array = mysql_fetch_row($result);
				$idMejorOperador = $row_array[2];
				echo "El mejor contrato para tu consumo de tu propio operador es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";
				$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro' GROUP BY idServicioAhorro";
				$result = mysql_query($sql);
				if ($result == 0) {
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				$numero_de_servicios_ahorro = mysql_num_rows($result);
				if ($numero_de_servicios_ahorro > 0) 
					echo "Deberías aplicar los siguientes servicios de ahorro:<br><br>";
				for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
					$row_array = mysql_fetch_row($result);
					echo "<b>" . $row_array[1] . "</b> a los teléfonos ";
					$sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro'";
					$result1 = mysql_query($sql1);
					if ($result1 == 0) {
						echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
						exit();
					}
					$numero_de_telefonos = mysql_num_rows($result1);
					for ($j = 0; $j < $numero_de_telefonos; $j++) {
						$row_array1 = mysql_fetch_row($result1);
						echo "<b>" . $row_array1[0] . "</b>";
						if ($j < $numero_de_telefonos - 1)
							echo ", ";
					}
					echo "<br><br>";
				}	
	
				if ($numero_de_servicios_ahorro > 0) 
					echo "Con este contrato y servicios de ahorro habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";
				else
					echo "Con este contrato habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";
			
				echo "El ahorro anual estimado sería de <b>" . sprintf("%.2f", $estimacionAhorroAnualB) . " €</b><br><br>";		
				echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorro) / $costeTotalReal) . " %</b><br><br>";
			}
		} 
		echo "</span>";
	}
	actualizarEstadisticasBasicas($idMiembro, $numero_movil_llamante, $costeTotalReal, $costeContratoMasServicioAhorroMejor);

	$resultados[0] = $estimacionAhorroAnualA;
	$resultados[1] = $estimacionAhorroAnualB;
	$resultados[2] = $idResultadoBasicoMejor;
	$resultados[3] = $idResultadoBasicoMejorOperadorMiembro;
	return $resultados;
}

function crearTablaResultadosBasicosRestringida($idMiembro, $numero_movil_llamante) {
	// Información basica sobre el mejor contrato y compatibilidad
	$resultados = array();
	$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
			) AND idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1) GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) == 0) {
		echo "<br><span class=\"Estilo36\"><b>No hay informe que mostrar. Deberías enviar facturas.</b></span><br><br>";
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

function crearTablaResultadosBasicosTPH($idMiembro, $numero_movil_llamante) {
    // Información básica sobre el mejor contrato y compatibilidad
    $resultados = array();
    $sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
                            SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
                    ) AND idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1)
                    GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
    $result = mysql_query($sql);
    if ($result == 0) {
        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
        exit();
    }
    if (mysql_num_rows($result) == 0) {
        echo "<br><span class=\"Estilo36\"><b>Deberías recalcular tu informe para el teléfono " . $numero_movil_llamante . "</b></span><br><br>";
        echo "<span class=\"Estilo36\" align=\"center\" valign=\"middle\">Haz clic en el siguiente botón... ";
       	echo "<a href=\"actualizarCalculos.php?Telefono=" . $numero_movil_llamante . "\">";
        echo "<img src=\"imagenesmastreces/contenido/botonRecalcular.gif\" border=\"0\" style=\"cursor:pointer;text-decoration:none\" alt=\"Recalcular informe\" onclick=\"showHideLayers()\"/>";
        echo "</a></span><br/><br/>";
        $resultados[0] = 0;
        $resultados[1] = 0;
        $resultados[2] = 0;
        $resultados[3] = 0;
        return $resultados;
    }
    $row_array = mysql_fetch_row($result);
    $idResultadoBasicoMejor = $row_array[0];
    $idResultadoBasicoMejorOperadorMiembro = 0;
    $costeContratoMasServicioAhorro = $row_array[3];
    $costeContratoMasServicioAhorroMejor = $costeContratoMasServicioAhorro;
    $costeTotalReal = obtenerCosteRealFacturas($idMiembro, $numero_movil_llamante);
    $ahorroMejor = $costeTotalReal - $costeContratoMasServicioAhorro;
    $numeroFacturas = obtenerNumeroFacturas($idMiembro, $numero_movil_llamante);
    $estimacionAhorroAnualA = ($ahorroMejor * 12) / $numeroFacturas;
    echo "<span class=\"Estilo36\">";
    if (strpos($numero_movil_llamante,",") === false)
        echo "<br>Informe para el teléfono <b>" . $numero_movil_llamante . "</b><br><br>";
    else
        echo "<br>Informe para los teléfonos <b>" . $numero_movil_llamante . "</b><br><br>";
    if ($estimacionAhorroAnualA <= 1)
        echo "<br><b>Ya tienes el mejor contrato y servicios de ahorro posibles... enhorabuena!</b><br><br></span>";
    else {
        $sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
        $result = mysql_query($sql);
        if ($result == 0) {
            echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
            exit();
        }
        $row_array = mysql_fetch_row($result);
        $idMejorOperador = $row_array[2];
        $nombreMejorContrato = $row_array[0];
        $nombreMejorOperador = $row_array[1];
        $idOperadorMiembro = obtenerIdOperadorMiembro($idMiembro, $numero_movil_llamante);
        if ($idOperadorMiembro == $idMejorOperador) {
            echo "<br>El mejor contrato para tu consumo es <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
            $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
            $result = mysql_query($sql);
            if ($result == 0) {
                echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                exit();
            }
            $numero_de_servicios_ahorro = mysql_num_rows($result);
            if ($numero_de_servicios_ahorro > 0) 
                echo "Deberías aplicar los siguientes servicios de ahorro:<br><br>";
            for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                $row_array = mysql_fetch_row($result);
                echo "<b>" . $row_array[1] . "</b> a los teléfonos ";
                $sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejor'";
                $result1 = mysql_query($sql1);
                if ($result1 == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_telefonos = mysql_num_rows($result1);
                for ($j = 0; $j < $numero_de_telefonos; $j++) {
                    $row_array1 = mysql_fetch_row($result1);
                    echo "<b>" . $row_array1[0] . "</b>";
                    if ($j < $numero_de_telefonos - 1)
                        echo ", ";
                }
                echo "<br>";
            }	
            echo "<br>";

            if ($numero_de_servicios_ahorro > 0) 
                echo "Con este contrato y servicios de ahorro habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br><br>";
            else
                echo "Con este contrato habrías ahorrado <b>" . sprintf("%.2f", $ahorroMejor) . " €</b><br><br>";

            echo "El ahorro anual estimado sería de <b>" . sprintf("%.2f", $estimacionAhorroAnualA) . " €</b><br><br>";
            echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorroMejor) / $costeTotalReal) . " %</b><br><br>";
        }
        else {
            // Primero el del propio operador
            $estimacionAhorroAnualB = 0;
            $sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
                            SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
                    ) AND idContrato IN (
                            SELECT id FROM contratos WHERE idOperador = '$idOperadorMiembro'
                    )
                    GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
            $result = mysql_query($sql);
            if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
            }
            $row_array = mysql_fetch_row($result);
            $idResultadoBasicoMejorOperadorMiembro = $row_array[0];
            $costeContratoMasServicioAhorro = $row_array[3];
            if ($costeContratoMasServicioAhorro < $costeContratoMasServicioAhorroMejor)
                $costeContratoMasServicioAhorroMejor = $costeContratoMasServicioAhorro;
            $costeTotalReal = obtenerCosteRealFacturas($idMiembro, $numero_movil_llamante);
            $ahorro = $costeTotalReal - $costeContratoMasServicioAhorro;
            $numeroFacturas = obtenerNumeroFacturas($idMiembro, $numero_movil_llamante);
            $estimacionAhorroAnualB = ($ahorro * 12) / $numeroFacturas;
            if ($estimacionAhorroAnualB > 1) {
                echo "<br>";
                $sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $row_array = mysql_fetch_row($result);
                $idMejorOperador = $row_array[2];
                echo "El mejor contrato para tu consumo <strong style=\"color:#FF0000\">de tu propio operador</strong> es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";
                $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro' GROUP BY idServicioAhorro";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_servicios_ahorro = mysql_num_rows($result);
                if ($numero_de_servicios_ahorro > 0) 
                    echo "Deberías aplicar los siguientes servicios de ahorro:<br><br>";
                for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                    $row_array = mysql_fetch_row($result);
                    echo "<b>" . $row_array[1] . "</b> a los teléfonos ";
                    $sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro'";
                    $result1 = mysql_query($sql1);
                    if ($result1 == 0) {
                        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                        exit();
                    }
                    $numero_de_telefonos = mysql_num_rows($result1);
                    for ($j = 0; $j < $numero_de_telefonos; $j++) {
                        $row_array1 = mysql_fetch_row($result1);
                        echo "<b>" . $row_array1[0] . "</b>";
                        if ($j < $numero_de_telefonos - 1)
                            echo ", ";
                    }
                    echo "<br>";
                }	
                echo "<br>";

                if ($numero_de_servicios_ahorro > 0) 
                    echo "Con este contrato y servicios de ahorro habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br>";
                else
                    echo "Con este contrato habrías ahorrado <b>" . sprintf("%.2f", $ahorro) . " €</b><br>";

                echo "El ahorro anual estimado sería de <b>" . sprintf("%.2f", $estimacionAhorroAnualB) . " €</b><br>";
                echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorro) / $costeTotalReal) . " %</b><br><br>";
                
                // El mejor si es de otro operador
                echo "<span style=\"color:808080\">";
                echo "<br>Existe un contrato mejor para tu consumo: <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
                $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_servicios_ahorro = mysql_num_rows($result);
                if ($numero_de_servicios_ahorro > 0) 
                    echo "Deberías aplicar los siguientes servicios de ahorro:<br><br>";
                for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                    $row_array = mysql_fetch_row($result);
                    echo "<b>" . $row_array[1] . "</b> a los teléfonos ";
                    $sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejor'";
                    $result1 = mysql_query($sql1);
                    if ($result1 == 0) {
                        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                        exit();
                    }
                    $numero_de_telefonos = mysql_num_rows($result1);
                    for ($j = 0; $j < $numero_de_telefonos; $j++) {
                        $row_array1 = mysql_fetch_row($result1);
                        echo "<b>" . $row_array1[0] . "</b>";
                        if ($j < $numero_de_telefonos - 1)
                            echo ", ";
                    }
                    echo "<br>";
                }	
                echo "<br>";

                if ($numero_de_servicios_ahorro > 0) 
                    echo "Con este contrato y servicios de ahorro habrías ahorrado <b>" . sprintf("%.2f", $ahorroMejor) . " €</b><br>";
                else
                    echo "Con este contrato habrías ahorrado <b>" . sprintf("%.2f", $ahorroMejor) . " €</b><br>";

                echo "El ahorro anual estimado sería de <b>" . sprintf("%.2f", $estimacionAhorroAnualA) . " €</b><br>";
                echo "El ahorro sería del <b>" . sprintf("%.2f", (100.0 * $ahorroMejor) / $costeTotalReal) . " %</b><br><br>";
                echo "</span>";
            }
        }
    }
    echo "</span>";
    actualizarEstadisticasBasicas($idMiembro, $numero_movil_llamante, $costeTotalReal, $costeContratoMasServicioAhorroMejor);

    $resultados[0] = $estimacionAhorroAnualA;
    $resultados[1] = $estimacionAhorroAnualB;
    $resultados[2] = $idResultadoBasicoMejor;
    $resultados[3] = $idResultadoBasicoMejorOperadorMiembro;
    return $resultados;
}

function crearTablaResumenTelefonos($idMiembro, $numero_movil_llamante)
{
	echo "<table width=\"100%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\" bordercolor=\"B75B00\">";
	echo "<tr><th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Número de tel&eacute;fono llamado</span></th>";
	echo "<th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">N&uacute;mero llamadas</span></th>";
	echo "<th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Tiempo acumulado</span></th>";
	echo "<th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Coste acumulado</span></th></tr>";
	$sql = "SELECT numero_telefono_llamado, numero_llamadas, tiempo_llamado, coste FROM resumen_telefonos WHERE idMiembro = '$idMiembro' AND numero_telefono_llamante = '$numero_movil_llamante' ORDER BY coste DESC";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error f" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($j = 0; $j < mysql_num_rows($result); $j++) {
		$row_array = mysql_fetch_row($result);
		$horas = (int)($row_array[2] / 3600);
		$minutos = (int)(($row_array[2] - $horas * 3600) / 60);
		$segundos = (int)($row_array[2] - $horas * 3600 - $minutos * 60);
		$tiempoLlamada = sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);  
		echo "<tr align=\"center\" bgcolor=\"#FFE4CA\" class=\"Estilo2\"><td width=\"25%\">". $row_array[0] . "</td>";
		echo "<td width=\"25%\">". $row_array[1] . "</td>";
		echo "<td width=\"25%\">". $tiempoLlamada . "</td>";
		echo "<td width=\"25%\">". sprintf("%.2f", $row_array[3]) . "</td></tr>";
	}
	echo "</table>";	
}

function crearTablaCostesDetallados($idResultadoBasico) 
{
	echo "<table width=\"100%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\" bordercolor=\"B75B00\">";
	echo "<tr><th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Número de tel&eacute;fono llamado</span></th>";
	echo "<th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Duración</span></th>";
	echo "<th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Coste real</span></th>";
	echo "<th width=\"25%\" bgcolor=\"#FFA851\" scope=\"col\"><span class=\"Estilo1\">Coste simulado</span></th></tr>";
	$sql = "SELECT llamadas.numero_telefono_llamado, llamadas.duracion, llamadas.coste, resultados_detallados.coste FROM llamadas, resultados_detallados WHERE llamadas.id = resultados_detallados.idLlamada AND resultados_detallados.idResultadoBasico IN (
				SELECT id FROM resultados_basicos WHERE idContrato = (
					SELECT idContrato FROM resultados_basicos WHERE id = '$idResultadoBasico'
				) AND idCompatibilidad = (
					SELECT idCompatibilidad FROM resultados_basicos WHERE id = '$idResultadoBasico'
				) AND idFactura IN (
					SELECT id FROM facturas WHERE idMiembro = (
						SELECT idMiembro FROM facturas WHERE id = (
							SELECT idFactura FROM resultados_basicos WHERE id = '$idResultadoBasico'
						)
					) AND numero_movil_llamante = (
						SELECT numero_movil_llamante FROM facturas WHERE id = (
							SELECT idFactura FROM resultados_basicos WHERE id = '$idResultadoBasico'
						)
					)
				)
			)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error g" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) == 0) {
		$sql = "SELECT llamadas.numero_telefono_llamado, llamadas.duracion, llamadas.coste, resultados_detallados.coste FROM llamadas, resultados_detallados WHERE llamadas.id = resultados_detallados.idLlamada AND resultados_detallados.idResultadoBasico IN (
					SELECT id FROM resultados_basicos WHERE idContrato = (
						SELECT idContrato FROM resultados_basicos WHERE id = '$idResultadoBasico'
					) AND idFactura IN (
						SELECT id FROM facturas WHERE idMiembro = (
							SELECT idMiembro FROM facturas WHERE id = (
								SELECT idFactura FROM resultados_basicos WHERE id = '$idResultadoBasico'
							)
						) AND numero_movil_llamante = (
							SELECT numero_movil_llamante FROM facturas WHERE id = (
								SELECT idFactura FROM resultados_basicos WHERE id = '$idResultadoBasico'
							)
						)
					)
				) GROUP BY llamadas.id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error h" . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
	for ($j = 0; $j < mysql_num_rows($result); $j++) {
		$row_array = mysql_fetch_row($result);
		echo "<tr align=\"center\" bgcolor=\"#FFE4CA\" class=\"Estilo2\"><td width=\"25%\">". $row_array[0] . "</td>";
		echo "<td width=\"25%\">". $row_array[1] . "</td>";
		echo "<td width=\"25%\">". sprintf("%.2f", $row_array[2]) . "</td>";
		echo "<td width=\"25%\">". sprintf("%.2f", $row_array[3]) . "</td></tr>";
	}
	echo "</table>";	
}

function crearTablaResultadosContratos($idMiembro, $numero_movil_llamante) 
{
	$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);
	$descripciones_facturas = obtenerDescripcionesFacturas($facturas);
	$costes_facturas = obtenerCostesRealesFacturas($facturas);

	// Tabla de costes por contratos sin servicios de ahorro
	$porcentaje_columna = 100 / (count($facturas) + 2);
	echo "<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolor=\"B75B00\">";
	echo "<tr bgcolor=\"#FFA851\">";
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo1\">Contratos</div></td>";
	for ($i = 0; $i < count($facturas); $i++)
	    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo1\">" . $descripciones_facturas[$i] . "</div></td>";
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo1\">Totales</div></td>";
	echo "</tr>";
	echo "<tr bgcolor=\"#FFA851\">";
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo2\">Tu contrato</div></td>";
	$coste_total_fila_real = 0;	
	for ($i = 0; $i < count($facturas); $i++) {
	    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo2\">" . sprintf("%.2f", $costes_facturas[$i]) . "</div></td>";
		$coste_total_fila_real += $costes_facturas[$i];
	}
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo2\">" . sprintf("%.2f", $coste_total_fila_real) . "</div></td>";
	echo "</tr></table><br>";

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" bordercolor=\"FFFFFF\">";
	
	$sql = "SELECT contratos.id, contratos.nombre, operadores.color FROM contratos, operadores WHERE idOperador = operadores.id AND contratos.id NOT IN (SELECT id FROM contratos WHERE descatalogado = 1) GROUP BY contratos.id ORDER BY idOperador";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		echo "<tr bgcolor=\"#" . $row_array[2] . "\">";
	    echo "<td class=\"Estilo4\" width=\"" . $porcentaje_columna . "%\"><div align=\"center\">" . $row_array[1] . "</div></td>";
		$valid_total = 0;
		$coste_total_fila = 0;
		foreach ($facturas as $factura) {
			$sql1 = "SELECT coste, id FROM resultados_basicos WHERE idContrato = '$row_array[0]' AND idFactura = '$factura' ORDER BY id ASC";
			$result1 = mysql_query($sql1);
			if ($result1 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$row_array1 = mysql_fetch_row($result1);
			$costecol = "?";
			if (isset($row_array1[0]))
				$costecol = sprintf("%.2f", $row_array1[0]);
		    echo "<td class=\"Estilo5\" width=\"" . $porcentaje_columna . "%\"><div align=\"center\">" . $costecol . "</div></td>";
			if (isset($row_array1[0])) {
				$coste_total_fila += $row_array1[0];
				$valid_total = 1;
			}
		}
		$costecol = "?";
		if ($valid_total == 1)
			$costecol = sprintf("%.2f", $coste_total_fila);
	    echo "<td class=\"Estilo5\" width=\"" . $porcentaje_columna . "%\"><div align=\"center\">" . $costecol . "</div></td>";
		echo "</tr>";
		
		$colorR = ((hexdec($row_array[2]) >> 16) & 0xFF) / 2;
		$colorG = ((hexdec($row_array[2]) >> 8) & 0xFF) / 2;
		$colorB = (hexdec($row_array[2]) & 0xFF) / 2;
		echo "<tr bgcolor=\"#" . sprintf("%02X%02X%02X", $colorR, $colorG, $colorB) . "\" ";
		echo "height=\"2\"><td height=\"2\" colspan=\"" . (count($facturas) + 2) . "\"></td></tr>";
	}
	echo "</table>";
}

function crearTablaResultadosContratosCompatibilidades($idMiembro, $numero_movil_llamante) 
{
	$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);
	$descripciones_facturas = obtenerDescripcionesFacturas($facturas);
	$costes_facturas = obtenerCostesRealesFacturas($facturas);

	// Tabla de costes por contratos sin servicios de ahorro
	$porcentaje_columna = 100 / (count($facturas) + 2);
	echo "<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolor=\"B75B00\">";
	echo "<tr bgcolor=\"#FFA851\">";
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo1\">Contratos</div></td>";
	for ($i = 0; $i < count($facturas); $i++)
	    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo1\">" . $descripciones_facturas[$i] . "</div></td>";
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo1\">Totales</div></td>";
	echo "</tr>";
	echo "<tr bgcolor=\"#FFA851\">";
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo2\">Tu contrato</div></td>";
	$coste_total_fila_real = 0;	
	for ($i = 0; $i < count($facturas); $i++) {
	    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo2\">" . sprintf("%.2f", $costes_facturas[$i]) . "</div></td>";
		$coste_total_fila_real += $costes_facturas[$i];
	}
    echo "<td width=\"" . $porcentaje_columna . "%\"><div align=\"center\" class=\"Estilo2\">" . sprintf("%.2f", $coste_total_fila_real) . "</div></td>";
	echo "</tr></table><br>";

	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" bordercolor=\"FFFFFF\">";
	$sql = "SELECT contratos.id, contratos.nombre, operadores.color FROM contratos, operadores WHERE idOperador = operadores.id AND contratos.id NOT IN (SELECT id FROM contratos WHERE descatalogado = 1) GROUP BY contratos.id ORDER BY idOperador";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($k = 0; $k < mysql_num_rows($result); $k++) {
		$row_array = mysql_fetch_row($result);
		$idContrato = $row_array[0];
		echo "<tr bgcolor=\"#" . $row_array[2] . "\">";
		$sql2 = "SELECT id, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE idContrato = '$idContrato' AND idFactura IN (
					SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
				) GROUP BY idCompatibilidad ORDER BY SUM(coste) ASC";
		$result2 = mysql_query($sql2);
		if ($result2 == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array2 = mysql_fetch_row($result2);
		$idCompatibilidad = $row_array2[1];

		$textoColumnaContratoCompatibilidad = $row_array[1];		
		$sql3 = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM compatibilidades, servicios_ahorro WHERE compatibilidades.idServicioAhorro = servicios_ahorro.id AND idCompatibilidad = '$idCompatibilidad' AND idContrato = '$idContrato'";
		$result3 = mysql_query($sql3);
		if ($result3 == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$numero_de_servicios_ahorro = mysql_num_rows($result3);
		for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
			$row_array3 = mysql_fetch_row($result3);
			$sql4 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array3[0]' AND idResultadoBasico = '$row_array2[0]'";
			$result4 = mysql_query($sql4);
			if ($result4 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$numero_de_telefonos = mysql_num_rows($result4);
			if ($numero_de_telefonos > 0)
				$textoColumnaContratoCompatibilidad = $textoColumnaContratoCompatibilidad . "<br><b>" . $row_array3[1] . "</b>: ";
			for ($j = 0; $j < $numero_de_telefonos; $j++) {
				$row_array4 = mysql_fetch_row($result4);
				$textoColumnaContratoCompatibilidad = $textoColumnaContratoCompatibilidad . $row_array4[0];
				if ($j < $numero_de_telefonos - 1)
					$textoColumnaContratoCompatibilidad = $textoColumnaContratoCompatibilidad . ", ";
			}
		}
		
	    echo "<td class=\"Estilo5\" width=\"" . $porcentaje_columna . "%\"><div align=\"center\">" . $textoColumnaContratoCompatibilidad . "</div></td>";
		$valid_total = 0;
		foreach ($facturas as $factura) {
			if ($numero_de_servicios_ahorro == 0)
				$sql1 = "SELECT coste FROM resultados_basicos WHERE idContrato = '$idContrato' AND idFactura = '$factura'";
			else
				$sql1 = "SELECT coste FROM resultados_basicos WHERE idContrato = '$idContrato' AND idFactura = '$factura' AND idCompatibilidad = '$idCompatibilidad'";
			$result1 = mysql_query($sql1);
			if ($result1 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$row_array1 = mysql_fetch_row($result1);
			$costecol = "?";
			if (isset($row_array1[0])) {
				$costecol = sprintf("%.2f", $row_array1[0]);
				$valid_total = 1;
			}
		    echo "<td class=\"Estilo5\" width=\"" . $porcentaje_columna . "%\"><div align=\"center\">" . $costecol . "</div></td>";
		}
		$costecol = "?";
		if ($valid_total == 1)
			$costecol = sprintf("%.2f", $row_array2[2]);
	    echo "<td class=\"Estilo5\" width=\"" . $porcentaje_columna . "%\"><div align=\"center\">" . $costecol . "</div></td>";
		echo "</tr>";
		$colorR = ((hexdec($row_array[2]) >> 16) & 0xFF) / 2;
		$colorG = ((hexdec($row_array[2]) >> 8) & 0xFF) / 2;
		$colorB = (hexdec($row_array[2]) & 0xFF) / 2;
		echo "<tr bgcolor=\"#" . sprintf("%02X%02X%02X", $colorR, $colorG, $colorB) . "\" ";
		echo "height=\"2\"><td height=\"2\" colspan=\"" . (count($facturas) + 2) . "\"></td></tr>";
	}

	echo "</table>";
}

function actualizarMovilesDudosos($idTipoLlamada, $idOperador, $idMiembro, $telefono_llamado, $telefono_llamante) {
	if ($idTipoLlamada > 1000 && $idTipoLlamada != 1018) {
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

function obtenerNumeroDeCalculos() {
	$sql = "SELECT id FROM contratos WHERE descatalogado = 0";
	$result = mysql_query($sql);
	if ($result == 0)
		return 1.0;
	$contratos = mysql_num_rows($result);
	$sql = "SELECT id FROM compatibilidades WHERE idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1) GROUP BY idCompatibilidad, idContrato";
	$result = mysql_query($sql);
	if ($result == 0)
		return $contratos;
	return $contratos + mysql_num_rows($result);
}

function obtenerNumeroDeClientesEstadisticas() {
	$sql = "SELECT id FROM estadisticas_basicas";
	$result = mysql_query($sql);
	if ($result == 0)
		return "0.00";	
	return mysql_num_rows($result);
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

function obtenerNumeroDeFacturasEstadisticas() {
	$sql = "SELECT SUM(numero_facturas) FROM estadisticas_basicas";
	$result = mysql_query($sql);
	if ($result == 0)
		return 0;
	if (mysql_num_rows($result) == 0)
		return 0;
	$row_array = mysql_fetch_row($result);
	if (!isset($row_array[0]))
		return 0;
	return $row_array[0];
}

function obtenerNumeroDeFacturasEstadisticasConAhorro() {

	//introduit 13.01.08 per donar coherenica a l'estalvi en % (només factures amb estalvi) i a l'estalvi en euros (el cost mitjà també ha de ser de les factures amb estalvi)
	$sql = "SELECT SUM(numero_facturas) FROM estadisticas_basicas WHERE coste_real > coste_calculado";
	$result = mysql_query($sql);
	if ($result == 0)
		return 0;
	if (mysql_num_rows($result) == 0)
		return 0;
	$row_array = mysql_fetch_row($result);
	if (!isset($row_array[0]))
		return 0;
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

function obtenerCosteMedioFactura() {
	$nFacturas = obtenerNumeroDeFacturasEstadisticas();
	if ($nFacturas == 0)
		return 0.00;
	return obtenerCosteTotal()/$nFacturas;
}

function obtenerCosteMedioAnualPorClienteEuros() {
	$nFacturas = obtenerNumeroDeFacturasEstadisticasConAhorro();
	if ($nFacturas == 0)
		return 0.00;
	return 12.0*(obtenerCosteTotalFacturasConAhorro()/$nFacturas);
}

function obtenerAhorroMedioAnualPorClienteEuros() {
	$nClientes = obtenerNumeroDeClientesEstadisticas();
	if ($nClientes == 0)
		return 0.00;
	return obtenerAhorroAnualEstimado()/$nClientes;
}

function obtenerAhorroMedioEnPorcentaje() {
	$sql = "SELECT SUM(coste_real), SUM(coste_calculado) FROM estadisticas_basicas WHERE coste_real > coste_calculado";
	$result = mysql_query($sql);
	if ($result == 0)
		return "0.00";
	if (mysql_num_rows($result) == 0)
		return "0.00";
	$row_array = mysql_fetch_row($result);
	if ($row_array[0] == 0)
		return "0.00";
	return sprintf("%.2f", (100.0 * ($row_array[0] - $row_array[1])) / $row_array[0]);
	//return sprintf("%.2f", (100.0 * obtenerAhorroMedioAnualPorClienteEuros() / obtenerCosteMedioAnualPorClienteEuros()));
}

function obtenerCosteTotal() {
	$sql = "SELECT SUM(coste_real) FROM estadisticas_basicas";
	$result = mysql_query($sql);
	if ($result == 0)
		return "0.00";
	if (mysql_num_rows($result) == 0)
		return "0.00";
	$row_array = mysql_fetch_row($result);
	return sprintf("%.0f", $row_array[0] - $row_array[1]);
}

function obtenerCosteTotalFacturasConAhorro() {
	$sql = "SELECT SUM(coste_real) FROM estadisticas_basicas WHERE coste_real > coste_calculado";
	$result = mysql_query($sql);
	if ($result == 0)
		return "0.00";
	if (mysql_num_rows($result) == 0)
		return "0.00";
	$row_array = mysql_fetch_row($result);
	return sprintf("%.0f", $row_array[0] - $row_array[1]);
}
function obtenerAhorroTotal() {
	$sql = "SELECT SUM(coste_real), SUM(coste_calculado) FROM estadisticas_basicas WHERE coste_real > coste_calculado";
	$result = mysql_query($sql);
	if ($result == 0)
		return "0.00";
	if (mysql_num_rows($result) == 0)
		return "0.00";
	$row_array = mysql_fetch_row($result);
	return sprintf("%.0f", $row_array[0] - $row_array[1]);
}

function obtenerAhorroAnualEstimado() {
	//primer obtenim el número de facutres amb estalvi: modificació 13.01.08
	$sql = "SELECT SUM(numero_facturas) FROM estadisticas_basicas WHERE coste_real > coste_calculado";
	$result = mysql_query($sql);
	if ($result == 0)
		return 0;
	if (mysql_num_rows($result) == 0)
		return 0;
	$row_array = mysql_fetch_row($result);
	$numeroFacturasConAhorro=$row_array[0];
	$numeroFacturas = obtenerNumeroDeFacturasEstadisticas();
	if ($numeroFacturas == 0)
		return "0.00";
	return sprintf("%.0f", (obtenerNumeroDeClientesEstadisticas() * 12.0 * obtenerAhorroTotal()) / $numeroFacturasConAhorro);
}

function informesActualizados($idMiembro) {
	$sql = "SELECT id FROM resultados_basicos WHERE idFactura IN (SELECT id FROM facturas WHERE idMiembro = (SELECT id FROM miembros WHERE Login = '$idMiembro'))";
	$result = mysql_query($sql);
	$row_array = mysql_fetch_row($result);
	if (mysql_num_rows($result) == 0)
		return false;

	$sql = "SELECT MAX(fecha) FROM contratos";
	$result = mysql_query($sql);
	$row_array = mysql_fetch_row($result);
	$fecha = $row_array[0];
	$sql = "SELECT MAX(fecha) FROM compatibilidades";
	$result = mysql_query($sql);
	$row_array = mysql_fetch_row($result);
	if ($row_array[0] > $fecha)
		$fecha = $row_array[0];
	$sql = "SELECT MAX(fecha) FROM servicios_ahorro";
	$result = mysql_query($sql);
	$row_array = mysql_fetch_row($result);
	if ($row_array[0] > $fecha)
		$fecha = $row_array[0];
	$sql = "SELECT resultados_basicos.id, fecha FROM resultados_basicos WHERE fecha < '$fecha' AND idFactura IN (SELECT id FROM facturas WHERE idMiembro = (SELECT id FROM miembros WHERE Login = '$idMiembro'))";
	$result = mysql_query($sql);
	$row_array = mysql_fetch_row($result);
	if (mysql_num_rows($result) > 0)
		return false;
	return true;	
}

function obtenerListaOperadoras (){
	$sql = "SELECT nombre FROM operadores WHERE id < 90";
	$result = mysql_query ($sql);

	$resultados = array ();
	// El primer resultado es el número de operadoras
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$resultados[$i] = $row_array[0];
	}
	return $resultados;
}

?>