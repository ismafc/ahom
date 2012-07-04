<?php session_start(); 
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	include("../Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$type = (isset($_GET["type"])) ? $_GET["type"] : exit();
	$idOperador = (isset ($_GET["idOperador"])) ? $_GET["idOperador"] : "";
	$idNoticia = (isset ($_GET["idNoticia"])) ? $_GET["idNoticia"] : "";
	
	if ($type == "LOGO")
		$sql = "SELECT logoMime, logo FROM operadores WHERE id='$idOperador'";
	else if ($type == "CABECERA")
		$sql = "SELECT cabeceraMime, cabecera FROM operadores WHERE id='$idOperador'";
	else if ($type == "NOTICIA")
		$sql = "SELECT mime, imagen FROM noticias WHERE id='$idNoticia'";
	else if ($type == "NOTICIAMINIATURA")
		$sql = "SELECT mimeMiniatura, imagenMiniatura FROM noticias WHERE id='$idNoticia'";
	else
		exit();

	$result = mysql_query($sql);
	if ($result == 0) 
		exit();

	$row_array = mysql_fetch_row($result);
	header ("Content-Type: $row_array[0]");
	echo $row_array[1];
?>
