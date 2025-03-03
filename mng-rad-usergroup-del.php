<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	$username = "";
	$group = "";

	$showRemoveDiv = "block";

	if (isset($_POST['usergroup'])) {
		$usergroup_array = $_REQUEST['usergroup'];
	} else {
		if (isset($_POST['username']))
			$usergroup_array = array($_REQUEST['username']."||".$_REQUEST['group']);
	}

	$logAction = "";
	$logDebugSQL = "";

	if (isset($usergroup_array)) {

		foreach ($usergroup_array as $usergroup) {

		list($username, $group) = preg_split('\|\|', $usergroup);

		if (trim($username) != "") {

			$allGroups =  "";
			$allUsernames = "";
			include 'library/opendb.php';

			if (trim($group) != "") {

				// // delete only a specific groupname and it's attribute
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].
					" WHERE UserName='".$dbSocket->escapeSimple($username)."' AND GroupName='".$dbSocket->escapeSimple($group)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$allUsernames .= $username . ", ";
				$allGroups .= $group . ", ";
				$successMsg = "Deleted all Usernames: <b> $allUsernames </b> and all their Groupnames: <b> $allGroups </b>";
				$logAction .= "Successfully deleted all users [$allUsernames] and their groups [$allGroups] on page: ";

				include 'library/closedb.php';

			} else {
				// delete all attributes associated with a username
				$sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].
						" WHERE UserName='".$dbSocket->escapeSimple($username)."'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$successMsg = "Deleted all instances for Username: <b> $allUsernames </b>";
				$logAction .= "Successfully deleted all group instances for users [$allUsernames] on page: ";

				include 'library/closedb.php';
			}

			$showRemoveDiv = "none";

		}  else {
			$failureMsg = "No user was entered, please specify a username to remove from database";
			$logAction .= "Failed deleting empty user on page: ";
		}

		} //foreach
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

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradusergroupdel.php') ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradusergroupdel') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>

		<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <fieldset>

                <h302> <?php echo t('title','GroupInfo') ?> </h302>
                <br/>

                <input type="hidden" value="<?php echo $group ?>" name="group"/><br/>

                <ul>

                <li class='fieldset'>
                <label for='username' class='form'><?php echo t('all','Username') ?></label>
                <input name='username' type='text' id='username' value='<?php echo $username ?>' tabindex=100 />
                </li>

                <li class='fieldset'>
                <label for='group' class='form'><?php echo t('all','Groupname') ?></label>
                <input name='group' type='text' id='group' value='<?php echo $group ?>' tabindex=101 />
                <?php
                        include 'include/management/populate_selectbox.php';
                        populate_groups("Select Groups","long");
                ?>
                <div id='groupTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo t('Tooltip','groupTooltip') ?>
                </div>
                </li>


                <li class='fieldset'>
                <br/>
                <hr><br/>
                <input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />
                </li>

		</ul>
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
