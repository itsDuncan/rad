<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>

<body>
<?php
    include_once ("lang/main.php");
    $m_active = "Billing";
    include_once ("include/menu/menu-items.php");
    include_once("include/management/autocomplete.php");
?>
<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">


<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Billing</div>

    <small class="sidebar-subheading">Payments Management</small>

    <div class="list-group list-group-flush">
        <div class="list-group-item list-group-item-action bg-light">
            <a href="javascript:document.paymentslist.submit();"><?php echo t('button','ListPayments') ?></a>
                    
            <form name="paymentslist" action="bill-payments-list.php" method="get" class="sidebar">
                <input class="form-control" name="username" type="text" id="username" 
                autocomplete='off'
                tooltipText='<?php echo t('Tooltip','Username'); ?> <br/>'
                value="<?php if (isset($edit_username)) echo $edit_username; ?>" tabindex=3>
                
                <input class="form-control" name="invoice_id" type="text" id="invoice_id" 
                tooltipText='<?php echo t('Tooltip','invoiceID'); ?> <br/>'
                value="<?php if (isset($edit_invoice_id)) echo $edit_invoice_id; ?>" tabindex=3>
            </form>
        </div>

        <div class="list-group-item list-group-item-action bg-light">
            <a href="bill-payments-new.php"><?php echo t('button','NewPayment') ?></a>
        </div>

        <div class="list-group-item list-group-item-action bg-light">
            <a href="javascript:document.paymentsedit.submit();"><?php echo t('button','EditPayment') ?></a>
            <form name="paymentsedit" action="bill-payments-edit.php" method="get" class="sidebar">
            <input class="form-control" name="payment_id" type="text" id="payment_id" 
tooltipText='<?php echo t('Tooltip','PaymentId'); ?> <br/>'
                    value="<?php if (isset($edit_payment_id)) echo $edit_payment_id; ?>" tabindex=3>
            </form>
        </div>

        <div class="list-group-item list-group-item-action bg-light">
            <a href="bill-payments-del.php"><?php echo t('button','RemovePayment') ?></a>
        </div>

        
    </div>

    <small class="sidebar-subheading">Payment Types Management</small>

    <div class="list-group list-group-flush">
        <div class="list-group-item list-group-item-action bg-light">
            <a href="bill-payment-types-list.php"><?php echo t('button','ListPayTypes') ?></a>
        </div>

        <div class="list-group-item list-group-item-action bg-light">
            <a href="bill-payment-types-new.php"><?php echo t('button','NewPayType') ?></a>
        </div>

        <div class="list-group-item list-group-item-action bg-light">
            <a href="javascript:document.paymenttypesedit.submit();""><?php echo t('button','EditPayType') ?></a>
                <form name="paymenttypesedit" action="bill-payment-types-edit.php" method="get" class="sidebar">
                <input class="form-control" name="paymentname" type="text" id="paymentname" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
tooltipText='<?php echo t('Tooltip','PayTypeName'); ?> <br/>'
                        value="<?php if (isset($edit_paymentName)) echo $edit_paymentName; ?>" tabindex=3>
                </form>
        </div>

        <div class="list-group-item list-group-item-action bg-light">
            <a href="bill-payment-types-del.php"><?php echo t('button','RemovePayType') ?></a>
        </div>
    </div>
</div>

<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                        /** Making usernameEdit interactive **/
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('username','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
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
