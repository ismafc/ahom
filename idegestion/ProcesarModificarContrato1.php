<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>paginaprincipal</title>

<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$idContrato = $_POST["idContrato"];
	

	// Mirem primer si els valors modificats pel propi formulari del contracte son SET
		if ($_POST["NombreContrato"] != "" && $_POST["CuotaAlta"] != "" and $_POST["FraccionMinima"] != "" and $_POST["UnidadTarificacion"] != "" and $_POST["ConsumoMinimo"] != "" and $_POST["BaseConsumoGratis"] != "" and $_POST["ConsumoGratis"] != "") {
				$nombre1 = $_POST["NombreContrato"];
				$cuota_alta1 = $_POST["CuotaAlta"];
				$cuota_mensual1 = $_POST["CuotaMensual"];
				$fraccion_minima1 = $_POST["FraccionMinima"];
				$unidad_tarificacion1 = $_POST["UnidadTarificacion"];
				$consumo_minimo1 = $_POST["ConsumoMinimo"];
				$base_consumo_gratis1 = $_POST["BaseConsumoGratis"];
				$consumo_gratis1 = $_POST["ConsumoGratis"];
				$fecha = date("Y-m-d");
				/*			echo "ara esta SET" . "<br>";
				echo "<b>Nombre = " . $nombre1 . "</b><br>";
				echo "<b>Operador = " . $idOperador . "</b><br>";
				echo "<b>Consumo Mínimo = " . $consumo_minimo1 . "</b><br>";
				echo "<b>Cuota alta = " . $cuota_alta1 . "</b><br>";
				echo "<b>Unidad tarificación = " . $unidad_tarificacion1 . "</b><br>";
				echo "<b>Fracción mínima = " . $fraccion_minima1 . "</b><br>";
     */   		$sql2 = "UPDATE contratos SET nombre = '$nombre1' , cuota_alta = '$cuota_alta1', cuota_mensual = '$cuota_mensual1', fraccion_minima = '$fraccion_minima1', unidad_tarificacion = '$unidad_tarificacion1', consumo_minimo = '$consumo_minimo1', base_consumo_gratis = '$base_consumo_gratis1', consumo_gratis = '$consumo_gratis1', fecha = '$fecha' WHERE id = '$idContrato'";
				$result2 = mysql_query($sql2);
				if ($result2 == 0) {
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
					exit ();
					}
					$sql3 = "UPDATE compatibilidades SET fecha = '$fecha' WHERE idContrato = '$idContrato'";
				$result3 = mysql_query($sql3);
				if ($result3 == 0) {
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
					exit();
					}
					
					}
					
					
	
	// Mirem si estan set els valors d'establiment de trucada i cost
	
				for ($i = 0 ; $i < 1000 ; $i++) {
								
				if (isset($_POST["idCoste".$i.""]) and isset($_POST["establecimientoLlamada".$i.""]) and  isset($_POST["coste".$i.""]))      {
						$idCoste = $_POST["idCoste".$i.""];
						$establecimientoLlamada = $_POST["establecimientoLlamada".$i.""];
						$coste = $_POST["coste".$i.""]/60;
						
						$sql3 = "UPDATE costes SET establecimiento_llamada = '$establecimientoLlamada' , coste = '$coste' WHERE id = '$idCoste'";
						   $result3 = mysql_query($sql3);
				           if ($result3 == 0)
				          	echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
					              }	
						else break;
	
							}
	
	
	// Mirem ara si s'han d'esborrar costos
	
				for ($i = 0 ; $i < 1000 ; $i++)
				 {
					if (isset($_POST["idCoste".$i.""]))
					{
						$idCoste = $_POST["idCoste".$i.""];			
						if (($_POST["checkbox".$i.""] == "1"))
						      {
								$sql4 = "DELETE FROM costes WHERE id = '$idCoste'";
								$result4 = mysql_query($sql4);
				           		if ($result4 == 0)
				          		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
					           }
					}	
					else break;
	
				}
	
	
								
	// Ara afegim nous costos si estan set
	
