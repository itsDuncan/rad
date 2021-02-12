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

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<body>
<?php
	include_once ("lang/main.php");
	$m_active = "Config";
	include_once ("include/menu/menu-items.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Configuration</div>

	<small class="sidebar-subheading">Global Settings</small>

	<div class="list-group list-group-flush">
		<a class="list-group-item list-group-item-action bg-light" href="config-user.php"><?php echo t('button','UserSettings') ?></a>
		<a class="list-group-item list-group-item-action bg-light" href="config-db.php"><?php echo t('button','DatabaseSettings') ?></a>
		<a class="list-group-item list-group-item-action bg-light" href="config-lang.php"><?php echo t('button','LanguageSettings') ?></a>
		<a class="list-group-item list-group-item-action bg-light" href="config-logging.php"><?php echo t('button','LoggingSettings') ?></a>
		<a class="list-group-item list-group-item-action bg-light" href="config-interface.php"><?php echo t('button','InterfaceSettings') ?></a>
		<a class="list-group-item list-group-item-action bg-light" href="config-mail.php"><?php echo t('button','MailSettings') ?></a>
	</div>
</div>

