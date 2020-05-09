<html>
<head>
    <title>Загрузка файлов на сервер</title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>

<?php
if ( ! $_FILES )
{
    echo '
		<script>
		$(document).ready(function(){
			console.log($(\':file\'));
		});
		function q(element){console.log($(element))}</script>
		  <h2>Форма для загрузки файлов</h2>
		  <form action="" method="post" enctype="multipart/form-data">
		  <input type="file" name="filename[task1]" oninput="q(this)"><br>
		  <input type="submit" value="Загрузить"><br>
		  </form>
	';
}
else
{
    // Проверяем загружен ли файл
    if(  is_uploaded_file($_FILES["filename"]["tmp_name"]['task1'])  )
    {
        // Если файл загружен успешно, перемещаем его
        // из временной директории в конечную
        move_uploaded_file
        (
            $_FILES["filename"]["tmp_name"]['task1'],
            __DIR__  .  DIRECTORY_SEPARATOR  .'sql'.DIRECTORY_SEPARATOR . $_FILES["filename"]["name"]['task1']
        );
		echo __DIR__ .'<br>';
		echo var_dump($_FILES);
    } else {
        echo("Ошибка загрузки файла");
    }
}
?>

</body>
</html>