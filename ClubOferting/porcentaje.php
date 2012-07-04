<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
include("./../Lib/main.inc");
include("./../Lib/baseServicioClubOferting.inc");
if (openDatabase() == false) {
	echo "Error BD";
	exit();
}

$idMiembro = $_GET["idMiembro"];

$idFactura = obtenerUltimaFactura($idMiembro);

$pasos = (float)obtenerNumeroDeCalculos();

$sql = "SELECT id FROM resultados_basicos WHERE idFactura = '$idFactura'";
$result = mysql_query($sql);
if ($result == 0) {
	echo "0";
}
else
{
	$p = (int)((100.0 * mysql_num_rows($result)) / $pasos);
	echo $p;
}
?>
