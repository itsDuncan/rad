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

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<body>

<?php
include_once ("lang/main.php");
?>

<?php
	$m_active = "Reports";
    include_once ("include/menu/menu-items.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Status</div>

  <small class="sidebar-subheading">Status</small>
  <div class="list-group list-group-flush">
    <a href="rep-stat-server.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ServerStatus') ?></a>
    <a href="rep-stat-services.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ServicesStatus') ?></a>
  </div>

  <small class="sidebar-subheading">Extended Peripherals</small>
  <div class="list-group list-group-flush">
    <a href="rep-stat-cron.php" class="list-group-item list-group-item-action bg-light">CRON Status</a>
    <a href="rep-stat-ups.php" class="list-group-item list-group-item-action bg-light">UPS Status</a>
    <a href="rep-stat-raid.php" class="list-group-item list-group-item-action bg-light">RAID Status</a>
  </div>
</div>
