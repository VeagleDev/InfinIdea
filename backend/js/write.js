// eventlistener to click event on the submit button
console.log('salut');

document.onload = function () {
    document.getElementsByClassName("submit")[0].addEventListener('click', () => {
        console.log('bouton cliqué');
        const title = document.getElementsByClassName("title")[0].value
        const description = document.getElementsByClassName("description")[0].value
        const content = document.getElementsByClassName("content")[0].value
        const tags = document.getElementsByClassName("tags")[0].value

        const title_regex = /^.{4,50}$/
        const description_regex = /^.{4,200}$/
        const content_regex = /^.{30,10000}$/
        const tags_regex = /^.{0,1000}$/

        let legit = true;

        if (!title_regex.test(title)) {
            // display error message
            document.getElementsByClassName("title-error")[0].style.display = "block"
            legit = false;
        } else {
            document.getElementsByClassName("title-error")[0].style.display = "none"
        }
        if (!description_regex.test(description)) {
            document.getElementsByClassName("description-error")[0].style.display = "block"
            legit = false;
        } else {
            document.getElementsByClassName("description-error")[0].style.display = "none"
        }
        if (!content_regex.test(content)) {
            document.getElementsByClassName("content-error")[0].style.display = "block"
            legit = false;
        } else {
            document.getElementsByClassName("content-error")[0].style.display = "none"
        }
        if (!tags_regex.test(tags)) {
            document.getElementsByClassName("tags-error")[0].style.display = "block"
            legit = false;
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
                    alert('Yes')
                },
                error: function (data) {
                    alert('No')
                }
            });
            return true;

        } else {
            alert('Not legit')
            return false;
        }


    })
}
