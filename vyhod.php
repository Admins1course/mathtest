<?php
	if (isset($_COOKIE['id'])&&isset($_COOKIE['randomCookie'])){
		setcookie("id","", time()-60*60*10*30,'/','mathtest.rfpgu.ru');
		setcookie("randomCookie","",time()-60*60*10*30,'/','mathtest.rfpgu.ru');
	}
	session_start();
	unset($_SESSION);
	session_destroy();
	header("Location: index.php");