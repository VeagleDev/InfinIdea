const container = document.getElementsByClassName("preview-container")[0] // On récupère le conteneur de l'image

var displayedImg = document.getElementById("displayed-img") // On récupère l'image affichée
var previewContainer = document.getElementsByClassName("preview-container")[0] // On récupère le conteneur de l'image

var startImgSelected = document.getElementsByClassName("preview")[0].src // On récupère l'image de départ

displayedImg.src = startImgSelected // On met l'image de départ dans l'image affichée

document.getElementsByClassName("preview")[0].classList.add("glow") // On ajoute la classe glow à l'image de départ

container.addEventListener('click', (event) => { // Quand on clique sur le conteneur
    const displayedImg = document.getElementById("displayed-img") // On récupère l'image affichée

    event.target.classList.remove("glow") // On enlève la classe glow de l'image précédente

    if (event.target.classList.contains("preview")) { // Si l'élément cliqué contient la classe preview
        for (var i = 0; i < container.children.length; i++) { // Pour chaque enfant du conteneur
            document.getElementsByClassName("preview")[i].classList.remove("glow") // On enlève la classe glow de chaque enfant
        }

        if (event.target.classList.contains("preview")) { // Si l'élément cliqué contient la classe preview
            displayedImg.src = event.target.src // On met l'image cliquée dans l'image affichée
            event.target.classList.add("glow") // On ajoute la classe glow à l'image cliquée
        }
    }
)