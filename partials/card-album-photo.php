    <div  class="user-photo-item">
        <a href="#modal-<?=$key?>" rel="modal:open">
            <img style="object-fit: cover; width: 200px; height: 200px;"   src="<?=$base?>/media/uploads/<?=$photo->getBody()?>" />
        </a>
        <div id="modal-<?=$key?>" style="display:none">
            <img src="<?=$base?>/media/uploads/<?=$photo->getBody()?>" />
        </div>
    </div>
