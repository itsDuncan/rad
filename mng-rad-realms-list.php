<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');


	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "RealmName";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";



	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for listing of records on page: ";


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
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradrealms.php') ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >				
			<?php echo t('helpPage','mngradrealmslist') ?>
			<br/>
		</div>	
		<br/>

<?php

	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page	
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALOREALMS']." ";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALOREALMS'].
		" ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";
	
	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<form name='listrealms' method='post' action='mng-rad-realms-del.php'>";
	
	echo "<table border='0' class='table1'>\n";
	echo "
		<thead>
			<tr>
			<th colspan='10' align='left'>

			Select:
			<a class=\"table\" href=\"javascript:SetChecked(1,'realmname[]','listrealms')\">All</a>
			<a class=\"table\" href=\"javascript:SetChecked(0,'realmname[]','listrealms')\">None</a>
			<br/>
			<input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listrealms\",\"mng-rad-realms-del.php\")' />
			<br/><br/>
	";

	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

	echo "	</th></tr>
			</thead>
	";

	if ($orderType == "asc") {
		$orderType = "desc";
	} else  if ($orderType == "desc") {
		$orderType = "asc";
	}

	echo "<thread> <tr>
		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=realmname&orderType=$orderType\">
		".t('all','RealmName')."</a>
		</th>
	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
			<td> <input type='checkbox' name='realmname[]' value='$row[1]'>
				<a class='tablenovisit' href='#'
								onclick='javascript:return false;'
                                tooltipText=\"
                                        <a class='toolTip' href='mng-rad-realms-edit.php?realmname=$row[1]'>".t('Tooltip','EditRealm')."</a>
                                        <br/>\"
				>$row[1]</a></td>
		</tr>";
	}

	echo "
	<tfoot>
		<tr>
		<th colspan='10' align='left'>
	";
	setupLinks($pageNum, $maxPage, $orderBy, $orderType);
	echo "
		</th>
		</tr>
	</tfoot>
	";


	echo "</table></form>";

	include 'library/closedb.php';
?>


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

<script type="text/javascript">
var tooltipObj = new DHTMLgoodies_formTooltip();
tooltipObj.setTooltipPosition('right');
tooltipObj.setPageBgColor('#EEEEEE');
tooltipObj.setTooltipCornerSize(15);
tooltipObj.initFormFieldTooltip();
</script>

</body>
</html>
