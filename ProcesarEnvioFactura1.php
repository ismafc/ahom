<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Procesado de facturas</title>
<link rel="stylesheet" href="ProcesarEnvioFactura.css" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
var idMiembro;
var nFacturas;
var pagina_requerida;

function procesarPorcentaje() {
    if (pagina_requerida.readyState == 4) {
        if (pagina_requerida.status == 200) {
			var porcentaje = pagina_requerida.responseText;
            showProgressBar(porcentaje);
	        if (porcentaje != "100") {
	            setTimeout("poll()", 2000);
	        }
        }
    }
}

function llamarasincrono(url)
{
    if (window.XMLHttpRequest) {
        pagina_requerida = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        pagina_requerida = new ActiveXObject("Microsoft.XMLHTTP");
    }
    pagina_requerida.open("GET", url, true);
}

function showProgressBar(porcentaje) {
	var po = window.document.getElementById("Porcentaje");
	po.innerHTML = "<strong>Completado: " + porcentaje + "%</strong>";
}

function poll() {
    var url = "porcentaje.php?idMiembro=" + idMiembro + "&nFacturas=" + nFacturas;
    llamarasincrono(url);
    pagina_requerida.onreadystatechange = procesarPorcentaje;
    pagina_requerida.send(null);
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  idMiembro = args[6];
  nFacturas = args[7];
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
window.scroll(0,0);
  setTimeout("poll()", 1000);
}
//-->
</script>
<style type="text/css">
.Estilo1 {color: #FFFFFF}
</style>
</head>

<body>
<div id="wrapper">
	<div id="encabezado">
	  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="117" valign="top"><img src="imagenesmastreces/encabezadoComoEnviarFacturas/encabezado3.gif"></td>
    </tr>
	  </table>
  </div>
  
<?php
	include("./Lib/library.inc");
	include("./Lib/main.inc");
	include("./Lib/base.inc");
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
	
	$numero_movil_llamante = $_POST["Telefono"];
	
	// Miramos la tabla de teléfonos dudosos
	$sql = "SELECT numero_movil, idOperadorPropuesto, idOperadorPosible FROM moviles_dudosos WHERE numero_movil_llamante = '$numero_movil_llamante' AND idMiembro = '$idMiembro'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) > 0) {
		?>
<form name="form1" id="form1" method="post" action="ProcesarEnvioFactura2.php" target="_self">
  <table width="778"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"><img src="imagenesmastreces/contenido/telefonosDudososa.gif" width="778" height="52"></td>
    </tr>
    <tr>
      <td height="30" colspan="3" style="background-color:#89C540"><span class="Estilo1">De los siguientes tel&eacute;fonos la factura no informa sobre el operador al que pertenecen. Ahorramovil propone el operador en base a la numeraci&oacute;n.</span></td>
    </tr>
    <tr>
      <td height="10" colspan="3" style="background-color:#89C540" >&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="3" style="background-color:#89C540"><span class="Estilo1">(*) Si no est&aacute;s seguro de que el operador propuesto por Ahorramovil es el real, selecciona la opci&oacute;n &quot;no lo s&eacute;&quot; de manera que no se tenga en cuenta en los c&aacute;lculos.</span></td>
    </tr>
    <tr>
      <td height="10" colspan="3" style="background-color:#89C540">&nbsp;</td>
    </tr>
    <tr>
      <td width="288" height="30" style="background-color:#89C540">&nbsp;</td>
      <td width="13" style="background-color:#89C540">&nbsp;</td>
      <td width="289" height="30" style="background-color:#89C540">&nbsp;</td>
    </tr>
	<?php
		echo "<input type=\"hidden\" name=\"Telefono\" value=\"" . $numero_movil_llamante . "\">";
		$movil_actual = "X";
		$ntelefono = 0;
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row_array = mysql_fetch_row($result);
			if ($movil_actual != $row_array[0]) {
				if ($movil_actual != "X") {
					echo "</select></div></td></tr>";
				}
				$movil_actual = $row_array[0];
				echo "<tr>";
		        echo "<td height=\"30\" style=\"background-color:#89C540\"><span class=\"Estilo1\"><div align=\"right\">" . $movil_actual . "</span></div></td><td style=\"background-color:#89C540\"></td>";
				echo "<td height=\"30\" style=\"background-color:#89C540\"><div align=\"left\">";
				echo "<input type=\"hidden\" name=\"Telefono" . $ntelefono . "\" value=\"" . $movil_actual . "\">";
				echo "<select name=\"Operador" . $ntelefono . "\">";
				echo "<option value=\"0\">No lo s&eacute;</option>";
				echo "<option value=\"" . $row_array[2] . "\" " . (($row_array[2] == $row_array[1]) ? "selected" : "") . ">" . obtenerNombreOperador($row_array[2]) . "</option>";
				$ntelefono++;
			}
			else {
				echo "<option value=\"" . $row_array[2] . "\" " . (($row_array[2] == $row_array[1]) ? "selected" : "") . ">" . obtenerNombreOperador($row_array[2]) . "</option>";
			}
		}	
		echo "</select></div></td></tr>";
	?>
