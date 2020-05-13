<?php
try{
	$pdo = new PDO ('mysql:host=localhost;dbname=c9mathtest', 'c9mathtest', 'tq6mWY!2');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e){
	$error="Невозможно подключиться к базе данных: ".$e->getMessage();
	include 'error.html.php';
	exit();
}