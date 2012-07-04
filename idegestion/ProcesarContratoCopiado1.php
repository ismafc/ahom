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
	$idContratoViejo = $_POST["idContratoViejo"];
	$nombreNuevo = $_POST["NombreContratoNuevo"];
	$idOperadorNuevo = $_POST["OperadorNuevo"];


// ara farem la selecció de tots els camps del contracte antic per copiar


	$sql = "SELECT * FROM contratos WHERE id = '$idContratoViejo'";
				$result = mysql_query($sql);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						
							
						}
					}
	
	$cuota_alta = $row_array[3];
	$cuota_mensual = $row_array[4];
	$fraccion_minima = $row_array[5];
	$unidad_tarificacion = $row_array[6];
	$consumo_minimo = $row_array[7];
	$base_consumo_gratis = $row_array[8];
	$consumo_gratis = $row_array[9];


// copiem les dades per al nou contracte



$sql00 = "INSERT INTO contratos (nombre, idOperador, cuota_alta, cuota_mensual, fraccion_minima, unidad_tarificacion, consumo_minimo, base_consumo_gratis, consumo_gratis) VALUES ('$nombreNuevo', '$idOperadorNuevo', '$cuota_alta', '$cuota_mensual', '$fraccion_minima', '$unidad_tarificacion', '$consumo_minimo', '$base_consumo_gratis', '$consumo_gratis')";
	$result00 = mysql_query($sql00);
	if ($result00 == 0) {
			echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>"; }
					
			else
					
			{
	
			// ara rescatem els costos del contracte antic


			$sql200 = "SELECT * FROM costes WHERE idContrato = $idContratoViejo";
				$result = mysql_query($sql200);
					if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					$numerodecostes = mysql_num_rows($result);
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						
						$id_tipo_dia[$i] = $row_array[2];
						$franja_hora_inicio[$i] = $row_array[3];
						$franja_hora_fin[$i] = $row_array[4]; 
						$id_tipo_llamada[$i] = $row_array[5];
						$intervalo_desde[$i] = $row_array[6];
						$intervalo_hasta[$i] = $row_array[7];
						$establecimiento_llamada[$i] = $row_array[8];
						$coste[$i] = $row_array[10];
						
									
						
						}
					}
					
			// ara copiem els costos pel nou contracte

			$sql400 = "SELECT id, nombre FROM contratos WHERE nombre = '$nombreNuevo'";
				$result = mysql_query($sql400);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					$row_array = mysql_fetch_row($result);
					$idContratoNuevo= $row_array[0];
						
					}


			for ($i = 0; $i < $numerodecostes; $i++) {

			$sql300 = "INSERT INTO costes (idContrato, idTipoDia, franja_hora_inicio, franja_hora_fin, idTipoLlamada, 		intervalo_desde, intervalo_hasta, establecimiento_llamada, coste) VALUES ('$idContratoNuevo', '$id_tipo_dia[$i]', '$franja_hora_inicio[$i]', '$franja_hora_fin[$i]', '$id_tipo_llamada[$i]', '$intervalo_desde[$i]', '$intervalo_hasta[$i]', '$establecimiento_llamada[$i]', '$coste[$i]')";
			$result = mysql_query($sql300);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();					
			}
			}	
			}			
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

      <td width="570"> <div align="left">Ahorramovil Tarifas. Contratos. Copiar contrato </div></td>
	  </tr>
    </table>
	  <br />

 <table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Contrato copiado con éxito !! </div></td>
   </tr>
 </table>


<form action="ProcesarModificarContrato1.php" method="post" name="form" target="_self">
  <?php
  
  echo "<input type=\"hidden\" name=\"idContrato\" value=\"" . $idContratoNuevo . "\">";
  
  ?>
  <br />

<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td width="570" class="Estilo53"><div align="center" class="Estilo55">Datos del Contrato </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 
     <table width="571" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="276" class="Estilo53"><div align="right">Nombre del contrato </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		 <?php
		echo  $nombreNuevo ;
		?>
        </label></td>
        </tr>
      <tr>
        <td width="276" class="Estilo53"><div align="right">Operador </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		        <?php	
			$nombreOperador = ObtenerNombreOperador($idOperadorNuevo);
        	echo $nombreOperador;
			?>
         </label></td>
        </tr>
      <tr>
        <td width="276" class="Estilo53"><div align="right">Cuota de alta (€): </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		  <?php
		echo $cuota_alta;
		?>

        </label></td>
        </tr>
      <tr>
         <td width="276" class="Estilo53"><div align="right">Cuota mensual (€):</div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		  <?php
		echo  $cuota_mensual;
		?>
        </label></td>
        </tr>
      <tr>
        <td width="276" class="Estilo53"><div align="right">Fracción mínima (segundos) </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		  <?php
		echo $fraccion_minima ;
		?>
        </label></td>
        </tr>
      <tr>
         <td width="276" class="Estilo53"><div align="right">Unidad tarificación (segundos) </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
        <?php
		echo $unidad_tarificacion ;
		?>
        </label></td>
        </tr>
      <tr>
        <td width="276" class="Estilo53"><div align="right">Consumo Mínimo (€): </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
	  <?php
		echo $consumo_minimo;
		?>
        </label></td>
        </tr>
      <tr>
         <td width="276" class="Estilo53"><div align="right">Base consumo gratis (€): </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		  <?php
		echo $base_consumo_gratis;
		?>
        </label></td>
        </tr>
	   <tr>
         <td width="276" class="Estilo53"><div align="right">Consumo gratis (€): </div></td>
        <td width="17">&nbsp;</td>
        <td width="275"><label>
		  <?php
		echo $consumo_gratis;
		?>
        </label></td>
        </tr>
	    <tr>
	     <td width="276" class="Estilo53">&nbsp;</td>
	     <td width="17">&nbsp;</td>
	     <td width="275">&nbsp;</td>
        </tr>
	   <tr>
	     <td width="276" class="Estilo53">&nbsp;</td>
	     <td width="17">&nbsp;</td>
	     <td width="275">&nbsp;</td>
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
            <td><div align="center">Establecimiento llamada (&euro;)</div></td>
            <td><div align="center">Coste (&euro;/minuto)</div></td>
          </tr>
		  
		  <?php	
        		$sql = "SELECT costes.id, idContrato, tipos_dias.nombre, franja_hora_inicio, franja_hora_fin,  intervalo_desde, intervalo_hasta, tipos_llamadas.nombre, establecimiento_llamada, coste FROM costes JOIN tipos_llamadas, tipos_dias WHERE idContrato = $idContratoNuevo AND costes.idTipodia = tipos_dias.id AND costes.idTipoLlamada = tipos_llamadas.id ORDER by tipos_dias.nombre DESC , franja_hora_inicio, tipos_llamadas.nombre" ;
				$result = mysql_query($sql);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						echo "<tr>" ;
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[2] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[3]/3600 .
						 "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[4]/3600 .
						 "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[5] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[6] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"	. $row_array[7] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"  . $row_array[8] . "</span></div></td>";
						echo "<td><div align=\"center\"><span class=\"Estilo59\">"  . $row_array[9]*60 . "</span></div></td>";
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
		
		<table width="570" align="center">
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     </tr>
	   <tr>
	     <td class="Estilo53"><div align="center">
		 
		 <input name="Enviar" type="submit" value="Modificar Contrato " />
	     </div></td>
	     </tr>
    </table>
       
</form>
</div>
</div>
</body>
</html>
