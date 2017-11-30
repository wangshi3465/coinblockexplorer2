<?php
if (isset($_GET['q'])) {
  $qstr = preg_replace("/[^a-z0-9]/i", '', $_GET['q']);
  $qlen = strlen($qstr);
  if ($qlen >= 64) {
    $tx = $_SESSION[$rpc_client]->getrawtransaction($qstr);
    if (!empty($tx) && empty($_SESSION[$rpc_client]->error)) {
	  redirect("./?tx=$qstr");
	} else {
	  redirect("./?block=$qstr");
	}
  } else {
    if (is_numeric($qstr)) {
	  redirect("./?b=$qstr");
	} else {
	  redirect("./?address=$qstr"); 
	}
  }
  

  
  
} else {
?>
<h1>&nbsp;查询区块链</h1>
<div class="span5">


<form name="search_form" class="form-horizontal" method="get" action="./">
  <h3>查询地址 <small>请输入有效的钱包地址</small></h3>
  <input type="text" class="long_input" name="address" value="" maxlength="34" />
  <input type="submit" class="btn" value="Search" />
  
</form>

<form name="search_form" class="form-horizontal" method="get" action="./">
  <h3>查询交易编号 <small>请输入有效的交易编号</small></h3>
  <input type="text" class="long_input" name="tx" value="" maxlength="64" />
  <input type="submit" class="btn" value="Search" />
</form>
  
<form name="search_form" class="form-horizontal" method="get" action="./">
  <h3>查询区块哈希 <small>请输入有效的区块哈希</small></h3>
  <input type="text" class="long_input" name="block" value="" maxlength="64" />
  <input type="submit" class="btn" value="Search" />
</form>
</div>
<div align="right">
<script type="text/javascript">
    var cpro_id = "u2823152";
</script>
<script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>
</div>

<?php
}
?>