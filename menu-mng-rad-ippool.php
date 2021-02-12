<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

<body>
<?php
    include_once ("lang/main.php");
    $m_active = "Management";
    include_once ("include/menu/menu-items.php");
?>
<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Management</div>

	<small class="sidebar-subheading">IP Pools</small>

	<div class="list-group list-group-flush">
		<a href="mng-rad-ippool-list.php" class="list-group-item list-group-item-action bg-light" tabindex=1><?php echo t('button','ListIPPools') ?></a>
		
		<a href="mng-rad-ippool-new.php" class="list-group-item list-group-item-action bg-light" tabindex=2><?php echo t('button','NewIPPool') ?></a>
		
		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.mngradippooledit.submit();" tabindex=3 ><?php echo t('button','EditIPPool') ?></a>
			<form name="mngradippooledit" action="mng-rad-ippool-edit.php" method="get" class="sidebar">
			<input name="poolname" type="text" 
				tooltipText='<?php echo t('Tooltip','PoolName'); ?> <br/>'
				value="<?php if (isset($poolname)) echo $poolname ?>" tabindex=4>
			<input name="ipaddressold" type="text" 
				tooltipText='<?php echo t('Tooltip','IPAddress'); ?> <br/>'
				value="<?php if (isset($ipaddressold)) echo $ipaddressold  ?>" tabindex=4>
			</form>
		</div>
		
		<a href="mng-rad-ippool-del.php" class="list-group-item list-group-item-action bg-light" tabindex=5><?php echo t('button','RemoveIPPool') ?></a>
	</div>
</div>

<script type="text/javascript">
        var tooltipObj = new DHTMLgoodies_formTooltip();
        tooltipObj.setTooltipPosition('right');
        tooltipObj.setPageBgColor('#EEEEEE');
        tooltipObj.setTooltipCornerSize(15);
        tooltipObj.initFormFieldTooltip();
</script>

