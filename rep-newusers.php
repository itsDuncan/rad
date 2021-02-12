<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

        include('library/check_operator_perm.php');

        if (isset($_GET['startdate']))
                $startdate = $_GET['startdate'];
        if (isset($_GET['enddate']))
                $enddate = $_GET['enddate'];


        include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query for listing of records on page: ";



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

<script src="js/dtech/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/dtech/dtech.js" type="text/javascript"></script>

<?php
        include_once ("library/tabber/tab-layout.php");
?>

<?php

    include ("menu-reports.php");

?>

                <div id="contentnorightbar">
                    <?php
                        include_once ("include/menu/reports-subnav.php");
                    ?>

                    <div class="container">
                
                                <h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro','repnewusers.php'); ?>
                                <h144>&#x2754;</h144></a></h2>
                                
                <div id="helpPage" style="display:none;visibility:visible" >
                        <?php echo t('helpPage','repnewusers'); ?>
                        <br/>
                </div>
                <br/>


<div class="tabber">

     <div class="tabbertab" title="Statistics">
        <br/>   
        
<?php

        include 'library/opendb.php';
        include 'include/management/pages_common.php';
        include 'include/management/pages_numbering.php';               // must be included after opendb because it needs to read the CONFIG_IFACE_TABLES_LISTING variable from the config file

        //orig: used as maethod to get total rows - this is required for the pages_numbering.php page
        $sql = "SELECT CONCAT(MONTH(CreationDate),'-',YEAR(Creationdate)) AS Month, ".
                        "COUNT(*) As Users FROM ".
                        $configValues['CONFIG_DB_TBL_DALOUSERINFO'].
                        " WHERE CreationDate >='$startdate' AND CreationDate <='$enddate' ".
                        " GROUP BY Month(Creationdate) ";
        $res = $dbSocket->query($sql);
        $numrows = $res->numRows();


        /* we are searching for both kind of attributes for the password, being User-Password, the more
           common one and the other which is Password, this is also done for considerations of backwards
           compatibility with version 0.7        */

           
        $sql = "SELECT CONCAT(YEAR(CreationDate),'-',MONTH(Creationdate), '-01') AS Month, ".
                        "COUNT(*) As Users FROM ".
                        $configValues['CONFIG_DB_TBL_DALOUSERINFO'].
                        " WHERE CreationDate >='$startdate' AND CreationDate <='$enddate' ".
                        " GROUP BY Month ORDER BY Date(Month);";
        $res = $dbSocket->query($sql);
        $logDebugSQL = "";
        $logDebugSQL .= $sql . "\n";


        echo "<form name='usersonline' method='get' >";

        echo "<table border='0' class='table1'>\n";
        echo "
                <thead>
                        <tr>
                        <th colspan='5' align='left'>

                        <br/>
                ";


        echo "</th></tr>
                        </thead>
        ";

        echo "<thread> <tr>
                <th scope='col'>
                ".t('all','Month'). "
                </th>

                <th scope='col'>
                        ".t('all','Users')."
                </th>

        </tr> </thread>";

        while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {

                $Month = $row['Month'];
                $Users = $row['Users'];

                echo "<tr>
                                <td> $Month </td>
                                <td> $Users</td>
                </tr>";
        }

        echo "
                                        <tfoot>
                                                        <tr>
                                                        <th colspan='5' align='left'>
        ";
        echo "
                                                        </th>
                                                        </tr>
                                        </tfoot>
                ";
        
        echo "</table>";
        include 'library/closedb.php';
                
?>

        </div>


     <div class="tabbertab" title="Graph">
        <br/>


<?php
        echo "<center>";
        echo "<img src=\"library/graphs-reports-new-users.php?startdate=$startdate&enddate=$enddate\" />";
        echo "</center>";
?>

        </div>
</div>



<?php
        include('include/config/logging.php');
?>
                
                </div>
            </div>
                
                <div id="footer">
                
                                                                <?php
        include 'page-footer.php';
?>


<script type="text/javascript">
var tooltipObj = new DHTMLgoodies_formTooltip();
tooltipObj.setTooltipPosition('right');
tooltipObj.setPageBgColor('#EEEEEE');
tooltipObj.setTooltipCornerSize(15);
tooltipObj.initFormFieldTooltip();
</script>
                
                </div>
                
</div>
</div>


</body>
</html>
