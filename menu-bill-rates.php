<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<body>
	<?php
		include_once ("lang/main.php");
		$m_active = "Billing";
		include_once ("include/menu/menu-items.php");
		include_once("include/management/autocomplete.php");
	?>
	<div id="wrapper">
		<div id="innerwrapper" class="main-section d-flex">

			<div class="bg-light border-right" id="sidebar-wrapper">
				<div class="sidebar-heading">Billing</div>

				<small class="sidebar-subheading">Track Rates</small>

				<div class="list-group list-group-flush">
					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.billrates.submit();"><?php echo t('button','DateAccounting') ?>
					</a>

					<form name="billrates" action="bill-rates-date.php" method="get" class="sidebar">
						<select class="form-control" name="ratename" size="1">
							<option value="<?php if (isset($billing_date_ratename)) echo $billing_date_ratename; else echo ""; ?>">
								<?php if (isset($billing_date_ratename)) echo $billing_date_ratename; else echo "Choose Rate"; ?>
							</option>
							<?php
							include 'library/opendb.php';

							$sql = "SELECT rateName FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].";";
							$res = $dbSocket->query($sql);

							while ($row = $res->fetchRow()) {
								echo "<option value='$row[0]'>$row[0]</option>";
							}
							?>           
						</select>

						<input class="form-control" name="username" type="text" id="username" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
						tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
						value="<?php if (isset($billing_date_username)) echo $billing_date_username; ?>">
						<input class="form-control" name="startdate" type="text" id="startdate"
						tooltipText='<?php echo t('Tooltip','Date'); ?> <br/>'
						value="<?php if (isset($billing_date_startdate)) echo $billing_date_startdate;
						else echo date("Y-m-01"); ?>">

						<img src="library/js_date/calendar.gif"
						onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
						<div id="chooserSpan" class="dateChooser select-free"
						style="display: none; visibility: hidden;       width: 160px;"></div>

						<input class="form-control" name="enddate" type="text" id="enddate"
						tooltipText='<?php echo t('Tooltip','Date'); ?> <br/>'
						value="<?php if (isset($billing_date_enddate)) echo $billing_date_enddate;
						else echo date("Y-m-t"); ?>">

						<img src="library/js_date/calendar.gif"
						onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
						<div id="chooserSpan" class="dateChooser select-free"
						style="display: none; visibility: hidden; width: 160px;"></div>

					</form>
				</div>

				<small class="sidebar-subheading">Rates Management</small>

				<div class="list-group list-group-flush">
					<div class="list-group-item list-group-item-action bg-light">
						<a href="bill-rates-list.php"><?php echo t('button','ListRates') ?></a>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="bill-rates-new.php"><?php echo t('button','NewRate') ?></a>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.billratesedit.submit();"><?php echo t('button','EditRate') ?></a>
						<form name="billratesedit" action="bill-rates-edit.php" method="get" class="sidebar">
							<input class="form-control" name="ratename" type="text" id="ratename" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
							tooltipText='<?php echo t('Tooltip','RateName'); ?> <br/>'
							value="<?php if (isset($edit_rateName)) echo $edit_rateName; ?>" tabindex=3>
						</form>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="bill-rates-del.php"><?php echo t('button','RemoveRate') ?></a>
					</div>
				</div>
			</div>
		</div>

		<?php
		include_once("include/management/autocomplete.php");

		if ($autoComplete) {
			echo "<script type=\"text/javascript\">
			autoComEdit = new DHTMLSuite.autoComplete();
			autoComEdit.add('username','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

			autoComEdit = new DHTMLSuite.autoComplete();
			autoComEdit.add('ratename','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteRateName');
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
