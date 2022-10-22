// A commenter

function typeEffect(element, speed) {
    element.style.display = "inline-block";
    var text = element.innerHTML;
    element.innerHTML = "";

    var i = 0;
    var timer = setInterval(function () {
        if (i < text.length) {
            element.append(text.charAt(i));
            i++;
        } else {
            clearInterval(timer);
            el++

            if(element.classList.contains("before-append-input")) {
                document.getElementsByClassName("input-container")[elInput].style.display = "flex"
                elInput++
            } else {
                typeEffect(document.getElementsByClassName("type-effect")[el], 20)
            }

        }
    }, speed);
}

var el = 0
var elInput = 0

document.getElementsByClassName("step-one")[0].style.display = "block"

typeEffect(document.getElementsByClassName("type-effect")[el], 30)


document.getElementsByClassName("submit-email")[0].addEventListener('click', () => {
    if(checkEmail(document.getElementsByClassName("email-value")[0]) === true) {
        document.getElementsByClassName("step-two")[0].style.display = "block"
        typeEffect(document.getElementsByClassName("type-effect")[el], 20)

        document.getElementsByClassName("email-value")[0].style.border = "none"
        document.getElementsByClassName("error")[0].style.display = "none"
    } else {
        document.getElementsByClassName("email-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[0].style.display = "block"
    }

})

document.getElementsByClassName("submit-password")[0].addEventListener('click', () => {
    if(checkFieldSize(document.getElementsByClassName("password-value")[0], 8, 100) === true) {

        const mail = document.getElementsByClassName("email-value")[0].value // On récupère l'email
        const passwd = document.getElementsByClassName("password-value")[0].value // On récupère le mot de passe

        jQuery.ajax({ // On envoie une requête AJAX
            url: "/backend/php/veagle-connect.php", // On envoie la requête à ce fichier
            data: { // On envoie les données
                email: mail, // On envoie l'email
                password: passwd // On envoie le mot de passe
            },
            type: "post", // On envoie les données en POST
            success: function (data) { // Si la requête est un succès
                const code = data; // On récupère le code de retour
                switch (code) { // On switch le code de retour
                    case "0": // Si tout a fonctionné
                        document.getElementsByClassName("email-value")[0].style.border = "none"
                        document.getElementsByClassName("error")[0].style.display = "none"
                        document.getElementsByClassName("password-value")[0].style.border = "none"
                        document.getElementsByClassName("error")[1].style.display = "none"

                        window.location.replace("https://infinidea.veagle.fr/");
                        break;
                    case "1": // Si le mdp est incorrect
                        console.log(document.getElementsByClassName("password-value")[0])
                        document.getElementsByClassName("password-value")[0].style.border = "red 1px solid"
                        document.getElementsByClassName("error")[1].style.display = "block"
                        break;
                    case "2": // Si l'email est incorrect
                        document.getElementsByClassName("email-value")[0].style.border = "red 1px solid"
                        document.getElementsByClassName("error")[0].style.display = "block"
                        break;
                    case "3": // Si la requete a échoué
                        alert('Une erreur est survenue, veuillez rééssayer');
                        break;
                    default: // Si le code de retour n'est pas reconnu
                        console.log(code);
                        break;
                }
            },
            error: function (xhr, status) {
                alert("Une erreur est survenue durant la connexion")
            },
            complete: function (xhr, status) {
            }
        });

        document.getElementsByClassName("password-value")[0].style.border = "none"
        document.getElementsByClassName("error")[1].style.display = "none"
    } else {
        console.log(document.getElementsByClassName("password-value")[0])
        document.getElementsByClassName("password-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[1].style.display = "block"
    }

})

function checkEmail(input) {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (validRegex.test(input.value)) {
        return true;
    } else {
        return false;
    } 
}

function checkFieldSize(field, minSize, maxSize) {
    if(field.value.length >= minSize || field.length <= maxSize) {
        return true;
    } else {
        return false;
    }
}