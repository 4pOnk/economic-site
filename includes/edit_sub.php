<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$current_user_id = $_GET['author_id'];
$current_user = $db->select('users', "`id`='${current_user_id}'")[0];
$current_user_subscriptions = explode(",", $current_user['subscriptions']);
$current_user_sub_times = explode(",", $current_user['sub_times']);
$current_user_sub_costs = explode(",", $current_user['sub_costs']);

$arr_pos = array_search($_GET['target_id'],$current_user_subscriptions);

$current_user_sub_times[$arr_pos] = $_POST['time'];
$current_user_sub_costs[$arr_pos] = $_POST['sum'];

$current_user_sub_times = implode(",", $current_user_sub_times);
$current_user_sub_costs = implode(",", $current_user_sub_costs);

$db -> update('users',['accretionPerMonth','accretionPerWeek'],[$_POST['accM'],$_POST['accW']],"`id`=${_GET['target_id']}");
$db -> update('users',['sub_times','sub_costs'],[$current_user_sub_times,$current_user_sub_costs],"`id`=${current_user_id}");

header('Location: /cabinet.php?user_id=' . $current_user_id);