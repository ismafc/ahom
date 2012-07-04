<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META name="description" content="Esta página permite conocer cuanto se puede ahorrar en la factura de telefonía móvil. Informando del mejor operador, contrato y servicio de ahorro"> 
<META name="keywords" content="ahorrar, ahorro, telefonía, móvil, factura, contrato, operador, movistar, vodafone, amena, consumo"> 
<title>Ahorrar en la factura de telefon&iacute;a m&oacute;vil. Aplicaci&oacute;n web para calcular el mejor operador, contrato y servicio de ahorro</title>
<?php
	include("./Lib/main.inc");
	include("./Lib/base.inc");
	include("./Lib/library.inc");
	include("./Lib/noticias.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	if (!isset($_SESSION['miembro'], $_SESSION['password'])) {
		$_SESSION['miembro'] = session_id();
		$_SESSION['password'] = session_id();
		crearUsuarioProvisional($_SESSION['miembro'], $_SESSION['password']);
	}
?>
<link rel="stylesheet" href="noticias.css" type="text/css" />

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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body id="inicio">
<div id="wrapper">

	<div id="encabezado">
	<table border="0"cellpadding="0" cellspacing="0">
   	<tr>
      <td><img src="imagenesmastreces/encabezadoNoticias/encabezado1.gif" alt="" width="778" height="141" usemap="#Map" />
        <div id="fecha"><?php echo obtenerFechaActual(); ?></div>      </td>
	  </tr>
      </table>
  </div>
	
  <div id="encabezado2">
	
  </div>
	 
  

	<div id="login">
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
	  <table width="152" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><?php
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
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
  <tr>
    <td colspan="5"><p><span>&iexcl;Actualizamos las tarifas constantemente!</span><br/>
Nuevos contratos, nuevos operadores, etc...<br/>
    </p>
      &iexcl;Consulta nuestros <a href="queOfrecemos.php">servicios</a>!<br/>
    </td>
  </tr>
      </table>
  </div>
  <div id="areaTexto">



	<div id="contenido">
    <?php
		$begin = isset ($_GET["begin"]) ? $_GET["begin"] : 0;
		$max = 7;
		
		$sql = "SELECT id, fecha, titulo, descripcion, mimeMiniatura, imagenMiniatura, altoMiniatura, anchoMiniatura, alto, ancho FROM noticias ORDER BY fecha DESC";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}

		if ($begin < 0)
			$begin = 0;
			
		$end = $begin + $max;
		if ($end > mysql_num_rows ($result))
			$end = mysql_num_rows ($result);
		
		echo "<table border=0 cellpadding=0 cellspacing=0 width=418 height=100>";
                 if ($end == 0) {
                        echo "<tr height=10><td style=\"text-align: center\">No hay noticias disponibles</td></tr>";
                 }
                 else {
                    mysql_data_seek ($result, $begin);
                    for ($i = $begin; $i < $end; $i++) {
                            $row_array = mysql_fetch_row($result);
                            echo "<tr height=10>";
                        echo "<td width=20>&nbsp;</td>";
                            echo "<td width=378 align=left>";
                            echo "<strong><a href=\"#".$row_array[0]."\">".timestamp2Date($row_array[1])." ".$row_array[2]."</a></strong>";
                        echo "<td width=20>&nbsp;</td>";
                            echo "</td>";
                            echo "</tr>";
                    }
                    $i = $end - $begin;
                    for ($i; $i < $max; $i++){
                            echo "<tr height=10>";
                        echo "<td width=20>&nbsp;</td>";
                            echo "<td width=378>&nbsp;</td>";
                        echo "<td width=20>&nbsp;</td>";
                            echo "</tr>";
                    }
                }
		echo "</table>";
		
		echo "<table border=0 cellpadding=0 cellspacing=0 width=418>";
		echo "<tr height=10>";
		echo "<td width=20>&nbsp;</td>";
		echo "<td width=189 align=left>";
		if ($begin > 0){
			echo "<a href=\"noticias.php?begin=".($begin - $max)."\"/>";
			echo "<div id=\"anterior\">&lt;&lt;Anterior</div>";
			echo "</a></td>";
		}
		echo "</td>";
		echo "<td width=189 align=right>";
		if ($end < mysql_num_rows ($result)){
			echo "<a href=\"noticias.php?begin=".$end."\"/>";
			echo "<div id=\"siguiente\">Siguiente&gt;&gt;</div>";
			echo "</a>";
		}
		echo "</td>";
		echo "<td width=20>&nbsp;</td>";
		echo "</tr>";
		echo "</table>";
	?>

<div id="textoContenido">
  <?php
            if ($end > 0) {
	  	mysql_data_seek ($result, $begin);
		for ($i = $begin; $i < $end; $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<table align=center border=0 cellpadding=0 cellspacing=0 width=370>";
			echo "<tr><td height=10>";
			echo "<div id=\"tituloNoticia\"><a name=\"".$row_array[0]."\" id=\"".$row_array[0]."\"></a>".$row_array[2]."</div>";
			echo "</td></tr>";
			echo "<tr><td height=10><div id=\"fechaNoticia\">".timestamp2String ($row_array[1])."</div></td></tr>";
			echo "<tr height=10></tr>";
			echo "<tr><td width=378 align=justify>".$row_array[3]."</td></tr>";

			if ($row_array[5] != NULL){
				echo "<tr height=".($row_array[6]+20)."><td width=378 align=center valign=center>";
				echo "<a href=\"cargarImagenDB.php?type=NOTICIA&idNoticia=".$row_array[0]."\" target=\"_blank\" onClick=\"window.open(this.href,this.target,'width=".($row_array[9]+20).",height=".($row_array[8]+20)."'); return false;\"><img src=\"cargarImagenDB.php?type=NOTICIAMINIATURA&idNoticia=".$row_array[0]."\" border=0/></a></td></tr>";
			}
			echo "<tr><td height=15>&nbsp;</td></tr>";
			echo "<tr><td align=center><img src=\"imagenesmastreces/noticias/separador.gif\" alt=\"\" /></td></tr>";
			echo "<tr><td height=15>&nbsp;</td></tr>";
		    echo "</table>";
		}			
            }
	  ?>
</div>
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
