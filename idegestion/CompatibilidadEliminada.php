<html>
<head>
	<title>PHP & MySQL Test</title>
    <style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo32 {font-size: 28pt}
.Estilo33 {	font-size: 30pt;
	font-weight: bold;
}
.Estilo5 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	font-style: italic;
}
.Estilo60 {font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo63 {	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	font-weight: bold;
}
-->
    </style>
</head>
<body>

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
    <td width="585" height="20" valign="middle" class="Estilo60" scope="col"><div align="center"></div></td>
    <td width="191" valign="middle" class="Estilo60" scope="col"><div align="center"></div></td>
  </tr>
</table>
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
	$idContrato = $_POST["idContrato"];
	
	// Mirem les compatibilitats que s'han seleccionat, en principi fins un m�xim de 20, ja que les i estan alternades i no es pot estar segur de fer un break su bi estan set
		
	for ($i = 0 ; $i < 29 ; $i++)
	 {
	      
	      
				$idCompatibilidad = $_POST["compatibilidad".$i.""];
						
				if (($_POST["checkbox".$i.""] == "1") )
								 {
									$sql00 = "DELETE FROM compatibilidades WHERE idContrato = '$idContrato' AND idCompatibilidad = '$idCompatibilidad'";
									$result100 = mysql_query($sql00);
									echo "<b> Eliminada con exito la compatibilidad " .  $idCompatibilidad . "del contrato " . $idContrato . "<br>";
								  }
					
			
	
	}
			
	?>
<form name="form1" method="post" action="indexGestion.php">
  <label><br>
  </label>
  <table width="990" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div align="center">
	  	        <input type="submit" name="Submit" value="Continuar &gt;&gt;">
      </div></td>
    </tr>
  </table>
</form>

</body>
</html>