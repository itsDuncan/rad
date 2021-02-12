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
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<body>
<?php
	include_once ("lang/main.php");
	$m_active = "Graphs";
	include_once ("include/menu/menu-items.php");
	include_once("include/management/autocomplete.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

	<div class="bg-light border-right" id="sidebar-wrapper">
		<div class="sidebar-heading">Graphs</div>

		<small class="sidebar-subheading">User Graph</small>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.overall_logins.submit();">
					<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','UserLogins') ?>
				</a>
				<form name="overall_logins" action="graphs-overall_logins.php" method="post" class="sidebar">
					<input name="username" class="form-control" type="text" id="usernameLogins" <?php if ($autoComplete) echo "autocomplete='off'"; ?> tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
						value="<?php if (isset($overall_logins_username)) echo $overall_logins_username; ?>">
					<select class="generic" class="form-control"> name="type" type="text">
						<option value="daily"> <?php echo t('all','Daily') ?>
						<option value="monthly"> <?php echo t('all','Monthly') ?>
						<option value="yearly"> <?php echo t('all','Yearly') ?>
					</select>
				</form>
			</div>

			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.overall_download.submit();">
					<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','UserDownloads') ?>
				</a>
				<form name="overall_download" action="graphs-overall_download.php" method="post" class="sidebar">
					<input name="username" class="form-control" type="text" id="usernameDownloads" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
				                        tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
						value="<?php if (isset($overall_download_username)) echo $overall_download_username; ?>">
					<select class="generic" class="form-control"> name="type" type="text">
						<option value="daily"> <?php echo t('all','Daily') ?>
						<option value="monthly"> <?php echo t('all','Monthly') ?>
						<option value="yearly"> <?php echo t('all','Yearly') ?>
					</select>
					<select class="generic" class="form-control" name="size" type="text">
						<option value="megabytes"> <?php echo t('all','Megabytes') ?>
						<option value="gigabytes"> <?php echo t('all','Gigabytes') ?>
					</select>
				</form>
			</div>

			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.overall_upload.submit();">
					<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','UserUploads') ?>
				</a>
				<form name="overall_upload" action="graphs-overall_upload.php" method="post" class="sidebar">
					<input name="username" class="form-control" type="text" id="usernameUploads" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
				                        tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
						value="<?php if (isset($overall_upload_username)) echo $overall_upload_username; ?>">
					<select class="generic" class="form-control" name="type" type="text">
						<option value="daily"> <?php echo t('all','Daily') ?>
						<option value="monthly"> <?php echo t('all','Monthly') ?>
						<option value="yearly"> <?php echo t('all','Yearly') ?>
					</select>
					<select class="generic" class="form-control" name="size" type="text">
						<option value="megabytes"> <?php echo t('all','Megabytes') ?>
						<option value="gigabytes"> <?php echo t('all','Gigabytes') ?>
					</select>
				</form>
			</div>
		</div>

		<small class="sidebar-subheading">Statistics</small>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.alltime_logins.submit();">
					<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','TotalLogins') ?>
				</a>
				<form name="alltime_logins" action="graphs-alltime_logins.php" method="post" class="sidebar">
					<select class="generic" class="form-control" name="type" type="text">
						<option value="daily"> <?php echo t('all','Daily') ?>
						<option value="monthly"> <?php echo t('all','Monthly') ?>
						<option value="yearly"> <?php echo t('all','Yearly') ?>
					</select>
				</form>
			</div>
		</div>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.alltime_traffic_compare.submit();">
						<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','TotalTraffic') ?>
				</a>

				<form name="alltime_traffic_compare" action="graphs-alltime_traffic_compare.php" method="post" 
					class="sidebar">
					<select class="generic" class="form-control" name="type" type="text">
						<option value="daily"> <?php echo t('all','Daily') ?>
						<option value="monthly"> <?php echo t('all','Monthly') ?>
						<option value="yearly"> <?php echo t('all','Yearly') ?>
					</select>
					<select class="generic" class="form-control" name="size" type="text">
						<option value="megabytes"> <?php echo t('all','Megabytes') ?>
						<option value="gigabytes"> <?php echo t('all','Gigabytes') ?>
					</select>
				</form>
			</div>
		</div>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.alltime_traffic_compare.submit();">
					<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','TotalTraffic') ?>
				</a>
				
				<form name="alltime_traffic_compare" action="graphs-alltime_traffic_compare.php" method="post" 
					class="sidebar">
				<select class="generic" name="type" type="text">
					<option value="daily"> <?php echo t('all','Daily') ?>
					<option value="monthly"> <?php echo t('all','Monthly') ?>
					<option value="yearly"> <?php echo t('all','Yearly') ?>
				</select>
				<select class="generic" name="size" type="text">
					<option value="megabytes"> <?php echo t('all','Megabytes') ?>
					<option value="gigabytes"> <?php echo t('all','Gigabytes') ?>
				</select>
				</form>
			</div>
		</div>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				
			</div>
		</div>

		<div class="list-group list-group-flush">
			<div class="list-group-item list-group-item-action bg-light">
				<a href="javascript:document.logged_users.submit();">
					<img src='images/icons/graphsGeneral.gif' border='0'>
					<?php echo t('button','LoggedUsers') ?>
				</a>
				<form name="logged_users" action="graphs-logged_users.php" method="post" class="sidebar">
					<?php echo t('graphs','Day'); ?>:</br>
					<?php $d = date("j"); ?>
					<select class="generic" class="form-control" name="day" type="text">
						<?php 
							$i = 1;
							while ($i<32):
						?>
							<option value="<?php echo $i ?>" <?php if($d == $i) echo "selected" ?> > <?php echo $i ?> </option>
						<?php $i++; 	?>
						<?php endwhile; ?>
					</select>
					<?php echo t('graphs','Month'); ?>:</br>
					<?php $m = date("M"); ?>
					<select class="generic" class="form-control" name="month" type="text">
						<option value="jan" <?php if ($m == 'Jan') echo "selected" ?>> <?php echo t('graphs','Jan')?> </option>
						<option value="feb" <?php if ($m == 'Feb') echo "selected" ?>> <?php echo t('graphs','Feb')?> </option>
						<option value="mar" <?php if ($m == 'Mar') echo "selected" ?>> <?php echo t('graphs','Mar')?> </option>
						<option value="apr" <?php if ($m == 'Apr') echo "selected" ?>> <?php echo t('graphs','Apr')?> </option>
						<option value="may" <?php if ($m == 'May') echo "selected" ?>> <?php echo t('graphs','May')?> </option>
						<option value="jun" <?php if ($m == 'Jun') echo "selected" ?>> <?php echo t('graphs','Jun')?> </option>
						<option value="jul" <?php if ($m == 'Jul') echo "selected" ?>> <?php echo t('graphs','Jul')?> </option>
						<option value="aug" <?php if ($m == 'Aug') echo "selected" ?>> <?php echo t('graphs','Aug')?> </option>
						<option value="sep" <?php if ($m == 'Sep') echo "selected" ?>> <?php echo t('graphs','Sep')?> </option>
						<option value="oct" <?php if ($m == 'Oct') echo "selected" ?>> <?php echo t('graphs','Oct')?> </option>
						<option value="nov" <?php if ($m == 'Nov') echo "selected" ?>> <?php echo t('graphs','Nov')?> </option>
						<option value="dec" <?php if ($m == 'Dec') echo "selected" ?>> <?php echo t('graphs','Dec')?> </option>
					</select>
					<?php echo t('graphs','Year'); ?>:</br>
					<select class="generic" class="form-control" name="year" type="text">
						<?php
							for($i = 0; $i <= 10; $i++) {
								$myDate = date('Y', mktime(0, 0, 0, 1, 1, (date('Y')-$i) ));
								echo "<option value='$myDate'>$myDate</option>";
							}
						?>
					</select>
				</form>
			</div>
		</div>
	</div>


<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameLogins','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameDownloads','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameUploads','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
