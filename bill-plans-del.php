<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['planName']) ? $plans = $_REQUEST['planName'] : $plans = "";
	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if (isset($_REQUEST['planName'])) {

		if (!is_array($plans))
			$plans = array($plans);

		$allPlans = "";

		include 'library/opendb.php';
	
		foreach ($plans as $variable=>$value) {
			if (trim($value) != "") {

				$planName = $value;
				$allPlans .= $planName . ", ";

				// remove the plan entry from the plans table
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS'].
						" WHERE planName='".$dbSocket->escapeSimple($planName)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				// remove plan's association with profiles from the plans_profiles table
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANSPROFILES'].
						" WHERE plan_name='".$dbSocket->escapeSimple($planName)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				$successMsg = "Deleted billing plan(s): <b> $allPlans </b>";
				$logAction .= "Successfully deleted billing plan(s) [$allPlans] on page: ";
				
			} else { 
				$failureMsg = "no billing plan name was entered, please specify a billing plan name to remove from database";
				$logAction .= "Failed deleting billing plan(s) [$allPlans] on page: ";
			}

		} //foreach

		$plans = "";
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
<?php
	include ("menu-bill-plans.php");
?>		

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/billing-subnav.php");
	?>

	<div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','billplansdel.php') ?>
	:: <?php if (isset($plans)) { echo $plans; } ?><h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >
		<?php echo t('helpPage','billplansdel') ?>
		<br/>
	</div>
	<?php
		include_once('include/management/actionMessages.php');
	?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','PlanRemoval') ?> </h302>
		<br/>

		<label for='planNname' class='form'><?php echo t('all','PlanName') ?></label>
		<input name='planName[]' type='text' id='planName' value='<?php echo $plans ?>' tabindex=100 autocomplete="off" />
		<br/>

		<br/><br/>
		<hr><br/>

		<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=1000 
			class='button' />

	</fieldset>

	</form>
	</div>


<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('planName','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteBillingPlans');
                      </script>";
        }

?>


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





