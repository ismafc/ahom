<?php
if (!isset($mainFolder))
	$mainFolder = "./";	
include_once($mainFolder . "Lib/facturasBase.inc");

$version_XML = "";
$operador_llamante_XML = "";
$titular_XML = "";
$numero_movil_llamante_XML = "";
$coste_total_XML = -1;
$periodo_XML = "";
$fecha_hora_XML = array();
$telefono_llamado_XML = array();
$tipo_llamada_XML = array();
$duracion_XML = array();
$coste_XML = array();
$coste_total_calculado_XML = 0;

// Estado
// -2 : Estado de error
// -1 : Esperando el tag inicial FACTURA
// 0 : Estoy en FACTURA
// 1 : Estoy en FACTURA->VERSION
// 2 : Estoy en FACTURA->NUMERO_MOVIL_LLAMANTE
// 3 : Estoy en FACTURA->TITULAR
// 4 : Estoy en FACTURA->PERIODO
// 5 : Estoy en FACTURA->COSTE
// 6 : Estoy en FACTURA->OPERADOR
// 7 : Estoy en FACTURA->LLAMADAS
// 8 : Estoy en FACTURA->LLAMADAS->LLAMADA
// 9 : Estoy en FACTURA->LLAMADAS->LLAMADA->NUMERO_MOVIL_LLAMADO
// 10 : Estoy en FACTURA->LLAMADAS->LLAMADA->OPERADOR
// 11 : Estoy en FACTURA->LLAMADAS->LLAMADA->TIPO
// 12 : Estoy en FACTURA->LLAMADAS->LLAMADA->AMBITO
// 13 : Estoy en FACTURA->LLAMADAS->LLAMADA->FECHA
// 14 : Estoy en FACTURA->LLAMADAS->LLAMADA->DURACION
// 15 : Estoy en FACTURA->LLAMADAS->LLAMADA->COSTE
$estado_XML = -1;

$data_XML = ""; // Para acumular los data de los tags
$tag_XML = "";  // Para saltar tags que no se reconocen

$numero_llamadas_XML = 0;

// Ahora es necesario para obtener el tipo llamada
$operador_XML = "";
$tipo_XML = "";
$ambito_XML = "";

