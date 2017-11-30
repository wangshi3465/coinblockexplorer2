<?php
	require_once(dirname(__FILE__).'/../inc/config.inc.php');
	require_once(dirname(__FILE__).'/../lib/common.lib.php');
	$file_time = dirname(__FILE__)."/../db/curtime.txt";//更新时间
	$rich_time = dirname(__FILE__)."/../db/richtime.txt";//更新富豪榜时间
	$upd_time =  file_get_contents($file_time);
	$rich_upd_time =  file_get_contents($rich_time);
	set_time_limit(0);
	
	if($rich_upd_time != $upd_time){
	file_put_contents($rich_time,$upd_time);
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}
	mysql_select_db($db_add, $con);
	$result = mysql_query("TRUNCATE TABLE ".$rich_add);
	mysql_close($con);
	
	$address = 0;
	$balance = 0;
	$m = 0;
	$n = 0;
	$arr_add = array();
	$arr_val = array();
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}
	mysql_select_db($db_add, $con);
	$result = mysql_query("SELECT * FROM ".$tb_add);
	while($row = mysql_fetch_array($result))
	{
		if( $m== 0){
			$arr_add[$n] = $row['address'];
			$arr_val[$n] = $row['valch'];
		}
		else{
			$i = 0;
			$issame = false;//相同吗？
			while($i<=$n){
				if($row['address'] == $arr_add[$i]){
					$arr_val[$i] += $row['valch'];
					$issame = true;
					break;
				}
				$i++;
			}
			if(!$issame){
				$n++;
				$arr_add[$n] = $row['address'];
				$arr_val[$n] = $row['valch'];					
			}
		}
		$m++;				
	}
	for($j=0;$j<=$n;$j++){
		$address = $arr_add[$j];
		$balance = $arr_val[$j];
		if($balance != 0){
			mysql_select_db($db_add, $con);
			mysql_query("INSERT INTO ".$rich_add." (address,balance) 
			VALUES ('$address','$balance')");
		}
	}	
	unset($arr_add);
	unset($arr_val);
	mysql_close($con);
	echo "更新数据:".$upd_time;
	}
	else echo "无需更新!";
?>
