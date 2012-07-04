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
	echo "<form name=\"form1\" method=\"post\" action=\"ProcesarCompatibilidades.php\">";
	echo "Contratos: <select name=\"Contratos\">";
	$sql = "SELECT id, nombre FROM contratos";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Servicio ahorro 1: <select name=\"ServicioAhorro1\">";
	$sql = "SELECT id, nombre FROM servicios_ahorro";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		echo "<option value=\"Ninguno\">Ninguno</option>";
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Servicio ahorro 2: <select name=\"ServicioAhorro2\">";
	$sql = "SELECT id, nombre FROM servicios_ahorro";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		echo "<option value=\"Ninguno\">Ninguno</option>";
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Servicio ahorro 3: <select name=\"ServicioAhorro3\">";
	$sql = "SELECT id, nombre FROM servicios_ahorro";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		echo "<option value=\"Ninguno\">Ninguno</option>";
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Servicio ahorro 4: <select name=\"ServicioAhorro4\">";
	$sql = "SELECT id, nombre FROM servicios_ahorro";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		echo "<option value=\"Ninguno\">Ninguno</option>";
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "Servicio ahorro 5: <select name=\"ServicioAhorro5\">";
	$sql = "SELECT id, nombre FROM servicios_ahorro";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	else
	{
		echo "<option value=\"Ninguno\">Ninguno</option>";
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
		}
	}
	echo "</select><br><br>";
	echo "<input name=\"Enviar\" type=\"submit\" value=\"Añadir compatibilidad\">";
	echo "</form>";
?>
</body>
</html>
