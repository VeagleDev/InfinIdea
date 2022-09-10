const container = document.getElementsByClassName("preview-container")[0]

container.addEventListener('click', (event) => {
    const displayedImg = document.getElementById("displayed-img")

    if(event.target.classList.contains("preview"))
    displayedImg.src = event.target.src
})
