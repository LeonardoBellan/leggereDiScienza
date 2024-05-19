let values = JSON.parse(document.querySelector('meta[name="data"]').content);
let ce = values.caseEditrici;
let pc = values.paroleChiave;
let au = values.autori;
let tp = values.tipologie;

//
let flag = true;

//reference
let inputs = document.getElementsByClassName("input-text");

//Execute function on keyup
for (let inputField of inputs) {
    inputField.addEventListener("keyup", function (e) {
        type = findType(inputField);

        //loop through above array
        //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
        removeElements();
        getVarByType(type).forEach((entry) => {
            if (entry[getPropertyNameByType(type)].toLowerCase().startsWith(inputField.value.toLowerCase()) &&
                inputField.value != "") {

                //create li element
                let listItem = document.createElement("li");
                //One common class name
                listItem.classList.add("list-items");
                listItem.style.cursor = "pointer";

                listItem.setAttribute("onclick", "displayNames('" + type + "-block', '" + entry[getPropertyNameByType(type)] + "')");
                //Display matched part in bold
                let word = "<b>" + entry[getPropertyNameByType(type)].substr(0, inputField.value.length) + "</b>";
                word += entry[getPropertyNameByType(type)].substr(inputField.value.length);
                //display the value in array
                listItem.innerHTML = word;
                document.querySelector("." + type + "-list").appendChild(listItem);
            }
        });
    });
};

//Execute function on input
for (let inputField of inputs) {
    inputField.addEventListener("input", function (e) {
        type = findType(inputField);

        displayNames(type + "-block'", entry[getPropertyNameByType(type)]);

        //loop through above array
        //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
        /*removeElements();
        getVarByType(type).forEach((entry) => {
            if (entry[getPropertyNameByType(type)].toLowerCase().startsWith(inputField.value.toLowerCase()) &&
                inputField.value != "") {
 
                //create li element
                let listItem = document.createElement("li");
                //One common class name
                listItem.classList.add("list-items");
                listItem.style.cursor = "pointer";
 
                listItem.setAttribute("onclick", "displayNames('" + type + "-block', '" + entry[getPropertyNameByType(type)] + "')");
                //Display matched part in bold
                let word = "<b>" + entry[getPropertyNameByType(type)].substr(0, inputField.value.length) + "</b>";
                word += entry[getPropertyNameByType(type)].substr(inputField.value.length);
                //display the value in array
                listItem.innerHTML = word;
                document.querySelector("." + type + "-list").appendChild(listItem);
            }
        });*/
    });
};

function findType(input) {
    return (input.id).split('-')[0];
}

function getVarByType(type) {
    switch (type) {
        case "ce":
            return ce;
        case "pc":
            return pc;
        case "au":
            return au;
        case "tp":
            return tp;
    }
}

function getPropertyNameByType(type) {
    switch (type) {
        case "ce":
            return "nome";
        case "pc":
            return "parola";
        case "au":
            return "nome";
        case "tp":
            return "tipologia";
    }
}

//change to saveOption() + change behaviour
function displayNames(elementId, value) {
    let root = document.querySelector("#" + elementId).parentElement;
    let str = elementId.split('-')[0];
    let rowId = str + "-sel-row";

    //Creation of new row for selected elements
    if (!document.querySelector("#" + rowId)) {
        let el = document.createElement("div");
        el.setAttribute("class", "row");
        el.setAttribute("id", rowId);
        el.setAttribute("style", "display:flex; flex-wrap:wrap; width:980px; padding: 0px 100px; gap: 10px");

        root.insertAdjacentElement("afterEnd", el);
    }

    //Creation of new element
    let el = document.createElement("div");
    el.setAttribute("class", str + "-selected-item");
    el.setAttribute("style", "display:flex; flex-basis:10px; flex.shrink:1; gap:5px; border: 1px #9c6644 solid;  border-radius:13px");

    let eltext = document.createElement("p");
    eltext.setAttribute("style", "white-space:nowrap");
    eltext.appendChild(document.createTextNode(value));
    el.appendChild(eltext);

    let elbtn = document.createElement("button");
    elbtn.setAttribute("onclick", "removeParent(this)");
    elbtn.appendChild(document.createTextNode("x"));
    el.appendChild(elbtn);

    /*let elicon = document.createElement("i");
    elicon.setAttribute("class", "fa-solid fa-x");
    elicon.setAttribute("font-size", "8px");
    elicon.setAttribute("aria-hidden", "true");
    elbtn.appendChild(elicon);*/
    document.querySelector("#" + rowId).appendChild(el);
    getVarByType(str)

    removeElements();
    root.querySelector("input").value = "";
}

function removeParent(button) {
    var parent = button.parentElement;
    parent.remove();
}

function removeElements() {
    //clear all the items
    let items = document.querySelectorAll(".list-items");
    items.forEach((item) => {
        item.remove();
    });
}