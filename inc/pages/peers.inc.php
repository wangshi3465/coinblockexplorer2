<h1>网络节点</h1>
<br />

<table class="table table-striped table-condensed">
<tr>
  <th>IP地址</th>
  <th>端口</th>
  <th>服务</th>
  <th>版本</th>
  <th>已连接时间</th>
</tr>

<?php
$peers = $_SESSION[$rpc_client]->getpeerinfo();

if (empty($peers)) {
  echo "<tr><td colspan='5'>There are currently 0 connected peers.</td></tr>";
} else {
	foreach ($peers as $key => $value) {
      $ip_port = explode(':', $value["addr"]);
	  echo "<tr><td>".$ip_port[0]."</td>".
		   "<td>".$ip_port[1]."</td><td>".
		   $value["services"]."</td><td>".
		   $value["version"]."</td><td>".
		   date("Y-m-d h:i:s A e",
           $value["conntime"])."</td></tr>";
	}
}
?>
</table>

<script type="text/javascript">
    var cpro_id = "u2823160";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>

