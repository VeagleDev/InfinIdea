document.querySelectorAll(".img-article").forEach((el) => { // Pour chaque image
    if (el.offsetWidth / el.offsetHeight <= 1) { // Si la largeur est inférieure à la hauteur
        el.style.height = "100%" // On met la hauteur à 100%
        el.style.width = "auto" // On met la largeur à auto
        console.log("vertical") // On affiche vertical dans la console

    } else {
        el.style.height = "auto" // Sinon on met la hauteur à auto
        el.style.width = "100%" // On met la largeur à 100%
        console.log("horizontal") // On affiche horizontal dans la console
    }
})