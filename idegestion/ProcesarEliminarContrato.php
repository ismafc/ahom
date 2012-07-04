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
	$idContrato = $_POST["idContrato"];
			
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
/*	echo "<b>Nombre = " . $nombre . "</b><br>";
	echo "<b>Operador = " . $idOperador . "</b><br>";
	echo "<b>Consumo Mínimo = " . $consumo_minimo . "</b><br>";
	echo "<b>Cuota alta = " . $cuota_alta . "</b><br>";
	echo "<b>Unidad tarificación = " . $unidad_tarificacion . "</b><br>";
	echo "<b>Fracción mínima = " . $fraccion_minima . "</b><br>";
	
*/?>
<form action="contratoEliminado.php" method="post" name="form" target="_self">
  <?php
  
  echo "<input type=\"hidden\" name=\"idContrato\" value=\"" . $idContrato . "\">";
  
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
      <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center">Eliminar contrato </div></td>
      <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"><a href="indexGestion.php" class="Estilo64">Salir</a><a href="index.php"></a></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
 <table width="990" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Datos del Contrato </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 
     <table width="990" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="377" class="Estilo53"><div align="right">Nombre del contrato </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		 <?php
		echo  $nombre ;
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
        <td width="377" class="Estilo53"><div align="right">Fracción mínima (segundos) </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo $fraccion_minima ;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Unidad tarificación (segundos) </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
        <?php
		echo $unidad_tarificacion ;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
        <td width="377" class="Estilo53"><div align="right">Consumo Mínimo (€): </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
	  <?php
		echo $consumo_minimo;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
      <tr>
         <td width="377" class="Estilo53"><div align="right">Base consumo gratis (€): </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo $base_consumo_gratis;
		?>
        </label></td>
        <td width="372">&nbsp;</td>
      </tr>
	   <tr>
         <td width="377" class="Estilo53"><div align="right">Consumo gratis (€): </div></td>
        <td width="19">&nbsp;</td>
        <td width="222"><label>
		  <?php
		echo $consumo_gratis;
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
	     <td colspan="4" class="Estilo53"><div align="center"><span class="Estilo55">Costes del contrato </span></div></td>
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
            <td><div align="center">Hora franja inicio (HH:MM)</div></td>
            <td><div align="center">Hora franja fin (HH:MM)</div></td>
            <td><div align="center">Intervalo desde (segundos o KBytes)</div></td>
            <td><div align="center">Intervalo hasta (segundos o KBytes)</div></td>
            <td><div align="center">Tipo de Llamada</div></td>
            <td><div align="center">Establecimiento llamada (&euro;)</div></td>
            <td><div align="center">Coste (&euro;/minuto)</div></td>
          </tr>
		  
		  <?php	
        		$sql = "SELECT costes.id, idContrato, tipos_dias.nombre, franja_hora_inicio, franja_hora_fin,  intervalo_desde, intervalo_hasta, tipos_llamadas.nombre, establecimiento_llamada, coste FROM costes JOIN tipos_llamadas, tipos_dias WHERE idContrato = $idContrato AND costes.idTipodia = tipos_dias.id AND costes.idTipoLlamada = tipos_llamadas.id ORDER by tipos_dias.nombre DESC , franja_hora_inicio, tipos_llamadas.nombre" ;
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
		 
		 <input name="Enviar" type="submit" value="Eliminar Contrato " />
	     </div></td>
	     </tr>
    </table>
       
</form>
 
 
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
 
    <?php 
