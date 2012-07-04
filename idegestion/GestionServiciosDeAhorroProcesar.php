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
	$id = "";
	$modificar = 0;
	if (isset ($_GET["id"])){
		// modificar;
		$id = $_GET["id"];
		$modificar = 1;
		echo "<br /><strong>MODIFICAR SERVICIO DE AHORRO</strong><br /><br />";
	}else{
		// añadir;
		echo "<br /><strong>NUEVO SERVICIO DE AHORRO</strong><br /><br />";
	}
	
	if (isset ($_POST['enviar'])){
		$idOperador = $_POST['idOperador'];
		$nombre = $_POST['nombre'];
		$urlTarifa = $_POST['urlTarifa'];
		$urlTarifaOperador = $_POST['urlTarifaOperador'];
		
		if ($modificar == 1){	
			$sql ="UPDATE servicios_ahorro ".
					"SET nombre='$nombre', idOperador='$idOperador', urlTarifa='$urlTarifa', urlTarifaOperador='$urlTarifaOperador' ".
					"WHERE id='$id'";
		}else{
			$sql = "INSERT INTO servicios_ahorro (nombre, idOperador, cuota_alta, cuota_mensual, condicion_cuota_mensual, ".
					"cuota_vodafone, cuota_movistar, cuota_amena, cuota_fijo, urlTarifa, urlTarifaOperador) ".
				"VALUES ('$nombre', '$idOperador', 0,0,0,0,0,0,0, '$urlTarifa', '$urlTarifaOperador')";
		}
		$result = mysql_query($sql);
		if ($result==0)
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
		else if ($modificar == 1)
			echo "<br>Modificación realizada correctamente<br>";
		else
			echo "<br>Servicio de ahorro añadido correctamente<br>";
			
		echo "<br /><br /><a href=\"./GestionServiciosDeAhorro.php\">Atrás...</a>";	
	}else{
		$idOperador = "0";
		$nombre = "";
		$urlTarifa = "";
		
		if ($modificar == 1){
			$sql = "SELECT nombre, idOperador, urlTarifa, urlTarifaOperador FROM servicios_ahorro WHERE id=$id";

			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			
			$row_array = mysql_fetch_row($result);
			$nombre = $row_array[0];
			$idOperador = $row_array[1];
			$urlTarifa = $row_array[2];
			$urlTarifaOperador = $row_array[3];
		}	
?>
    <form action="GestionServiciosDeAhorroProcesar.php<?php if ($modificar == 1) echo "?id=".$id;?>" method="post">
    <table border="0" cellpadding="0" cellspacing="0">
	    <tr height="50">
    		<td width="100" valign="middle"><strong>Nombre</strong></td>
            <td width="100">
            	<input type="text" size="64" id="nombre" name="nombre" value="<?php echo $nombre;?>"/>
            </td>
        </tr>
	    <tr height="50">
            <td width="100" valign="middle"><strong>Operador</strong></td>
            <td width="100">
            	<select size="1" id="idOperador" name="idOperador">
                	<option value="0" <?php if ($idOperador == "0") echo "selected=\"selected\""?>>-- Ninguno --</option>
                    <?php		
						$sql = "SELECT id, nombre FROM operadores";
						$result = mysql_query($sql);
						if ($result == 0)
						echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
						else
						{
							for ($i = 0; $i < mysql_num_rows($result); $i++) {
								$row_array = mysql_fetch_row($result);
								echo "<option value=\"" . $row_array[0] . "\"";
								if ($idOperador == $row_array[0])
									echo "selected=\"selected\"";
								echo ">" . $row_array[1] . "</option>";
							}
						}
					?>
               </select>
            </td>
        </tr>
	    <tr height="50">
    		<td width="100" valign="middle"><strong>URL Tarifa</strong></td>
            <td width="100">
            	<input size="64" type="text" id="urlTarifa" name="urlTarifa" value="<?php echo $urlTarifa;?>"/>
            </td>
        </tr>
	    <tr height="50">
    		<td width="100" valign="middle"><strong>URL Tarifa Operador</strong></td>
            <td width="100">
            	<input size="256" type="text" id="urlTarifaOperador" name="urlTarifaOperador" value="<?php echo $urlTarifaOperador;?>"/>
            </td>
        </tr>
	</table>
    <br />
    <input size="100"  name="enviar" type="submit" value="Aceptar" />
    </form>
<?php 
	} //end if 
?> 

</body>
</html>
