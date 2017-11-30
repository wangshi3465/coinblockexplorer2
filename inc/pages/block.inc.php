<?php
if (isset($_GET['b'])) {
  $bnumb = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['b']));
  $bhash = $_SESSION[$rpc_client]->getblockhash(abs($bnumb));
  if (!empty($bhash)) {
    $block = $_SESSION[$rpc_client]->getblock($bhash);
	$chain_info = "<sup class='main_info'>[主链]</sup>";
  } else {
	$break = true;
  }
} elseif (isset($_GET['block'])) {
  $bhash = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['block']));
  $block = $_SESSION[$rpc_client]->getblock($bhash);
  if (!empty($block)) {
    $chash = $_SESSION[$rpc_client]->getblockhash($block['height']);
	if ($bhash === $chash) {
	  $chain_info = "<sup class='main_info'>[主链]</sup>";
	} else {
	  $chain_info = "<sup class='orphan_info'>[orphan chain]</sup>";
	}
  } else {
	$break = true;
  }
}

if (!isset($break) || rpc_error_check(false)) {

	echo "<h1><a href='./?b=".$block['height']."'>区块 #".$block['height']."</a> $chain_info</h1>";
	echo "<div class='row-fluid'><div class='span5'>";
	echo "<h3>概要:</h3><table class='table table-striped table-condensed'>";
	echo "<tr><td><b>版本:</b></td><td>".$block['version']."</td></tr>";
	echo "<tr><td><b>大小:</b></td><td>".round($block['size']/1024, 2)." kB</td></tr>";
	echo "<tr><td><b>交易:</b></td><td>".count($block['tx'])."</td></tr>";
	echo "<tr><td><b>确认:</b></td><td>".$block['confirmations']."</td></tr>";
	echo "<tr><td><b>难度:</b></td><td>".$block['difficulty']."</td></tr>";
	echo "<tr><td><b>随机数:</b></td><td>".$block['nonce']."</td></tr>";
	echo "<tr><td><b>时间戳:</b></td><td>".date("Y-m-d H:i:s", $block['time'])."</td></tr>";
	echo "</table>";

	echo '</div><div class="span7">';
	echo '<h3>哈希:</h3><table class="table table-striped">';
	if (isset($block['previousblockhash'])) {
	  echo "<tr><td><b>前一区块:</b></br><a href='./?block=".
	  $block['previousblockhash']."'>".$block['previousblockhash']."</a></td></tr>";
	}
	if (isset($block['nextblockhash'])) {
	  echo "<tr><td><b>后一区块:</b></br><a href='./?block=".
	  $block['nextblockhash']."'>".$block['nextblockhash']."</a></td></tr>";
	}
	echo "<tr><td><b>区块哈希:</b></br><a href='./?block=".$block['hash']."'>".$block['hash']."</a></td></tr>";
	echo "<tr><td><b>检验哈希:</b></br>".$block['proofhash']."</td></tr>";
	echo "<tr><td><b>根节点:</b></br>".$block['merkleroot']."</td></tr>";
	echo '</table></div></div>';

	echo "<h3>交易:</h3>
	<table class='table'>";

	foreach ($block['tx'] as $key => $txid) {
	  $tx = $_SESSION[$rpc_client]->getrawtransaction($txid,1);
	  
	  if (!empty($tx)) {
		$in_total = 0;
		$out_total = 0;
		
		
		echo "<tr><td colspan='2'><a href='./?tx=$txid'>$txid</a></td><td colspan='2' style='text-align:right'>".
			 date("Y-m-d H:i:s", $tx['time'])."</td></tr><tr><td style='vertical-align:middle'>";	
	    if (count($tx['vin']) > 0) {
		  foreach ($tx['vin'] as $key => $value) {
		    if(isset($value['coinbase']))
			   echo "挖矿生成的交易";
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
			                echo "<a href='./?address=".$add_value_vin[0]."'>".$add_value_vin[0].
				            "</a>:</br><span class='happy_txt'><b>$clean_val_vin</b></span>&nbsp;$curr_code</br>";
							}
		                }
			        }		
		        }
			}
		  }
	    }
	    else {
		  $in_total = 0;
		  echo "交易不存在<br />";
	    }
		
		echo "<br /></td><td style='vertical-align:middle'>
		<i class='icon-arrow-right'></i><br /><br />
		</td><td style='vertical-align:middle'>";
		
		$add_play_out = '';//地址显示
		$dig_flag_out = false;//默认不是挖矿
        $fee_name = "转帐手续费";//手续费还是挖矿所得
		$pos_name = "";
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
		  //else if(!$dig_flag_out){
		     foreach ($value['scriptPubKey'] as $add_value){
			 if(is_array($add_value))
			  echo "<a href='./?address=".$add_value[0]."'>".$add_value[0].
				   "</a>:</br><span class='happy_txt'><b>$clean_val</b></span>&nbsp;$curr_code</br>";
		     }
			//}

		}
		if($dig_flag_out && $out_total!=0){
		//echo "<a href='./?address=".$add_play_out."'>".$add_play_out.
		//		   "</a>:</br><span class='happy_txt'><b>$out_total</b></span>&nbsp;$curr_code</br>";
		$fee_name = "POS挖矿所得";		 
		$dig_flag_out = false;
		$add_play_out = '';
		}
		
		$fee = (($in_total===0)?'0':bcsub($out_total, $in_total,8));
		if(($fee-70) >= 0){
			$fee = $fee-14;
			$fee_name = "主节点挖矿";
			$pos_name = "POS挖矿所得: 14 JRG";
			
		}
		//$fee = number_format($fee,8);
		//$amount = number_format($out_total,8);
		echo "<br /></td><tr><td style='vertical-align:middle'>
		<b>总数量:&nbsp;$out_total&nbsp;$curr_code &nbsp;
		<b>$fee_name:&nbsp;</b>$fee&nbsp;$curr_code&nbsp;&nbsp;$pos_name</br></br></td></tr></tr>";
	  }
	}
	
	echo "</table>";
} 
else {
  echo "<p>指定区块未找到.</p>";
}
?>
<div align="center">
<script type="text/javascript">
    var cpro_id = "u2823160";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>
</div>