<!--
    <tr>
      <td height="30"><div align="right">teléfono</div></td>
      <td></td>
      <td height="30"><div align="left">
		<input type="hidden" name="Telefono1" value="696270875">
        <select name="Operador1">
          <option value="0">No lo s&eacute;</option>
          <option value="3" selected>VODAFONE</option>
          <option value="1">MOVISTAR</option>
        </select>
      </div></td>
    </tr>
-->
    <tr>
      <td height="30" style="background-color:#89C540">&nbsp;</td>
      <td style="background-color:#89C540">&nbsp;</td>
      <td height="30" style="background-color:#89C540">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" style="background-color:#89C540"><div align="right">
        <input type="reset" name="reset" id="reset" value="" />
      </div></td>
      <td style="background-color:#89C540">&nbsp;</td>
      <td height="30" style="background-color:#89C540">
        <div align="left">
          <input name="Submit2" id="Submit2" type="submit"  value="" onClick="MM_showHideLayers('wrapper','','hide','espera','','show',<?php echo $idMiembro . ", " . $nFacturas; ?>)" />
        </div></td>
    </tr>
    <tr>
      <td height="30" colspan="3" ><img src="imagenesmastreces/contenido/telefonosDudososb.gif" width="778" height="52"></td>
      </tr>
  </table>
  </form>	
</div>
<div id="espera">
    <div id="cabecera_espera" align="center">
	<table width="780" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td><div align="center"><img src="imagenesmastreces/encabezadoComoEnviarFacturas/encabezado3.gif" /></div></td>
		</tr>
	</table>
    </div>
    <div id="mensaje_espera" align="center">
	<table width="780" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td><div align="center">El programa está calculando</div></td>
		</tr>
		<tr>
		    <td><div align="center">Esta operación puede tardar algunos segundos. Espere por favor...</div></td>
		</tr>
	</table>
    </div>
    <div id="progreso_espera" align="center">
	<table width="586" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		    <td height="53" width="400">
            	<div id="Porcentaje" align="center"><strong>Completado: 0%</strong></div>            </td>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		</tr>
	</table>
    </div>
</div>
</body>
</html>
<?php
		exit();
	}

	$facturas = obtenerFacturas($idMiembro, $numero_movil_llamante);

	// Calculamos todos los contratos (básicos y detallados) para las facturas del teléfono dado del usuario
	$costes = obtenerCostes($facturas, $numero_movil_llamante);

	// ----------------
	// Servicios Ahorro
	// ----------------

	$idContratos = obtenerContratos();
	foreach($idContratos as $idContrato) {
		$idsCompatibilidades = ObtenerCompatibilidades($idContrato);
		if (empty($idsCompatibilidades) == false) {
			foreach ($idsCompatibilidades as $idCompatibilidad) {
				ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante);
				$idsServiciosAhorro = ObtenerServiciosAhorro($idCompatibilidad, $idContrato);
				GenerarResultadosBasicosServiciosAhorro($facturas, $idContrato, $idCompatibilidad);
				foreach ($idsServiciosAhorro as $idServicioAhorro) {
					$telefonos = ObtenerTelefonos($idServicioAhorro, $idMiembro, $numero_movil_llamante);
					if (count($telefonos) > 0) {
						GenerarResultadosNumerosServiciosAhorro($facturas, $idContrato, $idCompatibilidad, $idServicioAhorro, $telefonos);
						EliminarTelefonosYaSeleccionados($idMiembro, $numero_movil_llamante, $idServicioAhorro, $facturas, $idContrato, $idCompatibilidad);
					}
				}
			}
			ActualizarResumenTelefonos($idMiembro, $numero_movil_llamante);
	
			// Vamos a calcular los costes de los resultados básicos con los servicios de ahorro
			foreach ($facturas as $factura) {
				foreach ($idsCompatibilidades as $idCompatibilidad) {
					AplicarServiciosAhorroALlamadasSeleccionadas($factura, $idContrato, $idCompatibilidad, false, $numero_movil_llamante);
				}
			}
		}	
	}
