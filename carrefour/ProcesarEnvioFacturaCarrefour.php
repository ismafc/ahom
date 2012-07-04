<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html>
<head>
<title>Resultados Carrefour</title>
<script type="text/javascript">
<!--
function LanzarResultadosDetalladosCarrefour(numerotelefono1, numerotelefono2, numerotelefono3, numerotelefono4, numerotelefono5) { //v2.0
	texto = numerotelefono1;
	if (numerotelefono2 != null)
		texto = texto + ", " + numerotelefono2;
	if (numerotelefono3 != null)
		texto = texto + ", " + numerotelefono3;
	if (numerotelefono4 != null)
		texto = texto + ", " + numerotelefono4;
	if (numerotelefono5 != null)
		texto = texto + ", " + numerotelefono5;
	newWindow = open("http://www.ahorramovil.com/carrefour/detallesCarrefour.php?Telefono=" + texto, "Detalles", "scrollbars,resizable,width=700,height=500");
}

function ValidaDatos() {
	if (document.Formulario.Factura.value=="") {
		alert("por favor, selecciona la factura a enviar");
    	return false;
	}
	else { document.Formulario.submit }
}

//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.texto_normal {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #E881B9;
	font-weight: normal;
	text-decoration: none;
}
.texto_normal a {
	color: #E881B9;
}
.texto_normal a:hover {
	text-decoration:none;
}
.Estilo3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #990033;
}
.Estilo4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #990033;
}
body {
	background-color:#ffffff;
	margin:0;
	padding:0 0 0 5px;
}
-->
</style>
</head>
<body>
<?php
	include_once("./../Lib/library.inc");
	include_once("./Lib/main.inc");
	include_once("./../Lib/facturas.inc");
	include_once("./Lib/base.inc");
	if (openDatabase() == false)
		exit();

	// Creamos un usuario Carrefour
	unset($_SESSION['miembroCarrefour'], $_SESSION['passwordCarrefour']);
	if (!isset($_SESSION['miembroCarrefour'], $_SESSION['passwordCarrefour'])) {
		$_SESSION['miembroCarrefour'] = session_id();
		$_SESSION['passwordCarrefour'] = session_id();
		crearUsuarioCarrefour($_SESSION['miembroCarrefour'], $_SESSION['passwordCarrefour']);
	}	

	$login = $_SESSION['miembroCarrefour'];
	$password = $_SESSION['passwordCarrefour'];
	$sql = "SELECT id FROM miembros WHERE Login = '$login' AND Password = '$password'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	$idMiembro = $row_array[0];
	$nFacturas = obtenerNumeroDeFacturasMiembro($idMiembro);

	$idFactura = 0;
	$edad_titular = 0;
	$idParentesco = 3;
	$descripcion = "";
	$numeros_moviles_llamantes = array();
	$numeros = 0;

	if ($_FILES["Factura"]["name"] != false) {
		$destination = "./data/".$_FILES["Factura"]["name"].".".$idMiembro;
		$temp_file = $_FILES["Factura"]["tmp_name"];
		move_uploaded_file($temp_file, $destination);
	
		$content = "";
		$size = filesize($destination);
		if  ($size > 0) {
			$fp = fopen($destination, "r");
			$content = fread($fp, $size);
			fclose($fp);
		}
		
		$n = procesarFactura($content, $idMiembro, $edad_titular, $idParentesco, $descripcion, $idFactura);
		if ($n[0] == '!') {
			insertarErrorProcesoFactura($idMiembro, $destination, $n);
			?>
				<table width="490" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="10" height="10"><img src="imagenes/tit_calcula.png" width="490"></td>
					</tr>
				</table>
				<br>
				<table width="490" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td colspan="3"><p class="texto_normal"><strong>Resultado del cálculo</strong></p></td>
					</tr>
					<tr>
						<td width="40" height="20"></td>
						<td></td>
						<td width="40"></td>
					</tr>
					<tr>
						<td width="40"></td>
						<td>
							<div align="justify"><span class="texto_normal">
							<br>¡No se pudo procesar la factura correctamente! El fichero no es una factura de telefonía móvil o ésta no se ajusta a ninguno los formatos reconocidos por el sistema.<br>
							<br>Te invitamos a que descubras nuestras promociones y la telefonía móvil más sencilla y barata haciendo clic <a href=http://www.carrefour.es/movil/servicios/tarjeta-prepago.html target="_parent">aquí</a>.
							<br>
							<br>
							</span>
							</div>
						</td>
						<td width="40"></td>
					</tr>
				</table>
				<br>
				<form action="http://www.ahorramovil.com/carrefour/ProcesarEnvioFacturaCarrefour.php" method="post" enctype="multipart/form-data" name="Formulario" target="_self" id="Formulario" onSubmit="return ValidaDatos()">
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
					<table width="490" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="facturas">
						<tr>
							<td height="10" colspan="3" valign="middle" class="texto_normal">
								<strong>Env&iacute;a m&aacute;s facturas</strong>
							</td>
						</tr>
						<tr>
							<td width="40" height="10" valign="middle"></td>
							<td height="10" align="center"></td>
							<td width="40" height="10"></td>
					    </tr>
					    <tr>
							<td width="40" valign="middle"></td>
							<td align="center"><input name="Factura" type="file" class="Estilo3" size="50" /></td>
							<td width="40"></td>
					    </tr>
						<tr>
							<td width="40" height="10" valign="middle"></td>
							<td height="10" align="center"></td>
							<td width="40" height="10" align="right"></td>
						</tr>
						<tr>
							<td width="40" valign="middle"></td>
							<td align="center">
								<input name="Submit3" type="submit" class="Estilo3" value="       Calcular mi ahorro       " />
							</td>
							<td width="40" align="right"></td>
						</tr>
						<tr>
							<td width="40" height="10" valign="middle"></td>
							<td height="10" align="center"></td>
							<td width="40" height="10" align="right"></td>
						</tr>
					</table>
				</form>
			</body>
			</html>
			<?php
			exit();
		}
		if (!existe($n, $numeros_moviles_llamantes))
			$numeros_moviles_llamantes[$numeros++] = $n;
	}
	
	if (count($numeros_moviles_llamantes) == 0) {
		insertarErrorProcesoFactura($idMiembro, $destination, "!No hay número de movil llamante");
?>
<table width="490" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10" height="10"><img src="imagenes/tit_calcula.png" width="490"></td>
  </tr>
</table>
<br>
<table width="490" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><p class="texto_normal"><strong>Resultado del cálculo</strong></p></td>
  </tr>
  <tr>
    <td width="40" height="20"></td>
    <td></td>
    <td width="40"></td>
  </tr>
  <tr>
    <td width="40"></td>
    <td><div align="justify"><span class="texto_normal">
		<br>¡Enhorabuena! No podemos garantizarte que tus llamadas sean más baratas con nosotros.<br><br>
		Aun así te invitamos a que descubras nuestras promociones y la telefonía móvil más sencilla y barata haciendo clic <a href=http://www.carrefour.es/movil/servicios/tarjeta-prepago.html target="_parent">aquí</a>.<br>
		<br>
	</span></div></td>
    <td width="40"></td>
  </tr>
</table>
<br>
<form action="http://www.ahorramovil.com/carrefour/ProcesarEnvioFacturaCarrefour.php" method="post" enctype="multipart/form-data" name="Formulario" target="_self" id="Formulario" onSubmit="return ValidaDatos()">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
  <table width="490" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="facturas">
    <tr>
      <td height="10" colspan="3" valign="middle" class="texto_normal"><strong>Env&iacute;a m&aacute;s facturas</strong></td>
    </tr>
    <tr>
      <td width="40" height="10" valign="middle"></td>
      <td height="10" align="center"></td>
      <td width="40" height="10"></td>
    </tr>
    <tr>
      <td width="40" valign="middle"></td>
      <td align="center"><input name="Factura" type="file" class="Estilo3" size="50" /></td>
      <td width="40"></td>
    </tr>
    <tr>
      <td width="40" height="10" valign="middle"></td>
      <td height="10" align="center"></td>
      <td width="40" height="10" align="right"></td>
    </tr>
    <tr>
      <td width="40" valign="middle"></td>
      <td align="center"><input name="Submit3" type="submit" class="Estilo3" value="       Calcular mi ahorro       " /></td>
      <td width="40" align="right"></td>
    </tr>
    <tr>
      <td width="40" height="10" valign="middle"></td>
      <td height="10" align="center"></td>
      <td width="40" height="10" align="right"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
		exit();
	}
	
	$numero_movil_llamante = $numeros_moviles_llamantes[0];

	$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);

	// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
	$costes = obtenerCostesFacturas($facturas, 51, true);
	$costes = obtenerCostesFacturas($facturas, 68, true);
