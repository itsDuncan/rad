<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
        
	include_once('library/config_read.php');
    $log = "visited page: ";

?>

<?php

    include ("menu-reports-logs.php");

?>
		
		<div id="contentnorightbar">
			<?php
				include_once ("include/menu/reports-subnav.php");
			?>

			<div class="container">
		
		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','replogs.php'); ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage','replogs') ?>
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
