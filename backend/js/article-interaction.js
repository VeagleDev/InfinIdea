const interactionContainer = document.getElementsByClassName("interaction-container")[0]
const interactionCommentContainer = document.getElementsByClassName("interaction-container")[1]

interactionContainer.addEventListener('click', (event) => {
    if(event.target.classList.contains("like") && event.target.classList.contains("fa-regular")) {
        event.target.classList.add("fa-solid")
        event.target.classList.remove("fa-regular")
    } else if(event.target.classList.contains("like") && event.target.classList.contains("fa-solid")) {
        event.target.classList.add("fa-regular")
        event.target.classList.remove("fa-solid")
    }
})