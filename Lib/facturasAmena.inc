<?php
if (!isset($mainFolder))
	$mainFolder = "./";
include_once($mainFolder . "Lib/facturasBase.inc");

//
// Funciones para analizar las facturas
//

function obtenerFechaHoraAmena($f, $h) {
	$dia = substr($f, 0, 2);
	$mes = substr($f, 3, 2);
	$year = substr($f, 6, 4);
	return date($year . "-" . $mes . "-" . $dia . " " . $h);
}

function obtenerDuracionAmena($d) {
	if ($d == "0 min")
		return 0;
	else if ($d == "menor 1m")
		return 0;
	else {
		$resultado = 0;
		$i = 0;
		$valor = "";	
		if ($d[$i] == 'M')
			$i++;
		while ($d[$i] >= '0' && $d[$i] <= '9') {
			$valor = $valor . $d[$i];
			$i++;
		}
		if ($d[$i] == 'h')
			$resultado += $valor * 3600;
		else if ($d[$i] == 'm')
			$resultado += $valor * 60;
		else if ($d[$i] == 's')
			$resultado += $valor;
		$i++;
		$i++;
		if ($i < strlen($d)) {
			$valor = "";	
			while ($d[$i] >= '0' && $d[$i] <= '9') {
				$valor = $valor . $d[$i];
				$i++;
			}
			if ($d[$i] == 'm')
				$resultado += $valor * 60;
			else if ($d[$i] == 's')
				$resultado += $valor;
			$i++;
			$i++;
			if ($i < strlen($d)) {
				$valor = "";	
				while ($d[$i] >= '0' && $d[$i] <= '9') {
					$valor = $valor . $d[$i];
					$i++;
				}
				if ($d[$i] == 's')
					$resultado += $valor;
			}
		}
		return $resultado;
	}
}
	
function obtenerTipoLlamadaAmena($tipo, $destino, $especiales) {
	//echo "--> " . $tipo . "<br>";
	//echo "---> " . $destino . "<br>";
	//echo "----> " . $especiales . "<br>";
	if ($tipo == "especial")
		return 18;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false) && (strpos($destino, "il AMENA") !== false || strpos($destino, "il ORANGE") !== false) && ($especiales == "mensaje de texto" || $especiales == "SMS"))
		return 7;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false) && $destino == "Vodafone" && ($especiales == "mensaje de texto" || $especiales == "SMS"))
		return 6;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false) && $destino == "Movistar" && ($especiales == "mensaje de texto" || $especiales == "SMS"))
		return 5;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false) && (strpos($destino, "il AMENA") !== false || strpos($destino, "il ORANGE") !== false) && (strpos($especiales,"telefon") !== false || $especiales == "llamada"))
		return 4;
	else if ($tipo == "nacional" && strpos($destino, "ero elegido") !== false && $especiales == "llamada")
		return 4;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false) && $destino == "Vodafone" && (strpos($especiales,"telefon") !== false || $especiales == "llamada"))
		return 2;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false) && $destino == "Movistar" && (strpos($especiales,"telefon") !== false || $especiales == "llamada"))
		return 3;
	else if (($tipo == "nacional" || strpos($tipo, "ero elegido") !== false || $tipo == "dentro horario eleg.") && (strpos($especiales,"telefon") !== false || $especiales == "llamada"))
		return 1;
	return 18;
}

function obtenerDatosLlamadaAmena($line, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	if (strlen($line) == 0)
		return 73;

	if (!(strpos($line, "detalle de las llamadas") === false)) {
		return 73;
	}
	if (!(strpos($line, "N?mero de Telef?no;Fecha;") === false)) {
		return 73;
	}
	if (!(strpos($line, "no;Fecha;") === false)) {
		return 73;
	}

	//echo "<b>Datos llamada Amena = " . $line . "</b><br />";
	$nllamada = count($coste);
	$pos = strpos($line, ";");
	$line = substr($line, $pos + 1);
	
	$pos = strpos($line, ";");
	$fecha = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);
	
	$pos = strpos($line, ";");
	$telefono = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);
	
	$pos = strpos($line, ";");
	$tipo = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);
	
	$pos = strpos($line, ";");
	$destino = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);

	$pos = strpos($line, ";");
	$especiales = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);

	$pos = strpos($line, ";");
	$hora = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);

	$pos = strpos($line, ";");
	$dur = substr($line, 0, $pos);
	$line = substr($line, $pos + 1);

	$pos = strpos($line, ";");
	$line = substr($line, $pos + 1);

	$c = str_replace(",", ".", $line);
	
	$fecha_hora[$nllamada] = obtenerFechaHoraAmena($fecha, $hora);
	$telefono_llamado[$nllamada] = $telefono;
	$tipo_llamada[$nllamada] = obtenerTipoLlamadaAmena($tipo, $destino, $especiales);
	$duracion[$nllamada] = obtenerDuracionAmena($dur);
	$coste[$nllamada] = $c;
	//echo $fecha_hora[$nllamada] . " ; " . $telefono_llamado[$nllamada] . " ; " . $tipo_llamada[$nllamada] . " ; " . $duracion[$nllamada] . ";" . $coste[$nllamada] . "<br>";
	
	return 73;
}

?>
