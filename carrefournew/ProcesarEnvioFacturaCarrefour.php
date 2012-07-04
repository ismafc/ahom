<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es"><head><!--<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">--><title>Calcula tu ahorro &gt; Carrefour Móvil &gt; Carrefour Telecom</title>




<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Author" content="Carrefouronline">
<meta name="Copyright" content="© 2001 - 2006 Carrefouronline, S.L.U.">
<meta name="Description" content="Llamar a fijos y móviles te costará igual. Tarifas competitivas sin consumo mínimo ni cuotas. Contrata tu número o conserva el actual. Recarga tu móvil.">
<meta name="Keywords" content="movil, móvil, celular, telefono, teléfono, telefonía, telefonia,  carrefour, telecomunicaciones, llamar, llamadas, recarga, recargas, tarifa, tarifas, fijo, tarjeta, roaming, SIM, SMS, MMS, portabilidad, contrato, operador, virtual">
<link rel="stylesheet" href="http://www.carrefour.es/movil/css/estilos.css" type="text/css">
<style type="text/css">
<!--
.Estilo3 { font-family: ms sans serif; font-size: 13px; width:500px; }
body { background-color:#dbbfcb; margin:0; padding:0 0 0 5px; }
.creat01 { font-family:tahoma; font-size:15px; color:#5f0F3a; background-color:#dbbfcb; }
.creat01 .peque { font-size:12px; }
.creat01 .peque a { color:#5f0F3a; }
.creat01 .nota { font-size:12px; color:#333333; font-family:ms sans serif; }
.creat01 .nota span { text-align:center; font-size:13px; font-weight:bold; padding:0 0 0 180px; }
.creat01 .nota span a { color:#333333; text-decoration:none; }
.creat01 .nota span a:hover { text-decoration:underline; } 
.creat01 .nota strong { font-size:13px; font-weight:bold; }
#Formulario { margin:0; padding:0; width:595px; height:169px; background-image:url(http://www.carrefour.es/telecom/documentos/v2008/layout/bkg_form_calculaahorro.gif); }
-->
</style>
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
	newWindow = open("http://www.ahorramovil.com/carrefournew/detallesCarrefour.php?Telefono=" + texto, "Detalles", "scrollbars,resizable,width=700,height=500");
}

function ValidaDatos() {
	if (document.Formulario.Factura.value=="" ) {
 		alert("Debes adjuntar un fichero");
	 	return false
 	}
 	else if (document.Formulario.aceptocon.checked==false) { 
		alert("Por favor, lee y acepta las condiciones de este cálculo");
    	return false
	}
	else { document.Formulario.submit(); }
}
//-->
</script>
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
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr><td colspan="3" height="155">
		<div class="creat01">
			<p>¡No se pudo procesar la factura correctamente! El fichero no es una factura de telefonía móvil o ésta no se ajusta a ninguno los formatos reconocidos por el sistema.</p><p>Te invitamos a que descubras nuestras promociones y la telefonía móvil más sencilla y barata haciendo clic <a href=http://www.carrefour.es/telecom/movil/index.html target="_parent" style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);"><strong>aquí</strong></a>.</p>
			<p><strong>Introduce otra factura</strong></p>
 			<p>Introduce una factura de tu operador móvil (en Formato PDF o TXT ) (*) en la aplicación y 
				pulsa en "<strong>Calcular mi ahorro</strong>". </p>
			<p class="peque">(*) Si estás registrado online en las páginas web de Movistar o Vodafone deberás tener tus facturas en formato PDF
				y si eres de Orange, en formato TXT.</p>
		</div>
	</td></tr>
    <tr>
	<td height="10" valign="middle" width="40"></td>
    <td align="center" height="10" width="321"></td>
    <td height="10" width="40"></td>
    </tr>
    <tr><td colspan="3">
		<form action="http://www.ahorramovil.com/carrefournew/ProcesarEnvioFacturaCarrefour.php" method="post" enctype="multipart/form-data" name="Formulario" target="_self" id="Formulario" onSubmit="return ValidaDatos()">
		<input name="Factura" class="Estilo3" size="70" style="margin: 35px 0pt 0pt 25px;" type="file">
		<br><br>
		<input name="aceptocon" style="margin: 0pt 0pt 0pt 25px;" type="checkbox"> <span style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);">He leido y acepto las <a href="javascript:void(null);" onClick="javascript:void(window.open('http://www.carrefour.es/movil/img/popup_condiciones_calculo_cuota.html','icc','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=550,height=550,top=0,left=0'))" style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);"><strong>condiciones de este cálculo</strong></a></span>
		<br><br><input name="Submit3" value="       Calcular mi ahorro       " style="margin: 0pt 0pt 0pt 225px;" type="submit">
		<input name="MAX_FILE_SIZE" value="1000000" type="hidden">
		</form>
	</td></tr>
</tbody></table>
</body></html>
			<?php
			exit();
		}
		if (!existe($n, $numeros_moviles_llamantes))
			$numeros_moviles_llamantes[$numeros++] = $n;
	}
	
	if (count($numeros_moviles_llamantes) == 0) {
		insertarErrorProcesoFactura($idMiembro, $destination, "!No hay número de movil llamante");
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr><td colspan="3" height="155">
		<div class="creat01">
			<p>¡Enhorabuena! No podemos garantizarte que tus llamadas sean más baratas con nosotros.<br><br>
		Aun así te invitamos a que descubras nuestras promociones y la telefonía móvil más sencilla y barata haciendo clic <a href=http://www.carrefour.es/telecom/movil/index.html target="_parent" style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);"><strong>aquí</strong></a></p>
			<p><strong>Introduce otra factura</strong></p>
 			<p>Introduce una factura de tu operador móvil (en Formato PDF o TXT ) (*) en la aplicación y 
				pulsa en "<strong>Calcular mi ahorro</strong>". </p>
			<p class="peque">(*) Si estás registrado online en las páginas web de Movistar o Vodafone deberás tener tus facturas en formato PDF
				y si eres de Orange, en formato TXT.</p>
		</div>
	</td></tr>
    <tr>
	<td height="10" valign="middle" width="40"></td>
    <td align="center" height="10" width="321"></td>
    <td height="10" width="40"></td>
    </tr>
    <tr><td colspan="3">
		<form action="http://www.ahorramovil.com/carrefournew/ProcesarEnvioFacturaCarrefour.php" method="post" enctype="multipart/form-data" name="Formulario" target="_self" id="Formulario" onSubmit="return ValidaDatos()">
		<input name="Factura" class="Estilo3" size="70" style="margin: 35px 0pt 0pt 25px;" type="file">
		<br><br>
		<input name="aceptocon" style="margin: 0pt 0pt 0pt 25px;" type="checkbox"> <span style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);">He leido y acepto las <a href="javascript:void(null);" onClick="javascript:void(window.open('http://www.carrefour.es/movil/img/popup_condiciones_calculo_cuota.html','icc','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=550,height=550,top=0,left=0'))" style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);"><strong>condiciones de este cálculo</strong></a></span>
		<br><br><input name="Submit3" value="       Calcular mi ahorro       " style="margin: 0pt 0pt 0pt 225px;" type="submit">
		<input name="MAX_FILE_SIZE" value="1000000" type="hidden">
		</form>
	</td></tr>
</tbody></table>
</body></html>
<?php
		exit();
	}
	
	$numero_movil_llamante = $numeros_moviles_llamantes[0];

	$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);

	// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
	$costes = obtenerCostesFacturas($facturas, 51, true);
	$costes = obtenerCostesFacturas($facturas, 68, true);
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr><td colspan="3">
    <?php
	// --------------------------
	// Presentación de resultados
	// --------------------------
	$resultados = crearTablaResultadosBasicosRestringidaCarrefour($idMiembro, $numero_movil_llamante);
	?>
		</td></tr>
        <tr><td colspan="3">
		<div class="creat01">			
			<p><strong>Introduce otra factura</strong></p>
			<p class="peque">Recuerda que si estás registrado online en las páginas web de Movistar o Vodafone deberás tener tus facturas en formato PDF
				y si eres de Orange, en formato TXT.</p>
		</div>
	</td></tr>
    <tr>
	<td height="10" valign="middle" width="40"></td>
    <td align="center" height="10" width="321"></td>
    <td height="10" width="40"></td>
    </tr>
    <tr><td colspan="3">
		<form action="http://www.ahorramovil.com/carrefournew/ProcesarEnvioFacturaCarrefour.php" method="post" enctype="multipart/form-data" name="Formulario" target="_self" id="Formulario" onSubmit="return ValidaDatos()">
		<input name="Factura" class="Estilo3" size="70" style="margin: 35px 0pt 0pt 25px;" type="file">
		<br><br>
		<input name="aceptocon" style="margin: 0pt 0pt 0pt 25px;" type="checkbox"> <span style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);">He leido y acepto las <a href="javascript:void(null);" onClick="javascript:void(window.open('http://www.carrefour.es/movil/img/popup_condiciones_calculo_cuota.html','icc','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=550,height=550,top=0,left=0'))" style="font-family: ms sans serif; font-size: 13px; color: rgb(51, 51, 51);"><strong>condiciones de este cálculo</strong></a></span>
		<br><br><input name="Submit3" value="       Calcular mi ahorro       " style="margin: 0pt 0pt 0pt 225px;" type="submit">
		<input name="MAX_FILE_SIZE" value="1000000" type="hidden">
		</form>
	</td></tr>
</tbody></table>
</body></html>
