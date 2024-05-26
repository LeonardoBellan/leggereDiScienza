let values = JSON.parse(document.querySelector('meta[name="data"]').content);
let ce = values.caseEditrici;
let pc = values.paroleChiave;
let au = values.autori;
let tp = values.tipologie;
let ge = values.generi;

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

                listItem.setAttribute("onclick", "displayNames(this, '" + entry[getPropertyNameByType(type)] + "')");
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
        case "ge":
            return ge;
    }
}

function getPropertyNameByType(type) {
    switch (type) {
        case "ce":
            return "nome";
        case "pc":
            return "parolaChiave";
        case "au":
            return "nome";
        case "tp":
            return "tipologia";
        case "ge":
            return "genere";
    }
}

function displayNames(element, value) {
    var input = element.parentElement.parentElement.querySelector("div > input");
    input.value = value;
    removeElements(findType(input));
}

//change to saveOption() + change behaviour
function saveOption(element) {
    var value = element.parentElement.querySelector("input").value;
    if (!value) return;
    let root = element.parentElement.parentElement.parentElement;
    let str = element.id.split('-')[0];
    let rowId = str + "-sel-row";

    //Creation of new row for selected elements
    if (!document.querySelector("#" + rowId)) {
        let el = document.createElement("div");
        el.setAttribute("class", str + "-selected-row");
        el.setAttribute("id", rowId);
        //el.setAttribute("style", "display:flex; flex-wrap:wrap; width:80%; padding: 0px 100px; gap: 10px");

        root.insertAdjacentElement("afterEnd", el);
    }

    if (document.querySelector("#" + rowId).childElementCount < 9) {
        //Creation of new element
        let el = document.createElement("div");
        el.setAttribute("class", str + "-selected-item");
        //el.setAttribute("style", "display:flex; flex-basis:10px; flex-shrink:1; gap:5px; border: 1px #9c6644 solid;  border-radius:13px; padding: 0px 5px");

        let eltext = document.createElement("p");
        eltext.setAttribute("style", "white-space:nowrap");
        eltext.appendChild(document.createTextNode(value));
        el.appendChild(eltext);

        let elbtn = document.createElement("button");
        elbtn.setAttribute("onclick", "removeParent(this)");

        let elicon = document.createElement("i");
        elicon.setAttribute("class", "fa-solid fa-xmark");
        //elicon.setAttribute("style", "color: var(--coffee);")
        elbtn.appendChild(elicon);
        el.appendChild(elbtn);
        document.querySelector("#" + rowId).appendChild(el);
        getVarByType(str)

        removeElements();
        root.querySelector("input").value = "";
    } else {
        alert("Raggiunto numero massimo di elementi")
    }
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

//Da miigliorare il Warning
function submitInsertForm() {
    var pcRow = document.querySelector("#pc-sel-row");
    var auRow = document.querySelector("#au-sel-row");
    var geRow = document.querySelector("#ge-sel-row");

    //Generazione  warning
    var errstr = "";
    if (document.querySelector("#titolo-in").value == "")
        errstr += "Nessun titolo inserito! ";
    if (document.querySelector("#ISBN-in").value == "")
        errstr += "\nNessun ISBN inserito! ";
    if (document.querySelector("#file-upload").files.length == 0)
        errstr += "\nNessuna copertina inserita! ";
    if (document.querySelector("#ce-input").value == "")
        errstr += "\nNessuna casa editrice inserita! ";
    if (document.querySelector("#tp-input").value == "")
        errstr += "\nNessuna tipologia inserita! ";
    if (!pcRow || pcRow.childElementCount == 0)
        errstr += "\nNessuna parola chiave inserita! ";
    if (!auRow || auRow.childElementCount == 0)
        errstr += "\nNessun autore inserito! ";
    if (!geRow || geRow.childElementCount == 0)
        errstr += "\nNessun genere inserito! ";
    if (errstr != "") {
        alert(errstr);
        return;
    }

    //raccoglimento dati multipli
    pcArr = [];
    for (let child of pcRow.children) {
        pcArr.push(child.querySelector("p").textContent);
    }

    auArr = [];
    for (let child of auRow.children) {
        auArr.push(child.querySelector("p").textContent);
    }

    geArr = [];
    for (let child of geRow.children) {
        geArr.push(child.querySelector("p").textContent);
    }

    //Assegnazione dei dati multipli come JSON a <input> nascosti da cui saranno ricavati nel  controller
    document.querySelector("#pc-form-item").setAttribute("value", JSON.stringify(pcArr));
    document.querySelector("#au-form-item").setAttribute("value", JSON.stringify(auArr));
    document.querySelector("#ge-form-item").setAttribute("value", JSON.stringify(geArr));

    //submit del form
    document.querySelector("#insert-form").submit();
}

function submitFilterForm() {
    var pcRow = document.querySelector("#pc-sel-row");
    var auRow = document.querySelector("#au-sel-row");
    var geRow = document.querySelector("#ge-sel-row");

    //raccoglimento dati multipli
    pcArr = [];

    if (pcRow) {
        for (let child of pcRow.children) {
            pcArr.push(child.querySelector("p").textContent);
        }
    }

    auArr = [];
    if (auRow) {
        for (let child of auRow.children) {
            auArr.push(child.querySelector("p").textContent);
        }
    }

    geArr = [];
    if (geRow) {
        for (let child of geRow.children) {
            geArr.push(child.querySelector("p").textContent);
        }
    }

    //Assegnazione dei dati multipli come JSON a <input> nascosti da cui saranno ricavati nel  controller
    document.querySelector("#pc-form-item").setAttribute("value", JSON.stringify(pcArr));
    document.querySelector("#au-form-item").setAttribute("value", JSON.stringify(auArr));
    document.querySelector("#ge-form-item").setAttribute("value", JSON.stringify(geArr));

    //submit del form
    document.querySelector("#filter-form").submit();
}

function setPageNum(element){
    document.querySelector("#page-param").value=element.value;
    submitFilterForm();
}