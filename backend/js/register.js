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
        //tu fais ce que ta a faire et tu te demerde sale grosse pute de ta mere
        // fais très attention à ce que tu dis

        // go ajax
        const userpseudo = document.getElementsByClassName("pseudo-value")[0].value;
        const surname = document.getElementsByClassName("name-value")[0].value;
        const email = document.getElementsByClassName("email-value")[0].value;
        const passwd = document.getElementsByClassName("password-value")[0].value;

        jQuery.ajax({
            url: "/backend/php/veagle-register.php",
            data: {
                pseudo: userpseudo,
                prenom: surname,
                mail: email,
                password: passwd
            },
            type: "post",
            success: function (data) {
                const code = data;
                switch (code) {
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