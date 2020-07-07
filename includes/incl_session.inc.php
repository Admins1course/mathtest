<?php
	session_start();
    if (isset($_COOKIE['id'])&&
		isset($_COOKIE['name'])&&
		isset($_COOKIE['surname'])&&
		isset($_COOKIE['root'])&&
		isset($_COOKIE['login'])&&
		isset($_COOKIE['password'])){
		$_SESSION['data-user']['id']=$_COOKIE['id'];
		$_SESSION['data-user']['name']=$_COOKIE['name'];
		$_SESSION['data-user']['surname']=$_COOKIE['surname'];
		$_SESSION['data-user']['root']=$_COOKIE['root'];
		$_SESSION['data-user']['login']=$_COOKIE['login'];
		$_SESSION['data-user']['password']=$_COOKIE['password'];
		$_SESSION['invitation']=false;
	}