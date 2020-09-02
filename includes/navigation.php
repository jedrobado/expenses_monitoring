<!-- side nav/ do not touch -->
<?php
function highlight_top_nav($file_name,$top_nav_selected){
	if($file_name==$top_nav_selected){
		return "nav_page_active";
	}
}
?>
<header class="default_background_color">
	<!-- headnav -->
	<nav class="py-0 navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav default_background_color pr-0">
		<div class="float-left">
			<a href="#" data-activates="slide-out" class="button-collapse ml-0"><i class="fas fa-stream"></i></a>
		</div>
		<div class="breadcrumb-dn mr-auto white-text">
			<p><?php echo $page_title;?></p>
		</div>
		<ul class="nav navbar-nav nav-flex-icons ml-auto">
			<li class="nav-item dropdown <?php echo highlight_top_nav($file_name,'profile.php');?>">
				<a class="hvr-pop nav-link" href="#" id="profile_menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo $short_url;?>image/<?php echo ($_SESSION['profile_picture']!=""?"profile_picture/".$_SESSION['profile_picture']:"person_male.png");?>" alt="profile" class="nav_profile">
				</a>
				<div class="dropdown-menu dropdown-menu-right secondary_background_color custom_dropdown_menu" aria-labelledby="profile_menu">
					<a class="white-text btn btn-sm hvr-pop dropdown-item" href="profile.php">Profile</a>
					<a class="white-text btn btn-sm hvr-pop dropdown-item" id="logout" type="button">Logout</a>
				</div>
			</li>
		</ul>
	</nav>
</header>
<!-- start of main/ do not touch -->
<main class="ml-0 mr-0 pt-0 mt-5">
    <div class="container-fluid">