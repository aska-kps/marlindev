<?php
session_start();
if($_POST['title']!='' && $_POST['description']!=''){
$_SESSION['true']='<div class="alert alert-success" role="alert">
                                Комментарий успешно добавлен
                              </div>';
require "db.php";
$pdo = DB::get();



$stmt = $pdo->prepare("
	INSERT INTO `comments` 
	(`title`,
	`description`)
	VALUES (
	:title,
	:description)
	");


$stmt->execute([
                    ':title' => $_POST['title'],
                    ':description' => $_POST['description']
                ]);




}
else{
	$_SESSION['true']='<div class="alert alert-danger" role="alert">
                                Ошибка!
                              </div>';

}
 Location: header('Location: /index.php');
?>