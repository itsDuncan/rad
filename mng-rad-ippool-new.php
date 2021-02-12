<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
        
	include('library/check_operator_perm.php');

	// declaring variables
	$poolname = "";
	$ipaddress = "";

	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST['submit'])) {
	
		$poolname = $_POST['poolname'];
		$ipaddress = $_POST['ipaddress'];
		
		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADIPPOOL'].
			" WHERE pool_name='".$dbSocket->escapeSimple($poolname)."'".
			" AND framedipaddress='".$dbSocket->escapeSimple($ipaddress)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {

			if (trim($poolname) != "" and trim($ipaddress) != "") {

				// insert ippool name and ip address
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADIPPOOL'].
					" (pool_name, framedipaddress) ".
					" VALUES ('".$dbSocket->escapeSimple($poolname)."', '".
					$dbSocket->escapeSimple($ipaddress)."')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
			
				$successMsg = "Added to database new IP Address: <b>$ipaddress</b> for Pool Name: <b>$poolname</b>";
				$logAction .= "Successfully added IP Address [$ipaddress] for Pool Name [$poolname] on page: ";
			} else {
				$failureMsg = "No IP Address or Pool Name was entered, it is required that you specify both";
				$logAction .= "Failed adding (missing ipaddress/poolname) IP Address [$ipaddress] for Pool Name [$poolname] on page: ";
			}
		} else {
			$failureMsg = "The IP Address <b>$ipaddress</b> for Pool Name <b>$poolname</b> already exists in the database";
			$logAction .= "Failed adding already existing IP Address [$ipaddress] for Pool Name [$poolname] on page: ";
		}

		include 'library/closedb.php';
	}
	

	include_once('library/config_read.php');
    $log = "visited page: ";

?>

<?php
	include_once ("library/tabber/tab-layout.php");
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
	
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradippoolnew.php') ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradippoolnew') ?>
			<br/>
		</div>

<?php
	include_once('include/management/actionMessages.php');
?>

		<form name="newippool" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="tabber">
	<div class="tabbertab" title="<?php echo t('title','IPPoolInfo'); ?>">
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
     </div>
</div>
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
