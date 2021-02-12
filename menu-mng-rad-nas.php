<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

<body>
<?php
	include_once ("lang/main.php");
?>

<?php
	$m_active = "Management";
	include_once ("include/menu/menu-items.php");
	include_once("include/management/autocomplete.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Management</div>

	<small class="sidebar-subheading">NAS Management</small>

	<div class="list-group list-group-flush">
		<a href="mng-rad-nas-list.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListNAS') ?></a>
		<a href="mng-rad-nas-new.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewNAS') ?></a>
		<a href="javascript:document.mnghsedit.submit();" class="list-group-item list-group-item-action bg-light border-bottom-0"><?php echo t('button','EditNAS') ?></a>
		<form name="mngradnasedit" action="mng-rad-nas-edit.php" method="get" class="sidebar">
			<input name="nashost" type="text" id="nashostEdit" class="form-control input-fit" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
			tooltipText='<?php echo t('Tooltip','NasName'); ?> <br/>'
			tabindex=4>
		</form>
	</div>

	<a href="mng-rad-nas-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveNAS') ?></a>
</div>

<?php
	include_once("include/management/autocomplete.php");

	if ($autoComplete) {
		echo "<script type=\"text/javascript\">
			autoComEdit = new DHTMLSuite.autoComplete();
			autoComEdit.add('nashostEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteNASHost');
			</script>";
	}
?>

<script type="text/javascript">
	var tooltipObj = new DHTMLgoodies_formTooltip();
	tooltipObj.setTooltipPosition('right');
	tooltipObj.setPageBgColor('#EEEEEE');
	tooltipObj.setTooltipCornerSize(15);
	tooltipObj.initFormFieldTooltip();
</script>
