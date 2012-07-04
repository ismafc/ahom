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

function ValidateLogoForm() {
	if (document.LogoForm.LogoOperadora.value == "") {
		alert("Introduce el archivo de imagen del logo de la operadora");
		document.LogoForm.LogoOperadora.focus();
		return false;	
	}

	if (document.LogoForm.CabeceraOperadora.value == "") {
		alert("Introduce el archivo de imagen del logo de la operadora");
		document.LogoForm.CabeceraOperadora.focus();
		return false;	
	}
	return true;
}

</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
</head>
<table border="1">
	<?php
		$id = (isset ($_GET["id"])) ? $_GET["id"] : exit();
		
		$sql = "SELECT id, nombre, nombre_oficial FROM operadores WHERE id=$id";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		$row_array = mysql_fetch_row($result);
		echo "<tr height=20>";
		echo "<td width=100 align=left><strong>Id</strong></td>";
		echo "<td width=420 align=left>".$row_array[0]."</td>";
		echo "</tr>";
		
		echo "<tr height=20>";	
		echo "<td width=100 align=left><strong>Nombre</strong></td>";
		echo "<td width=420 align=left>".$row_array[1]."</td>";
		echo "</tr>";
		
		echo "<tr height=20>";
		echo "<td width=100 align=left><strong>Nombre Oficial</strong></td>";
		echo "<td width=420 align=left>".$row_array[2]."</td>";
		echo "</tr>";	
		
		echo "<tr height=100>";	
		echo "<td width=100 align=left><strong>Logo</strong></td>";
		echo "<td width=420 align=left><img src=\"cargarImagenDB.php?type=LOGO&idOperador=".$row_array[0]."\"/></td>";
		echo "</tr>";
		
		echo "<tr height=100>";
		echo "<td width=100 align=left><strong>Cabecera</strong></td>";
		echo "<td width=420 align=left><img src=\"cargarImagenDB.php?type=CABECERA&idOperador=".$row_array[0]."\"/></td>";
		echo "</tr>";	
	?>
</table>
<br />
<br />
Introduce los ficheros de logo (90x90) y cabecera (414x40) del operador
	 <form action="OperadoresGestionProcesar.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data" target="_self" name="LogoForm" id="LogoForm" onsubmit="return ValidateLogoForm()">
      
        <table border="0" cellpadding="0" cellspacing="0">
          <tr height="50">
            <td width="100" valign="middle"><strong>Logo</strong></td>
            <td width="400" align="center" valign="middle">
           		<input size="100" type="file" id="LogoOperadora" name="LogoOperadora" /> 
            </td>
          </tr>
         <tr height="50">
         	<td width="100"><strong>Cabecera</strong></td>
	        <td width="400" align="center" valign="middle">
           		<input size="100" type="file" id="CabeceraOperadora" name="CabeceraOperadora" /> 
            </td>
         </tr>
         <tr height="50">
         	<td colspan="2" width="500">
            	<input size="100"  name="Submit2" id="Submit2" type="submit" value="enviar" />
            </td>
          </tr>
          
         </table>
       </form>
</body>
</html>
