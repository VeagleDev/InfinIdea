const container = document.getElementsByClassName("preview-container")[0]

var displayedImg = document.getElementById("displayed-img")
var previewContainer = document.getElementsByClassName("preview-container")[0]

var startImgSelected = document.getElementsByClassName("preview")[0].src

displayedImg.src = startImgSelected

document.getElementsByClassName("preview")[0].classList.add("glow")

container.addEventListener('click', (event) => {
    const displayedImg = document.getElementById("displayed-img")

    event.target.classList.remove("glow")

    if(event.target.classList.contains("preview"))
    for (var i = 0; i < container.children.length; i++) {
        document.getElementsByClassName("preview")[i].classList.remove("glow")
    }

    if (event.target.classList.contains("preview")) {
        displayedImg.src = event.target.src
        event.target.classList.add("glow")
    }
})