<?php
include './components/header.php';
session_start();

$current_user_id = $_GET['author_id'];
$current_user = $db->select('users', "`id`='${current_user_id}'")[0];
$current_user_subscriptions = explode(",", $current_user['subscriptions']);
$current_user_sub_times = explode(",", $current_user['sub_times']);
$current_user_sub_costs = explode(",", $current_user['sub_costs']);

$arr_pos = array_search($_GET['target_id'],$current_user_subscriptions);
$target_user = $db -> select('users',"`id`=${_GET['target_id']}")[0];
?>
    <style>
        main{
            position: relative;
        }
        input,textarea{
            color: black;
        }
        p{
            margin-top: 20px;
        }
        input[type=submit]{
            padding: 7px 15px;
            margin-bottom: 30px;
        }


        form{
            display: block;
            margin-left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
    </style>
    <main>
        <form action="includes/edit_sub.php?author_id=<?= $_GET['author_id'] ?>&target_id=<?= $_GET['target_id'] ?>" method="post">
            <p>Месячный прирост:</p>
            <input type="text" name="accW" style="width: 75px" value="<?= $target_user['accretionPerWeek'] ?>">%
            <p>Недельный прирост:</p>
            <input type="text" name="accM" style="width: 75px" value="<?= $target_user['accretionPerMonth'] ?>">%
            <p>Сумма подписки</p>
            <input name="sum" value="<?= $current_user_sub_costs[$arr_pos] ?>"><br>
            <p>Время подписки</p>
            <input type="text" name="time" value="<?= $current_user_sub_times[$arr_pos] ?>"><br>
            <input type="submit">
        </form>
    </main>
<?php
include './components/footer.php';
?>