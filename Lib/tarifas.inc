<?php
//
// Crea la tabla de servicios de ahorro compatibles con el contrato
//
function crearTablaServiciosAhorroEnContrato ($idContrato) 
{
	$sql = "SELECT DISTINCT servicios_ahorro.id, servicios_ahorro.nombre, servicios_ahorro.urlTarifa FROM servicios_ahorro INNER JOIN compatibilidades ON servicios_ahorro.id = compatibilidades.idServicioAhorro WHERE compatibilidades.idContrato=$idContrato";
	$result = mysql_query($sql);
	
	if ($result == 0) 
		return false;
		
	if (mysql_num_rows($result) <= 0)
		return false;

	echo "<tr>";
	echo "<td colspan=3 height=6></td>";
    echo "</tr>";
  	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tablaServiciosAhorroCompatibles.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<td width=9>";
	echo "<td width=400 style=\"background-color:#D7E9F5\">";
	echo "<table width=400 border=0 cellpadding=0 cellspacing=0>";
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		echo "<tr height=20>";
		echo "<td width=400 align=center>";
		if ($row_array[2])
			echo "<a href=\"".$row_array[2]."?idServicioAhorro=".$row_array[0]."\">".$row_array[1]."</a>";
		else
			echo $row_array[1];
		echo "<td>";
		echo "</tr>";
 	}
	echo "</table>";
	echo "</td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tabla2b.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	
	return true;
}

//
// Crea al enlace a la tarifa del contrato en la web del operador
//
function crearEnlaceTarifaContratoOperador ($idContrato)
{
	$sql = "SELECT urlTarifaOperador FROM contratos WHERE id=$idContrato";
	$result = mysql_query($sql);
	
	if ($result != 0){
		if (mysql_num_rows($result) > 0){
			$row_array = mysql_fetch_row ($result);
			if ($row_array[0]){
				echo "<a href=\"".$row_array[0]."\" target=\"mas_informacion\">Más información</a>";
				return true;
			}
		}
	}
	
//	echo "<a href=\"http://www.google.es/\" target=\"ventana_google\">Google</a>";
//	echo "&nbsp;";
	return false;
}

//
// Crea la tabla de servicios de ahorro compatibles con la tarjeta
//
function crearTablaServiciosAhorroEnTarjeta ($idTarjeta) 
{
	$sql = "SELECT DISTINCT servicios_ahorro.id, servicios_ahorro.nombre, servicios_ahorro.urlTarifa FROM servicios_ahorro INNER JOIN compatibilidades_tarjeta ON servicios_ahorro.id = compatibilidades_tarjeta.idServicioAhorro WHERE compatibilidades_tarjeta.idTarjeta=$idTarjeta";
	$result = mysql_query($sql);
	
	if ($result == 0) 
		return false;
		
	if (mysql_num_rows($result) <= 0)
		return false;

	echo "<tr>";
	echo "<td colspan=3 height=6></td>";
    echo "</tr>";
  	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tablaServiciosAhorroCompatibles.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<td width=9>";
	echo "<td width=400 style=\"background-color:#D7E9F5\">";
	echo "<table width=400 border=0 cellpadding=0 cellspacing=0>";
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		echo "<tr height=20>";
		echo "<td width=400 align=center>";
		if ($row_array[2])
			echo "<a href=\"".$row_array[2]."?idServicioAhorro=".$row_array[0]."\">".$row_array[1]."</a>";
		else
			echo $row_array[1];
		echo "<td>";
		echo "</tr>";
 	}
	echo "</table>";
	echo "</td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tabla2b.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	
	return true;
}

