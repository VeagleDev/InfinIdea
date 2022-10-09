var articleResult = document.getElementsByClassName("article-result")[0];
var elementList = document.getElementsByClassName("element-result-list")[0];

window.onload = () => {
    document.querySelectorAll(".delete-btn").forEach((el) => {
        el.addEventListener("click", () => {
            console.log(el)
            console.log(document.getElementsByClassName("element")[el.parentElement.length])
        })
    })
}