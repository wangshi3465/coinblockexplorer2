	<hr />
    <div id="footer">
	  <?php
	  if (empty($getinfo)) {
		$status = 'offline';
		$getinfo['connections'] = 0;
	  } else {
	    $status = '已同步';
	  }
	  ?>
      网络状态: <a href="./?page=stats"><?php echo $status; ?></a> | 节点数量: <a href="./?page=peers"><?php echo $getinfo['connections']; ?></a> 捐助:<b><?php echo $cb_addr; ?></b></br>
	  &copy; <a href="http://www.fiyea.com" target="_blank">菲亚</a>—领先的中文区块浏览器综合网站! <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=516848390&site=qq&menu=yes">添加新币种？</a> 菲亚区块链QQ群:<a target="_blank" href="http://jq.qq.com/?_wv=1027&k=2EbqgWO">481457267</a>
	  <br />友情链接：<a href="http://fiyea.com" target="_blank">菲亚社区</a> <a href="http://f.fiyea.com" target="_blank">免费领币水龙头</a> <a href="http://bitfun.us" target="_blank">BitFun比特娱乐</a> <a href="https://www.btc9.com/Reg/index/m/1509.html" target="_blank">币久网</a>  <a href="http://8xsz.com" target="_blank">八喜数字网</a> <a href="http://www.yuanbao.com/So5vR2" target="_blank">元宝网</a> <a href="http://www.jubi.com/i_ujipcz" target="_blank">聚币网</a> <a href="http://www.btc38.com" target="_blank">比特时代</a> <a href="https://www.bichuang.com/user/register.html?uid=24503" target="_blank">币创网</a>
			<a href="http://www.yunbi.com" target="_blank">云币网</a> <a href="http://www.poloniex.com" target="_blank">P网</a>
	  <br />免责声明:菲亚是一家专业的数字货币区块浏览器综合网站,仅提供区块查询相关服务,与币种发行方无任何关系!  <a href="http://www.miitbeian.gov.cn" target="_blank">粤ICP备13078058号-1</a>
	  <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1258814783'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1258814783%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
	  </p>
	</div>
