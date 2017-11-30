<div class="navbar navbar-fixed-top">
	<div class="container">
		<div class="navbar-inner">
			<ul class="nav">
				<li ><img src="./img/logo.png"></li>
				<li ><a href="./"><i class="icon-home"></i><b>主页</b></a></li>
				<li><a href="./?page=masternode"><b>主节点</b></a></li>
				<li><a href="./?page=stats"><b>状态</b></a></li>

				<li><a href="<?php echo $curr_offweb; ?>" target="_blank"><b>官网</b></a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" ><b>交易网站</b></a>
						<ul class="dropdown-menu">
							<li><a href="http://www.coin78.com/?invit=DXJGZY" target="_blank"><b>币兴网</b></a></li>
							<li><a href="http://bitcny.cc/?invit=MIZHDE" target="_blank"><b>区块网</b></a></li>	
							
						</ul>					
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" ><b>水龙头等</b></a>
						<ul class="dropdown-menu">
							<li><a href="http://f.fiyea.com" target="_blank">水龙头</a></li>
							<li><a href="./?page=api"><b>API</b></a></li>														
						</ul>					
				</li>
			</ul>
			<form class="navbar-search pull-right" method="get" action="./index.php">
				<input type="hidden" name="page" value="search" />
				<input type="text" class="search-query" name="q" maxlength="99" placeholder="查询区块高度,交易编号或钱包地址">
			</form>
			
		</div>
	</div>
</div>
</div>
