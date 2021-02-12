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

				<small class="sidebar-subheading">Plan Accounting</small>

				<div class="list-group list-group-flush">
					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.acctdate.submit();"><?php echo t('button','PlanUsage') ?></a>
						<form name="acctdate" action="acct-plans-usage.php" method="get" class="sidebar">
							<input class="form-contorl" name="username" type="text" id="usernamePlan" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
							tooltipText='<?php echo t('Tooltip','Username'); ?>'
							value="<?php if (isset($accounting_plan_username)) echo $accounting_plan_username;  ?>">

							<input class="form-contorl" name="startdate" type="text" id="startdate" 
							tooltipText='<?php echo t('Tooltip','Date'); ?>'
							value="<?php if (isset($accounting_plan_startdate)) echo $accounting_plan_startdate;
							else echo date("Y-m-01"); ?>">
							
							<img src="library/js_date/calendar.gif" 
							onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
							<div id="chooserSpan" class="dateChooser select-free" 
							style="display: none; visibility: hidden; 	width: 160px;"></div>

							<input class="form-contorl" name="enddate" type="text" id="enddate" 
							tooltipText='<?php echo t('Tooltip','Date'); ?>'
							value="<?php if (isset($accounting_plan_enddate)){ echo $accounting_plan_enddate;}
							else { echo date("Y-m-t");} ?>">
							<img src="library/js_date/calendar.gif" 
							onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
							<div id="chooserSpan" class="dateChooser select-free" 
							style="display: none; visibility: hidden; width: 160px;"></div>

						</form>

						<?php   
						include 'include/management/populate_selectbox.php';
						populate_plans("Select Plan","planname","generic");
						?>
					</div>
				</div>
			</div>

			<?php
			include_once("include/management/autocomplete.php");

			if ($autoComplete) {
				echo "<script type=\"text/javascript\">
				autoComEdit = new DHTMLSuite.autoComplete();
				autoComEdit.add('usernamePlan','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
