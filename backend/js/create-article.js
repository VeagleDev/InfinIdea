// A commenter

document.getElementsByClassName("text-open-creation-display")[0].addEventListener("click", () => {
    document.getElementsByClassName("add-text")[0].style.display = "block";

    document.getElementsByClassName("add-link")[0].style.display = "none";
    document.getElementsByClassName("add-img")[0].style.display = "none";
})

document.getElementsByClassName("link-open-creation-display")[0].addEventListener("click", () => {
    document.getElementsByClassName("add-link")[0].style.display = "block";

    document.getElementsByClassName("add-text")[0].style.display = "none";
    document.getElementsByClassName("add-img")[0].style.display = "none";
})

document.getElementsByClassName("img-open-creation-display")[0].addEventListener("click", () => {
    document.getElementsByClassName("add-img")[0].style.display = "block";

    document.getElementsByClassName("add-link")[0].style.display = "none";
})

document.querySelectorAll(".submit").forEach((el) => {
    el.addEventListener("click", () => {
        document.getElementsByClassName("add-link")[0].style.display = "none";
        document.getElementsByClassName("add-img")[0].style.display = "none";
        document.getElementsByClassName("add-text")[0].style.display = "none";
    })
})


var articleResult = document.getElementsByClassName("article-result")[0];
var elementList = document.getElementsByClassName("element-result-list")[0];

//Récuperer les boutons des options à ajouter
var addTextBtn = document.getElementsByClassName("submit-text")[0];
var addLinkBtn = document.getElementsByClassName("submit-link")[0];
var addRowBtn = document.getElementsByClassName("submit-row")[0];
var addImgBtn = document.getElementsByClassName("submit-img-link")[0];

// //Récuperer les valeurs des inputs
// var addTextValue = document.getElementsByClassName("text-value")[0].value;

// var addNameLinkValue = document.getElementsByClassName("text-link-value")[0].value;
// var addLinkValue = document.getElementsByClassName("link-value")[0].value;

//Créer un compteur d'élement créé qui servira de nom, et d'id à la class des élements créé dans result

addTextBtn.addEventListener("click", () => {
    //Récupèrer la valeur rentrée par l'utilisateur
    var textValue = document.getElementsByClassName("text-value")[0].value;

    //Vérifier si la valeur n'est pas nul
    if(textValue != null) {
        //Créer l'élement qui va être affiché dans articleResult
        var textElement = document.createElement("p");
        //La valeur de ce nouveau texte est égal à la valeur qu'a renseigné l'utilisateur
        textElement.innerHTML = textValue;
        //Mettre l'id et la class
        textElement.classList.add("element");
        textElement.classList.add("text-element")

        //Créer l'élement de liste pour intéragir même après intégration
        var textElementInteraction = document.createElement("div");
        //Mettre sa class et son id
        textElementInteraction.classList.add("element-interaction");
        textElementInteraction.classList.add("element-interaction-input-text");

        //Mettre l'élement dans articleResult pour l'afficher quelque part lol
        articleResult.appendChild(textElement);

        //Créer tous les élements qui seront présents dans cette élement d'interaction
        var modifyText = document.createElement("input");
        var modifyBtn = document.createElement("button");

        var deleteBtn = document.createElement("button");

        //Mettre les ajustements
        deleteBtn.innerHTML = "Supprimer l'élement";

        modifyText.value = textElement.innerHTML;
        modifyBtn.innerHTML = "Modifier l'élement";

        deleteBtn.classList.add("delete-btn");
        modifyText.classList.add("modify-input");
        modifyBtn.classList.add("modify-btn")

        //Mettre les intéractions dans son contenant
        textElementInteraction.appendChild(modifyText);
        textElementInteraction.appendChild(modifyBtn);
        textElementInteraction.appendChild(deleteBtn);
        //Mettre l'élement d'interaction dans la liste d'élement d'interaction
        elementList.appendChild(textElementInteraction);


        //Dernière étape : mettre un eventListener sur les élements d'interaction et mettre leurs actions
        modifyBtn.onclick = () => {
            textElement.innerHTML = modifyText.value;
        }

        deleteBtn.onclick = () => {
            textElement.remove();
            textElementInteraction.remove();
        }
    }
})

