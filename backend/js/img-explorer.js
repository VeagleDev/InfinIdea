const container = document.getElementsByClassName("preview-container")[0]

container.addEventListener('click', (event) => {
    const displayedImg = document.getElementById("displayed-img")

    event.target.classList.remove("glow")

    for(var i = 0; i < container.children.length; i++) {
        document.getElementsByClassName("preview")[i].classList.remove("glow")
    }

    if(event.target.classList.contains("preview")) {
        displayedImg.src = event.target.src
        event.target.classList.add("glow")
    }
})
