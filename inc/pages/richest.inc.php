<?php
	
	$price=0.01;
	function get($url){
		if(function_exists('file_get_contents'))
		{
			$file_contents = file_get_contents($url);
		}
		$res1 = explode(':',$file_contents);
		$m=$res1[4];
		$res2 = explode(',',$m);
		$n=$res2[0];
		$p=floatval($n);
		return $p;	
	}
	$file_time = dirname(dirname(dirname(__FILE__)))."/db/curtime.txt";//更新时间
	$m = 1;
	$total = 0;
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}
	mysql_select_db($db_add, $con);
	$result = mysql_query("SELECT * FROM ".$rich_add." ORDER BY balance DESC");
	echo "<h3 ><center>富豪榜TOP150</center></h3>
	<table class='table table-striped' align="."center".">";
	echo "<tr>
		<th>排名</th>
		<th>钱包地址</th>
		<th>余额</th>
		<th>价值</th>
		<th>占比</th>
		</tr>";
	while($row = mysql_fetch_array($result))
	{
		if($m <= 150){
			echo "<tr><td>".$m."</td>";
			echo "<td><a href='./?address=".$row['address']."'>".$row['address']."</a></td>";
			$row['balance']=round($row['balance']);
			echo "<td>".$row['balance']."&nbsp;".$curr_code."</td>";
			$value= round($row['balance'] * $price,2);
			echo "<td>".$value."&nbsp;元</td>";
			$prop = round($row['balance']*100/$total_coin,2);
			echo "<td>".$prop."%</td></tr>";			
		}
		
		if($m ==150)
		break;
		$m++;
		$total+= $row['balance'];
	}	
	echo "</table>";
	mysql_close($con);
	echo "富豪榜TOP100共计持有:<b>".$total." </b>".$curr_code."</br>";
	$upd_time =  file_get_contents($file_time);
	echo "更新时间：".$upd_time;
	
?>
