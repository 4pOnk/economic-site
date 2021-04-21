<?php
include './components/header.php';
$comment_id = $_GET['comment_id'];
$comment = $db -> select('comments',"`id` = ${comment_id}")[0];
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
        <form action="includes/edit_comment.php?id=<?= $comment_id ?>" method="post">
            <p>Дата (YYYY-MM-DD H:M:S):</p>
            <input type="text" name="time" value="<?= $comment['pub_time'] ?>"><br>
            <p>Текст:</p>
            <textarea name="text" id="" cols="30" rows="10"><?= $comment['text'] ?></textarea><br>
            <input type="submit">
        </form>
    </main>
<?php
include './components/footer.php';
?>