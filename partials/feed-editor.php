<?php 
$name = current(explode(" ",$user->getName() ))
?>
<style>
    .feed-new-photo {
        cursor: pointer;
        margin-right:5px;
    }
    .feed-new-photo img {
        width:25px;
        height:25px;
    }
    .feed-photo {
        position: absolute;
        left: -500px;
        top: -500px;
    }
</style>

<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?=$base;?>/media/avatars/<?=$user->getAvatar()?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?=$name?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-photo">
                <img src="<?=$base;?>/assets/images/photo.png" />
                <input type="file" name="feed-photo" class="feed-photo" accept="image/png,image/jpeg,image/jpg " />
            </div>
            <div class="feed-new-send">
                <img src="<?=$base;?>/assets/images/send.png" />
            </div>
            <form class="feed-new-form" method="post" action="<?=$base?>/feed_editor_action.php">
                <input type="hidden" name="body">
            </form>
        </div>
    </div>
</div>

<script>
    let elementInput = document.querySelector(".feed-new-input");
    let elementForm = document.querySelector(".feed-new-form");
    let elementSubmit = document.querySelector(".feed-new-send");
    let feedPhoto = document.querySelector(".feed-new-photo")
    let fileInput = document.querySelector(".feed-photo");
    elementSubmit.addEventListener("click", () => {
        let content = elementInput.innerText.trim();
        elementForm.querySelector("input[name='body']").value = content;
        elementForm.submit();
    })
    feedPhoto.addEventListener("click", () => {
        fileInput.click();
    })
    fileInput.addEventListener("change", async () => {
        let photo = fileInput.files[0];
        let formData = new FormData();

        formData.append("photo", photo);
        let req = await fetch("ajax_upload.php", {
            method: "POST",
            body: formData,
        })
        let json = await req.json();

        if(json.error !== ""){
            alert(json.error);
        }

        window.location.href = window.location.href;
    })
</script>