var width = document.getElementById("displayed-img").offsetWidth
var height = document.getElementById("displayed-img").offsetHeight

if(width / height <= 1) {
    document.getElementById("displayed-img").style.height = "100%"
    document.getElementById("displayed-img").style.width = "auto"
    console.log("vertical")
} else {
    document.getElementById("displayed-img").style.height = "auto"
    document.getElementById("displayed-img").style.width = "100%"
    console.log("horizontal" + width / height)
}

document.getElementsByClassName("preview-container")[0].addEventListener("click", () => {
    var newWidth = document.getElementById("displayed-img").offsetWidth
    var newHeight = document.getElementById("displayed-img").offsetHeight

    if(newWidth / newHeight <= 1) {
        document.getElementById("displayed-img").style.height = "100%"
        document.getElementById("displayed-img").style.width = "auto"
        
        document.getElementsByClassName("displayed-img")[0].style.height = "450px"
    } else {
        document.getElementById("displayed-img").style.height = "auto"
        document.getElementById("displayed-img").style.width = "100%"

        document.getElementsByClassName("displayed-img")[0].style.height = "450px"
    }
})
