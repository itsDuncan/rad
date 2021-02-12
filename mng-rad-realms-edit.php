<?php 

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	isset($_GET['realmname']) ? $realmname = $_GET['realmname'] : $realmname = "";

	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST["submit"])) {

		isset($_POST['realmname']) ? $realmname = $_POST['realmname'] : $realmname = "";
		isset($_POST['type']) ? $type = $_POST['type'] : $type = "";
		isset($_POST['authhost']) ?$authhost = $_POST['authhost'] : $authhost = "";
		isset($_POST['accthost']) ? $accthost = $_POST['accthost'] : $accthost = "";
		isset($_POST['secret']) ? $secret = $_POST['secret'] : $secert = "";
		isset($_POST['ldflag']) ? $ldflag = $_POST['ldflag'] : $ldflag = "";
		isset($_POST['nostrip']) ? $nostrip = $_POST['nostrip'] : $nostrip = "";
		isset($_POST['hints']) ? $hints = $_POST['hints'] : $hints = "";
		isset($_POST['notrealm']) ? $notrealm = $_POST['notrealm'] :  $notrealm = "";
		
		include 'library/opendb.php';

		if (isset($configValues['CONFIG_FILE_RADIUS_PROXY'])) {
			$filenameRealmsProxys = $configValues['CONFIG_FILE_RADIUS_PROXY'];
			$fileFlag = 1;
		} else {
			$filenameRealmsProxys = "";
			$fileFlag = 0;
		}

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALOREALMS'].
				" WHERE realmname='".$dbSocket->escapeSimple($realmname)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if (trim($realmname) != "") {

			if (!(file_exists($filenameRealmsProxys))) {
				$logAction .= "Failed non-existed realms configuration file [$filenameRealmsProxys] on page: ";
				$failureMsg = "the file $filenameRealmsProxys doesn't exist, I can't save realms information to the file";
				$fileFlag = 0;
			}

			if (!(is_writable($filenameRealmsProxys))) {
				$logAction .= "Failed writing realms configuration to file [$filenameRealmsProxys] on page: ";
				$failureMsg = "the file $filenameRealmsProxys isn't writable, I can't save realms information to the file";
				$fileFlag = 0;
			}

			$currDate = date('Y-m-d H:i:s');
			$currBy = $_SESSION['operator_user'];

			// update realm entry in database
			$sql = "UPDATE ".$configValues['CONFIG_DB_TBL_DALOREALMS']." SET ".
				" type='".$dbSocket->escapeSimple($type)."', ".
				" authhost='".$dbSocket->escapeSimple($authhost)."', ".
				" accthost='".$dbSocket->escapeSimple($accthost)."', ".
				" secret='".$dbSocket->escapeSimple($secret)."', ".
				" ldflag='".$dbSocket->escapeSimple($ldflag)."', ".
				" nostrip='".$dbSocket->escapeSimple($nostrip)."', ".
				" hints='".$dbSocket->escapeSimple($hints)."', ".
				" notrealm='".$dbSocket->escapeSimple($notrealm)."', ".
				" updatedate='$currDate', updateby='$currBy' ".
				" WHERE realmname='$realmname';";
			$res = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";

			$successMsg = "Updated database with realm: <b>$realmname</b>";
			$logAction .= "Updated realm [$realmname] on page: ";

			/*******************************************************************/
			/* enumerate from database all realm entries */
			include_once('include/management/saveRealmsProxys.php');
			/*******************************************************************/

		} else {
			$failureMsg = "you must provide atleast a realm name";
			$logAction .= "Updated realm [$realmname] on page: ";	
		}

		include 'library/closedb.php';

	}


	include 'library/opendb.php';

        // fill-in realm information in html elements
        $sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALOREALMS']." WHERE realmname='".$dbSocket->escapeSimple($realmname)."'";
        $res = $dbSocket->query($sql);
        $logDebugSQL .= $sql . "\n";

        $row = $res->fetchRow(DB_FETCHMODE_ASSOC);
        $type = $row['type'];
        $authhost = $row['authhost'];
        $accthost = $row['accthost'];
        $secret = $row['secret'];
        $ldflag = $row['ldflag'];
        $nostrip = $row['nostrip'];
        $hints = $row['hints'];
        $notrealm = $row['notrealm'];

	include 'library/closedb.php';


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
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script> 

