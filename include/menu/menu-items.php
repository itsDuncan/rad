                <div id="header">

                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                  <a class="navbar-brand" href="#"><strong>GWIJINET</strong></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavBar" aria-controls="mainNavBar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="mainNavBar">
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <form class="form-inline my-2 my-lg-0" action="mng-search.php">
                      <input name="username" class="form-control mr-sm-2" type="search" placeholder="Search users" aria-label="Search users" title="<?php echo t('Tooltip','Username') . '. ' . t('Tooltip','UsernameWildcard'); ?>">
                      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    <div id="login_data" class="px-2 text-light">
                      <span><?php echo $operator; ?></span>@<span><?php echo $_SESSION['location_name'] ?></span>
                    </div>

                  </div>
                </nav>

                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#subNavBar" aria-controls="subNavBar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="subNavBar">
                    <ul class="navbar-nav mr-auto">
                      <li class="list-item"><a href="index.php" class="nav-link" <?php echo ($m_active == "Home") ? "class=\"active\"" : ""?>>Home</a></li>
                      <li class="list-item"><a href="mng-main.php" class="nav-link" <?php echo ($m_active == "Management") ? "class=\"active\"" : "" ?>>Management</a></li>
                      <li class="list-item"><a href="rep-main.php" class="nav-link" <?php echo ($m_active == "Reports") ? "class=\"active\"" : "" ?>>Reports</a></li>
                      <li class="list-item"><a href="acct-main.php" class="nav-link" <?php echo ($m_active == "Accounting") ? "class=\"active\"" : "" ?>>Accounting</a></li>
                      <li class="list-item"><a href="bill-main.php" class="nav-link" <?php echo ($m_active == "Billing") ? "class=\"active\"" : "" ?>>Billing</a></li>
                      <li class="list-item"><a href="gis-main.php" class="nav-link" <?php echo ($m_active == "Gis") ? "class=\"active\"" : ""?>>GIS</a></li>
                      <li class="list-item"><a href="graph-main.php" class="nav-link" <?php echo ($m_active == "Graphs") ? "class=\"active\"" : ""?>>Graphs</a></li>
                      <li class="list-item"><a href="config-main.php" class="nav-link" <?php echo ($m_active == "Config") ? "class=\"active\"" : ""?>>Config</a></li>
                      <li class="list-item"><a href="help-main.php" class="nav-link" <?php echo ($m_active == "Help") ? "class=\"active\"" : ""?>>Help</a></li>
                    </ul>

                  </div>
                </nav>
              </div>
