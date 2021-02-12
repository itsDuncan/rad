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

  <title>GwijiNet</title>
</head>

<?php

	include ("menu-mng-users.php");

?>

<div id="contentnorightbar">

  <?php
  include_once("include/menu/management-subnav.php");
  ?>

  <div class="container">

  <h2 id="Intro"><a href="#"><?php echo t('Intro','mngmain.php') ?></a></h2>
  <p>
    <table><center><br/>
      <img src="library/chart-mng-total-users.php" />
    </table></center>
  </p>


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
