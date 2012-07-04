<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paginaprincipal</title>
</head>
<?php
	include("../Lib/main.inc");
	include("../Lib/base.inc");
	if (openDatabase() == false) {
		echo "Problemas de acceso a la base de datos<br>";
		exit();
	}
?>
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
	color: #000000;
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
.Estilo59 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo60 {font-size: 18px}
.style1 {
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #0000FF;
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
      <td width="585" height="20" valign="middle" class="Estilo59" scope="col"></td>
      <td width="191" valign="middle" class="Estilo59" scope="col"><div align="center"><a href="../index.php" class="Estilo59">Salir </a></div></td>
    </tr>
</table>
  
  <p>&nbsp;</p>
<table width="990" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionContrato.php" target="_self" class="Estilo60">Contratos</a></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionServicioAhorro.php" target="_self" class="Estilo60">Servicios de ahorro</a></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionCompatibilidad.php" target="_self" class="Estilo60">Compatibilidades</a></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionNoticias.php" target="_self" class="Estilo60">Noticias</a></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="Operadores.php" target="_self" class="Estilo60">A&ntilde;adir logo de operadores</a></div></td>
  </tr>
  <tr>
    <td height="50"><div align="center" class="style1">Tarifas</div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionTarjetas.php" target="_self" class="Estilo60">S&oacute;lo para las tarifas (tarjetas</a>)</div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionTarjetasCompatibilidad.php" target="_self" class="Estilo60">S&oacute;lo para las tarifas (compatibilidades tarjetas)</a></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionServiciosDeAhorro.php" target="_self" class="Estilo60">S&oacute;lo para las tarifas (servicios de ahorro)</a></div></td>
  </tr>
  <tr>
    <td height="30"><div align="center" class="Estilo53"><a href="GestionTarifasContratos.php" target="_self" class="Estilo60">S&oacute;lo para las tarifas (contratos)</a></div></td>
  </tr>
</table>
</p>
</body>
</html>
