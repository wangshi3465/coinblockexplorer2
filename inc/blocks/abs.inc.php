<?php
$get_info = $_SESSION[$rpc_client]->getinfo();
?>
	<div class="container">
		<div id="abs">
				<div class="abs-150">
					<div class="abs-30"><b>中文名</b></div>
					<div class="abs-50"><h3><?php echo $curr_name; ?></h3></div>
				</div>
				<div class="abs-150">
					<div class="abs-30"><b>英文简称</b></div>
					<div class="abs-50"><h3><?php echo $curr_code; ?></h3></div>
				</div>
				<div class="abs-img"> 
					<img src="./img/coinlogo.png" class="img-circle"> 
				</div>
				<div class="abs-150">
					<div class="abs-30"><b>算法</b></div>
					<div class="abs-50"><h3><?php echo $curr_alg; ?></h3></div>					
				</div>
				<div class="abs-150">
					<div class="abs-30"><b>总量</b></div>
					<div class="abs-50"><h3><?php echo $total_coin; ?></h3></div>					
				</div>
		</div>	
	</div>

