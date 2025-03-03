<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_GET['username']) ? $username = $_GET['username'] : $username = "";
	isset($_GET['attribute']) ? $attribute = $_GET['attribute'] : $attribute = "";
	isset($_GET['tablename']) ? $tablename = $_GET['tablename'] : $tablename = "";
	isset($_GET['delradacct']) ? $delradacct = $_GET['delradacct'] : $delradacct = "";
	isset($_GET['clearSessionsUsers']) ? $clearSessionsUsers = $_GET['clearSessionsUsers'] : $clearSessionsUsers = "";

	$logAction = "";
	$logDebugSQL = "";

	$showRemoveDiv = "block";

	if ( (isset($_GET['username'])) && (!(isset($_GET['attribute']))) && (!(isset($_GET['tablename']))) ) {

		$allUsernames = "";
		$isSuccessful = 0;

		/* since the foreach loop will report an error/notice of undefined variable $value because
		   it is possible that the $username is not an array, but rather a simple GET request
		   with just some value, in this case we check if it's not an array and convert it to one with
		   a NULL 2nd element
		*/
		if (!is_array($username))
			$username = array($username, NULL);

		foreach ($username as $variable=>$value) {

			if (trim($variable) != "") {

				$username = $value;
				$allUsernames .= $username . ", ";

				include 'library/opendb.php';

				// setting table-related parameters first
				switch($configValues['FREERADIUS_VERSION']) {
					case '1' :
						$tableSetting['postauth']['user'] = 'user';
						$tableSetting['postauth']['date'] = 'date';
						break;
					case '2' :
						// down
					case '3' :
						// down
					default  :
						$tableSetting['postauth']['user'] = 'username';
						$tableSetting['postauth']['date'] = 'authdate';
						break;
				}

				// delete all attributes associated with a username
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." WHERE Username='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADREPLY']." WHERE Username='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." WHERE Username='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_DALOUSERBILLINFO']." WHERE Username='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." WHERE Username='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADPOSTAUTH']." WHERE ".
					$tableSetting['postauth']['user']."='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				if (strtolower($delradacct) == "yes") {
					$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADACCT']." WHERE Username='".$dbSocket->escapeSimple($username)."'";
					$res = $dbSocket->query($sql);
					$logDebugSQL .= $sql . "\n";
				}

				$successMsg = "Deleted user(s): <b> $allUsernames </b>";
				$logAction .= "Successfully deleted user(s) [$allUsernames] on page: ";

				include 'library/closedb.php';

			}  else {
				$failureMsg = "no user was entered, please specify a username to remove from database";
				$logAction .= "Failed deleting user(s) [$allUsernames] on page: ";
			}


		$showRemoveDiv = "none";

		} //foreach


	} else 	if ( (isset($_GET['username'])) && (isset($_GET['attribute'])) && (isset($_GET['tablename'])) ) {

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

		$sql = "DELETE FROM ".$dbSocket->escapeSimple($tablename)." WHERE Username='".$dbSocket->escapeSimple($username)."' ".
				" AND Attribute='".$dbSocket->escapeSimple($attribute)."' AND id=".$dbSocket->escapeSimple($columnId);
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		$successMsg = "Deleted attribute: <b> $attribute </b> for user(s): <b> $username </b> from database";
		$logAction .= "Successfully deleted attribute [$attribute] for user [$username] on page: ";

		include 'library/closedb.php';

		$showRemoveDiv = "none";

	} else if ( (isset($clearSessionsUsers)) && ($clearSessionsUsers != "") ) {

		/* this is used to remove stale user sessions from the accounting table
		*/
		$allUsernames = "";

		if (!is_array($clearSessionsUsers))
			$clearSessionsUsers = array($clearSessionsUsers, NULL);

			foreach ($clearSessionsUsers as $variable=>$value) {

				if (trim($value) != "") {

					list($userSessions,$acctStartTime) = preg_split('/\\|\\|/', $value);

					$allUsernames .= $userSessions . ", ";

					include 'library/opendb.php';

					$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADACCT'].
						" WHERE Username='$userSessions' AND AcctStartTime='$acctStartTime' ".
						" AND (AcctStopTime='0000-00-00 00:00:00' OR AcctStopTime IS NULL)";
					$res = $dbSocket->query($sql);
					$logDebugSQL .= $sql . "\n";

					$successMsg = "Deleted stale accounting sessions for user: <b> $allUsernames </b> from database";
					$logAction .= "Successfully deleted stale accounting sessions for user [$allUsernames] on page: ";

					include 'library/closedb.php';
			} // if trim

		} // foreach

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
  <link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />
  <link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css"/>
</head>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<?php

	include ("menu-mng-users.php");

?>


<div id="contentnorightbar">
  <?php
    include_once("include/menu/management-subnav.php");
  ?>

  <div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngdel.php') ?>
	:: <?php if (isset($username)) { echo $username; } ?><h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >
		<?php echo t('helpPage','mngdel') ?>
		<br/>
	</div>
	<?php
		include_once('include/management/actionMessages.php');
	?>

	<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

	<fieldset>

		<h302> <?php echo t('title','AccountRemoval') ?> </h302>
		<br/>

		<label for='username' class='form'><?php echo t('all','Username')?></label>
		<input name='username[]' type='text' id='username' value='<?php echo $username ?>' tabindex=100 />
		<br />

		<label for='delradacct' class='form'><?php echo t('all','RemoveRadacctRecords')?></label>
		<select class='form' tabindex=102 name='delradacct' tabindex=101>
			<option value='no'>no</option>
			<option value='yes'>yes</option>
		</select>
		<br />

		<br/><br/>
		<hr><br/>
		<input type="submit" name="submit" value="<?php echo t('buttons','apply') ?>" tabindex=1000
			class='button' />

	</fieldset>

	</form>
	</div>


<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('username','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