?>
<form action="VerResultados.php" method="post" name="DatosVerResultados" target="_self" id="DatosVerResultados">
<table width="779" height="60" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"><img src="imagenesmastreces/contenido/informea.gif" width="779" height="52"></td>
  </tr>
  <tr>
    <td align="center" style="background-color:#CEE00A">
    <?php
	// --------------------------
	// Presentación de resultados
	// --------------------------
	$resultados = crearTablaResultadosBasicosRestringida($idMiembro, $numero_movil_llamante);
	?>	</td>
  </tr>
  
<?php
	$estimacionAhorroAnualA = $resultados[0];
	if ($estimacionAhorroAnualA > 1) {
		echo "<input type=\"hidden\" name=\"telefono\" value=\"" . $numero_movil_llamante . "\">";
		echo "<input type=\"hidden\" name=\"resumentelefonos\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"tablacontratos\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"tablaservicios\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"llamadassimuladas\" value=\"0\">";
	?>
		  <tr>
		    <td style="background-color:#CEE00A">&nbsp;</td>
    </tr>
		  <tr>
		    <td style="background-color:#CEE00A">&nbsp;</td>
    </tr>
		  <tr>
		    <td style="background-color:#CEE00A"><div id="botonDetallados" align="center">
		      <input name="Ver" type="submit" id="Ver" value="">
		    </div></td>
		  </tr>
    <?php
	}
	?>
  <tr>
    <td align="center"><img src="imagenesmastreces/contenido/informeb.gif" width="779" height="52"></td>
  </tr>
</table>
</form>
<br/>
<div id="pie">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="50%" class="Estilo42">
    	<?php
			if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
		?>
		    	&iquest;Quieres enviar más facturas? Date de alta <a href="alta.php">aqu&iacute;</a> gratis!.
        <?php
			}
			else {
				$nombreusu = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
				echo $nombreusu;
		?>, ve a tu <a href="zonaUsuario.php">Zona de Usuario</a>
        <?php
			}
		?>
    </td>
	<td width="50%"><div align="center"><span class="Estilo42">Ir al <a href="index.php" target="_self">Inicio</a></span></div></td>
  </tr>
  </table>
  </div>
</div>

<div id="espera">
    <div id="cabecera_espera" align="center">
	<table width="780" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td><div align="center"><img src="imagenesmastreces/encabezadoComoEnviarFacturas/encabezado3.gif" /></div></td>
		</tr>
	</table>
    </div>
    <div id="mensaje_espera" align="center">
	<table width="780" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td><div align="center">El programa está calculando</div></td>
		</tr>
		<tr>
		    <td><div align="center">Esta operación puede tardar algunos segundos. Espere por favor...</div></td>
		</tr>
	</table>
    </div>
    <div id="progreso_espera" align="center">
	<table width="586" border="0" cellspacing="0" cellpadding="0">
		<tr>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		    <td height="53" width="400">
            	<div id="Porcentaje" align="center"><strong>Completado: 0%</strong></div>            </td>
		    <td height="53" width="93"><img src="imagenesmastreces/contenido/rueda1.gif" alt="" /></td>
		</tr>
	</table>
    </div>
</div>
</body>
</html>