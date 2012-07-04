<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>
<style type="text/css">
<!--
.Estilo43 {color: #FFFFFF}
.Estilo57 {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
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
.Estilo62 {color: #FFFBF0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo60 {font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo63 {	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	font-weight: bold;
}
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
?>
<html>
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
    <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"><a href="indexGestion.php" class="Estilo63">Salir</a><a href="index.php"></a></div></td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="990" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Selecciona el servicio de ahorro </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <form action="ProcesarEliminarServicioAhorro.php" method="post" target="_self" id="form1">
    <table width="990" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td width="482" class="Estilo53"><div align="right">Escoge el servicio de ahorro </div></td>
        <td width="17">&nbsp;</td>
        <td width="491"><label>
		<select name="idServicioAhorro">
		        <?php	
        		 $sql = "SELECT id, nombre FROM servicios_ahorro";
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
        </label></td>
      </tr>

	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>
		 <input name="Enviar" type="submit" value="  Eliminar &gt;&gt;">		</td>
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
