<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['profile']) ? $profile = $_REQUEST['profile'] : $profile = "";
	isset($_REQUEST['attribute']) ? $attribute = $_REQUEST['attribute'] : $attribute = "";
	isset($_REQUEST['tablename']) ? $tablename = $_REQUEST['tablename'] : $tablename = "";

	isset($_REQUEST['profile_delete_assoc']) ? $removeProfileAssoc = $_REQUEST['profile_delete_assoc'] : $removeProfileAssoc = "";
	if ($removeProfileAssoc == '1')
		$removeProfileAssoc = true;
	else
		$removeProfileAssoc = false;


	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if ( (isset($_REQUEST['profile'])) && (!(isset($_REQUEST['attribute']))) && (!(isset($_REQUEST['tablename']))) ) {

		$allProfiles = "";
		$isSuccessful = 0;

		if (!is_array($profile))
			$profile = array($profile, NULL);

		foreach ($profile as $variable=>$value) {

			if (trim($variable) != "") {

				$profile = $value;
				$allProfiles .= $profile . ", ";

				include 'library/opendb.php';

				// delete all attributes associated with a profile
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].
					" WHERE GroupName='".$dbSocket->escapeSimple($profile)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].
					" WHERE GroupName='".$dbSocket->escapeSimple($profile)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				// delete all user associations with the profile
				if ($removeProfileAssoc == true) {
					$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].
						" WHERE GroupName='".$dbSocket->escapeSimple($profile)."'";
					$res = $dbSocket->query($sql);
					$logDebugSQL .= $sql . "\n";
				}


				$successMsg = "Deleted profile(s): <b> $allProfiles </b>";
				$logAction .= "Successfully deleted profile(s) [$allProfiles] on page: ";

				include 'library/closedb.php';

			}  else {
				$failureMsg = "no profile was entered, please specify a profile to remove from database";
				$logAction .= "Failed deleting profile(s) [$allProfiles] on page: ";
			}

		} //foreach

		$showRemoveDiv = "none";

	} else  if ( (isset($_REQUEST['profile'])) && (isset($_REQUEST['attribute'])) && (isset($_REQUEST['tablename'])) ) {

		/* this section of the deletion process only deletes the username record with the specified attribute
		 * variable from $tablename, this is in order to support just removing a single attribute for the user
		 */

		include 'library/opendb.php';

                if (isset($attribute)) {
                        if (preg_match('/__/', $attribute))
                                list($columnId, $attribute) = explode("__", $attribute);
                        else
                                $attribute = $attribute;
                }

		$sql = "DELETE FROM ".$dbSocket->escapeSimple($tablename)." WHERE GroupName='".$dbSocket->escapeSimple($profile).
				"' AND Attribute='".$dbSocket->escapeSimple($attribute)."' AND id=".$dbSocket->escapeSimple($columnId);
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		$successMsg = "Deleted attribute: <b> $attribute </b> for profile(s): <b> $profile </b> from database";
		$logAction .= "Successfully deleted attribute [$attribute] for profile [$profile] on page: ";

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
	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<title>GwijiNet</title>
</head>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>
 
<?php
	include ("menu-mng-rad-profiles.php");
?>

	<div id="contentnorightbar">
		<?php
			include_once ("include/menu/management-subnav.php");
		?>
		
		<div class="container">

				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradprofilesdel.php') ?>
				:: <?php if (isset($profile)) { echo $profile; } ?><h144>&#x2754;</h144></a></h2>

				<div id="helpPage" style="display:none;visibility:visible" >
					<?php echo t('helpPage','mngradprofilesdel') ?>
					<br/>
				</div>
                <?php
					include_once('include/management/actionMessages.php');
                ?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <fieldset>

                <h302> <?php echo t('title','ProfileInfo') ?> </h302>
                <br/>

                <label for='profile' class='form'>Profile Name</label>
                <input name='profile[]' type='text' id='profile' value='<?php echo $profile ?>' tabindex=100 />
                <br/>

                <label for='profile' class='form'>Remove all user associations with this profile(s)</label>
                <input name='profile_delete_assoc' type='checkbox' id='profile_delete_assoc' value='1' tabindex=100 />
                <br/>

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
