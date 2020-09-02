<?php

	session_start();
	$return=array();
	$return=array("success","Logout success.");
	session_destroy();
	echo json_encode($return);
?>