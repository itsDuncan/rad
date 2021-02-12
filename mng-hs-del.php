<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['name']) ? $name = $_REQUEST['name'] : $name = "";
	$logAction = "";
	$logDebugSQL = "";

        $showRemoveDiv = "block";

	if (isset($_REQUEST['name'])) {

		if (!is_array($name))
			$name = array($name, NULL);

		$allHotspots = "";

		include 'library/opendb.php';

		foreach ($name as $variable=>$value) {
			if (trim($value) != "") {

				$name = $value;
				$allHotspots .= $name . ", ";

				// delete all attributes associated with a username
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']." WHERE name='".
						$dbSocket->escapeSimple($name)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$successMsg = "Deleted hotspot(s): <b> $allHotspots </b>";
				$logAction .= "Successfully deleted hotspot(s) [$allHotspots] on page: ";

			} else {
				$failureMsg = "no hotspot was entered, please specify a hotspot name to remove from database";
				$logAction .= "Failed deleting hotspot(s) [$allHotspots] on page: ";
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

  <link rel="stylesheet" href="css/dtech/bootstrap.min.css">
  <link rel="stylesheet" href="css/dtech/style.css">

  <title>GwijiNet</title>
</head>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<?php

	include ("menu-mng-hs.php");

?>

<div id="contentnorightbar">
  <?php
    include_once("include/menu/management-subnav.php");
  ?>

  <div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mnghsdel.php') ?>
	:: <?php if (isset($name)) { echo $name; } ?><h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >
		<?php echo t('helpPage','mnghsdel') ?>
		<br/>
	</div>
	<?php
		include_once('include/management/actionMessages.php');
	?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','HotspotRemoval') ?> </h302>
		<br/>

		<label for='name' class='form'><?php echo t('all','HotSpotName') ?></label>
		<input name='name[]' type='text' id='name' value='<?php echo $name ?>' tabindex=100 autocomplete="off" />
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
                      autoComEdit.add('name','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteHotspots');
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
