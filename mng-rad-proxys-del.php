<?php 

	include ("library/checklogin.php");
	$operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['proxyname']) ? $proxynameArray = $_REQUEST['proxyname'] : $proxynameArray = "";

	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if (isset($_REQUEST['proxyname'])) {

		if (!is_array($proxynameArray))
			$proxynameArray = array($proxynameArray, NULL);

		$allProxys = "";

		include 'library/opendb.php';

		if (isset($configValues['CONFIG_FILE_RADIUS_PROXY'])) {
			$filenameRealmsProxys = $configValues['CONFIG_FILE_RADIUS_PROXY'];
			$fileFlag = 1;
		} else {
			$filenameRealmsProxys = "";
			$fileFlag = 0;
		}

		foreach ($proxynameArray as $variable=>$value) {
			if (trim($value) != "") {

				$proxyname = $value;
				$allProxys .= $proxyname . ", ";

				// delete all proxys
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOPROXYS'].
					" WHERE proxyname='".$dbSocket->escapeSimple($proxyname)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				$successMsg = "Deleted proxy(s): <b> $allProxys </b>";
				$logAction .= "Successfully deleted proxy(s) [$allProxys] on page: ";
				
			} else { 
				$failureMsg = "no proxy was entered, please specify a proxy name to remove from database";
				$logAction .= "Failed deleting proxy(s) [$allProxys] on page: ";
			}

		} //foreach

		/*******************************************************************/
		/* enumerate from database all proxy entries */
		include_once('include/management/saveRealmsProxys.php');
		/*******************************************************************/

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
include ("menu-mng-rad-realms.php");
?>

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/management-subnav.php");
	?>
	<div class="container">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradproxysdel.php') ?>
		<h144>&#x2754;</h144></a></h2>
		
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradproxysdel') ?>
			<br/>
		</div>
		<?php   
			include_once('include/management/actionMessages.php');
		?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','ProxyInfo') ?> </h302>
		<br/>

			<label for='proxyname' class='form'><?php echo t('all','ProxyName') ?></label>
			<input name='proxyname[]' type='text' id='proxyname' value='<?php echo $proxyname ?>' tabindex=100 />
			<br/>

			<br/><br/>
			<hr><br/>

			<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=1000  class='button' />

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





