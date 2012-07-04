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
<script type="text/JavaScript">
function ValidateLoginForm() {
	if (document.LoginForm.idTarjeta.value == "Ninguna"){
		alert ("Tarjeta no seleccionada");
		document.LoginForm.idTarjeta.focus();
		return false;
	}
	
	c = 0;
	
	if (document.LoginForm.idServicioAhorro0.value != "Ninguno")
		c++;
	if (document.LoginForm.idServicioAhorro1.value != "Ninguno")
		c++;
	if (document.LoginForm.idServicioAhorro2.value != "Ninguno")
		c++;
	if (document.LoginForm.idServicioAhorro3.value != "Ninguno")
		c++;
		
	if (c == 0){
		alert ("No se ha seleccionada ningún servicio de ahorro");
		document.LoginForm.idServicioAhorro0.focus();
		return false;
	}
	
	
	return true;
}
</script>

</head>

<?php
	$id = "";
	$modificar = 0;
	$idTarjeta = "";
	$mostrarFormulario = 1;
	$idServicioAhorro[4];
	$idServicioAhorro[0] = "";
	$idServicioAhorro[1] = "";
	$idServicioAhorro[2] = "";
	$idServicioAhorro[3] = "";
	
	if (isset ($_GET["id"])){
		// modificar;
		$id = $_GET["id"];
		$modificar = 1;
		echo "<br /><strong>MODIFICAR COMPATIBILIDAD</strong><br /><br />";
	}else{
		// añadir;
		echo "<br /><strong>NUEVA COMPATIBILIDAD</strong><br /><br />";
	}
	
	if (isset ($_POST['enviar'])){
		$idServicioAhorro[0] = $_POST['idServicioAhorro0'];
		$idServicioAhorro[1] = $_POST['idServicioAhorro1'];
		$idServicioAhorro[2] = $_POST['idServicioAhorro2'];
		$idServicioAhorro[3] = $_POST['idServicioAhorro3'];
		$idTarjeta = $_POST['idTarjeta'];
	
		// Comprobamos si el operador de la tarjeta es el mismo que el de los servicios de ahorro
		
		$sql = "SELECT idOperador FROM tarjetas WHERE id=$idTarjeta";
		$result = mysql_query ($sql);				
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
			
		if (mysql_num_rows($result) == 0){
			echo "<br><br><b>ERROR : No se ha encontrado el identificador del operador de la tarjeta</b><br><br>";
		}else{
			$row_array = mysql_fetch_row($result);
			$idOperador = $row_array[0];
			$ok = 1;
			for ($i = 0; $i < 4; $i++){
				if ($idServicioAhorro[$i] == "Ninguno")
					continue;
					
				for ($j = $i + 1; $j < 4; $j++){
					if ($idServicioAhorro[$i] == $idServicioAhorro[$j]){
						echo "<br><br><b>ERROR: El de servicio de ahorro ".($j+1)." es igual al servicio de ahorro".($i+1)."</b><br><br>";
						$ok = 0;
					}
				}
				if ($ok == 0)
					break;
						
				$sql = "SELECT idOperador FROM servicios_ahorro WHERE id=$idServicioAhorro[$i]";
				$result = mysql_query ($sql);
				if ($result == 0){
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
				}
				if (mysql_num_rows($result) == 0)
					continue;
				$row_array = mysql_fetch_row($result);
				if ($idOperador != $row_array[0]){
					echo "<br><br><b>ERROR: El operador del servicio de ahorro ".($i+1)." es diferente al operador de la tarjeta</b><br><br>";
					$ok = 0;
					break;
				}
			}
			
			if ($ok){
				if ($modificar == 1){
					$sql = "DELETE FROM compatibilidades_tarjeta WHERE idCompatibilidad=$id";
					$result = mysql_query($sql);
				}else{
					// Buscamos el identificador 
					$sql = "SELECT MAX(idCompatibilidad) FROM compatibilidades_tarjeta";
					$result = mysql_query($sql);
					if ($result == 0) {
						echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
						exit();
					}
					if (mysql_num_rows($result) != 0) {
						$row_array = mysql_fetch_row($result);
						$id = $row_array[0] + 1;
					}else{
						echo "<b> ERROR !! </b>";
						exit ();
					}
				}
				$ok = 1;
				for ($i = 0; $i < 4; $i++){
					if ($idServicioAhorro[$i] == "Ninguno")
						continue;
					$sql = "INSERT INTO compatibilidades_tarjeta (idCompatibilidad, idTarjeta, idServicioAhorro) ".
							"VALUES ('$id', '$idTarjeta', '$idServicioAhorro[$i]')";
					$result = mysql_query($sql);
					if ($result==0){
						$ok = 0;
						echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";							
					}
				}
				
				if ($ok == 1){
					if ($modificar == 1)
						echo "<br>Modificación realizada correctamente<br>";
					else
						echo "<br>Compatibilidad añadida correctamente<br>";
			
					echo "<br /><br /><a href=\"./GestionTarjetasCompatibilidad.php\">Atrás...</a>";	
					$mostrarFormulario = 0;
				}
			}
		}			
	}
		
	if ($mostrarFormulario == 1){
		if ($modificar == 1){
			$sql = "SELECT compatibilidades_tarjeta.idCompatibilidad, compatibilidades_tarjeta.idTarjeta, compatibilidades_tarjeta.idServicioAhorro ".
					"FROM compatibilidades_tarjeta WHERE compatibilidades_tarjeta.idCompatibilidad=$id";
				
			$result = mysql_query ($sql);				
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			
			if (mysql_num_rows($result) > 4){
				echo "<b>Error : La compatibilidad tiene más de 4 servicios de ahorro configurados</b>";
				exit();
			}
			for ($i = 0; $i < mysql_num_rows($result); $i++) {
				$row_array = mysql_fetch_row($result);
				$idTarjeta = $row_array[1];
				$idServicioAhorro[$i] = $row_array[2];
			}
		}
?>
    <form action="GestionTarjetasCompatibilidadesProcesar.php<?php if ($modificar == 1) echo "?id=".$id;?>" method="post" target="_self" name="LoginForm" id="LoginForm" onsubmit="return ValidateLoginForm();">
    <table border="0" cellpadding="0" cellspacing="0">
	    <tr height="50">
            <td width="250" valign="middle"><strong>Tarjeta</strong></td>
            <td width="250">
            	<select size="1" id="idTarjeta" name="idTarjeta">
                	<option value="Ninguna" <?php if ($idTarjeta == "") echo "selected=\"selected\""?>>-- Ninguna --</option>
                    <?php		
						$sql = "SELECT tarjetas.id, tarjetas.nombre, operadores.nombre ".
								"FROM tarjetas INNER JOIN operadores ON tarjetas.idOperador = operadores.id ".
								"ORDER BY operadores.nombre, tarjetas.nombre";

						$result = mysql_query($sql);
						if ($result == 0)
							echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
						else
						{
							for ($i = 0; $i < mysql_num_rows($result); $i++) {
								$row_array = mysql_fetch_row($result);
								echo "<option value=\"" . $row_array[0] . "\"";
								if ($idTarjeta == $row_array[0])
									echo "selected=\"selected\"";
								echo ">" . $row_array[2]." - ".$row_array[1] . "</option>";
							}
						}
					?>
               </select>
            </td>
        </tr>
        <?php
			$sql = "SELECT servicios_ahorro.id, servicios_ahorro.nombre, operadores.nombre ".
					"FROM servicios_ahorro INNER JOIN operadores ON servicios_ahorro.idOperador = operadores.id ".
					"ORDER BY operadores.nombre, servicios_ahorro.nombre";
			$result = mysql_query($sql);
			if ($result == 0)
				echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
			else
			{
				for ($i = 0; $i < 4; $i++){
					echo "<tr height=50>";
					echo "<td width=250 valign=middle><strong>Servicio de ahorro ".($i + 1)."</strong></td>";
		            echo "<td width=250>";
					echo "<select size=1 id=\"idServicioAhorro".$i."\" name=\"idServicioAhorro".$i."\">";
					echo "<option value=\"Ninguno\" "; 
					if ($idServicioAhorro[$i] == "") 
						echo "selected=\"selected\"";
					echo ">-- Ninguno --</option>";

					mysql_data_seek ($result, 0);
					for ($j = 0; $j < mysql_num_rows($result); $j++){
						$row_array = mysql_fetch_row($result);
						echo "<option value=\"" . $row_array[0] . "\"";
						if ($idServicioAhorro[$i] == $row_array[0])
							echo "selected=\"selected\"";
						echo ">" . $row_array[2]." - ".$row_array[1] . "</option>";
					}				
					echo "</select>";
					echo "</td>";
					echo "</tr>";
				}
			}	
	   ?>
	</table>
    <br />
    <input size="100"  name="enviar" type="submit" value="Aceptar" />
    </form>
	<br />
    <br />
        
    <form action="GestionTarjetasCompatibilidad.php" method="post">
       	<input size="100" name="cancelar" type="submit" value="Cancelar"/>
    </form>
<?php 
	} //end if 
?> 

</body>
</html>
