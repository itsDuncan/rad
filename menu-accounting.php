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
	include_once("include/management/autocomplete.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Accounting</div>

	<small class="sidebar-subheading">User Accounting</small>

	<div class="list-group list-group-flush">
		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.acctusername.submit();"><?php echo t('button','UserAccounting') ?></a>
			<form name="acctusername" action="acct-username.php" method="get" class="sidebar">
			<input class="form-control" name="username" type="text" id="usernameAcct" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
                                tooltipText='<?php echo t('Tooltip','Username'); ?>'
				value="<?php if (isset($accounting_username)) echo $accounting_username; ?>">
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.acctipaddress.submit();"><?php echo t('button','IPAccounting') ?></a>
			<form name="acctipaddress" action="acct-ipaddress.php" method="get" class="sidebar">
			<input class="form-control" name="ipaddress" type="text" 
                                tooltipText='<?php echo t('Tooltip','IPAddress'); ?>'
				value="<?php if (isset($accounting_ipaddress)) echo $accounting_ipaddress; ?>">
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.acctnasipaddress.submit();"><?php echo t('button','NASIPAccounting') ?></a>
			<form name="acctnasipaddress" action="acct-nasipaddress.php" method="get" class="sidebar">
			<input class="form-control" name="nasipaddress" type="text" 
                                tooltipText='<?php echo t('Tooltip','IPAddress'); ?>'
				value="<?php if (isset($accounting_nasipaddress)) echo $accounting_nasipaddress; ?>">
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.acctdate.submit();"><?php echo t('button','DateAccounting') ?></a>
			<form name="acctdate" action="acct-date.php" method="get" class="sidebar">
			<input class="form-control" name="username" type="text" id="usernameDate" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
                                tooltipText='<?php echo t('Tooltip','Username'); ?>'
				value="<?php if (isset($accounting_date_username)) echo $accounting_date_username;  ?>">
			<input class="form-control" name="startdate" type="text" id="startdate" 
                                tooltipText='<?php echo t('Tooltip','Date'); ?>'
				value="<?php if (isset($accounting_date_startdate)) echo $accounting_date_startdate;
			else echo date("Y-m-01"); ?>">
			
			<img src="library/js_date/calendar.gif" 
				onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
			<div id="chooserSpan" class="dateChooser select-free" 
				style="display: none; visibility: hidden; 	width: 160px;"></div>

			<input class="form-control" name="enddate" type="text" id="enddate" 
                                tooltipText='<?php echo t('Tooltip','Date'); ?>'
				value="<?php if (isset($accounting_date_enddate)){ echo $accounting_date_enddate;}
				else { echo date("Y-m-t");} ?>">
			<img src="library/js_date/calendar.gif" 
				onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
			<div id="chooserSpan" class="dateChooser select-free" 
				style="display: none; visibility: hidden; width: 160px;"></div>

			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="acct-all.php"><?php echo t('button','AllRecords') ?></a>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="acct-active.php"><?php echo t('button','ActiveRecords') ?></a>
		</div>
	</div>
</div>

<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
            echo "<script type=\"text/javascript\">
                  autoComEdit = new DHTMLSuite.autoComplete();
                  autoComEdit.add('usernameDate','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

                  autoComEdit = new DHTMLSuite.autoComplete();
                  autoComEdit.add('usernameAcct','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
