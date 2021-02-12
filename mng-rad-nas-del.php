<?php

include ("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');


isset($_REQUEST['nashost']) ? $nashost = $_REQUEST['nashost'] : $nashost = "";

$logAction = "";
$logDebugSQL = "";

$showRemoveDiv = "block";

if (isset($_REQUEST['nashost'])) {

	$allNASs = "";

		/* since the foreach loop will report an error/notice of undefined variable $value because
                   it is possible that the $nashost is not an array, but rather a simple GET request
                   with just some value, in this case we check if it's not an array and convert it to one with
                   a NULL 2nd element
		*/

                   if (!is_array($nashost))
                   	$nashost = array($nashost, NULL);

                   foreach ($nashost as $variable=>$value) {

                   	if (trim($variable) != "") {

                   		include 'library/opendb.php';

                   		$nashost = $value;
                   		$allNASs .= $nashost . ", ";
			//echo "nas: $nashost <br/>";


			// delete all attributes associated with a username
                   		$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADNAS'].
                   		" WHERE nasname='".$dbSocket->escapeSimple($nashost)."'";
                   		$res = $dbSocket->query($sql);
                   		$logDebugSQL .= $sql . "\n";

                   		$successMsg = "Deleted all NASs from database: <b> $allNASs </b>";
                   		$logAction .= "Successfully deleted nas(s) [$allNASs] on page: ";

                   		include 'library/closedb.php';

                   	}  else {
                   		$failureMsg = "No nas ip/host was entered, please specify a nas ip/host to remove from database";
                   		$logAction .= "Failed deleting empty nas on page: ";
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

	<?php
	include ("menu-mng-rad-nas.php");
	?>

	<div id="contentnorightbar">
		<div class="container">

			<?php
			include_once("include/menu/management-subnav.php");
			?>

			<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradnasdel.php') ?>
			:: <?php if (isset($nashost)) { echo $nashost; } ?><h144>&#x2754;</h144></a></h2>

			<div id="helpPage" style="display:none;visibility:visible" >
				<?php echo t('helpPage','mngradnasdel') ?>
				<br/>
			</div>
			<?php
			include_once('include/management/actionMessages.php');
			?>

			<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

					<fieldset>

						<h302> <?php echo t('title','NASInfo') ?> </h302>
						<br/>

						<label for='nashost' class='form'><?php echo t('all','NasIPHost') ?></label>
						<input name='nashost' type='text' id='nashost' value='' tabindex=100 />
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

<?php
include_once("include/management/autocomplete.php");

if ($autoComplete) {
	echo "<script type=\"text/javascript\">
	autoComEdit = new DHTMLSuite.autoComplete();
	autoComEdit.add('nashost','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteNASHost');
	</script>";
}

?>

</body>
</html>
