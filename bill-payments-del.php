<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['payment_id']) ? $payment_id = $_REQUEST['payment_id'] : $payment_id = "";
	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if (isset($_REQUEST['payment_id'])) {

		if (!is_array($payment_id))
			$payment_id = array($payment_id);

		$allPayment_Ids = "";

		include 'library/opendb.php';
	
		foreach ($payment_id as $variable=>$value) {
			if (trim($value) != "") {

				$id = $value;
				$allPayment_Ids .= $id . ", ";

				// delete all payment types 
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOPAYMENTS']." WHERE id=".
						$dbSocket->escapeSimple($id)."";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				$successMsg = "Deleted payment(s): <b> $allPayment_Ids </b>";
				$logAction .= "Successfully deleted payment(s) [$allPayment_Ids] on page: ";
				
			} else { 
				$failureMsg = "no payment id was entered, please specify a payment id to remove from database";
				$logAction .= "Failed deleting payment(s) [$allPayment_Ids] on page: ";
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
<?php

	include ("menu-bill-payments.php");
	
?>		

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/billing-subnav.php");
	?>

	<div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','paymentsdel.php') ?>
	:: <?php if (isset($payment_id)) { echo $payment_id; } ?><h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >		<?php echo t('helpPage','paymentsdel') ?>
		<br/>
	</div>
	<?php
		include_once('include/management/actionMessages.php');
	?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','PaymentInfo') ?> </h302>
		<br/>

		<label for='payment_id' class='form'><?php echo t('all','PaymentId') ?></label>
		<input name='payment_id[]' type='text' id='payment_id' value='<?php echo $payment_id ?>' tabindex=100 />
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





