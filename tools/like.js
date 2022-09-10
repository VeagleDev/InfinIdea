const LikeMachine = new XMLHttpRequest();
const LikeRefresher = new XMLHttpRequest();

function performLike() {
    url = window.location.href;
    url = url.replace('http://', 'https://');
    if(url.includes('?')) {
        url += '&action=like';
        console.log("[INFO] Sending like request to " + url);
        LikeMachine.open("GET", url);
        LikeMachine.send();
    }

}

LikeMachine.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // we get the response
        const response = this.responseText;
        console.log("[INFO] Like request response: " + response);
        // we refresh the like counter
        refreshLikeCounter();
    }
}

function refreshLikeCounter() {
    const url = "https://myproject.mysteriousdev.fr/tools/infos.php?info=likes";
    console.log("[INFO] Refreshing like counter");
    LikeRefresher.open("GET", url);
    LikeRefresher.send();
}

// when the request is done, refresh the like counter
LikeRefresher.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // we get the response
        const response = this.responseText;
        console.log("[INFO] Like request response: " + response);
        // we set the paragraph with the id likeCounter to the response
        document.getElementById("likeCounter").innerHTML = response;
    }
}


