<?php require_once 'includes/db.inc.php';
	  require_once 'includes/incl_session.inc.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" charset="UTF-8">
	<link rel="stylesheet" href="style/Main.css?<?=time()?>" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style/CsslistTest.css?<?=time()?>" type="text/css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<?php include 'includes/script_for_nav_menu.php';?>	
</head>
<body style="height: 2000px;">
	<div id="page">
	</div>
		<div class="slider midle">
			<div class="slides">
				<input type="radio" name="r" id="r1" checked>
				<input type="radio" name="r" id="r2" >
				<input type="radio" name="r" id="r3" >
				<input type="radio" name="r" id="r4" >

				<div class="slide s1"> <img src="style/img/FonBooks.png" alt=""></div>
				<div class="slide"> <img src="style/img/books.png" alt=""></div>
				<div class="slide"> <img src="style/img/rtx.png" alt=""></div>
				<div class="slide"> <img src="style/img/Artem.png" alt=""></div>
			</div>

			<div class="navigation">
				<label for="r1" class="bar"></label>
				<label for="r2" class="bar"></label>
				<label for="r3" class="bar"></label>
				<label for="r4" class="bar"></label>
			</div>
		</div>
		<div id="plus_inform">
			<div class="search_area">
				<div class="search">
					<input type="text" class="search_bar">	
				</div>
				<div class="search_send">
					<p class="search_send_title">поиск</p>
				</div>
			</div>
		</div>
		<?php 
		$sql='SELECT idAuthor,idTest,taskName FROM tests';
		$result=$pdo->query($sql);
		$tests=$result->fetchAll();
		for ($i=0;$i<count($tests);$i++):
			$sql="SELECT name,surname FROM users WHERE id=:idAuthor";
			$result=$pdo->prepare($sql);
			$result->execute(['idAuthor'=>$tests[$i]['idAuthor']]);
			$users=$result->fetchAll();?>
			<div id="main_content">
				<a href="book.html.php?idUser=<?=$tests[$i]['idAuthor']?>&idTest=<?=$tests[$i]['idTest']?>">
				<div class="test_href">
					<p>Название: <?=$tests[$i]['taskName'];?></p>
					<p>Автор: <?=$users[0]['name']?> <?=$users[0]['surname']?></p>
				</div>
			</div>
		<?php endfor;?>
		<div id="right_block">
			<ul class="testlist">
				<li class="test_name"><a href="" class="test_title">Математический анализ</a></li>
				<li class="test_name"><a href="" class="test_title">Интегральные и дифферинциальные уравнения</a></li>
				<li class="test_name"><a href="" class="test_title">Прикладная математика</a></li>
			</ul>
		</div>
			<div id="left_block_title">
			</div>
			<div id="left_block" class="left_block">
			</div>
<?php include 'includes/nav_menu.php';?>
	<div id="footer">
		<div class="text">
			2020
		</div>
	</div>
</body>
</html>