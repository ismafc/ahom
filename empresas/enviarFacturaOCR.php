<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Procesado de facturas</title>
<script language="JavaScript" type="text/JavaScript">

function clickMovistar() {
	document.FormularioMovistar.submit();
	return true;
}

</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
</head>
<?php
  if (!isset($mainFolder))
	$mainFolder = "../";
	include($mainFolder . "Lib/library.inc");
	include($mainFolder . "Lib/main.inc");
	include($mainFolder . "Lib/facturas.inc");
	include($mainFolder . "Lib/base.inc");
	if (openDatabase() == false)
		exit();

	// 	Provisionalmente
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
	
	$login = $_SESSION['miembro'];
	$password = $_SESSION['password'];
	$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$idMiembro = $row_array[0];
	$nFacturas = obtenerNumeroDeFacturasMiembro($idMiembro);
?>

<body>
	<div id="Movistar">
  <form action="procesarFacturaOCR.php" method="post" enctype="multipart/form-data" target="_self" id="FormularioMovistar" name="FormularioMovistar">
        <table width="418" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="11" height="49" valign="middle">
            <!--<input type="submit" id="EMovistar" name="EMovistar" value="" /> -->            </td>
            <td width="44" height="49" valign="top" onclick="clickMovistar()"><a href="#">Enviar factura Movistar</a></td>
            <td height="49" align="center" valign="middle"><input type="file" id="FacturaPdfMovistar1b" name="FacturaPdfMovistar1b" /></td>
            </tr>
        </table>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	    </form>
	</div>
</body>

</html>
