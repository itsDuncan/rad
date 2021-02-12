
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

	<small class="sidebar-subheading">Profiles Management</small>

	<div class="list-group list-group-flush">
		<a href="mng-rad-profiles-list.php" class="list-group-item list-group-item-action bg-light">
			<img src='images/icons/groupsList.png' border='0'>
			<?php echo t('button','ListProfiles') ?>
		</a>

		<a href="mng-rad-profiles-new.php" class="list-group-item list-group-item-action bg-light">
			<img src='images/icons/groupsAdd.png' border='0'>
			<?php echo t('button','NewProfile') ?>
		</a>

		<div class="form-group">
			<a href="javascript:document.mngradprofileedit.submit();"" class="list-group-item list-group-item-action bg-light">
				<img src='images/icons/groupsEdit.png' border='0'>
				<?php echo t('button','EditProfile') ?>
			</a>

			<form name="mngradprofileedit" action="mng-rad-profiles-edit.php" method="get" class="sidebar">
				<?php   
					include 'include/management/populate_selectbox.php';
					populate_groups("Select Profile","profile","generic");
				?>
			</form>
		</div>

		<a href="mng-rad-profiles-duplicate.php" class="list-group-item list-group-item-action bg-light">
			<img src='images/icons/groupsEdit.png' border='0'>
			<?php echo t('button','DuplicateProfile') ?>
		</a>

		<a href="mng-rad-profiles-del.php" class="list-group-item list-group-item-action bg-light">
			<img src='images/icons/groupsRemove.png' border='0'>
			<?php echo t('button','RemoveProfile') ?>
		</a>

	</div>
</div>


<?php 
	include_once("include/management/autocomplete.php");

	if ($autoComplete) {
		echo "<script type=\"text/javascript\">
			/** Making usernameEdit interactive **/
	              autoComEdit = new DHTMLSuite.autoComplete();
              </script>";
	} 
?>