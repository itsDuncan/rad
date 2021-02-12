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

<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<?php
	include ("menu-mng-rad-nas.php");
?>

		<div id="contentnorightbar">
      <?php
        include_once("include/menu/management-subnav.php");
      ?>

      <div class="container">

				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','mngradnaslist.php') ?>
				<h144>&#x2754;</h144></a></h2>

				<div id="helpPage" style="display:none;visibility:visible" >
					<?php echo t('helpPage','mngradnaslist') ?>
					<br/>
				</div>
				<br/>


<?php


	include 'library/opendb.php';
	include 'include/management/pages_numbering.php';		// must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

	//orig: used as maethod to get total rows - this is required for the pages_numbering.php page
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADNAS'];
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= $sql . "\n";

	$numrows = $res->numRows();

	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADNAS']." ORDER BY $orderBy $orderType LIMIT $offset, $rowsPerPage;";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";

	/* START - Related to pages_numbering.php */
	$maxPage = ceil($numrows/$rowsPerPage);
	/* END */


        echo "<form name='listallnas' method='post' action='mng-rad-nas-del.php'>";

	echo "<table border='0' class='table1'>\n";
	echo "
					<thead>
                                                        <tr>
                                                        <th colspan='10' align='left'>

                                Select:
                                <a class=\"table\" href=\"javascript:SetChecked(1,'nashost[]','listallnas')\">All</a>

                                <a class=\"table\" href=\"javascript:SetChecked(0,'nashost[]','listallnas')\">None</a>
                        <br/>
                                <input class='button' type='button' value='Delete' onClick='javascript:removeCheckbox(\"listallnas\",\"mng-rad-nas-del.php\")' />
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
		".t('all','NasID')."</a>
		<br/>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=nasname&orderType=$orderType\">
		".t('all','NasIPHost')."</a>
		<br/>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=shortname&orderType=$orderType\">
		".t('all','NasShortname')."</a>
		<br/>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=type&orderType=$orderType\">
		".t('all','NasType')."</a>
		<br/>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=ports&orderType=$orderType\">
		".t('all','NasPorts')."</a>
		<br/>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=secret&orderType=$orderType\">
		".t('all','NasSecret')."</a>
		<br/>
		</th>

                <th scope='col'>
                <a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=secret&orderType=$orderType\">
                ".t('all','NasVirtualServer')."</a>
                <br/>
                </th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=community&orderType=$orderType\">
		".t('all','NasCommunity')."</a>
		<br/>
		</th>

		<th scope='col'>
		<a title='Sort' class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?orderBy=description&orderType=$orderType\">
		".t('all','NasDescription')."</a>
		<br/>
		</th>
	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
                                <td> <input type='checkbox' name='nashost[]' value='$row[1]'> $row[0] </td>
                                <td> <a class='tablenovisit' href='#'
								onclick='javascript:return false;'
                                tooltipText=\"
                                        <a class='toolTip' href='mng-rad-nas-edit.php?nashost=$row[1]'>".t('Tooltip','EditNAS')."</a>
                                        <a class='toolTip' href='mng-rad-nas-del.php?nashost=$row[1]'>".t('Tooltip','RemoveNAS')."</a>
                                        <br/>\"
                                        >$row[1]</a></td>
				<td> $row[2] </td>
				<td> $row[3] </td>
				<td> $row[4] </td>
				<td> $row[5] </td>
				<td> $row[6] </td>
				<td> $row[7] </td>
               <td> $row[8] </td>

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
