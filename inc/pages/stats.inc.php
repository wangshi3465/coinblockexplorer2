<?php
$get_info = $_SESSION[$rpc_client]->getinfo();

$now_time = date("Y-m-d H:i:s e");
$start_time = date("Y-m-d H:i:s e", $launch_time);
$time_diff = get_time_difference($start_time, $now_time);

?>
<div class="container">
<h1>&nbsp;网络状态</h1>
<div class="span5">

<table class="table table-striped">
<tr><td>
  <b>最新版本:</b></td><td>
  <?php echo $get_info['version']; ?>
</td></tr><tr><td>
  <b>协议版本:</b></td><td>
  <?php echo $get_info['protocolversion']; ?>
</td></tr><tr><td>
  <b>货币总量:</b></td><td>
  <?php echo $total_coin.' '.$curr_code; ?>
</td></tr><tr><td>
  <b>在线节点数:</b></td><td>
  <?php echo $get_info['connections']; ?> 
</td></tr><tr><td>
  <b>最新区块:</b></td><td>
  <?php echo $get_info['blocks']; ?>
</td></tr><tr><td>
  <b>平均区块时间:</b></td><td>
  <?php echo '60'.' 秒'; ?>
</td></tr><tr><td>
  <b>当前POS难度:</b></td><td>
  <?php echo $get_info['difficulty']; ?>
</td></tr><tr><td>
  <b>运行时间:</b></td><td>
  <?php echo round($get_info['blocks']/2/60/24, 2).' 天'; ?>
</td></tr>
</table>
</div>
<div align="right">
<script type="text/javascript">
    var cpro_id = "u2823152";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>
</div>

</div>