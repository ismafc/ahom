<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	include("../Lib/library.inc");
	include ("../Lib/tarifas.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
	$idContrato = isset ($_GET["idContrato"]) ? $_GET["idContrato"] : "";
	$idOperador = "";
	if (isset ($_GET["idOperador"]))
		$idOperador = $_GET["idOperador"];
	else{
		echo "No se ha definido el identificador de la operadora (idOperadora)";
		exit();
	}
?>
<link rel="stylesheet" href="../ahorramovil.css" type="text/css" />

<script type="text/JavaScript">
function ValidateLoginForm() {
	if (document.LoginForm.Usuario.value == "") {
		alert("Introduce un nombre de Usuario (Nick)... el campo está vacío");
		document.LoginForm.Usuario.focus();
		return false;	
	}
	if (document.LoginForm.Usuario.value.length < 4) {
		alert("El nombre de Usuario (Nick) debe tener almenos cuatro carácteres");
		document.LoginForm.Usuario.focus();
		return false;
	}
	if (document.LoginForm.Password.value == "") {
		alert("Introduce una contraseña... el campo está vacío");
		document.LoginForm.Password.focus();
		return false;	
	}
	if (document.LoginForm.Password.value.length < 4) {
		alert("La contraseña debe tener almenos cuatro carácteres");
		document.LoginForm.Password.focus();
		return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
.Estilo5 {font-size: 14}
.Estilo6 {font-size: 10px}
-->
</style>
</head>

<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	  <table border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td height="117" valign="top"><img src="../imagenesmastreces/encabezado/home1.gif" width="303" height="117" /><img src="../imagenesmastreces/encabezado/bunneranimat.gif" width="475" height="117" /></td>
    </tr>
	<tr>
      <td><img src="../imagenesmastreces/encabezado/home3.gif" usemap="#Map" href="../queOfrecemos.php"></a></td>
	  </tr>
	  </table>
  </div>
	
	 
  

  <div id="login">

<form action="../zonaUsuario.php" method="post" name="LoginForm" id="LoginForm" target="_self" onsubmit="return ValidateLoginForm();">

<table width="152" border="0" cellspacing="0" cellpadding="0">

 <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td height="15" valign="top">Usuario</td>
  </tr>
  <tr>
    <td><input name="Usuario" type="text" id="Usuario" /></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td height="15" valign="top">Password</td>
  </tr>
  <tr>
    <td><input name="Password" type="password" id="Password" /></td>
  </tr>
   <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td><input name="Entrar" type="submit"  id="Entrar" value="" />
	</td>
  </tr>
  <tr>
    <td height="25"></td>
  </tr>
  
</table>
</form>

<table width="152" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    	<?php
			if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
		?>
		    	&iquest;No eres usuario? Date de alta <a href="../alta.php">aqu&iacute;</a>.
        <?php
			}
			else {
				$nombreusu = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
				if (isset($nombreusu))
					echo $nombreusu . ", ";				
		?>ya puedes ir a tu <a href="../zonaUsuario.php">Zona de Usuario</a>
        <?php
			}
		?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><span>Actualizadas las tarifas a 31 de octubre de 2007!</span><br/>
Nuevos contratos y servicios de ahorro de Orange, nuevos costes de Movistar, etc... </p></td>
  </tr>
</table>




	

 

</div>
<div id="areaTexto">
<div id="contenido">
<table width="418" border="0" cellspacing="0" cellpadding="0">
    <tr>
	    <td colspan="3" height="6"></td>
	</tr>
	<tr>
	  	<td width="2"></td>
	    <td width="414"><img src="cargarImagenDB.php?type=CABECERA&idOperador=<?php echo $idOperador;?>" /></td>
	  	<td width="2"></td>
	</tr>
	<tr>
	    <td colspan="3" height="6"></td>
	</tr>
    <tr>
    	<td width="2"></td>
        <td width="414" align="center"><strong>Contrato Vitamina Cl&aacute;sica</strong></td>
    	<td width="2"></td>
	<tr>
	    <td colspan="3" height="6"></td>
	</tr>
</table>

<table width="418" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" height="6"></td>
    </tr>
  	
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tabla2a.gif" alt="" /></td>
    	<td width="9"></td>
    </tr>
    <tr>
    	<td width="9"></td>
        <td width="400" style="background-color:#D7E9F5">
        	<table width="400" border="0" cellpadding="0" cellspacing="0">
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Cuota de alta:</strong></td>
                    <td width="190" align="right">21 €</td>
                	<td width="10"></td>	
                </tr>
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Cuota mensual:</strong></td>
                    <td width="190" align="right">0 €</td>
                	<td width="10"></td>	
                </tr>
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Consumo mínimo mensual:</strong></td>
                    <td width="190" align="right">9 €</td>
                	<td width="10"></td>	
                </tr>
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Establecimiento de llamada:</strong></td>
                    <td width="190" align="right">0,12 €</td>
                	<td width="10"></td>	
                </tr>
             </table>
        </td>
    	<td width="9"></td>
  	</tr>
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tabla2b.gif" alt="" /></td>
    	<td width="9"></td>
    </tr>
   	<tr>
		<td colspan="3" height="6"></td>
    </tr>
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tablaVoz.gif" alt="" /></td>
    	<td width="9"></td>
    <tr>
    	<td width="9">
        <td width="400" style="background-color:#D7E9F5">
        	<table width="400" border="0" cellpadding="0" cellspacing="0">
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Fijos y móviles:</strong></td>
                    <td width="190" align="right">0,18 €/mín</td>
                	<td width="10"></td>	
                </tr>
            </table>
        </td>     
    	<td width="9"></td>
  	</tr>
    <tr>
    	<td width="9"></td>
        <td width="400"><img src="./imagenes/tabla2b.gif" alt="" /></td>
	   	<td width="9"></td>
    </tr>
   	<tr>
		<td colspan="3" height="6"></td>
    </tr>
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tablaVideollamada.gif" alt="" /></td>
    	<td width="9"></td>
    </tr>
    <tr>
    	<td width="9"></td>
        <td width="400" style="background-color:#D7E9F5">
        	<table width="400" border="0" cellpadding="0" cellspacing="0">
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Cualquier destino:</strong></td>
                    <td width="190" align="right">0,50 €/mín</td>
                	<td width="10"></td>	
                </tr>
             </table>
        </td>     
    	<td width="9"></td>
  	</tr>
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tabla2b.gif" alt="" /></td>
    	<td width="9"></td>
    </tr>
   	<tr>
		<td colspan="3" height="6"></td>
    </tr>
      	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tablaSMS.gif" alt="" /></td>
    	<td width="9"></td>
    </tr>
    	<td width="9">
        <td width="400" style="background-color:#D7E9F5">
        	<table width="400" border="0" cellpadding="0" cellspacing="0">
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Nacional:</strong></td>
                    <td width="190" align="right">0,15 €</td>
                	<td width="10"></td>	
                </tr>
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Internacional:</strong></td>
                  	<td width="190" align="right">0,60 €</td>
                	<td width="10"></td>	
                </tr>
             </table>
    	</td>
        <td width="9"></td>
  	</tr>
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tabla2b.gif" alt="" /></td>
    	<td width="9"></td> 
    </tr>
   	<tr>
		<td colspan="3" height="6"></td>
    </tr>
      	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tablaMMS.gif" alt="" /></td>
    	<td width="9"></td>
    </tr>
    	<td width="9">
        <td width="400" style="background-color:#D7E9F5">
        	<table width="400" border="0" cellpadding="0" cellspacing="0">
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Nacional:</strong></td>
                  	<td width="190" align="right">0,30 €</td>
                	<td width="10"></td>	
                </tr>
				<tr height="20">
                	<td width="10"></td>	
				    <td width="190" align="left"><strong>Internacional:</strong></td>
                    <td width="190" align="right">1,80 €</td>
                	<td width="10"></td>	
                </tr>
             </table>
    	</td>
        <td width="9"></td>
  	</tr>
    <tr>
    	<td width="9"></td>
    	<td width="400"><img src="./imagenes/tabla2b.gif" alt="" /></td>
    	<td width="9"></td> 
    </tr>
<?php
	crearTablaServiciosAhorroEnContrato ($idContrato);
?>     
</table>

<table width="418" border="0" cellspacing="0" cellpadding="0" class="Estilo6">
	<tr>
  		<td height="6"></td>
  	</tr>
    <tr>
    	<td width="5"></td>
   		<td width="408" align="right">Impuestos indirectos no incluidos</td>
    	<td width="5"></td>
    </tr>
</table> 

<table width="418" border="0" cellspacing="0" cellpadding="0">
	<tr>
  		<td height="6"></td>
  	</tr>
  	<tr>
    	<td width="5"></td>
    	<td align="left" width="204">
   	    <?php
			crearEnlaceTarifaContratoOperador ($idContrato);
		?> 
        </td>
  		 <td align="right" width="204"><a href="javascript:history.back()">Atrás...</a></td>
    	<td width="5"></td>
    </tr>
</table> 
   
	
	
	</div>
	
	
	<div id="estadisticas">
	<table width="204" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="18"><img src="../imagenesmastreces/navegaciond/bola.gif" alt="" /></td>
    <td height="18"><a href="../faqs.php">Preguntas frecuentes</a></td>
  </tr>
  <tr>
    <td height="18"><img src="../imagenesmastreces/navegaciond/bola.gif" alt="" /></td>
    <td height="18"><a href="../queOfrecemos.php">Que ofrecemos</a> </td>
  </tr>
  <tr>
    <td height="18"><img src="../imagenesmastreces/navegaciond/bola.gif" alt="" /></td>
    <td height="18"><a href="../informeReal.html" target="_blank">Ejemplo de informe real</a></td>
  </tr>
  <tr>
    <td height="18"><img src="../imagenesmastreces/navegaciond/bola.gif" alt="" /></td>
    <td height="18"><a href="../comoEnviarFactura.php">Cómo enviar una factura</a></td>
  </tr>
  <tr>
    <td height="18"><img src="../imagenesmastreces/navegaciond/bola.gif" alt="" /></td>
    <td height="18"><a href="index.php">Tarifas</a></td>
  </tr>
  <tr>
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table width="204" border="0" align="center" cellpadding="0" cellspacing="0" class="Estilo4">
  <tr>
    <td colspan="5"><img src="../imagenesmastreces/navegaciond/tabla1a.gif" alt="" /></td>
  </tr>
  <tr height="20">
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="3"></td>
    <td style="background-color:#D7E9F5" width="140">Usuarios registrados:</td>
    <td style="background-color:#D7E9F5" width="53"><strong><?php echo obtenerNumeroDeClientes(); ?></strong></td>
    <td width="5"></td>
  </tr>
  <tr height="20">
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="3"></td>
    <td style="background-color:#D7E9F5" width="140">Número de facturas:</td>
    <td style="background-color:#D7E9F5" width="53"><strong><?php echo obtenerNumeroDeFacturas(); ?></strong></td>
    <td width="5"></td>
  </tr>
  <tr height="20">
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="3"></td>
    <td style="background-color:#D7E9F5" width="140">Ahorro medio:</td>
    <td style="background-color:#D7E9F5" width="53"><strong><?php echo obtenerAhorroMedioEnPorcentaje(); ?> %</strong></td>
    <td width="5"></td>
  </tr>
  <tr height="20">
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="3"></td>
    <td style="background-color:#D7E9F5" width="140">Ahorro total:</td>
    <td style="background-color:#D7E9F5" width="53"><strong><?php echo obtenerAhorroTotal(); ?> €</strong></td>
    <td width="5"></td>
  </tr>
  <tr height="20">
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="3"></td>
    <td style="background-color:#D7E9F5" width="140">Ahorro anual estimado:</td>
    <td style="background-color:#D7E9F5" width="53"><strong><?php echo obtenerAhorroAnualEstimado(); ?> €</strong></td>
    <td width="5"></td>
  </tr>
  <tr height="30">
    <td width="3"></td>
    <td colspan="3" style="background-color:#D7E9F5"><div align="right"><a href="../masEstadisticas.php" style="color:#0071BC">Más estadísticas...&nbsp;&nbsp;</a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td colspan="5"><img src="../imagenesmastreces/navegaciond/tabla1b.gif" alt="" /></td>
  </tr>
</table>
<table width="204" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" height="6"></td>
    </tr>
  <tr>
    <td colspan="3"><img src="../imagenesmastreces/navegaciond/tabla2a.gif" alt="" /></td>
    </tr>
  <tr>
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="196"><div align="center"><a href="http://www.movistar.es" target="_blank"><span>Movistar</span></a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="196"><div align="center"><a href="http://www.vodafone.es" target="_blank"><span>Vodafone</span></a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="196"><div align="center"><a href="http://www.orange.es" target="_blank"><span>Orange</span></a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="196"><div align="center"><a href="http://www.yoigo.es" target="_blank"><span>Yoigo</span></a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="196"><div align="center"><a href="http://www.carrefour.es/movil" target="_blank"><span>Carrefour</span></a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td width="3"></td>
    <td style="background-color:#D7E9F5" width="196"><div align="center"><a href="http://www.happymovil.es" target="_blank"><span>Happy Movil</span></a></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="../imagenesmastreces/navegaciond/tabla1b.gif" alt="" /></td>
    </tr>
</table>

	</div>
	
			
</div>

<div id="pie">
		<table border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td ><img src="../imagenesmastreces/pie/pie.gif" usemap="#Map2"/></td>
    </tr>
   	  </table>
</div>
</div>

<map name="Map" id="Map">
  <area shape="rect" coords="470,12,517,24" href="../index.php" alt="" />
<area shape="rect" coords="518,12,621,25" href="../legal.php" alt="" />
<area shape="rect" coords="620,12,692,24" href="../queOfrecemos.php" alt="" />
<area shape="rect" coords="692,12,776,25" href="../contacto.php" alt="" />
</map>
<map name="Map2" id="Map2">
<area shape="rect" coords="42,7,92,24" href="../index.php" alt="" />
<area shape="rect" coords="106,7,213,23" href="../legal.php" alt="" />
<area shape="rect" coords="226,7,300,24" href="../queOfrecemos.php" alt="" />
<area shape="rect" coords="310,7,403,24" href="../masEstadisticas.php" alt="" />
<area shape="rect" coords="415,8,470,24" href="../faqs.php" alt="" />
<area shape="rect" coords="480,9,579,24" href="../zonaUsuario.php" alt="" />
<area shape="rect" coords="587,9,652,24" href="../popup.html" target="_blank" alt="" />
<area shape="rect" coords="659,10,743,24" href="../contacto.php" alt="" />
<area shape="rect" coords="44,28,173,44" href="../privacidad.php" alt="" />
<area shape="rect" coords="618,30,742,44" href="../legal.php" alt="" />
</map>
</body>

</html>
