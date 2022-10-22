function typeEffect(element, speed) {
    element.style.display = "inline-block";
    var text = element.innerHTML;
    element.innerHTML = "";
    
    var i = 0;
    var timer = setInterval(function() {
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
            typeEffect(document.getElementsByClassName("type-effect")[el], 30)
        }
        
      }
    }, speed);
}

var el = 0
var elInput = 0

document.getElementsByClassName("step-one")[0].style.display = "block"

typeEffect(document.getElementsByClassName("type-effect")[el], 30)



document.getElementsByClassName("submit-pseudo")[0].addEventListener('click', () => {
    if(checkFieldSize(document.getElementsByClassName("pseudo-value")[0], 3, 20) === true) {
        document.getElementsByClassName("step-two")[0].style.display = "block"
        typeEffect(document.getElementsByClassName("type-effect")[el], 20)

        document.getElementsByClassName("pseudo-value")[0].style.border = "none"
        document.getElementsByClassName("error")[0].style.display = "none"
    } else {
        document.getElementsByClassName("pseudo-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[0].style.display = "block"
    }

})

document.getElementsByClassName("submit-name")[0].addEventListener('click', () => {
    if(checkFieldSize(document.getElementsByClassName("name-value")[0], 3, 20) === true) {
        document.getElementsByClassName("step-three")[0].style.display = "block"
        typeEffect(document.getElementsByClassName("type-effect")[el], 20)

        document.getElementsByClassName("name-value")[0].style.border = "none"
        document.getElementsByClassName("error")[1].style.display = "none"
    } else {
        document.getElementsByClassName("name-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[1].style.display = "block"
    }
})

document.getElementsByClassName("submit-email")[0].addEventListener('click', () => {
    if(checkEmail(document.getElementsByClassName("email-value")[0]) === true) {
        document.getElementsByClassName("step-four")[0].style.display = "block"
        typeEffect(document.getElementsByClassName("type-effect")[el], 20) 

        document.getElementsByClassName("email-value")[0].style.border = "none"
        document.getElementsByClassName("error")[2].style.display = "none"
    } else {
        document.getElementsByClassName("email-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[2].style.display = "block"
    }

})

document.getElementsByClassName("submit-password")[0].addEventListener('click', () => {
    if(checkFieldSize(document.getElementsByClassName("password-value")[0], 8, 100) === true) {
        document.getElementsByClassName("step-five")[0].style.display = "block"
        typeEffect(document.getElementsByClassName("type-effect")[el], 20)

        document.getElementsByClassName("password-value")[0].style.border = "none"
        document.getElementsByClassName("error")[3].style.display = "none"
    } else {
        document.getElementsByClassName("password-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[3].style.display = "block"
    }

})

document.getElementsByClassName("confirm-password")[0].addEventListener('click', () => {
    if(document.getElementsByClassName("password-value")[0].value === document.getElementsByClassName("confirm-password-value")[0].value) {

        const userpseudo = document.getElementsByClassName("pseudo-value")[0].value; // On récupère la valeur du champ pseudo
        const surname = document.getElementsByClassName("name-value")[0].value; // On récupère la valeur du champ nom
        const email = document.getElementsByClassName("email-value")[0].value; // On récupère la valeur du champ email
        const passwd = document.getElementsByClassName("password-value")[0].value; // On récupère la valeur du champ mot de passe

        jQuery.ajax({ // On utilise la fonction ajax de jQuery
            url: "/backend/php/veagle-register.php", // On passe l'url du fichier de traitement
            data: { // On envoie les données
                pseudo: userpseudo, // On envoie le pseudo
                prenom: surname, // On envoie le nom
                mail: email, // On envoie l'email
                password: passwd // On envoie le mot de passe
            },
            type: "post", // On définit le type de la requête
            success: function (data) {
                const code = data; // On récupère le code de retour
                switch (code) { // On vérifie le code de retour
                    case "0":
                        location.href = 'https://infinidea.veagle.fr/';
                        break;
                    case "1": // request error
                        alert('Une erreur est survenue lors de votre inscription dans la base de données');
                        break;
                    case "2": // same mail
                        document.getElementsByClassName("email-value")[0].style.border = "red 1px solid";
                        document.getElementsByClassName("error")[2].style.display = "block";
                        break;
                    case "3": // same pseudo
                        document.getElementsByClassName("pseudo-value")[0].style.border = "red 1px solid";
                        document.getElementsByClassName("error")[0].style.display = "block";
                        break;
                    case "4":
                        alert('Erreur inconnue');
                        break;
                    default:
                        alert('Erreur inconnue');
                        break;

                }
            },
            error: function (xhr, status) {
                alert('Une erreur est survenue lors de la requête au serveur !');
            },
            complete: function (xhr, status) {
            }
        });

        document.getElementsByClassName("confirm-password-value")[0].style.border = "none"
        document.getElementsByClassName("error")[3].style.display = "none"
    } else {
        document.getElementsByClassName("confirm-password-value")[0].style.border = "red 1px solid"
        document.getElementsByClassName("error")[4].style.display = "block"
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