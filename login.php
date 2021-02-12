<?php
/*
 **********************************************
 *
 * Author: dtechcan Maina <duncan.dtech@gmail.com>
 *
 **********************************************
*/

isset($_REQUEST['error']) ? $error = $_REQUEST['error'] : $error = "";
$error = strip_tags(htmlspecialchars($error));

?>
  <!doctype html>

  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
      <title>GwijiNet</title>

      <link rel="stylesheet" href="css/dtech/owl.carousel.min.css">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/dtech/bootstrap.min.css">

      <!-- Style -->
      <link rel="stylesheet" href="css/dtech/style.css">

      <title>GwijiNet</title>
    </head>
    <body>

      <?php
          include_once ("lang/main.php");
      ?>

    <div class="content">
      <div class="container">
        <div class="row justify-content-center">

          <div class="col-md-6 contents">
            <div class="row justify-content-center">
              <div class="col-md-12">
                <div class="form-block">
                    <div class="mb-4">
                    <h3>GWIJINET SOLUTIONS</h3>
                    <p class="mb-4">Kindly provide you credentials to access the <strong>admin portal</strong></p>
                  </div>

                  <form name="login" action="dologin.php" method="post">
                    <div class="form-group first">
                      <label for="username">Username</label>
                      <input name="operator_user" type="text" class="form-control" id="username">
                    </div>

                    <div class="form-group last mb-4">
                      <label for="password">Password</label>
                      <input name="operator_pass" type="password" class="form-control" id="password">
                    </div>

                    <div class="form-group">
                      <h6>Select Location</h6>
                      <select name="location" tabindex=3 class="form-control" id="location" >
          							<?php
          								if (isset($configValues['CONFIG_LOCATIONS']) && is_array($configValues['CONFIG_LOCATIONS']) && count($configValues['CONFIG_LOCATIONS']) > 0) {
          							        	foreach ($configValues['CONFIG_LOCATIONS'] as $locations=>$val)
          							                	echo "<option value='$locations'>$locations</option>";
          								} else {
          								        echo "<option value='default'>Default</option>";
          								}
          							?>
          						</select>
                    </div>

                    <input type="submit" value="Log In" class="btn btn-pill text-white btn-block btn-primary">

                  </form>

                  <?php
                  	if ($error) {
                  		echo $error;
                  		echo t('messages','loginerror');
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center mt-5">
          <p>Curated by <a href="https://www.dtech.site/">dtech</a> </p>
        </div>

      </div>
    </div>


      <script src="js/dtech/jquery-3.3.1.min.js"></script>
      <script src="js/dtech/popper.min.js"></script>
      <script src="js/dtech/bootstrap.min.js"></script>
      <script src="js/dtech/main.js"></script>
    </body>
  </html>
