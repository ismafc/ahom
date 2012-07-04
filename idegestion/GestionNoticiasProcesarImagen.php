<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	include("../Lib/library.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>
<script type="text/JavaScript">

function ValidateImagenForm() {
	if (document.ImagenForm.imagenNoticia.value == "") {
		alert("Introduce el archivo de imagen de la noticia");
		document.ImagenForm.imagenNoticia.focus();
		return false;	
	}
	return true;
}

</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 10px; color:#0071BC;}
-->
</style>
</head>
<table border="1">
	<?php
		$id = (isset ($_GET["id"])) ? $_GET["id"] : exit();

		if (isset ($_POST['enviar'])){
		  # Nombre del archivo temporal del thumbnail
		    define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
		 	//define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos

		
			$mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
			// Variables de la foto
			$nameImagen = $_FILES["imagenNoticia"]["name"];
			$typeImagen = $_FILES["imagenNoticia"]["type"];
			$tmp_nameImagen = $_FILES["imagenNoticia"]["tmp_name"];
			$sizeImagen = $_FILES["imagenNoticia"]["size"];
			echo "Nombre: ".$nameImagen."<br>";
			echo "mime: ".$typeImagen."<br>";
		
			// Verificamos si el archivo es una imagen válida
			if(!in_array($typeImagen, $mimetypes))
				die("El archivo de imagen no es una imagen válida");

			$datos = getimagesize($tmp_nameImagen);
			$altoImagen = $datos[1];
			$anchoImagen = $datos[0];	
			echo "Alto = " . $altoImagen . "<br>";
			echo "Ancho = " . $anchoImagen . "<br>";

/////////////////////////////////////////////////////////////////////////////////////////////////
// Creando el thumbnail
  switch($typeImagen) {
    case $mimetypes[0]:
    case $mimetypes[1]:
      $img = imagecreatefromjpeg($tmp_nameImagen);
      break;
    case $mimetypes[2]:
      $img = imagecreatefromgif($tmp_nameImagen);
      break;
    case $mimetypes[3]:
      $img = imagecreatefrompng($tmp_nameImagen);
      break;
  }
  echo "Se creó en memoria<br>";
  $datos = getimagesize($tmp_nameImagen);
  $altoMiniatura = 100;
  $ratio = ($altoImagen/$altoMiniatura);
  $anchoMiniatura = round($anchoImagen/$ratio);
  $miniatura = imagecreatetruecolor($anchoMiniatura, $altoMiniatura);
  imagecopyresized($miniatura, $img, 0, 0, 0, 0, $anchoMiniatura, $altoMiniatura, $anchoImagen, $altoImagen);
  switch($typeImagen) {
    case $mimetypes[0]:
    case $mimetypes[1]:
      imagejpeg($miniatura, NAMETHUMB);
          break;
    case $mimetypes[2]:
      imagegif($miniatura, NAMETHUMB);
      break;
    case $mimetypes[3]:
      imagepng($miniatura, NAMETHUMB);
      break;
  }
////////////////////////////////////////////////////////////////////////////////////////////////777

//			$datos = getimagesize($tmp_nameImagen);
	//		$altoImagen = $datos[1];
		//	$anchoImagen = $datos[0];	
			
			$fpImagen = fopen($tmp_nameImagen, "rb");
			$tfotoImagen = fread($fpImagen, filesize($tmp_nameImagen));
			$tfotoImagen = addslashes($tfotoImagen);
			fclose($fpImagen);
			@unlink($tmp_nameImagen);

			$fpMiniatura = fopen(NAMETHUMB, "rb");
			$tfotoMiniatura = fread($fpMiniatura, filesize(NAMETHUMB));
			$tfotoMiniatura = addslashes($tfotoMiniatura);
			fclose($fpMiniatura);
			@unlink(NAMETHUMB);
 
			$sql = "SELECT id, fecha FROM noticias WHERE id=$id";
			echo $sql."<br>";
			$result = mysql_query($sql);
			echo $result."<br>";
			if (mysql_num_rows($result) == 0) {
				//No existe
				echo "No se ha encontrado la Noticia<br>";
				echo "<br><a href=\"./GestionNoticias.php\">Atrás...</a>";
			}else{
				$row_array = mysql_fetch_row($result);
				$fecha = $row_array[1];
		
				$sql ="UPDATE noticias ".
				"SET fecha='$fecha', imagen='$tfotoImagen', mime='$typeImagen', alto='$altoImagen', ancho='$anchoImagen', ".
				"imagenMiniatura='$tfotoMiniatura', mimeMiniatura='$typeImagen', altoMiniatura='$altoMiniatura', anchoMiniatura='$anchoMiniatura' ".
				"WHERE id=$id";
				$result = mysql_query($sql);
				echo $result."<br>";
				if ($result==0)
					echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b><br>";
				else{
					echo "Modificada Correctamente<br>";		
					echo "<a href=\"./GestionNoticias.php\">Atrás...</a>";
				}
			}
		}else{
			echo "<br><br>";
			echo "<strong>GESTIONAR IMAGEN DE LA NOTICIA<strong>";
			echo "<br><br>";
			$sql = "SELECT id, titulo, altoMiniatura FROM noticias WHERE id=$id";
		
			$result = mysql_query($sql);
			if ($result == 0) {
				echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
				exit();
			}
			$row_array = mysql_fetch_row($result);
			echo "<tr height=20>";
			echo "<td width=100 align=left><strong>Id</strong></td>";
			echo "<td width=420 align=left>".$row_array[0]."</td>";
			echo "</tr>";
		
			echo "<tr height=20>";	
			echo "<td width=100 align=left><strong>Titulo</strong></td>";
			echo "<td width=420 align=left>".$row_array[1]."</td>";
			echo "</tr>";
		
			echo "<tr height=".($row_array[2]+20).">";	
			echo "<td width=100 align=left><strong>Imagen Actual</strong></td>";
			echo "<td width=420 align=left><img src=\"cargarImagenDB.php?type=NOTICIAMINIATURA&idNoticia=".$row_array[0]."\"/></td>";
			echo "</tr>";
		?>
		</table>
		<br />
		<br />
		Introduce la imagen de la noticia
				 <form action="GestionNoticiasProcesarImagen.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data" target="_self" name="ImagenForm" id="ImagenForm" onsubmit="return ValidateImagenForm()">
      
    		    <table width="100%" border="0" cellpadding="0" cellspacing="0">
		          <tr height="50">
		            <td width="10%" valign="middle"><strong>Imagen</strong></td>
		            <td width="90%" align="center" valign="middle">
		           		<input size="150" type="file" id="imagenNoticia" name="imagenNoticia" /> 
		            </td>
		          </tr>
		         </table>
                  <input size="100"  name="enviar" type="submit" value="Aceptar" />
	       </form>
         
<?php 
	} //end if 
?> 

</body>
</html>
