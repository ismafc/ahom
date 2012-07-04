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
<br />
<strong> GESTION TARJETAS PREPAGO </strong>
<br />
<br />
<table border="1">
	<?php
		$sql = "SELECT tarjetas.id, tarjetas.nombre, operadores.nombre, tarjetas.urlTarifa, tarjetas.urlTarifaOperador ".
				"FROM tarjetas LEFT JOIN operadores ON tarjetas.idOperador = operadores.id ".
				"ORDER BY operadores.nombre, tarjetas.nombre";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		echo "<tr>";
		echo "<td width=50 align=center><strong>ID</strong></td>";
		echo "<td width=100 align=center><strong>NOMBRE</strong></td>";
		echo "<td width=150 align=center><strong>OPERADOR</strong></td>";
		echo "<td width=420 align=center><strong>URLTARIFA</strong></td>";
		echo "<td width=420 align=center><strong>URLTARIFAOPERADOR</strong></td>";
		echo "<td width=100></td>";
		echo "<td width=100></td>";
		echo "</tr>";	
		
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<tr>";
			echo "<td width=50 align=center>".$row_array[0]."</td>";
			echo "<td width=400 align=center>".$row_array[1]."</td>";
			echo "<td width=150 align=center>".$row_array[2]."</td>";
			echo "<td width=420 align=center>".$row_array[3]."</td>";
			echo "<td width=420 align=center>".$row_array[4]."</td>";
			echo "<td width=100 align=center><a href=\"GestionTarjetasProcesar.php?id=".$row_array[0]."\"/>Cambiar</a></td>";
			echo "<td width=100 align=center><a href=\"GestionTarjetasEliminar.php?id=".$row_array[0]."\"/>Eliminar</a></td>";
			echo "</tr>";
		}
	?>
</table>
<br />
<br />
<a href="GestionTarjetasProcesar.php"><strong>Nueva tarjeta</strong></a>
</body>
</html>
