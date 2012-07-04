<?php
function openDatabase() {

	// PC local Isma
	$host="localhost";
	$user="root";
	$password="isma10";
	$database="ahorramo";

	// PC ovh
//	$host="localhost";
//	$user="ahorramo";
//	$password="ahorramovil10";
//	$database="ahorramo";

	// PC local
//	$host="localhost";
//	$user="root";
//	$password="isma10";
//	$database="idesimul";

	//AddYour.net
//	$host="localhost";
//	$user="idegrupo_ismael";
//	$password="isma10";
//	$database="idegrupo_idesimul";

	// iespana.es
//	$host="imysql01";
//	$user="i4144795";
//	$password="clxdd4kget8xlom7";
//	$database="i4144795";

	// A2Hosting
//	$host="localhost";
//	$user="idesimul_ismafc";
//	$password="isma10";
//	$database="idesimul_idesimul";
	
	$connection = mysql_connect($host,$user,$password);
	if ($connection == 0)
		return false;
	$db = mysql_select_db($database, $connection);
	if ($db == 0)
		return false;
	return true;
}
?>