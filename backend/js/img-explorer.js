const container = document.getElementsByClassName("preview-container")[0]
document.getElementsByClassName("preview")[0].style.border = "#000 2px solid"

container.addEventListener('click', (event) => {
    const displayedImg = document.getElementById("displayed-img")

    if(event.target.classList.contains("preview") && event.target.src != displayedImg.src) {
        displayedImg.src = event.target.src
        event.target.classList.add("glow")
    }
})

document.g