<?php
include ("menu-mng-rad-realms.php");
?>

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/management-subnav.php");
	?>
	<div class="container">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradrealmsedit.php') ?>
		<h144>&#x2754;</h144></a></h2>
		
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradrealmsedit') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="tabber">

     <div class="tabbertab" title="<?php echo t('title','RealmInfo'); ?>">

	<fieldset>

		<h302> <?php echo t('title','RealmInfo'); ?> </h302>
		<br/>

		<ul>

		<input type='hidden' name='realmname' id='realmname' value='<?php if (isset($realmname)) echo $realmname; ?>' />

		<li class='fieldset'>
		<label for='realmname' class='form'><?php echo t('all','RealmName') ?></label>
		<input disabled name='realmname' type='text' id='realmname' 
			value='<?php if (isset($realmname)) echo $realmname; ?>' tabindex=100 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmNameTooltip')" />
		
		<div id='realmNameTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmNameTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='type' class='form'><?php echo t('all','Type') ?></label>
		<input name='type' type='text' id='type' value='<?php if (isset($type)) echo $type; ?>' tabindex=101 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmTypeTooltip')"/>
		
		<div id='realmTypeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmTypeTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='authhost' class='form'><?php echo t('all','AuthHost') ?></label>
		<input name='authhost' type='text' id='authhost' value='<?php if (isset($authhost)) echo $authhost; ?>' tabindex=102 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmAuthhostTooltip')"/>
		
		<div id='realmAuthhostTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmAuthhostTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='accthost' class='form'><?php echo t('all','AcctHost') ?></label>
		<input name='accthost' type='text' id='accthost' value='<?php if (isset($accthost)) echo $accthost; ?>' tabindex=103 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmAccthostTooltip')"/>
		
		<div id='realmAccthostTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmAccthostTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='secret' class='form'><?php echo t('all','RealmSecret') ?></label>
		<input name='secret' type='text' id='secret' value='<?php if (isset($secret)) echo $secret; ?>' tabindex=104 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmSecretTooltip')"/>
		
		<div id='realmSecretTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmSecretTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=10000 class='button' />
		</li>

		</ul>
	</fieldset>

	</div>


     <div class="tabbertab" title="<?php echo t('title','Advanced'); ?>">

	<fieldset>

		<h302> <?php echo t('title','RealmInfo'); ?> </h302>
		<br/>
		<ul>

		<li class='fieldset'>
		<label for='ldflag' class='form'><?php echo t('all','Ldflag') ?></label>
		<input name='ldflag' type='text' id='ldflag' value='<?php if (isset($ldflag)) echo $ldflag; ?>' tabindex=105 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmLdflagTooltip')"/>
		
		<div id='realmLdflagTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmLdflagTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='nostrip' class='form'><?php echo t('all','Nostrip') ?></label>
		<input name='nostrip' type='text' id='nostrip' value='<?php if (isset($nostrip)) echo $nostrip; ?>' tabindex=106 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmNostripTooltip')"/>
		
		<div id='realmNostripTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmNostripTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='hints' class='form'><?php echo t('all','Hints') ?></label>
		<input name='hints' type='text' id='hints' value='<?php if (isset($hints)) echo $hints; ?>' tabindex=107 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmHintsTooltip')"/>
		
		<div id='realmHintsTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmHintsTooltip') ?>
		</div>
		</li>

                <li class='fieldset'>
		<label for='notrealm' class='form'><?php echo t('all','Notrealm') ?></label>
		<input name='notrealm' type='text' id='notrealm' value='<?php if (isset($notrealm)) echo $notrealm; ?>' tabindex=108 />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('realmNotrealmTooltip')"/>
		
		<div id='realmNotrealmTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo t('Tooltip','realmNotrealmTooltip') ?>
		</div>
		</li>

		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' tabindex=10000 class='button' /> 
		</li>

		</ul>
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





