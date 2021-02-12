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

				<small class="sidebar-subheading">HuntGroup Management</small>

				<div class="list-group list-group-flush">
					<a href="mng-rad-hunt-list.php" class="list-group-item list-group-item-action bg-light" tabindex=1><?php echo t('button','ListHG') ?>
					</a>

					<a href="mng-rad-hunt-new.php" class="list-group-item list-group-item-action bg-light" tabindex=2><?php echo t('button','NewHG') ?></a>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.mngradhuntedit.submit();" tabindex=3 ><?php echo t('button','EditHG') ?></a>
						<form name="mngradhuntedit" action="mng-rad-hunt-edit.php" method="get" class="sidebar">
							<input name="nasipaddress" class="form-control input-fit" type="text" id="nashostEdit" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
							tooltipText='<?php echo t('Tooltip','hgNasIpAddress'); ?> <br/>'
							tabindex=4 />
							<input name="groupname" type="text" class="form-control input-fit" value=""
							tooltipText='<?php echo t('Tooltip','hgGroupName'); ?> <br/>'
							tabindex=5 />
						</form>
					</div>

					<a href="mng-rad-hunt-del.php" class="list-group-item list-group-item-action bg-light" tabindex=5><?php echo t('button','RemoveHG') ?></a>

				</div>
			</div>

	<?php

	if ($autoComplete) {
		echo "<script type=\"text/javascript\">
		autoComEdit = new DHTMLSuite.autoComplete();
		autoComEdit.add('nashostEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteHGHost');
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

