<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/dtech/bootstrap.min.css">
  <link rel="stylesheet" href="css/dtech/style.css">

  <title>GwijiNet</title>
</head>

<body class="main-container">

<?php
    include_once ("lang/main.php");
?>

<?php
	$m_active = "Home";
	include_once ("include/menu/menu-items.php");
	include_once ("include/menu/home-subnav.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Home</div>
  <small class="sidebar-subheading">Status</small>
  <div class="list-group list-group-flush">
    <a href="rep-stat-server.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ServerStatus') ?></a>
    <a href="rep-stat-services.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ServicesStatus') ?></a>
    <a href="rep-lastconnect.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','LastConnectionAttempts') ?></a>
  </div>
  <small class="sidebar-subheading">Logs</small>
  <div class="list-group list-group-flush">
    <a href="rep-logs-radius.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RadiusLog') ?></a>
    <a href="rep-logs-system.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','SystemLog') ?></a>
  </div>
</div>
