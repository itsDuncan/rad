<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['ratename']) ? $ratename = $_REQUEST['ratename'] : $ratename = "";
	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if (isset($_REQUEST['ratename'])) {

		if (!is_array($ratename))
			$ratename = array($ratename);

		$allRates = "";

		include 'library/opendb.php';
	
		foreach ($ratename as $variable=>$value) {
			if (trim($value) != "") {

				$name = $value;
				$allRates .= $name . ", ";

				// delete all rates 
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES']." WHERE rateName='".
						$dbSocket->escapeSimple($name)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				$successMsg = "Deleted rate(s): <b> $allRates </b>";
				$logAction .= "Successfully deleted rates(s) [$allRates] on page: ";
				
			} else { 
				$failureMsg = "no rate was entered, please specify a rate name to remove from database";
				$logAction .= "Failed deleting rate(s) [$allRates] on page: ";
			}

		} //foreach

		include 'library/closedb.php';

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

	<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">

	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<link rel="stylesheet" href="css/dtech/bootstrap.min.css">
	<link rel="stylesheet" href="css/dtech/style.css">

	<title>GwijiNet</title>
</head>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<?php

	include ("menu-bill-rates.php");
	
?>		

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/billing-subnav.php");
	?>

	<div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','billratesdel.php') ?>
	:: <?php if (isset($ratename)) { echo $ratename; } ?><h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >		<?php echo t('helpPage','billhsdel') ?>
		<br/>
	</div>
	<?php
		include_once('include/management/actionMessages.php');
	?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','RateInfo') ?> </h302>
		<br/>

		<label for='ratename' class='form'><?php echo t('all','RateName') ?></label>
		<input name='ratename[]' type='text' id='ratename' value='<?php echo $ratename ?>' tabindex=100 />
		<br/>

		<br/><br/>
		<hr><br/>

		<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=1000 
			class='button' />

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





