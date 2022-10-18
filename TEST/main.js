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

addTextBtn.addEventListener("click", () => {
    //Récupèrer la valeur rentrée par l'utilisateur
    var textValue = document.getElementsByClassName("text-value")[0].value;

    //Vérifier si la valeur n'est pas nul
    if(textValue != null) {
        //Créer l'élement qui va être affiché dans articleResult
        var textElement = document.createElement("p");
        //La valeur de ce nouveau texte est égal à la valeur qu'a renseigné l'utilisateur
        textElement.innerHTML = textValue;

        //Mettre l'élement dans articleResult pour l'afficher quelque part lol
        articleResult.appendChild(textElement);


        //Créer l'élement de liste pour intéragir même après intégration
        var textElementInteraction = document.createElement("div");
        //Créer tous les élements qui seront présents dans cette élement d'interaction
        var modifyText = document.createElement("input");
        var modifyBtn = document.createElement("button");

        var deleteBtn = document.createElement("button");

        //Mettre les ajustements
        deleteBtn.innerHTML = "Supprimer l'élement";

        modifyText.value = textElement.innerHTML;
        modifyBtn.innerHTML = "Modifier l'élement";

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
    console.log("d")
    //Vérifier si la valeur n'est pas nul
    if(textValue != null && linkValue != null) {
        //Créer l'élement qui va être affiché dans articleResult
        var textElement = document.createElement("a");
        //La valeur de ce nouveau texte est égal à la valeur qu'a renseigné l'utilisateur
        textElement.innerHTML = textValue;
        textElement.href = linkValue;

        //Mettre l'élement dans articleResult pour l'afficher quelque part lol
        articleResult.appendChild(textElement);


        //Créer l'élement de liste pour intéragir même après intégration
        var textElementInteraction = document.createElement("div");
        //Créer tous les élements qui seront présents dans cette élement d'interaction
        var modifyText = document.createElement("input");
        var modifyBtn = document.createElement("button");

        var deleteBtn = document.createElement("button");

        //Mettre les ajustements
        deleteBtn.innerHTML = "Supprimer l'élement";

        modifyText.value = textElement.innerHTML;
        modifyBtn.innerHTML = "Modifier l'élement";

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

    //Créer l'élement de liste pour intéragir même après intégration
    var textElementInteraction = document.createElement("div");

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

        //Créer l'élement de liste pour intéragir même après intégration
        var textElementInteraction = document.createElement("div");

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