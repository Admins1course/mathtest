<?php 
if(isset($_GET['idUser'])&&isset($_GET['idTest'])){
	if(!(preg_match("/[\D]/",$_GET['idUser'])&&preg_match("/[a-f0-9]/",$_GET['idTest']))){
		$sql="SELECT `id` FROM `tests` WHERE `id`=:idTest AND `idAuthor`=:idUser";
		$result=$pdo->prepare($sql);
		$result->execute(['idTest'=>$_GET['idTest'],
						  'idUser'=>$_GET['idUser']]);
		if($result->fetchAll(PDO::FETCH_ASSOC)===[]){
			echo 'Данный тест не существует';
			exit();
		}
		else{
			$_SESSION['tests'][$_GET['idTest']]=true;
		}
	}
}