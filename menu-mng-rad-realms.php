
<body>
<?php
    include_once ("lang/main.php");
    $m_active = "Management";
	include_once ("include/menu/menu-items.php");
?>

<div id="wrapper">
<div id="innerwrapper" class="main-section d-flex">

<div class="bg-light border-right" id="sidebar-wrapper">
	<div class="sidebar-heading">Management</div>

	<small class="sidebar-subheading">Realms Management</small>

	<div class="list-group list-group-flush">
		<a href="mng-rad-realms-list.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListRealms') ?></a>
		<a href="mng-rad-realms-new.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewRealm') ?></a>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.mngradrealmedit.submit();"><?php echo t('button','EditRealm') ?>
			</a>
			<form name="mngradrealmedit" action="mng-rad-realms-edit.php" method="get" class="sidebar">
			<?php
				include_once('include/management/populate_selectbox.php');
				populate_realms("Select Realm","realmname","generic");
			?>
			</form>
		</div>

		<a href="mng-rad-realms-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveRealm') ?></a>
	</div>

	<small class="sidebar-subheading">Proxy Management</small>

	<div class="list-group list-group-flush">
		<a href="mng-rad-proxys-list.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','ListProxys') ?></a>
		<a href="mng-rad-proxys-new.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','NewProxy') ?></a>

		<div class="list-group-item list-group-item-action bg-light">
			<a href="javascript:document.mngradproxyedit.submit();"><?php echo t('button','EditProxy') ?></a>
			<form name="mngradproxyedit" action="mng-rad-proxys-edit.php" method="get" class="sidebar">
			<?php   
				populate_proxys("Select Proxy","proxyname","generic");
			?>
			</form>
		</div>

		<a href="mng-rad-proxys-del.php" class="list-group-item list-group-item-action bg-light"><?php echo t('button','RemoveProxy') ?></a>
	</div>

</div>
