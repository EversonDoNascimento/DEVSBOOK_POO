<?php
$action_type = "";
$linkProfile = '?id='.$item->getIdUser();
switch($item->getType()){
    case("text"):
        $action_type = "Fez um post";
        break;
    case("photo"):
        $action_type = "Postou uma foto";
    default:
        break;
}
require_once("./partials/feed-item-script.php");

?>

<div data-id-post="<?=$item->getId()?>" class="box feed-item">
    <div class="box-body">
       
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?=$base?>/perfil.php<?=$linkProfile?>"><img src="<?=$base;?>/media/avatars/<?=$item->getUser()->getAvatar()?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?=$base?>/perfil.php<?=$linkProfile?>"><span class="fidi-name"><?=$item->getUser()->getName()?></span></a>
                <span class="fidi-action"><?=$action_type?></span>
                <br/>
                <span class="fidi-date"><?=$item->getCreated_at()->format("d/m/Y")?></span>
            </div>
            <div class="feed-item-head-btn">
                <img src="<?=$base;?>/assets/images/more.png" />
            </div>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?php if($item->getType() === "photo"):?>
                <img src="<?=$base?>/media/uploads/<?=$item->getBody()?>"></img>
            <?php endif?>
            <?php if($item->getType()  === "text"):?>
                <?=nl2br($item->getBody())?>
            <?php endif?>
        
        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div  class="like-btn <?= $item->getLiked()? "on":"" ?>"><?=$item->getLikeCount()?>
            </div>
            <div class="msg-btn"><?= sizeof($item->getComments())?></div>
        </div>
        <div class="feed-item-comments">
            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href=""><img src="<?=$base;?>/media/avatars/<?= $user->getAvatar()?>" /></a>
                </div> 
                <input  type="text" name="body" class="comment fic-item-field" placeholder="Escreva um comentário" />
            </div>
            <?php if(sizeof($item->getComments()) > 0):?>
                <?php foreach($item->getComments() as $c):?>
                    <div class="fic-item row m-height-10 m-width-20">
                        <div class="fic-item-photo">
                            <a href=""><img src="<?=$base;?>/media/avatars/<?=$c->getUser()->getAvatar()?>" /></a>
                        </div>
                        <div class="fic-item-info">
                            <a href="<?=$base?>/perfil.php?id=<?=$c->getUser()->getId()?>"><?=$c->getUser()->getName()?></a>
                            <?=$c->getBody()?>
                        </div>
                    </div>
                <?php endforeach?>
            <?php endif ?>
            

        </div>
    </div>
</div>

