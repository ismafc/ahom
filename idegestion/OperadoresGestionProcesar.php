<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	include("../Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>
<script type="text/JavaScript">
</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
</head>
<?php
	$id = (isset ($_GET["id"])) ? $_GET["id"] : exit();
	$mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	// Variables de la foto
	$nameLogo = $_FILES["LogoOperadora"]["name"];
	$typeLogo = $_FILES["LogoOperadora"]["type"];
	$tmp_nameLogo = $_FILES["LogoOperadora"]["tmp_name"];
	$sizeLogo = $_FILES["LogoOperadora"]["size"];
		
	$nameCabecera = $_FILES["CabeceraOperadora"]["name"];
	$typeCabecera = $_FILES["CabeceraOperadora"]["type"];
	$tmp_nameCabecera = $_FILES["CabeceraOperadora"]["tmp_name"];
	$sizeCabecera = $_FILES["CabeceraOperadora"]["size"];		
		
	// Verificamos si el archivo es una imagen válida
	if(!in_array($typeLogo, $mimetypes))
		die("El archivo de logo no es una imagen válida");

	if(!in_array($typeCabecera, $mimetypes))
		die("El archivo de cabecera no es una imagen válida");
	
	$datos = getimagesize($tmp_nameLogo);
	if ($datos[1] != 90 || $datos[0] != 90)
		die ("Las dimensiones del archivos de logo han de ser de 90x90");
		
	$datos = getimagesize($tmp_nameCabecera);
	if ($datos[1] != 40 || $datos[0] != 414)
		die ("Las dimensiones del archivos de cabecera han de ser de 414x40");

	$fpLogo = fopen($tmp_nameLogo, "rb");
	$tfotoLogo = fread($fpLogo, filesize($tmp_nameLogo));
	$tfotoLogo = addslashes($tfotoLogo);
	fclose($fpLogo);
	@unlink($tmp_nameLogo);
 
	$fpCabecera = fopen($tmp_nameCabecera, "rb");
	$tfotoCabecera = fread($fpCabecera, filesize($tmp_nameCabecera));
	$tfotoCabecera = addslashes($tfotoCabecera);
	fclose($fpCabecera);
	@unlink($tmp_nameCabecera);
 
	$sql = "SELECT id FROM operadores WHERE id=".$id;
	echo $sql."<br>";
	$result = mysql_query($sql);
	echo $result."<br>";
	if (mysql_num_rows($result) == 0) {
		//No existe
		echo "No se ha encontrado la operadora<br>";
		echo "<br><a href=\"./Operadores.php\">Atrás...</a>";
	}else{
		echo "type resultado -- ".get_resource_type($result) . "<br>";
		$row_array = mysql_fetch_row($result);
		echo "resultado -- ".$row_array[0]." -- ".$row_array[1]."<br>";

		$sql ="UPDATE operadores ".
			"SET logo='$tfotoLogo', logoMime='$typeLogo', cabecera='$tfotoCabecera', cabeceraMime='$typeCabecera' ".
			"WHERE id=$id";
		echo "modificar<br>";
 
		$result = mysql_query($sql);
		echo $result."<br>";
		if ($result==0)
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
		else{
			echo "Insertada Correctamente<br>";		
			echo "<a href=\"./Operadores.php\">Atrás...</a>";
		}
	}
?>
</body>
</html>






