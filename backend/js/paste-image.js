/*
    Cette fonction permet de récupérer les images du presse-papier
 */

function retrieveImageFromClipboardAsBase64(pasteEvent, callback, imageFormat) {
    if (pasteEvent.clipboardData == false) { // Si le presse-papier est vide
        if (typeof (callback) == "function") { // Si la fonction de callback est une fonction
            callback(undefined); // On appelle la fonction de callback
        }
    }
    var items = pasteEvent.clipboardData.items; // On récupère les données du presse-papier
    if (items == undefined) { // Si les données sont vides
        if (typeof (callback) == "function") { // Si la fonction de callback est une fonction
            callback(undefined); // On appelle la fonction de callback
        }
    }
    for (var i = 0; i < items.length; i++) { // Pour chaque donnée
        if (items[i].type.indexOf("image") == -1) continue; // Si ce n'est pas une image, on passe à la suivante
        var blob = items[i].getAsFile(); // On récupère l'image
        var mycanvas = document.createElement("canvas"); // On crée un canvas
        var ctx = mycanvas.getContext('2d'); // On récupère le contexte du canvas
        var img = new Image(); // On crée une image
        img.onload = function () { // Quand l'image est chargée
            mycanvas.width = this.width; // On définit la largeur du canvas
            mycanvas.height = this.height; // On définit la hauteur du canvas
            ctx.drawImage(img, 0, 0); // On dessine l'image dans le canvas
            if (typeof (callback) == "function") { // Si la fonction de callback est une fonction
                callback(mycanvas.toDataURL( // On appelle la fonction de callback
                    (imageFormat || "image/png") // On définit le format de l'image
                ));
            }
        };
        var URLObj = window.URL || window.webkitURL; // On récupère l'URL
        img.src = URLObj.createObjectURL(blob); // On définit l'URL de l'image
    }
}


window.addEventListener("paste", function (e) { // Quand on colle une image
    retrieveImageFromClipboardAsBase64(e, function (imageDataBase64) { // On récupère l'image du presse-papier
        if (imageDataBase64) { // Si on a une image
            sendImageToServer(imageDataBase64); // On envoie l'image au serveur
        }
    });
}, false);



// create a function which send the base64 image to the server
function sendImageToServer(imageDataBase64) { // On envoie l'image au serveur
    const aid = document.getElementById('article-id').value; // On récupère l'id de l'article
    jQuery.ajax({ // On envoie l'image au serveur avec AJAX
        url: "/backend/php/upload-image.php",  // On envoie l'image au serveur
        data: { // On envoie les données
            article: aid, // L'id de l'article
            image: imageDataBase64 // L'image
        },
        type: "post", // On envoie les données en POST
        success: function (data) { // Si le serveur a répondu
            const doc = document.getElementById("content"); // On récupère le contenu de l'article
            const text = data; // On récupère le texte
            const cursorPos = doc.selectionStart; // On récupère la position du curseur
            const v = doc.value; // On récupère le contenu de l'article
            const textBefore = v.substring(0, cursorPos); // On récupère le texte avant le curseur
            const textAfter = v.substring(cursorPos, v.length); // On récupère le texte après le curseur
            doc.value = textBefore + text + textAfter; // On ajoute le texte

            console.log(data); // On affiche le texte dans la console

        },
        error: function (xhr, status) { // Si le serveur n'a pas répondu
            alert("Erreur durant l'envoi de l'image"); // On affiche un message d'erreur
        },
        complete: function (xhr, status) {
        }
    });
}