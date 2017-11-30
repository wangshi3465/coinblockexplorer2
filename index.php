<?php
$index_call = true;
require_once('inc/common.inc.php');
require_once('inc/blocks/meta.inc.php');
?>
<body>

  <?php
  //include persistent menu
  require_once('inc/blocks/menu.inc.php');
  ?>
  
    <div id="wrapper">

  <div class="container">
    <?php
	
    //include persistent header
    require_once('inc/blocks/head.inc.php');

	// include page controller
	require_once('inc/control.inc.php');
	?>
	
  </div>
  <div class="container">
  <?php
  // include persistent footer
  require_once('inc/blocks/foot.inc.php');
  ?>
</div>
</body>
</html>
