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
<table border="1">
	<?php
		$sql = "SELECT id, nombre, nombre_oficial FROM operadores ORDER BY id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		echo "<td width=50 align=center><strong>ID</strong></td>";
		echo "<td width=200 align=center><strong>NOMBRE</strong></td>";
		echo "<td width=200 align=center><strong>NOMBRE OFICIAL</strong></td>";
		echo "<td width=100 align=center><strong>LOGO</strong></td>";
		echo "<td width=420 align=center><strong>CABECERA</strong></td>";
		echo "<td width=100></td>";

		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<tr height=\"100\">";
			echo "<td width=50 align=center>".$row_array[0]."</td>";
			echo "<td width=200 align=center>".$row_array[1]."</td>";
			echo "<td width=200 align=center>".$row_array[2]."</td>";
			echo "<td width=100 align=center><img src=\"cargarImagenDB.php?type=LOGO&idOperador=".$row_array[0]."\"/></td>";
			echo "<td width=420 align=center><img src=\"cargarImagenDB.php?type=CABECERA&idOperador=".$row_array[0]."\"/></td>";
			echo "<td width=100 align=center><a href=\"OperadoresGestion.php?id=".$row_array[0]."\"/>Cambiar</a></td>";
//					for ($i = 0; $i < mysql_num_rows($result); $i++) {
	//		$row_array = mysql_fetch_row($result);
		//	echo "<tr height=\"20\"><td width=\"418\" align=\"center\">".$row_array[0]." (".$row_array[1].")";
		//	if ($row_array[3]!=NULL){
		//		echo "</td><tr height=\"50\">";
		//		echo "<td width=\"418\" align=\"center\"><img src=\"logoOperadora.php?id=".$row_array[1]."\" />imagen";
		//	}
		//	echo "</td></tr>";
			
			
			
			
			
			
			echo "</tr>";
/*		
			echo "<tr height=\"20\"><td width=\"418\" align=\"center\">".$row_array[0]." (".$row_array[1].")";
			if ($row_array[3]!=NULL){
				echo "</td><tr height=\"50\">";
				echo "<td width=\"418\" align=\"center\"><img src=\"logoOperadora.php?id=".$row_array[1]."\" />imagen";
			}
			echo "</td></tr>";
			*/
		}
	?>
</table>
</body>
</html>
