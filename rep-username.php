<?php

include ("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');


	//setting values for the order by and order type variables
isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "id";
isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";


if (isset($_REQUEST['username']))
	$username = $_REQUEST['username'];

include_once('library/config_read.php');
$log = "visited page: ";
$logQuery = "performed query for user [$username] on page: ";


?>

<?php

include ("menu-reports.php");

?>

<div id="contentnorightbar">
	<?php
		include_once ("include/menu/reports-subnav.php");
	?>

	<div class="container">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','repusername.php'); ?>
	<h144>&#x2754;</h144></a></h2>

	<div id="helpPage" style="display:none;visibility:visible" >
		<?php echo t('helpPage','repusername')." ".$username ?>
		<br/>
	</div>
	<br/>



	<?php


	include 'library/opendb.php';

	// table to display the radcheck information per the $username

	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." WHERE UserName='".$dbSocket->escapeSimple($username)."'  ORDER BY $orderBy $orderType;";
	$res = $dbSocket->query($sql);
	$logDebugSQL = "";
	$logDebugSQL .= "";
	$logDebugSQL .= $sql . "\n";

	echo "<table border='0' class='table1'>\n";
	echo "
	<thead>
	<tr>
	<th colspan='10'>".t('captions','radcheckrecords')."</th>
	</tr>
	</thead>
	";

	echo "<thread> <tr>
	<th scope='col'> ".t('all','ID')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=id&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=id&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Username')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=username&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=username&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Attribute')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=attribute&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=attribute&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Value')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=value&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=value&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Action')." </th>
	</tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
		<td> $row[0] </td>
		<td> $row[1] </td>
		<td> $row[2] </td>
		<td> $row[4] </td>
		<td> <a href='mng-edit.php?username=$row[1]'> ".t('all','edit')." </a> 
		<a href='mng-del.php?username=$row[1]'> ".t('all','del')." </a>
		</td>
		</tr>";
	}
	echo "</table>";
	echo "<br/><br/>";


	
	
	// table to display the radreply information per the $username
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADREPLY']." WHERE UserName='".$dbSocket->escapeSimple($username)."'  ORDER BY $orderBy $orderType;";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";

	echo "<table border='0' class='table1'>\n";
	echo "
	<thead>
	<tr>
	<th colspan='10'>".t('captions','radreplyrecords')."</th>
	</tr>
	</thead>
	";

	echo "<thread> <tr>                        
	<th scope='col'> ".t('all','ID')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=id&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=id&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Username')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=username&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=username&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Attribute')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=attribute&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=attribute&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Value')."
	<br/>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=value&orderType=asc\"> > </a>
	<a class='novisit' href=\"" . $_SERVER['PHP_SELF'] . "?username=$username&orderBy=value&orderType=desc\"> < </a>
	</th>
	<th scope='col'> ".t('all','Action')." </th>                </tr> </thread>";
	while($row = $res->fetchRow()) {
		echo "<tr>
		<td> $row[0] </td>
		<td> $row[1] </td>
		<td> $row[2] </td>
		<td> $row[4] </td>
		<td> <a href='mng-edit.php?username=$row[1]'> ".t('all','edit')." </a> 
		<a href='mng-del.php?username=$row[1]'> ".t('all','del')." </a>
		</td>
		</tr>";
	}
	echo "</table>";


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


</body>
</html>
