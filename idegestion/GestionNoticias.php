<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	include("../Lib/library.inc");
	include("../Lib/noticias.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>
<script type="text/JavaScript">
</script>
<style type="text/css">
<!--
.fechaNoticia {font-size:9px; color:#0071BC; }
.tituloNoticia {font-size:14px; font-weight:bold; color:#053A7F; font-family:Verdana, Arial, Helvetica, sans-serif;}
.descripcionNoticia {font-size:11px; color:#053A7F; font-family:Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
</head>
<body>
<table width=418 border=0>
<tr height=50>
<td><strong>GESTION NOTICIAS</strong></td>
</tr>
</table>
	<?php
		$begin = isset ($_GET["begin"]) ? $_GET["begin"] : 0;
//		$end = isset ($_GET["end"]) ? $_GET["end"] : -1;
		$max = 5;
		
		$sql = "SELECT id, fecha, titulo, descripcion, mimeMiniatura, imagenMiniatura, altoMiniatura, anchoMiniatura, alto, ancho FROM noticias ORDER BY fecha DESC";
		$result = mysql_query($sql);
		if ($result == 0) {
			echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
			exit();
		}

		if ($begin < 0)
			$begin = 0;
			
//		if ($end == -1)
			$end = $begin + $max;
		if ($end > mysql_num_rows ($result))
			$end = mysql_num_rows ($result);
		
		mysql_data_seek ($result, $begin);
 		echo "<table width=418 border=0>";
		for ($i = $begin; $i < $end; $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<tr>";
			echo "<td width=418 align=left>";
			echo "<strong><a href=\"#".$row_array[0]."\">".$row_array[1].". ".$row_array[2]."</a></strong>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		
		echo "<table width=418 border=0>";
		echo "<tr>";
		echo "<td width=209 align=left>";
		if ($begin > 0)
			echo "<a href=\"GestionNoticias.php?begin=".($begin - $max)."\"/>Anterior</a>";
		echo "</td>";
		echo "<td width=209 align=right>";
		if ($end < mysql_num_rows ($result))	
			echo "<a href=\"GestionNoticias.php?begin=".$end."\"/>Siguiente</a>";
		echo "</td>";
		echo "</tr>";
		echo "<tr height=6></tr>";
		echo "<tr> <td colspan=2 width=418 align=center>";
		echo "<a href=\"GestionNoticiasProcesar.php\"><strong>Nueva noticia</strong></a>";
		echo "</td></tr>";
		echo "</table>";
		echo "</div>";
		echo "<br />";
		echo "<br />";
	
		mysql_data_seek ($result, $begin);
		for ($i = $begin; $i < $end; $i++) {
			$row_array = mysql_fetch_row($result);
			echo "<br />";	
			echo "<table width=370 border = 0>";
			echo "<tr><td colspan=3 align=left class=tituloNoticia>";
//			echo "<a name=\"".$row_array[0]."\" id=\"".$row_array[0]."\">".$row_array[2]."</a>";
			echo $row_array[2];
			echo "</td></tr>";
			echo "<tr><td colspan=3 align=left class=fechaNoticia>";
			echo timestamp2String ($row_array[1]);
			echo "</td></tr>";
			echo "<tr><td colspan=3 align=justify class=descripcionNoticia>".$row_array[3]."</td></tr>";

			if ($row_array[5] != NULL){
				echo "<tr height=".($row_array[6]+20)."><td colspan=3 width=500 align=center valign=center>";
				
				echo "<a href=\"cargarImagenDB.php?type=NOTICIA&idNoticia=".$row_array[0]."\" target=\"_blank\" onClick=\"window.open(this.href,this.target,'width=".($row_array[9]+20).",height=".($row_array[8]+20)."'); return false;\"><img src=\"cargarImagenDB.php?type=NOTICIAMINIATURA&idNoticia=".$row_array[0]."\"/></a></td>";
			}

			echo "<tr>";
			echo "<td width=123 align=center><a href=\"GestionNoticiasProcesar.php?id=".$row_array[0]."\"/>Cambiar</a></td>";
			echo "<td width=124 align=center><a href=\"GestionNoticiasProcesarImagen.php?id=".$row_array[0]."\"/>Imagen</a></td>";
			echo "<td width=123 align=center><a href=\"GestionNoticiasEliminar.php?id=".$row_array[0]."\"/>Eliminar</a></td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=15>&nbsp;</td></tr>";
			echo "<tr><td colspan=3 align=center><img src=\"../imagenesmastreces/noticias/separador.gif\" alt=\"\" /></td></tr>";
			echo "<tr><td colspan=3 height=15>&nbsp;</td></tr>";
			echo "</table>";
			
		}	
	?>
</body>
</html>
