<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$comment_id = $_GET['id'];

$db -> delete('comments',"`id` = $comment_id");

header("Location: /user.php?id=" . $_GET['user_id']);