<h1>内存池</h1>
<br />

<table class="table table-striped table-condensed">
<tr>
  <th>交易编号</th>
  <th>发送数量</th>
</tr>

<?php
$tx_ids = $_SESSION[$rpc_client]->getrawmempool();

if (empty($tx_ids)) {
  echo "<tr><td colspan='2'>当前内存池为空.</td></tr>";
} else {

	$tx = array();

	foreach ($tx_ids as $key => $value) {

	  $tx[$key] = $_SESSION[$rpc_client]->getrawtransaction($value, 1);
	  $total = '';
	  
	  foreach ($tx[$key]['vout'] as $k => $value) {
		if (!isset($tx[$k]['limit'])) {
		  $total = bcadd($total, remove_ep($value['value']));
		}
	  }
	  
	  echo "<tr><td><a href='./?tx=".$tx[$key]['txid'].
		   "'>".$tx[$key]['txid']."</a></td><td>".
		   $total.' '.$curr_code."</td></tr>";
	}
}
?>
</table>
