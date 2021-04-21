<?php
    session_start();
    require 'controller/DB.php';
    $db = new Database();
    $user_id = $_SESSION['user'];
    $user = $db -> select('users',"`id` = ${user_id}")[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="view/styles/header.css">
</head>
<body>
<div class="rounds">
    <div class="round1"></div>
    <div class="round2"></div>
    <div class="round3"></div>
</div>
<header>
    <nav>
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a  href="#">О нас</a></li>
            <li class="logo"><a  href="/"><h2>LOGO</h2></a></li>
            <li><a href="#">Новости</a></li>
            <li><a href="#">Правила</a></li>
        </ul>
    </nav>
    <div class="userInfo">
        <?php if($user['image']): ?>
            <a href="/cabinet.php?user_id=<?= $user_id ?>"><img src="<?= $user['image'] ?>" alt="" class="userImage"></a>
        <?php else: ?>
        <img src="./view/images/logo_example.png" alt="" class="userImage">
        <?php endif; ?>
        <div class="redShadow"></div>
        <?php if($_SESSION['user']): ?>
            <a href="/cabinet.php?user_id=<?= $user_id ?>"><h5 class="userName"><?= $user['login'] ?></h5></a>
        <span class="balance"><a href="/top_up_balance.php">Баланс:</a><span id="balance"><?= $user['balance'] ?></span></span>
        <div class="userLinks">
            <a href="#"><img src="./view/images/link.png" alt=""></a>
            <a href="#"><img src="./view/images/vk.png" alt=""></a>
            <a href="/includes/logout.php"><img src="./view/images/logout.png" alt=""></a>
        </div>
        <?php else: ?>
            <a href="/login.php"><input type="button" value="Войти" class="loginBtn"></a>
        <?php endif; ?>
    </div>
</header>