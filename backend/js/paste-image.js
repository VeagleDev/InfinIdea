/**
 * This handler retrieves the images from the clipboard as a base64 string and returns it in a callback.
 *
 * @param pasteEvent
 * @param callback
 * @param {Event} pasteEvent
 * @param {*} callback
 * @param {string|string} imageFormat
 */


/*
    Cette fonction permet de récupérer les images du presse-papier
 */
function retrieveImageFromClipboardAsBase64(pasteEvent, callback, imageFormat) {
    if (pasteEvent.clipboardData == false) {
        if (typeof (callback) == "function") {
            callback(undefined);
        }
    }
    var items = pasteEvent.clipboardData.items;
    if (items == undefined) {
        if (typeof (callback) == "function") {
            callback(undefined);
        }
    }
    for (var i = 0; i < items.length; i++) {
        // Skip content if not image
        if (items[i].type.indexOf("image") == -1) continue;
        // Retrieve image on clipboard as blob
        var blob = items[i].getAsFile();
        // Create an abstract canvas and get context
        var mycanvas = document.createElement("canvas");
        var ctx = mycanvas.getContext('2d');
        // Create an image
        var img = new Image();
        // Once the image loads, render the img on the canvas
        img.onload = function(){
            // Update dimensions of the canvas with the dimensions of the image
            mycanvas.width = this.width;
            mycanvas.height = this.height;
            // Draw the image
            ctx.drawImage(img, 0, 0);
            // Execute callback with the base64 URI of the image
            if(typeof(callback) == "function"){
                callback(mycanvas.toDataURL(
                    (imageFormat || "image/png")
                ));
            }
        };
        // Crossbrowser support for URL
        var URLObj = window.URL || window.webkitURL;
        // Creates a DOMString containing a URL representing the object given in the parameter
        // namely the original Blob
        img.src = URLObj.createObjectURL(blob);
    }
}


window.addEventListener("paste", function (e) { // Quand on colle une image

    // Handle the event
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
            const doc = document.getElementById("content-txt"); // On récupère le contenu de l'article
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