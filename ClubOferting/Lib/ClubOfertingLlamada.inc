<?php

// Devolvemos un array que contiene los ids de todos los contratos ordenados por operador
function obtenerContratosClubOferting() {
	$sql = "SELECT id FROM contratos WHERE descatalogado = 0 AND cuota_mensual = 0 AND consumo_minimo < 20 ORDER BY idOperador";
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
    
// Devuelve un vector donde cada fila es un contrato
// En cada fila hay una lista con los costes de las facturas
function obtenerCostesClubOferting($idsFacturas, $numero_movil_llamante) {
	$sql = "SELECT id FROM contratos WHERE descatalogado = 0 AND cuota_mensual = 0 AND consumo_minimo < 20";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$costes_contrato = obtenerCostesFacturasClubOferting($idsFacturas, $row_array[0], $numero_movil_llamante);
		$costes[$i] = $costes_contrato;
	}
	return $costes;
}

// Devolvemos los
// costes de las facturaa para ese contrato
function obtenerCostesFacturasClubOferting($idsFacturas, $idContrato, $numero_movil_llamante) {
	$i = 0;
	foreach ($idsFacturas as $idFactura)
		$costes[$i++] = obtenerCosteFacturaClubOferting($idFactura, $idContrato, $numero_movil_llamante);
	return $costes;
}

function obtenerCosteFacturaClubOferting($idFactura, $idContrato, $numero_movil_llamante) {
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
					$coste_simulado_llamada[$i] = $coste_simulado_llamada[$i] + $establecimiento_llamada;
				}
				else if ($duracion_calculo <= $intervalo_hasta) {
					$coste_simulado_llamada[$i] += ($duracion_calculo - $intervalo_desde) * $coste_contrato;
					$coste_simulado_llamada[$i] = $coste_simulado_llamada[$i] + $establecimiento_llamada;
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
        guardarResultadosDetallados($idLlamadas, $coste_simulado_llamada, $numero_llamadas, $idFactura, $idContrato);
	return $coste_total_calculado;
}
    
function AplicarServiciosAhorroALlamadasSeleccionadasClubOferting($idFactura, $idContrato, $idCompatibilidad, $guardarResultadosDetallados, $numero_movil_llamante) {
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

	$coste_total_calculado *= 1.16;
        //echo "Coste SA : " . $coste_total_calculado . "<br>";
	
	if ($coste_total_calculado > 0) {
		$fecha = date("Y-m-d H:i:s");
                //$sql2 = "INSERT INTO resultados_basicos (idFactura, idContrato, fecha, coste, idCompatibilidad) VALUES ('$idFactura', '$idContrato', '$fecha', '$coste_total_calculado')";
		$sql2 = "UPDATE resultados_basicos SET fecha = '$fecha', coste = '$coste_total_calculado' WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'";
                //echo $sql2 . "<br>";
		$result2 = mysql_query($sql2);
		if ($result2 == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}
}

function crearTablaResultadosLlamadaServiciosAhorroClubOferting ($idResultadoBasico, $coste){
	// Servicios de ahorro
	$sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasico' GROUP BY idServicioAhorro";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}

	$numero_de_servicios_ahorro = mysql_num_rows($result);
	if ($numero_de_servicios_ahorro > 0){
		?>
		<p>Aplicando el siguiente servicios de ahorro al teléfono llamado el coste sería de: <strong style="font-size:120%;"><?php echo sprintf("%.2f", $coste) . " €"?></strong></p>
		<?php
		for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
			$row_array = mysql_fetch_row($result);
			?>
			<p style="padding-left: 20px;"><strong><?php echo $row_array[1] ?></strong></p>
			<?php
		}
	}
	else{
		?>
		<p>El coste sería de: <strong style="font-size:120%;"><?php echo sprintf("%.2f", $coste) . " €"?></strong></p>
		<?php
	}
}

function crearTablaResultadosBasicosLlamadaClubOferting($idMiembro, $numero_movil_llamante) {
//     Información básica sobre el mejor contrato y compatibilidad
    $sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
                          SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
                    ) AND idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1)
                    GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";

