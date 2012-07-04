<?php
if (!isset($mainFolder))
	$mainFolder = "./";
include($mainFolder . "Lib/facturasMovistarOld.inc");
include($mainFolder . "Lib/facturasMovistarNew.inc");
include($mainFolder . "Lib/facturasVodafone.inc");
include($mainFolder . "Lib/facturasAmena.inc");
include($mainFolder . "Lib/facturasXML.inc");

//
// Funciones para analizar las facturas
//

/**********************************************************************
**
** _state: Estado del parser
** 0 = ESTADO INDEFINIDO
** 1 = STREAM DE TIPO INFORMACION (Hay que descomprimir)
** 2 = STREAM DE TIPO IMAGEN (No hace falta descomprimir)
** 3 = STREAM DE TIPO PAGINA (Hay que descomprimir)
**
** _operator: Operador que ha generado el PDF
** 0 : OPERADOR INDEFINIDO
** 1 : MOVISTAR
** 2 : VODAFONE
** 3 : ORANGE
**
** _estado_llamadas: Estado del an?lisis de las llamadas
** 0 = AUN NO SABEMOS NI EL OPERADOR
** 10 = NO ESTAMOS ANALIZANDO LLAMADAS (VODAFONE)
** 11 = HEMOS ENCONTRADO LOS TEXTOS FECHA Y HORA DE CABECERA (VODAFONE)
** 12 = ESTAMOS PREPARADOS PARA BUSCAR LA PRIMERA PARTE DE UNA LLAMADA (VODAFONE)
** 13 = HEMOS ENCONTRADO LA PRIMERA PARTE DE LA LLAMADA Y ESTAMOS PREPARADO PARA LA SEGUNDA (VODAFONE)
**
** 20 = ESTAMOS BUSCANDO EL TEL?FONO LLAMANTE (MOVISTAR)
** 22 = HEMOS ENCONTRADO EL BLOQUE E-MOCI?N O SERVICIO INTERNET (MOVISTAR)
** 23 = HEMOS ENCONTRADO EL BLOQUE DE LLAMADAS DE VOZ O VIDEOTELEFONIA (MOVISTAR)
** 24 = HEMOS ENCONTRADO EL BLOQUE DE SMS (MOVISTAR)
** 25 = HEMOS ENCONTRADO EL BLOQUE PREMIUM O EMOCION (MOVISTAR)
** 26 = HEMOS ENCONTRADO EL BLOQUE DE LLAMADAS INTERNACIONALES (MOVISTAR)
** 27 = HEMOS ENCONTRADO EL BLOQUE DE LLAMADAS RECIBIDAS EN ITINERANCIA (MOVISTAR)
** 28 = HEMOS ENCONTRADO EL BLOQUE DE SMS EN ITINERANCIA (MOVISTAR)
** 29 = HEMOS ENCONTRADO EL BLOQUE DE LLAMADAS REALIZADAS EN ITINERANCIA (MOVISTAR)
** 30 = HEMOS ENCONTRADO EL BLOQUE DE MENSAJES MULTIMEDIA (MOVISTAR)
** 31 = HEMOS ENCONTRADO EL BLOQUE DE DATOS GPRS EN ITINERANCIA (MOVISTAR)
** 32 = HEMOS ENCONTRADO EL BLOQUE DE SERVICIOS DE TARIFICACION ADICIONAL (MOVISTAR)
** 50 = HEMOS ENCONTRADO EL NUMERO LLAMANTE Y ESPERAMOS EL BLOQUE (MOVISTAR ANTIGUO)
** 51 = HEMOS ENCONTRADO LA POSICI?N DONDE SABEMOS QUE VA EL TEL?FONO LLAMANTE (MOVISTAR ANTIGUO)
**
** 100 = HEMOS ENCONTRADO NUMERO MOVIL LLAMADO (NUEVO MOVISTAR)
** 110 = HEMOS ENCONTRADO EMOCION (NUEVO MOVISTAR)
**
** 70 = ESTAMOS BUSCANDO DATOS GENERALES DE ORANGE (ORANGE)
** 71 = ESTAMOS BUSCANDO EL N?MERO DE TEL?FONO LLAMANTE (ORANGE)
** 72 = ESTAMOS BUSCANDO EL INICIO DE LAS LLAMADAS (ORANGE)
** 73 = ESTAMOS BUSCANDO LA SIGUIENTE LLAMADA (ORANGE)
**
***********************************************************************/

