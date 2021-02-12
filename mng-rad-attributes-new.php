<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');
	
	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST["submit"])) {

		isset($_POST['vendor']) ? $vendor = $_POST['vendor'] : $vendor = "";
		isset($_POST['attribute']) ? $attribute = $_POST['attribute'] : $attribute = "";
		isset($_POST['type']) ? $type = $_POST['type'] : $type = "";
		isset($_POST['RecommendedOP']) ? $RecommendedOP = $_POST['RecommendedOP'] : $RecommendedOP = "";
		isset($_POST['RecommendedTable']) ? $RecommendedTable = $_POST['RecommendedTable'] : $RecommendedTable = "";
		isset($_POST['RecommendedTooltip']) ? $RecommendedTooltip = $_POST['RecommendedTooltip'] : $RecommendedTooltip = "";

		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALODICTIONARY']." WHERE vendor='".$dbSocket->escapeSimple($vendor).
			"' AND attribute='".$dbSocket->escapeSimple($attribute)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {
			if (trim($vendor) != "" and trim($attribute) != "") {
				// insert vendor/attribute pairs to database
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_DALODICTIONARY'].
					" (id, type, attribute, vendor, RecommendedOP, RecommendedTable, RecommendedTooltip) VALUES (0, '".
					$dbSocket->escapeSimple($type)."', '".$dbSocket->escapeSimple($attribute)."','".
					$dbSocket->escapeSimple($vendor)."','".	$dbSocket->escapeSimple($RecommendedOP)."','".
					$dbSocket->escapeSimple($RecommendedTable)."','".$dbSocket->escapeSimple($RecommendedTooltip)."')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$successMsg = "Added to database new vendor attribute: <b>$attribute</b> of vendor: <b>$vendor</b>";
				$logAction .= "Successfully added new vendor [$vendor] and attribute [$attribute] on page: ";
			} else {
				$failureMsg = "You must provide atleast a vendor name and attribute";	
				$logAction .= "Failed adding new vendor [$vendor] and attribute [$attribute] on page: ";
			}
		} else { 
			$failureMsg = "You have tried to add a vendor's attribute that already exist in the database: $attribute";
			$logAction .= "Failed adding new vendor attribute already in database [$attribute] on page: ";		
		}
	
		include 'library/closedb.php';

	}



	include_once('library/config_read.php');
    $log = "visited page: ";

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/dtech/bootstrap.min.css">
	<link rel="stylesheet" href="css/dtech/style.css">

	<title>GwijiNet</title>
</head>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script> 

<?php
include ("menu-mng-rad-attributes.php");
?>

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/management-subnav.php");
	?>
	<div class="container">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradattributesnew.php') ?>
		<h144>&#x2754;</h144></a></h2>
		
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradattributesnew') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	
	<fieldset>

		<h302> <?php echo t('title','VendorAttribute'); ?> </h302>
		<br/>

		<ul>

		<li class='fieldset'>
		<label for='vendor' class='form'><?php echo t('all','VendorName') ?></label>
		<input name='vendor' type='text' id='vendor' value='' tabindex=100 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('vendorNameTooltip')" />
		
		<div id='vendorNameTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','vendorNameTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='attribute' class='form'><?php echo t('all','Attribute') ?></label>
		<input name='attribute' type='text' id='attribute' value='' tabindex=101 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('attributeTooltip')" />

		<div id='attributeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','attributeTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='type' class='form'><?php echo t('all','Type') ?></label>
		<select name='type' type='text' id='type' class='form' tabindex=102 />
			<option value=''>Select Type...</option>
		<?php
			include_once('include/management/populate_selectbox.php');
			drawTypes();
		?>
		</select>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('typeTooltip')" />
		
		<div id='typeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','typeTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='RecommendedOP' class='form'><?php echo t('all','RecommendedOP') ?></label>
		<select name='RecommendedOP' id='RecommendedOP' class='form' tabindex=103 />
			<option value=''>Select OP...</option>
		<?php
			include_once('include/management/populate_selectbox.php');
			drawOptions();
		?>
		</select>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('RecommendedOPTooltip')" />
		
		<div id='RecommendedOPTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','RecommendedOPTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='RecommendedTable' class='form'><?php echo t('all','RecommendedTable') ?></label>
                <select name='RecommendedTable' id='RecommendedTable' class='form' tabindex=104 />
		<option value=''>Select Table...</option>
		<?php
			include_once('include/management/populate_selectbox.php');
			drawTables();
		?>
		</select>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('RecommendedTableTooltip')" />
		
		<div id='RecommendedTableTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','RecommendedTableTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='RecommendedTooltip' class='form'><?php echo t('all','RecommendedTooltip') ?></label>
		<textarea class='form' name='RecommendedTooltip' type='text' id='RecommendedTooltip' tabindex=105 /></textarea>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('RecommendedTooltipTooltip')" />
		<div id='RecommendedTooltipTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','RecommendedTooltipTooltip') ?>
		</div>
		</li>

	
		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=10000 class='button' />
		</li>

		</ul>
	</fieldset>

	</form>

<?php
	include('include/config/logging.php');
?>

		</div>
		</div>

		<div id="footer">

<?php
	include 'page-footer.php';
?>


		</div>

</div>
</div>


</body>
</html>