//	echo "<form name=\"form1\" method=\"post\" action=\"ProcesarContrato.php\">";
//	echo "Nombre del contrato: <input name=\"NombreContrato\" type=\"text\" maxlength=\"64\"><br><br>";
//	echo "Operador: <select name=\"Operador\">";
//	$sql = "SELECT id, nombre FROM operadores";
//	$result = mysql_query($sql);
//	if ($result == 0)
//		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
//	else
//	{
//		for ($i = 0; $i < mysql_num_rows($result); $i++) {
//			$row_array = mysql_fetch_row($result);
//			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
//		}
//	}
//	echo "</select><br><br>";
//	echo "Cuota de alta (&#8364;): <input name=\"CuotaAlta\" type=\"text\" maxlength=\"15\"><br><br>";
//	echo "Cuota mensual (&#8364;): <input name=\"CuotaMensual\" type=\"text\" maxlength=\"15\"><br><br>";
//	echo "Fracción mínima (segundos): <input name=\"FraccionMinima\" type=\"text\" value=\"60\" maxlength=\"15\"><br><br>";
//	echo "Unidad tarificación (segundos): <input name=\"UnidadTarificacion\" type=\"text\" value=\"1\" maxlength=\"15\"><br><br>";
// echo "Consumo Mínimo (&#8364;): <input name=\"ConsumoMinimo\" type=\"text\" maxlength=\"15\"><br><br>";
//	echo "Base consumo gratis (&#8364;): <input name=\"BaseConsumoGratis\" type=\"text\" value=\"0\" maxlength=\"15\"><br><br>";
//	echo "Consumo gratis (&#8364;): <input name=\"ConsumoGratis\" type=\"text\" value=\"0\" maxlength=\"15\"><br><br>";
//	echo "<table width=\"100%\" border=\"0\">";
//	echo "<tr><td height=\"2\" bgcolor=\"#000000\"></td></tr>";
//	echo "</table><br>";
//	echo "Tipo de día: <select name=\"TipoDia\">";
//	echo "<option value=\"A\">Todos</option>";
//	$sql = "SELECT id, nombre FROM tipos_dias";
//	$result = mysql_query($sql);
//	if ($result == 0)
//		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
//	else
//	{
//		for ($i = 0; $i < mysql_num_rows($result); $i++) {
//			$row_array = mysql_fetch_row($result);
//			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
//		}
//	}
//	echo "</select><br><br>";
//	echo "Tipo de llamada: <select name=\"TipoLlamada\">";
//	echo "<option value=\"A\">Llamadas propio operador + fijos</option>";
//	echo "<option value=\"B\">Llamadas resto operadores</option>";
//	echo "<option value=\"C\">Llamadas a todos</option>";
//	echo "<option value=\"D\">SMS a todos</option>";
//	echo "<option value=\"E\">MMS a todos</option>";
//	$sql = "SELECT id, nombre FROM tipos_llamadas";
//	$result = mysql_query($sql);
//	if ($result == 0)
//		echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
//	else
//	{
//		for ($i = 0; $i < mysql_num_rows($result); $i++) {
//			$row_array = mysql_fetch_row($result);
//			echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
//		}
//	}
//	echo "</select><br><br>";
//	echo "Hora franja inicio (HH:MM): <input name=\"FranjaInicio\" type=\"text\" maxlength=\"5\">";
//	echo "Hora franja fin (HH:MM): <input name=\"FranjaFin\" type=\"text\" maxlength=\"5\"><br><br>";
//	echo "Intervalo desde (segundos o KBytes): <input name=\"IntervaloDesde\" type=\"text\" value=\"0\" maxlength=\"10\">";
//	echo "Intervalo hasta (segundos o KBytes): <input name=\"IntervaloHasta\" type=\"text\" value=\"86400\" maxlength=\"10\"><br><br>";
//	echo "Establecimiento llamada (&#8364;): <input name=\"EstablecimientoLlamada\" type=\"text\" maxlength=\"15\">";
//	echo "Coste (&#8364;/minuto): <input name=\"Coste\" type=\"text\" maxlength=\"15\"><br><br>";
//	echo "<input name=\"Enviar\" type=\"submit\" value=\"Añadir\">";
//	echo "</form>";

?>
</p>
  <p>&nbsp;  </p>
</body>
</html>
