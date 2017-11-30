<?php
require_once(dirname(__FILE__).'/../../../lib/common.lib.php');
require_once(dirname(__FILE__).'/../../config.inc.php');

session_start();

$getinfo = $_SESSION[$rpc_client]->getinfo();
$newest_hash = $_SESSION[$rpc_client]->getblockhash($getinfo['blocks']);
$newest_block = $_SESSION[$rpc_client]->getblock($newest_hash);

rpc_error_check();
$block[0] = $newest_block;
$txs = array();

echo '<h3>最新区块</h3>

<table class="table table-striped">
<tr>
  <th>区块高度</th>
  <th>时间</th>
  <th>难度</th>
  <th>随机数</th>
  <th>交易数量</th>
  <th>大小 (kB)</th>
</tr>';

echo "<tr><td><a href='./?block=".$newest_block['hash'].
"'>".$newest_block['height']."</a></td><td>".
date("Y-m-d H:i:s", $newest_block['time']).
"</td><td>".$newest_block['difficulty'].
"</td><td>".$newest_block['nonce'].
"</td><td>".count($newest_block['tx']).
"</td><td>".round($newest_block['size']/1024, 2).
"</td></tr>";

foreach ($newest_block['tx'] as $key => $value) {
  $txs[] = $value;
}

for ($i=1;$i<6;$i++) {

  $block[$i] = $_SESSION[$rpc_client]->getblock($block[$i-1]['previousblockhash']);
  
  echo "<tr><td><a href='./?block=".$block[$i]['hash'].
  "'>".$block[$i]['height']."</a></td><td>".
  date("Y-m-d H:i:s", $block[$i]['time']).
  "</td><td>".$block[$i]['difficulty'].
  "</td><td>".$block[$i]['nonce'].
  "</td><td>".count($block[$i]['tx']).
  "</td><td>".round($block[$i]['size']/1024, 2).
  "</td></tr>";
  
  foreach ($block[$i]['tx'] as $key => $value) {
    $txs[] = $value;
  }
}

echo '</table>';
$tx = array();
$count = 0;

echo '<h3>最新交易</h3>

<table class="table table-striped table-condensed">
<tr>
  <th>交易编号</th>
  <th>时间</th>
  <th>数量</th>
</tr>';

foreach ($txs as $key => $value) {

  if ($count > 12) { break; }
  $tx[$key] = $_SESSION[$rpc_client]->getrawtransaction($value, 1);
  if (!$show_cbtxs && $tx[$key]['vin'][0]['coinbase'] === true) { continue; }
  $total = '';
  
  foreach ($tx[$key]['vout'] as $k => $value) {
    if (!isset($tx[$k]['limit'])) {
      $total = bcadd($total, remove_ep($value['value']));
	}
  }
  
  $tx_time = date("Y-m-d H:i:s", $tx[$key]['time']);
  $tx_age = get_time_difference($tx_time, date("Y-m-d H:i:s"));
  $count++;
	
  if ($tx_age['seconds'] < 1) {
    $tx_age = '< 1 second';
  } elseif ($tx_age['minutes'] < 1) {
    $tx_age = $tx_age['seconds'].' seconds';
  } else {
    $tx_age = $tx_age['minutes'].' minutes';
  }
  $total = number_format($total,8);
  if($total>0)
  echo "<tr><td><a href='./?tx=".$tx[$key]['txid'].
       "'>".$tx[$key]['txid']."</a></td><td>".$tx_age.
       "</td><td>".$total.' '.$curr_code."</td></tr>";
}

echo '</table>';
?>
