<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<html>
<head>
	<title>Resultados del cálculo</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style3 {color: #000099}
</style>
<script language="JavaScript">
<!--
function OcultarEspera() {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	var frameaho = parent.document.getElementById("fahorramovil");
	var maintable = parent.document.getElementById("maintableahorramovil");
	maintable.height="680";
	framemsg.style.visibility="hidden";
	framemsg.height="0";
	frameaho.style.visibility="visible";
	frameaho.height="680";
	return true;
}

function VisualizarEspera() {
	var framemsg = parent.document.getElementById("fahorramovilmsg");
	var frameaho = parent.document.getElementById("fahorramovil");
	var maintable = parent.document.getElementById("maintableahorramovil");
	maintable.height="53";
	framemsg.style.visibility="visible";
	framemsg.height="53";
	frameaho.style.visibility="hidden";
	frameaho.height="0";
	return true;
}
//-->
</script>
</head>

<body style="background-color:#FFFFFF" onLoad="OcultarEspera();">
<div align="center">
	<table width="589" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="10" colspan="3"></td>
			</tr>
		<tr>
            <td width="10"></td>
			<td height="17" valign="center" bgcolor="ECF1F5" class="tablafina_titulo">
            	<div align="center" class="categoryItemListTitleResult">&iexcl;Encuentra la mejor opción para ti!</div>
          </td>
            <td width="10"></td>
		</tr>
		<tr>
            <td height="10" width="10"></td>
			<td height="10"></td>
            <td height="10" width="10"></td>
		</tr>
	</table>
  
<?php	
	include("./../Lib/library.inc");
	include("./../Lib/main.inc");
	include("./../Lib/facturas.inc");
	include("./../Lib/base.inc");
	if (openDatabase() == false)
		exit();

	// 	Provisionalmente
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisionalFrom($_SESSION['miembro'], $_SESSION['password'], "THEPHONEHOUSE");
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

	//echo $login . "<br/>";
	//echo $password . "<br/>";
	//echo $idMiembro . "<br/>";
	//echo $nFacturas . "<br/>";
	$idFactura = 0;
	$edad_titular = 0;
	$idParentesco = 3;
	$descripcion = "";
	$numeros_moviles_llamantes = array();
	$numeros = 0;

	// 	No permitimos enviar más de una factura a un usuario provisional
	$sql = "SELECT Estado FROM miembros WHERE id = '$idMiembro'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$row_array = mysql_fetch_row($result);
	if ($row_array[0] == "PROVISIONAL") {
		$sql = "SELECT id FROM facturas WHERE idMiembro = '$idMiembro'";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}
		if (mysql_num_rows($result) > 0) {
			?>
			<table width="589" border="0" cellspacing="0" cellpadding="10">
				<tr>
					<td height="15" valign="middle">
						<div align="center" class="verdanapeque">El proceso no se puede completar si no sigue los pasos establecidos en el <a href="http://www.phonehouse.es/calculate_tph.aspx" target="_top" class="menu_izq">formulario incial</a>						</div>
				  </td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
			</table>
	  		<table width="589" border="0" cellpadding="0" cellspacing="0">
				<tr>
		            <td height="20" colspan="3" valign="middle">
	                	<div align="center" class="news">Servicio proporcionado por <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">www.ahorramovil.com</a>                    
	                    </div>
					</td>
				</tr>
				<tr>
					<td height="10" colspan="3"></td>
				</tr>
			</table>

			<table width="589" height="50" border="0" cellpadding="0" cellspacing="0">
				<tr>
		            <td width="10"></td>
					<td>
						<div align="center">
							<a href="http://www.ahorramovil.com" target="_blank">
								<img src="imagenes/logoInforme.gif" alt="" border="0" class="f1w" />							</a>						</div>
				  </td>
					<td width="10"></td>
				</tr>
			</table>
            <?php
			echo "</div></body></html>";
			exit();
		}
	}
	
	$error = false;
	if ($_FILES["FacturaPdf"]["name"] != false) {
		$destination = "./data/".$_FILES["FacturaPdf"]["name"].".".$idMiembro;
		$temp_file = $_FILES["FacturaPdf"]["tmp_name"];
		move_uploaded_file($temp_file, $destination);
	
		$content = "";
		$size = filesize($destination);
		if  ($size > 0) {
			$fp = fopen($destination, "r");
			$content = fread($fp, $size);
			fclose($fp);
		}
		
		$n = procesarFactura($content, $idMiembro, $edad_titular, $idParentesco, $descripcion, $idFactura);
		if ($n == "ALREADY_EXISTS") {
		?>
            <table width="589" border="0" cellspacing="0" cellpadding="10">
                <tr>
                    <td height="15" valign="middle">
                        <div align="center" class="verdanapeque">Esta factura ya ha sido anteriormente enviada a <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">Ahorramovil</a>                        </div>
                  </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
            </table>
            <table width="589" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="20" colspan="3" valign="middle">
                        <div align="center" class="news">Servicio proporcionado por <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">www.ahorramovil.com</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="10" colspan="3"></td>
                </tr>
            </table>
    
            <table width="589" height="50" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10"></td>
                    <td>
                        <div align="center">
                            <a href="http://www.ahorramovil.com" target="_blank">
                                <img src="imagenes/logoInforme.gif" alt="" border="0" class="f1w" />                        </a>                    </div>
                  </td>
                    <td width="10"></td>
                </tr>
            </table>
            <table width="589" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="15" valign="middle">
                        <div align="center" class="verdanapeque">
                            <a href="http://www.phonehouse.es/calculate_tph.aspx" target="_top" class="menu_izq">Vorver al formulario inicial</a>                    </div>
                  </td>
                </tr>
                <tr>
                    <td height="30"></td>
                </tr>
            </table>
            <?php
            echo "</div></body></html>";
            exit();
		}
		if ($n[0] == '!') {
			insertarErrorProcesoFactura($idMiembro, $destination, $n);
			$error = true;
		}
		else {
			if (!existe($n, $numeros_moviles_llamantes))
				$numeros_moviles_llamantes[$numeros++] = $n;
		}
	}
	if ($error == true || count($numeros_moviles_llamantes) == 0) {
	?>
        <table width="589" border="0" cellspacing="0" cellpadding="10">
            <tr>
                <td height="15" valign="middle">
                    <div align="center" class="verdanapeque"><strong>El fichero enviado no es una factura v&aacute;lida o tiene un formato no soportado por la aplicaci&oacute;n</strong>
                    </div>
                </td>
            </tr>
			<tr>
				<td height="15" valign="middle">
                	<div align="center" class="verdanapeque">(*) Inf&oacute;rmate <a href="#" class="menu_izq" onClick="window.open('popup.html','','width=700,height=650,scrollbars=no')">aqu&iacute;</a> para saber como descargar facturas de tu operador
                    </div>
				</td>
			</tr>
            <tr>
                <td height="10"></td>
            </tr>
        </table>
        <table width="589" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="20" colspan="3" valign="middle">
                    <div align="center" class="news">Servicio proporcionado por <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">www.ahorramovil.com</a>                    
                    </div>
                </td>
            </tr>
            <tr>
                <td height="10" colspan="3"></td>
            </tr>
        </table>

        <table width="589" height="50" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="10"></td>
                <td>
                    <div align="center">
                        <a href="http://www.ahorramovil.com" target="_blank">
                            <img src="imagenes/logoInforme.gif" alt="" border="0" class="f1w" />                        </a>                    </div>
              </td>
                <td width="10"></td>
            </tr>
        </table>
        <table width="589" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="15" valign="middle">
                    <div align="center" class="verdanapeque">
                        <a href="http://www.phonehouse.es/calculate_tph.aspx" target="_top" class="menu_izq">Vorver al formulario inicial</a>                    </div>
              </td>
            </tr>
            <tr>
                <td height="30"></td>
            </tr>
        </table>
        <?php
        echo "</div></body></html>";
        exit();
	}
	
	$numero_movil_llamante = $numeros_moviles_llamantes[0];
	
	// Miramos la tabla de teléfonos dudosos
	$sql = "SELECT numero_movil, idOperadorPropuesto, idOperadorPosible FROM moviles_dudosos WHERE numero_movil_llamante = '$numero_movil_llamante' AND idMiembro = '$idMiembro'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) > 0) {
		?>
