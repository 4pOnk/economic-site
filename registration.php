<?php
include './components/header.php';
session_start();
?>
    <link rel="stylesheet" href="view/styles/registration.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<main>
    <div class="testbox">
        <h1>Registration</h1>

        <form action="/includes/registration.php" method="post" enctype="multipart/form-data">
            <hr>
            <label id="icon" for="name"><i class="icon-envelope "></i></label>
            <input type="text" name="email" id="name" placeholder="Email" required/>
            <label id="icon" for="name"><i class="icon-user"></i></label>
            <input type="text" name="name" id="name" placeholder="Имя" required/>
            <label id="icon" for="name"><i class="icon-shield"></i></label>
            <input type="password" name="password" id="name" placeholder="Пароль" required/>
            <div class="example-2">
                <div class="form-group">
                    <input type="file" name="file" id="file" class="input-file">
                    <label for="file" class="btn btn-tertiary js-labelFile">
                        <i class="icon fa fa-check"></i>
                        <span class="js-fileName">Загрузить Аватар</span>
                    </label>
                </div>
            </div>
            <p>By clicking Register, you agree on our <a href="#">terms and condition</a>.</p>
            <input type="submit" class="button" value="register">
        </form>
    </div>
</main>
    <script>
        let message = '<?= $_SESSION['reg_message'] ?>';
        if(message.length > 0) {
            alert(message);
            <?php unset($_SESSION['reg_message'])?>
        }
    </script>
<?php
include './components/footer.php';
?>