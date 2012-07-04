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
	$condicion_cuota_mensual = $row_array[4];
	$cuota_vodafone = $row_array[5];
	$cuota_movistar = $row_array[6];
	$cuota_amena = $row_array[7];
	$cuota_fijo = $row_array[8];
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
    <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center">Eliminar servicio de ahorro </div></td>
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
 <form action="ServicioAhorroEliminado.php" method="post" target="_self" id="form1">
 <?php
 echo "<input type=\"hidden\" name=\"idServicioAhorro\" value=\"" . $idServicioAhorro . "\">";
 ?>
    <table width="990" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="377" class="Estilo53"><div align="right">Nombre del servicio de ahorro </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		 <?php
		echo  $nombre;
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
		echo $cuota_alta;
		?>

        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota mensual (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo  $cuota_mensual;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Condición cuota mensual (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo $condicion_cuota_mensual;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota Vodafone (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
        <?php
		echo $cuota_vodafone;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Cuota Movistar (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
	  <?php
		echo $cuota_movistar;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota Amena (€):</div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo $cuota_amena;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
	   <tr>
         <td width="377" class="Estilo53"><div align="right">Cuota fijo (€): </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo $cuota_fijo;
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
						echo "<td><div align=\"center\"><span class=\"Estilo59\">" . $row_array[6] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[7]*60 . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[8] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[9] . "</span></div></td>";								
						
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
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

	
	     	  
	    <table width="990">
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     </tr>
	   <tr>
	     <td class="Estilo53"><div align="center">
		 <input name="Enviar" type="submit" value="Eliminar servicio de ahorro  &gt;&gt;" />
	     </div></td>
	     </tr>
    </table>
       
</form>
 
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
</body>
</html>
