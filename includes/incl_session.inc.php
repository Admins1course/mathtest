<?php
	session_start();
	if (!isset($_SESSION['data-user'])){
	    if (isset($_COOKIE['name'])){//достаточно name, чтобы были и остальные
			$_SESSION['data-user']['id']=$_COOKIE['id'];
			$_SESSION['data-user']['name']=$_COOKIE['name'];
			$_SESSION['data-user']['surname']=$_COOKIE['surname'];
			$_SESSION['data-user']['root']=$_COOKIE['root'];
		}
	}