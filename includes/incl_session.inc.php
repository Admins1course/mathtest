<?php
	session_start();
    if (isset($_COOKIE['name'])){//достаточно name, чтобы были и остальные
		$_SESSION['data-user']['id']=$_COOKIE['id'];
		$_SESSION['data-user']['name']=$_COOKIE['name'];
		$_SESSION['data-user']['surname']=$_COOKIE['surname'];
		$_SESSION['data-user']['root']=$_COOKIE['root'];
		$_SESSION['data-user']['login']=$_COOKIE['login'];
		$_SESSION['data-user']['password']=$_COOKIE['password'];
		$_SESSION['invitation']=false;
	}