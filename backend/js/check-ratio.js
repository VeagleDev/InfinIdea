var width = document.getElementById("displayed-img").offsetWidth
var height = document.getElementById("displayed-img").offsetHeight

var displayedImg = document.getElementById("displayed-img")
var previewContainer = document.getElementsByClassName("preview-container")[0]

if(width / height <= 1) {
    displayedImg.style.height = "100%"
    displayedImg.style.width = "auto"
    displayedImg.style.marginTop = "0px"
    previewContainer.style.marginTop = "0px"
    
    document.getElementsByClassName("displayed-img")[0].style.height = "450px"
} else {
    displayedImg.style.height = "auto"
    displayedImg.style.width = "100%"
    displayedImg.style.marginTop = "0px"
    previewContainer.style.marginTop = "0px"

    document.getElementsByClassName("displayed-img")[0].style.height = "450px"
}

if(height > document.getElementsByClassName("displayed-img")[0].offsetHeight) {
    displayedImg.style.marginTop = (height - document.getElementsByClassName("displayed-img")[0].offsetHeight) + "px"
    previewContainer.style.marginTop = (height - document.getElementsByClassName("displayed-img")[0].offsetHeight) + "px"
}

document.getElementsByClassName("preview-container")[0].addEventListener("click", () => {
    var newWidth = document.getElementById("displayed-img").offsetWidth
    var newHeight = document.getElementById("displayed-img").offsetHeight
    console.log(document.getElementsByClassName("displayed-img")[0].offsetHeight)
    if(newWidth / newHeight <= 1) {
        displayedImg.style.height = "100%"
        displayedImg.style.width = "auto"
        displayedImg.style.marginTop = "0px"
        previewContainer.style.marginTop = "0px"
        
        document.getElementsByClassName("displayed-img")[0].style.height = "450px"
    } else {
        displayedImg.style.height = "auto"
        displayedImg.style.width = "100%"
        displayedImg.style.marginTop = "0px"
        previewContainer.style.marginTop = "0px"

        document.getElementsByClassName("displayed-img")[0].style.height = "450px"
    }

    if(newHeight > document.getElementsByClassName("displayed-img")[0].offsetHeight) {
        displayedImg.style.marginTop = (newHeight - document.getElementsByClassName("displayed-img")[0].offsetHeight) + "px"
        previewContainer.style.marginTop = (newHeight - document.getElementsByClassName("displayed-img")[0].offsetHeight) + "px"
    }
})
