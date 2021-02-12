<?php

include ("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');

	//setting values for the order by and order type variables
isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "username";
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

<?php
	include ("menu-mng-rad-usergroup.php");
?>

<div id="contentnorightbar">
	<?php
		include_once("include/menu/management-subnav.php");
	?>

	<div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradusergrouplist') ?>
	<h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >		
		<?php echo t('helpPage','mngradusergrouplist') ?>
		<br/>
	</div>
	<br/>

	<?php

	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page	
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".UserName), ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName, ".
	$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".priority, ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname, ".
	$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname ".
	" FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." ON ".
	$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username ".
	" GROUP BY UserName;";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".UserName), ".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName, ".
	$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".priority, ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname, ".
	$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname ".
	" FROM ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOUSERINFO']." ON ".
	$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username ".
	" GROUP BY UserName ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";
	
	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<form name='listallusergroup' method='post' action='mng-rad-usergroup-del.php'>";
	
	echo "<table border='0' class='table1'>\n";
	echo "
	<thead>
	<tr>
	<th colspan='10' align='left'>

	Select:
	<a class=\"table\" href=\"javascript:SetChecked(1,'usergroup[]','listallusergroup')\">All</a>
	<a class=\"table\" href=\"javascript:SetChecked(0,'usergroup[]','listallusergroup')\">None</a>
	<br/>
	<input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listallusergroup\",\"mng-rad-usergroup-del.php\")' />
	<br/><br/>

	";


	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType);

	echo "	</th></tr>
	</thead>
	";

	if ($orderType == "asc") {
		$orderTypeNextPage = "desc";
	} else  if ($orderType == "desc") {
		$orderTypeNextPage = "asc";
	}

	echo "<thread> <tr>
	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=username&orderType=$orderTypeNextPage\">
	".t('all','Username')."</a>
	</th>

	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=firstname&orderType=$orderTypeNextPage\">
	".t('all','Name')."</a>
	</th>

	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=$orderTypeNextPage\">
	".t('all','Groupname')."</a>
	</th>

	<th scope='col'>
	<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=priority&orderType=$orderTypeNextPage\">
	".t('all','Priority')."</a>
	</th>

	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
		<td> <input type='checkbox' name='usergroup[]' value='$row[0]||$row[1]'> $row[0] </td>
		<td> $row[3] $row[4] </td>
		<td> <a class='tablenovisit' href='#'
		onclick='javascript:return false;'
		tooltipText=\"
		<a class='toolTip' href='mng-rad-usergroup-edit.php?username=$row[0]&group=$row[1]'>".t('Tooltip','EditUserGroup')."</a>
		<br/>
		<a class='toolTip' href='mng-rad-usergroup-list-user.php?username=$row[0]&group=$row[1]'>".t('Tooltip','ListUserGroups')."</a>
		<br/>\"
		>$row[1]</a></td>
		<td> $row[2] </td>
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
