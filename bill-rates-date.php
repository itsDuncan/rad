<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	//setting values for the order by and order type variables
	isset($_GET['orderBy']) ? $orderBy = $_GET['orderBy'] : $orderBy = "radacctid";
	isset($_GET['orderType']) ? $orderType = $_GET['orderType'] : $orderType = "asc";

        isset($_GET['ratename']) ? $ratename = $_GET['ratename'] : $ratename = "";
        isset($_GET['username']) ? $username = $_GET['username'] : $username = "%";
        isset($_GET['startdate']) ? $startdate = $_GET['startdate'] : $startdate = "";
        isset($_GET['enddate']) ? $enddate = $_GET['enddate'] : $enddate = "";

	//feed the sidebar variables
        $billing_date_ratename = $ratename;
        $billing_date_username = $username;
        $billing_date_startdate = $startdate;
        $billing_date_enddate = $enddate;

	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for user [$username] and start date [$startdate] and end date [$enddate] on page: ";
	$logDebugSQL = "";

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">

	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<link rel="stylesheet" href="css/dtech/bootstrap.min.css">
	<link rel="stylesheet" href="css/dtech/style.css">

	<title>GwijiNet</title>
</head>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<?php

	include("menu-bill-rates.php");

?>

	<div id="contentnorightbar">
		<?php
		include_once ("include/menu/billing-subnav.php");
		?>

		<div class="container">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','billratesdate.php'); ?>
		<h144>&#x2754;</h144></a></h2>
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','billratesdate') ?>
			<br/>
		</div>
		<br/>


<?php

	include 'library/opendb.php';
	include 'include/management/pages_common.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	// we can only use the $dbSocket after we have included 'library/opendb.php' which initialzes the connection and the $dbSocket object
	$username = $dbSocket->escapeSimple($username);
	$startdate = $dbSocket->escapeSimple($startdate);
	$enddate = $dbSocket->escapeSimple($enddate);
	$ratename = $dbSocket->escapeSimple($ratename);

        include_once('include/management/userBilling.php');
        userBillingRatesSummary($username, $startdate, $enddate, $ratename, 1);				// draw the billing rates summary table

        include 'library/opendb.php';

	// get rate type
	$sql = "SELECT rateType FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES']." WHERE ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateName = '$ratename'";
	$res = $dbSocket->query($sql);

	if ($res->numRows() == 0)
		$failureMsg = "Rate was not found in database, check again please";
	else {

		$row = $res->fetchRow();
		list($ratetypenum, $ratetypetime) = explode("/",$row[0]);

		switch ($ratetypetime) {					// we need to translate any kind of time into seconds, so a minute is 60 seconds, an hour is 3600,
			case "second":						// and so on...
				$multiplicate = 1;
				break;
			case "minute":
				$multiplicate = 60;
				break;
			case "hour":
				$multiplicate = 3600;
				break;
			case "day":
				$multiplicate = 86400;
				break;
			case "week":
				$multiplicate = 604800;
				break;
			case "month":
				$multiplicate = 187488000;			// a month is 31 days
				break;
			default:
				$multiplicate = 0;
				break;
		}

		// then the rate cost would be the amount of seconds times the prefix multiplicator thus:
		$rateDivisor = ($ratetypenum * $multiplicate);
	}

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page
	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADACCT'].".username), ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress, ".
		$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".
		$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateCost ".
		" FROM ".$configValues['CONFIG_DB_TBL_RADACCT'].", ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES']." WHERE (AcctStartTime >= '$startdate') and (AcctStartTime <= '$enddate') and (UserName = '$username') and (".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateName = '$ratename')";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();


	$sql = "SELECT distinct(".$configValues['CONFIG_DB_TBL_RADACCT'].".username), ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress, ".
		$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".
		$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateCost ".
		" FROM ".$configValues['CONFIG_DB_TBL_RADACCT'].", ".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES']." WHERE (AcctStartTime >= '$startdate') and (AcctStartTime <= '$enddate') and (UserName = '$username') and (".$configValues['CONFIG_DB_TBL_DALOBILLINGRATES'].".rateName = '$ratename')".
		" ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */



	if (isset($failureMsg)) {
		include_once('include/management/actionMessages.php');
		echo "<br/>";
	}


	echo "<table border='0' class='table1'>\n";
        echo "
                <thead>
                        <tr>
                        <th colspan='12' align='left'>

                        <br/>
                <br/>
        ";

	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType,"&username=$username&ratename=$ratename&startdate=$startdate&enddate=$enddate");

	echo " </th></tr>
			</thead>
	";

	if ($orderType == "asc") {
			$orderTypeNextPage = "desc";
	} else  if ($orderType == "desc") {
			$orderTypeNextPage = "asc";
	}

        echo "<thread> <tr>
		<th scope='col'>
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&ratename=$ratename&startdate=$startdate&enddate=$enddate&orderBy=username&orderType=$orderTypeNextPage\">
		".t('all','Username')."</a>
		</th>
		<th scope='col'>
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&ratename=$ratename&startdate=$startdate&enddate=$enddate&orderBy=nasipaddress&orderType=$orderTypeNextPage\">
		".t('all','NASIPAddress')."</a>
		</th>
		<th scope='col'>
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&ratename=$ratename&startdate=$startdate&enddate=$enddate&orderBy=acctstarttime&orderType=$orderTypeNextPage\">
		".t('all','LastLoginTime')."</a>
		</th>
		<th scope='col'>
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&ratename=$ratename&startdate=$startdate&enddate=$enddate&orderBy=acctsessiontime&orderType=$orderTypeNextPage\">
		".t('all','TotalTime')."</a>
		</th>
		<th scope='col'>
		<br/>
		 ".t('all','Billed')."
		</th>
                </tr> </thread>";

	$sumBilled = 0;
	$sumSession = 0;

	while($row = $res->fetchRow()) {

		$sessionTime = $row[3];
		$rateCost = $row[4];
		$billed = (($sessionTime/$rateDivisor)*$rateCost);
		$sumBilled += $billed;
		$sumSession += $sessionTime;

		echo "<tr>
				<td> $row[0] </td>
				<td> $row[1] </td>
				<td> $row[2] </td>
				<td> ".time2str($row[3])." </td>
				<td> ".number_format($billed,2)." </td>
		</tr>";

	}

        echo "
                                        <tfoot>
                                                        <tr>
                                                        <th colspan='12' align='left'>
        ";
	setupLinks($pageNum, $maxPage, $orderBy, $orderType,"&username=$username&ratename=$ratename&startdate=$startdate&enddate=$enddate");
        echo "
                                                        </th>
                                                        </tr>
                                        </tfoot>
                ";

	echo "</table>";

	include 'library/closedb.php';
?>

		</div>
	</div>


<?php
	include('include/config/logging.php');
?>

		<div id="footer">

								<?php
        include 'page-footer.php';
?>


		</div>

</div>
</div>

</body>
</html>
