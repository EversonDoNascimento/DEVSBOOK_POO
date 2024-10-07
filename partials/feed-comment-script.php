<style>
    .containerDetails {
        position: relative;
        padding: 5px;
    }
    .contentDetails {
        position: absolute;
        border: 1px solid rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        width: 5rem;
        padding: 5px 15px;
        right: 5px;
        top: 25px;
        color: black;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
    }

    .contentDetails:hover {
        background-color: #4A76A8;
        scale: 102%;
        transition: all;
        transition-duration: 0.4s;
        color: white;
        font-weight: bold;
    }
</style>

<script>

window.addEventListener("load", () => {
    let link = null;
    let img = null;    
    const btnDetailsFeed = document.querySelectorAll(".feed-item-head-btn");
    let isVisible = false;

    // Function to close the window (remove the link)
    function closeWindow(event) {
        const previousLink = document.querySelector(".contentDetails");
        if (previousLink && !previousLink.contains(event.target)) {
            previousLink.parentElement.removeChild(previousLink);
            isVisible = false;
            document.removeEventListener("click", closeWindow);
        }
    }

    // Adding event listeners to each button
    btnDetailsFeed.forEach(item => {
        img = item.querySelector("img");

        img.addEventListener("click", (event) => {
            event.stopPropagation(); // Prevent click from triggering the close
            // Remove the previous click listener to close the window if one exists
            document.removeEventListener("click", closeWindow);

            let id = item.closest(".feed-item").getAttribute("data-id-post");
            let previousLink = document.querySelector(".contentDetails");

            // If there's an existing details box, remove it
            if (previousLink) {
                previousLink.parentElement.removeChild(previousLink);
                isVisible = false;
                return;
            }  

            // If no box is visible, create and show the new one
            if (!isVisible) {
                link = document.createElement("a");
                link.innerText = "Excluir";
                link.classList.add("contentDetails");
                link.href = `<?=$base?>/delete_post_action.php?id=${id}`;
                item.appendChild(link);
                isVisible = true;

                // Add event listener to close the details when clicking outside
                document.addEventListener("click", closeWindow);
            }
        });
    });

document.querySelectorAll(".comment").forEach((item) => {
    item.addEventListener("keyup",async (event) => {
        if (event.key === "Enter" && !event.shiftKey) {  // Verifica se é Enter sem Shift
            event.preventDefault();  // Previne comportamento padrão, como pular linha

            let text = item.value.trim();  // Remove espaços em branco desnecessários
            if (text.length === 0) {
                return;  // Evita enviar comentário vazio
            }

            let id = item.closest(".feed-item").getAttribute("data-id-post");
            let data = new FormData();
            data.append("id", id);
            data.append("body", text);
            let req = await fetch("ajax_comment.php", {
                method: "POST",
                body: data
            })

            let json = await req.json();
            
            if(json.error == ''){
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
        }
    });
});
})

</script>