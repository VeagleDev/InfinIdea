const interactionContainer = document.getElementsByClassName("interaction-container")[0]

interactionContainer.addEventListener('click', (event) => {
    if(event.target.classList.contains("like") && event.target.classList.contains("fa-regular")) {
        event.target.classList.add("fa-solid")
        event.target.classList.remove("fa-regular")
    } else if(event.target.classList.contains("like") && event.target.classList.contains("fa-solid")) {
        event.target.classList.add("fa-regular")
        event.target.classList.remove("fa-solid")
    }
})

const commentCloseBtn = document.getElementsByClassName("close")[0]
const commentOpenBtn = document.getElementsByClassName("open-comment")[0]

commentCloseBtn.addEventListener('click', () => {
    document.getElementsByClassName("comment-section")[0].style.transform = "scaleX(0)"
})

commentOpenBtn.addEventListener('click', () => {
    document.getElementsByClassName("comment-section")[0].style.transform = "scaleX(100%)"
})

