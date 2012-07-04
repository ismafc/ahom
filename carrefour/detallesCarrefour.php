<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalles</title>
<style type="text/css">
<!--
.texto_normal {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #E881B9;
	font-weight: normal;
	text-decoration: none;
}
.texto_normal a {
	color: #E881B9;
}
.texto_normal a:hover {
	text-decoration:none;
}
.Estilo3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #990033;
}
.Estilo4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #990033;
}
body {
	background-color:#ffffff;
}
-->
</style>
</head>
<body leftmargin="5" rightmargin="5" topmargin="5" bottommargin="5">
<?php
	include_once("./../Lib/library.inc");
	include_once("./Lib/main.inc");
	include_once("./Lib/base.inc");
	if (openDatabase() == false)
		exit();

	// Crea un usuario Carrefour
	if (!isset($_SESSION['miembroCarrefour'], $_SESSION['passwordCarrefour'])) {
		$_SESSION['miembroCarrefour'] = session_id();
		$_SESSION['passwordCarrefour'] = session_id();
		crearUsuarioCarrefour($_SESSION['miembroCarrefour'], $_SESSION['passwordCarrefour']);
	}
	$login = $_SESSION['miembroCarrefour'];
	$password = $_SESSION['passwordCarrefour'];
	$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$idMiembro = $row_array[0];

	$numero_movil_llamante = $_GET["Telefono"];

	$numero_llamado_FM = array();
	$inicio_FM = array();
	$duracion_FM = array();
	$coste_FM = array();
	$coste_carrefour_FM = array();

	$numero_llamado_SMS = array();
	$inicio_SMS = array();
	$coste_SMS = array();
	$coste_carrefour_SMS = array();
	
	$coste_no_computado = 0;
	$llamadas_no_computadas = 0;
	$index_FM = 0;
	$index_SMS = 0;

	$total_duracion_FM = 0;
	$total_coste_FM = 0;
	$total_coste_carrefour_FM = 0;
	$total_coste_SMS = 0;
	$total_coste_carrefour_SMS = 0;

	$sql = "SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'";
	$result = mysql_query($sql);
	for ($j = 0; $j < mysql_num_rows($result); $j++) {
		$row_array = mysql_fetch_row($result);
		$idFactura = $row_array[0];

		$sqlx = "SELECT id, idContrato, idCompatibilidad, SUM(coste) FROM resultados_basicos WHERE idFactura IN (
				SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND numero_movil_llamante = '$numero_movil_llamante'
			) GROUP BY idContrato, idCompatibilidad ORDER BY SUM(coste) ASC";
		$resultx = mysql_query($sqlx);
		if ($resultx == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_arrayx = mysql_fetch_row($resultx);
		
		$sql1 = "SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura' AND idContrato='$row_arrayx[1]'";
		$result1 = mysql_query($sql1);
		for ($k = 0; $k < mysql_num_rows($result1); $k++) {
			$row_array1 = mysql_fetch_row($result1);
			$idResultadoBasico = $row_array1[0];
			$sql2 = "SELECT idLlamada, coste FROM resultados_detallados WHERE idResultadoBasico = '$idResultadoBasico'";
			$result2 = mysql_query($sql2);
			for ($i = 0; $i < mysql_num_rows($result2); $i++) {
				$row_array2 = mysql_fetch_row($result2);
				$idLlamada = $row_array2[0];
				$costecarrefour = $row_array2[1];
				$sql3 = "SELECT idTipoLlamada, numero_telefono_llamado, inicio_llamada, duracion, coste FROM llamadas WHERE id = '$idLlamada'";
				$result3 = mysql_query($sql3);
				$row_array3 = mysql_fetch_row($result3);
				if ($row_array3[0] == 1 || $row_array3[0] == 2 || $row_array3[0] == 3 || $row_array3[0] == 4 || $row_array3[0] == 19) {
					$numero_llamado_FM[$index_FM] = $row_array3[1];
					$inicio_FM[$index_FM] = $row_array3[2];
					$duracion_FM[$index_FM] = $row_array3[3];
					$coste_FM[$index_FM] = $row_array3[4];
					$coste_carrefour_FM[$index_FM] = $costecarrefour;
					$total_duracion_FM += $row_array3[3];
					$total_coste_FM += $row_array3[4];
					$total_coste_carrefour_FM += $costecarrefour;
					$index_FM++;	
				}
				else if ($row_array3[0] == 5 || $row_array3[0] == 6 || $row_array3[0] == 7 || $row_array3[0] == 20) {
					$numero_llamado_SMS[$index_SMS] = $row_array3[1];
					$inicio_SMS[$index_SMS] = $row_array3[2];
					$coste_SMS[$index_SMS] = $row_array3[4];
					$coste_carrefour_SMS[$index_SMS] = $costecarrefour;
					$total_coste_SMS += $row_array3[4];
					$total_coste_carrefour_SMS += $costecarrefour;
					$index_SMS++;
				}
				else {
					$coste_no_computado += $row_array3[4];
					$llamadas_no_computadas++;
				}
			}
		}
	}
	
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#E881B9">
  <tr>
    <td><div align="center" class="Estilo3">Informe detallado</div></td>
  </tr>
  <tr>
    <td><div align="center" class="texto_normal"><strong><?php echo $numero_movil_llamante ?></strong></div></td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#E881B9">
  <tr bgcolor="#FFCCFF">
    <td colspan="5"><div align="center" class="Estilo4"><strong>Llamadas a fijos nacionales y mviles</strong></div></td>
  </tr>
  <tr>
    <td width="20%" class="Estilo4"><div align="center">Telfono</div></td>
    <td width="25%" class="Estilo4"><div align="center">Inicio</div></td>
    <td width="15%" class="Estilo4"><div align="center">Duracin</div></td>
    <td width="20%" class="Estilo4"><div align="center">Coste factura ()</div></td>
    <td width="20%" class="Estilo4"><div align="center">Coste Carrefour ()</div></td>
  </tr>
