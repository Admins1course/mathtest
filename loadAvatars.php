<?php
if( isset( $_POST['my_file_upload'] ) ){  
	require_once "includes/db.inc.php";
	// ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно
	session_start();
	function myscandir($dir)
	{
		$list = scandir($dir);
		unset($list[0],$list[1]);
		return array_values($list);
	}
	function clear_dir($dir)
	{
		$list = myscandir($dir);
		foreach ($list as $file)
		{
			unlink($dir.$file);
		}
	}
	if (is_dir('./avatars/'.$_SESSION['data-user']['id'])){
		clear_dir('./avatars/'.$_SESSION['data-user']['id'].'/');
	}
	else{
		mkdir('./avatars/'.$_SESSION['data-user']['id'],0777,true);
	}
	if(move_uploaded_file
		(
			$_FILES[0]['tmp_name'],
			__DIR__ . DIRECTORY_SEPARATOR .'avatars'. DIRECTORY_SEPARATOR .$_SESSION['data-user']['id']. DIRECTORY_SEPARATOR . $_FILES[0]['name']
		))
	{
		$sql="UPDATE `avatars` SET `file`=:name WHERE id_User=:id";
		$pdo->prepare($sql)->execute(['name'=>$_FILES[0]['name'],
									  'id'=>$_SESSION['data-user']['id']]);
	}
	$data['name']=$_FILES[0]['name'];
	$data['id']=$_SESSION['data-user']['id'];
	echo json_encode($data);
}