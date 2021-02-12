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
?>
<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Management</div>

  <small class="sidebar-subheading">Hotspots Management</small>

  <div class="list-group list-group-flush">
    <a href="mng-hs-list.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListHotspots') ?></a>
    <a href="mng-hs-new.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewHotspot') ?></a>
    <a href="javascript:document.mnghsedit.submit();"" class="list-group-item list-group-item-action bg-light border-bottom-0"><?php echo t('button','EditHotspot') ?></a>
    <form name="mngedit" action="mng-hs-edit.php" method="get">
			<input name="name" type="text" id="hotspotEdit" class="form-control input-fit" autocomplete="off"
				tooltipText='<?php echo t('Tooltip','HotspotName'); ?> <br/>'
				value="<?php if (isset($edit_hotspotname)) echo $edit_hotspotname; ?>" tabindex=1>
		</form>
    
  </div>

  <small class="sidebar-subheading">Extended Capabilities</small>
  <div class="list-group list-group-flush">
    <a href="mng-hs-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveHotspot') ?></a>
  </div>
</div>


<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('hotspotEdit','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteHotspots');
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
