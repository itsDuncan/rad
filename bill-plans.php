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

	<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">

	<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

	<link rel="stylesheet" href="css/dtech/bootstrap.min.css">
	<link rel="stylesheet" href="css/dtech/style.css">

	<title>GwijiNet</title>
</head>
 
<?php

	include ("menu-bill-plans.php");
	
?>		
		
		<div id="contentnorightbar">
			<?php
			include_once ("include/menu/billing-subnav.php");
			?>

			<div class="container">
		
				<h2 id="Intro"><a href="#"><?php echo t('Intro','billplans.php') ?></a></h2>


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
