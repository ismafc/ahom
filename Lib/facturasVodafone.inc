<?php
if (!isset($mainFolder))
	$mainFolder = "./";
include_once($mainFolder . "Lib/facturasBase.inc");

//
// Funciones para analizar las facturas
//

function getTitularPDFVodafone(&$buffer, $line) {
    $pos = strpos($line, "Titular:");
    if ($pos === false)
        $pos = strpos($line, "Titularra:");
    $line = substr($line, $pos);
    $pos = strpos($line, "(");
    $titular = "";
    while ($pos > 0) {
        $line = substr($line, $pos + 1);
        $pos = strpos($line, ")");
        $titular = $titular . " " . substr($line, 0, $pos);
        $pos = strpos($line, "(");
    }
    if (strlen($titular) == 0) {
        // No est? en la misma l?nea!
        $state = 0;
        while (!(($line = nextline($buffer, $state)) === false)) {
            if (strpos($line, "TJ") > 0 || strpos($line, "Tj") > 0) {
                $titular = "";
                $pos = strpos($line, "(");
                while ($pos > 0) {
                    $line = substr($line, $pos + 1);
                    $pos = strpos($line, ")");
                    $titular = $titular . " " . substr($line, 0, $pos);
                    $pos = strpos($line, "(");
                }
                break;
            }
        }
    }
    return $titular;
}

function getTelefonoLlamantePDFVodafone($line, $telefono) {
    $pos = strpos($line, "Tel\\351fono");
    if ($pos === false) {
        $pos = strpos($line, "Telefonoa");
        if ($pos === false)
            $pos = strpos($line, "Tel\\350fon");
    }
    $line = substr($line, $pos);
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $line = substr($line, 0, $pos);
    if (!ereg("^[0-9]+$", $line))
        return $telefono;
    if ($telefono == "")
        $telefono = $line;
    else if (strpos($telefono, $line) === false)
        $telefono .= ", " . $line;	
    return $telefono;
}

function getCosteFacturaPDFVodafone($line, $coste) {
    $pos = strpos($line, "M\\363vil");
    if ($pos === false) {
        $pos = strpos($line, "guztira");
        if ($pos === false)
            $pos = strpos($line, "M\\362bil");
    }
    $line = substr($line, $pos);
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $coste1 = substr($line, 0, $pos);
    $_coste_total = str_replace(",", ".", $coste1);	
    if ($_coste_total == 0) {
        for ($i = 0; $i < count($coste); $i++) {
            $_coste_total += $coste[$i];
        }
    }
    return $_coste_total * 1.16;
}

function getCosteFacturaPDFVodafone1(&$buffer, $line, $coste) {
    $state = 0;
    $_coste_total = 0;
    while (!(($line = nextline($buffer, $state)) === false)) {
        if (strpos($line, "TJ") > 0 || strpos($line, "Tj") > 0) {
            $pos = strpos($line, "(");
            $line = substr($line, $pos + 1);
            $pos = strpos($line, ")");
            $coste1 = substr($line, 0, $pos);
            $_coste_total = str_replace(",", ".", $coste1);	
            break;
        }
    }
    if ($_coste_total == 0) {
        for ($i = 0; $i < count($coste); $i++) {
            $_coste_total += $coste[$i];
        }
	$_coste_total = $_coste_total * 1.16;
    }
    return $_coste_total;
}