/*	$sql = "SELECT resultados_basicos.id, resultados_basicos.idContrato, resultados_basicos.idCompatibilidad, SUM(resultados_basicos.coste)
			FROM (resultados_basicos INNER JOIN facturas ON facturas.id = resultados_basicos.idFactura)
			INNER JOIN contratos ON resultados_basicos.idContrato = contratos.id
			WHERE facturas.idMiembro = '$idMiembro' AND facturas.numero_movil_llamante = '$numero_movil_llamante' AND contratos.descatalogado != 1 AND resultados_basicos.coste IS NOT NULL
			GROUP BY idContrato, idCompatibilidad ORDER BY SUM(resultados_basicos.coste) ASC";
*/
    $result = mysql_query($sql);
    if ($result == 0) {
        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
        exit();
    }
    if (mysql_num_rows($result) == 0) {
        echo "<br><span class=\"Estilo36\"><b>Lo sentimos, no hemos podido calcular el mejor contrato para la llamada...</b></span><br><br>";
        return 0;
    }

	$row_array = mysql_fetch_row($result);
    $idResultadoBasicoMejor = $row_array[0];
    $costeContratoMasServicioAhorro = $row_array[3];

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

	if ($idOperadorMiembro != $idMejorOperador){
		// Primero el del propio operador
		$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
				) AND idContrato IN (
				SELECT id FROM contratos WHERE idOperador = '$idOperadorMiembro'
				)
				GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
/*
		$sql = "SELECT resultados_basicos.id, resultados_basicos.idContrato, resultados_basicos.idCompatibilidad, SUM(resultados_basicos.coste)
				FROM (resultados_basicos INNER JOIN facturas ON facturas.id = resultados_basicos.idFactura)
				INNER JOIN contratos ON resultados_basicos.idContrato = contratos.id
				WHERE facturas.idMiembro = '$idMiembro' AND facturas.numero_movil_llamante = '$numero_movil_llamante'
				AND contratos.descatalogado != 1 AND resultados_basicos.coste IS NOT NULL AND contratos.idOperador = '$idOperadorMiembro'
				GROUP BY idContrato, idCompatibilidad ORDER BY SUM(resultados_basicos.coste) ASC";
*/
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
		$idResultadoBasicoMejorOperadorMiembro = $row_array[0];
		$costeContratoMasServicioAhorroOperadorMiembro = $row_array[3];
		$sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
//		echo "<span class=\"Estilo36\">";
//		echo "<br>";
//		echo "El mejor contrato para la llamada <strong style=\"color:#FF0000\">de tu propio operador</strong> es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";

		// Servicios de ahorro
//		crearTablaResultadosLlamadaServiciosAhorroClubOferting ($idResultadoBasicoMejorOperadorMiembro, $costeContratoMasServicioAhorroOperadorMiembro);

//		echo "</span>";

		?>
		<tr>
          <td colspan="3" class="texto">
			<p>El mejor contrato para la llamada de tu propio operador es <strong style="color:#EB7D18;"><?php echo $row_array[0]." (".$row_array[1].")";?></strong>.</p>
			<?php crearTablaResultadosLlamadaServiciosAhorroClubOferting ($idResultadoBasicoMejorOperadorMiembro, $costeContratoMasServicioAhorroOperadorMiembro); ?>
		  </td>
        </tr>
            <tr><td colspan="3" style="height:20px"></td></tr>
		<?php

	}

 ?>
	<tr>
	<?php
	if ($idOperadorMiembro == $idMejorOperador) {
		?>
		<td colspan="3" class="texto">
			<p>El mejor contrato para tu consumo es <strong style="color:#EB7D18;"><?php echo $nombreMejorContrato." (".$nombreMejorOperador.")";?></strong>.</p>
		<?php
	}else{
		?>
		<td colspan="3" bgcolor="#F2F2F2" class="texto" style="border: 1px solid; padding: 10px;">
			<p>Existe un contrato mejor para tu llamada: <strong style="color:#EB7D18;"><?php echo $nombreMejorContrato." (".$nombreMejorOperador.")";?></strong>.</p>
		<?php
	}
	crearTablaResultadosLlamadaServiciosAhorroClubOferting ($idResultadoBasicoMejor, $costeContratoMasServicioAhorro);
	?>
	</td>
	</tr>
