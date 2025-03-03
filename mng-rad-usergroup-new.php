<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	// declaring variables
	isset($_GET['username']) ? $username = $_GET['username'] : $username = "";
	isset($_GET['group']) ? $group = $_GET['group'] : $group = "";
	isset($_GET['priority']) ? $priority = $_GET['priority'] : $priority = "";

	$logDebugSQL = "";
	$logAction = "";

	if (isset($_POST['submit'])) {
	
		$username = $_REQUEST['username'];
		$group = $_REQUEST['group'];;
		$priority = $_REQUEST['priority'];;

		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].
				" WHERE UserName='".$dbSocket->escapeSimple($username)."' AND GroupName='".$dbSocket->escapeSimple($group)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {

			if (trim($username) != "" and trim($group) != "") {

				if (!isset($priority)) {
					$priority = 1;		// default in mysql table for usergroup
				}
				
				// insert usergroup details
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." (UserName,GroupName,priority) ".
						" VALUES ('".$dbSocket->escapeSimple($username)."', '".
						$dbSocket->escapeSimple($group)."', ".$dbSocket->escapeSimple($priority).")";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				$successMsg = "Added new User-Group mapping to database: User<b> $username </b> and Group: <b> $group </b> ";
				$logAction .= "Successfully added user-group mapping of user [$username] with group [$group] on page: ";
			} else {
				$failureMsg = "no username or groupname was entered, it is required that you specify both username and groupname";
				$logAction .= "Failed adding (missing attributes) for user or group on page: ";
			}
		} else {
			$failureMsg = "The user $username already exists in the user-group mapping database";
			$logAction .= "Failed adding already existing user-group mapping for user [$username] with group [$group] on page: ";
		}

		include 'library/closedb.php';
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

<?php
	include ("menu-mng-rad-usergroup.php");
?>

	<div id="contentnorightbar">

		<?php
			include_once("include/menu/management-subnav.php");
		?>
		
		<div class="container">
	
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradusergroupnew.php') ?>
		<h144>&#x2754;</h144></a></h2>


		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradusergroupnew') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>
		
		<form name="newusergroup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <fieldset>

			<h302> <?php echo t('title','GroupInfo') ?> </h302>
			<br/>

		<ul>

			<li class='fieldset'>
			<label for='username' class='form'><?php echo t('all','Username') ?></label>
			<input name='username' type='text' id='username' value='<?php echo $username ?>' tabindex=100 />
			</li>

			<li class='fieldset'>
			<label for='group' class='form'><?php echo t('all','Groupname') ?></label>
			<?php   
				include 'include/management/populate_selectbox.php';
				populate_groups("Select Groups","group","long");
			?>
			<div id='groupTooltip'  style='display:none;visibility:visible' class='ToolTip'>
				<img src='images/icons/comment.png' alt='Tip' border='0' />
				<?php echo t('Tooltip','groupTooltip') ?>
			</div>
			</li>


			<li class='fieldset'>
				<label for='priority' class='form'><?php echo t('all','Priority') ?></label>
				<input class='integer' name='priority' type='text' id='priority' value='0' tabindex=102 />
				<img src="images/icons/bullet_arrow_up.png" alt="+" onclick="javascript:changeInteger('priority','increment')" />
				<img src="images/icons/bullet_arrow_down.png" alt="-" onclick="javascript:changeInteger('priority','decrement')"/>
			</li>	

			<li class='fieldset'>
				<br/>
				<hr><br/>
				<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />
			</li>


		</ul>
	</fieldset>




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
