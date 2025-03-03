<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');



	include 'library/opendb.php';

	// declaring variables
	$username = "";
	$group = "";
	$groupOld = "";
	$priority = "";

	$username = $_REQUEST['username'];
	$groupOld = $_REQUEST['group'];

	$logAction = "";
	$logDebugSQL = "";

	// fill-in nashost details in html textboxes
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].
		" WHERE UserName='".$dbSocket->escapeSimple($username)."' AND GroupName='".$dbSocket->escapeSimple($groupOld)."'";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";
	$row = $res->fetchRow();		// array fetched with values from $sql query

	// assignment of values from query to local variables
	// to be later used in html to display on textboxes (input)
	$priority = $row[2];

	if (isset($_POST['submit'])) {
		$username = $_REQUEST['username'];
		$groupOld = $_REQUEST['groupOld'];;
		$group = $_REQUEST['group'];;
		$priority = $_REQUEST['priority'];;
		
		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].
			" WHERE UserName='".$dbSocket->escapeSimple($username)."' AND GroupName='".$dbSocket->escapeSimple($groupOld)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 1) {

			if (trim($username) != "" and trim($group) != "") {

				if (!isset($priority)) {
					$priority = 1;
				}

				// insert nas details
				$sql = "UPDATE ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." SET GroupName='".$dbSocket->escapeSimple($group)."',
priority='".$dbSocket->escapeSimple($priority)."' WHERE UserName='".$dbSocket->escapeSimple($username)."'
AND GroupName='".$dbSocket->escapeSimple($groupOld)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
						
				$successMsg = "Updated User-Group mapping in database: User<b> $username </b> and Group: <b> $group </b> ";
				$logAction .= "Successfully updated attributes for user-group mapping of user [$username] with group [$group] on page: ";
			} else {
				$failureMsg = "no username or groupname was entered, it is required that you specify both username and groupname";
				$logAction .= "Failed updating (missing attributes) attributes on page: ";
			}
		} else {
			$failureMsg = "The user $username already exists in the user-group mapping database
			<br/> It seems that you have duplicate entries for User-Group mapping. Check your database";
			$logAction .= "Failed updating already existing user [$username] with group [$group] on page: ";
		} 

		include 'library/closedb.php';
	}
	
	if (isset($_REQUEST['username']))
		$username = $_REQUEST['username'];
	else
		$username = "";

	if (isset($_REQUEST['group']))
		$group = $_REQUEST['group'];
	else
		$group = "";

	if (trim($username) == "" OR trim($group) == "") {
		$failureMsg = "no username or groupname was entered, please specify a username and groupname to edit ";
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
	
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradusergroupedit') ?> 
		<?php echo $username ?><h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradusergroupedit') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>
				
		<form name="newuser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

			<input type="hidden" value="<?php echo $username ?>" name="username" />

        <fieldset>

                <h302> <?php echo t('title','GroupInfo') ?> </h302>
                <br/>

                <ul>

                <li class='fieldset'>
                <label for='username' class='form'><?php echo t('all','Username') ?></label>
                <input type='hidden' name='username' type='text' id='username' value='<?php echo $username ?>' tabindex=100 />
                <input disabled type='text' id='username' value='<?php echo $username ?>' tabindex=100 />
                </li>


                <li class='fieldset'>
                <label for='groupOld' class='form'><?php echo t('all','CurrentGroupname') ?></label>
                <input type='hidden' name='groupOld' id='groupOld' value='<?php echo $groupOld ?>' tabindex=101 />
                <input disabled type='text' id='groupOld' value='<?php echo $groupOld ?>' tabindex=101 />
				Old Group Name
                </li>

                <li class='fieldset'>
                <label for='group' class='form'><?php echo t('all','NewGroupname') ?></label>
                <?php   
					include 'include/management/populate_selectbox.php';
					populate_groups("Select Groups","group","form");
                ?>
                <div id='groupTooltip'  style='display:none;visibility:visible' class='ToolTip'>
					<img src='images/icons/comment.png' alt='Tip' border='0' />
					<?php echo t('Tooltip','groupTooltip') ?>
                </div>
                </li>


                <li class='fieldset'>
                <label for='priority' class='form'><?php echo t('all','Priority') ?></label>
                <input class='integer' name='priority' type='text' id='priority' value='<?php echo $priority ?>' tabindex=103 />
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
