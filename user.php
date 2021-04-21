<?php
include './components/header.php';
$user_id = $_GET['id'];
$user = $db -> select('users',"`id` = ${user_id}")[0];
$growthValues = explode(",", $user['growth']);
$growthDates = explode(",", $user['growth_dates']);
$opportunities = explode(",", $user['opportunities']);
$events = explode(",", $user['events']);
$current_user_id = $_SESSION['user'];
$current_user_subscriptions = $db->select('users', "`id`='${current_user_id}'")[0]['subscriptions'];
$current_user_subscriptions = explode(",", $current_user_subscriptions);
$current_user = $db -> select('users',"`id`=${current_user_id}")[0];
?>
    <link rel="stylesheet" href="view/styles/user.css">
    <div class="modalShadow" style="display: none"></div>
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
<main>
    <?php if($current_user['role'] == 'admin'): ?>
    <a href="/edit_user.php?id=<?= $user['id'] ?>" class="edit">Изменить</a>
    <?php endif; ?>
    <div class="row">
        <div class="userSchedule">
            <div class="scheduleInfo">
                <p>Месячный прирост</p>
                <div class="underline"></div>
            </div>
            <div class="middleLine"></div>
            <div class="scheduleValues">
                <?php
                    for($i = 0; $i < count($growthValues); $i++):
                ?>
                <div class="dayProfit"><?= $growthValues[$i] ?></div>
                <?php endfor; ?>
            </div>
            <div class="scheduleDays">
                <?php
                    for($i = 0; $i < count($growthDates); $i++):
                ?>
                    <div class="dayInfo"><?= $growthDates[$i] ?></div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="information">
            <div class="scheduleInfo">
                <p>Информация</p>
                <div class="underline"></div>
            </div>
            <div class="informationText">
                <p><?= $user['information'] ?></p>
            </div>
            <?php if($user['id'] != $_SESSION['user']): ?>
                <?php if(array_search($user['id'],$current_user_subscriptions) !== false):?>
                    <a href="includes/subscribe.php?target=<?= $user['id'] ?>&fromUser=<?= $user['id'] ?>"><input type="button" value="отписаться" class="shareJoin shareUnsub"></a>
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
    <div class="row">
        <div class="possibilities">
            <div class="row">
                <div class="possibilityBack">
                    <div class="posBackground"></div>
                    <img src="./view/images/swordsBack.png" alt="" class="backImage">
                    <div class="possibility">
                        <img src="./view/images/swordsFront.png" alt="" class="frontImage">
                        <p class="probTitle"><?= $opportunities[0] ?></p>
                        <span class="probNum"> 01 </span>
                    </div>
                </div>
                <div class="possibilityBack">
                    <div class="posBackground"></div>
                    <img src="./view/images/cupBack.png" alt="" class="backImage">
                    <div class="possibility">
                        <img src="./view/images/cupFront.png" alt="" class="frontImage">
                        <p class="probTitle"><?= $opportunities[1] ?></p>
                        <span class="probNum"> 02 </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="possibilityBack">
                    <div class="posBackground"></div>
                    <img src="./view/images/starBack.png" alt="" class="backImage">
                    <div class="possibility">
                        <img src="./view/images/starFront.png" alt="" class="frontImage">
                        <p class="probTitle"><?= $opportunities[2] ?></p>
                        <span class="probNum"> 03 </span>
                    </div>
                </div>
                <div class="possibilityBack">
                    <div class="posBackground"></div>
                    <img src="./view/images/letterBack.png" alt="" class="backImage">
                    <div class="possibility">
                        <img src="./view/images/letterFront.png" alt="" class="frontImage">
                        <p class="probTitle"><?= $opportunities[3] ?></p>
                        <span class="probNum"> 04 </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="events">
            <div class="scheduleInfo">
                <p>События</p>
                <div class="underline"></div>
            </div>
            <div class="informationText">
                <ul>
                    <?php
                        foreach ($events as $val):
                    ?>
                    <li><?= $val ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="comments">
        <h3>Отзывы:</h3>
        <?php if($_SESSION['user']): ?>
            <form action="/includes/add_comment.php?target_id=<?= $user_id ?>" method="post">
                <textarea class="commentsInput" name="text"></textarea><br>
                <input type="submit" class="commentsSubmit">
            </form>
        <?php endif; ?>
        <?php
            $comments = $db -> select('comments',"`target_id`=${user_id}");
            foreach ($comments as $comment):
                $author = $db -> select('users',"`id`=${comment['author_id']}")[0]['login'];
        ?>
        <div class="comment">
            <?php if($current_user['role'] == 'admin'): ?>
                <a href="includes/delete_comment.php?id=<?= $comment['id'] ?>&user_id=<?= $user_id ?>"><h4 style="color: red">Удалить</h4></a>
            <?php endif; ?>
            <?php if($current_user['role'] == 'admin'): ?>
               <span style="float: right"> <a href="edit_comment.php?comment_id=<?= $comment['id'] ?>" style="color: red">Изменить</a></span>
            <?php endif; ?>
            <p class="commentAuthor"><?= $author ?></p>
            <span class="commentDate"><?= $comment['pub_time'] ?></span>
            <p class="commentText"><?= $comment['text'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<script src="view/js/schedule.js"></script>
    <script>
        let shareSub = document.querySelectorAll('.shareSub');
        let subModalWin = document.querySelector('.subModalWin');
        let modalShadow = document.querySelector('.modalShadow');
        let subscribeModalWin = document.querySelector('.subscribeModalWin');
        let userId = document.querySelectorAll('.userId');
        let sum = document.getElementsByName('sum')[0];
        let balance = document.getElementById('balance').innerHTML;
        console.log(balance)

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
                document.querySelector('.subModalWin').action = 'includes/subscribe.php?target=<?= $user['id'] ?>&fromUser=<?= $user['id'] ?>'
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