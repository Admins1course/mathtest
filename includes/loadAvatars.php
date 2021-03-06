<?php
@session_start();
if(isset($_POST['my_file_upload'])&&$_POST['my_file_upload']){  
	require_once "db.inc.php";
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
	$filePath  = $_FILES[0]['tmp_name'];
	$errorCode = $_FILES[0]['error'];
	if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {
		$errorMessages = [
			UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
			UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
			UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
			UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
			UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
			UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
			UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
		];
		$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
		$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
		echo json_encode(['errorUpload'=>$outputMessage]);
		exit();
	}
	
	$fi = finfo_open(FILEINFO_MIME_TYPE);
	$mime = (string) finfo_file($fi, $filePath);
	if (strpos($mime, 'image') === false){
		echo json_encode(['errorUpload'=>'Можно загружать только изображения.']);
		exit();
	}
	
	$limitBytes  = 1024 * 1024 * 5;
	if (filesize($filePath) > $limitBytes){
		echo json_encode(['errorUpload'=>'Размер изображения не должен превышать 5 Мбайт.']);
		exit();
	}
	$image = getimagesize($filePath);
	$filepath.=$_SESSION['data-user']['id'];
	$name = md5_file($filePath);  
	$extension = image_type_to_extension($image[2]);
	$format = str_replace('jpeg', 'jpg', $extension);
	
	if(move_uploaded_file
		(
			$_FILES[0]['tmp_name'],
			__DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'avatars'. DIRECTORY_SEPARATOR . $name . $format
		))
	{
		$sql="SELECT `file` FROM `avatars` WHERE id_User=:id";
		$result=$pdo->prepare($sql);
		$result->execute(['id'=>$_SESSION['data-user']['id']]);
		$result=$result->fetchAll(PDO::FETCH_ASSOC);
		$sql="UPDATE `avatars` SET `file`=:name WHERE id_User=:id";
		$pdo->prepare($sql)->execute(['name'=>$name.$format,
									  'id'=>$_SESSION['data-user']['id']]);
		if(file_exists('../avatars/'.$result[0]['file'])) unlink('../avatars/'.$result[0]['file']);
	}
	else{
		echo json_encode(['errorUpload'=>'При записи изображения на диск произошла ошибка.']);
	}
	$data['name']=$name.$format;
	$data['id']=htmlspecialchars($_SESSION['data-user']['id']);
	$data['error']=htmlspecialchars($errorCode);
	echo json_encode($data);
}