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

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<body>
	<?php
		include_once ("lang/main.php");
		$m_active = "Reports";
		include_once ("include/menu/menu-items.php");
	?>

	<div id="wrapper">
		<div id="innerwrapper" class="main-section d-flex">

			<div class="bg-light border-right" id="sidebar-wrapper">
				<div class="sidebar-heading">Logs</div>

				<small class="sidebar-subheading">Log Files</small>

				<div class="list-group list-group-flush">
					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.daloradius_log.submit();">
							<img src='images/icons/reportsLogs.png' border='0'>&nbsp;<?php echo t('button','daloRADIUSLog') ?>
						</a>

						<form name="daloradius_log" action="rep-logs-daloradius.php" method="get" class="sidebar">
							<select class="generic form-control" name="daloradiusLineCount" type="text">
								<?php if (isset($daloradiusLineCount)) {
									echo "<option value='$daloradiusLineCount'> $daloradiusLineCount Lines </option>";
								} else {
									echo "<option value='50'> 50 Lines Output Limit </option>";
								}
								?>
								<option value="50"></option>
								<option value="20"> 20 Lines </option>
								<option value="50"> 50 Lines </option>
								<option value="100"> 100 Lines </option>
								<option value="500"> 500 Lines </option>
								<option value="1000"> 1000 Lines </option>
							</select>
							<select class="generic form-control" name="daloradiusFilter" type="text">
								<?php if (isset($daloradiusFilter)) {
									if ($daloradiusFilter == ".") 
										echo "<option value='$daloradiusFilter'> Any </option>";
									else
										echo "<option value='$daloradiusFilter'> $daloradiusFilter </option>";
								} else {
									echo "<option value='.'> No filter </option>";
								}
								?>
								<option value="."></option>
								<option value="QUERY"> Query Only </option>
								<option value="NOTICE"> Notice Only </option>
								<option value="INSERT"> SQL INSERT Only </option> 
								<option value="SELECT"> SQL SELECT Only </option>
							</select>
						</form>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.radius_log.submit();">
							<img src='images/icons/reportsLogs.png' border='0'>&nbsp;<?php echo t('button','RadiusLog') ?>
						</a>
						<form name="radius_log" action="rep-logs-radius.php" method="get" class="sidebar">
							<select class="generic form-control" name="radiusLineCount" type="text">
								<?php if (isset($radiusLineCount)) {
									echo "<option value='$radiusLineCount'> $radiusLineCount Lines </option>";
								} else {
									echo "<option value='50'> 50 Lines Output Limit </option>";
								}
								?>
								<option value="50"></option>
								<option value="20"> 20 Lines </option> 
								<option value="50"> 50 Lines </option>
								<option value="100"> 100 Lines </option>
								<option value="500"> 500 Lines </option>
								<option value="1000"> 1000 Lines </option>
							</select>
							<select class="generic form-control" name="radiusFilter" type="text">
								<?php if (isset($radiusFilter)) {
									if ($radiusFilter == ".") 
										echo "<option value='$radiusFilter'> Any </option>";
									else
										echo "<option value='$radiusFilter'> $radiusFilter </option>";
								} else {
									echo "<option value='.'> No filter </option>";
								}
								?>
								<option value="."></option>
								<option value="Auth"> Auth Only </option>
								<option value="Info"> Info Only </option>
								<option value="Error"> Error Only </option>
							</select>
						</form>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.system_log.submit();">
							<img src='images/icons/reportsLogs.png' border='0'>&nbsp;<?php echo t('button','SystemLog') ?>
						</a>
						<form name="system_log" action="rep-logs-system.php" method="get" class="sidebar">
							<select class="generic form-control" name="systemLineCount" type="text">
								<?php if (isset($systemLineCount)) {
									echo "<option value='$systemLineCount'> $systemLineCount Lines </option>";
								} else {
									echo "<option value='50'> 50 Lines Output Limit </option>";
								}
								?>
								<option value="50"></option>
								<option value="20"> 20 Lines </option> 
								<option value="50"> 50 Lines </option>
								<option value="100"> 100 Lines </option>
								<option value="500"> 500 Lines </option>
								<option value="1000"> 1000 Lines </option>
							</select>
							<input type="text" name="systemFilter" 
							tooltipText='<?php echo t('Tooltip','Filter'); ?> <br/>'
							value="<?php if (isset($systemFilter)) echo $systemFilter; ?>" />
						</form>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.boot_log.submit();">
							<img src='images/icons/reportsLogs.png' border='0'>&nbsp;<?php echo t('button','BootLog') ?>
						</a>
						<form name="boot_log" action="rep-logs-boot.php" method="get" class="sidebar">
							<select class="generic form-control" name="bootLineCount" type="text">
								<?php if (isset($bootLineCount)) {
									echo "<option value='$bootLineCount'> $bootLineCount Lines </option>";
								} else {
									echo "<option value='50'> 50 Lines Output Limit </option>";
								}
								?>
								<option value="50"></option>
								<option value="20"> 20 Lines </option> 
								<option value="50"> 50 Lines </option>
								<option value="100"> 100 Lines </option>
								<option value="500"> 500 Lines </option>
								<option value="1000"> 1000 Lines </option>
							</select>
							<input type="text" name="bootFilter" 
							tooltipText='<?php echo t('Tooltip','Filter'); ?> <br/>'
							value="<?php if (isset($bootFilter)) echo $bootFilter; ?>" />
						</form>
					</div>
				</div>
			</div>

<script type="text/javascript">
	var tooltipObj = new DHTMLgoodies_formTooltip();
	tooltipObj.setTooltipPosition('right');
	tooltipObj.setPageBgColor('#EEEEEE');
	tooltipObj.setTooltipCornerSize(15);
	tooltipObj.initFormFieldTooltip();
</script>
