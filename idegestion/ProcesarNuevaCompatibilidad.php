<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>
<style type="text/css">
<!--
.Estilo57 {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo62 {color: #FFFBF0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo64 {color: #FFFBF0}
.Estilo65 {	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>
<html>
<head>
<link type='text/xml' rel='alternate' href='/Default.vsdisco'/>

	<title>PHP & MySQL Test</title>
	<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	font-style: italic;
}
-->
    </style>
<link href="estils.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	text-decoration: none;
	color: #000000;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #FF9F00;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.Estilo32 {font-size: 28pt}
.Estilo33 {
	font-size: 30pt;
	font-weight: bold;
}
.Estilo53 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
.Estilo55 {font-size: 18px}
.Estilo59 {font-size: 14px}
.Estilo60 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo63 {color: #FFFFFF}
-->
</style>
</head>
<body>
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$idContrato = $_POST["idContrato"];
	

	// Mirem primer si els valors modificats pel propi formulari de la compatibilitat son SET
		if (isset($_POST["ServicioAhorro1"]) and isset($_POST["ServicioAhorro2"]) and isset($_POST["ServicioAhorro3"]) and isset(		$_POST["ServicioAhorro4"]) and isset($_POST["ServicioAhorro5"]) ) {
		
		
	$idServicioAhorro1 = $_POST["ServicioAhorro1"];
	$idServicioAhorro2 = $_POST["ServicioAhorro2"];
	$idServicioAhorro3 = $_POST["ServicioAhorro3"];
	$idServicioAhorro4 = $_POST["ServicioAhorro4"];
	$idServicioAhorro5 = $_POST["ServicioAhorro5"];

	$compatibilidad = 0;
	$sql = "SELECT MAX(idCompatibilidad) FROM compatibilidades WHERE idContrato = '$idContrato'";
	$result = mysql_query($sql);
	if ($result == 0) {
		echo "<b>Error " . mysql_errno() . ": " . mysql_error() . "</b>";
		exit();
	}
	if (mysql_num_rows($result) != 0) {
		$row_array = mysql_fetch_row($result);
		$compatibilidad = $row_array[0] + 1;
	}
	
	if ($idServicioAhorro1 != "Ninguno") {
		$sql01 = "INSERT INTO compatibilidades (idCompatibilidad, idContrato, idServicioAhorro) VALUES ('$compatibilidad', '$idContrato', '$idServicioAhorro1')";
		$result01 = mysql_query($sql01);
	}
	if ($idServicioAhorro2 != "Ninguno") {
		$sql01 = "INSERT INTO compatibilidades (idCompatibilidad, idContrato, idServicioAhorro) VALUES ('$compatibilidad', '$idContrato', '$idServicioAhorro2')";
		$result01 = mysql_query($sql01);
	}
	if ($idServicioAhorro3 != "Ninguno") {
		$sql01 = "INSERT INTO compatibilidades (idCompatibilidad, idContrato, idServicioAhorro) VALUES ('$compatibilidad', '$idContrato', '$idServicioAhorro3')";
		$result01 = mysql_query($sql01);
	}
	if ($idServicioAhorro4 != "Ninguno") {
		$sql01 = "INSERT INTO compatibilidades (idCompatibilidad, idContrato, idServicioAhorro) VALUES ('$compatibilidad', '$idContrato', '$idServicioAhorro4')";
		$result01 = mysql_query($sql01);
	}
	if ($idServicioAhorro5 != "Ninguno") {
		$sql01 = "INSERT INTO compatibilidades (idCompatibilidad, idContrato, idServicioAhorro) VALUES ('$compatibilidad', '$idContrato', '$idServicioAhorro5')";
		$result01 = mysql_query($sql01);
	}
	
			}
					
	?>
	
<table width="990" height="133" border="0" background="../imagenes/colorfonstitol2.jpg" id="Titol">
  <tr>
    <th width="200" rowspan="2" valign="middle" class="Estilo5" scope="col"><div align="right" class="Estilo32">
      <div align="right" class="Estilo33">Idegestion</div>
    </div></th>
    <th height="39" colspan="2" valign="bottom" class="Estilo5" scope="col"><div align="left"><img src="../imagenes/LogoID2.gif" width="29" height="20" /></div></th>
  </tr>
  <tr>
    <td height="43" colspan="2" valign="middle" class="Estilo5" scope="col"></td>
  </tr>
  <tr>
    <td height="20" valign="middle" class="Estilo5" scope="col"></td>
    <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center">Nueva compatibilidad </div></td>
    <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"><a href="indexGestion.php" class="Estilo65">Salir</a><a href="index.php"></a></div></td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="990" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">Compatibilidades del Contrato </div></td>
   </tr>
</table>
 <p>&nbsp;</p>
 <table width="990" border="1" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center">Nombre del contrato</div></td>
     <td class="Estilo53"><div align="center">Compatibilidad </div></td>
     <td class="Estilo53"><div align="center">Servicio de ahorro 1</div></td>
	 <td class="Estilo53"><div align="center">Servicio de ahorro 2 </div></td>
     <td class="Estilo53"><div align="center">Servicio de ahorro 3 </div></td>
     <td class="Estilo53"><div align="center">Servicio de ahorro 4 </div></td>
     <td class="Estilo53"><div align="center">Servicio de ahorro 5 </div></td>
   </tr>
   <?php
   // Extreiem la informació de les compatibilitats existents pel contracte
	
							
				$sql = "SELECT compatibilidades.id, idCompatibilidad, contratos.nombre, servicios_ahorro.nombre FROM compatibilidades JOIN contratos, servicios_ahorro WHERE idContrato = '$idContrato' AND compatibilidades.idContrato = contratos.id AND compatibilidades.idServicioAhorro = servicios_ahorro.id";
				$result = mysql_query($sql);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
			else
				{
						for ($i = 0; $i < mysql_num_rows($result); $i++) {
							$row_array = mysql_fetch_row($result);
							$idCompatibilidad[$i] = $row_array[1];
							
							if (mysql_num_rows($result) > 1)
							
							{
						
										
										
							
							if ($i == 0)
									 {
										echo "<tr>" ;
										echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
										echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
										echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
										$nc = 2;
									 }
								
							else if ($i > 0 and $i < (mysql_num_rows($result)-1))
									 {
														
										$diferenciaCompatibilidad = $idCompatibilidad[$i] - $idCompatibilidad[$i-1];
									//	echo "la i es" . $i . "la dc es" . $diferenciaCompatibilidad . "<br>";
										if ($diferenciaCompatibilidad == 0) 
															{
														
																echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
																$nc++;
															}
															else
																 {
																    for ($c = $nc+1; $c <  7 ; $c++){ echo "<td>&nbsp;</td>";}
																	echo "<td><div align=\"center\">";
																	//echo "<input type=\"checkbox\" name=\"checkbox".($i-1)."\" value=\"1\" />";
																	//echo "<input type=\"hidden\" name=\"compatibilidad".($i-1)."\" value=\"".$idCompatibilidad [$i-1]."\">";
																	echo "</td>";
																	echo "</tr>";
																	echo "<tr>" ;
																	echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
																	echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
																	echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
																	$nc=2;
								
																	}
									}
							else 
									{	
										$diferenciaCompatibilidad = $idCompatibilidad[$i] - $idCompatibilidad[$i-1];
										//echo "la i es" . $i . "la dc es" . $diferenciaCompatibilidad . "<br>";
										if ($diferenciaCompatibilidad == 0) 
														{
																echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
																$nc++;
																for ($c = $nc+1; $c<7; $c++){ echo "<td>&nbsp;</td>";}
															
																echo "<td><div align=\"center\">";
																//echo "<input type=\"checkbox\" name=\"checkbox".$i."\" value=\"1\" />";
															//	echo "<input type=\"hidden\" name=\"compatibilidad".$i."\" value=\"".$idCompatibilidad [$i]."\">";
																echo "</td>";
																echo "</tr>";
														}
														else
															 {
																for ($c = $nc+1; $c<7; $c++){ echo "<td>&nbsp;</td>";}
																
																echo "<td><div align=\"center\">";
															//	echo "<input type=\"checkbox\" name=\"checkbox".($i-1)."\" value=\"1\" />";
															//	echo "<input type=\"hidden\" name=\"compatibilidad".($i-1)."\" value=\"".$idCompatibilidad [$i-1]."\">";
																echo "</td>";
																echo "</tr>";
																echo "<tr>" ;
																echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
																echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
																echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
																$nc=2;
																for ($c = $nc+1; $c<7; $c++){ echo "<td>&nbsp;</td>";}
																
																echo "<td><div align=\"center\">";
															//	echo "<input type=\"checkbox\" name=\"checkbox".$i."\" value=\"1\" />";
															//	echo "<input type=\"hidden\" name=\"compatibilidad".$i."\" value=\"".$idCompatibilidad [$i]."\">";
																echo "</td>";
																echo "</tr>";
															}
							
							
									}
							
							
							}
							
							else {
																echo "<tr>" ;
																echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
																echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
																echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
																$nc=2;
																for ($c = $nc+1; $c<7; $c++){ echo "<td>&nbsp;</td>";}
																
																echo "<td><div align=\"center\">";
															//	echo "<input type=\"checkbox\" name=\"checkbox".$i."\" value=\"1\" />";
															//	echo "<input type=\"hidden\" name=\"compatibilidad".$i."\" value=\"".$idCompatibilidad [$i]."\">";
																echo "</td>";
																echo "</tr>";
																
								}
							
							
							
					}		
						
					/*	for ($i = 0; $i < mysql_num_rows($result); $i++) {
							$row_array = mysql_fetch_row($result);
							$idCompatibilidad = $row_array[1];
							echo "<tr>" ;
							echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
							echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
							echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
							echo "</tr>";
							
							for ($i = 0; $i < mysql_num_rows($result); $i++) {
							$row_array = mysql_fetch_row($result);
							$idCompatibilidad[$i] = $row_array[1];
							if ($i > 0) {
								$diferenciaCompatibilidad = $idCompatibilidad[$i] - $idCompatibilidad[$i-1];
								if ($diferenciaCompatibilidad == 0) {
									echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";}
									else {
									echo "</tr>";
									echo "<tr>" ;
									echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
									echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
									echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
								
								}
								}
							else {	
							echo "<tr>" ;
							echo "<td><div align=\"center\">"	. $row_array[2] . "</div></td>";
							echo "<td><div align=\"center\">"	. $row_array[1] . "</div></td>";
							echo "<td><div align=\"center\">"	. $row_array[3] . "</div></td>";
									}
							
							
							}
					*/
					}
															
								
									
			
   ?>
     
 </table>
 
 
 <p>&nbsp;</p>
 <table width="990" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td class="Estilo53"><div align="center" class="Estilo55">A&ntilde;adir nueva compatibilidad </div></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <form id="form1" method="post" action="ProcesarNuevaCompatibilidad.php">
 <?php
 echo "<input type=\"hidden\" name=\"idContrato\" value=\"" . $idContrato. "\">";
 ?>
 
   <table width="990" border="1" cellspacing="0" cellpadding="0">
     <tr>
       <td class="Estilo53"><div align="center">Nombre del contrato</div></td>
       <td class="Estilo53"><div align="center">Servicio de ahorro 1 </div></td>
       <td class="Estilo53"><div align="center">Servicio de ahorro 2 </div></td>
       <td class="Estilo53"><div align="center">Servicio de ahorro 3 </div></td>
       <td class="Estilo53"><div align="center">Servicio de ahorro 4 </div></td>
       <td class="Estilo53"><div align="center">Servicio de ahorro 5 </div></td>
     </tr>
     <tr>
       <td><div align="center">
	   <?php
	   $sql = "SELECT nombre FROM contratos WHERE id = '$idContrato'";
				$result = mysql_query($sql);
				if ($result == 0)
					echo "<b>Error 3" . mysql_errno() . ": " . mysql_error() . "</b>";
				else
				{
				$row_array = mysql_fetch_row($result);
				$nombre_contrato = $row_array[0];
					}
	     
	   echo $nombre_contrato;
	   ?>
	  </td>
       <td class="Estilo53"><select name="ServicioAhorro1">
	   
	        <?php	
        		 $sql = "SELECT id, nombre FROM servicios_ahorro WHERE idOperador = (SELECT idOperador FROM contratos WHERE id = '$idContrato')";
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
	   </td>
       <td class="Estilo53">
	   <select name="ServicioAhorro2">
	   <option value="Ninguno">Ninguno</option>
	        <?php	
        		 $sql = "SELECT id, nombre FROM servicios_ahorro WHERE idOperador = (SELECT idOperador FROM contratos WHERE id = '$idContrato')";
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
	  </td>
       <td class="Estilo53"><select name="ServicioAhorro3">
	   <option value="Ninguno">Ninguno</option>
	        <?php	
        		$sql = "SELECT id, nombre FROM servicios_ahorro WHERE idOperador = (SELECT idOperador FROM contratos WHERE id = '$idContrato')";
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
		</td>
       <td class="Estilo53"><select name="ServicioAhorro4">
	   <option value="Ninguno">Ninguno</option>
	        <?php	
        		$sql = "SELECT id, nombre FROM servicios_ahorro WHERE idOperador = (SELECT idOperador FROM contratos WHERE id = '$idContrato')";
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
	   
	  </td>
       <td class="Estilo53"><select name="ServicioAhorro5">
	   <option value="Ninguno">Ninguno</option>
	        <?php	
        		$sql = "SELECT id, nombre FROM servicios_ahorro WHERE idOperador = (SELECT idOperador FROM contratos WHERE id = '$idContrato')";
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
		</td>
     </tr>
	 </table> 
	 <table width="990">
	   <tr>
	     <td class="Estilo53">&nbsp;</td>
	     </tr>
	   <tr>
	     <td class="Estilo53"><div align="center">
		 <input name="Enviar" type="submit" value="Añadir compatibilidad al Contrato  &gt;&gt;" />
	     </div></td>
	     </tr>
    </table> 






</form>
  
</body>
</html>
