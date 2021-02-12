<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
        
	include('library/check_operator_perm.php');


	// declaring variables
	$nasipaddress = "";
	$groupname = "";
	$nasportid = "";

	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST['submit'])) {
	
		$nasipaddress = $_POST['nasipaddress'];
		$groupname = $_POST['groupname'];
		$nasportid = $_POST['nasportid'];

		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADHG'].
				" WHERE nasipaddress='".$dbSocket->escapeSimple($nasipaddress)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {

			if (trim($nasipaddress) != "" and trim($groupname) != "") {

				if (!$nasportid) {
					$nasportid = 0;
				}
				
				// insert nas details
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADHG'].
					" (id,nasipaddress,groupname,nasportid) ".
					" values (0, '".$dbSocket->escapeSimple($nasipaddress)."', '".$dbSocket->escapeSimple($groupname).
					"', '".$dbSocket->escapeSimple($nasportid)."')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
			
				$successMsg = "Added new HG to database: <b> $nasipaddress </b>  ";
				$logAction .= "Successfully added hg [$nasipaddress] on page: ";
			} else {
				$failureMsg = "no HG Host or HG GroupName was entered, it is required that you specify both HG Host and HG GroupName";
				$logAction .= "Failed adding (missing ip/groupname) hg [$nasipaddress] on page: ";
			}
		} else {
			$failureMsg = "The HG IP/Host $nasipaddress already exists in the database";	
			$logAction .= "Failed adding already existing hg [$nasipaddress] on page: ";
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
	
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradhuntnew.php') ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradhuntnew') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>
				

                <form name="newhg" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="tabber">

     <div class="tabbertab" title="<?php echo t('title','HGInfo'); ?>">

	<fieldset>

		<h302> <?php echo t('title','HGInfo') ?> </h302>
		<br/>

                <label for='nasipaddress' class='form'><?php echo t('all','HgIPHost') ?></label>
                <input name='nasipaddress' type='text' id='nasipaddress' value='' tabindex=100 />
                <br />


                <label for='groupname' class='form'><?php echo t('all','HgGroupName') ?></label>
                <input name='groupname' type='text' id='groupname' value='' tabindex=101 />
                <br />

                <label for='nasportid' class='form'><?php echo t('all','HgPortId') ?></label>
                <input name='nasportid' type='text' id='nasportid' value='0' tabindex=105 />
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
