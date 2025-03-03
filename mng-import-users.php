<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	$logAction = "";
	$logDebugSQL = "";

	isset($_POST['csvdata']) ? $csvdata = $_POST['csvdata'] : $csvdata = "";
	isset($_POST['groups']) ? $groups = $_POST['groups'] : $groups = "";
	isset($_POST['planName']) ? $planName = $_POST['planName'] : $planName = "";
	isset($_POST['userType']) ? $userType = $_POST['userType'] : $userType = "";

	if (isset($_POST['submit'])) {

		$users = array();
		if ( (isset($csvdata)) && (!empty($csvdata)) ) {

			$csvFormattedData = explode("\n", $csvdata);

			include 'library/opendb.php';

			// initialize some required variables

			$currDate = date('Y-m-d H:i:s');
			$currBy = $_SESSION['operator_user'];

			$passwordType = $_POST['passwordType'];

			$userCount = 0;

			//var_dump($csvFormattedData);
			foreach($csvFormattedData as $csvLine) {
				//list($user, $pass) = explode(",", $csvLine);
				$users = explode(",", $csvLine);

				//makeing sure user and pass are specified and are not empty
				//columns by chance
				if ( (isset($users[0]) && (!empty($users[0])))
						&&
						((isset($users[1]) && (!empty($users[1])))) )
					{

						$user = trim($dbSocket->escapeSimple($users[0]));
						$pass = trim($dbSocket->escapeSimple($users[1]));

						// perform further cleanup on $pass to make sure it doesn't contain invalid chars like \r\n
						// whether they are literal or encoded
						$pass = str_replace("\\r", "", $pass);
						$pass = str_replace("\\n", "", $pass);
						$pass = str_replace(chr(0xC2), "", $pass);
						$pass = str_replace(chr(0xA0), "", $pass);

						$planName = trim($dbSocket->escapeSimple($planName));
						$userType = trim($dbSocket->escapeSimple($userType));

						if ($userType == "userType") {
							$passwordType = "Auth-Type";
							$pass = "Accept";
						}

						// insert username/password into radcheck
						$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADCHECK'].
								" (id,Username,Attribute,op,Value) ".
								" VALUES (0, '$user', '$passwordType', ".
								" ':=', '$pass')";
						$res = $dbSocket->query($sql);
						$logDebugSQL .= $sql . "\n";

						// insert user into userinfo table
						$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].
								" (id,username,creationdate,creationby) ".
								" VALUES (0, '$user', '$currDate', '$currBy')";
						$res = $dbSocket->query($sql);
						$logDebugSQL .= $sql . "\n";

						// associate user with groups (profiles)
						foreach($groups as $groupName) {

							if ( (isset($groupName)) && (!empty($groupName)) ) {

								$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." (UserName,GroupName,priority) ".
									" VALUES ('".$dbSocket->escapeSimple($user)."', '".$dbSocket->escapeSimple($groupName)."',0) ";
								$res = $dbSocket->query($sql);
								$logDebugSQL .= $sql . "\n";

							}
						}


						// associate user with plans
						if ( (isset($planName)) && (!empty($planName)) ) {
							$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_DALOUSERBILLINFO'].
									" (id,planname,username,creationdate,creationby) ".
									" VALUES (0, '$planName', '$user', '$currDate', '$currBy')";
							$res = $dbSocket->query($sql);
							$logDebugSQL .= $sql . "\n";
						}






						$userCount++;

					}
			}

			include 'library/closedb.php';

		   $successMsg = "Successfully imported a total of <b>$userCount</b> users to database";
		   $logAction .= "Successfully imported a total of <b>$userCount</b> users to database on page: ";

		} else {

		   $failureMsg = "No CSV data was provided";
		   $logAction .= "Failed importing users, no CSV data was provided on page: ";
		}

	} //if (isset)


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

<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/productive_funcs.js" type="text/javascript"></script>
<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>

<?php

	include ("menu-mng-users.php");

?>

	<div id="contentnorightbar">
    <?php
      include_once("include/menu/management-subnav.php");
    ?>

    <div class="container">
      
			<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngimportusers.php') ?>
			<h144>&#x2754;</h144></a></h2>

			<div id="helpPage" style="display:none;visibility:visible" >
				<?php echo t('helpPage','mngimportusers') ?>
				<br/>
			</div>
			<?php
				include_once('include/management/actionMessages.php');
			?>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<fieldset>

		<h302> <?php echo t('title','ImportUsers'); ?> </h302>
		<br/>

		<ul>

		Paste a CSV-formatted data input of users, expected format is: user,password<br/>
		Note: any CSV fields beyond the first 2 (user and password) are ignored<br/>
		<br/>


		<li class='fieldset'>
		<label for='passwordType' class='form'><?php echo t('all','PasswordType')?> </label>
		<select class='form' tabindex=102 name='passwordType' >
			<option value='Cleartext-Password'>Cleartext-Password</option>
			<option value='User-Password'>User-Password</option>
			<option value='Crypt-Password'>Crypt-Password</option>
			<option value='MD5-Password'>MD5-Password</option>
			<option value='SHA1-Password'>SHA1-Password</option>
			<option value='CHAP-Password'>CHAP-Password</option>
		</select>
		</li>

		<li class='fieldset'>
		<label for='group' class='form'><?php echo t('all','Group')?></label>
		<?php
			include_once 'include/management/populate_selectbox.php';
			populate_groups("Select Groups","groups[]");
		?>

		<a class='tablenovisit' href='#'
			onClick="javascript:ajaxGeneric('include/management/dynamic_groups.php','getGroups','divContainerGroups',genericCounter('divCounter')+'&elemName=groups[]');">Add</a>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('group')" />
		<div id='divContainerGroups'>
		</div>


		<li class='fieldset'>
		<label for='planName' class='form'><?php echo t('all','PlanName') ?></label>
                <?php
                       populate_plans("Select Plan","planName","form");
                ?>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planNameTooltip')" />

		<div id='planNameTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','planNameTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='userType' class='form'><?php echo t('all','UserType') ?></label>
		<input type='checkbox' name='userType' value='userType' /> If users are MAC or PIN based authentication, check this box
		</li>






		<li class='fieldset'>
		<label for='csvdata' class='form'><?php echo t('all','CSVData') ?></label>
		<textarea class='form_fileimport' name='csvdata' tabindex=101></textarea>
		</li>


		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=10000 class='button' />
		</li>

		</ul>
	</fieldset>

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
