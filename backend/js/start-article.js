/*document.onload = () => {

    // select all pre elements and add the prettyprint class without ajax
    document.querySelectorAll("pre").forEach((el) => {
        el.classList.add("prettyprint")
    })
    document.querySelectorAll("code").forEach((el) => {
        el.classList.add("prettyprint")
    })

    PR.prettyPrint();
}*/

window.onload = () => {
    document.querySelectorAll("pre").forEach((el) => {
        el.classList.add("prettyprint")
    })
    PR.prettyPrint();
}