//	echo isset($_POST["TipoDia"]) . " " . isset($_POST["FranjaInicio"]) . " " . isset($_POST["FranjaFin"]) . "  " . isset($_POST["IntervaloDesde"]) . " " . isset($_POST["IntervaloHasta"]) . " " . isset($_POST["TipoLlamada"]) . " " . isset($_POST["EstablecimientoLlamadaNuevo"]) . " " . isset($_POST["CosteNuevo"]) . "<br>";
//	if (isset($_POST["TipoDia"]) && isset($_POST["FranjaInicio"]) &&  isset($_POST["FranjaFin"])  &&  isset($_POST["IntervaloDesde"]) &&  isset($_POST["IntervaloHasta"]) &&  isset($_POST["TipoLlamada"]) &&  isset($_POST["EstablecimientoLlamadaNuevo"]) &&  isset($_POST["CosteNuevo"]))  {
	if ($_POST["TipoDia"] != "" && $_POST["FranjaInicio"] != "" && $_POST["FranjaFin"] != "" && $_POST["IntervaloDesde"] != "" && $_POST["IntervaloHasta"] != "" &&  $_POST["TipoLlamada"] != "" &&  $_POST["EstablecimientoLlamadaNuevo"] != "" )  {
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
	$franja_inicio = substr($_POST["FranjaInicio"], 0, 2) * 3600 + substr($_POST["FranjaInicio"], 3, 2) * 60;
	$franja_fin = substr($_POST["FranjaFin"], 0, 2) * 3600 + substr($_POST["FranjaFin"], 3, 2) * 60;
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
//	echo "<b>" . $intervalo_desde . "</b><br>";
//	echo "<b>" . $intervalo_hasta . "</b><br>";
//	echo "<b>" . $establecimiento_llamada . "</b><br>";
//	echo "<b>" . $coste . "</b><br>";
	for ($i = 0; $i < $nTiposDias; $i++) {
		for ($j = 0; $j < $nTiposLlamadas; $j++) {
//			echo "<b>" . $idTiposDias[$i] . " - " . $idTiposLlamadas[$j] . "</b><br>";
			$sql = "INSERT INTO costes (idContrato, idTipoDia, franja_hora_inicio, franja_hora_fin, idTipoLlamada, intervalo_desde, intervalo_hasta, establecimiento_llamada, coste) VALUES ('$idContrato', '$idTiposDias[$i]', '$franja_inicio', '$franja_fin', '$idTiposLlamadas[$j]', '$intervalo_desde', '$intervalo_hasta', '$establecimiento_llamada', '$coste')";
			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
		}
	}
	}					
							
	// Extreiem la informació del contracte i dels costos i la mostrem
	
							
				$sql = "SELECT * FROM contratos WHERE id = '$idContrato'";
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
	$fraccion_minima = $row_array[5];
	$unidad_tarificacion = $row_array[6];
	$consumo_minimo = $row_array[7];
	$base_consumo_gratis = $row_array[8];
	$consumo_gratis = $row_array[9];
?>


<link type='text/xml' rel='alternate' href='/Default.vsdisco'/>
<link rel="stylesheet" href="gestion.css" type="text/css" />

	
</head>
<body id="inicio">

<div id="wrapper">

	<div id="encabezado">
	  <table border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td height="117" valign="top"><img src="imagenesmastreces/encabezadoGestion/encabezado1.gif" alt="" /></td>
    </tr>
	
	  </table>
                 
			
  </div>

   <div id="menu">
   
<table width="150" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="tarifas.php" target="_self" class="Estilo60">Tarifas c&aacute;lculo </a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="tarifasMostrar.php" target="_self" class="Estilo60">Tarifas mostrar </a><a href="GestionServicioAhorro.php" target="_self" class="Estilo60"></a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionNoticias.php" target="_self" class="Estilo60">Noticias</a><a href="GestionCompatibilidad.php" target="_self" class="Estilo60"></a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionPrensa.php" target="_self" class="Estilo60">Prensa</a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionTitular.php" target="_self" class="Estilo60">Titular</a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionClientes.php" target="_self" class="Estilo60">Clientes</a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionEstudios.php" target="_self" class="Estilo60">Estudios</a></div>
    </div></td>
  </tr>
</table>
</div>


<div id="contenido">
<table width="570" border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td width="579"> <div align="left">Ahorramovil Tarifas. Contratos. Modificar contrato </div></td>
	  </tr>
    </table>
	  <br />

