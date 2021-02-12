<?php
/*
 **********************************************
 *
 * Author: dtechcan Maina <dtechcan.dtech@gmail.com>
 *
 **********************************************
*/

isset($_REQUEST['error']) ? $error = $_REQUEST['error'] : $error = "";

// clean up error code to avoid XSS
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

    <div class="content">
      <div class="container">
        <div class="row justify-content-center">

          <div class="col-md-6 contents">
            <div class="row justify-content-center">
              <div class="col-md-12">
                <div class="form-block">
                    <div class="mb-4">
                    <h3>Sign In</h3>
                    <p class="mb-4">Welcome to <strong>GWIJINET SOLUTIONS</strong> customer portal</p>
                  </div>

                  <form name="login" action="dologin.php" method="post">
                    <div class="form-group first">
                      <label for="username">Username</label>
                      <input name="login_user" type="text" class="form-control" id="username">
                    </div>

                    <div class="form-group last mb-4">
                      <label for="password">Password</label>
                      <input name="login_pass" type="password" class="form-control" id="password">
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
