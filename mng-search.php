<?php
    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	//setting values for the order by and order type variables
	isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "id";
	isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";

	isset($_REQUEST['username']) ? $username = $_REQUEST['username'] : $username = "%";

	$search_username = $username; //feed the sidebar variables
	$username = str_replace('*', '%', $username);

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
  <link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />
  <link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css"/>
</head>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>
<?php

	include ("menu-mng-users.php");

?>

	<div id="contentnorightbar">
    <?php
      include_once("include/menu/management-subnav.php");
    ?>

    <div class="container">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngsearch.php'); ?>
		:: <?php if (isset($username)) { echo $username; } ?><h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo "searched for user $username" ?><br/>
		</div>

<br/>

<?php

	include 'include/management/pages_common.php';
	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	// setup php session variables for exporting
	$_SESSION['reportTable'] = $configValues['CONFIG_DB_TBL_RADCHECK'];
	$_SESSION['reportQuery'] = " WHERE UserName LIKE '".$dbSocket->escapeSimple($username)."%'";
	$_SESSION['reportType'] = "usernameListGeneric";

	//orig: used as method to get total rows - this is required for the pages_numbering.php page
	$sql = "SELECT distinct(username) as username, concat(coalesce(firstname,''),' ',coalesce(lastname,'')) as value, id FROM userinfo WHERE firstname like '".$dbSocket->escapeSimple($username)."%'
	or lastname like '".$dbSocket->escapeSimple($username)."%' or username like '".$dbSocket->escapeSimple($username)."%' or homephone  like '".$dbSocket->escapeSimple($username)."%'  or workphone  like '".$dbSocket->escapeSimple($username)."%'  or mobilephone  like '".$dbSocket->escapeSimple($username)."%'
	GROUP BY UserName";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".Username) as UserName,
			concat(coalesce(".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname,''),' ',coalesce(".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname,'')) as value,
			".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".id, IFNULL(disabled.username,0) as disabled
			FROM userinfo
			LEFT JOIN ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." disabled
			 ON disabled.username=".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username AND disabled.groupname = 'daloRADIUS-Disabled-Users'
			WHERE ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".firstname like '".$dbSocket->escapeSimple($username)."%' or ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".lastname like '".$dbSocket->escapeSimple($username)."%' or ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".username like '".$dbSocket->escapeSimple($username)."%' or ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".homephone  like '".$dbSocket->escapeSimple($username)."%' or ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".workphone  like '".$dbSocket->escapeSimple($username)."%'  or ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".mobilephone  like '".$dbSocket->escapeSimple($username)."%'" .
			" GROUP BY ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].".UserName ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";


	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	echo "<form name='searchusers' method='get' action='mng-del.php' >";

	echo "<table border='0' class='table1'>\n";
	echo "
		<thead>
			<tr>
			<th colspan='10' align='left'>

			Select:
			<a class=\"table\" href=\"javascript:SetChecked(1,'username[]','searchusers')\">All</a>
			<a class=\"table\" href=\"javascript:SetChecked(0,'username[]','searchusers')\">None</a>
			<br/>
			<input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"searchusers\",\"mng-del.php\")' />
			<input class='button' type='button' value='CSV Export'
				onClick=\"javascript:window.location.href='include/management/fileExport.php?reportFormat=csv'\" />

			<br/><br/>
	";

	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType, "&username=$username");

	echo " </th></tr>
			</thead>";


	if ($orderType == "asc") {
		$orderTypeNextPage = "desc";
	} else  if ($orderType == "desc") {
		$orderTypeNextPage = "asc";
	}

	echo "<thread> <tr>
		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=id&orderType=$orderTypeNextPage\">
		".t('all','ID'). "</a>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=Username&orderType=$orderTypeNextPage\">
	 	".t('all','Username')."</a>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=Value&orderType=$orderTypeNextPage\">
		Full name</a>
		</th>
	</tr> </thread>";
	while($row = $res->fetchRow()) {

		if ($row[3] !== '0')
			$img = "<img title='user is disabled' src='images/icons/userStatusDisabled.gif' alt='[disabled]'>";
		else
			$img = "<img title='user is enabled' src='images/icons/userStatusActive.gif' alt='[enabled]'>";

		printqn("<tr>
			<td> <input type='checkbox' name='username[]' value='$row[0]'> $row[2] </td>
                        <td> $img <a class='tablenovisit' href='#'
                                onClick='javascript:ajaxGeneric(\"include/management/retUserInfo.php\",\"retBandwidthInfo\",\"divContainerUserInfo\",\"username=$row[0]\");return false;'
                                tooltipText='
                                        <a class=\"toolTip\" href=\"mng-edit.php?username=$row[0]\">
	                                        ".t('Tooltip','UserEdit')."</a>
                                        &nbsp
					<br/>
					<a class=\"toolTip\" href=\"config-maint-test-user.php?username=$row[0]&password=$row[1]\">
						".t('all','TestUser')."</a>
					&nbsp
					<br/>
					 <a class=\"toolTip\" href=\"acct-username.php?username=$row[0]\">
						".t('all','Accounting')."</a>
                                        <br/><br/>

                                        <div id=\"divContainerUserInfo\">
                                                Loading...
                                        </div>
                                        <br/>'
                                >$row[0]</a>
                        </td>

			<td> $row[1] </td>

			</tr>");

	}

	echo "
			<tfoot>
				<tr>
				<th colspan='10' align='left'>
	";

	setupLinks($pageNum, $maxPage, $orderBy, $orderType, "&username=$username");

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
