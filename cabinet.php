<?php
include './components/header.php';
$current_user_id = $_GET['user_id'];
$current_user = $db->select('users', "`id`='${current_user_id}'")[0];
$current_user_subscriptions = explode(",", $current_user['subscriptions']);
$current_user_sub_times = explode(",", $current_user['sub_times']);
$current_user_sub_costs = explode(",", $current_user['sub_costs']);

    if($_SESSION['user'] == $current_user_id)
?>
    <link rel="stylesheet" href="view/styles/shares.css">

    <main>
        <h1>Мои подписки:</h1>
        <?php
        $orderRequest = $db -> select('users', "`show_in_main_page` = 1");

        for($i = 0; $i < count($orderRequest); $i++):
            $user = $orderRequest[$i];
            $arr_pos = array_search($user['id'],$current_user_subscriptions);
            if($arr_pos !== false):
            $growthValues = explode(",", $user['growth']);
            ?>
            <div class="modalShadow" style="display: none"></div>
            <div class="share" style="height: 180px;transform: skew(-5deg)">
                <?php if($current_user['role'] === 'admin'): ?>
                <a href="edit_sub.php?author_id=<?= $current_user_id ?>&target_id=<?= $user['id'] ?>" style="color: red">Изменить</a>
                <?php endif; ?>
                <div class="shareBackground"></div>
                <div class="shareContent">
                    <div class="shareFirstInfo">
                        <div class="shareNum" style="opacity: 0">0<?= $i + 1 ?></div>
                        <div class="userId" style="display: none"><?= $user['id'] ?></div>
                        <div class="shareNickName">
                            <a href="user.php?id=<?= $user['id'] ?>"><span><?= $user['login'] ?></span></a>
                        </div>
                    </div>
                    <div style="margin-left: 15px">

                    <div class="shareGrowth">
                        <h1><?= $user['accretionPerWeek'] ?>%</h1>
                        <div class="shareGrowthInfo">
                            <p class="growthPerWeek">Прирост за 7 дней</p>
                            <p class="growthPerMonth"><b>+<?= $user['accretionPerMonth'] ?>%</b> за 1 месяц</p>
                        </div>
                    </div>
                    <?php if($user['id'] != $_SESSION['user']): ?>
                        <?php if(array_search($user['id'],$current_user_subscriptions) !== false):?>
                            <a href="includes/subscribe.php?target=<?= $user['id'] ?>"><input type="button" value="отписаться" class="shareJoin shareUnsub"></a>
                            <input type="hidden" value="присоединиться" class="shareJoin shareSub">
                        <?php else: ?>
                            <input type="button" value="присоединиться" class="shareJoin shareSub">
                        <?php endif; ?>
                    <?php else: ?>
                        <input type="button" value="Это - вы" class="shareJoin shareUnsub">
                        <input type="hidden" value="присоединиться" class="shareJoin shareSub">
                    <?php endif ?>
                    <style>
                        .subInfo{
                            transform: translateX(-35px);

                            margin-top: 20px;
                        }
                        .subInfo span{
                            font-size: 18px;
                        }
                    </style>
                    </div>
                    <div class="subInfo" style="transform: translateX(-5px)">
                        <span>Стоимость подписки: <?= $current_user_sub_costs[$arr_pos] ?></span>
                        <span>Срок подписки: <?= $current_user_sub_times[$arr_pos] ?> дней</span><br>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php endfor; ?>
    </main>

    <form style="display: none" action="" method="post" class="subModalWin">
        <h3>Оформление подписки:</h3>
        <div>
            <span>Сумма:</span>
            <input type="text" name="sum" required>
        </div><br>
        <div>
            <span>Срок:</span>
            <select name="date" style="color: black">
                <option style="color: black">7</option>
                <option style="color: black">30</option>
            </select>
            <span>дней</span>
        </div><br>
        <input type="submit">
    </form>

    <script src="view/js/schedule.js"></script>
    <script>
        let shareSub = document.querySelectorAll('.shareSub');
        let subModalWin = document.querySelector('.subModalWin');
        let modalShadow = document.querySelector('.modalShadow');
        let subscribeModalWin = document.querySelector('.subscribeModalWin');
        let userId = document.querySelectorAll('.userId');




        for(let i = 0 ; i < shareSub.length; i++){
            shareSub[i].addEventListener('click',()=>{
                document.querySelector('form').action = 'includes/subscribe.php?target=' + userId[i].innerHTML;
                subModalWin.style.display = 'block';
                modalShadow.style.display = 'block';
                modalShadow.addEventListener('click',() => {
                    subModalWin.style.display = 'none';
                    modalShadow.style.display = 'none';
                })
            })
        }
    </script>

<?php
include './components/footer.php';
?>