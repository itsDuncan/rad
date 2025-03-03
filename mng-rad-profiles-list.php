<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');


	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "GroupName";
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
	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<title>GwijiNet</title>
</head>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>
 
<?php
	include ("menu-mng-rad-profiles.php");
?>

	<div id="contentnorightbar">
		<?php
			include_once ("include/menu/management-subnav.php");
		?>
		
		<div class="container">
		
				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradprofiles.php') ?>
				<h144>&#x2754;</h144></a></h2>

				<div id="helpPage" style="display:none;visibility:visible" >				
					<?php echo t('helpPage','mngradprofileslist') ?>
					<br/>
				</div>	
				<br/>
				
<?php

	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page	
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].".GroupName), count(distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username)) ".
		" AS Users FROM ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." ON ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].".GroupName=".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName GROUP BY ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].".GroupName ".
		" UNION ".
		" SELECT distinct(".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].".GroupName), count(distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username)) FROM ".
		$configValues['CONFIG_DB_TBL_RADGROUPCHECK']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." ON ".
		$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].".GroupName=".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName GROUP BY ".
		$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].".GroupName;";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].".GroupName), count(distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username)) ".
		" AS Users FROM ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." ON ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].".GroupName=".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName GROUP BY ".
		$configValues['CONFIG_DB_TBL_RADGROUPREPLY'].".GroupName ".
		" UNION ".
		" SELECT distinct(".$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].".GroupName), count(distinct(".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".username)) FROM ".
		$configValues['CONFIG_DB_TBL_RADGROUPCHECK']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." ON ".
		$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].".GroupName=".$configValues['CONFIG_DB_TBL_RADUSERGROUP'].".GroupName GROUP BY ".
		$configValues['CONFIG_DB_TBL_RADGROUPCHECK'].".GroupName ".
		" ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";
	
	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<form name='listprofiles' method='post' action='mng-rad-profiles-del.php'>";
	
	echo "<table border='0' class='table1'>\n";
	echo "
		<thead>
			<tr>
			<th colspan='10' align='left'>
			Select:
			<a class=\"table\" href=\"javascript:SetChecked(1,'profile[]','listprofiles')\">All</a>
			<a class=\"table\" href=\"javascript:SetChecked(0,'profile[]','listprofiles')\">None</a>
			<br/>
			<input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listprofiles\",\"mng-rad-profiles-del.php\")' />
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
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=groupname&orderType=$orderTypeNextPage\">
		".t('all','Groupname')."</a>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=users&orderType=$orderTypeNextPage\">
		".t('all','TotalUsers')."</a>
		</th>

	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
			<td> <input type='checkbox' name='profile[]' value='$row[0]'>
				<a class='tablenovisit' href='#'
								onclick='javascript:return false;'
                                tooltipText=\"
                                        <a class='toolTip' href='mng-rad-profiles-edit.php?profile=$row[0]'>".t('Tooltip','EditProfile')."</a>
                                        <br/>\"
				>$row[0]</a></td>
			<td>$row[1]</td>
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
