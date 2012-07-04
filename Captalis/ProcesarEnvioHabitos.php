<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html>
<head>
<?php
    if (!isset($_SESSION["heightCaptalis"]))
        $_SESSION["heightCaptalis"] = 600;
    if (!isset($_SESSION["pageOneCaptalis"]))
        $_SESSION["pageOneCaptalis"] = "CaptalisHabitos.php";
	if (!isset($mainFolder))
		$mainFolder = "../";
	include($mainFolder . "Lib/library.inc");
	include($mainFolder . "Lib/facturas.inc");
	include($mainFolder . "Lib/baseServicioClubOferting.inc");
	include($mainFolder . "Lib/main.inc");
	include("./Lib/captalisHabitos.inc");
	if (openDatabase() == false)
		exit();

	// 	Provisionalmente
	if (!isset($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS'])) {
		$_SESSION['miembroCAPTALIS'] = session_id();
		$_SESSION['passwordCAPTALIS'] = session_id();
		crearUsuarioProvisionalFrom($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS'], "CAPTALIS");
	}

	$login = $_SESSION['miembroCAPTALIS'];
	$password = $_SESSION['passwordCAPTALIS'];
	$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		if (esProvisional ($login, $password)){
			borrarUsuario ($login, $password);
			unset ($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS']);
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

	$operadoras = obtenerListaOperadoras ();
	define ("NUMERO_OPERADORAS", 3);
	for ($i = 0; $i < count($operadoras); $i++)
		define ($operadoras[$i], $i);

	define ("TIPOS_DE_LLAMADA", 2);
	define ("VOZ", 0);
	define ("SMS", 1);

	define ("TIPOS_DE_DIA", 2);
	define ("LABORAL", 0);
	define ("FESTIVO", 1);

	define ("TIPOS_DE_HORA", 2);
	define ("MAÑANA", 0);
	define ("TARDE", 1);

	// EL ARRAY CONTIENE LOS VALORES QUE SE HAN DE REPARTIR DEPENDIENDO DEL TIPO DE LLAMADA
	$totalValues = array ($_POST["minutos_voz"] *  60, $_POST["mensajes_SMS"]);

	// SE CREA UN ARRAY DE 4 DIMENSIONES DONSE SE REALIZA EL REPARTO DE SEGUNDOS Y SMS
	//	$values[TIPOS_DE_LLAMADA][OPERADORAS][TIPOS_DE_DIA][TIPOS_DE_HORA]
	$values = array();
	$values = array_pad ($values, TIPOS_DE_LLAMADA, array());
	for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++){
		$values[$i]= array_pad($values[$i], NUMERO_OPERADORAS, array());
		for ($j = 0; $j < NUMERO_OPERADORAS; $j++){
			$values[$i][$j] = array_pad($values[$i][$j], TIPOS_DE_DIA, array());
			for ($k = 0; $k < TIPOS_DE_DIA; $k++){
				$values[$i][$j][$k] = array_pad ($values[$i][$j][$k], TIPOS_DE_HORA, array());
				for ($t = 0; $t < TIPOS_DE_HORA; $t++)
					$values[$i][$j][$k][$t] = 0;
			}
		}
	}

	// REPARTO DE SEGUNDOS ENTRE LAS DIFERENTES OPERADORAS
	if ($_POST["operador_destino"] == "INDIFERENTE"){
		// 100% repartido a partes iguales entre todas las operadoras
		for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++){
			$aux = $totalValues[$i] / NUMERO_OPERADORAS;
			settype ($aux, "integer");
			$resto = $totalValues[$i] - ($aux * NUMERO_OPERADORAS);

			for ($j = 0; $j < NUMERO_OPERADORAS; $j++){
				$values[$i][$j][LABORAL][MAÑANA] = $aux + $resto;
				$resto = 0;
			}
		}
	}else if (strncmp ($_POST["operador_destino"], "SOLO_", 5) == 0){
		// 100% para la seleccionada
		$operador = substr($_POST["operador_destino"], 5);
		for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++)
			$values[$i][constant($operador)][LABORAL][MAÑANA] = $totalValues[$i];
	}else{
		// 70% para la seleccionada y 30% repartido a partes iguales entre el resto
		for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++){
			$otrosOperadores = ($totalValues[$i] * 0.3) / (NUMERO_OPERADORAS - 1);
			settype ($otrosOperadores, "integer");

			for ($j = 0; $j < NUMERO_OPERADORAS; $j++)
				$values[$i][$j][LABORAL][MAÑANA] = $otrosOperadores;

			$values[$i][constant($_POST["operador_destino"])][LABORAL][MAÑANA] = $totalValues[$i] - ($otrosOperadores * (NUMERO_OPERADORAS - 1));;
		}
	}

	// REPARTO DE SEGUNDOS ENTRE LOS DIFERENTES TIPOS DE DIA
	$porcentajeLaboral = 0.714;
	// SI ES INDIFERENTE SE LA ASIGNA EL MISMO PESO A TODOS LOS DIAS DE LA SEMANA (100 / 7)
	// LOS LABORALES SERAN (100 / 7 ) * 5 = 0.714
	if ($_POST["dia"] == "SOLO_LABORAL")
		$porcentajeLaboral = 1;
	else if ($_POST["dia"] == "SOLO_FESTIVOS")
		$porcentajeLaboral = 0;
	else if ($_POST["dia"] == "LABORAL")
		$porcentajeLaboral = 0.9;
	else if ($_POST["dia"] == "FESTIVOS")
		$porcentajeLaboral = 0.1;

	for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++){
		for ($j = 0; $j < NUMERO_OPERADORAS; $j++){
			$aux = $values[$i][$j][LABORAL][MAÑANA];
			$values[$i][$j][LABORAL][MAÑANA] = $aux * $porcentajeLaboral;
			settype ($values[$i][$j][LABORAL][MAÑANA], "integer");
			$values[$i][$j][FESTIVO][MAÑANA] = $aux - $values[$i][$j][LABORAL][MAÑANA];
		}
	}

	// REPARTO DE SEGUNDOS ENTRE LAS DIFERENTES FRANJAS HORARIAS
	$porcentajeMañana = 0.5;
	if ($_POST["franja"] == "SOLO_MANANAS")
		$porcentajeMañana = 1;
	else if ($_POST["franja"] == "SOLO_TARDES")
		$porcentajeMañana = 0;
	else if ($_POST["franja"] == "MANANAS")
		$porcentajeMañana = 0.8;
	else if ($_POST["franja"] == "TARDES")
		$porcentajeMañana = 0.2;

	for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++){
		for ($j = 0; $j < NUMERO_OPERADORAS; $j++){
			for ($k = 0; $k < TIPOS_DE_DIA; $k++){
				$aux = $values[$i][$j][$k][MAÑANA];
				$values[$i][$j][$k][MAÑANA] = $aux * $porcentajeMañana;
				settype ($values[$i][$j][$k][MAÑANA], "integer");
				$values[$i][$j][$k][TARDE] = $aux - $values[$i][$j][$k][MAÑANA];
			}
		}
	}

	$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
	$content .= "<factura>\r\n";
	$content .= "<version>1.0</version>\r\n";
	$content .= "<numero_movil_llamante>123456789</numero_movil_llamante>\r\n";
	$content .= "<titular>".$login."</titular>\r\n";
	$content .= "<periodo>";
