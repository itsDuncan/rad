<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');


	// declaring variables
	$nashost = "";
	$nassecret = "";
	$nasname = "";
	$nasports = "";
	$nastype = "";
	$nasdescription = "";
	$nascommunity = "";
	$nasvirtualserver = "";

	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST['submit'])) {

		$nashost = $_POST['nashost'];
		$nassecret = $_POST['nassecret'];
		$nasname = $_POST['nasname'];
		$nasports = $_POST['nasports'];
		$nastype = $_POST['nastype'];
		$nasdescription = $_POST['nasdescription'];
		$nascommunity = $_POST['nascommunity'];
		$nasvirtualserver = $_POST['nasvirtualserver'];

		include 'library/opendb.php';

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADNAS'].
				" WHERE nasname='".$dbSocket->escapeSimple($nashost)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {

			if (trim($nashost) != "" and trim($nassecret) != "") {

				if (!$nasports) {
					$nasports = 0;
				}

				if (!$nasvirtualserver) {
                      $nasvirtualserver = '';
               }

				// insert nas details
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADNAS'].
					" (id,nasname,shortname,type,ports,secret,server,community,description) ".
					" values (0, '".$dbSocket->escapeSimple($nashost)."', '".$dbSocket->escapeSimple($nasname).
					"', '".$dbSocket->escapeSimple($nastype)."', '".$dbSocket->escapeSimple($nasports).
					"', '".$dbSocket->escapeSimple($nassecret)."', '".$dbSocket->escapeSimple($nasvirtualserver).
					"', '".$dbSocket->escapeSimple($nascommunity)."', '".$dbSocket->escapeSimple($nasdescription)."')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				$successMsg = "Added new NAS to database: <b> $nashost </b>  ";
				$logAction .= "Successfully added nas [$nashost] on page: ";
			} else {
				$failureMsg = "no NAS Host or NAS Secret was entered, it is required that you specify both NAS Host and NAS Secret";
				$logAction .= "Failed adding (missing nas/secret) nas [$nashost] on page: ";
			}
		} else {
			$failureMsg = "The NAS IP/Host $nashost already exists in the database";
			$logAction .= "Failed adding already existing nas [$nashost] on page: ";
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
	include_once ("library/tabber/tab-layout.php");
?>

<?php
	include ("menu-mng-rad-nas.php");
?>

	<div id="contentnorightbar">

    <div class="container">

    <?php
      include_once("include/menu/management-subnav.php");
    ?>

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradnasnew.php') ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradnasnew') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>


                <form name="newnas" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="tabber">

     <div class="tabbertab" title="<?php echo t('title','NASInfo'); ?>">

	<fieldset>

		<h302> <?php echo t('title','NASInfo') ?> </h302>
		<br/>

                <label for='nashost' class='form'><?php echo t('all','NasIPHost') ?></label>
                <input name='nashost' type='text' id='nashost' value='' tabindex=100 />
                <br />


                <label for='nassecret' class='form'><?php echo t('all','NasSecret') ?></label>
                <input name='nassecret' type='text' id='nassecret' value='' tabindex=101 />
                <br />


                <label for='nastype' class='form'><?php echo t('all','NasType') ?></label>
                <input name='nastype' type='text' id='nastype' value='' tabindex=102 />
                <select onChange="javascript:setStringText(this.id,'nastype')" id="optionSele" tabindex=103 class='form'>
					<option value="">Select Type...</option>
	                <option value="other">other</option>
	                <option value="cisco">cisco</option>
	                <option value="livingston">livingston</option>
        	        <option value="computon">computon</option>
					<option value="max40xx">max40xx</option>
					<option value="multitech">multitech</option>
					<option value="natserver">natserver</option>
					<option value="pathras">pathras</option>
					<option value="patton">patton</option>
	                <option value="portslave">portslave</option>
	                <option value="tc">tc</option>
	                <option value="usrhiper">usrhiper</option>
       	        </select>
                <br />


                <label for='nasname' class='form'><?php echo t('all','NasShortname') ?></label>
                <input name='nasname' type='text' id='nasname' value='' tabindex=104 />
                <br />

                <br/><br/>
                <hr><br/>

                <input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />

        </fieldset>


     </div>
     <div class="tabbertab" title="<?php echo t('title','NASAdvanced'); ?>">

	<fieldset>

		<h302> <?php echo t('title','NASAdvanced') ?> </h302>
		<br/>

                <label for='nasports' class='form'><?php echo t('all','NasPorts') ?></label>
                <input name='nasports' type='text' id='nasports' value='0' tabindex=105 />
                <br />

                <label for='nascommunity' class='form'><?php echo t('all','NasCommunity') ?></label>
                <input name='nascommunity' type='text' id='nascommunity' value='' tabindex=106 />
                <br />

                <label for='nasvirtualserver' class='form'><?php echo t('all','NasVirtualServer') ?></label>
                <input name='nasvirtualserver' type= 'text' id='nasvirtualserver' value='' tabindex=107 >
                <br />

                <label for='nasdescription' class='form'><?php echo t('all','NasDescription') ?></label>
                <textarea class='form' name='nasdescription' id='nasdescription' value='' tabindex=108 ></textarea>
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
