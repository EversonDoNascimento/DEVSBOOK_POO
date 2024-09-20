//Controlador para remover a tag do elemento da messagem de erro

const area = document.querySelector(".area");
if(area){
    const message = document.querySelector(".baseMessage");
    setTimeout(()=> area.removeChild(message),4900)

}