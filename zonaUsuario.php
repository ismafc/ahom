<?php session_start();
	include("./Lib/main.inc");
	include("./Lib/base.inc");
	include("./Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
	
	$trylog = true;
	$loggedin = true;
	$idMiembro = "";
	unset($nombreUsuario);
	if (isset($_POST["Usuario"]) && isset($_POST["Password"])) {
		if (login($_POST["Usuario"], $_POST["Password"]) == true) {
			$nombreUsuario = obtenerNombreUsuario($_POST["Usuario"], $_POST["Password"]);
			$_SESSION['miembro'] = $_POST["Usuario"];
			$_SESSION['password'] = $_POST["Password"];
			$idMiembro = $_SESSION['miembro'];
		}
		else
			$loggedin = false;			
	}
	else {
		$trylog = false;
		if (!esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
			$nombreUsuario = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
			$idMiembro = $_SESSION['miembro'];
		}
		else
			$loggedin = false;
	}
	unset($_POST["Usuario"], $_POST["Password"]);
	//echo $idMiembro . "<br/>";
	
	$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = (SELECT id FROM miembros WHERE Login = '$idMiembro') GROUP BY numero_movil_llamante";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numeros_moviles_llamantes = array();
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$row_array = mysql_fetch_row($result);
		$numeros_moviles_llamantes[$i] = $row_array[0];
	}
	$sql = "SELECT numero_movil_llamante FROM facturas WHERE idMiembro = (SELECT id FROM miembros WHERE Login = '$idMiembro')";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	$numeroFacturas = mysql_num_rows($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>
<link rel="stylesheet" href="zonaUsuario.css" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
<script type="text/JavaScript">
function CallEliminarFacturas() { //v2.0
  var form = document.getElementById("EliminarFacturas");
  form.submit();
  return true;
}
function CallVerInforme() {
  var form = document.getElementById("VerInforme");
  form.submit();
  return true;
}
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
</head>
<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/EncabezadoUsuario/encabezadoUsuario.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
	  </tr>
      </table>
  </div>
	
	<div id="encabezado2">
	
  </div>
	 
  

  <div id="login">
<?php
	if ($loggedin == false) {
?>
<form action="zonaUsuario.php" method="post" name="LoginForm" id="LoginForm" target="_self" onsubmit="return ValidateLoginForm();">
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
<?php
}
else {
?>
<table width="152" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="10" height="10"></td>
    <td width="24" height="10"></td>
    <td width="5" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10" height="30"></td>
    <td height="30" colspan="3" valign="middle">
      <div align="center" class="Estilo4">
        <?php
		if (count($numeros_moviles_llamantes) == 0)
			echo "No tienes ningún teléfono analizado";
		else if (count($numeros_moviles_llamantes) == 1)
			echo "Tienes 1 teléfono analizado";
		else
			echo "Tienes " . count($numeros_moviles_llamantes) . " teléfonos analizados";
		?>    
      </div>    </td>
    <td width="10" height="30"></td>
  </tr>
  <tr>
    <td width="10" height="10"></td>
    <td width="24" height="10"></td>
    <td width="5" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10" height="30"></td>
    <td height="30" colspan="3" valign="middle">
      <div align="center" class="Estilo4">
        <?php
		if ($numeroFacturas == 0)
			echo "No tienes facturas";
		else if ($numeroFacturas == 1)
			echo "Tienes 1 factura";
		else
			echo "Tienes " . $numeroFacturas . " facturas";
		?>    
      </div>    </td>
    <td width="10" height="30"></td>
  </tr>
  <tr>
    <td width="10" height="15"></td>
    <td width="24" height="15"></td>
    <td width="5" height="15"></td>
    <td height="15"></td>
    <td width="10" height="15"></td>
  </tr>
  <tr>
    <td width="10" height="24"></td>
    <td height="24" colspan="3"><a href="logout.php"><img src="imagenesmastreces/navegacioni/logout.gif" alt="" border="0" style="cursor:pointer" /></a></td>
    <td width="10" height="24"></td>
  </tr>
  <tr>
    <td width="10" height="25"></td>
    <td height="25" colspan="3"><div align="center"><a href="logout.php">Salir</a></div></td>
    <td width="10" height="25"></td>
  </tr>  
  <tr>
    <td width="10" height="15"></td>
    <td width="24" height="15"></td>
    <td width="5" height="15"></td>
    <td height="15"></td>
    <td width="10" height="15"></td>
  </tr>
  <tr>
    <td colspan="5"><p><span>&iexcl;Actualizamos las tarifas constantemente!</span><br/>
Nuevos contratos, nuevos operadores, etc...<br/>
    </p>
      &iexcl;Consulta nuestros <a href="queOfrecemos.php">servicios</a>!<br/><br/>
      &iexcl;Consulta nuestra nueva sección de <a href="noticias.php">noticias</a>!
    </td>
  </tr>
</table>
<?php
}
?>
  </div>



  <div id="areaTexto">



	<div id="contenido">
	<table width="419" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    	<td height="22" colspan="2"></td>
	    </tr>
	  <tr>
    	<td width="60" height="18" valign="top"></td>
	    <td height="18" valign="top">
        <?php
			if ($loggedin == false) {
				if ($trylog == true)
	        		echo "<strong>Lo siento, el usuario y el password son incorrectos</strong>";
				else
	        		echo "<strong>No est&aacute;s identificado como usuario</strong>";
			}
			else if (!isset($nombreUsuario)) {
        		echo "<strong>En primer lugar, modifica tus datos personales</strong>";
			}
			else {
        		echo "<strong>Bienvenido a tu zona de usuario, " . $nombreUsuario . "</strong>";
			}
		?>        
        </td>
	  </tr>
	</table>
	<table width="419" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td height="26"></td>
	  </tr>
	  <tr>
	    <td height="45">
        	<?php
			if ($loggedin == true) {
			?>
        	<a href="enviarFactura.php">
            	<img src="imagenesmastreces/contenido/zonaUsuarioBotonEnviar.gif" alt="" />            
            </a>
            <?php
			}
			?>
        </td>
	  </tr>
	</table>
    <?php
	if (count($numeros_moviles_llamantes) == 0 && $loggedin == true) {
	?>
        <table width="419" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="1"></td>
          </tr>
          <tr>
          <td height="50" valign="middle">
           	<div align="center"><strong>Aun no has enviado facturas de ning&uacute;n tel&eacute;fono</strong></div>
          </td>
          </tr>
        </table>
        <table width="419" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="1"></td>
            </tr>
            <tr>
                <td height="41" valign="middle">
		           	<div align="center">&iexcl;Puedes enviar facturas de tantos tel&eacute;fonos como quieras!</div>                </td>
            </tr>
        </table>
        <table width="419" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="4"></td>
            </tr>
            <tr>
                <td height="30">
                	<div align="center">Empieza a ahorrar ya porque...</div>                
                </td>
            </tr>
            <tr>
                <td height="30">
                	<div align="center">Es gratis</div>                
                </td>
            </tr>
            <tr>
                <td height="30">
                	<div align="center">Es sencillo</div>            	
                </td>
            </tr>
            <tr>
                <td height="30">
                	<div align="center">Es seguro</div>                
                </td>
            </tr>
        </table>
    <?php
	}
	else if ($loggedin == true) {
	?>
	<table width="419" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td height="1" colspan="2"></td>
	    </tr>
	  <tr>
	    <td height="50" width="230">
			<img src="imagenesmastreces/contenido/zonaUsuarioBotonEliminarFacturas.gif" alt="" style="cursor:pointer;" onclick="CallEliminarFacturas()" />
		</td>
		<td height="50">
			<form name="EliminarFacturas" id="EliminarFacturas" method="post" action="zonaUsuarioEliminarFacturas.php" target="_self">
              <select name="telefono" id="telefono" style="width:180px">
						<?php
							foreach ($numeros_moviles_llamantes as $telefono) {
								echo "<option value=\"" . $telefono . "\">" . $telefono . "</option>";
							}
						?>
              </select>            
            </form>
        </td>
	  </tr>
    </table>
	<form name="VerInforme" id="VerInforme" method="post" action="VerResultados.php" target="_self">
    <table width="419" border="0" cellspacing="0" cellpadding="0">
        <tr>
	        <td height="1" colspan="2"></td>
        </tr>
        <tr>
            <td height="41" width="270">
                <img src="imagenesmastreces/contenido/zonaUsuarioBotonVerInformes.gif" alt="" style="cursor:pointer;" onclick="CallVerInforme()" />        	
            </td>
            <td height="41" width="140">
                <select name="telefono" id="telefono" style="width:130px">
                    <?php
					foreach ($numeros_moviles_llamantes as $telefono) {
						echo "<option value=\"" . $telefono . "\">" . $telefono . "</option>";
					}
                    ?>
                </select>
            </td>
        </tr>
    </table>
	<table width="419" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="4" colspan="3"></td>
        </tr>
		<tr>
            <td height="30" width="307">
            	<div align="right">Ver resumen de tel&eacute;fono</div>
            </td>
            <td height="30" width="5"></td>
            <td height="30" width="107">
            	<input name="resumentelefonos" type="checkbox" id="resumentelefonos" value="1" />
            </td>
		</tr>
		<tr>
            <td height="30" width="307">
            	<div align="right">Ver tabla de contratos</div>
            </td>
            <td height="30" width="5"></td>
            <td height="30" width="107">
            	<input name="tablacontratos" type="checkbox" id="tablacontratos" value="1" />
            </td>
		</tr>
		<tr>
            <td height="30" width="307"><div align="right">Ver tabla de servicios de ahorro</div></td>
            <td height="30" width="5"></td>
            <td height="30" width="107">
            	<input name="tablaservicios" type="checkbox" id="tablaservicios" value="1" />
			</td>
		</tr>
<!--        
		<tr>
            <td height="30" width="307"><div align="right">Ver tabla de llamadas simuladas</div></td>
            <td height="30" width="5"></td>
            <td height="30" width="107">
				<input name="llamadassimuladas" type="checkbox" id="llamadassimuladas" value="1" />
            </td>
		</tr>
-->
		<tr height="30"><td colspan="3" width="419"></td></tr>
	</table>
    </form>
    <?php
	}
	else {
	?>
        <table width="419" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="60"></td>
            </tr>
          <tr>
            <td height="50"><div align="center">
            <?php
                if (esProvisional($_SESSION['miembro'], $_SESSION['password'])) {
            ?>
                    &iquest;No eres usuario? Date de alta <a href="alta.php">aqu&iacute;</a>.
            <?php
                }
                else {
                    $nombreusu = obtenerNombreUsuario($_SESSION['miembro'], $_SESSION['password']);
                    if (isset($nombreusu))
                        echo $nombreusu . ", ";				
            ?>ya puedes ir a tu <a href="zonaUsuario.php">Zona de Usuario</a>
            <?php
                }
            ?>
            </div></td>
          </tr>
        </table>
	<?php
	}
	?>
	<table width="419" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td height="18"></td>
		</tr>
		<tr>
			<td height="45">
				<?php
                if ($loggedin == true) {
                ?>            
				<a href="zonaUsuarioMDP.php">
					<img src="imagenesmastreces/contenido/zonaUsuarioBotonMDP.gif" alt="" />            
                </a>        
                <?php
				}
				?>
            </td>
        </tr>
    </table>
</div>
	
    <div id="div_estadisticas">
         <IFRAME id="iframe_estadisticas" frameborder="0" src="barraDerecha.php">No se soportan iframes!</IFRAME>
    </div>
	
			
</div>

<div id="div_pie">
    <IFRAME id="iframe_pie" frameborder="0" src="pie.php">No se soportan iframes!</IFRAME>
</div>
</div>

<map name="Map" id="Map">
  <area shape="rect" coords="472,127,515,142" href="index.php" alt="" />
<area shape="rect" coords="521,128,618,140" href="quienesSomos.php" alt="" />
<area shape="rect" coords="622,128,690,142" href="queOfrecemos.php" alt="" />
<area shape="rect" coords="694,125,770,142" href="contacto.php" alt="" />
</map></body>

</html>
