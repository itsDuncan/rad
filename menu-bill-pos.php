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

	<small class="sidebar-subheading">Point of Sales Management</small>

	<div class="list-group list-group-flush">
		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.billposlist.submit();"><?php echo t('button','ListUsers') ?></a>
			<form name="billposlist" action="bill-pos-list.php" method="get" class="sidebar">
			<br/>
				<?php
					include 'include/management/populate_selectbox.php';
					populate_plans("Select Plan","planname","generic");
				?>
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="bill-pos-new.php"><?php echo t('button','NewUser') ?></a>
		</div>
		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.billposedit.submit();"><?php echo t('button','EditUser') ?></a>
			<form name="billposedit" action="bill-pos-edit.php" method="get" class="sidebar">
				<input class="form-control" name="username" type="text" id="usernameEdit" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
	                tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
	                value="<?php if (isset($edit_username)) echo $edit_username; ?>" tabindex=1>
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="bill-pos-del.php"><?php echo t('button','RemoveUsers') ?></a>
		</div>

	</div>

</div>

<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                        /** Making usernameEdit interactive **/
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
