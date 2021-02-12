<?php 

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_REQUEST['enddate']) ? $enddate = $_REQUEST['enddate'] : $enddate = "";
	isset($_REQUEST['startdate']) ? $startdate = $_REQUEST['startdate'] : $startdate = "";
	isset($_REQUEST['username']) ? $username = $_REQUEST['username'] : $username = "";

	$logAction =  "";
	$logDebugSQL = "";

	if (isset($_POST['submit'])) {

		if ( (trim($startdate) != "") || (trim($enddate) != "") || (trim($username) != "") ) {
			
			include 'library/opendb.php';

			$deleteUsername = "";
			if (trim($username) != "")
				$deleteUsername = " AND Username='$username'";

			$deleteEnddate = "";
			if (trim($enddate) != "")
				$deleteEnddate = " AND AcctStartTime<'".$dbSocket->escapeSimple($enddate)."'";

			$deleteStartdate = "";
			if (trim($startdate) != "")
				$deleteStartdate = " AND AcctStartTime>'".$dbSocket->escapeSimple($startdate)."'";


			$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADACCT'].
				" WHERE 1=1".
				" $deleteStartdate".
				" $deleteEnddate".
				" $deleteUsername ";
			$res = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";

			$successMsg = "Deleted records between <b>$startdate</b> to <b>$enddate</b> for user <b>$username</b>";
			$logAction .= "Successfully deleted records between [$startdate] and [$enddate] for user [$username] on page: ";

			include 'library/closedb.php';

		}  else { 
			$failureMsg = "no username, ending date or starting date was provided, please at least one of those";
			$logAction .= "Failed deleting records from database, missing fields on page: ";
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

	<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">

	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<link rel="stylesheet" href="css/dtech/bootstrap.min.css">
	<link rel="stylesheet" href="css/dtech/style.css">

	<title>GwijiNet</title>
</head>

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>
 
<?php
	include ("menu-accounting-maintenance.php");	
?>

	<div id="contentnorightbar">
		<?php
		include_once ("include/menu/accounting-subnav.php");
		?>

		<div class="container">
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','acctmaintenancedelete.php') ?>
		<h144>&#x2754;</h144></a></h2>
		
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','acctmaintenancedelete') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>
		
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>

			<h302> <?php echo t('title','DeleteRecords') ?> </h302>
			<br/>

			<label for='username' class='form'><?php echo t('all','Username')?></label>
			<input name='username' type='text' id='username' value='<?php echo $username ?>' tabindex=100 />
			<br />

			<label for='startdate' class='form'><?php echo t('all','StartingDate')?></label>
			<input name='startdate' type='text' id='startdate' value='<?php echo $startdate ?>' tabindex=100 />
			<img src="library/js_date/calendar.gif" onclick=
			"showChooser(this, 'startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d H:i:s', true);" >
			<br />

			<label for='enddate' class='form'><?php echo t('all','EndingDate')?></label>
			<input name='enddate' type='text' id='enddate' value='<?php echo $enddate ?>' tabindex=100 />
			<img src="library/js_date/calendar.gif" onclick=
			"showChooser(this, 'enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d H:i:s', true);" >
			<br />

			<br/><br/>
			<hr><br/>
			<input type="submit" name="submit" value="<?php echo t('buttons','apply') ?>" tabindex=1000 class='button' />

	</fieldset>

	<div id="chooserSpan" class="dateChooser select-free" 
		style="display: none; visibility: hidden; width: 160px;">
	</div>

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





