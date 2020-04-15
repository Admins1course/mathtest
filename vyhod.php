<?php
	if(isset($_COOKIE['name'])){ //если есть один элемент куков, значит  есть и остальные
		setcookie("id","", time()-60*60*24*10);
		setcookie("name","", time()-60*60*24*10);
		setcookie("surname","", time()-60*60*24*10);
		setcookie("root","", time()-60*60*24*10);
	}
	header("Location: index.php");