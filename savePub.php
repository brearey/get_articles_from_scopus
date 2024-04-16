<?php
session_start();

if (isset($_POST['save'])) {
	$_SESSION['author'] = $_POST['author'];
	$_SESSION['title'] = $_POST['title'];
	$_SESSION['link'] = $_POST['link'];

	$_SESSION['message'] = 'Публикация успешно сохранена! Проверьте <a href="myPubs.php">Мои публикации</a>';

	header("Location: index.php");
}

?>