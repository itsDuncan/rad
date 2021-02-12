<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['poolname']) ? $poolname = $_REQUEST['poolname'] : $poolname = "";
	isset($_REQUEST['ipaddress']) ? $ipaddress = $_REQUEST['ipaddress'] : $ipaddress = "";

	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if (isset($_POST['poolname'])) {

		$allPoolNames = "";
		$allIPAddresses = "";

		/* since the foreach loop will report an error/notice of undefined variable $value because
		it is possible that the $poolname is not an array, but rather a simple GET request
		with just some value, in this case we check if it's not an array and convert it to one with
		a NULL 2nd element
		*/

		if (is_array($poolname)) {
			$itemsArray = $poolname;
		} else {
			$itemsArray = array($poolname."||".$ipaddress);
		}

		foreach ($itemsArray as $value) {

			list($poolname, $ipaddress) = preg_split('\|\|', $value);

			if ( (trim($poolname) != "") && (trim($ipaddress) != "") ) {

				include 'library/opendb.php';

				$allPoolNames .= $poolname . ", ";
				$allIPAddresses .= $ipaddress .", ";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADIPPOOL']." WHERE ".
					" pool_name='".$dbSocket->escapeSimple($poolname)."' AND".
					" framedipaddress='".$dbSocket->escapeSimple($ipaddress)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$successMsg = "Deleted IP Address <b>$ipaddress</b> for Pool Name <b>$poolname</b> from database";
				$logAction .= "Successfully deleted IP Address [$ipaddress] for Pool name [$poolname] on page: ";

				include 'library/closedb.php';

			}  else {
				$failureMsg = "No IPAddress/Pool Name was entered, please specify an IPAddress/Pool Name to remove from database";
				$logAction .= "Failed deleting empty IP Address/Pool Name on page: ";
			} //if trim

		} //foreach

		$showRemoveDiv = "none";
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
	include ("menu-mng-rad-ippool.php");
?>

	<div id="contentnorightbar">
		<?php
			include_once ("include/menu/management-subnav.php");
		?>
		<div class="container">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradippooldel.php') ?>
		:: <?php if (isset($poolname)) { echo $poolname; } ?><h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradippooldel') ?>
			<br/>
		</div>
<?php
	include_once('include/management/actionMessages.php');
?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <fieldset>

			<h302> <?php echo t('title','IPPoolInfo') ?> </h302>
			<br/>

			<label for='poolname' class='form'><?php echo t('all','PoolName') ?></label>
			<input name='poolname' type='text' id='poolname' value='<?php echo $poolname ?>' tabindex=100 />
			<br />

			<label for='ipaddress' class='form'><?php echo t('all','IPAddress') ?></label>
			<input name='ipaddress' type='text' id='ipaddress' value='<?php echo $ipaddress ?>' tabindex=101 />
			<br />

			<br/><br/>
			<hr><br/>

			<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />

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
