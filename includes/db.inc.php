<?php
try{
	$pdo = new PDO ('mysql:host=localhost;dbname=formuly', 'formulyuser', 'rf19dp62pi');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
	$error="Невозможно подключиться к базе данных: ".$e->getMessage();
	include 'error.html.php';
	exit();
}