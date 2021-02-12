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

				<small class="sidebar-subheading">User-Group Management</small>

				<div class="list-group list-group-flush">
					<a href="mng-rad-usergroup-list.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListUserGroup') ?></a>

					<a href="javascript:document.mngradusrgrplist.submit();"" class="list-group-item list-group-item-action bg-light border-bottom-0"><?php echo t('button','ListUsersGroup') ?></a>

					<form name="mngradusrgrplist" action="mng-rad-usergroup-list-user.php" method="get"
						class="sidebar">
						<input class="form-control input-fit" name="username" type="text" id="usernameList" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
						tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
						/>
					</form>
				</div>

				<a href="mng-rad-usergroup-new.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewUserGroup') ?></a>

				<a href="javascript:document.mngradusrgrpedit.submit();"" class="list-group-item list-group-item-action bg-light border-bottom-0"><?php echo t('button','EditUserGroup') ?></a>

				<form name="mngradusrgrpedit" action="mng-rad-usergroup-edit.php" method="get" class="sidebar">
				
					<input name="username" type="text" value="" class="form-control input-fit" id="usernameEdit" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
							tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
							/>
					<input name="group" type="text" value="" class="form-control input-fit" id="groupnameEdit" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
							tooltipText='<?php echo t('Tooltip','GroupName'); ?> <br/>'
							/>
				</form>

				<a href="mng-rad-usergroup-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveUserGroup') ?></a>
			</div>

					<?php
					include_once("include/management/autocomplete.php");

					if ($autoComplete) {
						echo "<script type=\"text/javascript\">
						autoComEdit = new DHTMLSuite.autoComplete();
						autoComEdit.add('usernameList','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

						autoComEdit = new DHTMLSuite.autoComplete();
						autoComEdit.add('usernameEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

						autoComEdit = new DHTMLSuite.autoComplete();
						autoComEdit.add('groupnameEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteGroupName');
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
