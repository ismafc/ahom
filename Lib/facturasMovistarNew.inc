<?php
if (!isset($mainFolder))
	$mainFolder = "./";
include_once($mainFolder . "Lib/facturasMovistarBase.inc");

//
// Funciones para analizar las facturas
//

function isHoraMovistar($text, &$hora) {
	$hora = "";
	if (strlen($text) == 5)
		$hora = $text . ":00";
	else
		$hora = $text;
	if (!ereg("([0-9]{2}):([0-9]{2}):([0-9]{2})", $hora))
		return false;
	return true;
}

function isDiaMovistar($text, &$dia, &$mes) {
	$i = 0;
	$dia = "";
	while ($text[$i] >= '0' && $text[$i] <= '9') {
		$dia = $dia . $text[$i];
		$i++;
	}
	if (strlen($dia) == 0 || strlen($dia) > 2)
		return false;
	while ($text[$i] == ' ')
		$i++;
	$mes = obtenerMesMovistarPDF(substr($text, $i, 3));
	if ($mes == "0")
		return false;
	return true;
}

?>
