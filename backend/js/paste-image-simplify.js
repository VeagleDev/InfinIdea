// Même script que paste-image.js mais avec des modifications pour l'éditeur simple

 function retrieveImageFromClipboardAsBase64(pasteEvent, callback, imageFormat){
    if(pasteEvent.clipboardData == false){
        if(typeof(callback) == "function"){
            callback(undefined);
        }
    }
    var items = pasteEvent.clipboardData.items;
    if(items == undefined){
        if(typeof(callback) == "function"){
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


window.addEventListener("paste", function(e){

    // Handle the event
    retrieveImageFromClipboardAsBase64(e, function(imageDataBase64){
        // If there's an image, open it in the browser as a new window :)
        if(imageDataBase64){
            sendImageToServer(imageDataBase64);
        }
    });
}, false);


// create a function which send the base64 image to the server
function sendImageToServer(imageDataBase64){
    jQuery.ajax({
        url:"/backend/php/upload-image.php",
        // send the base64 post parameter
        data:{
            image: imageDataBase64
        },
        // important POST method !
        type:"post",
        // when complete, call the responseHandler
        success: function (data) {
            const doc = document.getElementById("content-txt");
            // get text from the response
            const text = data;
            // insert the text at the cursor position
            const cursorPos = doc.selectionStart;
            const v = doc.value;
            const textBefore = v.substring(0,  cursorPos );
            const textAfter  = v.substring( cursorPos, v.length );
            doc.value = textBefore + text + textAfter;

            console.log(data);

        },
        error: function (xhr, status) {
            alert("Erreur durant l'envoi de l'image");
        },
        complete: function (xhr, status) {  }
    });
}