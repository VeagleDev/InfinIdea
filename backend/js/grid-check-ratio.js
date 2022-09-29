document.querySelectorAll(".img-article").forEach((el) => {
    console.log(el.offsetWidth + "width")
    console.log(el.offsetHeight + "height")
    if(el.offsetWidth / el.offsetHeight <= 1) {
        el.style.height = "100%"
        el.style.width = "auto"

    } else {
        el.style.height = "auto"
        el.style.width = "100%"
    }
})