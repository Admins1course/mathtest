<?php
try{
	$sql="SELECT `file` FROM `avatars` WHERE id_User=:id";
	$result=$pdo->prepare($sql);
	$result->execute(['id'=>$_SESSION['data-user']['id']]);
	$result=$result->fetchAll(PDO::FETCH_ASSOC);
	if(preg_match("/[^0-9a-f]/",$result[0]['file'])){
		$path='';
	}
	else if ($result[0]['file']!=null){
		$path='avatars'. DIRECTORY_SEPARATOR .$result[0]['file'];
	}
	else $path='';
}
catch(PDOException $e){
	$path='';
}