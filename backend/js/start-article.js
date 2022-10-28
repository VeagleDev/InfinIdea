
window.onload = () => {
    document.querySelectorAll("pre").forEach((el) => {
        el.classList.add("prettyprint")
    })
    PR.prettyPrint();
}