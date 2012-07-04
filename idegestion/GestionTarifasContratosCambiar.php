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
	if (isset($_POST['enviar'])) {
		$mostrarFormulario = 0;
		$url = $_POST['url'];
		$urlOperador = $_POST['urlOperador'];
		$tipo = $_POST['tipo'];
			
		$sql ="UPDATE contratos ".
				"SET tipo='$tipo', urlTarifa='$url', urlTarifaOperador='$urlOperador' ".
				"WHERE id='$id'";
		$result = mysql_query($sql);
		if ($result==0)
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
		else
			echo "<br>Modificación realizada correctamente<br>";
	
	}else{
		$mostrarFormulario = 1;
	}
	
	$sql = "SELECT contratos.id, contratos.tipo, contratos.nombre, operadores.nombre, contratos.urlTarifa, contratos.urlTarifaOperador ".
			"FROM contratos INNER JOIN operadores ON contratos.idOperador = operadores.id WHERE contratos.id=$id";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$tipoActual = $row_array[1];
	$urlActual = $row_array[4];
	$urlOperadorActual = $row_array[5];
	echo "<table border=1>";
	echo "<tr height=20>";
	echo "<td width=100 align=left><strong>Id</strong></td>";
	echo "<td width=420 align=left>".$row_array[0]."</td>";
	echo "</tr>";
	
	echo "<tr height=20>";	
	echo "<td width=100 align=left><strong>Tipo</strong></td>";
	echo "<td width=420 align=left>".$row_array[1]."</td>";
	echo "</tr>";
		
	echo "<tr height=20>";	
	echo "<td width=100 align=left><strong>Nombre</strong></td>";
	echo "<td width=420 align=left>".$row_array[2]."</td>";
	echo "</tr>";
		
	echo "<tr height=20>";
	echo "<td width=100 align=left><strong>Operador</strong></td>";
	echo "<td width=420 align=left>".$row_array[3]."</td>";
	echo "</tr>";	
		
	echo "<tr height=20>";	
	echo "<td width=100 align=left><strong>URL Tarifa</strong></td>";
	echo "<td width=420 align=left>".$row_array[4]."</td>";
	echo "</tr>";

	echo "<tr height=20>";	
	echo "<td width=100 align=left><strong>URL Tarifa Operador</strong></td>";
	echo "<td width=420 align=left>".$row_array[5]."</td>";
	echo "</tr>";
	echo "</table>";
	
	if ($mostrarFormulario == 1){
?>
		<br />
		<br />
            <form action="GestionTarifasContratosCambiar.php?id=<?php echo $id?>" method="post">
    		<table border="0" cellpadding="0" cellspacing="0">
			    <tr height="50">
				    <td width="100" valign="middle"><strong>Tipo</strong></td>
				    <td width="400" align="left" valign="middle"><span>
					    <select size="1" id="tipo" name="tipo"> 
                        	<option value="NINGUNO" <?php if ($tipoActual=="NINGUNO") echo "selected=\"selected\""?>>Ninguno</option>
                            <option value="CONTRATO" <?php if ($tipoActual=="CONTRATO") echo "selected=\"selected\""?>>Contrato</option>
                            <option value="TARJETA" <?php if ($tipoActual=="TARJETA") echo "selected=\"selected\""?>>Tarjeta</option>
                        </select></span>
                    </td>
			    </tr>
			    <tr height="50">
				    <td width="100" valign="middle"><strong>Url</strong></td>
				    <td width="400" align="center" valign="middle">
					    <input size="100" type="text" id="url" name="url" value="<?php echo $urlActual;?>"/> 
				    </td>
			    </tr>
			    <tr height="50">
				    <td width="100" valign="middle"><strong>Url Operador</strong></td>
				    <td width="400" align="center" valign="middle">
					    <input size="100" type="text" id="urlOperador" name="urlOperador" value="<?php echo $urlOperadorActual;?>"/> 
				    </td>
			    </tr>
			    <tr height="50">
				    <td colspan="2" width="500">
					    <input size="100"  name="enviar" type="submit" value="Cambiar" />
				    </td>
			    </tr>
    
		    </table>
	    </form>
<?php
	}else{
?>
	<br />
	<br />
    <a href="./GestionTarifasContratos.php">Atrás...</a>
<?php 
	} //end if 
?> 

</body>
</html>
