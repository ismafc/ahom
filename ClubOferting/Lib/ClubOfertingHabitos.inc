<?php
function crearTablaResultadosHabitosServiciosAhorroClubOferting ($idResultadoBasico, $coste){
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
		<p>Aplicando los siguientes servicios de ahorro el coste sería de: <strong style="font-size:120%;"><?php echo sprintf("%.2f", $coste) . " €"?></strong></p>
		<?php
		for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
			$row_array = mysql_fetch_row($result);
			?>
			<p style="padding-left: 20px;"><strong><?php echo $row_array[1] ?></strong>
			<?php

			$sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasico'";
			$result1 = mysql_query($sql1);
			if ($result1 == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$numero_de_telefonos = mysql_num_rows($result1);
			if ($numero_de_telefonos == 1)
				echo " al teléfono que más llame";
			else if ($numero_de_telefonos > 1)
				echo " a los ".$numero_de_telefonos." teléfonos que más llame";
			?>
			</p>
			<?php
		}
	}
	else{
		?>
		<p>El coste sería de: <strong style="font-size:120%;"><?php echo sprintf("%.2f", $coste) . " €"?></strong></p>
		<?php
	}

}


function crearTablaResultadosHabitosClubOferting($idMiembro, $numero_movil_llamante) {
//     Información básica sobre el mejor contrato y compatibilidad
/*    $sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
                          SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
                    ) AND idContrato NOT IN (SELECT id FROM contratos WHERE descatalogado = 1)
                    GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";*/

	$sql = "SELECT resultados_basicos.id, resultados_basicos.idContrato, resultados_basicos.idCompatibilidad, SUM(resultados_basicos.coste)
			FROM (resultados_basicos INNER JOIN facturas ON facturas.id = resultados_basicos.idFactura)
			INNER JOIN contratos ON resultados_basicos.idContrato = contratos.id
			WHERE facturas.idMiembro = '$idMiembro' AND facturas.numero_movil_llamante = '$numero_movil_llamante' AND contratos.descatalogado != 1 AND resultados_basicos.coste IS NOT NULL
			GROUP BY idContrato, idCompatibilidad ORDER BY SUM(resultados_basicos.coste) ASC";

    $result = mysql_query($sql);
    if ($result == 0) {
        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
        exit();
    }
    if (mysql_num_rows($result) == 0) {
        echo "<br><span class=\"Estilo36\"><b>Lo sentimos, no hemos podido calcular el mejor contrato para sus hábitos de consumo...</b></span><br><br>";
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
/*		$sql = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE coste IS NOT NULL AND idFactura IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
				) AND idContrato IN (
				SELECT id FROM contratos WHERE idOperador = '$idOperadorMiembro'
				)
				GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";*/

		$sql = "SELECT resultados_basicos.id, resultados_basicos.idContrato, resultados_basicos.idCompatibilidad, SUM(resultados_basicos.coste)
				FROM (resultados_basicos INNER JOIN facturas ON facturas.id = resultados_basicos.idFactura)
				INNER JOIN contratos ON resultados_basicos.idContrato = contratos.id
				WHERE facturas.idMiembro = '$idMiembro' AND facturas.numero_movil_llamante = '$numero_movil_llamante'
				AND contratos.descatalogado != 1 AND resultados_basicos.coste IS NOT NULL AND contratos.idOperador = '$idOperadorMiembro'
				GROUP BY idContrato, idCompatibilidad ORDER BY SUM(resultados_basicos.coste) ASC";

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
		//echo "<span class=\"Estilo36\">";
		//echo "<br>";
		//echo "El mejor contrato <strong style=\"color:#FF0000\">de tu propio operador</strong> es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";

		// Servicios de ahorro
		//crearTablaResultadosHabitosServiciosAhorroClubOferting ($idResultadoBasicoMejorOperadorMiembro, $costeContratoMasServicioAhorroOperadorMiembro);

		//echo "</span>";
				?>
		<tr>
          <td colspan="3" class="texto">
			<p>El mejor contrato de tu propio operador es <strong style="color:#EB7D18;"><?php echo $row_array[0]." (".$row_array[1].")";?></strong>.</p>
			<?php crearTablaResultadosHabitosServiciosAhorroClubOferting ($idResultadoBasicoMejorOperadorMiembro, $costeContratoMasServicioAhorroOperadorMiembro); ?>
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
			<p>El mejor contrato es <strong style="color:#EB7D18;"><?php echo $nombreMejorContrato." (".$nombreMejorOperador.")";?></strong>.</p>
		<?php
	}else{
		?>
		<td colspan="3" bgcolor="#F2F2F2" class="texto" style="border: 1px solid; padding: 10px;">
			<p>Existe un contrato mejor para tu consumo: <strong style="color:##EB7D18;"><?php echo $nombreMejorContrato." (".$nombreMejorOperador.")";?></strong>.</p>
		<?php
	}
	crearTablaResultadosHabitosServiciosAhorroClubOferting ($idResultadoBasicoMejor, $costeContratoMasServicioAhorro);
	?>
	</td>
	</tr>
<?php
//	if ($idOperadorMiembro == $idMejorOperador) {
//		echo "<span class=\"Estilo36\">";
//		echo "<br>";
//		echo "<br>El mejor contrato es <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
//	}else{
//		echo "<span style=\"color:A0A0A0\">";
//		echo "<br>";
//		echo "<br>Existe un contrato mejor para tu consumo: <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
//	}

//	crearTablaResultadosHabitosServiciosAhorroClubOferting ($idResultadoBasicoMejor, $costeContratoMasServicioAhorro);

//	echo "</span>";
}
/*
 function crearTablaResultadosHabitosClubOferting($idMiembro, $numero_movil_llamante) {
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
        echo "<br><span class=\"Estilo36\"><b>Lo sentimos, no hemos podido calcular el mejor contrato para la llamada...</b></span><br><br>";
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
    echo "<span class=\"Estilo36\">";

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
            echo "<br>El mejor contrato es <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
            $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
            $result = mysql_query($sql);
            if ($result == 0) {
                echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                exit();
            }
            $numero_de_servicios_ahorro = mysql_num_rows($result);
            if ($numero_de_servicios_ahorro > 0)
                echo "Aplicando los siguientes servicios de ahorro:<br><br>";
            for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                $row_array = mysql_fetch_row($result);
                echo "<b>" . $row_array[1] . "</b> ";
                $sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejor'";
                $result1 = mysql_query($sql1);
                if ($result1 == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_telefonos = mysql_num_rows($result1);
				if ($numero_de_telefonos == 1)
					echo "al teléfono que más llame";
				else if ($numero_de_telefonos > 1)
					echo "a los ".$numero_de_telefonos." teléfonos que más llame";
                echo "<br>";
            }

           echo "<br>";
           if ($numero_de_servicios_ahorro > 0)
                echo "Con este contrato y servicios de ahorro el coste mensual sería de<b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br><br>";
            else
                echo "Con este contrato el coste mensual sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br><br>";
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
//            if ($costeContratoMasServicioAhorro < $costeContratoMasServicioAhorroMejor)
  //              $costeContratoMasServicioAhorroMejor = $costeContratoMasServicioAhorro;
    //        $costeTotalReal = obtenerCosteRealFacturas($idMiembro, $numero_movil_llamante);
      //      $ahorro = $costeTotalReal - $costeContratoMasServicioAhorro;
        //    $numeroFacturas = obtenerNumeroFacturas($idMiembro, $numero_movil_llamante);
          //  $estimacionAhorroAnualB = ($ahorro * 12) / $numeroFacturas;
            //if ($estimacionAhorroAnualB > 1) {
                echo "<br>";
                $sql = "SELECT contratos.nombre, operadores.nombre, operadores.id FROM contratos, operadores WHERE contratos.id = '$row_array[1]' AND contratos.idOperador = operadores.id";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $row_array = mysql_fetch_row($result);
                $idMejorOperador = $row_array[2];
                echo "El mejor contrato <strong style=\"color:#FF0000\">de tu propio operador</strong> es <b>" . $row_array[0] . "</b> (<b>" . $row_array[1] . "</b>)<br><br>";
                $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro' GROUP BY idServicioAhorro";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_servicios_ahorro = mysql_num_rows($result);
                if ($numero_de_servicios_ahorro > 0)
                    echo "Aplicando los siguientes servicios de ahorro:<br><br>";
                for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                    $row_array = mysql_fetch_row($result);
                    echo "<b>" . $row_array[1] . "</b> ";
                    $sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejorOperadorMiembro'";
                    $result1 = mysql_query($sql1);
                    if ($result1 == 0) {
                        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                        exit();
                    }
                    $numero_de_telefonos = mysql_num_rows($result1);
					if ($numero_de_telefonos == 1)
						echo "al teléfono que más llame";
					else if ($numero_de_telefonos > 1)
						echo "a los ".$numero_de_telefonos." teléfonos que más llame";
                    echo "<br>";
                }
                echo "<br>";
                if ($numero_de_servicios_ahorro > 0)
                    echo "Con este contrato y servicios de ahorro el coste mensual sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br>";
                else
                    echo "Con este contrato el coste mensual sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorro) . " €</b><br>";

                // El mejor si es de otro operador
                echo "<span style=\"color:A0A0A0\">";
                echo "<br>Existe un contrato mejor para tu consumo: <b>" . $nombreMejorContrato . "</b> (<b>" . $nombreMejorOperador . "</b>)<br><br>";
                $sql = "SELECT idServicioAhorro, servicios_ahorro.nombre FROM servicios_ahorro, resultados_numeros_servicios_ahorro WHERE resultados_numeros_servicios_ahorro.idServicioAhorro = servicios_ahorro.id AND idResultadoBasico = '$idResultadoBasicoMejor' GROUP BY idServicioAhorro";
                $result = mysql_query($sql);
                if ($result == 0) {
                    echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                    exit();
                }
                $numero_de_servicios_ahorro = mysql_num_rows($result);
                if ($numero_de_servicios_ahorro > 0)
                    echo "Aplicando los siguientes servicios de ahorro:<br><br>";
                for ($i = 0; $i < $numero_de_servicios_ahorro; $i++) {
                    $row_array = mysql_fetch_row($result);
                    echo "<b>" . $row_array[1] . "</b> ";
                    $sql1 = "SELECT numero_telefono FROM resultados_numeros_servicios_ahorro WHERE idServicioAhorro = '$row_array[0]' AND idResultadoBasico = '$idResultadoBasicoMejor'";
                    $result1 = mysql_query($sql1);
                    if ($result1 == 0) {
                        echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
                        exit();
                    }
                    $numero_de_telefonos = mysql_num_rows($result1);
					if ($numero_de_telefonos == 1)
						echo "al teléfono que más llame";
					else if ($numero_de_telefonos > 1)
						echo "a los ".$numero_de_telefonos." teléfonos que más llame";
                    echo "<br>";
                }

				echo "<br>";
                if ($numero_de_servicios_ahorro > 0)
                    echo "Con este contrato y servicios de ahorro el coste mensual sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorroMejor) . " €</b><br>";
                else
                    echo "Con este contrato el coste mensual sería de <b>" . sprintf("%.2f", $costeContratoMasServicioAhorroMejor) . " €</b><br>";

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