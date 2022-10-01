/**
 * This handler retrieves the images from the clipboard as a base64 string and returns it in a callback.
 *
 * @param pasteEvent
 * @param callback
 */
/**
 * Resize a base 64 Image
 * @param {String} base64Str - The base64 string (must include MIME type)
 * @param {Number} MAX_WIDTH - The width of the image in pixels
 * @param {Number} MAX_HEIGHT - The height of the image in pixels
 */


async function reduce_image_file_size(base64Str, MAX_WIDTH = 450, MAX_HEIGHT = 450) {
    let resized_base64 = await new Promise((resolve) => {
        let img = new Image()
        img.src = base64Str
        img.onload = () => {
            let canvas = document.createElement('canvas')
            let width = img.width
            let height = img.height

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width
                    width = MAX_WIDTH
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height
                    height = MAX_HEIGHT
                }
            }
            canvas.width = width
            canvas.height = height
            let ctx = canvas.getContext('2d')
            ctx.drawImage(img, 0, 0, width, height)
            resolve(canvas.toDataURL()) // this will return base64 image results after resize
        }
    });
    return resized_base64;
}


async function image_to_base64(file) {
    let result_base64 = await new Promise((resolve) => {
        let fileReader = new FileReader();
        fileReader.onload = (e) => resolve(fileReader.result);
        fileReader.onerror = (error) => {
            console.log(error)
            alert('An Error occurred please try again, File might be corrupt');
        };
        fileReader.readAsDataURL(file);
    });
    return result_base64;
}

async function process_image(file, min_image_size = 300) {
    const res = await image_to_base64(file);
    if (res) {
        const old_size = calc_image_size(res);
        if (old_size > min_image_size) {
            const resized = await reduce_image_file_size(res);
            const new_size = calc_image_size(resized)
            console.log('new_size=> ', new_size, 'KB');
            console.log('old_size=> ', old_size, 'KB');
            return resized;
        } else {
            console.log('image already small enough')
            return res;
        }

    } else {
        console.log('return err')
        return null;
    }
}

/*- NOTE: USE THIS JUST TO GET PROCESSED RESULTS -*/
async function preview_image() {
    const file = document.getElementById('file');
    const image = await process_image(file.files[0]);
    // console.log(image)
}

/*- NOTE: USE THIS TO PREVIEW IMAGE IN HTML -*/
// async function preview_image() {
//     const file = document.getElementById('file');
//     const res = await image_to_base64(file.files[0])
//     if (res) {
//         document.getElementById("old").src = res;

//         const olds = calc_image_size(res)
//         console.log('Old ize => ', olds, 'KB')

//         const resized = await reduce_image_file_size(res);
//         const news = calc_image_size(resized)
//         console.log('new size => ', news, 'KB')
//         document.getElementById("new").src = resized;
//     } else {
//         console.log('return err')
//     }
// }


function calc_image_size(image) {
    let y = 1;
    if (image.endsWith('==')) {
        y = 2
    }
    const x_size = (image.length * (3 / 4)) - y
    return Math.round(x_size / 1024)
}


// credit to: https://gist.github.com/ORESoftware/ba5d03f3e1826dc15d5ad2bcec37f7bf





function retrieveImageFromClipboardAsBase64(pasteEvent, callback, imageFormat){
    if(pasteEvent.clipboardData == false){
        if(typeof(callback) == "function"){
            callback(undefined);
        }
    };

    var items = pasteEvent.clipboardData.items;

    if(items == undefined){
        if(typeof(callback) == "function"){
            callback(undefined);
        }
    };

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
            // data:image/png;base64,iVBORw0KGgoAAAAN......
            let data = imageDataBase64;
            sendImageToServer(data);





        }
    });
}, false);

// create a function which send the base64 image to the server
function sendImageToServer(imageDataBase64){
    jQuery.ajax({
        url:"upload-image.php",
        // send the base64 post parameter
        data:{
            base64: imageDataBase64
        },
        // important POST method !
        type:"post",
        complete:function(){
            console.log("Successfully sent image to server");
        }
    });
}