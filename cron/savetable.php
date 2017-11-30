<?php
	require_once(dirname(__FILE__).'/../inc/config.inc.php');
	require_once(dirname(__FILE__).'/../lib/common.lib.php');
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}

	mysql_select_db($db_add, $con);
	$sql = "CREATE TABLE db_tb_add10 AS (SELECT DISTINCT time,block,txid,address,valch FROM ".$tb_add.")";
	$result=mysql_query($sql,$con);
	echo $result;
	mysql_close($con);
?>