addLinkBtn.addEventListener("click", () => {
    //Récupèrer la valeur rentrée par l'utilisateur
    var textValue = document.getElementsByClassName("text-link-value")[0].value;
    var linkValue = document.getElementsByClassName("link-value")[0].value;
    //Vérifier si la valeur n'est pas nul
    if(textValue != null && linkValue != null) {
        //Créer l'élement qui va être affiché dans articleResult
        var textElement = document.createElement("a");
        //La valeur de ce nouveau texte est égal à la valeur qu'a renseigné l'utilisateur
        textElement.innerHTML = textValue;
        textElement.href = linkValue;
        //Mettre l'id et la class
        textElement.classList.add("element");

        //Créer l'élement de liste pour intéragir même après intégration
        var textElementInteraction = document.createElement("div");
        //Mettre sa class et son id
        textElementInteraction.classList.add("element-interaction");
        textElementInteraction.classList.add("element-interaction-input-link");
        textElement.classList.add("link-element");

        //Mettre l'élement dans articleResult pour l'afficher quelque part lol
        articleResult.appendChild(textElement);

        //Créer tous les élements qui seront présents dans cette élement d'interaction
        var modifyText = document.createElement("input");
        var modifyBtn = document.createElement("button");

        var deleteBtn = document.createElement("button");

        //Mettre les ajustements
        deleteBtn.innerHTML = "Supprimer l'élement";

        modifyText.value = textElement.innerHTML;
        modifyBtn.innerHTML = "Modifier l'élement";

        deleteBtn.classList.add("delete-btn");
        modifyText.classList.add("modify-input");
        modifyBtn.classList.add("modify-btn")

        //Mettre les intéractions dans son contenant
        textElementInteraction.appendChild(modifyText);
        textElementInteraction.appendChild(modifyBtn);
        textElementInteraction.appendChild(deleteBtn);
        //Mettre l'élement d'interaction dans la liste d'élement d'interaction
        elementList.appendChild(textElementInteraction);


        //Dernière étape : mettre un eventListener sur les élements d'interaction et mettre leurs actions
        modifyBtn.onclick = () => {
            textElement.innerHTML = modifyText.value;
        }

        deleteBtn.onclick = () => {
            textElement.remove();
            textElementInteraction.remove();
        }
    }
})

addRowBtn.addEventListener("click", () => {
    var row = document.createElement("div");
    row.setAttribute("class", "row");

    var deleteBtn = document.createElement("button");

    //Mettre les ajustements
    deleteBtn.innerHTML = "Supprimer l'élement";
    //Mettre l'id et la class
    row.classList.add("element");
    row.classList.add("row-element")

    deleteBtn.classList.add("delete-btn");

    //Créer l'élement de liste pour intéragir même après intégration
    var textElementInteraction = document.createElement("div");
    //Mettre sa class et son id
    textElementInteraction.classList.add("element-interaction");
    textElementInteraction.classList.add("element-interaction-row");

    textElementInteraction.appendChild(deleteBtn);
    articleResult.appendChild(row);
    //Mettre l'élement d'interaction dans la liste d'élement d'interaction
    elementList.appendChild(textElementInteraction);

    deleteBtn.onclick = () => {
        row.remove();
        textElementInteraction.remove();
    }
})

addImgBtn.addEventListener("click", () => {
    var imgLink = document.getElementsByClassName("img-link")[0].value;

    if(imgLink != null) {
        var imgElement = document.createElement("img");
        imgElement.setAttribute("class", "img");
        imgElement.src = imgLink;

        var deleteBtn = document.createElement("button");

        //Mettre les ajustements
        deleteBtn.innerHTML = "Supprimer l'élement";
        //Mettre l'id et les class
        imgElement.classList.add("element");
        imgElement.classList.add("img-element");

        deleteBtn.classList.add("delete-btn");

        //Créer l'élement de liste pour intéragir même après intégration
        var textElementInteraction = document.createElement("div");
        //Mettre sa class et son id
        textElementInteraction.classList.add("element-interaction");
        textElementInteraction.classList.add("element-interaction-img");

        textElementInteraction.appendChild(deleteBtn);
        articleResult.appendChild(imgElement);
        //Mettre l'élement d'interaction dans la liste d'élement d'interaction
        elementList.appendChild(textElementInteraction);

        //Mettre les ajustements
        deleteBtn.innerHTML = "Supprimer l'élement";

        deleteBtn.onclick = () => {
            imgElement.remove();
            textElementInteraction.remove();
        }
    }
})