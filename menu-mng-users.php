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

  <small class="sidebar-subheading">Users Management</small>

  <div class="list-group list-group-flush">
    <a href="mng-list-all.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListUsers') ?></a>
    <a href="mng-new.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewUser') ?></a>
    <a href="mng-new-quick.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewUserQuick') ?></a>
    <a href="javascript:document.mngedit.submit();"" class="list-group-item list-group-item-action bg-light border-bottom-0"><?php echo t('button','EditUser') ?></a>
    <form name="mngedit" action="mng-edit.php" method="get">
			<input name="username" type="text" id="usernameEdit" class="form-control input-fit" autocomplete="off"
				tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
				value="<?php if (isset($edit_username)) echo $edit_username; ?>" tabindex=1>
		</form>

    <a href="javascript:document.mngsearch.submit();"" class="list-group-item list-group-item-action bg-light border-bottom-0"><?php echo t('button','SearchUsers') ?></a>
    <form name="mngsearch" action="mng-search.php" method="get">
			<input name="username" type="text" id="usernameSearch" class="form-control input-fit" autocomplete="off"
				tooltipText='<?php echo t('Tooltip','Username'); ?> <br/> <?php echo t('Tooltip','UsernameWildcard'); ?>'
				value="<?php if (isset($search_username)) echo $search_username; ?>" tabindex=2>
		</form>
    <a href="mng-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveUsers') ?></a>
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
			/** Making usernameEdit interactive **/
	              autoComEdit = new DHTMLSuite.autoComplete();
	              autoComEdit.add('usernameEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
			/** Making usernameSearch interactive **/
	              autoComEdit.add('usernameSearch','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
