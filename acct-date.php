<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	//setting values for the order by and order type variables
	isset($_GET['orderBy']) ? $orderBy = $_GET['orderBy'] : $orderBy = "radacctid";
	isset($_GET['orderType']) ? $orderType = $_GET['orderType'] : $orderType = "asc";

	if ( (isset($_GET['username'])) && ($_GET['username']) ) {
		$username = $_GET['username'];
	} else {
		$username = "%";
	}

	isset($_GET['startdate']) ? $startdate = $_GET['startdate'] : $startdate = "";
	isset($_GET['enddate']) ? $enddate = $_GET['enddate'] : $enddate = "";
	
	//feed the sidebar variables
	$accounting_date_username = $username;
	$accounting_date_startdate = $startdate;
	$accounting_date_enddate = $enddate;

	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for user [$username] and start date [$startdate] and end date [$enddate] on page: ";
	$logDebugSQL = "";

?>

<?php
	
	include("menu-accounting.php");
	
?>

	<div id="contentnorightbar">
		<?php
		include_once ("include/menu/accounting-subnav.php");
		?>

		<div class="container">
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','acctdate.php'); ?>
		<h144>&#x2754;</h144></a></h2>
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','acctdate') ?>
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

	// setup php session variables for exporting
	$_SESSION['reportTable'] = $configValues['CONFIG_DB_TBL_RADACCT'];
	$_SESSION['reportQuery'] = " WHERE AcctStartTime>'$startdate' AND AcctStartTime<'$enddate' AND UserName LIKE '$username'";
	$_SESSION['reportType'] = "accountingGeneric";

        include 'library/closedb.php';

        include_once('include/management/userReports.php');
        userPlanInformation($username, 1);
        userSubscriptionAnalysis($username, 1);                 // userSubscriptionAnalysis with argument set to 1 for drawing the table
        userConnectionStatus($username, 1);                     // userConnectionStatus (same as above)


        include 'library/opendb.php';
	
	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page
    $sql = "SELECT ".$configValues['CONFIG_DB_TBL_RADACCT'].".RadAcctId, ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".name as hotspot, ".$configValues['CONFIG_DB_TBL_RADACCT'].".UserName, ".$configValues['CONFIG_DB_TBL_RADACCT'].".FramedIPAddress, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStopTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctInputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctOutputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctTerminateCause, ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress FROM ".$configValues['CONFIG_DB_TBL_RADACCT']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']." ON ".$configValues['CONFIG_DB_TBL_RADACCT'].".calledstationid = ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".mac WHERE AcctStartTime>'$startdate' and AcctStartTime<'$enddate' and UserName like '$username';";
	$res = $dbSocket->query($sql);
	$numrows = $res->numRows();

	
    $sql = "SELECT ".$configValues['CONFIG_DB_TBL_RADACCT'].".RadAcctId, ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".name as hotspot, ".$configValues['CONFIG_DB_TBL_RADACCT'].".UserName, ".$configValues['CONFIG_DB_TBL_RADACCT'].".FramedIPAddress, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStartTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctStopTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctSessionTime, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctInputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctOutputOctets, ".$configValues['CONFIG_DB_TBL_RADACCT'].".AcctTerminateCause, ".$configValues['CONFIG_DB_TBL_RADACCT'].".NASIPAddress FROM ".$configValues['CONFIG_DB_TBL_RADACCT']." LEFT JOIN ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']." ON ".$configValues['CONFIG_DB_TBL_RADACCT'].".calledstationid = ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS'].".mac WHERE AcctStartTime>'$startdate' and AcctStartTime<'$enddate' and UserName like '$username' ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */

	$counter=0;
	$bytesin=0;
	$bytesout=0;
	$megabytesout=0;
	$megabytesin=0;
	$session_seconds=0;
	$session_minutes=0;

	echo "<table border='0' class='table1'>\n";
        echo "
                <thead>
                        <tr>
                        <th colspan='12' align='left'>

                        <input class='button' type='button' value='CSV Export'
                        onClick=\"javascript:window.location.href='include/management/fileExport.php?reportFormat=csv'\"
                        />
                        <br/>
                <br/>
        ";

	if ($configValues['CONFIG_IFACE_TABLES_LISTING_NUM'] == "yes")
		setupNumbering($numrows, $rowsPerPage, $pageNum, $orderBy, $orderType,"&username=$username&startdate=$startdate&enddate=$enddate");

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
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=radacctid&orderType=$orderTypeNextPage\">
		".t('all','ID')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=hotspot&orderType=$orderTypeNextPage\">
		".t('all','HotSpot')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=username&orderType=$orderTypeNextPage\">
		".t('all','Username')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=framedipaddress&orderType=$orderTypeNextPage\">
		".t('all','IPAddress')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=acctstarttime&orderType=$orderTypeNextPage\">
		".t('all','StartTime')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=acctstoptime&orderType=$orderTypeNextPage\">
		".t('all','StopTime')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=acctsessiontime&orderType=$orderTypeNextPage\">
		".t('all','TotalTime')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=acctinputoctets&orderType=$orderTypeNextPage\">
		".t('all','Upload')." (".t('all','Bytes').")</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=acctoutputoctets&orderType=$orderTypeNextPage\">
		".t('all','Download')." (".t('all','Bytes').")</a>
		</th>
		<th scope='col'>
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=acctterminatecause&orderType=$orderTypeNextPage\">
		 ".t('all','Termination')."</a>
		</th>
		<th scope='col'> 
		<br/>
		<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&startdate=$startdate&enddate=$enddate&orderBy=nasipaddress&orderType=$orderTypeNextPage\">
		".t('all','NASIPAddress')."</a>
		</th>
                </tr> </thread>";

	while($row = $res->fetchRow()) {
		printqn("<tr>
				<td> $row[0] </td>

                        <td> <a class='tablenovisit' href='#'
                                onClick='javascript:ajaxGeneric(\"include/management/retHotspotInfo.php\",\"retHotspotGeneralStat\",\"divContainerHotspotInfo\",\"hotspot=$row[1]\");return false;'
                                tooltipText='
                                        <a class=\"toolTip\" href=\"mng-hs-edit.php?name=$row[1]\">
                                                ".t('Tooltip','HotspotEdit')."</a>
                                        &nbsp;
                                        <a class=\"toolTip\" href=\"acct-hotspot-compare.php?\">
                                                ".t('all','Compare')."</a>
                                        <br/><br/>

                                        <div id=\"divContainerHotspotInfo\">
                                                Loading...
                                        </div>
                                        <br/>'
                                >$row[1]</a>
                        </td>

                        <td> <a class='tablenovisit' href='#'
                                onClick='javascript:ajaxGeneric(\"include/management/retUserInfo.php\",\"retBandwidthInfo\",\"divContainerUserInfo\",\"username=$row[2]\");return false;'
                                tooltipText='
                                        <a class=\"toolTip\" href=\"mng-edit.php?username=$row[2]\">
	                                        ".t('Tooltip','UserEdit')."</a>
                                        <br/><br/>

                                        <div id=\"divContainerUserInfo\">
                                                Loading...
                                        </div>
                                        <br/>'
                                >$row[2]</a>
                        </td>
				<td> $row[3] </td>
				<td> $row[4] </td>
				<td> $row[5] </td>
				<td> ".time2str($row[6])." </td>
				<td> ".toxbyte($row[7])."</td>
				<td> ".toxbyte($row[8])."</td>
				<td> $row[9] </td>
				<td> $row[10] </td>
		</tr>");

	}

        echo "
                                        <tfoot>
                                                        <tr>
                                                        <th colspan='12' align='left'>
        ";
	setupLinks($pageNum, $maxPage, $orderBy, $orderType,"&username=$username&startdate=$startdate&enddate=$enddate");
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

<script type="text/javascript">
        var tooltipObj = new DHTMLgoodies_formTooltip();
        tooltipObj.setTooltipPosition('right');
        tooltipObj.setPageBgColor('#EEEEEE');
        tooltipObj.setTooltipCornerSize(15);
        tooltipObj.initFormFieldTooltip();
</script>

</body>
</html>
