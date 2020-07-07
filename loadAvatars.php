<?php
session_start();
require_once "includes/checkSession.inc.php";
if ($is_login){
	if(isset($_POST['my_file_upload'])&&$_POST['my_file_upload']){  
		require_once "includes/db.inc.php";
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
		}
		
		$limitBytes  = 1024 * 1024 * 5;

		if (filesize($filePath) > $limitBytes){
			echo json_encode(['errorUpload'=>'Размер изображения не должен превышать 5 Мбайт.']);
			exit();
		}
		
		$name = md5_file($filePath);

		$extension = image_type_to_extension($image[2]);

		$format = str_replace('jpeg', 'jpg', $extension);

		/*if (is_dir('./avatars/'.$_SESSION['data-user']['id'])){
			clear_dir('./avatars/'.$_SESSION['data-user']['id'].'/');
		}
		else{
			mkdir('./avatars/'.$_SESSION['data-user']['id'],0777,true);
		}*/
		if(move_uploaded_file
			(
				$_FILES[0]['tmp_name'],
				__DIR__ . DIRECTORY_SEPARATOR .'avatars'. DIRECTORY_SEPARATOR . $name . $format
			))
		{
			$sql="UPDATE `avatars` SET `file`=:name WHERE id_User=:id";
			$pdo->prepare($sql)->execute(['name'=>$name.$format,
										  'id'=>$_SESSION['data-user']['id']]);
		}
		else{
			echo json_encode(['errorUpload'=>'При записи изображения на диск произошла ошибка.']);
		}
		$data['name']=$name.$format;
		$data['id']=$_SESSION['data-user']['id'];
		$data['error']=$errorCode;
		echo json_encode($data);
	}
}
else{
	echo json_encode(['answer'=>'errorDataUser']);
}