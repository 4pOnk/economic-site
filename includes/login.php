<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$name = htmlspecialchars(trim($_POST['name']));
$password = $_POST['password'];

$err = true;

if (!empty($name) && !empty($password)) {
    $password = md5($password);
    $compareUsers = +$db->count_res('users', "`login`='${name}' AND `password`='${password}'");
    if($compareUsers >= 0){
        $user_id = $db->select('users', "`login`='${name}' AND `password`='${password}'")[0]['id'];
        $_SESSION['user'] = $user_id;
        $err = false;
    }else{
        $_SESSION['log_message'] = 'Пользователя с такими данными нет';
    }
} else if (empty($name) || empty($password)) {
    $_SESSION['log_message'] = 'Пожалуйста, заполните все поля';
}

if ($err) {
    header('Location: /login.php');
} else {
    header('Location: /');
}