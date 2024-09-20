<?php
require("./config.php")
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css" />
    <link rel="stylesheet" href="<?=$base;?>/style.css" />

</head>
<body>

    <?php
        if(!empty($_SESSION['error'])){
            echo "<div class='area'>
                        <div class='errorMessage baseMessage'>". $_SESSION['error']."</div>
                    </div>";
            $_SESSION['error'] = "";
        }
    ?>
   
    <header>
        <div class="container">
            <a href="<?=$base?>"><img src="<?=$base;?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="<?=$base;?>/login_action.php">
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" />

            <input class="button" type="submit" value="Acessar o sistema" />

            <a href="<?= $base;?>/signup.php">Ainda não tem conta? Cadastre-se</a>
        </form>
    </section>
    
    <script src="ElementsController.js"></script>
</body>
</html>