//	$content .= $_POST["day"]."/".$_POST["month"]."/".$_POST["year"]." - ";
//	$content .= $_POST["day"]."/".$_POST["month"]."/".$_POST["year"];
	$content .= "01/11/2008 - 30/11/2008";
	$content .= "</periodo>\r\n";
	$content .= "<coste>99999</coste>\r\n";
	$content .= "<operador>".$_POST["operador_origen"]."</operador>\r\n";
	$content .= "<llamadas>\r\n";

	$maxLlamadas = 3;
	$repartoLlamadas = array (0.1, 0.3, 0.6);
	$horasLlamadas = array();
	$horasLlamadas[MAÑANA] = array ("06:00:00", "06:30:00", "23:30:00");
	$horasLlamadas[TARDE] = array ("13:30:00", "15:30:00", "16:30:00");

	$diasLlamadas = array ();
	$diasLlamadas[LABORAL] = array ("04/11/2008", "04/11/2008", "04/11/2008");
	$diasLlamadas[FESTIVO] = array ("02/11/2008", "02/11/2008", "02/11/2008");

	for ($i = 0; $i < TIPOS_DE_LLAMADA; $i++){
		for ($j = 0; $j < NUMERO_OPERADORAS; $j++){
			for ($k = 0; $k < TIPOS_DE_DIA; $k++){
				for ($t = 0; $t < TIPOS_DE_HORA; $t++){
					if ($values[$i][$j][$k][$t] == 0)
						continue;

					$resto = $values[$i][$j][$k][$t];
					$valor = 0;

					for ($h = 0; $h < $maxLlamadas; $h++){
						if ($h == ($maxLlamadas - 1)) // ultima
							$valor = $resto;
						else{
							$valor = $values[$i][$j][$k][$t] * $repartoLlamadas[$h];
							settype ($valor, "integer");
							$resto -= $valor;
						}
						$numeroTelefono = sprintf("987%03d%03d", $j, $h);

						if ($i == VOZ){
							$content .= "<llamada>\r\n";
							$content .= "<numero_movil_llamado>".$numeroTelefono."</numero_movil_llamado>\r\n";
							$content .= "<operador>".$operadoras[$j]."</operador>\r\n";
							$content .= "<tipo>VOZ</tipo>\r\n";
							$content .= "<ambito>LOCAL</ambito>\r\n";
							$content .= "<fecha>".$diasLlamadas[$k][$h]." ".$horasLlamadas[$t][$h]."</fecha>\r\n";
							$content .= "<duracion>".$valor."</duracion>\r\n";
							$content .= "<coste>9999</coste>\r\n";
							$content .= "<zona_internacional>1</zona_internacional>\r\n";
							$content .= "</llamada>\r\n";
						}else { // SMS
							for ($x = 0; $x < $valor; $x++){
								$content .= "<llamada>\r\n";
								$content .= "<numero_movil_llamado>".$numeroTelefono."</numero_movil_llamado>\r\n";
								$content .= "<operador>".$operadoras[$j]."</operador>\r\n";
								$content .= "<tipo>SMS</tipo>\r\n";
								$content .= "<ambito>LOCAL</ambito>\r\n";
								$content .= "<fecha>".$diasLlamadas[$k][$h]." ".$horasLlamadas[$t][$h]."</fecha>\r\n";
								$content .= "<coste>9999</coste>\r\n";
								$content .= "<zona_internacional>1</zona_internacional>\r\n";
								$content .= "</llamada>\r\n";
							}
						}
					}
				}
			}
		}
	}
	$content .= "</llamadas>\r\n";
	$content .= "</factura>\r\n";