function getPeriodoPDFVodafone(&$buffer, $line, $fecha_hora, &$year) {
    $esvasco = false;
    $escatalan = false;
    $first = 1;
    $_periodo = "";
    $pos = strpos($line, "facturaci\\363n:");
    if ($pos === false) { // No es castellano
        $line = str_replace("\\(", "[", $line);
        $line = str_replace("\\)", "]", $line);
        $pos = strpos($line, "facturaci\\363:");
        if ($pos === false) { // No es catal?n
            $pos = strpos($line, "epealdia:");
            $esvasco = true;
        }
        else
            $escatalan = true;
    }
    $line = substr($line, $pos);
    $pos = strpos($line, "(");
    while ($pos > 0) {
        $line = substr($line, $pos + 1);
        if ($first == 1) {
            if ($esvasco == true)
                $year = substr($line, 0, 4);
            else
                $year = substr($line, 6, 4);
            $first = 0;
        }
        $pos = strpos($line, ")");
        $_periodo = $_periodo . " " . substr($line, 0, $pos);
        $pos = strpos($line, "(");
    }
    if (strlen($_periodo) == 0 && count($fecha_hora) > 0) {
        $origen = getDate($fecha_hora[0]);
        $destino = getDate($fecha_hora[count($fecha_hora) - 1]);
        return $origen["mday"] + "/" + $origen["mon"] + "/" + $origen["year"] + " al " + 
               $destino["mday"] + "/" + $destino["mon"] + "/" + $destino["year"];
    }
    else {
        // No est? en la misma l?nea!
        $state = 0;
        while (!(($line = nextline($buffer, $state)) === false)) {
            if (strpos($line, "TJ") > 0 || strpos($line, "Tj") > 0) {
                $pos = strpos($line, "(");
                while ($pos > 0) {
                    $line = substr($line, $pos + 1);
                    if ($first == 1) {
                        if ($esvasco == true)
                            $year = substr($line, 0, 4);
                        else
                            $year = substr($line, 6, 4);
                        $first = 0;
                    }
                    $pos = strpos($line, ")");
                    $_periodo = $_periodo . " " . substr($line, 0, $pos);
                    $pos = strpos($line, "(");
                }
                if (strlen($_periodo) == 0 && count($fecha_hora) > 0) {
                    $origen = getDate($fecha_hora[0]);
                    $destino = getDate($fecha_hora[count($fecha_hora) - 1]);
                    return $origen["mday"] + "/" + $origen["mon"] + "/" + $origen["year"] + " al " + 
                           $destino["mday"] + "/" + $destino["mon"] + "/" + $destino["year"];
                }
                break;
            }
        }
    }
    return $_periodo;
}

function obtenerMesVodafonePDF($mes) {
    if ($mes == "ene.")
        return "1";
    else if ($mes == "feb.")
        return "2";
    else if ($mes == "mar.")
        return "3";
    else if ($mes == "abr.")
        return "4";
    else if ($mes == "may.")
        return "5";
    else if ($mes == "jun.")
        return "6";
    else if ($mes == "jul.")
        return "7";
    else if ($mes == "ago.")
        return "8";
    else if ($mes == "sep.")
        return "9";
    else if ($mes == "oct.")
        return "10";
    else if ($mes == "nov.")
        return "11";
    else if ($mes == "dic.")
        return "12";
    return "0";
}

function esPrimeraPartePDFVodafone($line) {
    //echo $line . "<br>";
    $pos = strpos($line, "(");
    if ($pos === false)
        return false;
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $dia = substr($line, 0, $pos);
    if (!ereg("^[0-9]{2}$", $dia))
            return false;
    $pos = strpos($line, "(");
    if ($pos === false)
            return false;
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $mes = substr($line, 0, $pos);
    $mes = obtenerMesVodafonePDF($mes);
    if ($mes == "0")
        return false;
    return true;
}

function getLlamadaPrimeraPartePDFVodafone($line, &$_buffer, &$_state, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
    $numero_llamadas = count($fecha_hora);
//	if ($numero_llamadas == 379)
//		exit();
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $dia = substr($line, 0, $pos);
    if (!ereg("^[0-9]{2}$", $dia)) {
        //echo "Final de bloque : " . $line . "<br>";
        return 10;
    }
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $mes = substr($line, 0, $pos);
    $mes = obtenerMesVodafonePDF($mes);

    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $hora = substr($line, 0, $pos);

    $fecha_hora[$numero_llamadas] = date($year . "-" . $mes . "-" . $dia . " " . $hora . ":00");

    $tipo_destino = "";
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $numero_llamado = substr($line, 0, $pos);
    if (!ereg("^[0-9]+$", $numero_llamado)) {
        if (ereg("^[0-9]+:[0-9]+$", $numero_llamado)) {
            $pos = strpos($line, "(");
            $line = substr($line, $pos + 1);
            $pos = strpos($line, ")");
            $numero_llamado = substr($line, 0, $pos);
        }
        $telefono_llamado[$numero_llamadas] = $numero_llamado;
        $tipo_destino = $numero_llamado;
        $duracion[$numero_llamadas] = 0;
        $tipo_llamada[$numero_llamadas] = 18;
        //echo $fecha_hora[$numero_llamadas] . " ; " . $telefono_llamado[$numero_llamadas] . " ; " . $tipo_llamada[$numero_llamadas] . " ; " . $duracion[$numero_llamadas] . "<br>";
        return 13;
    }
    $telefono_llamado[$numero_llamadas] = $numero_llamado;

    $first = 1;
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $field = substr($line, 0, $pos);
    while (!ereg("^[0-9]+:[0-9]+$", $field)) {
        if ($first == 1) {
            $tipo_destino = $field;
            $first = 0;
        }
        else
            $tipo_destino = $tipo_destino . " " . $field;
        $pos = strpos($line, "(");
        if ($pos === false) {
            $line = nextline($_buffer, $_state);
            $pos = strpos($line, "(");
        }
        $line = substr($line, $pos + 1);
        $pos = strpos($line, ")");
        $field = substr($line, 0, $pos);
        if (ereg("^[0-9]+$", $field))
            break;
    }

    $pos = strpos($field, ":");
    if ($pos === false)
        $duracion[$numero_llamadas] = $field;
    else
        $duracion[$numero_llamadas] = substr($field, 0, $pos) * 60 + substr($field, $pos + 1);

    $tipo_llamada[$numero_llamadas] = obtenerTipoLlamadaVodafone($tipo_destino, $telefono_llamado[$numero_llamadas], 3);
    //echo $fecha_hora[$numero_llamadas] . " ; " . $telefono_llamado[$numero_llamadas] . " ; " . $tipo_llamada[$numero_llamadas] . " ; " . $duracion[$numero_llamadas] . "<br>";

    return 13;
}

