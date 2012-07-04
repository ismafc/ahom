<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	include("../Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>
<!--
<script type="text/JavaScript">
</script>
-->

<script language="JavaScript" type="text/javascript" src="wysiwyg.js">
</script>

</head>
<body>
<?php
	$id = "";
	$modificar = 0;
	if (isset ($_GET["id"])){
		// modificar;
		$id = $_GET["id"];
		$modificar = 1;
		echo "<br /><strong>MODIFICAR NOTICIA</strong><br /><br />";
	}else{
		// añadir;
		echo "<br /><strong>NUEVA NOTICIA</strong><br /><br />";
	}
	
	if (isset ($_POST['enviar'])){
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		
		if ($modificar == 1){	
			// buscamos la fecha para no cambiarla
			$sql = "SELECT id, fecha FROM noticias WHERE id=$id";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) == 0) {
				//No existe
				echo "No se ha realizado la modificacion. No se ha encontrado la Noticia<br>";
				echo "<br><a href=\"./GestionNoticias.php\">Atrás...</a>";
				exit ();
			}
			$row_array = mysql_fetch_row($result);
			$fecha = $row_array[1];
				
			$sql ="UPDATE noticias ".
					"SET fecha='$fecha', titulo='$titulo', descripcion='$descripcion' ".
					"WHERE id='$id'";
		}else{
			$sql = "INSERT INTO noticias (titulo, descripcion) ".
				"VALUES ('$titulo', '$descripcion')";
		}
		$result = mysql_query($sql);
		if ($result==0)
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
		else if ($modificar == 1)
			echo "<br>Modificación realizada correctamente<br>";
		else
			echo "<br>Noticia añadida correctamente<br>";
			
		echo "<br /><br /><a href=\"./GestionNoticias.php\">Atrás...</a>";	
	}else{
		$titulo = "";
		$descripcion = "";
		
		if ($modificar == 1){
			$sql = "SELECT id, titulo, descripcion FROM noticias WHERE id=$id";

			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			
			$row_array = mysql_fetch_row($result);
			$id = $row_array[0];
			$titulo = $row_array[1];
			$descripcion = $row_array[2];
		}	
?>
    <form action="GestionNoticiasProcesar.php<?php if ($modificar == 1) echo "?id=".$id;?>" method="post">
    <table border="0" cellpadding="0" cellspacing="0">
	    <tr height="50">
    		<td width="100" valign="middle"><strong>Titulo</strong></td>
            <td width="100">
            	<input type="text" maxlenght="100" size="100" id="titulo" name="titulo" value="<?php echo $titulo;?>"/>
            </td>
        </tr>
	    <tr height="50">
    		<td width="100" valign="middle"><strong>Descripcion</strong></td>
            <td width="100">
<!--            	<textarea maxlenght="500" cols="80" rows="20" id="descripcion" name="descripcion" value="< ?php echo $descripcion;?>"/>
 -->
            	<textarea maxlenght="10" cols="80" rows="20" id="descripcion" name="descripcion"><?php echo $descripcion;?></textarea>
                 <script language="javascript1.2">
  generate_wysiwyg('descripcion');
</script> 
            </td>
        </tr>
	</table>
    <br />
    <input size="100"  name="enviar" type="submit" value="Aceptar" />
    </form>
    <form action="GestionNoticias.php" method="post">
                	<input size="100" name="cancelar" type="submit" value="Cancelar"/>
      </form>
<?php 
	} //end if 
?> 

</body>
</html>
