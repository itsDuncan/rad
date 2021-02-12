<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

<body>
<?php
    include_once("lang/main.php");
?>

<?php
    $m_active = "Management";
    include_once("include/menu/menu-items.php");

?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Management</div>

  <small class="sidebar-subheading">Batch Management</small>

  <div class="list-group list-group-flush">
    <a href="mng-batch-list.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListBatches') ?></a>
    <a href="mng-batch-add.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','BatchAddUsers') ?></a>
    <a href="mng-batch-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveBatch') ?></a>
  </div>

  <small class="sidebar-subheading">Extended Capabilities</small>
  <div class="list-group list-group-flush">
    <a href="mng-import-users.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ImportUsers') ?></a>
  </div>
</div>


<?php
	include_once("include/management/autocomplete.php");

	if ($autoComplete) {
		echo "<script type=\"text/javascript\">
			/** Making dictAttributesCustom interactive **/
	              autoComEdit = new DHTMLSuite.autoComplete();
              </script>";
	}
?>
