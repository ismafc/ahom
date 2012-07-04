<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 
	include(".\\Lib\\main.inc");
	if (openDatabase() == false)
		exit();
	echo "<form name=\"form1\" method=\"post\" action=\"ProcesarContrato.php\">";
	echo "Nombre del contrato: <input name=\"NombreContrato\" type=\"text\" maxlength=\"64\"><br><br>";
	echo "Operador: <select name=\"Operador\">";
	$sql = "SELECT id, nombre FROM operadores";
	$result = mysql_query($sql);
	if ($result == 0)
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Cuota de alta (&#8364;): <input name=\"CuotaAlta\" type=\"text\" maxlength=\"15\"><br><br>";
	echo "Cuota mensual (&#8364;): <input name=\"CuotaMensual\" type=\"text\" maxlength=\"15\"><br><br>";
	echo "Fracción mínima (segundos): <input name=\"FraccionMinima\" type=\"text\" value=\"60\" maxlength=\"15\"><br><br>";
	echo "Unidad tarificación (segundos): <input name=\"UnidadTarificacion\" type=\"text\" value=\"1\" maxlength=\"15\"><br><br>";
	echo "Consumo Mínimo (&#8364;): <input name=\"ConsumoMinimo\" type=\"text\" maxlength=\"15\"><br><br>";
	echo "Base consumo gratis (&#8364;): <input name=\"BaseConsumoGratis\" type=\"text\" value=\"0\" maxlength=\"15\"><br><br>";
	echo "Consumo gratis (&#8364;): <input name=\"ConsumoGratis\" type=\"text\" value=\"0\" maxlength=\"15\"><br><br>";
	echo "<table width=\"100%\" border=\"0\">";
	echo "<tr><td height=\"2\" bgcolor=\"#000000\"></td></tr>";
	echo "</table><br>";
	echo "Tipo de día: <select name=\"TipoDia\">";
	echo "<option value=\"A\">Todos</option>";
	$sql = "SELECT id, nombre FROM tipos_dias";
	$result = mysql_query($sql);
	if ($result == 0)
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Tipo de llamada: <select name=\"TipoLlamada\">";
	echo "<option value=\"A\">Llamadas propio operador + fijos</option>";
	echo "<option value=\"B\">Llamadas resto operadores</option>";
	echo "<option value=\"C\">Llamadas a todos</option>";
	echo "<option value=\"D\">SMS a todos</option>";
	echo "<option value=\"E\">MMS a todos</option>";
	$sql = "SELECT id, nombre FROM tipos_llamadas";
	$result = mysql_query($sql);
	if ($result == 0)
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
	else
	{
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Hora franja inicio (HH:MM): <input name=\"FranjaInicio\" type=\"text\" maxlength=\"5\">";
	echo "Hora franja fin (HH:MM): <input name=\"FranjaFin\" type=\"text\" maxlength=\"5\"><br><br>";
	echo "Intervalo desde (segundos o KBytes): <input name=\"IntervaloDesde\" type=\"text\" value=\"0\" maxlength=\"10\">";
	echo "Intervalo hasta (segundos o KBytes): <input name=\"IntervaloHasta\" type=\"text\" value=\"86400\" maxlength=\"10\"><br><br>";
	echo "Establecimiento llamada (&#8364;): <input name=\"EstablecimientoLlamada\" type=\"text\" maxlength=\"15\">";
	echo "Coste (&#8364;/minuto): <input name=\"Coste\" type=\"text\" maxlength=\"15\"><br><br>";
	echo "<input name=\"Enviar\" type=\"submit\" value=\"Añadir\">";
	echo "</form>";
?>
</body>
</html>