//
// Crea el enlace a la tarifa de la tarjeta en la web del operador
//
function crearEnlaceTarifaTarjetaOperador ($idTarjeta)
{
	$sql = "SELECT urlTarifaOperador FROM tarjetas WHERE id=$idTarjeta";
	$result = mysql_query($sql);
	
	if ($result != 0){
		if (mysql_num_rows($result) > 0){
			$row_array = mysql_fetch_row ($result);
			if ($row_array[0]){
				echo "<a href=\"".$row_array[0]."\" target=\"mas_informacion\">Más información</a>";
				return true;
			}
		}
	}
	return false;
}

//
// Crea la tabla de contratos compatibles con el servicio de ahorro
//
function crearTablaContratosEnServicioAhorro ($idServicioAhorro)
{
 	$sql = "SELECT DISTINCT contratos.id, contratos.nombre, contratos.urlTarifa FROM contratos INNER JOIN compatibilidades ON contratos.id = compatibilidades.idContrato WHERE compatibilidades.idServicioAhorro=$idServicioAhorro";
	$result = mysql_query($sql);
	
	if ($result == 0) 
		return false;
		
	if (mysql_num_rows($result) <= 0)
		return false;

	echo "<tr>";
	echo "<td colspan=3 height=6></td>";
    echo "</tr>";
  	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tablaContratosCompatibles.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<td width=9>";
	echo "<td width=400 style=\"background-color:#D7E9F5\">";
	echo "<table width=400 border=0 cellpadding=0 cellspacing=0>";
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		echo "<tr height=20>";
		echo "<td width=400 align=center>";
		if ($row_array[2])
			echo "<a href=\"".$row_array[2]."?idContrato=".$row_array[0]."\">".$row_array[1]."</a>";
		else
			echo $row_array[1];
		echo "<td>";
		echo "</tr>";
 	}
	echo "</table>";
	echo "</td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tabla2b.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	
	return true;
}

//
// Crea la tabla de tarjetas compatibles con el servicio de ahorro
//
function crearTablaTarjetasEnServicioAhorro ($idServicioAhorro)
{
   	$sql = "SELECT DISTINCT tarjetas.id, tarjetas.nombre, tarjetas.urlTarifa FROM tarjetas INNER JOIN compatibilidades_tarjeta ON tarjetas.id = compatibilidades_tarjeta.idTarjeta WHERE compatibilidades_tarjeta.idServicioAhorro=$idServicioAhorro";
	$result = mysql_query($sql);
	
	if ($result == 0) 
		return false;
		
	if (mysql_num_rows($result) <= 0)
		return false;

	echo "<tr>";
	echo "<td colspan=3 height=6></td>";
    echo "</tr>";
  	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tablaTarjetasCompatibles.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<td width=9>";
	echo "<td width=400 style=\"background-color:#D7E9F5\">";
	echo "<table width=400 border=0 cellpadding=0 cellspacing=0>";
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		echo "<tr height=20>";
		echo "<td width=400 align=center>";
		if ($row_array[2])
			echo "<a href=\"".$row_array[2]."?idTarjeta=".$row_array[0]."\">".$row_array[1]."</a>";
		else
			echo $row_array[1];
		echo "<td>";
		echo "</tr>";
 	}
	echo "</table>";
	echo "</td>";
	echo "<td width=9></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width=9></td>";
	echo "<td width=400><img src=\"./imagenes/tabla2b.gif\" alt=\"\" /></td>";
	echo "<td width=9></td>";
	echo "</tr>";
	
	return true;
}

//
// Crea el enlace a la tarifa del servicio de ahorro en la web del operador
//
function crearEnlaceTarifaServicioAhorroOperador ($idServicioAhorro)
{
	$sql = "SELECT urlTarifaOperador FROM servicios_ahorro WHERE id=$idServicioAhorro";
	$result = mysql_query($sql);
	
	if ($result != 0){
		if (mysql_num_rows($result) > 0){
			$row_array = mysql_fetch_row ($result);
			if ($row_array[0]){
				echo "<a href=\"".$row_array[0]."\" target=\"mas_informacion\">Más información</a>";
				return true;
			}
		}
	}
	return false;
}

?>