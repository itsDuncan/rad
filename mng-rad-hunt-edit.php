<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
        
	include('library/check_operator_perm.php');



    include 'library/opendb.php';

	$nasipaddress = "";
	$nasportid = "";
	$groupname = "";

	isset($_REQUEST['nasipaddress']) ? $nasipaddress = $_REQUEST['nasipaddress'] : $nasipaddress = "";
	isset($_REQUEST['groupname']) ? $groupname = $_REQUEST['groupname'] : $groupname = "";

	$logAction = "";
	$logDebugSQL = "";

	// fill-in nashost details in html textboxes
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADHG']." WHERE nasipaddress='".$dbSocket->escapeSimple($nasipaddress).
			"' AND groupname='".$dbSocket->escapeSimple($groupname)."'";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	$row = $res->fetchRow();		// array fetched with values from $sql query

	// assignment of values from query to local variables
	// to be later used in html to display on textboxes (input)
	$groupname = $row[1];
	$nasipaddress = $row[2];
	$nasportid = $row[3];
	

	if (isset($_POST['submit'])) {
	
		$nasipaddressold = $_REQUEST['nasipaddressold'];
		$nasipaddress = $_REQUEST['nasipaddress'];
		$nasportid = $_REQUEST['nasportid'];
		$nasportidold = $_REQUEST['nasportidold'];
		$groupname = $_REQUEST['groupname'];

			
		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADHG'].
		" WHERE nasipaddress='".$dbSocket->escapeSimple($nasipaddressold).
		"' AND nasportid='". $dbSocket->escapeSimple($nasportidold)."' ";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 1) {

			if (trim($nasipaddress) != "" and trim($groupname) != "") {

				if (!$nasportid) {
					$nasportid = 0;
				}

				// insert nas details
				$sql = "UPDATE ".$configValues['CONFIG_DB_TBL_RADHG'].
					" SET nasipaddress='".$dbSocket->escapeSimple($nasipaddress)."', ".
					" groupname='".$dbSocket->escapeSimple($groupname)."', ".
					" nasportid=".$dbSocket->escapeSimple($nasportid)." ".
					" WHERE nasipaddress='".$dbSocket->escapeSimple($nasipaddressold)."'".
					" AND nasportid='". $dbSocket->escapeSimple($nasportidold)."' ";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$successMsg = "Updated HG settings in database: <b> $nasipaddress - $nasportid</b>  ";
				$logAction .= "Successfully updated attributes for hg [$nasipaddress - $nasportid] on page: ";
			} else {
				$failureMsg = "no HG Host or HG GroupName was entered, it is required that you specify both hg Host and HG GroupName ";
				$logAction .= "Failed updating attributes for hg [$nasipaddress - $nasportid] on page: ";
			}
			
		} elseif ($res->numRows() > 1) {
			$failureMsg = "The HG IP/Host - Port <b> $nasipaddress  - $nasportid</b> already exists in the database
			<br/> Please check that there are no duplicate entries in the database";
			$logAction .= "Failed updating attributes for already existing hg [$nasipaddress - $nasportid] on page: ";
		} else {
			$failureMsg = "The HG IP/Host - Port <b> $nasipaddress  - $nasportid</b> doesn't exist at all in the database.
			<br/>Please re-check the nashost ou specified.";
			$logAction .= "Failed updating empty nas on page: ";
		}

		include 'library/closedb.php';
	}

	if (isset($_REQUEST['nasipaddress']))
		$nasipaddress = $_REQUEST['nasipaddress'];
	else
		$nasipaddress = "";

	if (trim($nasipaddress) == "") {
		$failureMsg = "no HG Host or HG GroupName was entered, it is required that you specify both HG Host and HG GroupName";
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
	include ("menu-mng-rad-hunt.php");
?>

<div id="contentnorightbar">
	<?php
		include_once ("include/menu/management-subnav.php");
	?>
	<div class="container">

			<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradhuntedit.php') ?>
			:: <?php if (isset($nasipaddress)) { echo $nasipaddress; } ?><h144>&#x2754;</h144></a></h2>

			<div id="helpPage" style="display:none;visibility:visible" >
				<?php echo t('helpPage','mngradhuntedit') ?>
				<br/>
			</div>
			<?php
				include_once('include/management/actionMessages.php');
			?>

			<form name="newhg" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			
<div class="tabber">

     <div class="tabbertab" title="<?php echo t('title','HGInfo'); ?>">
		<input type="hidden" value="<?php echo $nasipaddress ?>" name="nasipaddressold" />
		<input type="hidden" value="<?php echo $nasportid ?>" name="nasportidold" />


        <fieldset>

                <h302> <?php echo t('title','HGInfo') ?> </h302>
                <br/>

                <label for='nasipaddress' class='form'><?php echo t('all','HgIPHost') ?></label>
                <input name='nasipaddress' type='text' id='nasipaddress' value='<?php echo $nasipaddress ?>' tabindex=100 />
                <br />

                <label for='groupname' class='form'><?php echo t('all','HgGroupName') ?></label>
                <input name='groupname' type='text' id='groupname' value='<?php echo $groupname ?>' tabindex=101 />
                <br />


                <label for='nasportid' class='form'><?php echo t('all','HgPortId') ?></label>
                <input name='nasportid' type='text' id='nasportid' value='<?php echo $nasportid ?>' tabindex=104 />
                <br />



                <br/><br/>
                <hr><br/>

                <input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />

        </fieldset>

	</div>
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
