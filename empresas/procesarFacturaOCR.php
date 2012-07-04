<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Procesado de facturas</title>
<link rel="stylesheet" href="ProcesarEnvioFactura.css" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body>
<?php
function extraerDatosLlamada($_line) {
    echo "<llamada>";
    //echo $_line . "<br>";

    if (strpos($_line, "Vodafone") !== false)
        echo "<operador>VODAFONE</operador>";
    else if (strpos($_line, "Fijo") !== false || strpos($_line, "nacional") !== false)
        echo "<operador>FIJO</operador>";
    else
        echo "<operador>DESCONOCIDO</operador>";
        
    if (strpos($_line, "Especial") !== false || strpos($_line, "Contestador") !== false ||
        strpos($_line, "Navegaci") !== false || strpos($_line, "live!") !== false)
        echo "<tipo>ESPECIAL</tipo>";
    else if (strpos($_line, "Fijo") !== false || strpos($_line, "nacional") !== false)
        echo "<tipo>VOZ</tipo>";
    else if (strpos($_line, "Mensaje") !== false)
        echo "<tipo>SMS</tipo>";
    else 
        echo "<tipo>VOZ</tipo>";

    echo "<ambito>LOCAL</ambito>";
    
    $pos = false;
    $mes = "00";
    if (($pos = strpos($_line, "Ene.")) !== false || ($pos = strpos($_line, "Ene,")) !== false)
        $mes = "01";
    else if (($pos = strpos($_line, "Feb.")) !== false || ($pos = strpos($_line, "Feb,")) !== false)
        $mes = "02";
    else if (($pos = strpos($_line, "Mar.")) !== false || ($pos = strpos($_line, "Mar,")) !== false)
        $mes = "03";
    else if (($pos = strpos($_line, "Abr.")) !== false || ($pos = strpos($_line, "Abr,")) !== false)
        $mes = "04";
    else if (($pos = strpos($_line, "May.")) !== false || ($pos = strpos($_line, "May,")) !== false)
        $mes = "05";
    else if (($pos = strpos($_line, "Jun.")) !== false || ($pos = strpos($_line, "Jun,")) !== false)
        $mes = "06";
    else if (($pos = strpos($_line, "Jul.")) !== false || ($pos = strpos($_line, "Jul,")) !== false)
        $mes = "07";
    else if (($pos = strpos($_line, "Ago.")) !== false || ($pos = strpos($_line, "Ago,")) !== false)
        $mes = "08";
    else if (($pos = strpos($_line, "Sep.")) !== false || ($pos = strpos($_line, "Sep,")) !== false)
        $mes = "09";
    else if (($pos = strpos($_line, "Oct.")) !== false || ($pos = strpos($_line, "Oct,")) !== false)
        $mes = "10";
    else if (($pos = strpos($_line, "Nov.")) !== false || ($pos = strpos($_line, "Nov,")) !== false)
        $mes = "11";
    else if (($pos = strpos($_line, "Dic.")) !== false || ($pos = strpos($_line, "Dic,")) !== false)
        $mes = "12";
    if ($pos !== false) {
        $dia = substr($_line, $pos - 3, 2);
        if (substr($dia, 0, 1) == "\"")
            $dia = substr($_line, 1, 1);
        echo "<fecha>";
        echo (strlen($dia) == 1 ? "0" : "");
        echo $dia;
        echo "/" . $mes . "/2008 ";
        $pos += 4;
        $_line = trim(substr($_line, $pos));
        if (substr($_line, 0, 1) == "\"")
            $_line = trim(substr($_line, 3));
        echo substr($_line, 0, 5) . ":00";
        echo "</fecha>";
        $_line = trim(substr($_line, 5));
        if (substr($_line, 0, 1) == "\"")
            $_line = trim(substr($_line, 3));
        $pos = strpos($_line, "\";");
        if ($pos == 0)
            echo "<numero_movil_llamado>555</numero_movil_llamado>";
        else
            echo "<numero_movil_llamado>" . substr($_line, 0, $pos) . "</numero_movil_llamado>";
        $_line = trim(substr($_line, $pos + 2));

        $pos = strrpos($_line, "\";\"") + 3;
        $pos1 = strrpos($_line, "\"");
        $coste = str_replace(",", ".", substr($_line, $pos, $pos1 - $pos));
        echo "<coste>" . $coste . "</coste>";
        
        echo "<duracion>";
        $pos = strrpos($_line, "Normal") - 1;
        if (substr($_line, $pos, 1) == "\"")
            echo "1"; /// NAvegación live
        else {
            $_line = trim(substr($_line, 0, $pos));
            $_line = substr($_line, strlen($_line) - 5, 5);
            if (substr($_line, 0, 1) == "\"")
                echo substr($_line, 1, 1) * 60 + substr($_line, 3, 2);
            else
                echo substr($_line, 0, 2) * 60 + substr($_line, 3, 2);
        }
        echo "</duracion>";
    }
    echo "</llamada>";
    //echo "<br><br>";
}

