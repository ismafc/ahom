<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html>
<head>
<?php
    if (!isset($_SESSION["heightClubOferting"]))
        $_SESSION["heightClubOferting"] = 600;
    if (!isset($_SESSION["pageOneClubOferting"]))
        $_SESSION["pageOneClubOferting"] = "ClubOferting.php";
    if (!isset($mainFolder))
            $mainFolder = "../";
    include($mainFolder . "Lib/library.inc");
    include($mainFolder . "Lib/facturas.inc");
    include($mainFolder . "Lib/baseServicioClubOferting.inc");
    include($mainFolder . "Lib/main.inc");
    include("./Lib/ClubOfertingLlamada.inc");
    if (openDatabase() == false)
            exit();

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
            echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
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

    $duracionSegundos = $_POST["duracion_minutos"]*60 + $_POST["duracion_segundos"];
    $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
    $content .= "<factura>\r\n";
    $content .= "<version>1.0</version>\r\n";
    $content .= "<numero_movil_llamante>123456789</numero_movil_llamante>\r\n";
    $content .= "<titular>".$login."</titular>\r\n";
    $content .= "<periodo>";
    $content .= $_POST["day"]."/".$_POST["month"]."/".$_POST["year"]." - ";
    $content .= $_POST["day"]."/".$_POST["month"]."/".$_POST["year"];
    $content .= "</periodo>\r\n";
    $content .= "<coste>9999</coste>\r\n";
    $content .= "<operador>".$_POST["operador_origen"]."</operador>\r\n";
    $content .= "<llamadas>\r\n";
    $content .= "<llamada>\r\n";
    $content .= "<numero_movil_llamado>987654321</numero_movil_llamado>\r\n";
    $content .= "<operador>".$_POST["operador_destino"]."</operador>\r\n";
    $content .= "<tipo>".$_POST["tipo"]."</tipo>\r\n";
    $content .= "<ambito>LOCAL</ambito>\r\n";
    $content .= "<fecha>".$_POST["day"]."/".$_POST["month"]."/".$_POST["year"]." ".$_POST["hour"].":".$_POST["minute"].":00</fecha>\r\n";
    $content .= "<duracion>".$duracionSegundos."</duracion>\r\n";
    $content .= "<coste>9999</coste>\r\n";
    $content .= "<zona_internacional>1</zona_internacional>\r\n";
    $content .= "</llamada>\r\n";
    $content .= "</llamadas>\r\n";
    $content .= "</factura>\r\n";

$n = procesarFactura($content, $idMiembro, $edad_titular, $idParentesco, $descripcion, $idFactura);
    if ($n == "ALREADY_EXISTS") {
            echo $n."<br>";
            $error = true;
            if (esProvisional ($login, $password)){
                    borrarUsuario ($login, $password);
                    unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
            }
            exit(0);
    }
    else if ($n[0] == '!') {
            echo $n."<br>";
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
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Resultados del cálculo</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script type="text/javascript">
function OcultarEspera() {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	var frameaho = parent.document.getElementById("fahorramovil");
	var maintable = parent.document.getElementById("maintableahorramovil");
	maintable.height="<?php echo $_SESSION["heightClubOferting"]; ?>";
	framemsg.style.visibility="hidden";
	framemsg.height="0";
	frameaho.style.visibility="visible";
	frameaho.height="<?php echo $_SESSION["heightClubOferting"]; ?>";
	return true;
}

function VisualizarEspera() {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	var frameaho = parent.document.getElementById("fahorramovil");
	var maintable = parent.document.getElementById("maintableahorramovil");
	maintable.height="<?php echo $_SESSION["heightClubOferting"]; ?>";
	framemsg.style.visibility="visible";
	framemsg.height="<?php echo $_SESSION["heightClubOferting"]; ?>";
	frameaho.style.visibility="hidden";
	frameaho.height="0";
	return true;
}
</script>
</head>
<body onLoad="OcultarEspera();">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr><td colspan="3"><div class="titulo">Informe de resultado</div></td></tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Operador de Origen:</td>
        <td width="2%"></td>
        <td width="58%"class="texto"><strong><?php echo $_POST["operador_origen"]; ?></strong></td>
    </tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Operador de Destino:</td>
        <td width="2%" ></td>
        <td width="58%" class="texto"><strong><?php echo $_POST["operador_destino"]; ?></strong></td>
    </tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Tipo de llamada:</td>
        <td width="2%" ></td>
        <td width="58%" class="texto"><strong>
            <?php
                    if ($_POST["tipo"] == VOZ)
                            echo "Voz";
                    else if ($_POST["tipo"] == SMS)
                            echo "SMS";
                    else
                            echo $_POST["tipo"];
            ?>
            </strong>
        </td>
    </tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Fecha y Hora:</td>
        <td width="2%"></td>
        <td width="58%" class="texto"><strong><?php echo $_POST["day"]."/".$_POST["month"]."/".$_POST["year"]." ".$_POST["hour"].":".$_POST["minute"]; ?></strong></td>
    </tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <?php
    if ($_POST["tipo"] == VOZ) {
    ?>
        <tr>
            <td width="40%" class="texto" align="right">Duración:</td>
            <td width="2%" ></td>
            <td width="58%" class="texto"><strong><?php echo $_POST["duracion_minutos"]."' ".$_POST["duracion_segundos"]."''"; ?></strong></td>
        </tr>        
    <?php
    }
    ?>
    <tr><td colspan="3" style="height:30px"></td></tr>
    <?php
    crearTablaResultadosBasicosLlamadaClubOferting($idMiembro, $numero_movil_llamante);
    ?>
    <tr><td colspan="3" style="height:30px"></td></tr>
    <tr>
        <td class="texto" colspan="3" align="center"><a href="http://www.ClubOferting.com/telefonos-moviles/ahorrar-llamadas/" target="_top">Volver al formulario inicial</a></td>
    </tr>
</table>
<?php
if (esProvisional ($login, $password)){
    borrarUsuario ($login, $password);
    unset ($_SESSION['miembroClubOferting'], $_SESSION['passwordClubOferting']);
}
?>
</body>
</html>