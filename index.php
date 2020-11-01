<?php

session_start();

if (isset($_SESSION['message'])) {
	echo (
		'<div class="alert alert-success mb-0" role="alert">
  		'.$_SESSION['message'].'
  		</div>'
	);
	$_SESSION['message'] = null;
}

if (isset($_SESSION['error'])) {
	echo (
		'<div class="alert alert-danger mb-0" role="alert">
  		'.$_SESSION['error'].'
  		</div>'
	);
	$_SESSION['error'] = null;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<title>Импорт публикаций</title>
	<style>
		header {
			display: flex;
			padding: 8px;
			background-color: #fff;
		}
		header img {
			vertical-align: center;
		}
		header .left {
			width: 33%;
		}
		header .middle {
			width: 34%;
			text-align: center;
		}
		header .right {
			width: 33%;
			padding-top: 16px;
			text-align: center;
		}
		header .right button {
			color: #fff;
			background-color: #6ab8ee;
			border: none;
		}

		.menu {
			height: 43px;
			background-color: #3398dc;
			text-transform: uppercase;
		}
		.menu a {
			color: #fff !important;
			font-weight: 600;
			font-size: 0.92857rem;
		}
		body {
			background-color: #eeeeee;
		}

		.main .mleft {
			height: 400px;
			padding-top: 20px;
			padding-left: 380px;
		}
		.main .mleft .list-group {
			width: 240px;
		}
		.main .mright {
			height: 400px;
			padding-top: 20px;
			font-weight: 300px;
		}
		.pubs {
			width: 800px;
			background-color: white;
			padding: 20px;
		}
	</style>
</head>
<body>
	<header>
		<div class="left"></div>
		<div class="middle">
			<img src="https://www.s-vfu.ru/bitrix/templates/s1/assets/img/logo/logo-1.png" alt="">
		</div>
		<div class="right">
			<button class="btn btn-primary">Поиск</button>
		</div>
	</header>
	<nav class="menu navbar navbar-expand-lg">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav mx-auto">
				<a class="nav-link" href="#">Университет</a>
				<a class="nav-link" href="#">Абитуриенту</a>
				<a class="nav-link" href="#">Студенту</a>
				<a class="nav-link" href="#">Выпускнику</a>
				<a class="nav-link" href="#">Сотруднику</a>
				<a class="nav-link" href="#">Работодателю</a>
				<a class="nav-link" href="#">Закупки</a>
				<a class="nav-link" href="#">Институты и факультеты</a>
			</div>
		</div>
	</nav>
	<div class="main row">
		<div class="mleft col-4">
			<div class="list-group list-group-border-0 g-mb-10 rounded-0">
                <a href="#" class="list-group-item list-group-item-action justify-content-between g-bg-primary--hover g-brd-primary--hover g-color-white--hover">Профиль</a>
                <a style="background-color: #6ab8ee; color: white;" href="#" class="list-group-item list-group-item-action justify-content-between g-bg-primary--hover g-brd-primary--hover g-color-white--hover">Импорт публикаций</a>
                <a href="myPubs.php" class="list-group-item list-group-item-action justify-content-between g-bg-primary--hover g-brd-primary--hover g-color-white--hover">Мои публикации</a> 
            </div>
		</div>
		<div class="mright col-8">
			<h2 class="text-secondary">Импорт публикаций</h2>
			<div class="pubs">
				<div class="logoScopus">
					<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Scopus_logo.svg/1024px-Scopus_logo.svg.png" height="60">
				</div>
				<div class="desc">
					<p class="text-secondary">Здесь можно найти и импортировать свои публикации из базы данных <a href="https://scopus.com" target="_blank">Scopus</a></p>
				</div>
				<form action="finder.php" method="POST">
					<div class="form-group">
						<label for="familia">Поиск по фамилии:</label>
						<input type="text" class="form-control" id="familia" name="familia" placeholder="Используйте латинские буквы">
					</div>
					<div class="form-group">
						<label for="pubname">Поиск по названию публикации:</label>
						<input type="text" class="form-control" id="pubname" name="pubname" placeholder="Используйте латинские буквы">
					</div>
					<div class="form-group">
						<label for="issn">Поиск по ISSN:</label>
						<input type="number" class="form-control" id="issn" name="issn" aria-describedby="issnHelp" placeholder="00000000">
						<small id="issnHelp" class="form-text text-muted">Если вы знаете ISSN Вашей публикации, то введите в это поле</small>
					</div>
					<button type="submit" name="find" class="btn btn-primary">Найти в Scopus</button>
				</form>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>