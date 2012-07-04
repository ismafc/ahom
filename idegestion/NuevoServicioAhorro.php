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
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>
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
-->
</style>
</head>
<body>
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
    <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center">Nuevo servicio de ahorro</div></td>
    <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"><a href="indexGestion.php" class="Estilo63">Salir</a><a href="index.php"></a></div></td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="990" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Datos del Servicio de ahorro </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
  	
 <form action="ProcesarNuevoServicioAhorro.php" method="post" target="_self" id="form1">
    <table width="990" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="495" class="Estilo53"><div align="right">Nombre del servicio de ahorro</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="ServicioAhorro" type="text" class="Estilo53" id="Nombre" />
        </label></td>
      </tr>
      <tr>
        <td width="495" class="Estilo53"><div align="right">Operador </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
		<select name="Operador">
        <?php	
        		 $sql = "SELECT id, nombre FROM operadores";
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
        <td width="495" class="Estilo53"><div align="right">Cuota de alta (€) </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CuotaAlta" type="text" class="Estilo53" />
        </label></td>
      </tr>
      <tr>
         <td width="495" class="Estilo53"><div align="right">Cuota mensual (€)</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CuotaMensual" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
         <td width="495" class="Estilo53"><div align="right">Concición cuota mensual (€)</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CondicionCuotaMensual" type="text" class="Estilo53" />
        </label></td>
      </tr>
      <tr>
        <td width="495" class="Estilo53"><div align="right">Cuota Vodafone (€/teléfono)  </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CuotaVodafone" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
        <td width="495" class="Estilo53"><div align="right">Cuota Movistar (€/teléfono)  </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CuotaMovistar" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
        <td width="495" class="Estilo53"><div align="right">Cuota Amena (€/teléfono)  </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CuotaAmena" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  
	  <tr>
        <td width="495" class="Estilo53"><div align="right">Cuota fijo (€/teléfono)  </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="CuotaFijo" type="text" class="Estilo53" />
        </label></td>
      </tr>
      <tr>
         <td width="495" class="Estilo53"><div align="right">Numero de Líneas </div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="NumeroLineas" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
         <td width="495" class="Estilo53"><div align="right">Numero de Líneas Vodafone</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="NumeroLineasVodafone" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
         <td width="495" class="Estilo53"><div align="right">Numero de Líneas Movistar</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="NumeroLineasMovistar" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
         <td width="495" class="Estilo53"><div align="right">Numero de Líneas Amena</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="NumeroLineasAmena" type="text" class="Estilo53" />
        </label></td>
      </tr>
	  <tr>
         <td width="495" class="Estilo53"><div align="right">Numero de Líneas fijo</div></td>
        <td width="11">&nbsp;</td>
        <td width="484"><label>
          <input name="NumeroLineasFijo" type="text" class="Estilo53" />
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
	     <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>
		 <input name="Enviar" type="submit" value="Continuar &gt;&gt;   ">		</td>
      </tr>
    </table>
</form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
 
</body>
</html>
