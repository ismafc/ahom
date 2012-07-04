<html>
<head>
<title>Actualizar Ids miembros sueltos!</title>
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

	$sql = "SELECT id FROM errores_proceso_facturas WHERE idMiembro NOT IN (SELECT id FROM miembros)";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "No se puedo acceder a la base de datos!<br />";
		echo "</body></html>";
		exit();
        }
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row_array = mysql_fetch_row($result);
            $sql1 = "UPDATE errores_proceso_facturas SET idMiembro = 3 WHERE id = '$row_array[0]'";
            $result1 = mysql_query($sql1);
        }

	$sql = "SELECT id FROM estadisticas_basicas WHERE idMiembro NOT IN (SELECT id FROM miembros)";
	$result = mysql_query($sql);
	if ($result == 0) {
            echo "No se puedo acceder a la base de datos!<br />";
            echo "</body></html>";
            exit();
        }
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row_array = mysql_fetch_row($result);
            $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 3 WHERE id = '$row_array[0]'";
            $result1 = mysql_query($sql1);
            if ($result1 == 0) {
                $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 4 WHERE id = '$row_array[0]'";
                $result1 = mysql_query($sql1);
                if ($result1 == 0) {
                    $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 5 WHERE id = '$row_array[0]'";
                    $result1 = mysql_query($sql1);
                    if ($result1 == 0) {
                        $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 6 WHERE id = '$row_array[0]'";
                        $result1 = mysql_query($sql1);
                        if ($result1 == 0) {
                            $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 7 WHERE id = '$row_array[0]'";
                            $result1 = mysql_query($sql1);
                            if ($result1 == 0) {
                                $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 8 WHERE id = '$row_array[0]'";
                                $result1 = mysql_query($sql1);
                                if ($result1 == 0) {
                                    $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 9 WHERE id = '$row_array[0]'";
                                    $result1 = mysql_query($sql1);
                                    if ($result1 == 0) {
                                        $sql1 = "UPDATE estadisticas_basicas SET idMiembro = 10 WHERE id = '$row_array[0]'";
                                        $result1 = mysql_query($sql1);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

	$sql = "SELECT id FROM moviles_dudosos WHERE idMiembro NOT IN (SELECT id FROM miembros)";
	$result = mysql_query($sql);
	if ($result == 0) {
            echo "No se puedo acceder a la base de datos!<br />";
            echo "</body></html>";
            exit();
        }
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row_array = mysql_fetch_row($result);
            $sql1 = "UPDATE moviles_dudosos SET idMiembro = 3 WHERE id = '$row_array[0]'";
            $result1 = mysql_query($sql1);
            if ($result1 == 0) {
                $sql1 = "UPDATE moviles_dudosos SET idMiembro = 4 WHERE id = '$row_array[0]'";
                $result1 = mysql_query($sql1);
                if ($result1 == 0) {
                    $sql1 = "UPDATE moviles_dudosos SET idMiembro = 5 WHERE id = '$row_array[0]'";
                    $result1 = mysql_query($sql1);
                    if ($result1 == 0) {
                        $sql1 = "UPDATE moviles_dudosos SET idMiembro = 6 WHERE id = '$row_array[0]'";
                        $result1 = mysql_query($sql1);
                        if ($result1 == 0) {
                            $sql1 = "UPDATE moviles_dudosos SET idMiembro = 7 WHERE id = '$row_array[0]'";
                            $result1 = mysql_query($sql1);
                            if ($result1 == 0) {
                                $sql1 = "UPDATE moviles_dudosos SET idMiembro = 8 WHERE id = '$row_array[0]'";
                                $result1 = mysql_query($sql1);
                                if ($result1 == 0) {
                                    $sql1 = "UPDATE moviles_dudosos SET idMiembro = 9 WHERE id = '$row_array[0]'";
                                    $result1 = mysql_query($sql1);
                                    if ($result1 == 0) {
                                        $sql1 = "UPDATE moviles_dudosos SET idMiembro = 10 WHERE id = '$row_array[0]'";
                                        $result1 = mysql_query($sql1);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

/*
	$sql = "SELECT idMiembro, numero_movil_llamante FROM facturas GROUP BY numero_movil_llamante";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	
	for ($i = 0; $i < mysql_num_rows($result); $i++) {		
		$row_array = mysql_fetch_row($result);
//		if ($i < 700)
//			continue;
//		if ($i >= 900)
//			break;
		$idMiembro = $row_array[0];
		$numero_movil_llamante = $row_array[1];
		
		echo $idMiembro . " - " . $numero_movil_llamante . "<br>";
		$sql1 = "SELECT id, idContrato FROM resultados_basicos WHERE idFactura IN (SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante') GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
		$result1 = mysql_query($sql1);
		if ($result1 == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array1 = mysql_fetch_row($result1);		
		$idResultadoBasicoMejor = $row_array1[0];
		$idContrato = $row_array1[1];
		//echo $idResultadoBasicoMejor . " - " . $idContrato . " -> " . mysql_num_rows($result1) . "<br>";
		$idResultadoBasicoMejorOperadorMiembro = 0;
		
		$sqlx = "SELECT operadores.id FROM contratos, operadores WHERE contratos.id = '$idContrato' AND contratos.idOperador = operadores.id";
		$resultx = mysql_query($sqlx);
		if ($resultx == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_arrayx = mysql_fetch_row($resultx);
		$idMejorOperador = $row_arrayx[0];
		$idOperadorMiembro = obtenerIdOperadorMiembro($idMiembro, $numero_movil_llamante);
		//echo $idMejorOperador . " - " . $idOperadorMiembro . "<br>";
		
		if ($idOperadorMiembro != $idMejorOperador) {
			$sql2 = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE idFactura IN (
				 	 SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
				) AND idContrato IN (
					SELECT id FROM contratos WHERE idOperador = '$idOperadorMiembro'
				)
				GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
			$result2 = mysql_query($sql2);
			if ($result2 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$row_array2 = mysql_fetch_row($result2);
			$idResultadoBasicoMejorOperadorMiembro = $row_array2[0];
			//echo $idResultadoBasicoMejorOperadorMiembro . "<br>";
		}
		
		// Quitarlos todos menos los encontrados
		$sqla = "SELECT id, idContrato FROM resultados_basicos WHERE idFactura IN (SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante')";
		$resulta = mysql_query($sqla);
		if ($resulta == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$idContratoMejor = 0;
		$idContratoMejorOperadorMiembro = 0;
		for ($j = 0; $j < mysql_num_rows($resulta); $j++) {		
			$row_arraya = mysql_fetch_row($resulta);
			if ($row_arraya[0] == $idResultadoBasicoMejor) {
				$idContratoMejor = $row_arraya[1];
				continue;
			}
			else if ($row_arraya[0] == $idResultadoBasicoMejorOperadorMiembro) {
				$idContratoMejorOperadorMiembro = $row_arraya[1];
				continue;
			}
			else if ($idContratoMejor == $row_arraya[1] || $idContratoMejorOperadorMiembro == $row_arraya[1])
				continue;
			else if ($idContratoMejor != $row_arraya[1] && $idContratoMejor != 0)
				$idContratoMejor = 0;
			else if ($idContratoMejorOperadorMiembro != $row_arraya[1] && $idContratoMejorOperadorMiembro != 0)
				$idContratoMejorOperadorMiembro = 0;
			//echo "O = " . $row_arraya[0] . " - " . $row_arraya[1] . "<br>";
			$sqlDEL = "DELETE FROM resultados_detallados WHERE idResultadoBasico ='$row_arraya[0]'";
			$resultDEL = mysql_query($sqlDEL);
			if ($resultDEL == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
		}			
	}
*/	
	echo "Ids miembros actualizados!";
?>
</body>
</html>