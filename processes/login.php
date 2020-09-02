<?php
	// login process
	include("../includes/connect.php");
	session_start();
	$return=array();
	// username, password and status check
	$get_user=retrieve("SELECT * FROM user WHERE username=? AND password=?",array($_POST['username'],$_POST['password']));
	// if username and password match
	if(COUNT($get_user)>0){
		$_SESSION['user_id']=$get_user[0]['id'];
		$return=array("success","Login success.");
	}
	else{
		$return=array("warning","Username and password does not match or not yet verified.");
	}
	echo json_encode($return);
?>