<?php
//	echo "<span class=\"Estilo36\">";
//		echo "<br>";
//		echo "<br>El mejor contrato es <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
//	}else{
//		echo "<span style=\"color:A0A0A0\">";
//		echo "<br>";
//		echo "<br>Existe un contrato mejor para tu consumo: <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
//	}

//	crearTablaResultadosLlamadaServiciosAhorroClubOferting ($idResultadoBasicoMejor, $costeContratoMasServicioAhorro);

//	echo "</span>";
}

/*
function crearTablaResultadosBasicosLlamadaClubOferting($idMiembro, $numero_movil_llamante) {
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
        echo "<br><span class=\"glosario\"><b>Lo sentimos, no hemos podido calcular el mejor contrato para la llamada...</b></span><br><br>";
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
//    $numeroFacturas = obtenerNumeroFacturas($idMiembro, $numero_movil_llamante);
//    $estimacionAhorroAnualA = ($ahorroMejor * 12) / $numeroFacturas;
    echo "<span class=\"glosario\">";

//	if ($estimacionAhorroAnualA <= 1)
//        echo "<br><b>Ya tienes el mejor contrato y servicios de ahorro posibles... enhorabuena!</b><br><br></span>";
//    else {
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
            echo "<br>El mejor contrato para la llamada es <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
            $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
            $result = mysql_query($sql);
            if ($result == 0) {
                echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                exit();
            }
            $numero_de_servicios_ahorro = mysql_num_rows($result);
            if ($numero_de_servicios_ahorro > 0)
                echo "Aplicando los siguientes servicios de ahorro al teléfono llamado:<br><br>";
            for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                $row_array = mysql_fetch_row($result);
                echo "<b>" . $row_array[1] . "</b> ";
				echo "<br>";
            }
			echo "<br>";
            if ($numero_de_servicios_ahorro > 0)
                echo "Con este contrato y servicios de ahorro el coste de la llamada sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br><br>";
            else
                echo "Con este contrato el coste de la llamada sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br><br>";
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
                echo "<br>";
                $sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $row_array = mysql_fetch_row($result);
                $idMejorOperador = $row_array[2];
                echo "El mejor contrato para la llamada <strong style=\"color:#FF0000\">de tu propio operador</strong> es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";
                $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro' GROUP BY idServicioAhorro";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_servicios_ahorro = mysql_num_rows($result);
                if ($numero_de_servicios_ahorro > 0)
                    echo "Aplicando los siguientes servicios de ahorro al teléfono llamado:<br><br>";
                for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                    $row_array = mysql_fetch_row($result);
                    echo "<b>" . $row_array[1] . "</b>";// a los teléfonos ";
					echo "<br>";
                }
                echo ("<br>");
                if ($numero_de_servicios_ahorro > 0)
                    echo "Con este contrato y servicios de ahorro el coste de la llamada sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br>";
                else
                    echo "Con este contrato el coste de la llamada sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br>";

                // El mejor si es de otro operador
                echo "<span style=\"color:A0A0A0\">";
                echo "<br><br>Existe un contrato mejor para tu consumo: <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
                $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_servicios_ahorro = mysql_num_rows($result);
                if ($numero_de_servicios_ahorro > 0)
                    echo "Aplicando los siguientes servicios de ahorro al teléfono llamado:<br><br>";
                for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                    $row_array = mysql_fetch_row($result);
                    echo "<b>" . $row_array[1] . "</b>";
					echo "<br>";
                }
				echo "<br>";
                if ($numero_de_servicios_ahorro > 0)
                    echo "Con este contrato y servicios de ahorro el coste de la llamada sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorroMejor) . " €</b><br>";
                else
                    echo "Con este contrato el coste de la llamada sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorroMejor) . " €</b><br>";

				echo "<br>";
                echo "</span>";
            //}
        }
//    }
    echo "</span>";
//    actualizarEstadisticasBasicas($idMiembro, $numero_movil_llamante, $costeTotalReal, $costeContratoMasServicioAhorroMejor);

    $resultados[0] = $estimacionAhorroAnualA;
    $resultados[1] = $estimacionAhorroAnualB;
    $resultados[2] = $idResultadoBasicoMejor;
    $resultados[3] = $idResultadoBasicoMejorOperadorMiembro;
    return $resultados;
}
*/

?>