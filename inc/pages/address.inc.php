<div class="row-fluid">
<div class="span7">
<?php
$address = preg_replace("/[^a-z0-9]/i", '', $_GET['address']);
$file_time = dirname(dirname(dirname(__FILE__)))."/db/curtime.txt";//更新时间
	$clean_bal = 0;
	$real_ins = 0;
	$real_ots = 0;
	$isex = false;
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}
	mysql_select_db($db_add, $con);
	$result = mysql_query("SELECT valch FROM ".$tb_add." WHERE address='".$address."'");	//2016.9.14由于数据表中存在较多的重复数据,进行唯一性修复
	while($row = mysql_fetch_array($result))
	{
		
			$clean_bal += $row['valch'];
			if($row['valch'] >0) $real_ots += $row['valch'];
			else $real_ins += $row['valch'];
			$isex = true;
		
	}	
	$upd_time =  file_get_contents($file_time);
	mysql_close($con);
	if($isex){
		echo "<h1> 地址账户详情: </h1><br />";
		
				echo "<table class='table table-striped table-condensed'>";
					echo "<tr><td><b>地址账户:</b></td><td>".$address."</td></tr>";
					echo "<tr><td><b>余额:</b></td><td>".$clean_bal."&nbsp;".$curr_code."</td></tr>";
					echo "<tr><td><b>总发送金额:</b></td><td>".$real_ins."&nbsp;".$curr_code."</td></tr>";
					echo "<tr><td><b>总接收金额:</b></td><td>".$real_ots."&nbsp;".$curr_code."</td></tr>";
					echo "<tr><td><b>更新时间:</b></td><td>".$upd_time."</td></tr>";
					echo "<tr><td><b>注意:余额可能为负,因其不含POS挖矿收益.</b></td></tr>";					
				echo "</table>";
		
	}
	
	else echo "$address 余额太小未录入或地址有误！具体可咨询网站管理员！";
?>
</div>
<div class="span5">

<div align="right">
<script type="text/javascript">
    var cpro_id = "u2823152";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>
</div>

</div>

</div>
<div>
<?php
		
	echo "<h3>相关交易记录:</h3>
	<table class='table table-striped'>";
	$con = mysql_connect($db_host,$db_user,$db_pwd);
	if (!$con)
	{
		die('无法连接数据库: ' . mysql_error());
	}
	mysql_select_db($db_add, $con);
	$result = mysql_query("SELECT time,block,txid,valch FROM ".$tb_add." WHERE address='".$address."' ORDER BY time desc");//2016.9.14由于数据表中存在较多的重复数据,进行唯一性修复
	while($row = mysql_fetch_array($result))
	{
		
			$clean_bal += $row['valch'];
			if($row['valch'] >0) $real_ots += $row['valch'];
			else $real_ins += $row['valch'];
			echo "<tr><td colspan='2'>".$row['time']."&nbsp;"."<a href='./?b=".$row['block']."'>".$row['block']."</a>&nbsp;"."<a href='./?tx=".$row['txid']."'>".$row['txid']."</a>&nbsp;".$row['valch']."&nbsp;".$curr_code."</td></tr>";
			$isex = true;
		
	}	
	echo "</table>";
	
?>


</div>

