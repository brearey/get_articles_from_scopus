<?php
session_start();
require_once 'vendor/autoload.php';

	$familia = false;
	$pubname = false;
	$ISSN = false;

	$findFamilia = false;
	$findPubname = false;
	$findISSN = false;
	if (isset($_POST['find'])) {

		if ($_POST['familia'] != "") {
			$familia = true;
		}
		if ($_POST['pubname'] != "") {
			$pubname = true;
		}
		if ($_POST['issn'] != "") {
			$ISSN = true;
		}
	}
	if (isset($_POST['find']) and $_POST['familia'] == "" and $_POST['pubname'] == "" and $_POST['issn'] == "") {

		$_SESSION['error'] = "Заполните хотя бы одно поле";
		header("Location: index.php");
	}

	if ($familia == true and $pubname == false and $ISSN == false) {
		$findFamilia = true;
		$findPubname = false;
		$findISSN = false;
	}
	if ($familia == false and $pubname == true and $ISSN == false) {
		$findFamilia = false;
		$findPubname = true;
		$findISSN = false;
	}
	if ($familia == false and $pubname == false and $ISSN == true) {
		$findFamilia = false;
		$findPubname = false;
		$findISSN = true;
	}
	if (($familia == true or $pubname == true) and $ISSN == true) {
		$findFamilia = false;
		$findPubname = false;
		$findISSN = true;
	}

//Делаем запрос на scopus
if ($findPubname) {
	$scopusSearch = new \Scopus\ScopusSearch('c951122905774b2a212c42fbb722659a');

	$results = $scopusSearch
         ->query('TITLE('. $_POST["pubname"] .')')
         ->start(0)
         ->count(25) //itemsPerPage
         ->search();
	$data = json_decode($results, true);
	$countOfPubs = intval($data['search-results']['opensearch:totalResults']);
}
if ($findFamilia) {
	$scopusSearch = new \Scopus\ScopusSearch('c951122905774b2a212c42fbb722659a');

	$results = $scopusSearch
         ->query('AUTHLASTNAME('. $_POST["familia"] .') AND AFFIL(North-Eastern Federal University)')
         ->start(0)
         ->count(25) //itemsPerPage
         ->search();
	$data = json_decode($results, true);
	$countOfPubs = intval($data['search-results']['opensearch:totalResults']);
}
else if ($findISSN) {
	$scopusSearch = new \Scopus\ScopusSearch('c951122905774b2a212c42fbb722659a');

	$results = $scopusSearch
         ->query('ISSN('. $_POST["issn"] .') AND AFFIL(North-Eastern Federal University)')
         ->start(0)
         ->count(25) //itemsPerPage
         ->search();
	$data = json_decode($results, true);
	$countOfPubs = intval($data['search-results']['opensearch:totalResults']);
}
$countOfResults = 1;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<title>Результат поиска публикаций</title>
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
	<div class="main container">
		<h2 class="text-secondary text-center">Результат поиска</h2>
		<div style="min-height: 400px;" class="bg-white p-5">
			<div class="mb-5"><a href="index.php">Назад</a></div>
			<h4 class="mb-5">Найдено публикаций: <?= $countOfPubs; ?></h4>
			<table class="table">
				<thead>
					<tr>
					<th scope="col">#</th>
					<th scope="col">Автор</th>
					<th scope="col">Название публикации</th>
					<th scope="col">Ссылка</th>
					<th scope="col">Выбрать</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < $countOfPubs and $i < 25; $i++): ?>
					<tr>
						<th scope="row"><?= $countOfResults; ?></th>
						<td><?= $data['search-results']['entry'][$i]['dc:creator'] ?></td>
						<td><?= $data['search-results']['entry'][$i]['dc:title'] ?></td>
						<td> <a target="_blank" href="<?= $data['search-results']['entry'][$i]['link']['2']['@href'] ?>"><?= $data['search-results']['entry'][$i]['link']['2']['@href'] ?></a></td>
						<td>
							<form action="savePub.php" method="POST">
								<input type="hidden" name="author" value="<?= $data['search-results']['entry'][$i]['dc:creator'] ?>">
								<input type="hidden" name="title" value="<?= $data['search-results']['entry'][$i]['dc:title'] ?>">
								<input type="hidden" name="link" value="<?= $data['search-results']['entry'][$i]['link']['2']['@href'] ?>">
								<button class="btn btn-success btn-sm" type="submit" name="save">Сохранить</button>
							</form>
						</td>
					</tr>
					<?php $countOfResults++; endfor; ?>
				</tbody>
			</table>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>