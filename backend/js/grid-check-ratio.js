document.querySelectorAll(".img-article").forEach((el) => {
    if(el.offsetWidth / el.offsetHeight <= 1) {
        el.style.height = "100%"
        el.style.width = "auto"
        console.log("vertical")

    } else {
        el.style.height = "auto"
        el.style.width = "100%"
        console.log("horizontal")
    }
})