function obtenerTipoLlamada()
{
    global $operador_XML;
    global $tipo_XML;
    global $ambito_XML;
    global $numero_llamadas_XML;
    global $tipo_llamada_XML;
    global $telefono_llamado_XML;
    
    //echo $operador_XML . " - " . $tipo_XML . " - " . $ambito_XML . "<br>";
    if ($operador_XML == "FIJO" && $tipo_XML == "VOZ" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 1;
    else if ($operador_XML == "VODAFONE" && $tipo_XML == "VOZ" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 2;
    else if ($operador_XML == "MOVISTAR" && $tipo_XML == "VOZ" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 3;
    else if ($operador_XML == "ORANGE" && $tipo_XML == "VOZ" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 4;
    else if ($operador_XML == "MOVISTAR" && $tipo_XML == "SMS" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 5;
    else if ($operador_XML == "VODAFONE" && $tipo_XML == "SMS" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 6;
    else if ($operador_XML == "ORANGE" && $tipo_XML == "SMS" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL"))
        $tipo_llamada_XML[$numero_llamadas_XML] = 7;
    else if ($operador_XML == "DESCONOCIDO" && $tipo_XML == "VOZ" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL")) {
        $idOP = obtenerIdOperadorProbable(substr($telefono_llamado_XML[$numero_llamadas_XML], 0, 3));
        if ($idOP == 1)
            $tipo_llamada_XML[$numero_llamadas_XML] = 1003; // Ponemos MOVIL_MOVISTAR
        else if ($idOP == 2)
            $tipo_llamada_XML[$numero_llamadas_XML] = 1004; // Ponemos MOVIL_ORANGE
        else
            $tipo_llamada_XML[$numero_llamadas_XML] = 1002; // Ponemos MOVIL_VODAFONE
    }
    else if ($operador_XML == "DESCONOCIDO" && $tipo_XML == "SMS" && ($ambito_XML == "LOCAL" || $ambito_XML == "NACIONAL")) {
        $idOP = obtenerIdOperadorProbable(substr($telefono_llamado_XML[$numero_llamadas_XML], 0, 3));
        if ($idOP == 1)
            $tipo_llamada_XML[$numero_llamadas_XML] = 1005; // Ponemos SMS_MOVISTAR
        else if ($idOP == 2)
            $tipo_llamada_XML[$numero_llamadas_XML] = 1007; // Ponemos SMS_ORANGE
        else
            $tipo_llamada_XML[$numero_llamadas_XML] = 1006; // Ponemos SMS_VODAFONE
    }
    else
        $tipo_llamada_XML[$numero_llamadas_XML] = 18;
    return true;
}

function obtenerIdOperador($nombre, &$id)
{
    $sql = "SELECT id FROM operadores WHERE nombre = '$nombre'";
    //echo $sql . "<br>";
    $result = mysql_query($sql);
    if ($result == 0)
        return false;
    $row_array = mysql_fetch_row($result);
    if (!isset($row_array[0]))
        return false;
    $id = $row_array[0];
    //echo $id . "<br>";
    return true;
}

function startElement($parser, $name, $attrs) 
{
    //echo $name . "<br>";
    global $estado_XML;
    if ($estado_XML == -2)
        return;
    global $tag_XML;
    if ($tag_XML != "")
        return;
    global $data_XML;
    global $data_XML;
    $data_XML = "";
    if ($name == "FACTURA" && $estado_XML == -1)
        $estado_XML = 0;
    else if ($name == "VERSION" && $estado_XML == 0)
        $estado_XML = 1;
    else if ($name == "NUMERO_MOVIL_LLAMANTE" && $estado_XML == 0)
        $estado_XML = 2;
    else if ($name == "TITULAR" && $estado_XML == 0)
        $estado_XML = 3;
    else if ($name == "PERIODO" && $estado_XML == 0)
        $estado_XML = 4;
    else if ($name == "COSTE" && $estado_XML == 0)
        $estado_XML = 5;
    else if ($name == "OPERADOR" && $estado_XML == 0)
        $estado_XML = 6;
    else if ($name == "LLAMADAS" && $estado_XML == 0)
        $estado_XML = 7;
    else if ($name == "LLAMADA" && $estado_XML == 7)
        $estado_XML = 8;
    else if ($name == "NUMERO_MOVIL_LLAMADO" && $estado_XML == 8)
        $estado_XML = 9;
    else if ($name == "OPERADOR" && $estado_XML == 8)
        $estado_XML = 10;
    else if ($name == "TIPO" && $estado_XML == 8)
        $estado_XML = 11;
    else if ($name == "AMBITO" && $estado_XML == 8)
        $estado_XML = 12;
    else if ($name == "FECHA" && $estado_XML == 8)
        $estado_XML = 13;
    else if ($name == "DURACION" && $estado_XML == 8)
        $estado_XML = 14;
    else if ($name == "COSTE" && $estado_XML == 8)
        $estado_XML = 15;
    else {
        $tag_XML = $name;
        //echo $name . "<br>";
    }
}

function endElement($parser, $name) 
{
    //echo $name . "<br>";
    global $estado_XML;
    if ($estado_XML == -2)
        return;
    global $numero_llamadas_XML;
    global $data_XML;
    global $tag_XML;
    global $version_XML;
    global $operador_llamante_XML;
    global $titular_XML;
    global $numero_movil_llamante_XML;
    global $coste_total_XML;
    global $periodo_XML;
    global $fecha_hora_XML;
    global $telefono_llamado_XML;
    global $duracion_XML;
    global $coste_XML;
    global $operador_XML;
    global $tipo_XML;
    global $ambito_XML;
    global $coste_total_calculado_XML;
    
    if ($name == "FACTURA" && $estado_XML == 0) {
        $estado_XML = -1;
        //echo "Total en factura : " . $coste_total_XML . "<br>";
        //echo "Calculado : " . $coste_total_calculado_XML . "<br>";
    }
    else if ($name == "VERSION" && $estado_XML == 1) {
        if ($data_XML == "1.0") {
            $version_XML = $data_XML;
            $estado_XML = 0;
        }
        else {
            $estado_XML = -2;
            //echo "Versión incorrecta!!!!<br>";
        }
    }
    else if ($name == "NUMERO_MOVIL_LLAMANTE" && $estado_XML == 2) {
        if (ereg("^[0-9]+$", $data_XML)) {
            $numero_movil_llamante_XML = $data_XML;
            $estado_XML = 0;
        }
        else {
            $estado_XML = -2;
            //echo "Número móvil llamante incorrecto!!!!<br>";
        }
    }
    else if ($name == "TITULAR" && $estado_XML == 3) {
        $titular_XML = $data_XML;
        $estado_XML = 0;
    }
    else if ($name == "PERIODO" && $estado_XML == 4) {
        $periodo_XML = $data_XML;
        $estado_XML = 0;
    }
    else if ($name == "COSTE" && $estado_XML == 5) {
        $c = str_replace(",", ".", $data_XML);
        if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
            $coste_total_XML = $c;
            $estado_XML = 0;
        }
        else {
            $estado_XML = -2;
            //echo "Coste de la factura incorrecto!!!!<br>";
        }
    }
    else if ($name == "OPERADOR" && $estado_XML == 6) {
        if (obtenerIdOperador($data_XML, $idOp)) {
            $operador_llamante_XML = $idOp;
            $estado_XML = 0;
        }
        else {
            $estado_XML = -2;
            //echo "Operador de la factura incorrecto!!!!<br>";
        }
    }
    else if ($name == "LLAMADAS" && $estado_XML == 7)
        $estado_XML = 0;
    else if ($name == "LLAMADA" && $estado_XML == 8) {
        obtenerTipoLlamada();
        $estado_XML = 7;
        $numero_llamadas_XML++;
    }
    else if ($name == "NUMERO_MOVIL_LLAMADO" && $estado_XML == 9) {
        if (ereg("^[0-9]+$", trim($data_XML))) {
            $telefono_llamado_XML[$numero_llamadas_XML] = trim($data_XML);
            $estado_XML = 8;
        }
        else {
            $estado_XML = -2;
            //echo "Número móvil llamado incorrecto!!!!<br>";
        }
    }
    else if ($name == "OPERADOR" && $estado_XML == 10) {
        $operador_XML = $data_XML;
        $estado_XML = 8;
    }
    else if ($name == "TIPO" && $estado_XML == 11) {
        $tipo_XML = $data_XML;
        $estado_XML = 8;
    }
    else if ($name == "AMBITO" && $estado_XML == 12) {
        $ambito_XML = $data_XML;
        $estado_XML = 8;
    }
    else if ($name == "FECHA" && $estado_XML == 13) {
	if (ereg("^[0-9][0-9]/[0-9][0-9]/[0-9][0-9][0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]$", $data_XML)) {
            $dia = substr($data_XML, 0, 2);
            $mes = substr($data_XML, 3, 2);
            $year = substr($data_XML, 6, 4);
            $hora = substr($data_XML, 11, 8);
            $fecha_hora_XML[$numero_llamadas_XML] = date($year . "-" . $mes . "-" . $dia . " " . $hora);
            $estado_XML = 8;
        }
        else {
            $estado_XML = -2;
            //echo "Fecha incorrecta!!!!<br>";
        }
    }
    else if ($name == "DURACION" && $estado_XML == 14) {
        if (ereg("^[0-9]+$", $data_XML)) {
            $duracion_XML[$numero_llamadas_XML] = $data_XML;
            $estado_XML = 8;
        }
        else if (ereg("^[0-9][0-9]:[0-9][0-9]:[0-9][0-9]$", $data_XML)) {
            $horas = substr($data_XML, 0, 2);
            $minutos = substr($data_XML, 3, 2);
            $segundos = $horas * 3600 + $minutos * 60 + substr($data_XML, 6, 2);
            $duracion_XML[$numero_llamadas_XML] = $segundos;
            $estado_XML = 8;
        }
        else {
            $estado_XML = -2;
            //echo "Duración incorrecta!!!!<br>";
        }
    }
    else if ($name == "COSTE" && $estado_XML == 15) {
        $c = str_replace(",", ".", $data_XML);
        if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
            $coste_XML[$numero_llamadas_XML] = $c;
            $coste_total_calculado_XML += $c;
            $estado_XML = 8;
        }
        else {
            $estado_XML = -2;
            //echo "Coste incorrecto!!!!<br>";
        }
    }
    else if ($tag_XML == $name)
        $tag_XML = "";
    else {
        $estado_XML = -2;
        //echo "Estructura general incorrecta!!!!<br>";
    }
    $data_XML = "";
}

function characterData($parser, $data) 
{
    //echo $data . "<br>";
    global $estado_XML;
    if ($estado_XML == -2)
        return;
    global $tag_XML;
    if ($tag_XML != "")
        return;
    global $data_XML;
    $data_XML .= $data;
}

function analizeXML(&$_buffer, &$operador, &$titular, &$numero_movil_llamante, &$coste_total, &$periodo, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) 
{
    global $estado_XML;
    $xml_parser = xml_parser_create("UTF-8");
    // use case-folding so we are sure to find the tag in $map_array
    xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
    xml_set_element_handler($xml_parser, "startElement", "endElement");
    xml_set_character_data_handler($xml_parser, "characterData");
    if (!xml_parse($xml_parser, $_buffer)) {
        $estado_XML = -1;
        $buffer = utf8_encode($_buffer);
        $xml_parser = xml_parser_create("UTF-8");
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
        xml_set_element_handler($xml_parser, "startElement", "endElement");
        xml_set_character_data_handler($xml_parser, "characterData");
        if (!xml_parse($xml_parser, $buffer))
            return false;
    }

    xml_parser_free($xml_parser);
    //echo $estado_XML . "<br>";
    if ($estado_XML != -1)
        return false;
    
    global $data_XML;
    global $tag_XML;
    global $version_XML;
    global $operador_llamante_XML;
    global $titular_XML;
    global $numero_movil_llamante_XML;
    global $coste_total_XML;
    global $periodo_XML;
    global $fecha_hora_XML;
    global $telefono_llamado_XML;
    global $tipo_llamada_XML;
    global $duracion_XML;
    global $coste_XML;
    global $numero_llamadas_XML;
    //echo $numero_llamadas_XML . "<br>";
    $operador = $operador_llamante_XML;
    $titular = $titular_XML;
    $numero_movil_llamante = $numero_movil_llamante_XML;
    $coste_total = $coste_total_XML;
    $periodo = $periodo_XML;
    for ($i = 0; $i < $numero_llamadas_XML; $i++) {
        $fecha_hora[$i] = $fecha_hora_XML[$i];
        $telefono_llamado[$i] = $telefono_llamado_XML[$i];
        $tipo_llamada[$i] = $tipo_llamada_XML[$i];
        $duracion[$i] = $duracion_XML[$i];
        $coste[$i] = $coste_XML[$i];
    }
    return true;
}

?>
