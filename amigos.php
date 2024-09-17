<?php
$activeMenu = "Amigos";
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/PostDaoMysql.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$postDao = new PostDaoMysql($config->getConn());
$user = $auth->checkToken();
$id_user = filter_input(INPUT_GET,'id');
$userProfile = new User();
$UserDao = new UserDaoMysql($config->getConn());
if($id_user){  
    $getUser = $UserDao->findUserById($id_user, true);
    if(!$getUser){
        header("Location: $base");
        exit;
    }
    $userProfile = $getUser;
}

$postsProfile = $postDao->findPostByUserId($userProfile->getId());
$listPhotosPosts = $postDao->getPhotosUser($userProfile);
$totalPhotos = 0;
if($postsProfile > 0){
    foreach($postsProfile as $photo){
        if($photo->getType() === "photo"){
            $totalPhotos += 1;
        }
    } 
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <?php require("./partials/header.php")?>
    <section class="container main">
        <?php require("./partials/menu.php")?>
       
        <section class="feed">

            <div class="row">
                <div class="box flex-1 border-top-flat">
                    <div class="box-body">
                        <div class="profile-cover" style="background-image: url('media/covers/cover.jpg');"></div>
                        <div class="profile-info m-20 row">
                            <div class="profile-info-avatar">
                                <a href=""><img src="media/avatars/avatar.jpg" /></a>
                            </div>
                            <div class="profile-info-name">
                                <div class="profile-info-name-text"><a href="<?= $base?>/perfil.php?id=<?= $userProfile->getId()?>"><?= $userProfile->getName() ?></a></div>
                                <div class="profile-info-location"><?= $userProfile->getCity() ? $userProfile->getCity(): "Sem informações" ?></div>
                            </div>
                            <div class="profile-info-data row">
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?= sizeof($userProfile->getFollowers()) ?></div>
                                    <div class="profile-info-item-s">Seguidores</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?= sizeOf($userProfile->getFollowing()) ?></div>
                                    <div class="profile-info-item-s">Seguindo</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=$totalPhotos?></div>
                                    <div class="profile-info-item-s">Fotos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">

                <div class="column">
                    
                    <div class="box">
                        <div class="box-body">

                            <div class="tabs">
                                <div class="tab-item" data-for="followers">
                                    Seguidores
                                </div>
                                <div class="tab-item active" data-for="following">
                                    Seguindo
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-body" data-item="followers">
                                    
                                    <div class="full-friend-list">
                                        <?php if(count($userProfile->getFollowers()) > 0): ?>
                                            <?php foreach($userProfile->getFollowers() as $following): ?>
                                                <?php require("./partials/friend.php") ?>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>

                                </div>
                                <div class="tab-body" data-item="following">
                                    
                                    <div class="full-friend-list">
                                        <?php if(count($userProfile->getFollowing()) > 0): ?>
                                            <?php foreach($userProfile->getFollowing() as $following):?>
                                                <?php require("./partials/friend.php")?>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                                                                                  
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                
            </div>

        </section>
    </section>
    <div class="modal">
        <div class="modal-inner">
            <a rel="modal:close">&times;</a>
            <div class="modal-content"></div>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/script.js"></script>
    <script type="text/javascript" src="assets/js/vanillaModal.js"></script>
</body>
</html>