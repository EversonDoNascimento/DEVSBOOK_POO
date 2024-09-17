<style>
    .search-card-container {
    display: flex;
    gap: 10px;
    
    align-items: center;
    margin-bottom: 5px;
    padding: 15px;
    width: 100%;
    cursor: pointer;
    border-bottom: 2px solid #DCDDDE;
  
    }

    .search-card-container:hover{
        scale: 102%;
        transition: all;
        transition-duration: .2s;
    }
    .image-avatar {
       width: 60px;
       height: 60px;
       object-fit: cover;
       border-radius: 100%;
    }
    .container-image {
       width: 60px;
       height: 60px;
    }
   .user-card-name{
    font-weight: bold;
    font-size: 13px;
   }
    .user-card-email{
    font-weight: bold;
    color: #4A76A8;
    font-size: 11px;
   }
</style>

<form  method="GET" action="<?=$base?>/perfil.php" class="search-card-container">  
    <input type="hidden"  name="id" value="<?=$value->getId()?>"/>    
    <div class="container-image">
        <img class="image-avatar" src="<?=$base?>/media/avatars/avatar.jpg" >
    </div>
    <div>
        <p class="user-card-name"><?=$value->getName()?></p>
        <p class="user-card-email"><?=$value->getEmail()?></p>
    </div>
</form>
