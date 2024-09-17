<?php 
$name = current(explode(" ",$user->getName() ))
?>
<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?=$base;?>/media/avatars/<?=$user->getAvatar()?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?=$name?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
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
    elementSubmit.addEventListener("click", () => {
        let content = elementInput.innerText.trim();
        elementForm.querySelector("input[name='body']").value = content;
        elementForm.submit();
    })
</script>