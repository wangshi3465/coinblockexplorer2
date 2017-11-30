<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
	<title><?php safe_echo($site_name.' - '.$page_title); ?></title>
	
	
	<link rel="icon" type="image/png" href="./favicon.png" />
	<link rel="apple-touch-icon" href="./img/icons/apple-touch-icon.png" />
	<link rel="apple-touch-icon" size="72x72" href="./img/icons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" size="114x114" href="./img/icons/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" size="144x144" href="./img/icons/apple-touch-icon-144x144.png" />
		
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/boilerplate.css" />
	<link rel="stylesheet" href="./css/bootstrap.min.css" />
	<link rel="stylesheet" href="./css/custom18.css" />

	<!--[if lt IE 9]>
	<script src="js/html5shiv.min.js"></script>
	<![endif]-->
	<style type="text/css">
        td{font-size:14px;text-align:center;}
        .SortDescCss{background-image:url(./js/Desc.gif);background-repeat:no-repeat;background-position:right center;}
        .SortAscCss{background-image:url(./js/Asc.gif);background-repeat:no-repeat;background-position:right center;}
    </style>
	
	<script src="./js/modernizr-2.6.2.min.js"></script>
	<script src="./js/jquery-1.11.1.min.js"></script>
	<script src="./js/jquery.qrcode.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/general.lib.js"></script>
	<script src="./js/core.lib.js"></script>
	<script src="./js/plugins.js"></script>
	<script language="javascript" type="text/javascript" src="./js/TableSorterV2.js"></script>
	<script language="javascript" type="text/javascript">	
	window.onload = function()
	{
		new TableSorter("tb1");
	}
    </script>

</script>
</head>
	<?php 
			header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
			header("Cache-Control: no-cache, must-revalidate" ); 
	?>
<html>
