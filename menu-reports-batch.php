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
	include_once("include/management/autocomplete.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Batch Users</div>

	<small class="sidebar-subheading">List</small>

	<div class="list-group list-group-flush">
		<div class="list-group-item list-group-item-action bg-light">
			<a href="rep-batch-list.php"><?php echo t('button','BatchHistory') ?></a>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.batch_name_details.submit();"><?php echo t('button','BatchDetails') ?></a>

			<form name="batch_name_details" action="rep-batch-details.php" method="get" class="sidebar">
			<input name="batch_name" type="text" id="batchNameDetails" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
								tooltipText='<?php echo t('Tooltip','BatchName'); ?>'
				value="<?php if (isset($batch_name_details)) echo $batch_name_details; ?>">
			</form>
		</div>
		
	</div>
</div>

<?php

    if ($autoComplete) {
        echo "<script type=\"text/javascript\">
              autoComEdit = new DHTMLSuite.autoComplete();
              autoComEdit.add('batchNameDetails','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteBatchNames');
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
