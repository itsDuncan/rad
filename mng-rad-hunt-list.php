<?php

include ("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');

	//setting values for the order by and order type variables
isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "id";
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

<?php
include ("menu-mng-rad-hunt.php");
?>

<div id="contentnorightbar">
	<?php
	include_once ("include/menu/management-subnav.php");
	?>
	<div class="container">
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradhuntlist.php') ?>
		<h144>&#x2754;</h144></a></h2>
		
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','mngradhuntlist') ?>
			<br/>
		</div>
		<br/>


		<?php

		
		include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page	
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADHG'];
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	$numrows = $res->numRows();

	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADHG']." ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";

	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */


	echo "<form name='listallhunt' method='post' action='mng-rad-hunt-del.php'>";

	echo "<table border='0' class='table1'>\n";
	echo "
	<thead>
	<tr>
	<th colspan='4' align='left'>

	Select:
	<a class=\"table\" href=\"javascript:SetChecked(1,'nashost[]','listallhunt')\">All</a>

	<a class=\"table\" href=\"javascript:SetChecked(0,'nashost[]','listallhunt')\">None</a>
	<br/>
	<input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listallhunt\",\"mng-rad-hunt-del.php\")' />
	<br/><br/>


	";

	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

	echo " </th></tr>
	</thead>

	";

	if ($orderType == "asc") {
		$orderType = "desc";
	} else  if ($orderType == "desc") {
		$orderType = "asc";
	}

	echo "<thread> <tr>
	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=id&orderType=$orderType\">
	".t('all','HgID')."</a>
	<br/>
	</th>

	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=nasipaddress&orderType=$orderType\">
	".t('all','HgIPHost')."</a>
	<br/>
	</th>

	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=$orderType\">
	".t('all','HgGroupName')."</a>
	<br/>
	</th>

	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=nasportid&orderType=$orderType\">
	".t('all','HgPortId')."</a>
	<br/>
	</th>

	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
		<td> <input type='checkbox' name='nashost[]' value='$row[2]||$row[3]'> $row[0] </td>
		<td> <a class='tablenovisit' href='#'
		onclick='javascript:return false;'
		tooltipText=\"
		<a class='toolTip' href='mng-rad-hunt-edit.php?nasipaddress=$row[2]&nasportid=$row[3]'>".t('Tooltip','EditHG')."</a>
		<a class='toolTip' href='mng-rad-hunt-del.php?nasipaddress=$row[2]&nasportid=$row[3]'>".t('Tooltip','RemoveHG')."</a>
		<br/>\"
		>$row[2]</a></td>
		<td> $row[1] </td>
		<td> $row[3] </td>

		</tr>";
	}

	echo "
	<tfoot>
	<tr>
	<th colspan='4' align='left'>
	";
	setupLinks($pageNum, $maxPage, $orderBy, $orderType);
	echo "
	</th>
	</tr>
	</tfoot>
	";


	echo "</table>";
	echo "</form>";

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
