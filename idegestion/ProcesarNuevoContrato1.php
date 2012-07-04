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
<table width="570" border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td width="570"> <div align="left">Ahorramovil Tarifas. Contratos. Nuevo contrato </div></td>
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
	$nombre = $_POST["NombreContrato"];
	$idOperador = $_POST["Operador"];
	$cuota_alta = $_POST["CuotaAlta"];
	$cuota_mensual = $_POST["CuotaMensual"];
	$fraccion_minima = $_POST["FraccionMinima"];
	$unidad_tarificacion = $_POST["UnidadTarificacion"];
	$consumo_minimo = $_POST["ConsumoMinimo"];
	$base_consumo_gratis = $_POST["BaseConsumoGratis"];
	$consumo_gratis = $_POST["ConsumoGratis"];
/*	echo "<b>Nombre = " . $nombre . "</b><br>";
	echo "<b>Operador = " . $idOperador . "</b><br>";
	echo "<b>Consumo Mínimo = " . $consumo_minimo . "</b><br>";
	echo "<b>Cuota alta = " . $cuota_alta . "</b><br>";
	echo "<b>Unidad tarificación = " . $unidad_tarificacion . "</b><br>";
	echo "<b>Fracción mínima = " . $fraccion_minima . "</b><br>";
*/	
	$idContrato = "";
	$sql00 = "INSERT INTO contratos (nombre, idOperador, cuota_alta, cuota_mensual, fraccion_minima, unidad_tarificacion, consumo_minimo, base_consumo_gratis, consumo_gratis) VALUES ('$nombre', '$idOperador', '$cuota_alta', '$cuota_mensual', '$fraccion_minima', '$unidad_tarificacion', '$consumo_minimo', '$base_consumo_gratis', '$consumo_gratis')";
	$result00 = mysql_query($sql00);
	
	$sql01 = "SELECT id FROM contratos WHERE nombre = '$nombre'";
	$result01 = mysql_query($sql01);
	if ($result01 == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array01 = mysql_fetch_row($result01);
	$idContrato = $row_array01[0];
	?>
<form name="form1" method="post" action="ModificarContrato1.php">
  <label><br>
  </label>
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center">
	  	<?php
		echo "<input type=\"hidden\" name=\"idContrato\" value=\"" . $idContrato . "\">";
		echo "<b>id = " . $idContrato . "</b><br>";
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
