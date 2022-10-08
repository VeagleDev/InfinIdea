const LikeMachine = new XMLHttpRequest();
const LikeRefresher = new XMLHttpRequest();
aid = 0;

function performLike( id ) {
    aid = id;
    const url = "https://infinidea.veagle.fr/backend/php/add-like.php?article=" + aid;
    console.log("[INFO] Sending like request to " + url);
    LikeMachine.open("GET", url);
    LikeMachine.send();


}

LikeMachine.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // we get the response
        const response = this.responseText;
        console.log("[INFO] Like request response received");

    }
}