<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>
<style type="text/css">
<!--
.Estilo57 {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo62 {color: #FFFBF0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo64 {color: #FFFBF0}
.Estilo65 {	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>
<html>
<head>
<link type='text/xml' rel='alternate' href='/Default.vsdisco'/>

	<title>PHP & MySQL Test</title>
	<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	font-style: italic;
}
-->
    </style>
<link href="estils.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	text-decoration: none;
	color: #000000;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #FF9F00;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.Estilo32 {font-size: 28pt}
.Estilo33 {
	font-size: 30pt;
	font-weight: bold;
}
.Estilo53 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
.Estilo55 {font-size: 18px}
.Estilo59 {font-size: 14px}
.Estilo60 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo63 {color: #FFFFFF}
-->
</style>
</head>
<body>
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$idServicioAhorro = $_POST["idServicioAhorro"];
	

	// Mirem primer si els valors modificats pel propi formulari del servei d'estalvi son SET
		if (isset($_POST["NombreServicioAhorro"]) and isset($_POST["CuotaAlta"]) and isset($_POST["CuotaMensual"]) and isset($_POST["CuotaMensual"]) and isset($_POST["CondicionCuotaMensual"]) and isset($_POST["CuotaVodafone"]) and isset($_POST["CuotaMovistar"]) and isset($_POST["CuotaAmena"]) and isset($_POST["CuotaFijo"])) {
				$nombre1 = $_POST["NombreServicioAhorro"];
				$cuota_alta1 = $_POST["CuotaAlta"];
				$cuota_mensual1 = $_POST["CuotaMensual"];
				$condicion_cuota_mensual1 = $_POST["CondicionCuotaMensual"];
				$cuota_vodafone = $_POST["CuotaVodafone"];
				$cuota_movistar = $_POST["CuotaMovistar"];
				$cuota_amena = $_POST["CuotaAmena"];
				$cuota_fijo = $_POST["CuotaFijo"];
				$fecha = date("Y-m-d");
				
				$sql2 = "UPDATE servicios_ahorro SET nombre = '$nombre1' , cuota_alta = '$cuota_alta1', cuota_mensual = '$cuota_mensual1', condicion_cuota_mensual = '$condicion_cuota_mensual1', cuota_vodafone = '$cuota_vodafone',     cuota_movistar = '$cuota_movistar', cuota_amena = '$cuota_amena', cuota_fijo = '$cuota_fijo', fecha = '$fecha' WHERE id = '$idServicioAhorro'";
				$result2 = mysql_query($sql2);
				if ($result2 == 0){
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
					}
					
					$sql4 = "UPDATE compatibilidades SET fecha = '$fecha' WHERE idServicioAhorro = '$idServicioAhorro'";
							$result4 = mysql_query($sql4);
							if ($result4 == 0) {
							echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
							exit();
										}
					
					
					}
	
	// Mirem si estan set els valors d'establiment de trucada i cost
	
	
				for ($i = 0 ; $i < 1000 ; $i++) {
								
	// poder estar set o els costos, o els percentatges, per tant no imposem res
	
	//			if (isset($_POST["idCosteServicioAhorro".$i.""]) and isset($_POST["establecimientoLlamada".$i.""]) and  isset($_POST["coste".$i.""])  and  isset($_POST["porcentajeDescuentoTotal".$i.""]) and  isset($_POST["porcentajeDescuentoTiempo".$i.""]))      {
				
				if (isset($_POST["idCosteServicioAhorro".$i.""]) )      {
						$idCosteServicioAhorro = $_POST["idCosteServicioAhorro".$i.""];
						$establecimiento_llamada = $_POST["establecimientoLlamada".$i.""];
						$coste = $_POST["coste".$i.""]/60;
						$porcentaje_descuento_total = $_POST["porcentajeDescuentoTotal".$i.""];
						$porcentaje_descuento_tiempo = $_POST["porcentajeDescuentoTiempo".$i.""];
						
						$sql3 = "UPDATE costes_ahorro SET establecimiento_llamada = '$establecimiento_llamada' , coste = '$coste', porcentaje_descuento_total = '$porcentaje_descuento_total', porcentaje_descuento_tiempo = '$porcentaje_descuento_tiempo' WHERE id = '$idCosteServicioAhorro'";
						   $result3 = mysql_query($sql3);
				           if ($result3 == 0){
				          	echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
							exit();
							}
							
												
							
					              }	
						else break;
								}
								
								
	// Mirem ara si s'han d'esborrar costos
	
				for ($i = 0 ; $i < 1000 ; $i++)
				 {
					if (isset($_POST["idCosteServicioAhorro".$i.""]))
					{
						$idCosteServicioAhorro = $_POST["idCosteServicioAhorro".$i.""];			
						if (($_POST["checkbox".$i.""] == "1"))
						      {
								$sql4 = "DELETE FROM costes_ahorro WHERE id = '$idCosteServicioAhorro'";
								$result4 = mysql_query($sql4);
				           		if ($result4 == 0)
				          		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
					           }
					}	
					else break;
	
				}
								
	// Ara afegim nous costos si estan set
	
	if ($_POST["TipoDia"] != "" and $_POST["IntervaloDesde"] != "" and $_POST["IntervaloHasta"] != "" and $_POST["TipoLlamada"] != "" )  {
	
//	No podem obligar a que els costos i els percentatges tinguin quelcom, ja que o bé són costos, o bé percentatges

//	if ($_POST["TipoDia"] != "" and $_POST["IntervaloDesde"] != "" and $_POST["IntervaloHasta"] != "" and $_POST["TipoLlamada"] != "" and $_POST["EstablecimientoLlamadaNuevo"] != "" and $_POST["CosteNuevo"] != "" and $_POST["PorcentajeDescuentoTotalNuevo"] != "" and $_POST["PorcentajeDescuentoTiempoNuevo"] != "")  {
	
	$idTiposDias[2];
	$nTiposDias = 1;
	$tipo_dia = $_POST["TipoDia"];
	if ($tipo_dia == "A") {
		$nTiposDias = 2;
		$idTiposDias[0] = "1";
		$idTiposDias[1] = "2";
	}
	else {
		$idTiposDias[0] = $tipo_dia;
	}
	
//	echo "<b>" . $franja_inicio . " a " . $franja_fin . "</b><br>";
	$tipo_llamada = $_POST["TipoLlamada"];
//	echo "<b>" . $tipo_llamada . "</b><br>";
	$idTiposLlamadas[4];
	$nTiposLlamadas = 1;
	// Propio operador + fijos nacionales
	if ($tipo_llamada == "A") {
		$nTiposLlamadas = 2;
		if ($idOperador == "1") {
			$idTiposLlamadas[0] = "1";
			$idTiposLlamadas[1] = "3";
		}
		else if ($idOperador == "2") {
			$idTiposLlamadas[0] = "1";
			$idTiposLlamadas[1] = "4";
		}
		else {
			$idTiposLlamadas[0] = "1";
			$idTiposLlamadas[1] = "2";
		}
	}
	// Resto de operadores móviles
	else if ($tipo_llamada == "B") {
		$nTiposLlamadas = 2;
		if ($idOperador == "1") {
			$idTiposLlamadas[0] = "2";
			$idTiposLlamadas[1] = "4";
		}
		else if ($idOperador == "2") {
			$idTiposLlamadas[0] = "2";
			$idTiposLlamadas[1] = "3";
		}
		else {
			$idTiposLlamadas[0] = "3";
			$idTiposLlamadas[1] = "4";
		}
	}
	// fijos nacionales y todos los móviles
	else if ($tipo_llamada == "C") {
		$nTiposLlamadas = 4;
		$idTiposLlamadas[0] = "1";
		$idTiposLlamadas[1] = "2";
		$idTiposLlamadas[2] = "3";
		$idTiposLlamadas[3] = "4";
	}
	// SMS a todos los operadores
	else if ($tipo_llamada == "D") {
		$nTiposLlamadas = 3;
		$idTiposLlamadas[0] = "5";
		$idTiposLlamadas[1] = "6";
		$idTiposLlamadas[2] = "7";
	}
	// MMS a todos los operadores
	else if ($tipo_llamada == "E") {
		$nTiposLlamadas = 3;
		$idTiposLlamadas[0] = "8";
		$idTiposLlamadas[1] = "9";
		$idTiposLlamadas[2] = "10";
	}
	else {
		$idTiposLlamadas[0] = $tipo_llamada;
	}
	$intervalo_desde = $_POST["IntervaloDesde"];
	$intervalo_hasta = $_POST["IntervaloHasta"];
	$establecimiento_llamada = $_POST["EstablecimientoLlamadaNuevo"];
	$coste = $_POST["CosteNuevo"] / 60.0;
	$porcentaje_descuento_total = $_POST["PorcentajeDescuentoTotalNuevo"];
	$porcentaje_descuento_tiempo = $_POST["PorcentajeDescuentoTiempoNuevo"];

	for ($i = 0; $i < $nTiposDias; $i++) {
		for ($j = 0; $j < $nTiposLlamadas; $j++) {
//			echo "<b>" . $idTiposDias[$i] . " - " . $idTiposLlamadas[$j] . "</b><br>";
			$sql = "INSERT INTO costes_ahorro (idServicioAhorro, idTipoDia, idTipoLlamada, intervalo_desde, intervalo_hasta, establecimiento_llamada, coste, porcentaje_descuento_total, porcentaje_descuento_tiempo) VALUES ('$idServicioAhorro', '$idTiposDias[$i]', '$idTiposLlamadas[$j]', '$intervalo_desde', '$intervalo_hasta', '$establecimiento_llamada', '$coste', '$porcentaje_descuento_total', '$porcentaje_descuento_tiempo')";
			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
		}
	}
	}					
							
	// Extreiem la informació del contracte i dels costos i la mostrem
	
							
				$sql = "SELECT * FROM servicios_ahorro WHERE id = '$idServicioAhorro'";
				$result = mysql_query($sql);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						//	for ($j = 0; $j < mysql_num_fields($result); $j++){
						//	echo "<b>" . $row_array[$j] . "</b><br>"; ;
						//	}
							
						}
					}
	
	
	$nombre = $row_array[1];
	$idOperador = $row_array[2];
	$nombreOperador = ObtenerNombreOperador($idOperador);
	$cuota_alta = $row_array[3];
	$cuota_mensual = $row_array[4];
	$condicion_cuota_mensual = $row_array[5];
	$cuota_vodafone = $row_array[6];
	$cuota_movistar = $row_array[7];
	$cuota_amena = $row_array[8];
	$cuota_fijo = $row_array[9];
?>
<table width="990" height="133" border="0" background="../imagenes/colorfonstitol2.jpg" id="Titol">
  <tr>
    <th width="200" rowspan="2" valign="middle" class="Estilo5" scope="col"><div align="right" class="Estilo32">
      <div align="right" class="Estilo33">Idegestion</div>
    </div></th>
    <th height="39" colspan="2" valign="bottom" class="Estilo5" scope="col"><div align="left"><img src="../imagenes/LogoID2.gif" width="29" height="20" /></div></th>
  </tr>
  <tr>
    <td height="43" colspan="2" valign="middle" class="Estilo5" scope="col"></td>
  </tr>
  <tr>
    <td height="20" valign="middle" class="Estilo5" scope="col"></td>
    <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center">Modificar servicio ahorro </div></td>
    <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"><a href="indexGestion.php" class="Estilo65">Salir</a><a href="index.php"></a></div></td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="990" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Datos del servicio de ahorro </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <form action="ProcesarModificarServicioAhorro.php" method="post" target="_self" id="form1">
 <?php
 echo "<input type=\"hidden\" name=\"idServicioAhorro\" value=\"" . $idServicioAhorro . "\">";
 ?>
    <table width="990" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="377" class="Estilo53"><div align="right">Nombre del servicio de ahorro </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		 <?php
		echo "<input name=\"NombreServicioAhorro\" type=\"text\" value= \"" . $nombre . "\" maxlength=\"31\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Operador </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		        <?php	
        	echo $nombreOperador;
			?>
         </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Cuota de alta (€): </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo "<input name=\"CuotaAlta\" type=\"text\" value= \"" . $cuota_alta . "\" maxlength=\"15\">";
		?>

        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota mensual (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo "<input name=\"CuotaMensual\" type=\"text\" value= \"" . $cuota_mensual . "\" maxlength=\"15\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Condición cuota mensual (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo "<input name=\"CondicionCuotaMensual\" type=\"text\" value= \"" . $condicion_cuota_mensual . "\" maxlength=\"15\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota Vodafone (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
        <?php
		echo "<input name=\"CuotaVodafone\" type=\"text\" value= \"" . $cuota_vodafone . "\" maxlength=\"15\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Cuota Movistar (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
	  <?php
		echo "<input name=\"CuotaMovistar\" type=\"text\" value= \"" . $cuota_movistar. "\" maxlength=\"15\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota Amena (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo "<input name=\"CuotaAmena\" type=\"text\" value= \"" . $cuota_amena . "\" maxlength=\"15\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
	   <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota fijo (€): </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo "<input name=\"CuotaFijo\" type=\"text\" value= \"" . $cuota_fijo . "\" maxlength=\"15\">";
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
	    <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
   </table>
		<table width="990">
	   <tr>
	     <td colspan="4" class="Estilo53"><div align="center"><span class="Estilo55">Costes del servicio de ahorro </span></div></td>
      </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	    </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
   </table>
    
     	  
	    <table width="990" border="1" cellspacing="0" cellpadding="0">
          <tr class="Estilo53">
            <td><div align="center">Tipo de dia</div></td>
            <td><div align="center">Intervalo desde (segundos o KBytes)</div></td>
            <td><div align="center">Intervalo hasta (segundos o KBytes)</div></td>
            <td><div align="center">Tipo de Llamada</div></td>
            <td><div align="center">Establecimiento llamada (&euro;)</div></td>
            <td><div align="center">Coste (&euro;/minuto)</div></td>
			<td><div align="center">Porcentaje descuento total (%)</div></td>
			<td><div align="center">Porcentaje descuento tiempo (%)</div></td>
			<td><div align="center">Eliminar coste ?</div></td>
          </tr>
		  
		  <?php	
        		$sql = "SELECT costes_ahorro.id, idServicioAhorro, tipos_dias.nombre, intervalo_desde, intervalo_hasta, tipos_llamadas.nombre, establecimiento_llamada, coste, porcentaje_descuento_total, porcentaje_descuento_tiempo FROM costes_ahorro JOIN tipos_llamadas, tipos_dias WHERE idServicioAhorro = '$idServicioAhorro' AND costes_ahorro.idTipoDia = tipos_dias.id AND costes_ahorro.idTipoLlamada = tipos_llamadas.id ORDER by tipos_dias.nombre DESC , tipos_llamadas.nombre" ;
				$result = mysql_query($sql);
					if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						echo "<tr>" ;
						echo "<input type=\"hidden\" name=\"idCosteServicioAhorro".$i."\" value=\"" . $row_array[0] . "\">";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[2] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[3]/3600 .
						 "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[4]/3600 .
						 "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[5] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\"><input name=\"establecimientoLlamada".$i."\" type=\"text\" value= \"". $row_array[6] . "\"></span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\"><input name=\"coste".$i."\" type=\"text\" value= \""	. $row_array[7]*60 . "\"></span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\"><input name=\"porcentajeDescuentoTotal".$i."\" type=\"text\" value= \""	. $row_array[8] . "\"</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\"><input name=\"porcentajeDescuentoTiempo".$i."\" type=\"text\" value= \""	. $row_array[9] . "\"</span></div></td>";
						echo "<td><div align=\"center\">";
						echo "<input type=\"checkbox\" name=\"checkbox".$i."\" value=\"1\" />";
						echo "</td>";								
						
						echo "</tr>";
						}
					}
					
			?>
          <tr>
            <td><div align="center"><span class="Estilo59"></span></div></td>
		    <td><div align="center"><span class="Estilo59"></span></div></td>
            <td><div align="center"><span class="Estilo59"></span></div></td>
            <td><div align="center"><span class="Estilo59"></span></div></td>
            <td><div align="center"><span class="Estilo59"></span></div></td>
            <td><div align="center"><span class="Estilo59"></span></div></td>
            <td><div align="center"><span class="Estilo59"></span></div></td>
            <td><div align="center"><span class="Estilo59"></span></div></td>    
          </tr>
        </table>
		
		<table width="990" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><span class="Estilo55 Estilo60">A&ntilde;adir costes al servicio de ahorro</span></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

	
	     	  
	    <table width="990" border="1" cellspacing="0" cellpadding="0">
          <tr class="Estilo53">
            <td><div align="center">Tipo de dia</div></td>
            <td><div align="center">Intervalo desde (segundos o KBytes)</div></td>
            <td><div align="center">Intervalo hasta (segundos o KBytes)</div></td>
            <td><div align="center">Tipo de Llamada</div></td>
            <td><div align="center">Establecimiento llamada (&euro;)</div></td>
            <td><div align="center">Coste (&euro;/minuto)</div></td>
			<td><div align="center">Porcentaje descuento total (%)</div></td>
			<td><div align="center">Porcentaje descuento tiempo (%)</div></td>
          </tr>
		  
		    <tr>
            <td><div align="center"><span class="Estilo59">
			<select name="TipoDia">
			<?php		
						echo "<option value=\"A\">Todos</option>";
						$sql = "SELECT id, nombre FROM tipos_dias";
							$result = mysql_query($sql);
							if ($result == 0)
							echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
							else
							{
							for ($i = 0; $i < mysql_num_rows($result); $i++) {
							$row_array = mysql_fetch_row($result);
							echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
								}
							}
							?>
			</select>
				</span></div></td>
		    <td><div align="center"><span class="Estilo59">
		      <input name="IntervaloDesde" type="text" class="Estilo53" size="15" />
		    </span></div></td>
            <td><div align="center"><span class="Estilo59">
			<input name="IntervaloHasta" type="text" class="Estilo53" size="15" />
			</span></div></td>
            <td><div align="center"><span class="Estilo59">
			<select name="TipoLlamada">
		 			<option value="A">lamadas propio operador + fijos</option>
					<option value="B">Llamadas resto operadores</option>
					<option value="C">Llamadas a todos</option>
					<option value="D">SMS a todos</option>
					<option value="E">MMS a todos</option>
			        <?php		
						$sql = "SELECT id, nombre FROM tipos_llamadas";
						$result = mysql_query($sql);
						if ($result == 0)
						echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
						else
						{
							for ($i = 0; $i < mysql_num_rows($result); $i++) {
							$row_array = mysql_fetch_row($result);
							echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
							}
						}
							?>
			</select>
			</span></div></td>
            <td><div align="center"><span class="Estilo59">
			<input name="EstablecimientoLlamadaNuevo" type="text" class="Estilo53" size="10" />
			</span></div></td>
            <td><div align="center"><span class="Estilo59">
			<input name="CosteNuevo" type="text" class="Estilo53" size="10" />
			</span></div></td>
			<td><div align="center"><span class="Estilo59">
			<input name="PorcentajeDescuentoTotalNuevo" type="text" class="Estilo53" size="10" />
			</span></div></td>
			<td><div align="center"><span class="Estilo59">
			<input name="PorcentajeDescuentoTiempoNuevo" type="text" class="Estilo53" size="10" />
			</span></div></td>  
          </tr>
   </table>	
		
		
		
		
	    <table width="990">
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     </tr>
	   <tr>
	     <td class="Estilo53"><div align="center">
		 <input name="Enviar" type="submit" value="Modificar servicio de ahorro  &gt;&gt;" />
	     </div></td>
	     </tr>
    </table>
       
</form>
 
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
</body>
</html>
