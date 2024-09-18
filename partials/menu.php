<?php 

require_once("./config.php");

?>
<aside class="mt-10">
<nav>
    <a href="<?=$base?>/">
        <div class="menu-item <?= $activeMenu == "Home" ? 'active': ''?>">
            <div class="menu-item-icon">
                <img src="<?=$base;?>/assets/images/home-run.png" width="16" height="16" />
            </div>
            <div class="menu-item-text">
                Home
            </div>
        </div>
    </a>
    <a href="<?=$base?>/perfil.php?id=<?=$user->getId()?>">
        <div class="menu-item <?= $activeMenu  == "Perfil" && $id_user == $user->getId() ? 'active': ''?>">
            <div class="menu-item-icon">
                <img src="<?=$base;?>/assets/images/user.png" width="16" height="16" />
            </div>
            <div class="menu-item-text">
                Meu Perfil
            </div>
        </div>
    </a>
    <a href="<?=$base?>/amigos.php?id=<?= $user->getId()?>" >
        <div class="menu-item <?= $activeMenu  == "Amigos" && $id_user == $user->getId() ? 'active': ''?>">
            <div class="menu-item-icon">
                <img src="<?=$base;?>/assets/images/friends.png" width="16" height="16" />
            </div>
            <div class="menu-item-text">
                Amigos
            </div>
            <div class="menu-item-badge">
                0
            </div>
        </div>
    </a>
    <a href="<?=$base?>/fotos.php?id=<?=$user->getId()?>" >
        <div class="menu-item <?= $activeMenu  == "Fotos" && $id_user == $user->getId() ? 'active': ''?>">
            <div class="menu-item-icon">
                <img src="<?=$base;?>/assets/images/photo.png" width="16" height="16" />
            </div>
            <div class="menu-item-text">
                Fotos
            </div>
        </div>
    </a>
    <div class="menu-splitter"></div>
    <a href="<?=$base?>/configuracoes.php" >
        <div class="menu-item <?= $activeMenu == "Config" ? 'active': ''?>">
            <div class="menu-item-icon">
                <img src="<?=$base;?>/assets/images/settings.png" width="16" height="16" />
            </div>
            <div class="menu-item-text">
                Configurações
            </div>
        </div>
    </a>
    <a href="<?=$base?>/logout.php" >
        <div class="menu-item">
            <div class="menu-item-icon">
                <img src="<?=$base;?>/assets/images/power.png" width="16" height="16" />
            </div>
            <div class="menu-item-text">
                Sair
            </div>
        </div>
    </a>
</nav>
</aside>