<?php 
require_once("./config.php");
 ?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css" />
        <link rel="stylesheet" href="<?=$base;?>/style.css" />

</head>
<body>
<header>
        <div class="container">
            <div class="logo">
                <a href="<?=$base?>/"><img src="<?=$base?>/assets/images/devsbook_logo.png" /></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?=$base?>/search.php">
                            <input type="search" placeholder="Pesquisar" name="s" />
                        </form>
                    </div>
                </div>
                <div class="head-side-right">
                    <a href="<?=$base?>/perfil.php?id=<?=$user->getId()?>" class="user-area">
                        <div class="user-area-text"><?=$user->getName()?></div>
                        <div class="user-area-icon">
                            <img src="<?=$base?>/media/avatars/<?=$user->getAvatar()?>" />
                        </div>
                    </a>
                    <a href="<?=$base?>/logout.php" class="user-logout">
                        <img src="<?=$base?>/assets/images/power_white.png" />
                    </a>
                </div>
        </div>
    </div>
</header>