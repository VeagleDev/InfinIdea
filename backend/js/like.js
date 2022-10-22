// A refaire en AJAX
const LikeMachine = new XMLHttpRequest(); // On créé un objet XMLHttpRequest
aid = 0; // On déclare la variable aid

function performLike(id) { // On créé la fonction performLike
    aid = id; // On assigne la valeur de id à aid
    const url = "https://infinidea.veagle.fr/backend/php/add-like.php?article=" + aid; // On créé l'url
    console.log("[INFO] Sending like request to " + url); // On affiche l'url dans la console
    LikeMachine.open("GET", url); // On ouvre la requête
    LikeMachine.send(); // On envoie la requête


}

LikeMachine.onreadystatechange = function () { // On créé un écouteur d'évènement
    if (this.readyState == 4 && this.status == 200) { // Si la requête est terminée et que le serveur a répondu
        const response = this.responseText; // On récupère la réponse du serveur
        console.log("[INFO] Like request response received"); // On affiche un message dans la console

    }
}