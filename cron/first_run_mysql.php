<?php
	require_once(dirname(__FILE__).'/../inc/config.inc.php');
	require_once(dirname(__FILE__).'/../lib/common.lib.php');
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}

	// Create database
	if (mysql_query("CREATE DATABASE ".$db_add,$con))
	{
		echo "数据库创建成功";
	}
	else
	{
		echo "数据创建失败: " . mysql_error();
	}

	// Create table in my_db database
	mysql_select_db($db_add, $con);
	$sql = "CREATE TABLE ".$tb_add.
	"(
	time varchar(30), 
	block int,
	txid varchar(64),
	address varchar(34),
	valch double 
	)";
	mysql_query($sql,$con);
	
	mysql_select_db($db_add, $con);
	$sql = "CREATE TABLE ".$rich_add.
	"(
	address varchar(34),
	balance double 
	)";
	mysql_query($sql,$con);

	mysql_close($con);
?>