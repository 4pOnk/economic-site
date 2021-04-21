<?php
include './components/header.php';
$user_id = $_GET['id'];
$user = $db -> select('users',"`id` = ${user_id}")[0];
$opportunities = explode(",",$user['opportunities']);
?>
    <style>
        main{
            position: relative;
        }
        input,textarea{
            color: black;
        }
        .eventsPlus{
            font-size: 35px;
            cursor: pointer;
        }
        p{
            margin-top: 20px;
        }
        .submit{
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
    <form action="includes/edit_user.php?id=<?= $user_id ?>" method="post">
        <p>Имя:</p>
        <input type="text" name="name" value="<?= $user['login'] ?>"><br>
        <p>Показывать на главной странице <input type="checkbox" name="simp" <?php if($user['show_in_main_page'] == 1)echo 'checked'?>></p>
        <p>Прирост за 7 дней в процентах:</p>
        <input type="text" name="week" value="<?= $user['accretionPerWeek'] ?>"><br>
        <p>Прирост за месяц в процентах:</p>
        <input type="text" name="month" value="<?= $user['accretionPerMonth'] ?>"><br>
        <p>Баланс:</p>
        <input type="text" name="balance" value="<?= $user['balance'] ?>"><br>
        <p>Риск:</p>
        <input type="text" name="risk" value="<?= $user['risk'] ?>"><br>
        <p>Подписчики:</p>
        <input type="text" value="<?= $user['subscribers'] ?>"><br>
        <p>Данные графика(Вводить значения от -100 до 100 через заятую):</p>
        <textarea name="graph_vals" id="" cols="30" rows="3"><?= $user['growth'] ?></textarea><br>
        <p>Дни для данных графика(Столько же сколько и данных, вводить через запятую):</p>
        <textarea name="graph_dates" id="" cols="30" rows="3"><?= $user['growth_dates'] ?></textarea><br>
        <p>Информация:</p>
        <textarea name="info" id="" cols="30" rows="10"><?= $user['information'] ?></textarea><br>
        <div class="events">
            <div class="pos">
                <p>События:</p>
                <span>Ссылка</span>
                <input type="text" name="eventHref[]">
                <span>Текст ссылки</span>
                <input type="text" name="eventName[]"><br>
            </div>
        </div>
        <div class="eventsPlus">+</div>
        <p>Возможности:</p>
        <span>1)</span><input name="opportunities[]" type="text" value="<?= $opportunities[0] ?>"><br>
        <span>2)</span><input name="opportunities[]" type="text" value="<?= $opportunities[1] ?>"><br>
        <span>3)</span><input name="opportunities[]" type="text" value="<?= $opportunities[2] ?>"><br>
        <span>4)</span><input name="opportunities[]" type="text" value="<?= $opportunities[3] ?>"><br>
        <br><br><br>
        <input type="submit" value="Отправить" class="submit">
    </form>
</main>
    <script>
        let eventInputs = `<span>Ссылка</span>
        <input type="text" name="eventHref[]">
        <span>Текст ссылки</span>
        <input type="text" name="eventName[]"><br>`;
        let eventsBlock = document.querySelector('.events');
        let plusBtn = document.querySelector('.eventsPlus');
        plusBtn.addEventListener('click',() => {
            let pos = document.createElement('div');
            pos.innerHTML = eventInputs;
            eventsBlock.append(pos);
        })
    </script>
<?php
include './components/footer.php';
?>