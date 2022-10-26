// eventlistener to click event on the submit button

document.getElementsByClassName("submit")[0].addEventListener('click', () => {
    const title = document.getElementsByClassName("title")[0].value
    const description = document.getElementsByClassName("description")[0].value
    const content = document.getElementsByClassName("content")[0].value
    const tags = document.getElementsByClassName("tags")[0].value

    const title_regex = /^.{4,50}$/
    const description_regex = /^.{4,200}$/
    const content_regex = /^.{30,10000}$/
    const tags_regex = /^[a-zA-Z0-9_-,\[\]]{0,1000}$/

    if (!title_regex.test(title)) {
        // title is not valid
    }
    if (!description_regex.test(description)) {
        // description is not valid
    }
    if (!content_regex.test(content)) {
        // content is not valid
    }
    if (!tags_regex.test(tags)) {
        // tags are not valid
    }

})