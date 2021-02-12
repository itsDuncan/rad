<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

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
			<?php echo t('helpPage','mngradprofiles') ?>
			<br/>
		</div>	
		<br/>

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
