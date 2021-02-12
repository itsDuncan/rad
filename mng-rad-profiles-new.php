<?php

include ("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');

	// declaring variables
	//	isset($_GET['profile']) ? $group = $_GET['profile'] : $profile = "";

$logAction = "";
$logDebugSQL = "";

if (isset($_POST['submit'])) {
	
	$profile = $_POST['profile'];
	if ($profile != "") {

		include 'library/opendb.php';

			$attrCount = 0;					// counter for number of attributes
			foreach($_POST as $element=>$field) { 
				
				switch ($element) {
					case "submit":
					case "profile":
					$skipLoopFlag = 1; 
					break;
				}
				
				if ($skipLoopFlag == 1) {
					$skipLoopFlag = 0;             
					continue;
				}

				if (isset($field[0]))
					$attribute = $field[0];
				if (isset($field[1]))
					$value = $field[1];
				if (isset($field[2]))
					$op = $field[2];
				if (isset($field[3]))
					$table = $field[3];

				if ($table == 'check')
					$table = $configValues['CONFIG_DB_TBL_RADGROUPCHECK'];
				if ($table == 'reply')
					$table = $configValues['CONFIG_DB_TBL_RADGROUPREPLY'];


				if (!($value) || $table == '')
					continue;

				$sql = "INSERT INTO $table (id,GroupName,Attribute,op,Value) ".
				" VALUES (0, '".$dbSocket->escapeSimple($profile)."', '".
				$dbSocket->escapeSimple($attribute)."','".$dbSocket->escapeSimple($op)."', '".
				$dbSocket->escapeSimple($value)."')  ";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$attrCount++;				// increment attribute count

			}

			if ($attrCount == 0) {
				$failureMsg = "Failed adding profile name [$profile] - no attributes where provided by user";
				$logAction .= "Failed adding profile name [$profile] - no attributes where provided by user on page: ";
			} else {
				$successMsg = "Added to database new profile: <b> $profile </b>";
				$logAction .= "Successfully added new profile [$profile] on page: ";
			}

			include 'library/closedb.php';

		} else { // if $profile != ""
		$failureMsg = "profile name is empty";
		$logAction .= "Failed adding (possibly empty) profile name [$profile] on page: ";
	}

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
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradprofilesnew.php') ?>
		<h144>&#x2754;</h144></a></h2>


		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradprofilesnew') ?>
			<br/>
		</div>
		<?php
		include_once('include/management/actionMessages.php');
		?>
		
		<form name="newusergroup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

			<fieldset>

				<h302> <?php echo t('title','ProfileInfo') ?> </h302>
				<br/>

				<label for='profile' class='form'>Profile Name</label>
				<input name='profile' type='text' id='profile' value='' tabindex=100 />
				<br />

				<br/><br/>
				<hr><br/>

				<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />

			</fieldset>


			<br/>


			<?php
			include_once('include/management/attributes.php');
			?>
			
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
