<?php

	session_start();
	
	if (!isset($_SESSION['user'])) {
		header("Location: index");
	} else if(isset($_SESSION['user'])!="") {
		header("Location: index");
	}
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['user']);
		session_unset();
		session_destroy();
		header("Location: index");
		exit;
	}