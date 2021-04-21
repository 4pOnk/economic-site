<?php
include './components/header.php';
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
            margin-top: 90px;
        }
    </style>
    <main>
        <form action="includes/edit_comment.php?id=<?= $comment_id ?>" method="post">
            <?php
                $users = $db -> select('users','1');
                foreach ($users as $user):
            ?>
                <p><?= $user['login'] ?>:<a href="/user.php?id=<?= $user['id'] ?>">Внешняя страница</a> | <a href="/cabinet.php?user_id=<?= $user['id'] ?>">Личный кабинет</a></p>
            <?php endforeach; ?>
        </form>
    </main>
<?php
include './components/footer.php';
?>