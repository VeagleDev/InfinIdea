const input = document.getElementsByClassName('comment-input')[0];
const btn = document.getElementsByClassName('comment-button')[0];


btn.addEventListener('click', postComment);
input.addEventListener('keyup', function (event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        postComment();
    }
});

console.log('post-comment.js event listeners added');
console.log("post-comment.js chargé");


function postComment() {
    console.log('postComment');
    const texte = input.innerHTML;
    // get the id of the post from ?id= in the url
    const url = new URL(window.location.href);
    const id = url.searchParams.get('id');
    // send the comment to the server
    if (texte != "") {

        console.log("Début de la publication du commentaire : ", texte);
        jQuery.ajax({ // On envoie une requête AJAX
            url: "/backend/php/post-comment.php", // On envoie la requête à ce fichier
            data: { // On envoie les données
                comment: texte,
                aid: id
            },
            type: "post", // On envoie les données en POST
            success: function (data) { // Si la requête est un succès
                data = JSON.parse(data);
                if (data.success) { // Si le commentaire a bien été posté
                    console.log("Commentaire posté avec succès");
                    const pseudo = data.pseudo;
                    const html = '<li class="comment">\n' +
                        '<h1 class="username">' + pseudo + '</h1>\n' +
                        '<p class="comment-content">' + texte + '</p>\n' +
                        '<ul class="comment-user-interaction">\n' +
                        '<li>\n' +
                        '<button><i class="fa-regular fa-heart interaction like"></i></button>\n' +
                        '</li>\n' +
                        '<li>\n' +
                        '<button><i class="fa-regular fa-comment interaction"></i></button>\n' +
                        '</li>\n' +
                        '</ul>\n' +
                        '</li>';
                    document.getElementsByClassName('comments')[0].innerHTML += html;
                } else { // Si le commentaire n'a pas été posté
                    alert(data.message);
                }


            },
            error: function (xhr, status) {
                alert("Une erreur est survenue durant l'envoi du commentaire")
            },
        });
    }
}

