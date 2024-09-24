
<script>

document.querySelectorAll(".comment").forEach((item) => {
    item.addEventListener("keyup", (event) => {
        if (event.key === "Enter" && !event.shiftKey) {  // Verifica se é Enter sem Shift
            event.preventDefault();  // Previne comportamento padrão, como pular linha

            let text = item.value.trim();  // Remove espaços em branco desnecessários
            if (text.length === 0) {
                return;  // Evita enviar comentário vazio
            }

            let id = item.closest(".feed-item").getAttribute("data-id-post");

            fetch(`<?=$base?>/ajax_comment.php?id=${id}&&body=${text}`)
            let containerCommentElement = item.closest(".feed-item").querySelector(".feed-item-comments");
            const newDiv = document.createElement("div");
            newDiv.innerHTML =  `
                <div class="fic-item row m-height-10 m-width-20">
                    <div class="fic-item-photo">
                        <a href=""><img src="<?=$base;?>/media/avatars/<?=$c->getUser()->getAvatar()?>" /></a>
                    </div>
                    <div class="fic-item-info">
                        <a href="<?=$base?>/perfil.php?id=<?=$c->getUser()->getId()?>"><?=$c->getUser()->getName()?></a>
                        ${text}
                    </div>
                </div>
            `;
            containerCommentElement.appendChild(newDiv);
            item.value = "";
        }
    });
});

</script>