		</div>
	</main>
	<!-- set title/ make sure to set title in navigation -->
	<title><?php echo $page_title;?></title>
	<!-- bottom elements/ do not touch -->
	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/jquery-ui.min.js"></script>
 	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/popper.min.js"></script>
 	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/perfect-scrollbar.min.js"></script>
 	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/addons/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/mdb.min.js"></script>
	<script type="text/javascript" src="<?php echo $short_url;?>mdb_components/js/my_js.min.js"></script>
</body>
</html>
<!-- prevents posting forms upon page refresh -->
<script type="text/javascript">
	if ( window.history.replaceState ) {
		window.history.replaceState( null, null, window.location.href );
	}
</script>