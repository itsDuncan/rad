<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

        $groupname = "";
        $nasipaddress = "";
        $nasportid = "";
        $logAction = "";
        $logDebugSQL = "";

        $showRemoveDiv = "block";

        if (isset($_POST['nashost'])) {
                $hgroup_array = $_POST['nashost'];
        } else {
                if (isset($_GET['nasportid']))
                $hgroup_array = array($_GET['nasipaddress']."||".$_GET['nasportid']);
        }

        if (isset($hgroup_array)) {

                $allNasipaddresses =  "";
                $allNasportid =  "";

                foreach ($hgroup_array as $hgroup) {

                        list($nasipaddress, $nasportid) = preg_split('\|\|', $hgroup);

                        if (trim($nasipaddress) != "") {

                                $allNasipaddresses .= $nasipaddress . ", ";
                                $allNasportid .= $nasportid . ", ";

                                if ( trim($nasportid) != "")  {

                                        include 'library/opendb.php';

                                        // delete only a specific groupname and it's attribute
                                        $sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADHG'].
                                                        " WHERE nasipaddress='".$dbSocket->escapeSimple($nasipaddress).
                                                        "' AND nasportid='$nasportid' ";
                                        $res = $dbSocket->query($sql);
                                        $logDebugSQL .= $sql . "\n";

                                        $successMsg = "Deleted HuntGroup(s): <b> $allNasipaddresses </b> with Port ID(s): <b> $allNasportid </b> ";
                                        $logAction .= "Successfully deleted hunt group(s) [$allNasipaddresses] with port id [$allNasportid] on page: ";

                                        include 'library/closedb.php';

                                } else {

                                        include 'library/opendb.php';

                                        $sql = "DELETE FROM ".$configValues['CONFIG_DB_TBL_RADHG']." WHERE nasipaddress='".$dbSocket->escapeSimple($nasipaddress)."'";
                                        $res = $dbSocket->query($sql);
                                        $logDebugSQL .= $sql . "\n";

                                        $successMsg = "Deleted all instances for HuntGroup(s): <b> $allNasipaddresses </b>";
                                        $logAction .= "Successfully deleted all instances for huntgroup(s) [$allNasipaddresses] on page: ";

                                        include 'library/closedb.php';

                                }

                        } else {

                                        $failureMsg = "No hunt groupname was entered, please specify a hunt groupname to remove from database";
                                        $logAction .= "Failed deleting empty hunt group on page: ";
                        }

                } // foreach

                $showRemoveDiv = "none";

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

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradhuntdel.php') ?>
		:: <?php if (isset($nasipaddress)) { echo $nasipaddress; } ?><h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradhuntdel') ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>

		<div id="removeDiv" style="display:<?php echo $showRemoveDiv ?>;visibility:visible" >
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

        <fieldset>

			<h302> <?php echo t('title','HGInfo') ?> </h302>
			<br/>

			<label for='nasipaddress' class='form'><?php echo t('all','HgIPHost') ?></label>
			<input name='nasipaddress' type='text' id='nasipaddress' value='' tabindex=100 />
			<br />

                        <label for='nasportid' class='form'><?php echo t('all','HgPortId') ?></label>
                        <input name='nasportid' type='text' id='nasportid' value='<?php echo $nasportid ?>' tabindex=101 />
                        <br/>

			<br/><br/>
			<hr><br/>

			<input type='submit' name='submit' value='<?php echo t('buttons','apply') ?>' class='button' />

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

<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('nasipaddress','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteHGHost');
                      </script>";
        }

?>

</body>
</html>
