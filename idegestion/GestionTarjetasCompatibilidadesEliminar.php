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
		$sql = "DELETE FROM compatibilidades_tarjeta WHERE idCompatibilidad=$id";
		$result = mysql_query($sql);
		if ($result==0)
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
		else
			echo "<br>La Compatibilidad se ha eliminado correctamente<br>";
			
		echo "<br /><br /><a href=\"./GestionTarjetasCompatibilidad.php\">Atrás...</a>";	
	}else{
		echo "¿ESTAS SEGURO QUE QUIERES ELIMINAR LA COMPATIBILIDAD?<br /><br />"
?>
	<table border = 0>
   		<tr height = "50">
        	<td width = "100" valign = "middle">
            	<form action="GestionTarjetasCompatibilidadesEliminar.php?id=<?php echo $id;?>" method="post">
				   <input size="100"  name="enviar" type="submit" value="Aceptar" />
			    </form>
            </td>
            <td width = "50"></td>
            <td width = "100" valign = "middle">
            	<form action="GestionTarjetasCompatibilidad.php" method="post">
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