function getLlamadaSegundaPartePDFVodafone($line, &$coste) {
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    $field = substr($line, 0, $pos);
    $field = str_replace(",", ".", $field);
    if (!ereg("^[0-9]+\.[0-9]+$", $field))
        return 13;
    $coste[count($coste)] = $field;
    return 12;
}

function obtenerTipoLlamadaVodafone($descripcion, $telefono, $idOperador) {
    //echo $descripcion . "<br>";
    $pos = strpos($descripcion, "Premium");
    if (!($pos === false))
        return 18;  // Especial Premium Servicios SMS
    $pos = strpos($descripcion, "Especial");
    if (!($pos === false)) {
        if (strpos($descripcion, "a2") > 0)
            return 2; // Ponemos MOVIL_VODAFONE porque es un plan a2
        else if (strpos($descripcion, "QTAL!") > 0)
            return 2; // Ponemos MOVIL_VODAFONE porque es un plan QTAL!
        else
            return 18; // Especial
    }
    $pos = strpos($descripcion, "Mensaje Corto");
    if (!($pos === false)) {
        $pos = strpos($descripcion, "vil");
        if (!($pos === false)) {
            // Hay que elegir y no es seguro
            $idOP = obtenerIdOperadorProbable(substr($telefono, 0, 3));
            if ($idOP == 1)
                return 1005; // Ponemos SMS_MOVISTAR
            else
                return 1007; // Ponemos SMS_ORANGE
        }
        return 6; // Seguro SMS_VODAFONE
    }
    $pos = strpos($descripcion, "SMS");
    if (!($pos === false)) {
        if (strpos($descripcion, "a2") > 0)
            return 6; // Ponemos SMS_VODAFONE porque es un plan a2
        else if (strpos($descripcion, "QTAL!") > 0)
            return 6; // Ponemos SMS_VODAFONE porque es un plan QTAL!
        else if (strpos($descripcion, "Vodafone") > 0)
            return 6; // Ponemos SMS_VODAFONE
        else {
            // Hay que elegir y no es seguro
            $idOP = obtenerIdOperadorProbable(substr($telefono, 0, 3));
            if ($idOP == 1)
                return 1005; // Ponemos SMS_MOVISTAR
            else
                return 1007; // Ponemos SMS_ORANGE
        }
    }
    $pos = strpos($descripcion, "Nacional");
    if (!($pos === false)) {
        $pos = strpos($descripcion, "vil");
        if (!($pos === false)) {
            // Hay que elegir y no es seguro
            $idOP = obtenerIdOperadorProbable(substr($telefono, 0, 3));
            if ($idOP == 1)
                return 1003; // Ponemos MOVIL_MOVISTAR
            else
                return 1004; // Ponemos MOVIL_ORANGE
        }
        return 1; // Ponemos FIJO
    }
    $pos = strpos($descripcion, "m. Vodafone");
    if (!($pos === false))
        return 2; // Ponemos MOVIL_VODAFONE
    $pos = strpos($descripcion, "Cuenta Familiar");
    if (!($pos === false))
        return 2; // Ponemos MOVIL_VODAFONE
    $pos = strpos($descripcion, "m. habitual Vodafone");
    if (!($pos === false))
        return 2; // Ponemos MOVIL_VODAFONE
    $pos = strpos($descripcion, "Provincial");
    if (!($pos === false))
        return 1; // Ponemos FIJO
    return 1018;  // Ponemos Especial pero no es seguro
}

?>
