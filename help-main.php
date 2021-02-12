<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
        
	include_once('library/config_read.php');
    $log = "visited page: ";
    include('include/config/logging.php');

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

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>
 
<?php
	include ("menu-help.php");
?>
		
		<div id="contentnorightbar">
			<?php
				include_once ("include/menu/help-subnav.php");
			?>
			<div class="container">
		
				<h2 id="Intro"><a href="#">Help</a></h2>
				<p>
				
				One of several communication mediums available at your disposal:<br/><br/>
				
				<b>daloRADIUS website</b>: <a href="http://www.daloradius.com">daloRADIUS blog</a><br/><br/>
				<b>daloRADIUS Project at GitHub</b>: <a href="https://github.com/lirantal/daloradius">GitHub project</a><br/>
				At GitHub you may find the trackers for submitting tickets for support, bugs or features for next releases.<br/>
				The official daloRADIUS package is available at
				GitHub as well.<br/><br/>
				<b>daloRADIUS Project at SourceForge</b>: <a href="http://sourceforge.net/projects/daloradius/">SourceForge project</a><br/>
				Forums and the mailing list archive to review and search for issues.<br/>
				The daloRADIUS packages here are old, use the GitHub ones instead.<br/><br/>
				<b>daloRADIUS Mailing List</b>: Email to daloradius-users@lists.sourceforge.net, though registration to the mailing list<br/>
				is required first <a href="https://lists.sourceforge.net/lists/listinfo/daloradius-users">here</a><br/><br/>
				
				<b>daloRADIUS IRC</b>: you can find us at #daloradius on irc.freenode.net
				</p>
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
