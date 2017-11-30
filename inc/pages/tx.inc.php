
	<h1>&nbsp;&nbsp;&nbsp;        交易细节</h1>

<div class="span8">
<?php
$tx_id = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['tx']));
$tx = $_SESSION[$rpc_client]->getrawtransaction($tx_id, 1);
echo "<div class='span8'>";
if (rpc_error_check(false)) {
	$input_str = '';
	$output_str = '';
	$in_total = 0;
	$out_total = 0;
	
	  if (count($tx['vin']) > 0) {
		  foreach ($tx['vin'] as $key => $value) {
		    if(isset($value['coinbase']))
			   $input_str .= "挖矿生成的交易<br />";
		    else {
			    $txid_vin = $value['txid'];
			    $tx_vin = $_SESSION[$rpc_client]->getrawtransaction($txid_vin,1);
					
			foreach ($tx_vin['vout'] as $key => $value_vin) {
		            $clean_val_vin = remove_ep($value_vin['value']);	
		            if($clean_val_vin == 0) ;
				    //echo "挖矿<br />";
		            else{
		                foreach ($value_vin['scriptPubKey'] as $add_value_vin){
			                if(is_array($add_value_vin) && ($value_vin['n'] === $value['vout'])){
							$in_total = bcadd($in_total, $clean_val_vin,8);
			                $input_str .= "<a href='./?address=".$add_value_vin[0]."'>".$add_value_vin[0].
				            "</a>:&nbsp;<span class='happy_txt'>$clean_val_vin</span>&nbsp;$curr_code<br />";
							}
		                }
			        }		
		        }
			}
		  }
	    }
	    else {
		  $total_in = 0;
		  echo "交易不存在<br />";
	    }
		
		
		$add_play_out = '';//地址显示
		$dig_flag_out = false;//默认不是挖矿
        $fee_name = "手续费";//手续费还是挖矿所得
		foreach ($tx['vout'] as $key => $value) {
		  $clean_val = remove_ep($value['value']);
		  $out_total = bcadd($out_total, $clean_val,8);
		  if($clean_val == 0) {
		     $dig_flag_out = true;
		     //echo "&nbsp;<span class='sad_txt'>$clean_val</span>&nbsp;$curr_code<br />";
		    }
		  else if($dig_flag_out){
			 foreach ($value['scriptPubKey'] as $add_value) $add_play_out = $add_value[0];
			}
		 // else if(!$dig_flag_out){
		     foreach ($value['scriptPubKey'] as $add_value){
			 if(is_array($add_value))
			  $output_str .= "<a href='./?address=".$add_value[0]."'>".$add_value[0].
				   "</a>:&nbsp;<span class='happy_txt'>$clean_val</span>&nbsp;$curr_code<br />";
		     }
			//}

		}
		if($dig_flag_out && $out_total!=0){
		//$output_str .= "<a href='./?address=".$add_play_out."'>".$add_play_out.
		//		   "</a>:&nbsp;<span class='happy_txt'>$out_total</span>&nbsp;$curr_code<br />";
		$fee_name = "POS挖矿所得";		 
		$dig_flag_out = false;
		$add_play_out = '';
		}
	
		


	echo "<table class='table table-striped table-condensed' style='width:auto;'>";	
	echo "<tr><td><b>交易编号:</b></td><td><a href='./?tx=".
		 $tx['txid']."'>".$tx['txid']."</a></td></tr>";
		 
	if (isset($tx['blockhash'])) {
	  echo "<tr><td><b>区块:</b></td><td><a href='./?block=".
	       $tx['blockhash']."'>".$tx['blockhash']."</a></td></tr>";
	} else {
	  echo "<tr><td><b>区块:</b></td><td>未在区块中</td></tr>";
	}
	
	$tx_time = isset($tx['time']) ? date("Y-m-d H:i:s", $tx['time']) : 'unknown';
	$confirmations = isset($tx['confirmations']) ? $tx['confirmations'] : '0';
	$tx_message = empty($tx['msg']) ? 'none' : safe_str($tx['msg']);
	$tx_fee = ($in_total === 0) ? '0' : bcsub($out_total,$in_total,8);
	$pos_b=0;
	if(($tx_fee-70) >= 0){
			$tx_fee = $tx_fee-14;
			$fee_name = "主节点挖矿";
			$pos_b=14;
			
		}
	else $pos_b= 0;
	echo "<tr><td><b>发送时间:</b></td><td>$tx_time</td></tr>";
	echo "<tr><td><b>确认数量:</b></td><td>$confirmations</td></tr>";
	echo "<tr><td><b>锁定时间:</b></td><td>".$tx['locktime']."</td></tr>";
	echo "<tr><td><b>总输入:</b></td><td>$in_total $curr_code</td></tr>";
	echo "<tr><td><b>总输出:</b></td><td>$out_total $curr_code</td></tr>";
	echo "<tr><td><b>$fee_name:</b></td><td>$tx_fee $curr_code</td></tr>";
	echo "<tr><td><b>POS利息:</b></td><td>$pos_b $curr_code</td></tr>";
	echo "<tr><td><b>消息:</b></td><td>$tx_message</td></tr>";
	echo "</table>";
	
	echo "<h3>输入:</h3><p>$input_str</p>";	
	echo "<h3>输出:</h3><p>$output_str</p>";
}
	echo "</div>";
	echo "<div class='span4'>";
	echo "</div>";

?>
</div>
<div align="right">
<script type="text/javascript">
    var cpro_id = "u2823154";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>
</div>

