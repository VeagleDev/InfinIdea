<<<<<<< HEAD
const interactionContainer = document.getElementsByClassName("interaction-container")[0]

interactionContainer.addEventListener('click', (event) => {
    if(event.target.classList.contains("like") && event.target.classList.contains("fa-regular")) {
        // like
        event.target.classList.add("fa-solid")
        event.target.classList.remove("fa-regular")
    } else if(event.target.classList.contains("like") && event.target.classList.contains("fa-solid")) {
        // delike
        event.target.classList.add("fa-regular")
        event.target.classList.remove("fa-solid")
    }
})

const commentCloseBtn = document.getElementsByClassName("close")[0]
const commentOpenBtn = document.getElementsByClassName("open-comment")[0]


document.getElementsByClassName("comment-section")[0].style.transform = "translateX(100%)"
document.getElementsByClassName("comment-section")[0].style.display = "inline"

commentCloseBtn.addEventListener('click', () => {  
    document.getElementsByClassName("comment-section")[0].style.display = "inline"
    document.getElementsByClassName("comment-section")[0].style.transform = "translateX(100%)"
})

commentOpenBtn.addEventListener('click', () => {
    document.getElementsByClassName("comment-section")[0].style.display = "inline"
    document.getElementsByClassName("comment-section")[0].style.transform = "translateX(0)"
})

=======
const interactionContainer = document.getElementsByClassName("interaction-container")[0]

interactionContainer.addEventListener('click', (event) => {
    if(event.target.classList.contains("like") && event.target.classList.contains("fa-regular")) {
        // like
        event.target.classList.add("fa-solid")
        event.target.classList.remove("fa-regular")
    } else if(event.target.classList.contains("like") && event.target.classList.contains("fa-solid")) {
        // delike
        event.target.classList.add("fa-regular")
        event.target.classList.remove("fa-solid")
    }
})

const commentCloseBtn = document.getElementsByClassName("close")[0]
const commentOpenBtn = document.getElementsByClassName("open-comment")[0]


document.getElementsByClassName("comment-section")[0].style.transform = "translateX(100%)"
document.getElementsByClassName("comment-section")[0].style.display = "inline"

commentCloseBtn.addEventListener('click', () => {  
    document.getElementsByClassName("comment-section")[0].style.display = "inline"
    document.getElementsByClassName("comment-section")[0].style.transform = "translateX(100%)"
})

commentOpenBtn.addEventListener('click', () => {
    document.getElementsByClassName("comment-section")[0].style.display = "inline"
    document.getElementsByClassName("comment-section")[0].style.transform = "translateX(0)"
})

>>>>>>> 5d9bed2 (new)
