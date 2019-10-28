<?php
session_start();





if($_POST['name']!='' && filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)!='' && $_POST['password']!='' && $_POST['password']==$_POST['password2']){
$_SESSION['reg']='<div class="alert alert-success" role="alert">
                                Регистрация прошла успешно
                              </div>';

require "db.php";
$pdo = DB::get();



$stmt = $pdo->prepare("
	INSERT INTO `users` 
	(`name`,
	`mail`,
	`password`)
	VALUES (
	:name,
	:mail,
	:password)
	");


$stmt->execute([
                    ':name' => $_POST['name'],
                    ':mail' => $_POST['mail'],
                    ':password' => password_hash(($_POST['password']), PASSWORD_DEFAULT),
                ]);

}
else{


if($_POST['password']!=$_POST['password2']){$_SESSION['reg']='Пароли не совпадают!';}
if(strlen($_POST['password'])<6){$_SESSION['reg']='Пароль должен быть больше 5 символов';}
if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)==''){$_SESSION['reg']='Введите правильный email!';}
if($_POST['name']==''){$_SESSION['reg']='Введите имя!';}
if($_POST==''){$_SESSION['reg']='Заполните форму';}
}



 Location: header('Location: /register.php');
?>