<table width="579" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Datos del Contrato </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <form action="ProcesarModificarContrato1.php" method="post" target="_self" id="form1">
 <?php
 echo "<input type=\"hidden\" name=\"idContrato\" value=\"" . $idContrato. "\">";
 ?>
 <table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td width="276" class="Estilo53"><div align="right">Nombre del contrato </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"NombreContrato\" type=\"text\" value= \"" . $nombre . "\" maxlength=\"63\">";
		?>
     </label></td>
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Operador </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php	
        	echo $nombreOperador;
			?>
     </label></td>
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Cuota de alta (€): </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"CuotaAlta\" type=\"text\" value= \"" . $cuota_alta . "\" maxlength=\"15\">";
		?>
     </label></td>
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Cuota mensual (€):</div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"CuotaMensual\" type=\"text\" value= \"" . $cuota_mensual . "\" maxlength=\"15\">";
		?>
     </label></td>
  
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Fracción mínima (segundos) </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"FraccionMinima\" type=\"text\" value= \"" . $fraccion_minima . "\" maxlength=\"15\">";
		?>
     </label></td>
    
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Unidad tarificación (segundos) </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"UnidadTarificacion\" type=\"text\" value= \"" . $unidad_tarificacion . "\" maxlength=\"15\">";
		?>
     </label></td>
     
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Consumo Mínimo (€): </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"ConsumoMinimo\" type=\"text\" value= \"" . $consumo_minimo . "\" maxlength=\"15\">";
		?>
     </label></td>
    
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Base consumo gratis (€): </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"BaseConsumoGratis\" type=\"text\" value= \"" . $base_consumo_gratis . "\" maxlength=\"15\">";
		?>
     </label></td>
     
   </tr>
   <tr>
     <td width="276" class="Estilo53"><div align="right">Consumo gratis (€): </div></td>
     <td width="17">&nbsp;</td>
     <td width="276"><label>
       <?php
		echo "<input name=\"ConsumoGratis\" type=\"text\" value= \"" . $consumo_gratis . "\" maxlength=\"15\">";
		?>
     </label></td>
     
   </tr>
   <tr>
     <td width="276" class="Estilo53">&nbsp;</td>
     <td width="17">&nbsp;</td>
     <td width="276">&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td class="Estilo53">&nbsp;</td>
     <td width="17">&nbsp;</td>
     <td width="276">&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
 </table>
 <table width="570" align="center">
	   <tr>
	     <td colspan="4" class="Estilo53"><div align="center"><span class="Estilo55">Costes del contrato </span></div></td>
      </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	    </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
   </table>
    
     	  
	    <table width="570" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr class="Estilo53">
            <td><div align="center">Tipo de dia</div></td>
            <td><div align="center">Hora franja inicio (HH:MM)</div></td>
            <td><div align="center">Hora franja fin (HH:MM)</div></td>
            <td><div align="center">Intervalo desde (segundos o KBytes)</div></td>
            <td><div align="center">Intervalo hasta (segundos o KBytes)</div></td>
            <td><div align="center">Tipo de Llamada</div></td>
            <td><div align="center">Establ. llamada (&euro;)</div></td>
            <td><div align="center">Coste (&euro;/minuto)</div></td>
			<td><div align="center">Eliminar coste ?</div></td>
          </tr>
		  
		  <?php	
        		$sql = "SELECT costes.id, idContrato, tipos_dias.nombre, franja_hora_inicio, franja_hora_fin,  intervalo_desde, intervalo_hasta, tipos_llamadas.nombre, establecimiento_llamada, coste FROM costes JOIN tipos_llamadas, tipos_dias WHERE idContrato = $idContrato AND costes.idTipodia = tipos_dias.id AND costes.idTipoLlamada = tipos_llamadas.id ORDER by tipos_dias.nombre DESC , tipos_llamadas.nombre, franja_hora_inicio" ;
				$result = mysql_query($sql);
					if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						echo "<tr>" ;
						echo "<input type=\"hidden\" name=\"idCoste".$i."\" value=\"" . $row_array[0] . "\">";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[2] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[3]/3600 .
						 "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[4]/3600 .
						 "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[5] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[6] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[7] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\"><input name=\"establecimientoLlamada".$i."\" type=\"text\" value= \"". $row_array[8] . "\"></span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\"><input name=\"coste".$i."\" type=\"text\" value= \""	. $row_array[9]*60 . "\"></span></div></td>";
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
		
		<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><span class="Estilo55 Estilo60">A&ntilde;adir costes al contrato</span></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

	
	     	  
	    <table width="570" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr class="Estilo53">
            <td><div align="center">Tipo de dia</div></td>
            <td><div align="center">Hora franja inicio (HH:MM)</div></td>
            <td><div align="center">Hora franja fin (HH:MM)</div></td>
            <td><div align="center">Intervalo desde (segundos o KBytes)</div></td>
            <td><div align="center">Intervalo hasta (segundos o KBytes)</div></td>
            <td><div align="center">Tipo de Llamada</div></td>
            <td><div align="center">Establ. llamada (&euro;)</div></td>
            <td><div align="center">Coste (&euro;/minuto)</div></td>
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
		      <input name="FranjaInicio" type="text" class="Estilo53" size="10" />
		    </span></div></td>
            <td><div align="center"><span class="Estilo59">
			<input name="FranjaFin" type="text" class="Estilo53" size="10" />
			</span></div></td>
            <td><div align="center"><span class="Estilo59">
			<input name="IntervaloDesde" type="text" class="Estilo53" size="10" />
			</span></div></td>
            <td><div align="center"><span class="Estilo59">
			<input name="IntervaloHasta" type="text" class="Estilo53" size="10" />
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
          </tr>
   </table>	
		
		
		
		
	    <table width="579" align="center">
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     </tr>
	   <tr>
	     <td class="Estilo53"><div align="center">
		 <input name="Enviar" type="submit" value="Modificar Contrato  &gt;&gt;" />
	     </div></td>
	     </tr>
    </table>
       
</form>
 
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
 
</div>
</div>
</body>
</html>
