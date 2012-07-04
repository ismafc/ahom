<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

include("./Lib/main.inc");
include("./Lib/base.inc");
if (openDatabase() == false)
	exit();
$idMiembro = $_GET["idMiembro"];
$nFacturas = $_GET["nFacturas"];
if (obtenerNumeroDeFacturasMiembro($idMiembro) > $nFacturas) {
	$idFactura = obtenerUltimaFactura($idMiembro);
	$pasos = (float)obtenerNumeroDeCalculos();
	$sql = "SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "0";
	}
	else
	{
		echo (int)((100.0 * mysql_num_rows($result)) / $pasos);
//		$row_array = mysql_fetch_row($result);
//		echo $row_array[0];
//		echo (int)((100.0 * $row_array[0]) / 135.0);
	}
}
else {
	echo "0";
}
?>
