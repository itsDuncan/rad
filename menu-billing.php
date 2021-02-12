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

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>


<body>
<?php
    include_once ("lang/main.php");
    $m_active = "Billing";
    include_once ("include/menu/menu-items.php");
?>
<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

	<div class="bg-light border-right" id="sidebar-wrapper">
		<div class="sidebar-heading">Billing</div>

		<small class="sidebar-subheading">Billing Engine</small>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.billprepaidhotspot.submit();">Prepaid Accounting</a>
				<form name="billprepaidhotspot" action="bill-prepaid.php" method="get" class="sidebar">
					<select class="form-control" name="hotspot" size="3">
						<option value='%'> all
							<?php

							include 'library/opendb.php';

							$sql = "select name from ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']."";
							$res = $dbSocket->query($sql);

							while($row = $res->fetchRow()) {
								echo "
								<option value='$row[0]'> $row[0]
								";
							}
							include 'library/closedb.php';
							?>
					</select>

					<br/>
					Filter by date
					<input name="startdate" type="text" id="startdate" value="2006-01-01">
					<img src="library/js_date/calendar.gif" onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;">
					</div>

					<input name="enddate" type="text" id="enddate" value="2006-12-01">
					<img src="library/js_date/calendar.gif" onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;">
					</div>
				</form>
			</div>

			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.billpersecondhotspot.submit();">Per-second Accounting</a>
				<form name="billpersecondhotspot" action="bill-persecond.php" method="get" class="sidebar">
				<select class="form-control" name="ps-hotspot" size="3">
					<option value='%'> all
						<?php
							include 'library/opendb.php';

							$sql = "select name from ".$configValues['CONFIG_DB_TBL_DALOHOTSPOTS']."";
							$res = $dbSocket->query($sql);

							while($row = $res->fetchRow()) {
								echo "
								<option value='$row[0]'> $row[0]
								";
							}

							include 'library/closedb.php';
						?>
				</select>

					<br/>Filter by date
					<input class="form-control" name="ps-startdate" type="text" id="ps-startdate" value="2006-01-01">
					<img src="library/js_date/calendar.gif" onclick="showChooser(this, 'ps-startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>
					<input class="form-control" name="ps-enddate" type="text" id="ps-enddate" value="2006-12-01">
					<img src="library/js_date/calendar.gif" onclick="showChooser(this, 'ps-enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>

				</form>
			</div>
		</div>
	</div>

<?php

        if ((isset($actionStatus)) && ($actionStatus == "success")) {
                echo <<<EOF
                        <div id="contentnorightbar">
                        <h9 id="Intro"> Success </h9>
                        <br/><br/>
                        <font color='#0000FF'>
EOF;
        echo $actionMsg;

        echo "</font></div>";

        }


        if ((isset($actionStatus)) && ($actionStatus == "failure")) {
                echo <<<EOF
                        <div id="contentnorightbar">
                        <h8 id="Intro"> Failure </h8>
                        <br/><br/>
                        <font color='#FF0000'>
EOF;
        echo $actionMsg;

        echo "</font></div>";

        }


?>
