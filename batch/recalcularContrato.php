<html>
<head>
    <title>Recalcular un contrato</title>
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

    $contrato = $_GET["contrato"];
    if (!isset($contrato))
        $contrato = 75;
    $from = $_GET["from"];
    if (!isset($from))
        $from = 0;
    $to = $_GET["to"];
    $servicios_ahorro = 0;
    if (isset($_GET["servicios_ahorro"]))
        $servicios_ahorro = $_GET["servicios_ahorro"];
    echo "Contrato = " . $contrato . "<br>";
    echo "Desde = " . $from . "<br>";
    echo "Recalcular servicios de ahorro = " . $servicios_ahorro . "<br>";

    $sql = "SELECT idMiembro, numero_movil_llamante FROM facturas WHERE id IN (SELECT idFactura FROM resultados_basicos WHERE idContrato='$contrato') GROUP BY idMiembro, numero_movil_llamante";
    $result = mysql_query($sql);
    if ($result == 0) {
        echo "Error en la consulta con el contrato " . $contrato;
        echo "</body></html>";
        exit();
    }	
    if (!isset($to))
        $to = mysql_num_rows($result) - 1;
    echo "Hasta = " . $to . "<br>";
    for ($i = 0; $i < mysql_num_rows($result); $i++) {
        $row_array = mysql_fetch_row($result);
        if ($i >= $from && $i <= $to) {
            $idMiembro = $row_array[0];
            $numero_movil_llamante = $row_array[1];

            echo "idMiembro = " . $idMiembro . "; numero_telefono_llamante = " . $numero_movil_llamante;
            $facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);
            echo " -> " . count($facturas) . " facturas<br>";
            // Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
            $costes_contrato = obtenerCostesFacturas($facturas, $contrato, true, $numero_movil_llamante);
            //$costes = obtenerCostes($facturas, $numero_movil_llamante);

            if ($servicios_ahorro == 1) {
                // Ahora los servicios de ahorro
                $idsCompatibilidades = ObtenerCompatibilidades($contrato);
                if (empty($idsCompatibilidades) == false) {
                    foreach ($idsCompatibilidades as $idCompatibilidad) {
                        ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante);
                        $idsServiciosAhorro = ObtenerServiciosAhorro($idCompatibilidad, $contrato);
                        GenerarResultadosBasicosServiciosAhorro($facturas, $contrato, $idCompatibilidad);
                        foreach ($idsServiciosAhorro as $idServicioAhorro) {
                            echo "Servicio de ahorro " . $idServicioAhorro . " de la Compatibilidad " . $idCompatibilidad . "<br>";
                            $telefonos = ObtenerTelefonos($idServicioAhorro, $idMiembro, $numero_movil_llamante);
                            if (count($telefonos) > 0) {
                                GenerarResultadosNumerosServiciosAhorro($facturas, $contrato, $idCompatibilidad, $idServicioAhorro, $telefonos);
                                EliminarTelefonosYaSeleccionados($idMiembro, $numero_movil_llamante, $idServicioAhorro, $facturas, $contrato, $idCompatibilidad);
                            }
                        }
                    }
                    ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante);

                    // Vamos a calcular los costes de los resultados b�sicos con los servicios de ahorro
                    foreach ($facturas as $factura) {
                        foreach ($idsCompatibilidades as $idCompatibilidad) {
                            AplicarServiciosAhorroALlamadasSeleccionadas($factura, $contrato, $idCompatibilidad, false, $numero_movil_llamante);
                        }
                    }			
                }	
            }
        }
    }
    echo "Recalculo Ok!<br>";
?>
</body>
</html>