<form name="form1" id="form1" method="post" action="ProcesarEnvioFactura2.php" target="_self" onSubmit="return VisualizarEspera();">
  <table width="589"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3" ><div align="center"><span class="verdanapeque style3">De los siguientes tel&eacute;fonos la factura no informa sobre el operador al que pertenecen. La aplicaci&oacute;n propone el operador en base a la numeraci&oacute;n.</span></div></td>
    </tr>
    <tr>
      <td height="10" colspan="3"></td>
    </tr>
    <tr>
      <td height="30" colspan="3" ><div align="center"><span class="verdanapeque style3">(*) Si no est&aacute;s seguro de que el operador propuesto por la aplicaci&oacute;n es el real, selecciona la opci&oacute;n &quot;no lo s&eacute;&quot; de manera que no se tenga en cuenta en los c&aacute;lculos.</span></div></td>
    </tr>
    <tr>
      <td height="15" colspan="3" ></td>
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
		        echo "<td height=\"25\" ><span class=\"verdanapeque\"><div align=\"right\">" . $movil_actual . "</span></div></td><td height=\"25\" width=\"5\"></td>";
				echo "<td height=\"25\"><div align=\"left\">";
				echo "<input class=\"verdanapeque\" type=\"hidden\" name=\"Telefono" . $ntelefono . "\" value=\"" . $movil_actual . "\">";
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
      <td height="15" ></td>
      <td height="15" ></td>
      <td height="15" ></td>
    </tr>
    <tr>
      <td height="30" ><div align="right">
        <input name="reset" type="reset" class="news" id="reset" value="<< Restablecer" />
      </div></td>
      <td ></td>
      <td height="30">
        <div align="left">
          <input name="Submit2" type="submit" class="news" id="Submit2" value="Continuar >>  " />
        </div></td>
    </tr>
  </table>
  </form>
		<table width="589" border="0" cellpadding="0" cellspacing="0">
			<tr>
	            <td height="20" colspan="3" valign="middle">
                	<div align="center" class="news">Servicio proporcionado por <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">www.ahorramovil.com</a>                    
                    </div>
              </td>
			</tr>
			<tr>
				<td height="10" colspan="3"></td>
			</tr>
		</table>
		<table width="589" height="50" border="0" cellpadding="0" cellspacing="0">
			<tr>
	            <td width="10"></td>
			  <td>
               	  <div align="center">
                   	  <a href="http://www.ahorramovil.com" target="_blank">
                       	  <img src="imagenes/logoInforme.gif" alt="" border="0" class="f1w" />                      </a>                  </div>
              </td>
	            <td width="10"></td>
			</tr>
		</table>
		<table width="589" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="30"></td>
			</tr>
		</table>
