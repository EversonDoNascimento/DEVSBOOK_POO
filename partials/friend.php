<?php
$userTemp = $UserDao->findUserById($following);
?>
 <div class="friend-icon">
    <a href="<?=$base?>/perfil.php?id=<?=$userTemp->getId()?>">
        <div class="friend-icon-avatar">
            <img src="<?=$base?>/media/avatars/<?=$userTemp->getAvatar() ? $userTemp->getAvatar(): "avatar.jpg"?>" />
        </div>
        <div class="friend-icon-name">
            <?=$userTemp->getName()?>
        </div>
    </a>
</div>