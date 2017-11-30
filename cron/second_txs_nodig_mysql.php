<?php
ini_set('memory_limit', -1);
ini_set('max_execution_time', 99999);
$timer_start = microtime(true);
require_once(dirname(__FILE__).'/../inc/config.inc.php');
require_once(dirname(__FILE__).'/../lib/common.lib.php');
$rpcint = new RPCclient($rpc_user, $rpc_pass);
//1.首次运行，必须首先运行./cron/mysql.php创建数据库！
	$b_cur = $rpcint->getblockcount();//first block,last block;rpcinterface;block_current
	$file_count = dirname(__FILE__)."/../db/count.txt";//计数文件，此文件需要新建
	$las_count = (int) file_get_contents($file_count);
	if(empty($las_count)) $las_count = 0;
	file_put_contents($file_count, $b_cur);//此时的区块数写入count.txt                        
	$b_index = $las_count + 1;//从上一次保存的区块开始,并检查数据库中当前的最后一条记录的区块
	$address = '';
	$b_time = '';
	$con = mysql_connect($db_host,$db_user,$db_pwd);//连接数据库	
	if (!$con){
		die('无法连接数据库: ' . mysql_error());
	}
while($b_index <= $b_cur){	
	$b_hash = $rpcint->getblockhash($b_index);
	while(!$b_hash){
		sleep(10);
		$b_hash = $rpcint->getblockhash($b_index);
	}
	$b_det = $rpcint->getblock($b_hash);//block detail
	while(!$b_det){
		sleep(10);
		$b_det = $rpcint->getblock($b_hash);
	}
	$b_time = date("Y-m-d H:i:s", $b_det['time']);
	foreach ($b_det['tx'] as $key => $b_txid){
		$tx = $rpcint->gettransaction($b_txid);
		while(!$tx){
			sleep(10);
			$tx = $rpcint->gettransaction($b_txid);
		}
	    $in_total = 0;
		$out_total = 0;		
		$add_play_out = '';//地址显示
		$dig_flag_out = false;//默认不是挖矿
		foreach ($tx['vout'] as $key => $value) {
		  $clean_val = remove_ep($value['value']);	
		  if($clean_val ==0) {
		     $dig_flag_out = true; 
		    }
		  else $dig_flag_out = false; //MGC单独增加,计算主节点收益
		  if(!$dig_flag_out && $clean_val>0.1 ){
				foreach ($value['scriptPubKey'] as $add_value){
					if(is_array($add_value)){
						$address = $add_value[0];  //
						$val_ch = $clean_val;//value change
						mysql_select_db($db_add, $con);
						mysql_query("INSERT INTO ".$tb_add." (time,block, txid, address,valch) 
						VALUES ('$b_time','$b_index','$b_txid','$address','$val_ch')");
					}
				}
				
			}
		}		
		if (count($tx['vin']) > 0) {
			$arr_add = array();
			$arr_val = array();
			$m = 0;
			$n = 0;
			$addtem = '';
			$valtem = 0;
			foreach ($tx['vin'] as $key => $value) {
				if(!isset($value['coinbase']) && !$dig_flag_out) {
					$txid_vin = $value['txid'];
					$tx_vin = $rpcint->gettransaction($txid_vin);
					while(!$tx_vin){
						sleep(10);
						$tx_vin = $rpcint->gettransaction($txid_vin);
					}
					foreach ($tx_vin['vout'] as $key => $value_vin) {					
						$clean_val_vin = remove_ep($value_vin['value']);
						if($clean_val_vin >= 1){
							foreach ($value_vin['scriptPubKey'] as $add_value_vin){
								if(is_array($add_value_vin) && ($value_vin['n'] === $value['vout'])){
									$addtem = $add_value_vin[0];
									$valtem = $clean_val_vin;
									if( $m== 0){
										$arr_add[$n] = $addtem;
										$arr_val[$n] = $valtem;
									}
									$i = 0;
									$issame = false;//相同吗？
									while($i<=$n && $m!=0){
										if($addtem == $arr_add[$i])
										{
											$arr_val[$i] += $valtem;
											$issame = true;
										}
										$i++;
									}
									if(!$issame && $m!=0){
										$n++;
										$arr_add[$n] = $addtem;
										$arr_val[$n] = $valtem;					
									}
									$m++;				
								}
							}
						}
					}		
				}
				
			}
			if(count($arr_add) > 0){
				for($j=0;$j<=$n;$j++){
					$address = $arr_add[$j];
					$val_ch = $arr_val[$j] * (-1);
					mysql_select_db($db_add, $con);
					mysql_query("INSERT INTO ".$tb_add." (time,block, txid, address,valch) 
					VALUES ('$b_time','$b_index','$b_txid','$address','$val_ch')");
				}	
			}
			unset($arr_add);
			unset($arr_val);
	    }		
	}
	$b_index++;	
}	
	mysql_close($con);
	echo "区块数据库更新完毕，时间：".date('y-m-d H:i:s',time());
	echo "最新区块：".$b_cur;
	$file_time = dirname(__FILE__)."/../db/curtime.txt";//执行当前的文件的时间
	file_put_contents($file_time, date('y-m-d H:i:s',time()));
?>
