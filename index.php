<?php
require_once("./config.php");
require_once("./dao/PostDaoMysql.php");
require_once("./models/Auth.php");
require_once("./dao/RelationDaoMysql.php");

$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();
$activeMenu = "Home";
require_once("./partials/header.php");
$postDao = new PostDaoMysql($config->getConn());
$posts = $postDao->getHomePosts($user);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css" />
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
     <?php
        if(!empty($_SESSION['success'])){
            echo "<div class='area'>
                        <div class='successMessage baseMessage'>". $_SESSION['success']."</div>
                    </div>";
            $_SESSION['success'] = "";
        }
    ?>
    <section class="container main">
       <?php require_once("./partials/menu.php")?>
        <section class="feed mt-10">
            
            <div class="row">
                <div class="column pr-5">

                  <?php require_once("./partials/feed-editor.php")?>
                    
                 <?php foreach($posts as $item):?>
                    <?php require("./partials/feed.php")?>
                 <?php endforeach?>
                </div>
                <div class="column side pl-5">
                    <div class="box banners">
                        <div class="box-header">
                            <div class="box-header-text">Patrocinios</div>
                            <div class="box-header-buttons">
                                
                            </div>
                        </div>
                        <div class="box-body">
                            <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                            <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body m-10">
                            Criado com ❤️ por B7Web
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
    <?php require_once("./partials/footer.php")?>
    <?php require_once("./partials/feed-comment-script.php")?>
</body>
</html>
