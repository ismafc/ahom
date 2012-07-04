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
<strong> GESTION COMPATIBILIDADES TARJETAS PREPAGO </strong>
<br />
<br />
<table border="1">
	<?php
		$sql = "SELECT compatibilidades_tarjeta.idCompatibilidad, operadores.nombre, compatibilidades_tarjeta.idTarjeta, ".
			"tarjetas.nombre, compatibilidades_tarjeta.idServicioAhorro, servicios_ahorro.nombre ".
			"FROM (compatibilidades_tarjeta INNER JOIN (tarjetas INNER JOIN operadores ON tarjetas.idOperador = operadores.id) ".
			"ON compatibilidades_tarjeta.idTarjeta=tarjetas.id) INNER JOIN servicios_ahorro ".
			"ON compatibilidades_tarjeta.idServicioAhorro = servicios_ahorro.id ".
			"ORDER BY operadores.nombre, tarjetas.nombre, compatibilidades_tarjeta.idCompatibilidad";
			
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		echo "<tr>";
		echo "<td width=50 align=center><strong>IDCOMPATIBILIDAD</strong></td>";
		echo "<td width=100 align=center><strong>OPERADOR</strong></td>";
		echo "<td width=150 align=center><strong>TARJETA</strong></td>";
		echo "<td width=150 align=center><strong>SERVICIO AHORRO</strong></td>";
		echo "<td width=150 align=center><strong>SERVICIO AHORRO</strong></td>";
		echo "<td width=150 align=center><strong>SERVICIO AHORRO</strong></td>";
		echo "<td width=150 align=center><strong>SERVICIO AHORRO</strong></td>";
		echo "<td width=100></td>";
		echo "<td width=100></td>";
		echo "</tr>";	
		
		$idCompatibilidad = "";
		$primero = 1;
		$count = 0;
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
				
			if ($idCompatibilidad == $row_array[0]){
				$count++;
				echo "<td width=150 align=center>".$row_array[5]."</td>";
			}else{
				if ($primero == 1)
					$primero = 0;
				else{
					while ($count < 4){
						echo "<td width=150 align=center></td>";
						$count++;
					}
					echo "<td width=100 align=center><a href=\"GestionTarjetasCompatibilidadesProcesar.php?id=".$idCompatibilidad."\"/>Cambiar</a></td>";
					echo "<td width=100 align=center><a href=\"GestionTarjetasCompatibilidadesEliminar.php?id=".$idCompatibilidad."\"/>Eliminar</a></td>";
					echo "</tr>";
					$count = 0;
				}
				$idCompatibilidad = $row_array[0];
				echo "<tr>";
				echo "<td width=50 align=center>".$row_array[0]."</td>";
				echo "<td width=100 align=center>".$row_array[1]."</td>";
				echo "<td width=150 align=center>".$row_array[3]."</td>";
				echo "<td width=150 align=center>".$row_array[5]."</td>";
				$count = 1;
			}			
		}

		if ($count > 0){
			while ($count < 4){
				echo "<td width=150 align=center></td>";
				$count++;
			}
			echo "<td width=100 align=center><a href=\"GestionTarjetasCompatibilidadesProcesar.php?id=".$idCompatibilidad."\"/>Cambiar</a></td>";
			echo "<td width=100 align=center><a href=\"GestionTarjetasCompatibilidadesEliminar.php?id=".$idCompatibilidad."\"/>Eliminar</a></td>";
			echo "</tr>";
		}
	?>
</table>
<br />
<br />
<a href="GestionTarjetasCompatibilidadesProcesar.php"><strong>Nueva Compatibilidad</strong></a>
</body>
</html>
