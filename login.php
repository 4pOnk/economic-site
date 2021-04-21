<?php
include './components/header.php';
?>
    <link rel="stylesheet" href="view/styles/registration.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<main class="login">
    <div class="testbox">
        <h1>Login</h1>

        <form action="includes/login.php" method="post">
            <hr>
            <label id="icon" for="name"><i class="icon-user"></i></label>
            <input type="text" name="name" id="name" placeholder="Name" required/>
            <label id="icon" for="name"><i class="icon-shield"></i></label>
            <input type="password" name="password" id="name" placeholder="Password" required/>
            <input type="submit" class="button" value="login">
            <p class="noAcc">Нет аккаунта?<a href="/registration.php"> Зарегистрироваться</a></p>
        </form>
    </div>
</main>
    <script>
        let message = '<?= $_SESSION['log_message'] ?>';
        if(message.length > 0) {
            alert(message);
            <?php unset($_SESSION['log_message'])?>
        }
    </script>
<?php
include './components/footer.php';
?>