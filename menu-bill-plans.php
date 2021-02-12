<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

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

				<small class="sidebar-subheading">Track Billing History</small>

				<div class="list-group list-group-flush">
					<div class="list-group-item list-group-item-action bg-light">
						<a href="bill-plans-list.php"><?php echo t('button','ListPlans') ?></a>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="bill-plans-new.php"><?php echo t('button','NewPlan') ?></a>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="javascript:document.billplansedit.submit();"><?php echo t('button','EditPlan') ?><a>
						<form name="billplansedit" action="bill-plans-edit.php" method="get" class="sidebar">
						<input class="form-control" name="planName" type="text" id="planNameEdit" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
						tooltipText='<?php echo t('Tooltip','BillingPlanName'); ?> <br/>'
						value="<?php if (isset($edit_planname)) echo $edit_planname; ?>" tabindex=3>
						</form>
					</div>

					<div class="list-group-item list-group-item-action bg-light">
						<a href="bill-plans-del.php"><?php echo t('button','RemovePlan') ?></a>
					</div>
				</div>
			</div>

				<?php
				include_once("include/management/autocomplete.php");

				if ($autoComplete) {
					echo "<script type=\"text/javascript\">
					autoComEdit = new DHTMLSuite.autoComplete();
					autoComEdit.add('planNameEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteBillingPlans');
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