function otralinea(&$_buffer) {
    $pos = strpos($_buffer, "\n");
    if ($pos === false)
        return false;
    $pos1 = strpos($_buffer, "\r");
    if ($pos1 !== false && $pos1 < $pos)
        $pos = $pos1;
    $line = substr($_buffer, 0, $pos);
    $_buffer = substr($_buffer, $pos + 1);
    $i = substr($_buffer, 0, 1);
    while ($i == "\r" || $i == "\n") {
        $_buffer = substr($_buffer, 1);
        $i = substr($_buffer, 0, 1);
    }
    //echo $line . "<br>";
    return $line;
}

function empiezaBloque($_line)
{
    $exitos = 0;
    if (strpos($_line, "Fecha") !== false)
        $exitos++;
    if (strpos($_line, "Hora") !== false)
        $exitos++;
    if (strpos($_line, "receptor") !== false)
        $exitos++;
    if (strpos($_line, "Tipo") !== false)
        $exitos++;
    if (strpos($_line, "Destino") !== false)
        $exitos++;
    if (strpos($_line, "Minutos") !== false)
        $exitos++;
    if (strpos($_line, "Tarifa") !== false)
        $exitos++;
    if (strpos($_line, "Importe") !== false)
        $exitos++;
    if (strpos($_line, ";\"\";\"\";\"\";") !== false)
        $exitos++;
    if ($exitos > 3)
        return true;
    else
        return false;
}

function finalBloque($_line)
{
    if (strlen($_line) > 95) {
        //echo "------> " . strlen($_line) . " ----> " . $_line . "<br>";
        return true;
    }
    if (strlen($_line) < 70) {
        if (strpos($_line, ";\"\";\"\";\"\";") !== false)
            return false;
        if (strpos($_line, "Navegaci") !== false && strpos($_line, "live!"))
            return false;
        //echo "------> " . strlen($_line) . " ----> " . $_line . "<br>";
        return true;
    }
    return false;
}

if (!isset($mainFolder))
    $mainFolder = "../";
include($mainFolder . "Lib/library.inc");
include($mainFolder . "Lib/main.inc");
include($mainFolder . "Lib/facturas.inc");
include($mainFolder . "Lib/base.inc");
if (openDatabase() == false)
    exit();

if ($_FILES["FacturaPdfMovistar1b"]["name"] != false) {
    $temp_file = $_FILES["FacturaPdfMovistar1b"]["tmp_name"];

    $content = "";
    $size = filesize($temp_file);
    if  ($size > 0) {
        $fp = fopen($temp_file, "r");
        $content = fread($fp, $size);
        fclose($fp);
    }

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
    echo "<factura>";
    echo "<version>1.0</version>";
    echo "<numero_movil_llamante>661832614</numero_movil_llamante>";
    echo "<titular>Aperitivos y extrusionados SA</titular>";
    echo "<periodo>05/07/2008 - 04/08/2008</periodo>";
    echo "<operador>VODAFONE</operador>";
    echo "<llamadas>";
    
    // ANALIZAR CONTENT!!!
    $llamadas = 0;
    $estado = 0;
    while (!(($line = otralinea($content)) === false)) {        
        //echo $line . "<br>";
        if ($estado == 0) {
            if (empiezaBloque($line))
                $estado = 1;
        }
        else if ($estado == 1) {
            if (finalBloque($line))
                $estado = 0;
            else {
                //echo $line . "<br>";
                if (strpos($line, ";\"\";\"\";\"\";") === false) {
                    extraerDatosLlamada($line);
                    $llamadas++;
                }
            }
        }
    }
    echo "</llamadas>";
    echo "</factura>\r\n";
    //echo "Llamadas: " . $llamadas . "<br>";
}
?>
</body>
</html>