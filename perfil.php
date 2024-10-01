<?php
$activeMenu = "Perfil";
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/PostDaoMysql.php");
require_once("./dao/RelationDaoMysql.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();
$id_user = filter_input(INPUT_GET,'id');
$postDao = new PostDaoMysql($config->getConn());
$info_profile = [];
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


require_once("./partials/header.php");
$dateBirthdate = new DateTime($userProfile->getBirthdate());
$birthDate = $dateBirthdate->format("Y");
$currentYear = new DateTime();

$relationDao = new RelationDaoMysql($config->getConn());
$isFollow = $relationDao->findRelation($user, $userProfile);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Perfil</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css" />
</head>
<body>
   <style>
        .btn-follow {
            border: none;
            background-color: #4A76A8;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-follow:hover{
            scale: 102%;
            transition: all;
            transition-duration: .2s;
        }
   </style>
    <section class="container main">
        <?php require_once("./partials/menu.php")?>
        <section class="feed">

            <div class="row">
                <div class="box flex-1 border-top-flat">
                    <div class="box-body">
                        <div class="profile-cover" style="background-image: url('<?=$base?>/media/covers/<?= $userProfile->getCover() ? $userProfile->getCover():"cover.jpg" ?>');"></div>
                        <div class="profile-info m-20 row">
                            <div class="profile-info-avatar">
                                <img src="media/avatars/<?= $userProfile->getAvatar()?>" />
                            </div>
                            <div class="profile-info-name">
                                <div class="profile-info-name-text"><?= $userProfile->getName()?></div>
                                <div class="profile-info-location"><?= $userProfile->getCity()? $userProfile->getCity():"Sem informações"?></div>
                            </div>
                            <div class="profile-info-data row">
                                <?php if($user->getId() !== $userProfile->getId()):?>
                                    <div>
                                        <form action="<?=$base?>/follow_action.php" method="POST">
                                            <input type="hidden" value="<?=$userProfile->getId()?>" name="user_to">
                                            <button class="btn-follow" type="submit">
                                               <?= $isFollow ? "Deixar de seguir":"Seguir"?>
                                            </button>
                                        </form>
                                    </div>
                                <?php endif ?>

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

                <div class="column side pr-5">
                    
                    <div class="box">
                        <div class="box-body">
                            
                            <div class="user-info-mini">
                                <img src="<?=$base?>/assets/images/calendar.png" />
                                <?=$dateBirthdate->format("d/m/Y")?> (<?= $currentYear->format("Y") - $dateBirthdate->format("Y"). " anos"?>)
                            </div>
                            <?php if($userProfile->getCity()):?>
                                <div class="user-info-mini">
                                    <img src="<?=$base?>/assets/images/pin.png" />
                                    <?= $userProfile->getCity()? $userProfile->getCity():"Sem informações"?>, Brasil
                                </div>
                            <?php endif ?> 
                            <?php if($userProfile->getWork()) :?>
                                <div class="user-info-mini">
                                    <img src="<?=$base?>/assets/images/work.png" />
                                    <?= $userProfile->getWork() ?? "Sem informações"?>
                                </div>
                            <?php endif?>

                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?= sizeOf($userProfile->getFollowing()) ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base?>/amigos.php?id=<?=$userProfile->getId()?>">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">
                            
                        <?php foreach($userProfile->getFollowing() as $following):?>
                            <?php require("./partials/friend.php")?>
                        <?php endforeach?>
                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?=$totalPhotos?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base?>/fotos.php?id=<?=$userProfile->getId()?>">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            
                            <?php if(count($listPhotosPosts) > 0): ?>
                                <?php for($index = 0; $index < 4; $index++): ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?=$index + 1?>" rel="modal:open">
                                            <img src="<?=$base?>/media/uploads/<?=$listPhotosPosts[$index]->getBody()?>" />
                                        </a>
                                        <div id="modal-1" style="display:none">
                                            <img src="<?=$base?>/media/uploads/<?=$listPhotosPosts[$index]->getBody()?>" />
                                        </div>
                                    </div>
                                <?php endfor ?>
                            <?php endif?>
                            
                        </div>
                    </div>
                    <?php if(count($postsProfile) > 0):?>
                        <div class="box feed-item">                       
                            <?php foreach($postsProfile as $item):?>
                            <?php require "./partials/feed.php"; ?>
                            <?php endforeach?> 
                        </div>
                    <?php endif?>

                </div>
                
            </div>

        </section>
    </section>
    <?php require_once("./partials/footer.php")?>
    <?php require_once("./partials/feed-btn-script.php")?>

    <script type="text/javascript" src="<?=$base?>/assets/js/vanillaModal.js"></script>

    <script>
        window.onload(() => {
            let modal = new VanillaModal();
        })
    </script>
</body>
</html>