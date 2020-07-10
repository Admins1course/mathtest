<?php
	setcookie("id","", time()-60*60*24*30);
	setcookie("randomCookie","", time()-60*60*24*30);
	session_start();
	unset($_SESSION['data-user']);
	session_destroy();
header("Location: index.php");