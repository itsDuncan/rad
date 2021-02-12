<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">

	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<link rel="stylesheet" href="css/dtech/bootstrap.min.css">
	<link rel="stylesheet" href="css/dtech/style.css">

	<title>GwijiNet</title>
</head>

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<body>

	<?php
		include_once ("lang/main.php");
		$m_active = "Accounting";
		include_once ("include/menu/menu-items.php");
	?>

	<div id="wrapper">
		<div id="innerwrapper" class="main-section d-flex">

			<div class="bg-light border-right" id="sidebar-wrapper">
				<div class="sidebar-heading">Accounting</div>

				<small class="sidebar-subheading">Hotspots Accounting</small>

				<div class="list-group list-group-flush">
					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.accthotspot.submit();"><?php echo t('button','HotspotAccounting') ?><a>
						<form name="accthotspot" action="acct-hotspot-accounting.php" method="post" class="sidebar">
							<select class="form-control" name="hotspot" size="3">
								<?php

								include 'library/opendb.php';
								
								$sql = "select name from ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']."";
								$res = $dbSocket->query($sql);

								while($row = $res->fetchRow()) {
									echo "
									<option value='$row[0]'> $row[0]
									";

								}

								include 'library/closedb.php';

								?>	
							</select>
						</form>
					</div>
					<div class="list-group-item list-group-item-action bg-light">
						<a href="acct-hotspot-compare.php"><?php echo t('button','HotspotsComparison') ?>
						</a>
					</div>
				</div>
			</div>

