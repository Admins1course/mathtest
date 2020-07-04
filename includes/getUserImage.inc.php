<?php
if ($is_login){
	try{
		$sql="SELECT `file` FROM `avatars` WHERE id_User=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_SESSION['data-user']['id']]);
		$result=$result->fetchAll(PDO::FETCH_ASSOC);
		if ($result[0]['file']!=null) $path='avatars/'.$_SESSION['data-user']['id'].'/'.$result[0]['file'];
		else $path='';
	}
	catch(PDOException $e){
		
	}
}