function analizarFactura(&$_buffer, &$operador, &$titular, &$numero_movil_llamante, &$coste_total, &$periodo, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
    $year = 2000;
    $_state = 0;
    $_estado_llamadas = 0;
    $_posiciones_columnas = array();
	$oldMovistar = false;

    $coste_total = 0;
    $periodo = "";

    $diaMS = "";
    $mesMS = "";
    $tipoMS = "";
    $destinoMS = "";
    $bloqueMS = 0;  // 0 = indefinido; 10 = nacionales; 20 = videollamadas; 30 = mensajes; 40 = Internacionales

    if (obtenerOperador($_buffer, $_state, $_estado_llamadas, $operador)) {
        if ($operador == -1) {
            if (!analizeXML($_buffer, $operador, $titular, $numero_movil_llamante, $coste_total, $periodo, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste))
                $numero_movil_llamante = "";
        }
        else {
            while (!(($line = nextline($_buffer, $_state)) === false)) {
                // Buscamos información para Vodafone
                if ($operador == 3) {
                        if (strpos($line, "TJ") > 0 || strpos($line, "Tj") > 0) {
                               //echo $line . "<br>";
                                if (strpos($line, "Per\\355odo") > 0 || strpos($line,"epealdia") > 0 || strpos($line, "Per\\355ode") > 0 )
                                        $periodo = getPeriodoPDFVodafone($_buffer, $line, $fecha_hora, $year);
                                else if (strpos($line, "Total") > 0 && strpos($line, "telefon\\355a") > 0 && strpos($line, "M\\363vil") > 0)
                                        $coste_total = getCosteFacturaPDFVodafone($line, $coste);
                                else if (strpos($line, "Sakelako") > 0 && strpos($line, "telefonia") > 0 && strpos($line, "guztira") > 0) // Vasco
                                        $coste_total = getCosteFacturaPDFVodafone($line, $coste);
                                else if (strpos($line, "Total") > 0 && strpos($line, "Telefonia") > 0 && strpos($line, "M\\362bil") > 0)
                                        $coste_total = getCosteFacturaPDFVodafone($line, $coste);
                                else if (strpos($line, "TOTAL") > 0 && strpos($line, "FACTURA") > 0)
                                        $coste_total = getCosteFacturaPDFVodafone1($_buffer, $line, $coste);
                                else if (strpos($line, "SAKELAKO") > 0 && strpos($line, "FAKTURA") > 0)
                                        $coste_total = getCosteFacturaPDFVodafone1($_buffer, $line, $coste);
                                else if (strpos($line, "Tel\\351fono") > 0 || strpos($line, "Telefonoa") > 0 || strpos($line, "Tel\\350fon"))
                                        $numero_movil_llamante = getTelefonoLlamantePDFVodafone($line, $numero_movil_llamante);
                                else if (strpos($line, "Titular:") > 0 || strpos($line, "Titularra:") > 0)
                                        $titular = getTitularPDFVodafone($_buffer, $line);
//				else if (strpos($line, "Fecha") > 0 && strpos($line, "Hora") > 0)
//					$_estado_llamadas = 11;
//				else if ($_estado_llamadas == 11 && strpos($line, "Importe") > 0)
//					$_estado_llamadas = 12;
//				else if ($_estado_llamadas == 11)
//					$_estado_llamadas = 10;
                                else if ($_estado_llamadas == 10) {
                                        if (esPrimeraPartePDFVodafone($line, $year, $_buffer) == true)
                                                $_estado_llamadas = getLlamadaPrimeraPartePDFVodafone($line, $_buffer, $_state, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                                }
                                else if ($_estado_llamadas == 12)
                                        $_estado_llamadas = getLlamadaPrimeraPartePDFVodafone($line, $_buffer, $_state, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                                else if ($_estado_llamadas == 13)
                                        $_estado_llamadas = getLlamadaSegundaPartePDFVodafone($line, $coste);
                        }
                }
                // Buscamos informaci?n para Movistar
                else if ($operador == 1) {
                        //echo "<b>" . $line . "</b><br>";
                        if ((strpos($line, "51.0000 -59.5000") > 0) && ($_estado_llamadas == 20)) {
                                //echo $line . "<br>";
								$oldMovistar = true;
                                $_estado_llamadas = 51;
                        }
                        else if ($_estado_llamadas == 51 && (strpos($line, "Tm") > 0)) {
                                $line = nextline($_buffer, $_state);
								$oldMovistar = true;
                                //echo $line . "<br>";
                                $numero_movil_llamante = getTextoEntreParentesis($line);
                                $_estado_llamadas = 50;
                        }
                        else if ($_estado_llamadas == 20 && (strpos($line, "Madrid") > 0) && strlen($line) != 23) {
								$oldMovistar = true;
                                //echo $line . "<br>";
                                $year = obtenerYearMovistar($_buffer, $_state);
                                //echo $year . " - " . $_estado_llamadas . "<br>";
                        }
                        else if ($_estado_llamadas == 50 && $line == "0.8500 w") {
								$oldMovistar = true;
                             //echo "Buscando tipo de bloque<br>";
                                $_estado_llamadas = obtenerTipoBloqueMovistar($_buffer, $_state, $_posiciones_columnas);
                                if ($_estado_llamadas == -1) {
                                        $numero_movil_llamante = "";
                                        return;
                                }
                        }
                        // Bloque de e-moci?n
                        else if ($_estado_llamadas == 22)
                                $_estado_llamadas = obtenerEmocionMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de llamadas
                        else if ($_estado_llamadas == 23)
                                $_estado_llamadas = obtenerLlamadaMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de SMS
                        else if ($_estado_llamadas == 24)
                                $_estado_llamadas = obtenerSMSMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de premium
                        else if ($_estado_llamadas == 25)
                                $_estado_llamadas = obtenerPremiumMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de llamadas internacionales
                        else if ($_estado_llamadas == 26)
                                $_estado_llamadas = obtenerLlamadasInternacionalesMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de llamadas recibidas en itinerancia
                        else if ($_estado_llamadas == 27)
                                $_estado_llamadas = obtenerLlamadasRecibidasItineranciaMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de SMS itinerancia
                        else if ($_estado_llamadas == 28)
                                $_estado_llamadas = obtenerSMSItineranciaMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de llamadas realizadas en itinerancia
                        else if ($_estado_llamadas == 29)
                                $_estado_llamadas = obtenerLlamadasRealizadasItineranciaMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de mensajes multimedia
                        else if ($_estado_llamadas == 30)
                                $_estado_llamadas = obtenerMensajesMultimediaMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de datos GPRS en itinerancia
                        else if ($_estado_llamadas == 31)
                                $_estado_llamadas = obtenerDatosGPRSItineranciaMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Bloque de Servicio de tarificacion adicional
                        else if ($_estado_llamadas == 32)
                                $_estado_llamadas = obtenerServicioTarificacionAdicionalMovistar($_buffer, $_state, $_posiciones_columnas, $year, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                        // Nuevo tipo de facturas movistar
                        else if ($_estado_llamadas == 20 && (strpos($line, ") Tj") > 0)) {
                                //echo " ------> " . $line . "<br>";
                                $subline = getTextoEntreParentesis($line);
                                if (strpos($subline, "Madrid, ") !== false) {
                                        $year = 2000 + substr($subline, strlen($subline) - 2);
                                        //echo "Año : " . $year . "<br>";
                                }
                                else if (strpos($subline, ": ") > 0) {
                                        //echo $subline . " 1 <br>";
                                        $pt = strpos($subline, "Tel");
                                        $pt1 = strpos($subline, "fon");
                                        if ($pt === false && $pt1 === false) {
                                                $pt = strpos($subline, "Telefonoa");
                                        }
                                        if ($pt !== false) {
                                                $pt = strpos($subline, ": ") + 2;
                                                $sl = substr($subline, $pt);
                                                if (ereg("^[0-9]+$", $sl) && strlen($sl) > 8) {
                                                        $numero_movil_llamante = $sl;
                                                        //echo "NVLL : " . $numero_movil_llamante . "<br>";
                                                }
                                        }
                                }
                                else if (strpos($subline, ": ") !== false && strlen($subline) == 11) {
                                        //echo $subline . " 2 <br>";
                                        $pt = strpos($subline, ": ") + 2;
                                        $sl = substr($subline, $pt);
                                        if (ereg("^[0-9]+$", $sl) && strlen($sl) > 8) {
                                                $numero_movil_llamante = $sl;
                                                //echo $numero_movil_llamante . "<br>";
                                        }
                                }
                                else if ((strpos($subline,"Tel") !== false) && (strpos($subline,"fon") !== false)) {
                                    while (!(($line = nextline($_buffer, $_state)) === false)) {
                                                if (strpos($line, ") Tj") > 0) {
                                                        $sl = trim(getTextoEntreParentesis($line));
                                                        $pt = strpos($subline, ": ") + 2;
                                                        if (strpos($sl, ": ") !== false)
                                                            $sl = substr($sl, $pt);
                                                        //echo $sl . "<br>";
                                                        if (ereg("^[0-9]+$", $sl) && strlen($sl) > 8) {
                                                                if (strlen($numero_movil_llamante) == 0)
                                                                    $numero_movil_llamante = $sl;
                                                                else if (strpos($numero_movil_llamante, $sl) === false)
                                                                    $numero_movil_llamante .= ", " . $sl;
                                                                //echo "<b>" . $numero_movil_llamante . "</b><br>";
                                                        }
                                                        break;
                                                }
                                        }
                                }
                                else if (ereg("^[0-9]+$", $subline) && !$oldMovistar) {
                                        $numero_llamadas = count($coste);
                                        $telefono_llamado[$numero_llamadas] = $subline;
                                        $_estado_llamadas = 100;
                                        //echo "*****> " . $line . "<br>";
                                }
                                else if (strpos($subline,"emoci") !== false) {
                                        $_estado_llamadas = 110;
                                        $numero_llamadas = count($coste);
                                        $telefono_llamado[$numero_llamadas] = $subline;
                                        $tipo_llamada[$numero_llamadas] = 18;
                                        //echo $line . "<br>";
                                }				
                                else if ($subline == "P.Basico TV") {
                                        $_estado_llamadas = 140;
                                        $numero_llamadas = count($coste);
                                        $telefono_llamado[$numero_llamadas] = $subline;
                                        $tipo_llamada[$numero_llamadas] = 18;
                                        //echo $line . "<br>";
                                }				
                        }
                        // Nuevo tipo de facturas movistar (se ley? el tel?fono llamado, espero tipo o acceso)
                        else if ($_estado_llamadas == 100 && (strpos($line, ") Tj") > 0)) {
                                $numero_llamadas = count($coste);
                                $subline = getTextoEntreParentesis($line);
                                if ($subline == "Fv" || $subline == "N" || $subline == "Dv" || 
                                    $subline == "VT" || $subline == "Mb" || $subline == "Mo" || 
                                    $subline == "R" || $subline == "O" || $subline == "ML" || 
                                    $subline == "M5" || $subline == "E" || $subline == "MG" ||
                                    $subline == "MC" || $subline == "NV" || $subline == "Pf" ||
                                    $subline == "AG" || $subline == "WG") {
                                        $tipoMS = $subline;
                                        $_estado_llamadas = 101;
                                }
                                else if ($subline == "MMS") {
                                        //echo "GPRS itinerancia!<br>";
                                        $_estado_llamadas = 120;
                                }
                                else if (strlen($telefono_llamado[$numero_llamadas]) > 9) {
                                     if ($subline == "FI" || $subline == "NI" || $subline == "Tj") {
                                        $tipoMS = $subline;
                                        //echo "Internacional modulos ahorro: " . $destinoMS . "<br>";
                                        $_estado_llamadas = 134;
                                     }
                                     else {
                                        $destinoMS = $subline;
                                        //echo "Destino internacional : " . $destinoMS . "<br>";
                                        $_estado_llamadas = 130;
                                     }
                                }
                                else 
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? el tel?fono llamado y tipo, espero destino)
                        else if ($_estado_llamadas == 101 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $destinoMS = $subline;
                                $_estado_llamadas = 102;
                        }
                        // Nuevo tipo de facturas movistar (se ley? telefono llamado, tipo y destino, espero dia-mes)
                        else if ($_estado_llamadas == 102 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $diaMS = "";
                                $mesMS = "";
                                if (isDiaMovistar($subline, $diaMS, $mesMS)) {
                                        //echo $diaMS . " del " . $mesMS . "<br>";
                                        $_estado_llamadas = 103;
                                }
                                // Llamada en itinerancia (vuelvo a eaperar el dia-mes ya que esto es el destino
                                else if ($tipoMS == "O")
                                        $_estado_llamadas == 102;
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? telefono llamado, tipo, destino y dia-mes, espero hora)
                        else if ($_estado_llamadas == 103 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $horaMS = "";
                                if (isHoraMovistar($subline, $horaMS)) {
                                        //echo $horaMS . "<br>";
                                        $numero_llamadas = count($coste);
                                        $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " " . $horaMS);
                                        $_estado_llamadas = 104;
                                }
                                // Mensaje en itinerancia
                                else if ($tipoMS == "O") {
                                        $c = str_replace(",", ".", $subline);
                                        if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                                //echo "coste : " . $c . "<br>";
                                                $numero_llamadas = count($coste);
                                                $ndate = date("Y-m-d H:i:s");
                                                $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " 00:00:00");
                                                $tipo_llamada[$numero_llamadas] = 18;
                                                $duracion[$numero_llamadas] = 1;
                                                $coste[$numero_llamadas] = $c;
                                        }
                                        $_estado_llamadas = 20;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? telefono llamado, tipo, destino, dia-mes y hora, espero duraci?n, coste o volumen)
                        else if ($_estado_llamadas == 104 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                // Va a ser un MMS
                                if (strpos($subline, ",") !== false && strpos($subline, ",") == (strlen($subline) - 3)) {
                                        $numero_llamadas = count($coste);
                                        $duracion[$numero_llamadas] = $c;
                                        $_estado_llamadas = 105;
                                }
                                // Va a ser un mensaje
                                else if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                        //echo "coste : " . $c . "<br>";
                                        $numero_llamadas = count($coste);
                                        if ($tipoMS == "Mb")
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        else if (($tipoMS == "Mo" || $tipoMS == "M5" || $tipoMS == "Fv" || $tipoMS == "MG"  || $tipoMS == "MC" || $tipoMS == "NV" || $tipoMS == "AG" || $tipoMS == "WG") && ($destinoMS == "MoviStar" || $destinoMS == "movistar"))
                                                $tipo_llamada[$numero_llamadas] = 5;
                                        else if (($tipoMS == "Mo" || $tipoMS == "MG") && $destinoMS == "Vodafone")
                                                $tipo_llamada[$numero_llamadas] = 6;
                                        else if (($tipoMS == "Mo" || $tipoMS == "MG") && $destinoMS == "Orange")
                                                $tipo_llamada[$numero_llamadas] = 7;
                                        else
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        $coste[$numero_llamadas] = $c;
                                        $duracion[$numero_llamadas] = 1;
                                        //echo "Mensaje = " . $telefono_llamado[$numero_llamadas] . " -> " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                        $_estado_llamadas = 20;
                                }
                                // Va a ser una llamada o videollamada
                                else {
                                        $numero_llamadas = count($coste);
                                        $duracion[$numero_llamadas] = obtenerDuracionMovistar($subline);
                                        if ($duracion[$numero_llamadas] == 0)
                                                $_estado_llamadas = 20;
                                        else
                                                $_estado_llamadas = 106;
                                        //echo "Llamada o videollamada = " . $telefono_llamado[$numero_llamadas] . " -> " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                }
                        }
                        // Nuevo tipo de facturas movistar (se ley? telefono llamado, tipo, destino, dia-mes, hora y volumen, espero coste del MMS)
                        else if ($_estado_llamadas == 105 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                if (strpos($subline,"Kb.") === false) {
                                        $c = str_replace(",", ".", $subline);
                                        if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                                //echo "coste : " . $c . "<br>";
                                                $numero_llamadas = count($coste);
                                                if ($destinoMS == "MoviStar" || $destinoMS == "movistar")
                                                        $tipo_llamada[$numero_llamadas] = 18;//8;
                                                else if ($destinoMS == "Vodafone")
                                                        $tipo_llamada[$numero_llamadas] = 18;//9;
                                                else if ($destinoMS == "Orange")
                                                        $tipo_llamada[$numero_llamadas] = 18;//10;
                                                else
                                                        $tipo_llamada[$numero_llamadas] = 18;
                                                $coste[$numero_llamadas] = $c;
                                                //echo "MMS = " . $telefono_llamado[$numero_llamadas] . " -> " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                        }
                                        $_estado_llamadas = 20;
                                }
                        }
                        // Nuevo tipo de facturas movistar (se ley? telefono llamado, tipo, destino, dia-mes, hora y duraci?n, espero coste de la llamada o videollamada)
                        else if ($_estado_llamadas == 106 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                        //echo "coste : " . $c . "<br>";
                                        $numero_llamadas = count($coste);
                                        if (($tipoMS == "N" || $tipoMS == "Dv" || $tipoMS == "ML" || $tipoMS == "M5" || $tipoMS == "MG" || $tipoMS == "MC" || $tipoMS == "NV" || $tipoMS == "AG" || $tipoMS == "WG") && ($destinoMS == "MoviStar" || $destinoMS == "movistar")) {
                                                $tipo_llamada[$numero_llamadas] = 3;
                                                $bloqueMS = 10;
                                        }
                                        else if (($tipoMS == "N" || $tipoMS == "Dv" || $tipoMS == "MG") && $destinoMS == "Vodafone") {
                                                $tipo_llamada[$numero_llamadas] = 2;
                                                $bloqueMS = 10;
                                        }
                                        else if (($tipoMS == "N" || $tipoMS == "Dv" || $tipoMS == "MG") && $destinoMS == "Orange") {
                                                $tipo_llamada[$numero_llamadas] = 4;
                                                $bloqueMS = 10;
                                        }
                                        else if (($tipoMS == "N" || $tipoMS == "Dv" || $tipoMS == "MG") && $destinoMS == "Yoigo") {
                                                $tipo_llamada[$numero_llamadas] = 18;
                                                $bloqueMS = 10;
                                        }
                                        else if (($tipoMS == "N" || $tipoMS == "Dv") && strpos($destinoMS, "902") !== false) {
                                                $tipo_llamada[$numero_llamadas] = 18;
                                                $bloqueMS = 10;
                                        }
                                        else if (($tipoMS == "N" || $tipoMS == "Dv") && strpos($destinoMS, "901") !== false) {
                                                $tipo_llamada[$numero_llamadas] = 18;
                                                $bloqueMS = 10;
                                        }
                                        else if (($tipoMS == "N" || $tipoMS == "Dv") && strpos($destinoMS, "900") !== false) {
                                                $tipo_llamada[$numero_llamadas] = 18;
                                                $bloqueMS = 10;
                                        }
                                        else if ($tipoMS == "N" || $tipoMS == "Pf") {
                                                $tipo_llamada[$numero_llamadas] = 1;
                                                $bloqueMS = 10;
                                        }
                                        else if ($tipoMS == "M5") {
                                                $tipo_llamada[$numero_llamadas] = 1;
                                                $bloqueMS = 10;
                                        }
                                        else if ($tipoMS == "VT" && ($destinoMS == "MoviStar" || $destinoMS == "movistar")) {
                                                $tipo_llamada[$numero_llamadas] = 18;//15;
                                                $bloqueMS = 20;
                                        }
                                        else if ($tipoMS == "VT" && $destinoMS == "Vodafone") {
                                                $tipo_llamada[$numero_llamadas] = 18;//16;
                                                $bloqueMS = 20;
                                        }
                                        else if ($tipoMS == "VT" && $destinoMS == "Orange") {
                                                $tipo_llamada[$numero_llamadas] = 18;//17;
                                                $bloqueMS = 20;
                                        }
                                        else if ($tipoMS == "Fv") {
                                                // Duda! No sabemos si es vidollamada o llamada! Hacer m?s fino el cambio de bloque!
                                                if ($bloqueMS == 0 || $bloqueMS == 10) {
                                                        $tipo_llamada[$numero_llamadas] = 3;
                                                        $bloqueMS = 10;
                                                }
                                                else if ($bloqueMS == 20) {
                                                        $tipo_llamada[$numero_llamadas] = 18;//15
                                                        $bloqueMS = 10;
                                                }
                                                else {
                                                        $tipo_llamada[$numero_llamadas] = 18;
                                                }
                                        }
                                        // Recibida en itinerancia
                                        else if ($tipoMS == "R")
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        // Realizada en itinerancia
                                        else if ($tipoMS == "O")
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        else
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        $coste[$numero_llamadas] = $c;
                                        //echo "Llamada o Videollamada = " . $telefono_llamado[$numero_llamadas] . " -> " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                }
                                $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? emoci?n, espero dia-mes)
                        else if ($_estado_llamadas == 110 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $diaMS = "";
                                $mesMS = "";
                                if (isDiaMovistar($subline, $diaMS, $mesMS)) {
                                        //echo $diaMS . " del " . $mesMS . "<br>";
                                        $_estado_llamadas = 111;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? emoci?n y dia-mes, espero hora)
                        else if ($_estado_llamadas == 111 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $horaMS = "";
                                if (isHoraMovistar($subline, $horaMS)) {
                                        //echo $horaMS . "<br>";
                                        $numero_llamadas = count($coste);
                                        $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " " . $horaMS);
                                        $_estado_llamadas = 112;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? emoci?n, dia-mes y hora, espero sesiones -duracion-)
                        else if ($_estado_llamadas == 112 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $s = str_replace(",", ".", $subline);
                                if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $s)) {
                                        //echo "duracion : " . $s . "<br>";
                                        $numero_llamadas = count($coste);
                                        $duracion[$numero_llamadas] = $s;
                                        $_estado_llamadas = 113;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? emoci?n, dia-mes y hora, sesions -duracion y espero coste)
                        else if ($_estado_llamadas == 113 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                        //echo "coste : " . $c . "<br>";
                                        $numero_llamadas = count($coste);
                                        $coste[$numero_llamadas] = $c;
                                        //echo "Emoci?n = " . $telefono_llamado[$numero_llamadas] . " -> " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                }
                                $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar GPRS (se ley? el tel?fono llamado y acceso, espero tipo)
                        else if ($_estado_llamadas == 120 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                if ($subline == "D") {
                                        $tipoMS = $subline;
                                        $_estado_llamadas = 121;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar GPRS (se ley? el tel?fono llamado y acceso, espero pa?s)
                        else if ($_estado_llamadas == 121 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                //echo "Pais : " . $subline . "<br>";
                                $_estado_llamadas = 122;
                        }
                        // Nuevo tipo de facturas movistar GPRS (se ley? el tel?fono llamado, acceso y pa?s, espero dia-mes)
                        else if ($_estado_llamadas == 122 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $diaMS = "";
                                $mesMS = "";
                                if (isDiaMovistar($subline, $diaMS, $mesMS)) {
                                        //echo $diaMS . " del " . $mesMS . "<br>";
                                        $_estado_llamadas = 123;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar GPRS (se ley? el tel?fono llamado, acceso, pa?s y dia-mes, espero hora)
                        else if ($_estado_llamadas == 123 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $horaMS = "";
                                if (isHoraMovistar($subline, $horaMS)) {
                                        //echo $horaMS . "<br>";
                                        $numero_llamadas = count($coste);
                                        $ndate = date("Y-m-d H:i:s");
                                        $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " " . $horaMS);
                                        $_estado_llamadas = 124;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar GPRS (se ley? el tel?fono llamado, acceso, pa?s, dia-mes y hora, espero volumen)
                        else if ($_estado_llamadas == 124 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                if (strpos($subline, ",") !== false && strpos($subline, ",") == (strlen($subline) - 3)) {
                                        $numero_llamadas = count($coste);
                                        $duracion[$numero_llamadas] = $c;
                                        //echo $c . "<br>";
                                        $_estado_llamadas = 125;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar GPRS (se ley? el tel?fono llamado, acceso, pa?s, dia-mes, hora y volumen, espero el texto Kb)
                        else if ($_estado_llamadas == 125 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                //echo $subline . "<br>";
                                if (strpos($subline,"Kb.") !== false) {
                                        $c = str_replace(",", ".", $subline);
                                        $_estado_llamadas = 126;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar GPRS itinerancia (se ley? el tel?fono llamado, acceso, pa?s, dia-mes, hora, volumen y texto Kb. espero coste)
                        else if ($_estado_llamadas == 126 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                        //echo "coste : " . $c . "<br>";
                                        $numero_llamadas = count($coste);
                                        if ($tipoMS == "D")
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        else
                                                $tipo_llamada[$numero_llamadas] = 18;
                                        $coste[$numero_llamadas] = $c;
                                        //echo "MMS = " . $telefono_llamado[$numero_llamadas] . " -> " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                }
                                $_estado_llamadas = 20;
                        }			
                        // Nuevo tipo de facturas movistar internacional (se ley? telefono llamado, destino, espero dia-mes)
                        else if ($_estado_llamadas == 130 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $diaMS = "";
                                $mesMS = "";
                                if (isDiaMovistar($subline, $diaMS, $mesMS)) {
                                        //echo "Internacional : " . $diaMS . " del " . $mesMS . "<br>";
                                        $_estado_llamadas = 131;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar internacional (se ley? telefono llamado, destino y dia-mes, espero hora)
                        else if ($_estado_llamadas == 131 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $horaMS = "";
                                if (isHoraMovistar($subline, $horaMS)) {
                                        //echo "Internacional : " . $horaMS . "<br>";
                                        $numero_llamadas = count($coste);
                                        $ndate = date("Y-m-d H:i:s");
                                        $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " " . $horaMS);
                                        $_estado_llamadas = 132;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar internacional (se ley? telefono llamado, tipo, destino, dia-mes y hora, espero duraci?n)
                        else if ($_estado_llamadas == 132 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $numero_llamadas = count($coste);
                                $duracion[$numero_llamadas] = obtenerDuracionMovistar($subline);
                                //echo "internacional duracion : " . $duracion[$numero_llamadas] . "<br>";
                                if ($duracion[$numero_llamadas] == 0)
                                        $_estado_llamadas = 20;
                                else
                                        $_estado_llamadas = 133;
                        }
                        // Nuevo tipo de facturas movistar (se ley? telefono llamado, tipo, destino, dia-mes, hora y duraci?n, espero coste de la llamada)
                        else if ($_estado_llamadas == 133 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                        //echo "internacional coste : " . $c . "<br>";
                                        $numero_llamadas = count($coste);
                                        $tipo_llamada[$numero_llamadas] = 18;
                                        $bloqueMS = 40;
                                        $coste[$numero_llamadas] = $c;
                                        //echo "Llamada o Videollamada = " . $telefono_llamado[$numero_llamadas] . " -> " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                }
                                $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar internacional con modulos (se ley? telefono llamado, tipo, espero destino)
                        else if ($_estado_llamadas == 134 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $destinoMS = $subline;
                                $_estado_llamadas = 135;
                        }
                        // Nuevo tipo de facturas movistar internacional con modulos (se ley? telefono llamado, tipo, destino, espero dia-mes)
                        else if ($_estado_llamadas == 135 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $diaMS = "";
                                $mesMS = "";
                                if (isDiaMovistar($subline, $diaMS, $mesMS)) {
                                        //echo "Internacional : " . $diaMS . " del " . $mesMS . "<br>";
                                        $_estado_llamadas = 136;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar internacional por modulos (se ley? telefono llamado, destino y dia-mes, espero hora)
                        else if ($_estado_llamadas == 136 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $horaMS = "";
                                if (isHoraMovistar($subline, $horaMS)) {
                                        //echo "Internacional : " . $horaMS . "<br>";
                                        $numero_llamadas = count($coste);
                                        $ndate = date("Y-m-d H:i:s");
                                        $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " " . $horaMS);
                                        $_estado_llamadas = 137;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar internacional por modulos (se ley? telefono llamado, destino y dia-mes, hora espero tipo franja)
                        else if ($_estado_llamadas == 137 && (strpos($line, ") Tj") > 0)) {
                             //Cuidado que ppodría ser un mensaje internacional si llega un numero real (coste)
                            $subline = getTextoEntreParentesis($line);                             
                            $c = str_replace(",", ".", $subline);
                            if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                // Era un mensaje internacional con tarifa Juntos
                                $numero_llamadas = count($coste);
                                $duracion[$numero_llamadas] = 1;
                                $coste[$numero_llamadas] = $c;
                                $tipo_llamada[$numero_llamadas] = 18;
                                $_estado_llamadas = 20;
                            }
                            else
                                $_estado_llamadas = 138;
                         }
                        // Nuevo tipo de facturas movistar internacional por modulos (se ley? telefono llamado, tipo, destino, dia-mes y hora, espero duraci?n)
                        else if ($_estado_llamadas == 138 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $numero_llamadas = count($coste);
                                $duracion[$numero_llamadas] = obtenerDuracionMovistar($subline);
                                //echo "internacional duracion : " . $duracion[$numero_llamadas] . "<br>";
                                if ($duracion[$numero_llamadas] == 0)
                                        $_estado_llamadas = 20;
                                else
                                        $_estado_llamadas = 133;
                        }
                        // Nuevo tipo de facturas movistar (se ley? P.Basico TV, espero tipo)
                        else if ($_estado_llamadas == 140 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                if ($subline == "Sb") {
                                        $_estado_llamadas = 141;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? P.Basico TV y tipo, espero dia-mes)
                        else if ($_estado_llamadas == 141 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $diaMS = "";
                                $mesMS = "";
                                if (isDiaMovistar($subline, $diaMS, $mesMS)) {
                                        $_estado_llamadas = 142;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? P.Basico TV, tipo y dia-mes, espero hora)
                        else if ($_estado_llamadas == 142 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $horaMS = "";
                                if (isHoraMovistar($subline, $horaMS)) {
                                        //echo $horaMS . "<br>";
                                        $numero_llamadas = count($coste);
                                        $fecha_hora[$numero_llamadas] = date($year . "-" . $mesMS . "-" . $diaMS . " " . $horaMS);
                                        $_estado_llamadas = 143;
                                }
                                else
                                        $_estado_llamadas = 20;
                        }
                        // Nuevo tipo de facturas movistar (se ley? P.Basico TV, tipo , dia-mes y hora, espero coste)
                        else if ($_estado_llamadas == 143 && (strpos($line, ") Tj") > 0)) {
                                $subline = getTextoEntreParentesis($line);
                                $c = str_replace(",", ".", $subline);
                                if (ereg("^[+-]?[0-9]*\.?[0-9]+$", $c)) {
                                        //echo "coste : " . $c . "<br>";
                                        $numero_llamadas = count($coste);
                                        $duracion[$numero_llamadas] = 1;
                                        $coste[$numero_llamadas] = $c;
                                        //echo "Emoci?n = " . $telefono_llamado[$numero_llamadas] . " -> " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
                                }
                                $_estado_llamadas = 20;
                        }
                }
                // Buscamos informaci?n para Orange
                else if ($operador == 2) {
                        //echo $line . "<br />";
                        if ($_estado_llamadas == 70 && !(strpos($line, "per?odo facturado:") === false)) {
                                $periodo = substr($line, strpos($line, ";") + 1, strlen($line) - strpos($line, ";"));
                                //echo "<b>Periodo = " . $periodo . "</b><br />";
                        }
                        else if ($_estado_llamadas == 70 && !(strpos($line, "odo facturado:") === false)) {
                                $periodo = substr($line, strpos($line, ";") + 1, strlen($line) - strpos($line, ";"));
                                //echo "<b>Periodo = " . $periodo . "</b><br />";
                        }
                        else if ($_estado_llamadas == 70 && !(strpos($line, "titular:") === false)) {
                                $titular = substr($line, strpos($line, ";") + 1, strlen($line) - strpos($line, ";"));
                                //echo "<b>Titula = " . $titular . "</b><br />";
                        }
                        else if ($_estado_llamadas == 70 && !(strpos($line, "Total a pagar") === false)) {
                                $costetxt = substr($line, strpos($line, ";") + 1, strlen($line) - strpos($line, ";"));
                                $coste_total = str_replace(",", ".", $costetxt);
                                //echo "<b>Coste total = " . $coste_total . "</b><br />";
                        }
                        else if ($_estado_llamadas == 70 && !(strpos($line, "total a pagar") === false)) {
                                $costetxt = substr($line, strpos($line, ";") + 1, strlen($line) - strpos($line, ";"));
                                $coste_total = str_replace(",", ".", $costetxt);
                                //echo "<b>Coste total = " . $coste_total . "</b><br />";
                        }
                        else if ($_estado_llamadas == 70 && !(strpos($line, "n?mero de tel?fono;tarifa;") === false))
                                $_estado_llamadas = 71;
                        else if ($_estado_llamadas == 70 && !(strpos($line, "fono;tarifa;") === false))
                                $_estado_llamadas = 71;
                        else if ($_estado_llamadas == 71) {
                                if (strpos($line, ";") > 0) {
                                        $numero_movil_llamante = substr($line, 0, strpos($line, ";"));
                                        if (ereg("^[0-9]+$", $numero_movil_llamante)) {
                                                $_estado_llamadas = 72;
                                                //echo "<b>Movil = " . $numero_movil_llamante . "</b><br />";
                                        }
                                }
                        }
                        else if ($_estado_llamadas == 72 && ereg("^[0-9]+$", substr($line, 0, strpos($line, ";")))) {
                                $numero_movil_llamante = $numero_movil_llamante . ", " . substr($line, 0, strpos($line, ";"));
                                //echo "<b>Movil = " . $numero_movil_llamante . "</b><br />";
                        }
                        else if ($_estado_llamadas == 72 && !(strpos($line, "N?mero de Telef?no;Fecha;") === false))
                                $_estado_llamadas = 73;
                        else if ($_estado_llamadas == 72 && !(strpos($line, "no;Fecha;") === false))
                                $_estado_llamadas = 73;
                        else if ($_estado_llamadas == 73) {
                                $_estado_llamadas = obtenerDatosLlamadaAmena($line, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);
                                if ($_estado_llamadas == -1) {
                                        $numero_movil_llamante = "";
                                        return;
                                }
                        }
                }
            }
            //if ($coste_total == 0) {
                    // Para evitar cálculos chungos sumamos lo realmente encontrado en las llamadas y no el coste
                    $ncoste_total = 0;
                    $total = count($coste);
                    for ($i = 0; $i < $total; $i++) {
                            $ncoste_total += $coste[$i];
                    }
                    $ncoste_total *= 1.16;
                    if ($coste_total == 0 || $coste_total < $ncoste_total) {
                        $coste_total = $ncoste_total;
                    }
            //}
            // Cambiar los años 2000
            changeYears($fecha_hora, $year);
            if ($periodo == "") {
                    $total = count($fecha_hora);
                    if ($total > 0) {	
                            $desde = $fecha_hora[0];
                            $hasta = $fecha_hora[0];
                            for ($i = 0; $i < $total; $i++) {
                                    if (strtotime($desde) > strtotime($fecha_hora[$i]))
                                            $desde = $fecha_hora[$i];
                                    if (strtotime($hasta) < strtotime($fecha_hora[$i]))
                                            $hasta = $fecha_hora[$i];
                            }
                            $periodo = "desde " . date("d/m/Y",strtotime($desde)) . " hasta " . date("d/m/Y",strtotime($hasta));
                    }
            }
        }
    }        
}

function procesarFactura($content, $idMiembro, $edad_titular, $idParentesco, $descripcion, &$idFactura) {
	// Buscamos en el PDF
	// Cuidado con los acentos
	$periodo = "";
	$coste_total = 0;
	$operador = 0;
	$numero_movil_llamante = "";
	$titular = "";
	$fecha_hora = array();
	$telefono_llamado = array();
	$tipo_llamada = array();
	$duracion = array();
	$coste = array();
	analizarFactura($content, $operador, $titular, $numero_movil_llamante, $coste_total, $periodo, $fecha_hora, $telefono_llamado, $tipo_llamada, $duracion, $coste);

/*
	$pdf = new pdf_search($content);
	echo "1.-<br>";
	$pdf->analyze();
	echo "2.-<br>";
	$periodo = $pdf->getPeriodoFacturacion();
	echo "3.-<br>";
	$coste_factura = $pdf->getCosteTotal();
	echo "4.-<br>";
	$numero_movil_llamante = $pdf->getNumeroMovilLlamante();
	echo "5.-<br>";
	$idOperador = $pdf->getIdOperador();
	echo "6.-<br>";
	$titular = $pdf->getTitular();
	echo "7.-<br>";

	return $numero_movil_llamante;
*/	
	
/*	
	echo "Numero movil llamante : " . $numero_movil_llamante . "<br>";
	echo "Periodo : " . $periodo . "<br>";
	echo "Coste total : " . $coste_total . "<br>";
	$nllamadas = count($coste);
	for ($i = 0; $i < $nllamadas; $i++) {
		echo "<b>Llamada " . ($i + 1) . " : " . $telefono_llamado[$i] . " -> " . $fecha_hora[$i] . " (" . $tipo_llamada[$i] .", " . $duracion[$i] . ") = " . $coste[$i] . "</b><br>";
	}
	return "!Error: Solo para debuggar";
*/        

	if (strlen($numero_movil_llamante) == 0 || count($telefono_llamado) == 0 || count($coste) == 0)
		return "!Error: No se pudo leer la factura correctamente.";

	if (count($telefono_llamado) > 1000) {
		echo "<br><div align=\"center\"><h3><b>La factura que nos has enviado tiene " . count($telefono_llamado) . " llamadas!</b></h3><br><h4><b>El sistema no puede generar un informe de tantas llamadas en tiempo real.</b></h4><br>Si aún así deseas obtener el informe ponte en contacto con nosotros en:<br><a href=\"mailto:" . correo() . "\" target=\"_blank\">" . correo() . "</a><br>e intentaremos generarlo y enviártelo a la dirección que nos indiques.</div>";
		exit();
	}
	if (obtenerNumeroFacturas($idMiembro, $numero_movil_llamante) >= 4) {
		echo "<br><div align=\"center\"><h4><b>Ya has enviado el número máximo de facturas para el teléfono " . $numero_movil_llamante . "!</b></h4><br><h5><b>Si deseas enviar otra factura para dicho teléfono, elimina alguna desde tu zona de usuario.</b></h5></div>";
		exit();
	}

	$estadoF = estadoFactura($periodo, $coste_total, $numero_movil_llamante);
	if ($estadoF == 1) {
		$sql = "DELETE FROM facturas WHERE periodo = '$periodo' AND coste = '$coste_total' AND numero_movil_llamante = '$numero_movil_llamante'";
		$result = mysql_query($sql);
		if ($result == 0) {
			return "!Error: No se pudo borrar la factura del usuario provisional " . $idMiembro . " correctamente.";
			exit();			
		}
	}
	else if ($estadoF == 2) {
		echo "Ya existía la factura. Puedes consultar los resultados en tu zona de usuario o enviar otra diferente.";
		exit();
	}
	$sql = "INSERT INTO facturas (idMiembro, periodo, descripcion, coste, numero_movil_llamante, idOperador, titular, edad_titular, idParentesco) VALUES ('$idMiembro', '$periodo', '$descripcion', '$coste_total', '$numero_movil_llamante', '$operador', '$titular', '$edad_titular', '$idParentesco')";
	$result = mysql_query($sql);
	if ($result == 0) {
		$error = "!Error " . mysql_errno() . ": " . mysql_error();
		return $error;
	}
	$sql = "SELECT id FROM facturas WHERE idMiembro = '$idMiembro' AND periodo = '$periodo' AND numero_movil_llamante = '$numero_movil_llamante' AND coste = '$coste_total'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$idFactura = $row_array[0];
//	$duracion = substr($_POST["Duracion"], 0, 2) * 60 + substr($_POST["Duracion"], 3, 2);
/*	for ($i = 0; $i < $pdf->getNumeroLlamadas(); $i++) {
		$telefono_llamado = $pdf->getTelefonoLlamado($i);
		$idTipoLlamada = obtenerTipoLlamada($pdf->getTipoDestino($i), $pdf->getTelefonoLlamado($i), $pdf->getIdOperador());
		actualizarMovilesDudosos($idTipoLlamada, $pdf->getIdOperador(), $idMiembro, $pdf->getTelefonoLlamado($i), $numero_movil_llamante);
		$idTipoLlamada = ($idTipoLlamada > 1000 ? $idTipoLlamada - 1000 : $idTipoLlamada);
		$idTipoDia = obtenerTipoDia($pdf->getFechaHora($i));
		$inicio_llamada = $pdf->getFechaHora($i);
		$duracion = $pdf->getDuracion($i);
		$coste_llamada = $pdf->getCoste($i);
		$sql = "INSERT INTO llamadas (idFactura, numero_telefono_llamado, idTipoLlamada, idTipoDia, inicio_llamada, duracion, coste) VALUES ('$idFactura', '$telefono_llamado', '$idTipoLlamada', '$idTipoDia', '$inicio_llamada', '$duracion', '$coste_llamada')";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
	}*/
	for ($i = 0; $i < count($coste); $i++) {
		$telefono = $telefono_llamado[$i];
		actualizarMovilesDudosos($tipo_llamada[$i], $operador, $idMiembro, $telefono_llamado[$i], $numero_movil_llamante);
		$idTipoLlamada = ($tipo_llamada[$i] > 1000 ? $tipo_llamada[$i] - 1000 : $tipo_llamada[$i]);
		$idTipoDia = obtenerTipoDia($fecha_hora[$i]);
		$inicio_llamada = $fecha_hora[$i];
		$duracion_segundos = $duracion[$i];
		$coste_llamada = $coste[$i];
//		echo $inicio_llamada . " -> " . $telefono . " - " . $idTipoLlamada . " - " . $duracion_segundos . " - " . $coste_llamada . "<br>";
		$sql = "INSERT INTO llamadas (idFactura, numero_telefono_llamado, idTipoLlamada, idTipoDia, inicio_llamada, duracion, coste) VALUES ('$idFactura', '$telefono', '$idTipoLlamada', '$idTipoDia', '$inicio_llamada', '$duracion_segundos', '$coste_llamada')";
		$result = mysql_query($sql);
		if ($result == 0) {
			$error = "!Error " . mysql_errno() . ": " . mysql_error();
			return $error;
		}
		// Para revisar nosotros los tipos que falten
		if ($tipo_llamada[$i] == 1018) {
			$sql = "INSERT INTO llamadas_a_revisar (idFactura, numero_telefono_llamado, idTipoDia, inicio_llamada, duracion, coste) VALUES ('$idFactura', '$telefono', '$idTipoDia', '$inicio_llamada', '$duracion_segundos', '$coste_llamada')";
			$result = mysql_query($sql);
		}
	}
	return $numero_movil_llamante;
}

?>
