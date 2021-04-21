<?php
    include './components/header.php';
    $current_user_id = $_SESSION['user'];
    $current_user_subscriptions = $db->select('users', "`id`='${current_user_id}'")[0]['subscriptions'];
    $current_user_subscriptions = explode(",", $current_user_subscriptions);
?>
    <link rel="stylesheet" href="view/styles/shares.css">

    <main>
        <?php
            $orderRequest = $db -> select('users', "`show_in_main_page` = 1 ORDER BY `subscribers` DESC LIMIT 8");

            for($i = 0; $i < count($orderRequest); $i++):
                $user = $orderRequest[$i];
                $growthValues = explode(",", $user['growth']);
                ?>
                <div class="modalShadow" style="display: none"></div>
            <div class="share">
                <div class="shareBackground"></div>
                <div class="shareContent">
                    <div class="shareFirstInfo">
                        <div class="shareNum">0<?= $i + 1 ?></div>
                        <div class="userId" style="display: none"><?= $user['id'] ?></div>
                        <div class="shareNickName">
                            <a href="user.php?id=<?= $user['id'] ?>"><span><?= $user['login'] ?></span></a>
                        </div>
                    </div>
                    <div class="shareSchedule">
                        <div class="middleLine"></div>
                        <div class="scheduleValues">
                            <?php for($q = 0; $q < count($growthValues); $q++): ?>
                                <div class="dayProfit"><?= $growthValues[$q] ?></div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="shareGrowth">
                        <h1><?= $user['accretionPerWeek'] ?>%</h1>
                        <div class="shareGrowthInfo">
                            <p class="growthPerWeek">Прирост за 7 дней</p>
                            <p class="growthPerMonth"><b>+<?= $user['accretionPerMonth'] ?>%</b> за 1 месяц</p>
                        </div>
                    </div>
                    <div class="riceAndSubs">
                        <p class="rice"><span><?= $user['risk'] ?></span> риск</p>
                        <div class="subs"><span><?= $user['subscribers'] ?></span> подписчиков</div>
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
                </div>
            </div>
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
        let sum = document.getElementsByName('sum')[0];
        let balance = document.getElementById('balance').innerHTML;

        let sumVal = '';

        document.addEventListener('keyup',() => {
            if(sumVal !== sum.value){
                if(+sum.value > +balance || +sum.value < 0){
                    sum.value = sumVal;
                }else{
                    sumVal = sum.value;
                }
            }
        })


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