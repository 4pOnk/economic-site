<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$author_id = $_SESSION['user'];
$target_id = $_GET['target_id'];
$text = htmlspecialchars(trim($_POST['text']));

if(!empty($text)){
    $db -> insert('comments',['author_id','target_id','text'],[$author_id,$target_id,$text]);
}

header('Location: /user.php?id=' . $target_id);