<?php
if (empty($_GET['q'])) { ?>

<h1>Query API(试运行)</h1><hr />

<div class="row-fluid">
  <div class="span5">

	<h3>Network Data</h3>
	<p>
	  <a href="./?q=getdifficulty">getdifficulty(可用)</a> - current mining difficulty<br />
	  <a href="./?q=getblockcount">getblockcount(可用)</a> - current block height<br />
	  <a href="./?q=getlasthash">getlasthash(可用)</a> - hash of latest block
	</p>

	<h3>Coin Data</h3>
	<p>
	  <a href="./?q=blockreward">blockreward</a> - current block reward<br />
	  <a href="./?q=moneysupply">moneysupply(可用)</a> - total coins mined<br />
	  <a href="./?q=unminedcoins">unminedcoins</a> - total unmined coins<br />
	  <a href="./?q=runtime">runtime</a> - time since first block (secs)
	</p>

	<h3>Transaction Data</h3>
	<p>
	  <a href="./?q=txinput">txinput</a>/TxHash - total tx input value<br />
	  <a href="./?q=txoutput">txoutput</a>/TxHash - total tx output value<br />
	  <a href="./?q=txfee">txfee</a>/TxHash - tx fee value (inputs - outputs)<br />
	  <a href="./?q=txcount">txcount</a> - number of tx's in blockchain
	</p>

	<h3>Address Data</h3>
	<p>
	  <a href="./?q=addressbalance">addressbalance(可用)</a>/Address/Confs - balance of address<br />
	  <a href="./?q=addresslimit">addresslimit</a>/Address/Confs - withdrawal limit of address<br />
	  <a href="./?q=addresslastseen">addresslastseen</a>/Address - block when address last used<br />
	  <a href="./?q=addresscount">addresscount</a> - number of non-empty addresses
	</p>

	<h3>JSON Data</h3>
	<p>
	  <a href="./?q=getinfo">getinfo(可用)</a> - general information<br />
	  <a href="./?q=txinfo">txinfo</a>/TxHash - transaction information<br />
	  <a href="./?q=addressinfo">addressinfo</a>/Address/Confs - address information<br />
	  <a href="./?q=blockinfo">blockinfo</a>/BlockHash - block information
	</p>
	<h3>Others</h3>
	<p>
	  <a href="./?q=uptime">uptime(可用)</a> - data update time<br />
	</p>
  </div>
  <div class="span7">

	<h2>部分API使用方法</h2>
	<p>获取当前网络难度:</p>
	<pre>/?q=getdifficulty</pre>
	<p>获取当前区块高度:</p>
	<pre>/?q=getblockcount</pre>
	<p>获取当前区块hash:</p>
	<pre>/?q=getblockhash</pre>
	<p>获取当前全网币数:</p>
	<pre>/?q=moneysupply</pre>
	<p>获取指定钱包余额(参数arg1即为地址,例如UkDMjGipAe3faDUMx6CNCjBXXpBXQ1qE14):</p>
	<pre>/?q=addressbalance&amp;arg1=UkDMjGipAe3faDUMx6CNCjBXXpBXQ1qE14</pre>
	<p>或者:</p>
	<pre>/q/addressbalance/UkDMjGipAe3faDUMx6CNCjBXXpBXQ1qE14</pre>
	<p><b>注意:钱包余额非实时,有一定延迟;请勿频繁调用API</b></p>
	
  </div>
  <div class="span7">
<script type="text/javascript">
    var cpro_id = "u2823158";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>

  </div>
</div>

<?php
} else {
  $q = preg_replace("/[^a-z]/", '', strtolower($_GET['q']));
  
  switch ($q) {
    case 'getdifficulty': ////////////////////////////////////////////
	  $mining_info = $_SESSION[$rpc_client]->getmininginfo();
	  $result = $mining_info['difficulty'];
      break;
    case 'gethashrate': ////////////////////////////////////////////
	  $mining_info = $_SESSION[$rpc_client]->getmininginfo();
	  $result = $mining_info['networkhashps'];
      break;
    case 'getblockcount': ////////////////////////////////////////////
	  $mining_info = $_SESSION[$rpc_client]->getmininginfo();
      $result = $mining_info['blocks'];
      break;
    case 'getlasthash': ////////////////////////////////////////////
	  $b=$_SESSION[$rpc_client]->getmininginfo();
	  $c= $b['blocks'];
      $result = $_SESSION[$rpc_client]->getblockhash($c);
      break;	  
    case 'blockreward': ////////////////////////////////////////////
	  $balance = $_SESSION[$rpc_client]->listbalances(1, array($cb_address));
      $cb_balance = remove_ep($balance[0]['balance']);
      $frac_reman = bcdiv($cb_balance, $total_coin);
      $result = bcmul($first_reward, $frac_reman);
      break;
    case 'moneysupply': ////////////////////////////////////////////
      $tx_stats = $_SESSION[$rpc_client]->getinfo();
      $result = $tx_stats['moneysupply'];
      break;
    case 'unminedcoins': ////////////////////////////////////////////
	  $balance = $_SESSION[$rpc_client]->listbalances(1, array($cb_address));
      $result = remove_ep($balance[0]['balance']);
      break;
    case 'runtime': ////////////////////////////////////////////
      $now_time = date("Y-m-d H:i:s e");
	  $start_time = date("Y-m-d H:i:s e", $launch_time);
	  $time_diff = get_time_difference($start_time, $now_time);
	  $result = $time_diff['seconds'];
      break;  
    case 'txinput': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('tx hash not specified');
	  } else {
        $tx_id = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['arg1']));
        $tx = $_SESSION[$rpc_client]->getrawtransaction($tx_id, 1);
	    $total_in = '0';
	    if (count($tx['vin']) > 0) {
	      foreach ($tx['vin'] as $key => $value) {
	        $clean_val = remove_ep($value['value']);
	        $total_in = bcadd($total_in, $clean_val);
	      }
	    } else {
	      $total_in = '0';
	    }
	    $result = $total_in;
        break;
	  }
    case 'txoutput': ////////////////////////////////////////////
      $tx_id = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['arg1']));
      $tx = $_SESSION[$rpc_client]->getrawtransaction($tx_id, 1);
	  $total_out = '0';
	  foreach ($tx['vout'] as $key => $value) {
	    $clean_val = remove_ep($value['value']);
	    $total_out = bcadd($total_out, $clean_val);
	  }
	  $result = $total_out;
      break;
    case 'txfee': ////////////////////////////////////////////
      $tx_id = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['arg1']));
      $tx = $_SESSION[$rpc_client]->getrawtransaction($tx_id, 1);
	  $total_in = '0';
	  $total_out = '0';
	  if (count($tx['vin']) > 0) {
	    foreach ($tx['vin'] as $key => $value) {
	      $clean_val = remove_ep($value['value']);
	      $total_in = bcadd($total_in, $clean_val);
	    }
	  } else {
	    $total_in = '0';
	  }
	  foreach ($tx['vout'] as $key => $value) {
	    $clean_val = remove_ep($value['value']);
	    $total_out = bcadd($total_out, $clean_val);
	  }
	  $result = bcsub($total_in, $total_out);
      break;
    case 'txcount': ////////////////////////////////////////////
      $l_dat = explode(':', file_get_contents("./db/last_dat"));
	  $result = $l_dat[1];
      break;  
    case 'addressbalance': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('address was not specified');
	  } else {
       // $address = preg_replace("/[^a-z0-9]/i", '', $_GET['arg1']);
       // $confs = empty($_GET['arg2']) ? 1 : (int)$_GET['arg2'];
      //  $ainfo = $_SESSION[$rpc_client]->listbalances($confs, array($address));
      //  $result = remove_ep($ainfo[0]['balance']);
		$address = preg_replace("/[^a-z0-9]/i", '', $_GET['arg1']);
		$clean_bal = 0;
		$isex = false;
		$con = mysql_connect($db_host,$db_user,$db_pwd);
		if (!$con)
		{
			die('无法连接数据库: ' . mysql_error());
		}
		mysql_select_db($db_add, $con);
		$result = mysql_query("SELECT DISTINCT time,block,txid,address,valch FROM ".$tb_add);	//2016.9.14由于数据表中存在较多的重复数据,进行唯一性修复
		while($row = mysql_fetch_array($result))
		{
			if($row['address'] == $address){
				$clean_bal += $row['valch'];
				$isex = true;
			}
		} 
		if($isex) $result = $clean_bal;
		else $result=0;
		mysql_close($con);
        break;
	  }
    case 'addresslimit': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('address was not specified');
	  } else {
        $address = preg_replace("/[^a-z0-9]/i", '', $_GET['arg1']);
        $confs = empty($_GET['arg2']) ? 1 : (int)$_GET['arg2'];
        $ainfo = $_SESSION[$rpc_client]->listbalances($confs, array($address));
        $result = remove_ep($ainfo[0]['limit']);
        break;
	  }
    case 'addresslastseen': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('address was not specified');
	  } else {
        $address = preg_replace("/[^a-z0-9]/i", '', $_GET['arg1']);
        $confs = empty($_GET['arg2']) ? 1 : (int)$_GET['arg2'];
        $ainfo = $_SESSION[$rpc_client]->listbalances($confs, array($address));
        $balance = remove_ep($ainfo[0]['balance']);
	    if (clean_number($balance) === '0') {
		  $last_used = 'unknown';
	    } else {
		  $last_used = $ainfo[0]['age'];
	    }
	    $result = $last_used;
		break;
	  }
    case 'addresscount': ////////////////////////////////////////////
      $tx_stats = $_SESSION[$rpc_client]->gettxoutsetinfo();
	  $result = $tx_stats['accounts'];
      break;
    case 'getinfo': ////////////////////////////////////////////
	  $ginfo = $getinfo;
	  unset($ginfo['balance']);
	  unset($ginfo['proxy']);
	  unset($ginfo['keypoololdest']);
	  unset($ginfo['keypoolsize']);
	  unset($ginfo['paytxfee']);
	  header('Content-Type: application/json');
	  echo json_encode($ginfo);
      exit;
    case 'txinfo': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('tx hash not specified');
	  } else {
        $tx_id = preg_replace("/[^a-f0-9]/", '', strtolower($_GET['arg1']));
        $tinfo = $_SESSION[$rpc_client]->getrawtransaction($tx_id, 1);
        header('Content-Type: application/json');
	    echo json_encode($tinfo);
        exit;
	  }
    case 'addressinfo': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('address not specified');
	  } else {
        $address = preg_replace("/[^a-z0-9]/i", '', $_GET['arg1']);
        $confs = empty($_GET['arg2']) ? 1 : (int)$_GET['arg2'];
        $ainfo = $_SESSION[$rpc_client]->listbalances($confs, array($address));
	    unset($ainfo[0]['ours']);
	    unset($ainfo[0]['account']);
        header('Content-Type: application/json');
        echo json_encode($ainfo[0]);
        exit;
	  }
    case 'blockinfo': ////////////////////////////////////////////
	  if (empty($_GET['arg1'])) {
	    die('block hash not specified');
	  } else {
        $block = $_SESSION[$rpc_client]->getblock($_GET['arg1']);
        header('Content-Type: application/json');
        echo json_encode($block);
        exit;
	  }
	case 'uptime': ////////////////////////////////////////////
		$file_time = dirname(dirname(dirname(__FILE__)))."/db/curtime.txt";//更新时间
		$upd_time =  file_get_contents($file_time);
        echo $upd_time;
        exit;
    default: ////////////////////////////////////////////
       die('unknown command');
  }
  if (rpc_error_check() && $result !== '') {
    echo $result;
  }
}
?>
