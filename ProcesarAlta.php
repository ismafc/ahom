<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefonía móvil. Aplicación web para calcular el mejor operador, contrato y servicio de ahorro</title>

<link rel="stylesheet" href="alta.css" type="text/css" />
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
</head>

<body id="inicio">
<div id="wrapper">
<?php
	include("./Lib/main.inc");
	include("./Lib/base.inc");
	include("./Lib/library.inc");
	if (openDatabase() == false) {
		exit();
	}
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
	?>
	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/EncabezadoUsuario/encabezadoUsuario.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>
      </td>
	  </tr>
      </table>
  </div>	 
  

    <div id="login">
      <form action="zonaUsuario.php" method="post" target="_self" name="LoginForm" id="LoginForm" onsubmit="return ValidateLoginForm();">
        <table width="152" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td height="15" valign="top">Usuario</td>
          </tr>
          <tr>
            <td><input name="Usuario2" type="text" id="Usuario" /></td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="15" valign="top">Password</td>
          </tr>
          <tr>
            <td><input name="Password2" type="password" id="Password" /></td>
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
          <td height="10"></td>
        </tr>
        <tr>
          <td><div align="left"><strong>Al darte de alta podr&aacute;s:</strong></div></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;Enviar varias facturas...</div></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;De varios tel&eacute;fonos...</div></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;Ver tus informes...</div></td>
        </tr>
        <tr>
          <td><div align="left">&#8226;&nbsp;...</div></td>
        </tr>
        <tr>
          <td height="10"></td>
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
    </div>
  <div id="areaTexto">



	<div id="contenido">
	<?php
	$usuario = $_POST["UsuarioAlta"];
	$password = $_POST["PasswordAlta"];
	$fechacreacion = date("Y-m-d H:i:s");
	$nombre = $_POST["Nombre"];
	$mail = $_POST["Mail"];
//	$sql2 = "UPDATE resultados_basicos SET fecha = '$fecha', coste = '$coste_total_calculado' WHERE idFactura = '$idFactura' AND idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'";
//	$sql = "INSERT INTO miembros (Login, Password, Creado, Nombre, Apellido1, Apellido2, Estado, Nacimiento, Sexo";
	$sql = "UPDATE miembros SET Login = '$usuario', Password = '$password', Creado = '$fechacreacion', Nombre = '$nombre', Estado = 'INACTIVO'";
	if ($mail != false)
		$sql = $sql . ", Correo = '$mail'";
	$loginP = $_SESSION['miembro'];
	$passwordP = $_SESSION['password'];
	$sql = $sql . " WHERE Login = '$loginP' AND Password = '$passwordP'";
	$result = mysql_query($sql);
	if ($result == 0) {
		if (mysql_errno() == 1062) {
		?>
		<table width="378"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td height="30"> El usuario <?php echo $usuario; ?> ya existe. <a href="alta.php">Int&eacute;ntalo de nuevo con otro nombre de usuario.</a> </td>
		  </tr>
	  </table>
		<?php
		}
		else
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
	}
	else {
		$_SESSION['miembro'] = $usuario;
		$_SESSION['password'] = $password;
?>
  <table width="378"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"> <div align="center">Gracias por darte de alta en Ahorramovil! </div></td>
    </tr>
    <tr>
      <td height="20" colspan="3">&nbsp;</td>
      </tr>
    <tr>
      <td width="262" height="30"><div align="right">Usuario</div></td>
      <td width="17">&nbsp;</td>
      <td width="311" height="30">
        <div align="left"><strong><?php echo $usuario; ?></strong></div>		</td>
    </tr>
    <tr>
      <td height="30"><div align="right">Nombre</div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left"><strong><?php echo $nombre; ?></strong></div></td>
    </tr>
    <tr>
      <td height="30"><div align="right">e-mail</div></td>
      <td>&nbsp;</td>
      <td height="30"><div align="left"><strong><?php echo $mail; ?></strong></div></td>
    </tr>
    <tr>
      <td height="30"><div align="right">
      </div></td>
      <td>&nbsp;</td>
      <td height="30">
        <div align="left">      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="center">Ya puedes ir a tu <a href="zonaUsuario.php">Zona de Usuario!</a></div></td>
      </tr>
  </table>
<?php
	}
?>
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
<area shape="rect" coords="694,125,770,143" href="contacto.php" alt="" />
</map></body>

</html>
