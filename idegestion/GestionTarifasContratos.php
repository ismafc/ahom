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
<strong> GESTION URL TARIFAS PARA LOS CONTRATOS CONFIGURADOS </strong>
<br />
<br />
<table border="1">
	<?php
		$sql = "SELECT contratos.id, contratos.tipo, contratos.nombre, contratos.idOperador, contratos.urlTarifa, ".
				"contratos.urlTarifaOperador, ".
				"operadores.nombre FROM contratos INNER JOIN operadores ON contratos.idOperador = operadores.id ".
				"ORDER BY contratos.idOperador, contratos.nombre";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		echo "<tr>";
		echo "<td width=50 align=center><strong>ID</strong></td>";
		echo "<td width=100 align=center><strong>TIPO</strong></td>";
		echo "<td width=400 align=center><strong>NOMBRE</strong></td>";
		echo "<td width=150 align=center><strong>IDOPERADOR</strong></td>";
		echo "<td width=420 align=center><strong>URLTARIFA</strong></td>";
		echo "<td width=420 align=center><strong>URLTARIFAOPERADOR</strong></td>";
		echo "<td width=100></td>";
		echo "</tr>";	
		
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<tr>";
			echo "<td width=50 align=center>".$row_array[0]."</td>";
			echo "<td width=100 align=center>".$row_array[1]."</td>";
			echo "<td width=400 align=center>".$row_array[2]."</td>";
			echo "<td width=150 align=center>".$row_array[6]."</td>";
			echo "<td width=420 align=center>".$row_array[4]."</td>";
			echo "<td width=420 align=center>".$row_array[5]."</td>";
			echo "<td width=100 align=center><a href=\"GestionTarifasContratosCambiar.php?id=".$row_array[0]."\"/>Cambiar</a></td>";
			echo "</tr>";
		}
	?>
</table>
</body>
</html>
