<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$target_id = $_GET['id'];
$user_id = $_SESSION['user'];

$events = [];
$ev_empty = true;
if(count($_POST['eventHref']) > 0){
    for($i = 0 ; $i < count($_POST['eventHref']); $i++){
        if(!empty($_POST['eventName'][$i]))$ev_empty = false;
        $push_str = "<a href=" . $_POST['eventHref'][$i] . ">" . $_POST['eventName'][$i] . "</a>";
        if($_POST['eventHref'][$i] == '') $push_str = "<span>" . $_POST['eventName'][$i] . "</span>";
        $events[] = $push_str;
    }
}
$events =  implode(",", $events);
if($ev_empty){
    $events = $db -> select('users', "`id`=${target_id}")[0]['events'];
}

$opportunities = '';
for($i = 0; $i < 4; $i++){
    if($i !== 3) {
        $opportunities .= $_POST['opportunities'][$i] . ',';
    }else{
        $opportunities .= $_POST['opportunities'][$i];
    }
}
$simp = 0;
if($_POST['simp'] == 'on')
    $simp = 1;

if($db -> select('users', "`id`='${user_id}'")[0]['role'] == 'admin'){
    $db -> update('users',['balance','login','show_in_main_page','accretionPerWeek','accretionPerMonth','risk','growth','growth_dates','information','events','opportunities'], ["'${_POST['balance']}'","'${_POST['name']}'","'${simp}'","'${_POST['week']}'","'${_POST['month']}'","'${_POST['risk']}'","'${_POST['graph_vals']}'","'${_POST['graph_dates']}'","'${_POST['info']}'","'$events'","'$opportunities'"],"`id`=${target_id}",true);
}



header('Location: /user.php?id=' . $target_id);