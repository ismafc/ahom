<?php
//
// Funciones para analizar las facturas
//

function getTextoEntreParentesis($line) {
    //echo $line . "<br>";
    $pos = strpos($line, "(");
    $line = substr($line, $pos + 1);
    $pos = strpos($line, ")");
    return substr($line, 0, $pos);
}

function nextline(&$_buffer, &$_state) {
    $pos = strpos($_buffer, "\n");
    if ($pos === false)
            return false;
    $pos1 = strpos($_buffer, "\r");
    if (!($pos1 === false) && $pos1 < $pos)
            $pos = $pos1;
    $line = substr($_buffer, 0, $pos);
    $_buffer = substr($_buffer, $pos + 1);
    if ($line == "stream") {
        $endpos = strpos($_buffer, "endstream");
        if ($_state != 2) {
            $stream = substr($_buffer, 0, $endpos - 1);
            $stream = @gzuncompress($stream);
            if (strlen($stream) == 0) {
                $stream = substr($_buffer, 1, $endpos - 1);
                $stream = @gzuncompress($stream);
            }
        }
        $_buffer = $stream . substr($_buffer, $endpos + 10);
        $_state = 0;
    }

    else if (strpos($line, ">>stream") > 0 && strpos($line, "FlateDecode") > 0) {
        $endpos = strpos($_buffer, "endstream");
        if ($_state != 2) {
            if (strpos($line, "FlateDecode/I") > 0 || strpos($line, "FlateDecode/Name") > 0)
                $stream = "";
            else {
                $stream = substr($_buffer, 1, $endpos - 3);
                $stream = @gzuncompress($stream);
            }
        }
        $_buffer = $stream . substr($_buffer, $endpos + 10);
        $_state = 0;
    }
/*
	else if (strpos($line, ">>stream") > 0) {
		echo $line . "<br>";
		$endpos = strpos($_buffer, "endstream");
		if ($_state != 2) {
			$stream = substr($_buffer, 0, $endpos);
			echo $stream . "<br>";
			$stream = @gzuncompress($stream);
			echo $stream . "<br>";
		}
		$_buffer = $stream . substr($_buffer, $endpos + 10);
		$_state = 0;
	}
*/	
    else if ($line == "BI") {
        $endpos = strpos($_buffer, "EI");
        $_buffer = substr($_buffer, $endpos + 3);
    }
    else {
        $pos = strpos($line, "/Type /Info");
        if (!($pos === false))
            $_state = 1;
        $pos = strpos($line, "/Type /XObject");
        if (!($pos === false))
            $_state = 2;
        $pos = strpos($line, "/Type /Page");
        if (!($pos === false))
            $_state = 3;
    }
    $line = str_replace(">", "&gt", $line);
    $line = str_replace("<", "&lt", $line);
//	echo $line . "<br>";
    return $line;
}

function changeYears(&$fecha_hora, $year) {
    $m1 = date("m", strtotime($fecha_hora[0]));
    $m2 = date("m", strtotime($fecha_hora[0]));
    $yearjump = false;	
    $date_act = strtotime(date("Y-m-d H:i:s"));
    $total = count($fecha_hora);
    $year1 = date("Y", strtotime($fecha_hora[0]));
    $year2 = date("Y", strtotime($fecha_hora[0]));
    for ($i = 0; $i < $total; $i++) {
        $y = date("Y", strtotime($fecha_hora[$i]));
        if ($y == 2000)
                $fecha_hora[$i] = date($year . date("-m-d H:i:s", strtotime($fecha_hora[$i])));	

        $y = date("Y", strtotime($fecha_hora[$i]));
        if ($year2 != $y && $year1 != $y)
                $year2 = $y;

        $m = date("m", strtotime($fecha_hora[$i]));
        if ($m2 != $m && $m1 != $m)
                $m2 = $m;
    }

    if ($year1 == $year2 && (($m1 == 12 && $m2 == 1) || ($m1 == 1 && $m2 == 12)))
        $yearjump = true;
    else if ($year1 == $year2 && ($year1 > date("Y") || ($year1 == date("Y") && $m1 > date("m"))))
        $yearjump = true;

    // Cambiar el a?o si hemos pasado al siguiente (Diciembre-Enero)
    if ($yearjump == true && $total > 0) {
        $year = $year - 1;
        //echo "<br>Jump " . $year . "<br>";
        for ($i = 0; $i < $total; $i++) {
            $m1 = date("m", strtotime($fecha_hora[$i]));
            if ($m1 >= 1 && $m1 <= 6)
                $fecha_hora[$i] = date(($year + 1) . date("-m-d H:i:s", strtotime($fecha_hora[$i])));
            else
                $fecha_hora[$i] = date($year . date("-m-d H:i:s", strtotime($fecha_hora[$i])));
        }
    }
/*
    if ($total > 0) {
        $yearjump = false;
        $m1 = date("m", strtotime($fecha_hora[0]));
        if ($m1 == 1 || $m1 == 12) {
            for ($i = 1; $i < $total; $i++) {
                $m2 = date("m", strtotime($fecha_hora[$i]));
                if (($m1 == 1 && $m2 == 12) || ($m1 == 12 && $m2 == 1)) {
                    $yearjump = true;
                    break;
                }
            }
            if ($yearjump == true) {
                for ($i = 0; $i < $total; $i++) {
                    $m1 = date("m", strtotime($fecha_hora[$i]));
                    if ($m1 == 1)
                        $fecha_hora[$i] = date(($year + 1) . date("-m-d H:i:s", strtotime($fecha_hora[$i])));	
                }
            }
        }
    }
*/	
}

function obtenerOperador(&$_buffer, &$_state, &$_estado_llamadas, &$operador) {
    $line = nextline($_buffer, $_state);
    if ($line === false)
        return false;
    //echo $line . "<br>";
    if (strpos($line, "?xml version=\"1.0\" encoding=\"UTF-8\"?") !== false) {
        $operador = -1;
        $_estado_llamadas = 200;
        return true;
    }
    if (strpos($line, "?xml version=\"1.0\" encoding=\"ISO-8859-1\"?") !== false) {
        $operador = -1;
        $_estado_llamadas = 200;
        return true;
    }
    
    // Movistar Tanto antiguos como muchos nuevos
    if (strpos($line, "PDF-1.2") == 1) {
        $operador = 1;
        $_estado_llamadas = 20;
        return true;
    }
    
    // ORANGE
    if (($line == "AMENA - Retevisi?n M?vil, S.A.") || !(strpos($line, "ORANGE") === false)) {
        $operador = 2;
        $_estado_llamadas = 70;
        return true;
    }
    
    // Vodafone o Nuevo Movistar con PDF 1.3
    if (strpos($line, "PDF-1.") == 1) {
         if (strpos($line, "PDF-1.3")) {
            $line = nextline($_buffer, $_state);
            $line = nextline($_buffer, $_state);
            //echo "1.3 = " . $line . "<br>";
            if (strpos($line, "4 0 obj") !== false) {
                //Vodafone
                $operador = 3;
                $_estado_llamadas = 10;
				return true;
            }
            $line = nextline($_buffer, $_state);
            if (strpos($line, "9 0 obj") !== false) {
                //Vodafone
                $operador = 3;
                $_estado_llamadas = 10;
            }
            else {
                // Movistar nuevo
                $operador = 1;
                $_estado_llamadas = 20;
            }
            return true;
         }
         else {
            //Vodafone
            $operador = 3;
            $_estado_llamadas = 10;
            return true;
         }
    }
    return false;
}

?>
