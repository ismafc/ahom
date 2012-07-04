<?php
if (!isset($mainFolder))
	$mainFolder = "./";
include_once($mainFolder . "Lib/facturasMovistarBase.inc");

function obtenerPrimerValor($line) {
	$pos = strpos($line, " ");
	$valor = substr($line, 0, $pos);
	return $valor;
}

function obtenerTipoBloqueMovistar(&$_buffer, &$_state, &$_posiciones_columnas) {
	$line = nextline($_buffer, $_state);
	$line = nextline($_buffer, $_state);
	$columnas = 0;
	$_posiciones_columnas[$columnas] = obtenerPrimerValor($line);
	//echo "-> Primer valor " . $line . " = " . $_posiciones_columnas[$columnas] . "<br>";
	$columnas++;
	$salir = false;
	while ($salir == false) {
		if ($line == "0.8500 w") {
			$line = nextline($_buffer, $_state);
			$line = nextline($_buffer, $_state);
			$_posiciones_columnas[$columnas] = obtenerPrimerValor($line);
			//echo "Valor " . $line . " = " . $_posiciones_columnas[$columnas] . "<br>";
			if ($_posiciones_columnas[$columnas] >= 557.0 && $_posiciones_columnas[$columnas] <= 559.0) {
				$salir = true;
			}
			else if ($_posiciones_columnas[$columnas] >= 561.0 && $_posiciones_columnas[$columnas] <= 562.0) {
				if ($columnas == 11) {
					return 26;		// Internacionales
				}
				else if ($columnas == 5) {
					return 30;		// Mensajes multimedia
				}
				else if ($columnas == 7) {
					$anin = $_posiciones_columnas[$columnas] - $_posiciones_columnas[$columnas - 1];
					if ($anin < 70.0)
						return 22;		// e-mocion o datos GPRS
					else
						return 31;		// GPRS en itinerancia
				}
				else {
					//echo "50-1<br>";
					return 50;
				}
			}
			else if ($_posiciones_columnas[$columnas] >= 555.0 && $_posiciones_columnas[$columnas] <= 556.0) {
				if ($columnas == 6) {
					//echo "27!!!!<br>";
					return 27;
				}
				else if ($columnas == 7) {
					$anin = $_posiciones_columnas[1] - $_posiciones_columnas[0];
					//echo "29 o 32!!!! " . $anin . "<br>";
					if ($anin < 50.0)
						return 29;  // Llamadas en itinerancia
					else
						return 32;  // Servicios de tarificaci?n adicional
				}
				else {
					//echo "50-2!!!<br>";
					return 50;
				}
			}
			$columnas++;
		}
		if (($line = nextline($_buffer, $_state)) === false) {
			//echo "50-3<br>";
			return 50;
		}
	}
	if ($columnas == 8) {
		$anin = $_posiciones_columnas[$columnas - 1] - $_posiciones_columnas[$columnas - 2];
		if ($anin < 70.0)
			return 22;		// e-mocion o datos GPRS
		else
			return 31;		// GPRS en itinerancia
	}
	else if ($columnas == 14) {
		return 23;
	}
	else if ($columnas == 12) {
		$ancho1 = $_posiciones_columnas[2] - $_posiciones_columnas[1];
		if ($ancho1 >= 59.54 && $ancho1 <= 59.56) {
			return 24;
		}
		else if ($ancho1 >= 48.1 && $ancho1 <= 48.3) {
			return 28;
		}
		else {
			//echo "Eooo 1<br>";
			return -1;
		}
	}
	else if ($columnas == 10) {
		// Premium o ermoci?n
		return 25;
	}
	else {
		//echo "Eooo 2<br>";
		return -1;
	}
}

function obtenerPosicionX($line) {
	$pos = strpos($line, " ");
	$line = substr($line, $pos + 1);
	$pos = strpos($line, " ");
	$line = substr($line, $pos + 1);
	$pos = strpos($line, " ");
	$line = substr($line, $pos + 1);
	$pos = strpos($line, " ");
	$line = substr($line, $pos + 1);
	$pos = strpos($line, " ");
	return substr($line, 0, $pos);
}

function obtenerFechaHoraMovistar($year, $f, $h) {
	//echo $year . "; " . $f . "; " . $h . "<br>";
	$i = 0;
	$dia = "";
	while ($f[$i] >= '0' && $f[$i] <= '9') {
		$dia = $dia . $f[$i];
		$i++;
	}
	while ($f[$i] == ' ')
		$i++;
	$mes = obtenerMesMovistarPDF(substr($f, $i, 3));
	$hora = "";
	if (strlen($h) == 5)
		$hora = $h . ":00";
	else
		$hora = $h;
	//echo $dia . "/" . $mes . "/" . $year . " " . $hora . "<br>";
	return date($year . "-" . $mes . "-" . $dia . " " . $hora);	
}

function obtenerLlamadaMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 6) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[6])
				$base = 7;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	if ($textos_concatenados[1] == "VT")
		$tipo_llamada[$numero_llamadas] = 18;
	else if ($textos_concatenados[2] == "MoviStar")
		$tipo_llamada[$numero_llamadas] = 3;
	else if ($textos_concatenados[2] == "Vodafone")
		$tipo_llamada[$numero_llamadas] = 2;
	else if ($textos_concatenados[2] == "Amena" || $textos_concatenados[2] == "Orange")
		$tipo_llamada[$numero_llamadas] = 4;
	else {
		$prefijo = substr($textos_concatenados[0], 0, 2);
		if (($prefijo >= 81 && $prefijo <=88) || ($prefijo >= 91 && $prefijo <= 98))
			$tipo_llamada[$numero_llamadas] = 1;
		else		
			$tipo_llamada[$numero_llamadas] = 18;
	}
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[3], $textos_concatenados[4]);
	$duracion[$numero_llamadas] = obtenerDuracionMovistar($textos_concatenados[5]);
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[6]);
//	echo "Llamada = " . $tipo_llamada[$numero_llamadas] . " - " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 23;
}

function obtenerSMSMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 5) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[5])
				$base = 6;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	if ($textos_concatenados[2] == "MoviStar")
		$tipo_llamada[$numero_llamadas] = 5;
	else if ($textos_concatenados[2] == "Vodafone")
		$tipo_llamada[$numero_llamadas] = 6;
	else if ($textos_concatenados[2] == "Amena" || $textos_concatenados[2] == "Orange")
		$tipo_llamada[$numero_llamadas] = 7;
	else
		$tipo_llamada[$numero_llamadas] = 18;
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[3], $textos_concatenados[4]);
	$duracion[$numero_llamadas] = 0;
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[5]);
//	echo "SMS = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 24;
}

// Emoci?n o servicio internet
function obtenerEmocionMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 3) {
		if (strpos($line, "Tm") > 0) {
			//echo $line . " - <br>";
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[3])
				$base = 4;
			$line = nextline($_buffer, $_state);
			//echo $line . " -- <br>";
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w") {
			return 50;
		}
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18;
	if (ereg("^[0-9]+:[0-9]+$", $textos_concatenados[2])) {
		// Es Emoci?n
		$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[1], $textos_concatenados[2]);
		$duracion[$numero_llamadas] = 0; // REVISAR EN EL FUTURO
		$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[3]);
	}
	else {
		// Es servicio de internet! (GPRS)
		$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[1], "00:00");
		$peso = substr($textos_concatenados[2], 0, strpos($textos_concatenados[2], ","));
		$duracion[$numero_llamadas] = (int)$peso;
		$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[3]);
	}
	//echo "Emoci?n o Internet GPRS = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 22;
}

// Datos GPRS en itinerancia
function obtenerDatosGPRSItineranciaMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 7) {
		if (strpos($line, "Tm") > 0) {
			//echo $line . " - <br>";
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[7])
				$base = 8;
			$line = nextline($_buffer, $_state);
			//echo $line . " -- <br>";
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w") {
			return 50;
		}
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18;
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[4], $textos_concatenados[5]);
	$duracion[$numero_llamadas] = 0; // REVISAR EN EL FUTURO
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[7]);
	//echo "Datos GPRS en itinerancia = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 31;
}

// Premiumn... o emoci?n
function obtenerPremiumMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 4) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[4])
				$base = 5;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18;
	if (ereg("^[0-9]+:[0-9]+$", $textos_concatenados[2])) {
		// Es emoci?n
		$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[1], $textos_concatenados[2]);
	}
	else {
		// Es premium
		$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[2], $textos_concatenados[3]);
	}
	$duracion[$numero_llamadas] = 0;
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[4]);
	//echo "Llamada premium o emoci?n = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 25;
}

function obtenerLlamadasInternacionalesMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 5) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[5])
				$base = 6;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18;  // REVISAR EN UN FUTURO
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[2], $textos_concatenados[3]);
	$duracion[$numero_llamadas] = obtenerDuracionMovistar($textos_concatenados[4]);
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[5]);
	//echo "Llamada internacional = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 26;
}

function obtenerLlamadasRecibidasItineranciaMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 6) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[6])
				$base = 7;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18; // REVISAR EN UN FUTURO
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[3], $textos_concatenados[4]);
	$duracion[$numero_llamadas] = obtenerDuracionMovistar($textos_concatenados[5]);
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[6]);
	//echo "Llamada recibida itinerancia = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 27;
}

function obtenerMensajesMultimediaMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 5) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[5])
				$base = 6;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18; // REVISAR EN UN FUTURO
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[3], $textos_concatenados[4]);
	$duracion[$numero_llamadas] = 0;
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[5]);
	//echo "Mensaje multimedia = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 30;
}

function obtenerLlamadasRealizadasItineranciaMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 7) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[7])
				$base = 8;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18; // REVISAR EN UN FUTURO
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[4], $textos_concatenados[5]);
	$duracion[$numero_llamadas] = obtenerDuracionMovistar($textos_concatenados[6]);
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[7]);
	//echo "Llamada itinerancia = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 29;
}

function obtenerServicioTarificacionAdicionalMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	$maxpx = -1;
	while ($columna < 7) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000" || $px <= $maxpx)
				return 50;
			$maxpx = $px;
			if ($columna == 0 && $px > $_posiciones_columnas[7])
				$base = 8;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18; // REVISAR EN UN FUTURO
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[2], $textos_concatenados[3]);
	$duracion[$numero_llamadas] = obtenerDuracionMovistar($textos_concatenados[4]);
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[7]);
	//echo "Servicio tarificacion adicional = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 32;
}

function obtenerSMSItineranciaMovistar(&$_buffer, &$_state, &$_posiciones_columnas, $year, &$fecha_hora, &$telefono_llamado, &$tipo_llamada, &$duracion, &$coste) {
	$numero_llamadas = count($fecha_hora);
	$textos_concatenados = array();
	$texto_concatenado = "";
	$base = 0;
	$columna = 0;
	$px = 0;
	while ($columna < 5) {
		if (strpos($line, "Tm") > 0) {
			$px = obtenerPosicionX($line);
			if ($px == "51.0000")
				return 50;
			if ($columna == 0 && $px > $_posiciones_columnas[5])
				$base = 6;
			$line = nextline($_buffer, $_state);
			if ($px < $_posiciones_columnas[$columna + $base]) {
				if ($texto_concatenado == "") {
					$texto_concatenado = getTextoEntreParentesis($line);
				}
				else {
					$texto_concatenado = $texto_concatenado . " " . getTextoEntreParentesis($line);
				}
			}
			else {
				$textos_concatenados[$columna] = $texto_concatenado;
				$texto_concatenado = getTextoEntreParentesis($line);
				$columna++;
			}
		}
		else if ($line == "1.4000 w")
			return 50;
		else
			$line = nextline($_buffer, $_state);
	}
	if (strlen($texto_concatenado) == 0) { // A veces hay un texto vac?o antes del coste!!!
		$line = nextline($_buffer, $_state);
		while (!(strpos($line, "Tm") > 0)) {
			$line = nextline($_buffer, $_state);
		}
		$line = nextline($_buffer, $_state);
		$texto_concatenado = getTextoEntreParentesis($line);
	}
	$textos_concatenados[$columna] = $texto_concatenado;
	
	$telefono_llamado[$numero_llamadas] = $textos_concatenados[0];
	$tipo_llamada[$numero_llamadas] = 18;
	$fecha_hora[$numero_llamadas] = obtenerFechaHoraMovistar($year, $textos_concatenados[4], "00:00");
	$duracion[$numero_llamadas] = 0;
	$coste[$numero_llamadas] = str_replace(",", ".", $textos_concatenados[5]);
	//echo "SMS itinerancia = " . $fecha_hora[$numero_llamadas] . " - " . $duracion[$numero_llamadas] . " : " . $coste[$numero_llamadas] . "<br>";
	
	return 28;
}

function obtenerYearMovistar(&$_buffer, &$_state) {
	$year = 2000;
	$line = nextline($_buffer, $_state);
	$tjcounter = 0;
	$salir = false;
	while ($salir == false) {
		if (strpos($line, "Tj") > 0) {
			if ($tjcounter == 2) {
				$year += getTextoEntreParentesis($line);
				$salir = true;
			}
			$tjcounter++;
		}
		$line = nextline($_buffer, $_state);
	}
	//echo "Anyo = " . $year . "<br>";
	return $year;
}

?>
