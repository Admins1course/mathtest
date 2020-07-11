<?php
	if(basename($_SERVER['HTTP_REFERER'])==='index.php'){
		setcookie("id",null, -1,'/');
		setcookie("randomCookie",null, -1,'/');
		@session_start();
		unset($_SESSION['data-user']);
		session_destroy();
		header("Location: index.php");
	}