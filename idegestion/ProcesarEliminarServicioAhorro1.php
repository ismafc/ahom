<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>

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

<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>

      <td width="579"> <div align="left">Ahorramovil Tarifas. Servicios de ahorro. Eliminar Servicio de ahorro </div></td>
	  </tr>
    </table>
	  <br />

<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Datos del servicio de ahorro </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <form action="ServicioAhorroEliminado1.php" method="post" target="_self" id="form1">
 <?php
 echo "<input type=\"hidden\" name=\"idServicioAhorro\" value=\"" . $idServicioAhorro . "\">";
 ?>
    <table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="280" class="Estilo53"><div align="right">Nombre del servicio de ahorro </div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		 <?php
		echo  $nombre;
		?>
        </label></td>
        </tr>
      <tr>
        <td width="280" class="Estilo53"><div align="right">Operador </div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		        <?php	
        	echo $nombreOperador;
			?>
         </label></td>
        </tr>
      <tr>
        <td width="280" class="Estilo53"><div align="right">Cuota de alta (€): </div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		  <?php
		echo $cuota_alta;
		?>

        </label></td>
        </tr>
      <tr>
         <td width="280" class="Estilo53"><div align="right">Cuota mensual (€):</div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		  <?php
		echo  $cuota_mensual;
		?>
        </label></td>
        </tr>
      <tr>
        <td width="280" class="Estilo53"><div align="right">Condición cuota mensual (€):</div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		  <?php
		echo $condicion_cuota_mensual;
		?>
        </label></td>
        </tr>
      <tr>
         <td width="280" class="Estilo53"><div align="right">Cuota Vodafone (€):</div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
        <?php
		echo $cuota_vodafone;
		?>
        </label></td>
        </tr>
      <tr>
        <td width="280" class="Estilo53"><div align="right">Cuota Movistar (€):</div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
	  <?php
		echo $cuota_movistar;
		?>
        </label></td>
        </tr>
      <tr>
         <td width="280" class="Estilo53"><div align="right">Cuota Amena (€):</div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		  <?php
		echo $cuota_amena;
		?>
        </label></td>
        </tr>
	   <tr>
         <td width="280" class="Estilo53"><div align="right">Cuota fijo (€): </div></td>
        <td width="10">&nbsp;</td>
        <td width="280"><label>
		  <?php
		echo $cuota_fijo;
		?>
        </label></td>
        </tr>
	    <tr>
	     <td width="280" class="Estilo53">&nbsp;</td>
	     <td width="10">&nbsp;</td>
	     <td width="280">&nbsp;</td>
        </tr>
	   <tr>
	     <td width="280" class="Estilo53">&nbsp;</td>
	     <td width="10">&nbsp;</td>
	     <td width="280">&nbsp;</td>
        </tr>
   </table>
		<table width="570" align="center">
	   <tr>
	     <td colspan="4" class="Estilo53"><div align="center"><span class="Estilo55">Costes del servicio de ahorro </span></div></td>
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
		
		<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
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

	
	     	  
	    <table width="570" align="center">
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
</div>
</div>
</body>
</html>
