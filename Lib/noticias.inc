<?php

function timestamp2String ($datefromdb)
{
	$year = substr($datefromdb,0,4);
	$mon  = substr($datefromdb,5,2);
	$day  = substr($datefromdb,8,2);
	$hour = substr($datefromdb,11,2);
	$min  = substr($datefromdb,14,2);
	$sec  = substr($datefromdb,17,2);
	return $day . "/" . $mon."/".$year." ".$hour.":".$min;
}

function timestamp2Date ($datefromdb)
{
	$year = substr($datefromdb,0,4);
	$mon  = substr($datefromdb,5,2);
	$day  = substr($datefromdb,8,2);
	return $day . "/" . $mon."/".$year;
}

function timestamp2Time ($datefromdb)
{
	$hour = substr($datefromdb,11,2);
	$min  = substr($datefromdb,14,2);
	$sec  = substr($datefromdb,17,2);
	return $hour.":".$min.":".$sec;
}

?>