<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>

<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>


<link type='text/xml' rel='alternate' href='/Default.vsdisco'/>
<link rel="stylesheet" href="gestion.css" type="text/css" />

	
</head>
<body id="inicio">

<div id="wrapper">

	<div id="encabezado">
	  <table border="0" cellpadding="0" cellspacing="0">
    <tr>

      <td height="117" valign="top"><img src="imagenesmastreces/encabezadoGestion/encabezado1.gif" alt="" /></td>
    </tr>
	
	  </table>
                 
			
  </div>

   <div id="menu">
   
<table width="150" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="tarifas.php" target="_self" class="Estilo60">Tarifas c&aacute;lculo </a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="tarifasMostrar.php" target="_self" class="Estilo60">Tarifas mostrar </a><a href="GestionServicioAhorro.php" target="_self" class="Estilo60"></a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionNoticias.php" target="_self" class="Estilo60">Noticias</a><a href="GestionCompatibilidad.php" target="_self" class="Estilo60"></a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionPrensa.php" target="_self" class="Estilo60">Prensa</a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionTitular.php" target="_self" class="Estilo60">Titular</a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionClientes.php" target="_self" class="Estilo60">Clientes</a></div>
    </div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53">
      <div align="left"><a href="GestionEstudios.php" target="_self" class="Estilo60">Estudios</a></div>
    </div></td>
  </tr>
</table>
</div>


<div id="contenido">
<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>

      <td width="579"> <div align="left">Ahorramovil Tarifas. Compatibilidades. Nueva Compatibilidad </div></td>
	  </tr>
    </table>
	  <br />

<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55"></div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <form action="ProcesarNuevaCompatibilidad1.php" method="post" target="_self" id="form1">
    <table width="570" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
        <td width="482" class="Estilo53"><div align="right">Escoge el contrato </div></td>
        <td width="17">&nbsp;</td>
        <td width="491"><label>
		<select name="idContrato">
		        <?php	
        		 $sql = "SELECT id, nombre FROM contratos where descatalogado=0";
				$result = mysql_query($sql);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
					for ($i = 0; $i < mysql_num_rows($result); $i++) {
						$row_array = mysql_fetch_row($result);
						echo "<option value=\"" . $row_array[0] . "\">" . $row_array[1] . "</option>";
						}
					}
			?>
        </select>
        </label></td>
      </tr>

	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     <td>&nbsp;</td>
	     <td>
		 <input name="Enviar" type="submit" value="   Continuar &gt;&gt;">		</td>
      </tr>
    </table>
</form>
</div>
</div>
</body>
</html>
