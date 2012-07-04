<?php header('P3P: CP="CAO PSA OUR"'); session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>

<link rel="stylesheet" href="main.css" type="text/css" />

<script language="JavaScript">
<!--
function ValidaDatosFormularioAhorramovil() {
	var formulario = document.getElementById("FormularioEnviarFactura");
	if (formulario.FacturaPdf.value=="" ) {
 		alert("Debes adjuntar un fichero");
	 	return false;
 	}
 	else if (formulario.aceptocheck.checked==false) { 
		alert("Por favor, lee y acepta las condiciones de este cálculo");
    	return false;
	}
	else {
		var framemsg = parent.document.getElementById("fahorramovilmsg");
		var frameaho = parent.document.getElementById("fahorramovil");
		var maintable = parent.document.getElementById("maintableahorramovil");
		maintable.height="53";
		framemsg.style.visibility="visible";
		framemsg.height="53";
		frameaho.style.visibility="hidden";
		frameaho.height="0";
	}
	return true;
}

//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body style="background-color:#FFFFFF">
<div id="ahorramovil">
	<table width="609" border="0" cellpadding="0" cellspacing="0">
		<tr>
            <td width="10"></td>
			<td height="17" valign="center" bgcolor="ECF1F5" class="tablafina_titulo">
            	<div align="center">&iexcl;Encuentra la mejor opción para ti!</div>
            </td>
            <td width="10"></td>
		</tr>
	</table>
	<form action="ProcesarEnvioFactura1.php" method="post" enctype="multipart/form-data" target="fahorramovil" id="FormularioEnviarFactura" name="FormularioEnviarFactura" onSubmit="return ValidaDatosFormularioAhorramovil();">
		<table width="609" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="10" colspan="3"></td>
			</tr>
			<tr>
	            <td width="10"></td>
           	  	<td valign="middle">
               	<p align="center" class="glosario">Ahora <strong>GSMspain</strong> te ofrece un <strong>nuevo servicio gratuito</strong> que te resolver&aacute; de forma definitiva cual es el plan tarifario que m&aacute;s se ajusta a tus necesidades...solo necesitar&aacute;s unos segundos para saber cual es la <strong>opci&oacute;n que te ahorrar&aacute; m&aacute;s dinero</strong>!</p>
	              <p align="center" class="glosario">Solo tienes que adjuntar una factura electr&oacute;nica de tu operador en formato PDF o TXT(*) y pulsar en &quot;Encuentra mi mejor opci&oacute;n&quot;.</p>
	            <p align="center" class="news" style="color:#FF0000">&iexcl;En unos segundos se generar&aacute; un informe con el operador, contrato, servicios de ahorro que te hubieran ahorrado m&aacute;s dinero!</p>
   	          </td>
	            <td width="10"></td>
			</tr>
			<tr>
				<td height="10" colspan="3"></td>
			</tr>
            <tr>
	            <td width="10"></td>
				<td valign="middle">
                	<p class="tablafina_titulo">Env&iacute;a una factura </p>
                </td>
	            <td width="10"></td>
			</tr>
			<tr>                    
	            <td width="10"></td>
	            <td height="50" align="center" valign="middle"><p style="color:#FF0000"><strong>Servicio temporalmente deshabilitado. Disculpad las molestias.</strong></p>
                </td>
	            <td width="10"></td>
			</tr>
<!--
			<tr>                    
	            <td width="10"></td>
	            <td height="30" align="center" valign="middle">
                	<input type="file" id="FacturaPdf" name="FacturaPdf" size="60"/>
                </td>
	            <td width="10"></td>
			</tr>
			<tr>
	            <td width="10"></td>
				<td height="49" align="center" valign="middle">
                	<input name="Submit" type="submit" class="news" id="Submit" value="Encuentra mi mejor opci&oacute;n" />
                </td>
	            <td width="10"></td>
			</tr>
-->
			<tr>
	            <td width="10"></td>
				<td height="20" valign="middle">
					<div align="center" class="verdanapeque">
				  		<input type="checkbox" name="aceptocheck" value="checkbox" id="aceptocheck" />He leído y acepto las <a href="#" class="menu_izq" onClick="window.open('condiciones.html','Condiciones','width=700,height=500,scrollbars=no')">condiciones de este cálculo</a>				  
				  </div>
				</td>
	            <td width="10"></td>
			</tr>
			<tr>
				<td height="10" colspan="3"></td>
			</tr>
			<tr>
	            <td width="10"></td>
				<td height="20" valign="middle">
                	<div align="center" class="verdanapeque">(*) Inf&oacute;rmate <a href="#" class="menu_izq" onClick="window.open('popup.html','','width=700,height=650,scrollbars=no')">aqu&iacute;</a> para saber como descargar facturas de tu operador
                    </div>
				</td>
				<td width="10"></td>
			</tr>
			<tr>
				<td height="10" colspan="3"></td>
			</tr>
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
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		<table width="609" height="50" border="0" cellpadding="0" cellspacing="0">
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
		<table width="609" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="30"></td>
			</tr>
		</table>
	</form>    
</div>
</body>

</html>
