const button = document.getElementById('submit');


button.addEventListener("click", function () {
    button.innerHTML = "<div class='lds-dual-ring'></div>";
    button.style.padding = "5px";
    button.style.minWidth = "40px";
    button.style.minHeight = "40px";


    const title = document.getElementsByClassName("title")[0].value
    const description = document.getElementsByClassName("description")[0].value
    const content = document.getElementsByClassName("content")[0].value
    const tags = document.getElementsByClassName("tags")[0].value

    const title_regex = /^.{4,50}$/
    const description_regex = /^.{4,200}$/
    const content_regex = /^[\s\S]{30,10000}$/
    const tags_regex = /^.{0,1000}$/

    let legit = true;

    if (!title_regex.test(title)) {
        document.getElementsByClassName("title-error")[0].style.display = "block"
        legit = false;
        button.innerHTML = "Publier"
        button.style.padding = "0.5em"
    } else {
        document.getElementsByClassName("title-error")[0].style.display = "none"
    }
    if (!description_regex.test(description)) {
        document.getElementsByClassName("description-error")[0].style.display = "block"
        legit = false;
        button.innerHTML = "Publier"
        button.style.padding = "0.5em"
    } else {
        document.getElementsByClassName("description-error")[0].style.display = "none"
    }
    if (!content_regex.test(content)) {
        document.getElementsByClassName("content-error")[0].style.display = "block"
        legit = false;
        button.innerHTML = "Publier"
        button.style.padding = "0.5em"
    } else {
        document.getElementsByClassName("content-error")[0].style.display = "none"
    }
    if (!tags_regex.test(tags)) {
        document.getElementsByClassName("tags-error")[0].style.display = "block"
        legit = false;
        button.innerHTML = "Publier"
        button.style.padding = "0.5em"
    } else {
        document.getElementsByClassName("tags-error")[0].style.display = "none"
    }

    if (legit) {
        jQuery.ajax({
            url: '/backend/php/publish-article.php',
            type: 'POST',
            data: {
                title: title,
                description: description,
                content: content,
                tags: tags
            },
            success: function (data) {
                code = data;
                if (code.startsWith("https://")) {
                    const success = document.getElementsByClassName("success")[0]
                    const link = document.getElementsByClassName("link-article")[0]
                    button.style.color = "green"
                    button.innerHTML = "Publié"
                    button.style.padding = "0.5em"

                    button.enabled = false;
                    success.style.display = "block"
                    link.href = code
                } else {
                    button.innerHTML = "Publier"
                    button.style.padding = "0.5em"
                    switch (code) {
                        case "2":
                            alert("Erreur lors de la publication de l'article")
                            break;
                        case "3":
                            alert("Les données envoyées n\'ont pas pu être associées à un article")
                            break;
                        case "1":
                            alert("Les données envoyées ne sont pas valides")
                            break;
                        case "4":
                            alert("Un article avec le même titre existe déjà")
                            break;

                        default:
                            alert("Erreur inconnue")
                            break;

                    }

                }

            },
            error: function () {
                alert("Erreur durant la publication de l'article")
                button.innerHTML = "Publier"
                button.style.padding = "0.5em"
                button.style.backgroundColor = "red"
                button.enabled = true;
            }
        })
        return true;

    } else {
        return false;
    }


});

