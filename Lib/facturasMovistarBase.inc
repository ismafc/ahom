<?php
if (!isset($mainFolder))
	$mainFolder = "./";
include_once($mainFolder . "Lib/facturasBase.inc");

function obtenerMesMovistarPDF($mes) {
    if ($mes == "Gen" || $mes == "Ene" || $mes == "Xan")
        return "1";
    else if ($mes == "Feb")
        return "2";
    else if ($mes == "Mar")
        return "3";
    else if ($mes == "Abr")
        return "4";
    else if ($mes == "Mai" || $mes == "May")
        return "5";
    else if ($mes == "Jun" || $mes == "Xun")
        return "6";
    else if ($mes == "Jul" || $mes == "Xul")
        return "7";
    else if ($mes == "Ago")
        return "8";
    else if ($mes == "Sep" || $mes == "Set")
        return "9";
    else if ($mes == "Oct" || $mes == "Out")
        return "10";
    else if ($mes == "Nov")
        return "11";
    else if ($mes == "Des" || $mes == "Dic" || $mes == "Dec")
        return "12";
    return "0";
}

function obtenerDuracionMovistar($d) {
    $resultado = 0;
    $i = 0;
    $valor = "";	
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

?>
