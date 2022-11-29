const button = document.getElementsByClassName('comment-input')[0];
const commentaire = document.getElementsByClassName('comment-button')[0];
const texte = commentaire.innerHTML;

button.addEventListener('click', function() {
    if(texte != "")
    {
        
        console.log("Début de la publication du commentaire : ", texte);
        jQuery.ajax({ // On envoie une requête AJAX
            url: "/backend/php/post-comment.php", // On envoie la requête à ce fichier
            data: { // On envoie les données
                comment: texte, // On envoie l'email
            },
            type: "post", // On envoie les données en POST
            success: function (data) { // Si la requête est un succès
                
            },
            error: function (xhr, status) {
                alert("Une erreur est survenue durant l'envoi du commentaire")
            },
        });
    }

});