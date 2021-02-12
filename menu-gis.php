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
	<?php
		include "library/googlemaps.php";
	?>
</head>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<body onload="load()" onunload="GUnload()">

<?php
	include_once ("lang/main.php");
	$m_active = "Gis";
	include_once ("include/menu/menu-items.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">GIS</div>

	<small class="sidebar-subheading">GIS Mapping</small>

	<div class="list-group list-group-flush">
		<div class="list-group-item list-group-item-action bg-light">
			<a href="gis-viewmap.php"><?php echo t('button','ViewMAP') ?></a>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="gis-editmap.php"><?php echo t('button','EditMAP') ?></a>
		</div>
	</div>

	<small class="sidebar-subheading">Settings</small>

	<div class="list-group list-group-flush">
		<div class="list-group-item list-group-item-action bg-light">
			<a href="avascript:document.gisregister.submit();"><?php echo t('button','RegisterGoogleMapsAPI')?>
			</a>

			<form name="gisregister" action="gis-main.php" method="get" class="sidebar">
				<input name="code" class="form-control" type="text">
				<input class="sidebutton form-control" name="submit" type="submit" value="Register code">
			</form>
		</div>
	</div>
</div>