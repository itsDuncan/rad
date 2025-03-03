<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	$logAction = "";
	$logDebugSQL = "";

	isset($_GET['vendor']) ? $vendor = $$_GET['vendor'] : $vendor = "";
	isset($_GET['attribute']) ? $attribute = $$_GET['attribute'] : $attribute = "";

	$showRemoveDiv = "block";

	if (isset($_POST['vendor'])) {

		if (is_array($_POST['vendor'])) {
			$vendor_array = $_POST['vendor'];
		} else {
			$vendor_array = array($_POST['vendor']."||".$_POST['attribute']);
		}

		foreach ($vendor_array as $vendor_attribute) {

	                list($vendor, $attribute) = preg_split('\|\|', $vendor_attribute);

	                if ( (trim($vendor) != "") && (trim($attribute) != "") ) {

	                        $allVendors =  "";
	                        $allAttributes = "";
	                        include 'library/opendb.php';

				include 'library/opendb.php';

				$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALODICTIONARY']." WHERE vendor='".
						$dbSocket->escapeSimple($vendor)."' AND attribute='".$dbSocket->escapeSimple($attribute)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				if ($res->numRows() == 1) {
					if (trim($vendor) != "" and trim($attribute) != "") {
						// remove vendor/attribute pairs from database
						$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALODICTIONARY']." WHERE vendor='".
							$dbSocket->escapeSimple($vendor)."' AND attribute='".$dbSocket->escapeSimple($attribute)."'";
						$res = $dbSocket->query($sql);
						$logDebugSQL .= $sql . "\n";

						$successMsg = "Removed from database vendor attribute: <b>$attribute</b> of vendor: <b>$vendor</b>";
						$logAction .= "Successfully removed vendor [$vendor] and attribute [$attribute] from database on page: ";
					} else {
						$failureMsg = "you must provide atleast a vendor name and attribute";
						$logAction .= "Failed removing vendor [$vendor] and attribute [$attribute] from database on page: ";
					}
				} else {
					$failureMsg = "You have tried to remove a vendor's attribute that either is not present in the database or there
							may be more than 1 entry for this vendor attribute in database (attribute :$attribute)";
					$logAction .= "Failed removing vendor attribute already in database [$attribute] on page: ";
				} //if ($res->numRows() == 1)

				include 'library/closedb.php';

			} // if (trim...

		} //foreach

		$showRemoveDiv = "none";

	} //if (isset)


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

<?php
include ("menu-mng-rad-attributes.php");
?>

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/management-subnav.php");
	?>
	<div class="container">

			<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradattributesdel.php') ?>
			<h144>&#x2754;</h144></a></h2>

			<div id="helpPage" style="display:none;visibility:visible" >
				<?php echo t('helpPage','mngradattributesdel') ?>
				<br/>
			</div>
			<?php
				include_once('include/management/actionMessages.php');
			?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','VendorAttribute'); ?> </h302>
		<br/>

		<ul>

		<li class='fieldset'>
		<label for='vendor' class='form'><?php echo t('all','VendorName') ?></label>
		<input name='vendor' type='text' id='vendor' value='<?php if (isset($vendor)) echo $vendor ?>' tabindex=100 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('vendorNameTooltip')" />

		<div id='vendorNameTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','vendorNameTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='attribute' class='form'><?php echo t('all','Attribute') ?></label>
		<input name='attribute' type='text' id='attribute' value='<?php if (isset($attribute)) echo $attribute ?>' tabindex=101 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('attributeTooltip')" />

		<div id='attributeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','attributeTooltip') ?>
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
	</div>

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