/*
	echo "SEGUNDOS: ".$totalSegundos." (".$_POST["minutos_voz"]." X 60)<br><br>";
	echo "<table>";
	echo "<tr><td>Operador</td><td>Laboral Mañana</td><td>Laboral Tarde</td><td>Festivo Mañana</td><td>Festivo Tarde</td><tr>";
	for ($i = 0; $i < NUMERO_OPERADORAS; $i++){
		echo "<tr>";
		echo "<td>".$operadoras[$i]."</td>";
		echo "<td>".$values[VOZ][$i][LABORAL][MAÑANA]."</td>";
		echo "<td>".$values[VOZ][$i][LABORAL][TARDE]."</td>";
		echo "<td>".$values[VOZ][$i][FESTIVO][MAÑANA]."</td>";
		echo "<td>".$values[VOZ][$i][FESTIVO][TARDE]."</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "SMS: ".$_POST["mensajes_SMS"]."<br><br>";
	echo "<table>";
	echo "<tr><td>Operador</td><td>Laboral Mañana</td><td>Laboral Tarde</td><td>Festivo Mañana</td><td>Festivo Tarde</td><tr>";
	for ($i = 0; $i < NUMERO_OPERADORAS; $i++){
		echo "<tr>";
		echo "<td>".$operadoras[$i]."</td>";
		echo "<td>".$values[SMS][$i][LABORAL][MAÑANA]."</td>";
		echo "<td>".$values[SMS][$i][LABORAL][TARDE]."</td>";
		echo "<td>".$values[SMS][$i][FESTIVO][MAÑANA]."</td>";
		echo "<td>".$values[SMS][$i][FESTIVO][TARDE]."</td>";
		echo "</tr>";
	}
	echo "</table>";
*/
	$n = procesarFactura($content, $idMiembro, $edad_titular, $idParentesco, $descripcion, $idFactura);
	if ($n == "ALREADY_EXISTS") {
		echo $n."<br>";
		$error = true;
		if (esProvisional ($login, $password)){
			borrarUsuario ($login, $password);
			unset ($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS']);
		}
		exit(0);
	}
	else if ($n[0] == '!') {
		echo $n."<br>";
		insertarErrorProcesoFactura($idMiembro, $destination, $n);
		$error = true;
		if (esProvisional ($login, $password)){
			borrarUsuario ($login, $password);
			unset ($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS']);
		}
		exit(0);
	}

	$numero_movil_llamante = $n;
	$facturas = array();
	$facturas[0] = $idFactura;
    //echo $numero_movil_llamante . "<br>";
    //echo $idFactura . "<br>";
    //echo "</head><body>" . $numero_movil_llamante . " - " . $idFactura . "</body></html>";
    //exit();

	// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
	$costes = obtenerCostes($facturas, $numero_movil_llamante);

	// ----------------
	// Servicios Ahorro
	// ----------------

	$idContratos = obtenerContratos();
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
					AplicarServiciosAhorroALlamadasSeleccionadas($factura, $idContrato, $idCompatibilidad, false, $numero_movil_llamante);
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
	maintable.height="<?php echo $_SESSION["heightCaptalis"]; ?>";
	framemsg.style.visibility="hidden";
	framemsg.height="0";
	frameaho.style.visibility="visible";
	frameaho.height="<?php echo $_SESSION["heightCaptalis"]; ?>";
	return true;
}

function VisualizarEspera() {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	var frameaho = parent.document.getElementById("fahorramovil");
	var maintable = parent.document.getElementById("maintableahorramovil");
	maintable.height="<?php echo $_SESSION["heightCaptalis"]; ?>";
	framemsg.style.visibility="visible";
	framemsg.height="<?php echo $_SESSION["heightCaptalis"]; ?>";
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
        <td width="40%" class="texto" align="right">Operador:</td>
        <td width="2%"></td>
        <td width="58%" class="texto" align="left"><strong><?php echo $_POST["operador_origen"]; ?></strong></td>
    </tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Llamado y enviando SMS's:</td>
        <td width="2%"></td>
        <td width="58%" class="texto" align="left"><strong>
        <?php
            if ($_POST["operador_destino"] == "INDIFERENTE")
                echo "a cualquier operador";
            else if (strncmp ($_POST["operador_destino"], "SOLO_", 5) == 0)
                echo "solamente a ".substr($_POST["operador_destino"], 5);
            else
                echo "mayoritariamente a ".$_POST["operador_destino"];
        ?>
        </strong></td>
    </tr>
    <?php
    if ($_POST["minutos_voz"] > 0){
    ?>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Acumulando al mes (minutos):</td>
        <td width="2%"></td>
        <td width="58%" class="texto" align="left"><strong><?php echo $_POST["minutos_voz"]; ?></strong></td>
    </tr>
    <?php
    }
    if ($_POST["mensajes_SMS"] > 0){
    ?>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Acumulando al mes (mensajes):</td>
        <td width="2%"></td>
        <td width="58%" class="texto" align="left"><strong><?php echo $_POST["mensajes_SMS"]; ?></strong></td>
    </tr>
    <?php
    }
    ?>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Franja horaria:</td>
        <td width="2%"></td>
        <td width="58%" class="texto" align="left"><strong>
        <?php
            if ($_POST["franja"] == "INDIFERENTE")
                echo "A cualquier hora";
            else if ($_POST["franja"] == "SOLO_MANANAS")
                echo "Solamente por las mañanas";
            else if ($_POST["franja"] == "SOLO_TARDES")
                echo "Solamente por las tardes";
            else if ($_POST["franja"] == "MANANAS")
                echo "Mayoritariamente por las mañanas";
            else if ($_POST["franja"] == "TARDES")
                echo "Mayoritariamente por las tardes";
            else
                echo $_POST["franja"];
        ?>
        </strong></td>
    </tr>
    <tr><td colspan="3" style="height:15px"></td></tr>
    <tr>
        <td width="40%" class="texto" align="right">Tipo de día:</td>
        <td width="2%"></td>
        <td width="58%" class="texto" align="left"><strong>
        <?php
            if ($_POST["dia"] == "INDIFERENTE")
                echo "Cualquier día de la semana";
            else if ($_POST["dia"] == "SOLO_LABORAL")
                echo "Solamente de lunes a viernes";
            else if ($_POST["dia"] == "SOLO_FESTIVOS")
                echo "Solamente fines de semana y festivos";
            else if ($_POST["dia"] == "LABORAL")
                echo "Mayoritariamente de lunes a viernes";
            else if ($_POST["dia"] == "FESTIVOS")
                echo "Mayoritariamente fines de semana y festivos";
            else
                echo $_POST["dia"];
        ?>
        </strong></td>
    </tr>
    <tr><td colspan="3" style="height:30px"></td></tr>
    <?php
    crearTablaResultadosHabitosCAPTALIS($idMiembro, $numero_movil_llamante);
    ?>
    <tr><td colspan="3" style="height:30px"></td></tr>
    <tr>
        <td colspan="3" align="center" class="texto"><a href="http://www.captalis.com/telefonos-moviles/mejor-tarifa-movil/" target="_top">Volver al formulario inicial</a></td>
    </tr>
	</table>
 	<?php
	if (esProvisional ($login, $password)){
		borrarUsuario ($login, $password);
		unset ($_SESSION['miembroCAPTALIS'], $_SESSION['passwordCAPTALIS']);
	}
	?>
</body>
</html>