?>
<table width="490" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10" height="10"><img src="imagenes/tit_calcula.png" width="490"></td>
  </tr>
</table>
<br>
<table width="490" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><p class="texto_normal"><strong>Resultado del cálculo</strong></p></td>
  </tr>
  <tr>
    <td width="40" height="20"></td>
    <td></td>
    <td width="40"></td>
  </tr>
  <tr>
    <td width="40"></td>
    <td><div align="justify"><span class="texto_normal">
    <?php
	// --------------------------
	// Presentación de resultados
	// --------------------------
	$resultados = crearTablaResultadosBasicosRestringidaCarrefour($idMiembro, $numero_movil_llamante);
	?>
	</span></div></td>
    <td width="40"></td>
  </tr>
</table>
<br>
<form action="http://www.ahorramovil.com/carrefour/ProcesarEnvioFacturaCarrefour.php" method="post" enctype="multipart/form-data" name="Formulario" target="_self" id="Formulario" onSubmit="return ValidaDatos()">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
  <table width="490" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="facturas">
    <tr>
      <td height="10" colspan="3" valign="middle" class="texto_normal"><strong>Env&iacute;a m&aacute;s facturas</strong></td>
    </tr>
    <tr>
      <td width="40" height="10" valign="middle"></td>
      <td height="10" align="center"></td>
      <td width="40" height="10"></td>
    </tr>
    <tr>
      <td width="40" valign="middle"></td>
      <td align="center"><input name="Factura" type="file" class="Estilo3" size="50" /></td>
      <td width="40"></td>
    </tr>
    <tr>
      <td width="40" height="10" valign="middle"></td>
      <td height="10" align="center"></td>
      <td width="40" height="10" align="right"></td>
    </tr>
    <tr>
      <td width="40" valign="middle"></td>
      <td align="center"><input name="Submit3" type="submit" class="Estilo3" value="       Calcular mi ahorro       " /></td>
      <td width="40" align="right"></td>
    </tr>
    <tr>
      <td width="40" height="10" valign="middle"></td>
      <td height="10" align="center"></td>
      <td width="40" height="10" align="right"></td>
    </tr>
  </table>
</form>
</body>
</html>