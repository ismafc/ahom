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
	$id = isset ($_GET["id"]) ? $_GET["id"] : exit();

	if (isset ($_POST['enviar'])){
		$sql = "DELETE FROM servicios_ahorro WHERE id=$id";
		$result = mysql_query($sql);
		if ($result==0)
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
		else
			echo "<br>El servicio de ahorro se ha eliminado correctamente<br>";
			
		echo "<br /><br /><a href=\"./GestionServiciosDeAhorro.php\">Atrás...</a>";	
	}else{
		$sql = "SELECT servicios_ahorro.id, servicios_ahorro.nombre, operadores.nombre, servicios_ahorro.urlTarifa ".
				"FROM servicios_ahorro LEFT JOIN operadores ON servicios_ahorro.idOperador = operadores.id ".
				"WHERE servicios_ahorro.id=$id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		echo "ELIMINAR SERVICIO DE AHORRO <br />";
		$row_array = mysql_fetch_row($result);
		echo "Id: ".$row_array[0]."<br />";
		echo "Nombre: ".$row_array[1]."<br />";
		echo "Operador: ".$row_array[2]."<br />";
		echo "URL Tarifa: ".$row_array[3]."<br /><br />";
		echo "¿ESTAS SEGURO QUE QUIERES ELIMINAR EL SERVICIO DE AHORRO?<br /><br />"
?>
	<table border = 0>
   		<tr height = "50">
        	<td width = "100" valign = "middle">
            	<form action="GestionServiciosDeAhorroEliminar.php?id=<?php echo $id;?>" method="post">
				   <input size="100"  name="enviar" type="submit" value="Aceptar" />
			    </form>
            </td>
            <td width = "50"></td>
            <td width = "100" valign = "middle">
            	<form action="GestionServiciosDeAhorro.php" method="post">
                	<input size="100" name="cancelar" type="submit" value="Cancelar"/>
                </form>
            </td>
        </tr>
   </table>
<?php 
	} //end if 
?> 

</body>
</html>
