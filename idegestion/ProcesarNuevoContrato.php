<html>
<head>
	<title>PHP & MySQL Test</title>
    <style type="text/css">
<!--
.Estilo32 {font-size: 28pt}
.Estilo33 {	font-size: 30pt;
	font-weight: bold;
}
.Estilo5 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	font-style: italic;
}
.Estilo60 {font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo63 {	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	font-weight: bold;
}
-->
    </style>
</head>
<body>
<table width="990" height="133" border="0" background="../imagenes/colorfonstitol2.jpg" id="Titol">
  <tr>
    <th width="200" rowspan="2" valign="middle" class="Estilo5" scope="col"><div align="right" class="Estilo32">
      <div align="right" class="Estilo33">Idegestion</div>
    </div></th>
    <th height="39" colspan="2" valign="bottom" class="Estilo5" scope="col"><div align="left"><img src="../imagenes/LogoID2.gif" width="29" height="20" /></div></th>
  </tr>
  <tr>
    <td height="43" colspan="2" valign="middle" class="Estilo5" scope="col"></td>
  </tr>
  <tr>
    <td height="20" valign="middle" class="Estilo5" scope="col"></td>
    <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center"><a href="NuevoContrato.php" class="Estilo63"></a></div></td>
    <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"></div></td>
  </tr>
</table>
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$nombre = $_POST["NombreContrato"];
	$idOperador = $_POST["Operador"];
	$cuota_alta = $_POST["CuotaAlta"];
	$cuota_mensual = $_POST["CuotaMensual"];
	$fraccion_minima = $_POST["FraccionMinima"];
	$unidad_tarificacion = $_POST["UnidadTarificacion"];
	$consumo_minimo = $_POST["ConsumoMinimo"];
	$base_consumo_gratis = $_POST["BaseConsumoGratis"];
	$consumo_gratis = $_POST["ConsumoGratis"];
/*	echo "<b>Nombre = " . $nombre . "</b><br>";
	echo "<b>Operador = " . $idOperador . "</b><br>";
	echo "<b>Consumo Mínimo = " . $consumo_minimo . "</b><br>";
	echo "<b>Cuota alta = " . $cuota_alta . "</b><br>";
	echo "<b>Unidad tarificación = " . $unidad_tarificacion . "</b><br>";
	echo "<b>Fracción mínima = " . $fraccion_minima . "</b><br>";
*/	
	$idContrato = "";
	$sql00 = "INSERT INTO contratos (nombre, idOperador, cuota_alta, cuota_mensual, fraccion_minima, unidad_tarificacion, consumo_minimo, base_consumo_gratis, consumo_gratis) VALUES ('$nombre', '$idOperador', '$cuota_alta', '$cuota_mensual', '$fraccion_minima', '$unidad_tarificacion', '$consumo_minimo', '$base_consumo_gratis', '$consumo_gratis')";
	$result00 = mysql_query($sql00);
	
	$sql01 = "SELECT id FROM contratos WHERE nombre = '$nombre'";
	$result01 = mysql_query($sql01);
	if ($result01 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array01 = mysql_fetch_row($result01);
	$idContrato = $row_array01[0];
	?>
<form name="form1" method="post" action="ModificarContrato.php">
  <label><br>
  </label>
  <table width="990" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div align="center">
	  	<?php
		echo "<input type=\"hidden\" name=\"idContrato\" value=\"" . $idContrato . "\">";
		echo "<b>id = " . $idContrato . "</b><br>";
		?>
        <input type="submit" name="Submit" value="Continuar &gt;&gt;">
      </div></td>
    </tr>
  </table>
</form>
<?php
/*

	echo "<b>id = " . $idContrato . "</b><br>";
	$idTiposDias[2];
	$nTiposDias = 1;
	$tipo_dia = $_POST["TipoDia"];
	if ($tipo_dia == "A") {
		$nTiposDias = 2;
		$idTiposDias[0] = "1";
		$idTiposDias[1] = "2";
	}
	else {
		$idTiposDias[0] = $tipo_dia;
	}
	$franja_inicio = substr($_POST["FranjaInicio"], 0, 2) * 3600 + substr($_POST["FranjaInicio"], 3, 2) * 60;
	$franja_fin = substr($_POST["FranjaFin"], 0, 2) * 3600 + substr($_POST["FranjaFin"], 3, 2) * 60;
	echo "<b>" . $franja_inicio . " a " . $franja_fin . "</b><br>";
	$tipo_llamada = $_POST["TipoLlamada"];
	echo "<b>" . $tipo_llamada . "</b><br>";
	$idTiposLlamadas[4];
	$nTiposLlamadas = 1;
	// Propio operador + fijos nacionales
	if ($tipo_llamada == "A") {
		$nTiposLlamadas = 2;
		if ($idOperador == "1") {
			$idTiposLlamadas[0] = "1";
			$idTiposLlamadas[1] = "3";
		}
		else if ($idOperador == "2") {
			$idTiposLlamadas[0] = "1";
			$idTiposLlamadas[1] = "4";
		}
		else {
			$idTiposLlamadas[0] = "1";
			$idTiposLlamadas[1] = "2";
		}
	}
	// Resto de operadores móviles
	else if ($tipo_llamada == "B") {
		$nTiposLlamadas = 2;
		if ($idOperador == "1") {
			$idTiposLlamadas[0] = "2";
			$idTiposLlamadas[1] = "4";
		}
		else if ($idOperador == "2") {
			$idTiposLlamadas[0] = "2";
			$idTiposLlamadas[1] = "3";
		}
		else {
			$idTiposLlamadas[0] = "3";
			$idTiposLlamadas[1] = "4";
		}
	}
	// fijos nacionales y todos los móviles
	else if ($tipo_llamada == "C") {
		$nTiposLlamadas = 4;
		$idTiposLlamadas[0] = "1";
		$idTiposLlamadas[1] = "2";
		$idTiposLlamadas[2] = "3";
		$idTiposLlamadas[3] = "4";
	}
	// SMS a todos los operadores
	else if ($tipo_llamada == "D") {
		$nTiposLlamadas = 3;
		$idTiposLlamadas[0] = "5";
		$idTiposLlamadas[1] = "6";
		$idTiposLlamadas[2] = "7";
	}
	// MMS a todos los operadores
	else if ($tipo_llamada == "E") {
		$nTiposLlamadas = 3;
		$idTiposLlamadas[0] = "8";
		$idTiposLlamadas[1] = "9";
		$idTiposLlamadas[2] = "10";
	}
	else {
		$idTiposLlamadas[0] = $tipo_llamada;
	}
	$intervalo_desde = $_POST["IntervaloDesde"];
	$intervalo_hasta = $_POST["IntervaloHasta"];
	$establecimiento_llamada = $_POST["EstablecimientoLlamada"];
	$coste = $_POST["Coste"] / 60.0;
	echo "<b>" . $intervalo_desde . "</b><br>";
	echo "<b>" . $intervalo_hasta . "</b><br>";
	echo "<b>" . $establecimiento_llamada . "</b><br>";
	echo "<b>" . $coste . "</b><br>";
	for ($i = 0; $i < $nTiposDias; $i++) {
		for ($j = 0; $j < $nTiposLlamadas; $j++) {
			echo "<b>" . $idTiposDias[$i] . " - " . $idTiposLlamadas[$j] . "</b><br>";
			$sql = "INSERT INTO costes (idContrato, idTipoDia, franja_hora_inicio, franja_hora_fin, idTipoLlamada, intervalo_desde, intervalo_hasta, establecimiento_llamada, coste) VALUES ('$idContrato', '$idTiposDias[$i]', '$franja_inicio', '$franja_fin', '$idTiposLlamadas[$j]', '$intervalo_desde', '$intervalo_hasta', '$establecimiento_llamada', '$coste')";
			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
		}
	}
	echo "<b>De puta madre!</b>";
*/?>
</body>
</html>