<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>


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

      <td width="570"> <div align="left">Ahorramovil Tarifas. Servicios de ahorro. Nuevo Servicio de ahorro </div></td>
	  </tr>
    </table>
	  <br />
 <p>&nbsp;</p>
 <?php
		include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$nombre = $_POST["ServicioAhorro"];
	$idOperador = $_POST["Operador"];
	$cuota_alta = $_POST["CuotaAlta"];
	$cuota_mensual = $_POST["CuotaMensual"];
	$condicion_cuota_mensual = $_POST["CondicionCuotaMensual"];
	$cuota_vodafone = $_POST["CuotaVodafone"];
	$cuota_movistar = $_POST["CuotaMovistar"];
	$cuota_amena = $_POST["CuotaAmena"];
	$cuota_fijo = $_POST["CuotaFijo"];
	$numero_lineas = $_POST["NumeroLineas"];
	$numero_lineas_vodafone = $_POST["NumeroLineasVodafone"];
	$numero_lineas_movistar = $_POST["NumeroLineasMovistar"];
	$numero_lineas_amena = $_POST["NumeroLineasAmena"];
	$numero_lineas_fijo = $_POST["NumeroLineasFijo"];
	
	
	$idServicioAhorro = "";
	$sql0 = "INSERT INTO servicios_ahorro (nombre, idOperador, cuota_alta, cuota_mensual, condicion_cuota_mensual, cuota_vodafone, cuota_movistar , cuota_amena , cuota_fijo) VALUES ('$nombre', '$idOperador', '$cuota_alta', '$cuota_mensual', '$condicion_cuota_mensual', '$cuota_vodafone', '$cuota_movistar' , '$cuota_amena' , '$cuota_fijo')";
	$result0 = mysql_query($sql0);
	if ($result0 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	
	$sql1 = "SELECT id FROM servicios_ahorro WHERE nombre = '$nombre'";
	$result1 = mysql_query($sql1);
	if ($result1 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array1 = mysql_fetch_row($result1);
	$idServicioAhorro = $row_array1[0];

	$combinacion = 0;
	$sql00 = "SELECT MAX(combinacion) FROM combinaciones_servicios_ahorro WHERE idServicioAhorro = '$idServicioAhorro'";
	$result00 = mysql_query($sql00);
	if ($result00 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result00) != 0) {
		$row_array00 = mysql_fetch_row($result00);
		$combinacion = $row_array00[0] + 1;
	}
	if ($numero_lineas_vodafone != 0) {
		$sql01 = "INSERT INTO combinaciones_servicios_ahorro (idServicioAhorro, combinacion, idTipoLlamada, NumeroLineas) VALUES ('$idServicioAhorro', '$combinacion', '2', '$numero_lineas_vodafone')";
		$result01 = mysql_query($sql01);
	}
	if ($numero_lineas_movistar != 0) {
		$sql01 = "INSERT INTO combinaciones_servicios_ahorro (idServicioAhorro, combinacion, idTipoLlamada, NumeroLineas) VALUES ('$idServicioAhorro', '$combinacion', '3', '$numero_lineas_movistar')";
		$result01 = mysql_query($sql01);
	}
	if ($numero_lineas_amena != 0) {
		$sql01 = "INSERT INTO combinaciones_servicios_ahorro (idServicioAhorro, combinacion, idTipoLlamada, NumeroLineas) VALUES ('$idServicioAhorro', '$combinacion', '4', '$numero_lineas_amena')";
		$result01 = mysql_query($sql01);
	}
	if ($numero_lineas_fijo != 0) {
		$sql01 = "INSERT INTO combinaciones_servicios_ahorro (idServicioAhorro, combinacion, idTipoLlamada, NumeroLineas) VALUES ('$idServicioAhorro', '$combinacion', '1', '$numero_lineas_fijo')";
		$result01 = mysql_query($sql01);
	}
	if ($numero_lineas != 0) {
		$sql01 = "INSERT INTO combinaciones_servicios_ahorro (idServicioAhorro, combinacion, NumeroLineas) VALUES ('$idServicioAhorro', '$combinacion', '$numero_lineas')";
		$result01 = mysql_query($sql01);
	}
	
	?>
<form action="ModificarServicioAhorro1.php" method="post" name="form1" target="_self">
  <label><br>
  </label>
  <table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center">
	  	<?php
		echo "<input type=\"hidden\" name=\"idServicioAhorro\" value=\"" . $idServicioAhorro . "\">";
		echo "<b>id = " . $idServicioAhorro . "</b><br>";
		?>
        <input type="submit" name="Submit" value="Continuar &gt;&gt;">
      </div></td>
    </tr>
  </table>
</form>
 
 
</div>





<div id="pie">
<table width="779" border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td width="579"> <div align="right"><a href="indexGestion1.php" target="_self">Ahorramovil Gestion. </a></div></td>
	  <td width="200"> <div id="fecha"><?php echo obtenerFechaActual(); ?></div></td>
    </tr>
	
	  </table>
</div>
</div>
</body>
</html>