<?php
		echo "</div></body></html>";
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
<table width="589" border="2" cellpadding="5" cellspacing="0" bordercolor="#A46200" bgcolor="#FFE4CA">
    <tr>
    <td align="center" >
      <div align="center">
        <?php
	// --------------------------
	// Presentación de resultados
	// --------------------------
	$resultados = crearTablaResultadosBasicos($idMiembro, $numero_movil_llamante);
	?>	
      </div></td>
  </tr>
</table>
<table width="589" border="0" cellspacing="0" cellpadding="10">
    <tr>
        <td height="15" valign="middle">
            <div align="center" class="verdanapeque">(*) Si quieres enviar m&aacute;s facturas entra en <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">Ahorramovil</a> con los siguientes datos:            </div>
      </td>
    </tr>
    <tr>
        <td height="15" valign="middle">
            <div align="center" class="verdanapeque">Usuario: <b><span class="menu_izq"><?php echo $login; ?></span></b>&nbsp;Contrase&ntilde;a: <b><span class="menu_izq"><?php echo $password; ?></span></b>
            </div>
      </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
</table>
<table width="589" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height="20" colspan="3" valign="middle">
            <div align="center" class="news">Servicio proporcionado por <a href="http://www.ahorramovil.com" target="_blank" class="menu_izq">www.ahorramovil.com</a>                    
            </div>
      </td>
    </tr>
    <tr>
        <td height="10" colspan="3"></td>
    </tr>
</table>

<table width="589" height="50" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="10"></td>
      <td>
          <div align="center">
              <a href="http://www.ahorramovil.com" target="_blank">
                  <img src="imagenes/logoInforme.gif" alt="" border="0" class="f1w" />                      </a>                  </div>
      </td>
        <td width="10"></td>
    </tr>
</table>
<table width="589" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="15" valign="middle">
          <div align="center" class="verdanapeque">
           	  <a href="http://www.phonehouse.es/calculate_tph.aspx" target="_top" class="menu_izq">Vorver al formulario inicial</a></div>
      </td>
    </tr>
    <tr>
        <td height="30"></td>
    </tr>
</table>
</div>
</body>
</html>