<?php
	if ($index_FM == 0) {
		echo "<tr>";
		echo "<td colspan=\"5\"><div align=\"center\" class=\"Estilo4\"><strong>No se encontraron llamadas</strong></div></td>";
		echo "</tr>";
	}
	else {
		for ($i = 0; $i < $index_FM; $i++) {
			echo "<tr>";
			echo "<td width=\"20%\" class=\"texto_normal\"><div align=\"center\">" . $numero_llamado_FM[$i] . "</div></td>";
			echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . $inicio_FM[$i] . "</div></td>";
			$horas = (int)($duracion_FM[$i] / 3600);
			$minutos = (int)(($duracion_FM[$i] - $horas * 3600) / 60);
			$segundos = (int)($duracion_FM[$i] - $horas * 3600 - $minutos * 60);
			$tiempoLlamada = sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
			echo "<td width=\"15%\" class=\"texto_normal\"><div align=\"center\">" . $tiempoLlamada . "</div></td>";
			echo "<td width=\"20%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $coste_FM[$i]) . "</div></td>";
			echo "<td width=\"20%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $coste_carrefour_FM[$i]) . "</div></td>";
			echo "</tr>";
		}
		echo "<tr bgcolor=\"#FFCCFF\">";
		echo "<td width=\"20%\" class=\"texto_normal\"><div align=\"center\">Total</div></td>";
		echo "<td width=\"25%\" class=\"texto_normal\">&nbsp;</td>";
		$horas = (int)($total_duracion_FM / 3600);
		$minutos = (int)(($total_duracion_FM - $horas * 3600) / 60);
		$segundos = (int)($total_duracion_FM - $horas * 3600 - $minutos * 60);
		$tiempoLlamada = sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
		echo "<td width=\"15%\" class=\"texto_normal\"><div align=\"center\">" . $tiempoLlamada . "</div></td>";
		echo "<td width=\"20%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $total_coste_FM) . "</div></td>";
		echo "<td width=\"20%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $total_coste_carrefour_FM) . "</div></td>";
		echo "</tr>";
	}
?>
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#E881B9">
  <tr bgcolor="#FFCCFF">
    <td colspan="4"><div align="center" class="Estilo4"><strong>SMS</strong></div></td>
  </tr>
  <tr>
    <td width="25%" class="Estilo4"><div align="center">Telfono</div></td>
    <td width="25%" class="Estilo4"><div align="center">Fecha</div></td>
    <td width="25%" class="Estilo4"><div align="center">Coste factura</div></td>
    <td width="25%" class="Estilo4"><div align="center">Coste Carrefour</div></td>
  </tr>
<?php
	if ($index_SMS == 0) {
		echo "<tr>";
		echo "<td colspan=\"4\"><div align=\"center\" class=\"Estilo4\"><strong>No se encontraron SMS</strong></div></td>";
		echo "</tr>";
	}
	else {
		for ($i = 0; $i < $index_SMS; $i++) {
			echo "<tr>";
			echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . $numero_llamado_SMS[$i] . "</div></td>";
			echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . $inicio_SMS[$i] . "</div></td>";
			echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $coste_SMS[$i]) . "</div></td>";
			echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $coste_carrefour_SMS[$i]) . "</div></td>";
			echo "</tr>";
		}
		echo "<tr bgcolor=\"#FFCCFF\">";
		echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">Total</div></td>";
		echo "<td width=\"25%\" class=\"texto_normal\">&nbsp;</td>";
		echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $total_coste_SMS) . "</div></td>";
		echo "<td width=\"25%\" class=\"texto_normal\"><div align=\"center\">" . sprintf("%.2f", $total_coste_carrefour_SMS) . "</div></td>";
		echo "</tr>";
	}
?>
</table>
<br />
  <?php
if ($llamadas_no_computadas > 0) {
	if ($llamadas_no_computadas > 1) {
?>
  <span class="Estilo4">(*) Se han encontrado <?php echo $llamadas_no_computadas; ?> llamadas con un coste acumulado de <?php echo sprintf("%.2f", $coste_no_computado) ?>  que no se han tenido en cuenta a efectos del clculo del ahorro</span><br />
  <?php
	}
	else {
	?>
  <span class="Estilo4">(*) Se ha encontrado una llamada con un coste de <?php echo sprintf("%.2f", $coste_no_computado) ?>  que no se ha tenido en cuenta a efectos del clculo del ahorro</span><br />
  <?php
	}
}
?>
<br />
  <span class="Estilo4">(**) Los costes estn expresados sin IVA (16%)</span><br />
<br />
<div align="center"><span class="Estilo3" style="cursor:pointer" onClick="window.close();">Cerrar</span></div>
</body>
</html>
