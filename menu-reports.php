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
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

 
<body>
<?php
include_once ("lang/main.php");
?>

<?php
	$m_active = "Reports";
	include_once ("include/menu/menu-items.php");
    include_once("include/management/autocomplete.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Reports</div>

	<small class="sidebar-subheading">Users Reports</small>

	<div class="list-group list-group-flush">
		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.reponline.submit();">
			<img src='images/icons/reportsOnlineUsers.gif' border='0'>
			<?php echo t('button','OnlineUsers') ?></a>

			<form name="reponline" action="rep-online.php" method="get" class="sidebar">
				<input name="usernameOnline" type="text" id="usernameOnline"
				<?php if ($autoComplete) echo "autocomplete='off'"; ?>
				tooltipText='<?php echo t('Tooltip','Username'); ?> <br/> <?php echo t('Tooltip','UsernameWildcard') ?> <br/>'
				value="<?php if (isset($usernameOnline)) echo $usernameOnline ?>" tabindex=1>
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.replastconnect.submit();">
				<img src='images/icons/reportsLastConnection.png' border='0'>
				<?php echo t('button','LastConnectionAttempts') ?>
			</a>

			<form name="replastconnect" action="rep-lastconnect.php" method="get" class="sidebar">
				<input name="usernameLastConnect" type="text" id="usernameLastConnect"
					<?php if ($autoComplete) echo "autocomplete='off'"; ?>
					tooltipText='<?php echo t('Tooltip','Username'); ?> <br/> <?php echo t('Tooltip','UsernameWildcard') ?> <br/>'
					value="<?php if (isset($usernameLastConnect)) echo $usernameLastConnect ?>" tabindex=2>
					<select class="generic form-control" name="radiusreply" tabindex=3>
						<option value="Any">Any</option>
						<option value="Access-Accept">Access-Accept</option>
						<option value="Access-Reject">Access-Reject</option>
					</select>

					<small class="sidebar-subheading">Start Date</small>
					<img src="library/js_date/calendar.gif" 
					onclick="showChooser(this, 'startdate_lastconnect', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<input name="startdate" type="text" id="startdate_lastconnect"
					tooltipText='<?php echo t('Tooltip','Date'); ?>'
					value="<?php if (isset($startdate)) echo $startdate;
					else echo date("Y-m-01"); ?>">
					<div id="chooserSpan" class="dateChooser select-free" 
					style="display: none; visibility: hidden; 	width: 160px;">
					</div>
					<small class="sidebar-subheading">End Date</small>

					<img src="library/js_date/calendar.gif" 
					onclick="showChooser(this, 'enddate_lastconnect', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<input name="enddate" type="text" id="enddate_lastconnect"
					tooltipText='<?php echo t('Tooltip','Date'); ?>'
					value="<?php if (isset($enddate)) echo $enddate;
					else echo date("Y-m-t"); ?>">
					<div id="chooserSpan" class="dateChooser select-free" 
					style="display: none; visibility: hidden; 	width: 160px;">
				</div>
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.repnewusers.submit();">
				<img src='images/icons/userList.gif' border='0'>
				<?php echo t('button','NewUsers') ?>
			</a>

				<form name="repnewusers" action="rep-newusers.php" method="get" class="sidebar">
				<small class="sidebar-subheading">Start Date</small>
				<img src="library/js_date/calendar.gif"
				onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
				<input name="startdate" type="text" id="startdate"
				tooltipText='<?php echo t('Tooltip','Date'); ?>'
				value="<?php if (isset($startdate)) echo $startdate;
				else echo date("Y-01-01"); ?>">
				<div id="chooserSpan" class="dateChooser select-free" 
					style="display: none; visibility: hidden; 	width: 160px;">
				</div>

				<small class="sidebar-subheading">End Date</small>
				<img src="library/js_date/calendar.gif" 
				onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
				<input name="enddate" type="text" id="enddate"
				tooltipText='<?php echo t('Tooltip','Date'); ?>'
				value="<?php if (isset($enddate)) echo $enddate;
				else echo date("Y-m-t"); ?>">
				<div id="chooserSpan" class="dateChooser select-free" 
				style="display: none; visibility: hidden; 	width: 160px;">
				</div>
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.topusers.submit();">
				<img src='images/icons/reportsTopUsers.png' border='0'>
				<?php echo t('button','TopUser') ?>
			</a>
				<form name="topusers" action="rep-topusers.php" method="get" class="sidebar">
					<select class="form-control" class="generic" name="limit" type="text" tabindex=3>
						<option value="5"> 5 </option>
						<option value="10"> 10 </option>
						<option value="20"> 20 </option>
						<option value="50"> 50 </option>
						<option value="100"> 100 </option>
						<option value="500"> 500 </option>
						<option value="1000"> 1000 </option>
					</select>

					<small class="sidebar-subheading">Username Filter</small>
					<input name="username" type="text" id="username" 
					value="<?php if (isset($username)) echo $username; else echo "%"; ?>">
					
					<small class="sidebar-subheading">Start Date</small>
					<img src="library/js_date/calendar.gif" 
					onclick="showChooser(this, 'startdate_topuser', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
					<input name="startdate" type="text" id="startdate_topuser"
					tooltipText='<?php echo t('Tooltip','Date'); ?>'
					value="<?php if (isset($startdate)) echo $startdate;
					else echo date("Y-m-01"); ?>">
					<div id="chooserSpan" class="dateChooser select-free" 
					style="display: none; visibility: hidden; 	width: 160px;">
				</div>
				
				<small class="sidebar-subheading">End Date</small>
				<img src="library/js_date/calendar.gif" 
				onclick="showChooser(this, 'enddate_topuser', 'chooserSpan', 1950, <?php echo date('Y', time());?>, 'Y-m-d', false);">
				<input name="enddate" type="text" id="enddate_topuser"
				tooltipText='<?php echo t('Tooltip','Date'); ?>'
				value="<?php if (isset($enddate)) echo $enddate;
				else echo date("Y-m-t"); ?>">
				<div id="chooserSpan" class="dateChooser select-free" 
				style="display: none; visibility: hidden; 	width: 160px;">
				</div>
				<small class="sidebar-subheading">Report By</small>

				<select class="generic" name="orderBy" type="text" tabindex=4>
					<option value="Bandwidth"> bandwidth </option>
					<option value="Time"> time </option>
				</select>
			</form>
		</div>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="rep-history.php">
				<img src='images/icons/reportsHistory.png' border='0'>
				<?php echo t('button','History') ?>
			</a>
		</div>

	</div>
</div>

<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameOnline','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
                      autoComEdit.add('usernameLastConnect','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
                      </script>";
        }
?>

	
<script type="text/javascript">
        var tooltipObj = new DHTMLgoodies_formTooltip();
        tooltipObj.setTooltipPosition('right');
        tooltipObj.setPageBgColor('#EEEEEE');
        tooltipObj.setTooltipCornerSize(15);
        tooltipObj.initFormFieldTooltip();
</script>
