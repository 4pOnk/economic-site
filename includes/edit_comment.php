<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$db -> update('comments',['pub_time','text'],[$_POST['time'],$_POST['text']],"`id`=${_GET['id']}");

header('Location: /user.php?id=' . $db -> select('comments',"`id`=${_GET['id']}")[0]['target_id']);