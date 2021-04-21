<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$email = htmlspecialchars(trim($_POST['email']));
$name = htmlspecialchars(trim($_POST['name']));
$password = $_POST['password'];
$file = $_FILES['file'];

$compareUsers = +$db -> count_res('users', "`login`='${name}'");

$err = true;

if(!empty($email) && !empty($name) && !empty($password) && $compareUsers == 0){
    $password = md5($password);
    if($file['size'] != 0 && ($file['type'] == 'image/png' || $file['type'] == 'image/jpg' || $file['type'] == 'image/jpeg')){
        $path = 'uploads/' . time() . $file['name'];
        move_uploaded_file($file['tmp_name'], '../' . $path);
        $db -> insert('users',['email','login','password','image'],[$email,$name,$password, $path]);
    }else{
        $db -> insert('users',['email','login','password'],[$email,$name,$password]);
    }
    $user_id = $db -> select('users', "`login`='${name}'")[0]['id'];
    $_SESSION['user'] = $user_id;
    $err = false;
}else if (empty($email) || empty($name) || empty($password)){
    $_SESSION['reg_message'] = 'Пожалуйста, заполните все поля';
}else if($compareUsers > 0){
    $_SESSION['reg_message'] = 'Пользователь с таким именем уже зарегистрирован';
}

if($err){
    header('Location: /registration.php');
}else{
    header('Location: /');
}