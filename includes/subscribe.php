<?php
session_start();
require '../controller/DB.php';
$db = new Database();

$current_user_id = $_SESSION['user'];
$target_user_id = $_GET['target'];

$sum = $_POST['sum'];
$date = $_POST['date'];

$subscribed = false;

if($current_user_id) {
    $user = $db->select('users', "`id`='${current_user_id}'")[0];
    $current_user_subscriptions = $user['subscriptions'];
    $current_user_sum = $user['sub_costs'];
    $current_user_time = $user['sub_times'];
    if(!empty($current_user_subscriptions)) {
        $current_user_subscriptions = explode(",", $current_user_subscriptions);
        $current_user_sum = explode(",", $current_user_sum);
        $current_user_time = explode(",", $current_user_time);
        $foundPos = -1;
        for ($i = 0; $i < count($current_user_subscriptions); $i++) {
            if (+$current_user_subscriptions[$i] == $target_user_id) {
                $subscribed = true;
                $foundPos = $i;
                break;
            }
        }
    }

    if (!$subscribed) {
        if(+$sum > 0):
        if(!empty($current_user_subscriptions)) {
            $current_user_subscriptions[] = $target_user_id;
            $current_user_sum[] = $sum;
            $current_user_time[] = $date;
            $current_user_subscriptions = implode(",", $current_user_subscriptions);
            $current_user_sum = implode(",", $current_user_sum);
            $current_user_time = implode(",", $current_user_time);
        }
        else {
            $current_user_subscriptions = $target_user_id;
            $current_user_sum = $sum;
            $current_user_time = $date;
        }
        $db->update('users', ['subscribers'], ["`subscribers` + 1"], "`id`='${target_user_id}'", true);
        $db->update('users', ['subscriptions','sub_costs','sub_times','balance'], ["'$current_user_subscriptions'","'$current_user_sum'","'$current_user_time'","`balance` - ${sum}"], "`id`='${current_user_id}'", true);
        endif;

    } else {
        $sum = $current_user_sum[$foundPos];
        unset($current_user_subscriptions[$foundPos]);
        unset($current_user_sum[$foundPos]);
        unset($current_user_time[$foundPos]);
        $current_user_subscriptions = implode(",", $current_user_subscriptions);
        $current_user_sum = implode(",", $current_user_sum);
        $current_user_time = implode(",", $current_user_time);
        $db->update('users', ['subscribers'], ["`subscribers` - 1"], "`id`='${target_user_id}'", true);
        $db->update('users', ['subscriptions','sub_costs','sub_times','balance'], ["'$current_user_subscriptions'","'$current_user_sum'","'$current_user_time'","`balance` + ${sum}"], "`id`='${current_user_id}'", true);
    }
}
if($_GET['fromUser'])
    header('Location: /user.php?id=' . $_GET['fromUser']);
else
    header('Location: /');